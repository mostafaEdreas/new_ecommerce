<?php
namespace App\Helpers;

use App\Traits\FileTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFile
{
    use FileTrait;
    public $realName;
    public $extension;
    public $fileName ;

      function __construct(UploadedFile $file) {
        $this->file = $file;
        $this -> realName = $file->getClientOriginalName();
        $this->extension = $file->getClientOriginalExtension();
        $this->fileName   =  $this->createFileName() . '.' . $this->extension;
    }

    public  function saveFile(String $path,$isFullPath =false): string
    {
      $path = $isFullPath?$path: $this->getPath($path);
      $this->ensureDirectoryExists($path);
      $this->file->move($path,$this->fileName);
      return $this->fileName;
    }
    private function  getPath(string $folder){
       return base_path("uploads/$folder/file/" );
    }

    public static function deleteFile($fileName, string $path ,$isFullPath =true)
    {
        $path = $isFullPath?$path: base_path("uploads/$path/file/" . $fileName);;
        if ($fileName) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
