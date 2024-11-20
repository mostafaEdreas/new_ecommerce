<?php

namespace App\Repositories\Category;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository {
    public function getAll() : array | Collection ;
    public function getById($id) : object  ;
    public function Save($category) : object  ;
    public function Update($id) : object  ;
    public function distroy($id) : bool  ;
    public function report($filter) : array | Collection ;

}
