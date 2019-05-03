<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Session;
use App\Type_products;
use App\Products;
use App\Cart;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $loai_sp = Type_products::all();
        View::share('loai_sp', $loai_sp);
        view()->composer(['header','page.dathang'], function($view){
            $sanpham = Products::all();
            if(Session('cart')){
                $oldcart = Session::get('cart');
                $cart = new Cart($oldcart);
                $view->with(['sanpham' => $sanpham, 'cart'=>Session::get('cart'), 'product_cart'=>$cart->items, 'totalPrice'=>$cart->totalPrice, 'totalQty'=>$cart->totalQty]);
            }
            
        });
    }
}
