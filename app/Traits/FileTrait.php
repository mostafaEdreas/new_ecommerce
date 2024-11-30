<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileTrait {
    private UploadedFile  $file;

    private  function createFileName()
    {
      return date_format(now(), 'YmdHisu');
    }

    protected function ensureDirectoryExists($path)
    {
        $directory = dirname($path); // Get the directory path from the full file path
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
    }

}