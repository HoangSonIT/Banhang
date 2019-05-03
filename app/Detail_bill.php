<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_bill extends Model
{
    //
    protected $table = 'bill_detail';
    public function products(){
    	$this->belongsTo('App\Products', 'id_products', 'id');
    }
    public function bill(){
    	$this->belongsTo('App\Bill', 'id_bill', 'id');
    }
}
