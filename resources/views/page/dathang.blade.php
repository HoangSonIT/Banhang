@extends('master')
@section('content')
 <!-- #header -->
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				@if(count($errors) > 0)
					@foreach($errors->all() as $err)
						<div class="alert alert-danger">
							{{$err}}
						</div>
					@endforeach
				@endif
				@if(Session('thongbao'))
				<div class="alert alert-success">
					{{Session('thongbao')}}
				</div>
				@endif
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="index.html">Trang chủ</a> / <span>Đặt hàng</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			
			<form action="{{route('dathang')}}" method="post" class="beta-form-checkout">
				<input type="hidden" name="_token" value={{csrf_token()}} />
				<div class="row">
					<div class="col-sm-6">
						<h4>Đặt hàng</h4>
						<div class="space20">&nbsp;</div>

						<div class="form-block">
							<label for="name">Họ tên<b style="color: red">*</b></label>
							<input type="text" id="name" name="name" placeholder="Họ tên" required>
						</div>
						<div class="form-block">
							<label>Giới tính </label>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%"><span style="margin-right: 10%">Nam</span>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>
										
						</div>

						<div class="form-block">
							<label for="email">Email<b style="color: red">*</b></label>
							<input type="email" id="email"  name="email"required placeholder="expample@gmail.com">
						</div>

						<div class="form-block">
							<label for="adress">Địa chỉ<b style="color: red">*</b></label>
							<input type="text" id="adress"  name="address"placeholder="Street Address" required>
						</div>
						

						<div class="form-block">
							<label for="phone">Điện thoại<b style="color: red">*</b></label>
							<input type="text" id="phone" name="phone_number" placeholder="255-444-856"required>
						</div>
						
						<div class="form-block">
							<label for="notes">Ghi chú</label>
							<textarea id="notes" name="note" placeholder="Write somthing to here..."></textarea>
						</div>
					</div>
					@if(Session::has('cart'))
					<div class="col-sm-6">
						<div class="your-order">
							<div class="your-order-head"><h5>Đơn hàng của bạn</h5></div>
							<div class="your-order-body" style="padding: 0px 10px">
								<div class="your-order-item">
									<div>
									<!--  one item	 -->
					@foreach($product_cart as $cart)									
										<div class="media">
											<img width="25%" src="source/image/product/{{$cart['item']['image']}}" alt="" class="pull-left">
											<div class="media-body">												
												<p class="font-large">{{$cart['item']['name']}}</p>
												<span class="color-gray your-order-info">Số lượng: {{$cart['qty']}}</span>
												<span class="color-gray your-order-info">Đơn giá: {{number_format($cart['item']['unit_price'])}} đồng</span>
											</div>
										</div>
									<!-- end one item -->
					@endforeach					
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="your-order-item">
									<div class="pull-left"><p class="your-order-f18">Tổng tiền:</p></div>
									<div class="pull-right"><h5 class="color-black">{{$totalPrice}} đồng</h5></div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="your-order-head"><h5>Hình thức thanh toán</h5></div>
							
							<div class="your-order-body">
								<ul class="payment_methods methods">
									<li class="payment_method_bacs">
										<input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="COD" checked="checked" data-order_button_text="">
										<label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
										<div class="payment_box payment_method_bacs" style="display: block;">
											Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng
										</div>						
									</li>

									<li class="payment_method_cheque">
										<input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="ATM" data-order_button_text="">
										<label for="payment_method_cheque">Chuyển khoản </label>
										<div class="payment_box payment_method_cheque" style="display: none;">
											Chuyển tiền đến tài khoản sau:
											<br>- Số tài khoản: 123 456 789
											<br>- Chủ TK: Nguyễn A
											<br>- Ngân hàng ACB, Chi nhánh TPHCM
										</div>						
									</li>
									
								</ul>
							</div>

							<div class="text-center" id="button"><button class="beta-btn primary click" >Đặt hàng <i class="fa fa-chevron-right"></i></button></div>
						</div> <!-- .your-order -->
					</div>
					@endif
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection

@section('script')
	<script type="text/javascript">
	$(document).ready(function() {
    	$('.click').on('click', function() {
    var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    var phone = $('#phone').val();
    if(phone !==''){
        if (vnf_regex.test(phone) == false) 
        {
            alert('Số điện thoại của bạn không đúng định dạng!');
        }else{
            alert('Số điện thoại của bạn hợp lệ!');
        }
    }else{
        alert('Bạn chưa điền số điện thoại!');
    }
    });
});
	</script>
@endsection