<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';

    public function type_products(){
    	$this->belongsTo('App\Type_products', 'id_type', 'id');
    }
    public function detail_bill(){
    	$this->hasMany('App\Detail_bill', 'id_products', 'id');
    }    
}
