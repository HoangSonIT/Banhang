<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    protected $table = 'bills';
    public function detail_bill(){
    	$this->hasMany('App\Detail_bill', 'id_bill', 'id');
    }
    public function customer(){
    	$this->belongsTo('App\customer', 'id_custom', 'id');
    }
}
