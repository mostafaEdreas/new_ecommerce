<?php
namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class GlobalObserver
{
    
    public function deleting(Model $model, array $children)
    {
        foreach ($children as  $value) {
            if (method_exists($model, $value) && $model->{'value'}()->exists()) {
                throw new \Exception('Cannot delete a model that has children.');
            }
        }
       
    }

    // Other events, if needed
    public function created(Model $model)
    {
        // Logic for when any model is created
    }

    public function updated(Model $model)
    {
        // Logic for when any model is updated
    }


    protected function response(){
        
    }
}
