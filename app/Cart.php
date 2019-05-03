<?php

namespace App;

class Cart
{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart){
		if($oldCart){
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($item, $id){
		$giohang = ['qty'=>0, 'price' => $item->unit_price_promotion, 'item' => $item, 'salePrice'=> $item->promotion_price, 'unitPrice'=>$item->unit_price];
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$giohang = $this->items[$id];
			}
		}
		$giohang['qty']++;
		if($item->promotion_price == 0){
			$item->unit_price_promotion = $item->unit_price;
		}else{
			$item->unit_price_promotion = $item->promotion_price;
		}
		$this->items[$id] = $giohang;
		$this->totalQty++;
		$giohang['price'] = $item->unit_price_promotion * $giohang['qty'];
		$this->totalPrice += $item->unit_price_promotion;
	}
	//xóa 1
	public function reduceByOne($id){
		$this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $this->items[$id]['item']['price'];
		$this->totalQty--;
		$this->totalPrice -= $this->items[$id]['item']['promotion_price'] == 0 ? $this->items[$id]['item']['unit_price'] : $this->items[$id]['item']['promotion_price'];
		if($this->items[$id]['qty'] <= 0){
			unset($this->items[$id]);
		}
	}
	//xóa nhiều
	public function removeItem($id){
		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);
	}

}
