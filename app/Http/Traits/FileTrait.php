<?php

namespace App\Http\Traits;

use PhpOffice\PhpWord\IOFactory;

use Illuminate\Support\Facades\Storage;

use App\Services\YandexGPTService;
use App\Models\Ad\Hosting;

trait FileTrait
{
    public function saveFiles($files, $folder, $type, int $id, $time, $resize = null, $quality = 70, $disk = 'public')
    {
        $result = [];

        if (isset($files))
            foreach ($files as $i => $file) {
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
                $ext = ($file instanceof \Illuminate\Http\UploadedFile)
                    ? $file->getClientOriginalExtension()
                    : $file->extension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality);
                else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

                array_push(
                    $result,
                    $folder . '/' . $filename . '.' . $ext
                );
            }

        return $result;
    }

    public function saveContract($file, $folder, Hosting $hosting, $disk = 'public')
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

    public function saveFile($file, $folder, $type, int $id, $time, $resize = null, $quality = 70, $disk = 'public')
    {
        $filename = $type . '_' . $id;
        if ($time) $filename .= '_' . $time;
        if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
        $ext = ($file instanceof \Illuminate\Http\UploadedFile)
            ? $file->getClientOriginalExtension()
            : $file->extension();
        if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality);
        else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

        return $folder . '/' . $filename . '.' . $ext;
    }

    public function saveFilesWithName($files, $folder, $type, int $id, $resize = null, $quality = 70, $disk = 'public')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $name = explode('.', $file->getClientOriginalName())[0];
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                if ($resize) $filename .= '_' . (is_array($resize) ? ($resize[0] ?? $resize[1]) : $resize);
                $ext = ($file instanceof \Illuminate\Http\UploadedFile)
                    ? $file->getClientOriginalExtension()
                    : $file->extension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize, $quality);
                else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

                array_push($result, array(
                    'name' => $name,
                    'path' => $folder . '/' . $filename . '.' . $ext
                ));
            }

        return $result;
    }

    private function compress($file, $disk, $folder, $filename, $resize, $quality)
    {
        $info = getimagesize($file->getPathName());

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($file->getPathName());
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($file->getPathName());
        elseif ($info['mime'] == 'image/webp') $image = imagecreatefromwebp($file->getPathName());

        if (isset($image)) {
            if ($resize) {
                [$destW, $destH] = is_array($resize) ? $resize : [$resize, $resize];

                $srcW = $info[0];
                $srcH = $info[1];

                if (is_array($resize) && (is_null($destW) || is_null($destH))) {
                    if (is_null($destH)) $destH = (int)($destW * $srcH / $srcW);
                    else $destW = (int)($destH * $srcW / $srcH);

                    $minSideW = $srcW;
                    $minSideH = $srcH;
                    $x = 0;
                    $y = 0;
                } else {
                    $aspectSrc = $srcW / $srcH;
                    $aspectDest = $destW / $destH;

                    if ($aspectSrc > $aspectDest) {
                        $minSideW = $srcH * $aspectDest;
                        $minSideH = $srcH;
                        $x = ($srcW - $minSideW) / 2;
                        $y = 0;
                    } else {
                        $minSideW = $srcW;
                        $minSideH = $srcW / $aspectDest;
                        $x = 0;
                        $y = ($srcH - $minSideH) / 2;
                    }
                }

                $dest = imagecreatetruecolor($destW, $destH);
                if ($info['mime'] == 'image/png' || $info['mime'] == 'image/webp') {
                    imagealphablending($dest, false);
                    imagesavealpha($dest, true);
                }

                imagecopyresampled($dest, $image, 0, 0, (int)$x, (int)$y, $destW, $destH, (int)$minSideW, (int)$minSideH);

                $image = $dest;
            }

            imagepalettetotruecolor($image);

            if (!Storage::disk($disk)->exists($folder)) Storage::disk($disk)->makeDirectory($folder);

            if (!imagewebp($image, Storage::path($disk . '/' . $folder . '/' . $filename . '.webp'), $quality)) return false;

            return 'webp';
        }

        return false;
    }
}
