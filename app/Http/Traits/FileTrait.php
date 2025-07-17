<?php

namespace App\Http\Traits;

use PhpOffice\PhpWord\IOFactory;

use Illuminate\Support\Facades\Storage;

use App\Jobs\GetYandexGPTOperation;

trait FileTrait
{
    use YandexGPT;
    
    public function saveFiles($files, $folder, $type, int $id, $disk = 'public/')
    {
        $result = [];

        $time = time();

        if (isset($files))
            foreach ($files as $i => $file) {
                $filename = $type . '_' . $id . '_' . $i . '_' . $time;
                $ext = $file->getClientOriginalExtension();
                if (!($ext == 'doc' || $ext == 'docx')) $ext = $this->compress($file, $disk, $folder, $filename);
                else $file->storeAs($disk . $folder, $filename . '.' . $ext);

                array_push(
                    $result,
                    $folder . '/' . $filename . '.' . $ext
                );
            }

        return $result;
    }

    public function saveContract($file, $folder, int $id, $disk = 'public/')
    {
        $path = $this->saveFile($file, $folder, 'contract', $id, $disk);

        $document = IOFactory::load(storage_path('app/' . $disk . '/' . $path));
        $text = '';

        foreach ($document->getSections() as $s) {
            foreach ($s->getElements() as $e) {
                if (method_exists(get_class($e), 'getText')) $text .= ' ' . $e->getText();
                else $text .= "\n";
            }
        }

        GetYandexGPTOperation::dispatch($this->checkDocument($text)->id, $folder, $id)->delay(now()->addMinutes(1));

        return $path;
    }

    public function saveFile($file, $folder, $type, int $id, $disk = 'public/')
    {
        $filename = $type . '_' . $id . '_' . time();
        $ext = $file->getClientOriginalExtension();
        if (!($ext == 'doc' || $ext == 'docx')) $ext = $this->compress($file, $disk, $folder, $filename);
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
                if (!($ext == 'doc' || $ext == 'docx')) $ext = $this->compress($file, $disk, $folder, $filename);
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
