<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait {
    private UploadedFile  $file;

    private  function createFileName()
    {
      return date_format(now(), 'YmdHisu');
    }

    protected function ensureDirectoryExists($path)
    {
        $path = base_path($path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

}