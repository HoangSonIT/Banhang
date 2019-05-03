<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Slide;
use App\Products;
use App\Type_products;
use App\Cart;
use Session;
use App\Customer;
use App\Bill;
use App\Detail_bill;
use App\User;
class PagesController extends Controller
{
    //
    public function getIndex(){
    	$slide = Slide::all();
    	// return view('page.trangchu', 'slide'=>$slide);
    	$new_product = Products::where('new', 1)->paginate(4);
        $sanpham_khuyenmai = Products::where('promotion_price','<>',0)->paginate(8);
    	return view('page.trangchu', compact('slide','new_product', 'sanpham_khuyenmai'));
    }
    public function getLoaisp($id){
        $sanpham_khac = Products::where('id_type','<>',$id)->paginate(3);
        $loaisp = Products::where('id_type', $id)->paginate(3);
        $ten_hienthi = Type_products::where('id', $id)->first(); 
    	return view('page.loai_sanpham', compact('loaisp','sanpham_khac','ten_hienthi'));
    }
    public function getSanpham($id){
        $sanpham = Products::where('id', $id)->first();
        $desc = Type_products::where('id', $sanpham->id_type)->first();
        $same_prod = Products::where('id_type', $sanpham->id_type)->paginate(3);
    	return view('page.sanpham', compact('sanpham', 'desc','same_prod'));
    }
    public function getLienhe(){
    	return view('page.lienhe');
    }
    public function getGt(){
    	return view('page.gioithieu');
    }
    public function getAddtoCart(Request $request, $id){
        $product = Products::find($id);
        $oldCart = Session('cart') ? Session::get('cart'):null;    
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $request->session()->put('cart', $cart);
        return redirect()->back();
    }
    public function getDeltoCart($id){
        $oldCart = Session('cart') ? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        //dd($cart);
        if(count($cart->items) > 0){
            Session::put('cart', $cart);           
        }else{
            Session::forget('cart');
        }
        return  redirect()->back();
    }
    public function getDathang(){
        return view('page.dathang');
    }
    public function postDathang(Request $request){
        $cart = Session::get('cart');
        $this->validate($request, 
            [
                'phone_number'=>'regex:/0[9,3,7,8,5]+[0-9]{8}/',
            ], 
            [
                'phone_number.regex'=>'Bạn đã điền sai số điện thoại'
            ]);
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->gender = $request->gender;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone_number = $request->phone_number;
        $customer->note = $request->note;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $request->payment_method;
        $bill->note = $request->note;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $detail_bill = new Detail_bill;
            $detail_bill->id_bill = $bill->id;
            $detail_bill->id_product = $key;
            $detail_bill->quantity = $value['qty'];
            if($value['salePrice'] == 0){
                $detail_bill->unit_price = $value['unitPrice'];
            }else{
                $detail_bill->unit_price = $value['salePrice'];
            }
            $detail_bill->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Bạn đã đặt hàng thành công, bên hỗ trợ sẽ liên lạc để xác nhận đơn hàng của bạn lần cuối, xin cảm ơn');
    }
    public function getDangnhap(){
        return view('page.login');
    }
    public function getDangki(){
        return view('page.signup');
    }
    public function postDangki(Request $request){
        $this->validate($request,
         [
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|regex:/0[9,3,7,8,5]+[0-9]{8}/',
            'password'=>'required|min:5|max:32',
            'passwordAgain'=>'required|same:password'
         ], 
         [
            'email.required'=>"Bạn chưa điền email",
            'email.email'=>"Bạn điềm sai định dạng mail",
            'email.unique'=>"Email đã tồn tại",
            'phone.required'=>"Bạn chưa điền số điện thoại",
            'phone.regex'=>"Bạn điền sai định dạng số",
            'password.required'=>"Bạn chưa điền mật khẩu",
            'password.min'=>"Mật khẩu tối thiểu 5 kí tự",
            'password.max'=>"Mật khẩu tối đa 32 kí tự",
            'passwordAgain.required'=>"Bạn chưa nhập lại mật khẩu",
            'passwordAgain.same'=>"Mật khẩu không khớp"
         ]);
        $user = new User;
        $user->full_name = $request->name;        
        $user->email = $request->email;
        $user->password = Hash::make($request->password);        
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect("dang-nhap")->with('thongbao', 'Tạo tài khoản thành công');
    }
    public function postDangnhap(Request $request){
        $this->validate($request,
         [
            'email'=>'required|email',
            'password'=>'required|min:5|max:32',
         ], 
         [
            'email.required'=>"Bạn chưa điền email",
            'email.email'=>"Bạn điềm sai định dạng mail",
            'password.required'=>"Bạn chưa điền mật khẩu",
            'password.min'=>"Mật khẩu tối thiểu 5 kí tự",
            'password.max'=>"Mật khẩu tối đa 32 kí tự",
         ]);
        $login = array('email' => $request->email , 'password'=>$request->password );
        if(Auth::attempt($login)){
            return redirect('trangchu');
        }else{
            return redirect()->back()->with('loi', 'Bạn đã nhập sai địa chỉ mail hoặc password');
        }
    }
    public function postDangxuat(){
        Auth::logout();
        return redirect("trangchu");
    }
    public function Search(Request $request){
        $timkiem = Products::where('name','like','%'.$request->key.'%')->orWhere('unit_price',$request->key)->get();
        return view('page.search', compact('timkiem'));
    }
    public function addSlide(){
        return view("page.Taianh");
    }
    public function upload(){
        return view('input');
    }

    //Phần thêm slide ở dưới
    public function postUpload(Request $request){
        $slide = new Slide;
        $slide->link = $request->link;
        $slide->image = $request->file('image')->getClientOriginalName();
        $slide->save();
        return redirect()->back()->with('thongbao', 'Đã thêm slide thành công');
    }
}
