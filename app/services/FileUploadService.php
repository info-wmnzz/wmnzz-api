<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    protected $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default');
    }

    public function upload($file, $folder = 'uploads')
    {
        $path = $file->store($folder, $this->disk);

        return [
            'path' => $path,
            'url' => Storage::disk($this->disk)->url($path),
        ];
    }

    public function delete($path)
    {
        if ($path && Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->delete($path);

            return true;
        }

        return false;
    }

    public function update($file, $oldPath = null, $folder = 'uploads')
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $this->upload($file, $folder);
    }

    public function getUrl($path)
    {
        if (! $path) {
            return null;
        }
        if ($this->disk == 'local') {
            return env('APP_URL').Storage::disk($this->disk)->url($path);
        }

        return Storage::disk($this->disk)->url($path);
    }

    public function getUrls($paths = [])
    {
        if (! $paths) {
            return [];
        }

        return array_map(function ($path) {
            return $this->getUrl($path);
        }, $paths);
    }
}
