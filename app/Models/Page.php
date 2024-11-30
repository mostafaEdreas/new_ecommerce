<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Page extends Model
{
    protected $table = 'pages';
    private $lang ;
    protected $fillable = [
        'name_ar',
        'name_en',
        'content_ar',
        'content_en',
        'status',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }
    public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }


    public function getContentAttribute(){
        return $this->{'content_'.$this->lang} ;
    }

    public function getActiveAttribute(){
        $this->status ? __('home.yes') : __( 'home.no') ;
     }

     public function scopeActive($query){
         $query->whereStatus(1);
      }

      public function scopeUnactive($query){
         $query->whereStatus(0);
      }
}
