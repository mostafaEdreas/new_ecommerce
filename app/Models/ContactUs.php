<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class ContactUs extends Model
{
	protected $table='contact_us';
    protected $fillable = [
        'name',
        'subject',
        'phone',
        'email',
        'message',
        'seen',
    ];

	public static function messageCount(){
	    return ContactUs::where('admin_seen',0)->count();
	}
}
