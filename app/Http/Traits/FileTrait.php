<?php

namespace App\Http\Traits;

use PhpOffice\PhpWord\IOFactory;

use Illuminate\Support\Facades\Storage;

use App\Services\YandexGPTService;
use App\Models\Ad\Hosting;

trait FileTrait
{
    public function saveFiles($files, $folder, $type, int $id, $disk = 'public')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                $ext = $file->getClientOriginalExtension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename);
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
        $path = $this->saveFile($file, $folder, 'contract', $hosting->id, $disk);

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

    public function saveFile($file, $folder, $type, int $id, $disk = 'public', $resize = false, $withTime = true)
    {
        $filename = $type . '_' . $id;
        if ($withTime) $filename .= '_' . time();
        $ext = $file->getClientOriginalExtension();
        if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename, $resize);
        else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

        return $folder . '/' . $filename . '.' . $ext;
    }

    public function saveFilesWithName($files, $folder, $type, int $id, $disk = 'public')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $name = explode('.', $file->getClientOriginalName())[0];
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                $ext = $file->getClientOriginalExtension();
                if (!($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt')) $ext = $this->compress($file, $disk, $folder, $filename);
                else $file->storeAs($disk . '/' . $folder, $filename . '.' . $ext);

                array_push($result, array(
                    'name' => $name,
                    'path' => $folder . '/' . $filename . '.' . $ext
                ));
            }

        return $result;
    }

    private function compress($file, $disk, $folder, $filename, $resize = false)
    {
        $info = getimagesize($file->getPathName());

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($file->getPathName());
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($file->getPathName());
        elseif ($info['mime'] == 'image/webp') $image = imagecreatefromwebp($file->getPathName());

        if (isset($image)) {
            if ($resize) {
                $w = $info[0];
                $h = $info[1];
                if ($w > $h) {
                    $x = ($w - $h) / 2;
                    $y = 0;
                    $minSide = $h;
                } else {
                    $x = 0;
                    $y = ($h - $w) / 2;
                    $minSide = $w;
                }

                $dest = imagecreatetruecolor($resize, $resize);
                if ($info['mime'] == 'image/png') {
                    imagealphablending($dest, false);
                    imagesavealpha($dest, true);
                }

                imagecopyresampled($dest, $image, 0, 0, $x, $y, $resize, $resize, $minSide, $minSide);
                $image = $dest;
            }

            imagepalettetotruecolor($image);

            if (!Storage::disk($disk)->exists($folder)) Storage::disk($disk)->makeDirectory($folder);

            if (!imagewebp($image, Storage::path($disk . '/' . $folder . '/' . $filename . '.webp'), 20)) return false;

            return 'webp';
        }

        return false;
    }
}
