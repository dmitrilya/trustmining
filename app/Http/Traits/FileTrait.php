<?php

namespace App\Http\Traits;

use App\Jobs\CompressImage;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function saveFiles($files, $folder, $type, int $id, $disk = 'public/')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                $ext = $file->getClientOriginalExtension();
                if ($ext != 'pdf') $ext = $this->compress($file, $disk, $folder, $filename);
                else $file->storeAs($disk . $folder, $filename . '.' . $ext);

                array_push(
                    $result,
                    $folder . '/' . $filename . '.' . $ext
                );
            }

        return $result;
    }

    public function saveFile($file, $folder, $type, int $id, $disk = 'public/')
    {
        $filename = $type . '_' . $id . '_' . time();
        $ext = $file->getClientOriginalExtension();
        if ($ext != 'pdf') $ext = $this->compress($file, $disk, $folder, $filename);
        else $file->storeAs($disk . $folder, $filename . '.' . $ext);

        return $folder . '/' . $filename . '.' . $ext;
    }

    public function saveFilesWithName($files, $folder, $type, int $id, $disk = 'public/')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $name = explode('.', $file->getClientOriginalName())[0];
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                $ext = $file->getClientOriginalExtension();
                if ($ext != 'pdf') $ext = $this->compress($file, $disk, $folder, $filename);
                else $file->storeAs($disk . $folder, $filename . '.' . $ext);

                array_push($result, array(
                    'name' => $name,
                    'path' => $folder . '/' . $filename . '.' . $ext
                ));
            }

        return $result;
    }

    private function compress($file, $disk, $folder, $filename)
    {
        $info = getimagesize($file->getPathName());

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($file->getPathName());
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($file->getPathName());

        if (isset($image)) {
            imagepalettetotruecolor($image);
            
            if (!imagewebp($image, Storage::path($disk . $folder . '/' . $filename . '.webp'), 20)) return false;

            return 'webp';
        }

        return false;
    }
}
