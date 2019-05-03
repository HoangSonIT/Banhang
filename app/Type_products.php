<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_products extends Model
{
    //
    protected $table = 'type_products';

    public function product(){
    	$this->hasMany('App\Products', 'id_type', 'id');
    }
}
