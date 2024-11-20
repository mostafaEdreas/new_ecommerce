<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;


trait FileTrait {
    private UploadedFile  $file;

    private  function createFileName()
    {
      return date_format(now(), 'YmdHisu');
    }

    /**
     * Cheackv if the path is ensure exsits if not create it
     *
     * @return void
     */

    protected function ensureDirectoryExists():void
    {
        if (!File::exists($this->path)) {
            File::makeDirectory($this->path, 0755, true);
        }
    }


    protected function getExtension()
    {
       return $this->file->getClientOriginalExtension();
    }

    protected function getName()
    {
       return $this->file->getClientOriginalExtension();
    }

    protected function getType()
    {
       return $this->file->getMimeType();
    }

    protected function getPath():string
    {
       return  $this->path ;
    }



}
