<?php

namespace App\Http\Traits;

use PhpOffice\PhpWord\IOFactory;

use Illuminate\Support\Facades\Storage;

use App\Services\YandexGPTService;
use App\Models\Ad\Hosting;
use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

trait FileTrait
{
    public function saveFiles(?array $files, string $folder, string $type, int|string $id, int $time, int|array|null $resize = null, ?string $watermark = null, int $quality = 70, string $disk = 'public')
    {
        $result = [];

        if (isset($files))
            foreach ($files as $i => $file) {
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
                $ext = ($file instanceof UploadedFile) ? $file->getClientOriginalExtension() : $file->extension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality, $watermark);
                else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

                array_push(
                    $result,
                    $folder . '/' . $filename . '.' . $ext
                );
            }

        return $result;
    }

    public function saveContract(UploadedFile|File $file, string $folder, Hosting $hosting, string $disk = 'public')
    {
        $path = $this->saveFile($file, $folder, 'contract', $hosting->id, time(), null, 70, $disk);

        $document = IOFactory::load(storage_path('app/' . $disk . '/' . $path));
        $text = '';

        foreach ($document->getSections() as $s) {
            foreach ($s->getElements() as $e) {
                if (method_exists(get_class($e), 'getText')) $text .= ' ' . $e->getText();
                else $text .= "\n";
            }
        }

        (new YandexGPTService())->checkDocument($text, $folder, $hosting);

        return $path;
    }

    public function saveFile(UploadedFile|File $file, string $folder, string $type, int|string $id, ?int $time, int|array|null $resize = null, ?string $watermark = null, int $quality = 70, string $disk = 'public')
    {
        $filename = $type . '_' . $id;
        if ($time) $filename .= '_' . $time;
        if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
        $ext = ($file instanceof UploadedFile) ? $file->getClientOriginalExtension() : $file->extension();
        if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality, $watermark);
        else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

        return $folder . '/' . $filename . '.' . $ext;
    }

    public function saveFilesWithName(?array $files, string $folder, string $type, int|string $id, int|array|null $resize = null, ?string $watermark = null, int $quality = 70, string $disk = 'public')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $name = explode('.', $file->getClientOriginalName())[0];
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
                $ext = ($file instanceof UploadedFile) ? $file->getClientOriginalExtension() : $file->extension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality, $watermark);
                else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

                array_push($result, array(
                    'name' => $name,
                    'path' => $folder . '/' . $filename . '.' . $ext
                ));
            }

        return $result;
    }

    private function getAdditionalFiles(array $paths, array $sizes)
    {
        $files = [];

        foreach ($paths as $path) {
            $pathInfo = pathinfo($path);

            $filename = preg_replace('/_[0-9]+$/', '', $pathInfo['filename']);

            foreach ($sizes as $size) {
                $files[] = $pathInfo['dirname'] . '/' . $filename . '_' . $size . '.' . $pathInfo['extension'];
            }
        }

        return $files;
    }

    private function compress(UploadedFile|File $file, string $disk, string $folder, string $filename, int|array|null $resize, int $quality, ?string $watermark = null)
    {
        $info = getimagesize($file->getPathName());

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($file->getPathName());
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($file->getPathName());
        elseif ($info['mime'] == 'image/webp') $image = imagecreatefromwebp($file->getPathName());

        if (isset($image)) {
            $w = $info[0];
            $h = $info[1];

            if ($resize) {
                [$destW, $destH] = is_array($resize) ? $resize : [$resize, $resize];

                if (is_array($resize) && (is_null($destW) || is_null($destH))) {
                    if (is_null($destH)) $destH = (int)($destW * $h / $w);
                    else $destW = (int)($destH * $w / $h);

                    $minSideW = $w;
                    $minSideH = $h;
                    $x = 0;
                    $y = 0;
                } else {
                    $aspectSrc = $w / $h;
                    $aspectDest = $destW / $destH;

                    if ($aspectSrc > $aspectDest) {
                        $minSideW = $h * $aspectDest;
                        $minSideH = $h;
                        $x = ($w - $minSideW) / 2;
                        $y = 0;
                    } else {
                        $minSideW = $w;
                        $minSideH = $w / $aspectDest;
                        $x = 0;
                        $y = ($h - $minSideH) / 2;
                    }
                }

                $dest = imagecreatetruecolor($destW, $destH);
                if ($info['mime'] == 'image/png' || $info['mime'] == 'image/webp') {
                    imagealphablending($dest, false);
                    imagesavealpha($dest, true);
                }

                imagecopyresampled($dest, $image, 0, 0, (int)$x, (int)$y, $destW, $destH, (int)$minSideW, (int)$minSideH);

                $w = $destW;
                $h = $destH;
                $image = $dest;
            }

            imagepalettetotruecolor($image);

            if ($watermark) $this->addWatermark($image, $w, $h, $watermark);

            if (!Storage::disk($disk)->exists($folder)) Storage::disk($disk)->makeDirectory($folder);

            if (!imagewebp($image, Storage::path($disk . '/' . $folder . '/' . $filename . '.webp'), $quality)) return false;

            return 'webp';
        }

        return false;
    }

    private function addWatermark(GdImage $image, int $w, int $h, string $watermark)
    {
        imagealphablending($image, true);
        $textColor = imagecolorallocatealpha($image, 140, 140, 140, 90);
        $fontSize = max(8, min(20, $w / 50));
        $font = public_path('fonts/Nunito-ExtraBold.ttf');
        $angle = 0;

        $textBox = imagettfbbox($fontSize, $angle, $font, 'TRUSTMINING');
        $textHeight = abs($textBox[5] - $textBox[3]);
        $posX = $w / 30;
        $posY = $w / 30 + $textHeight;
        imagettftext($image, $fontSize, $angle, $posX, $posY, $textColor, $font, 'TRUSTMINING');

        $textBox = imagettfbbox($fontSize, $angle, $font, "$watermark");
        $textWidth = abs($textBox[2] - $textBox[0]);
        $posX = $w - $textWidth - $w / 30;
        $posY = $h - $w / 30;
        imagettftext($image, $fontSize, $angle, $posX, $posY, $textColor, $font, "$watermark");
    }
}
