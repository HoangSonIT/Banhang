@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">{{$ten_hienthi->name}}</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('trang-chu')}}">Home</a> / <span>Sản phẩm</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-3">
						<ul class="aside-menu">
							@foreach($loai_sp as $lsp)
							<li><a href="{{route('loai-san-pham', $lsp->id)}}">{{$lsp->name}}</a></li>
							@endforeach
						</ul>
					</div>
					<div class="col-sm-9">
						<div class="beta-products-list">
							<h4><b>SẢN PHẨM</b></h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy: {{count($loaisp)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
								@foreach($loaisp as $lsp)
								<div class="col-sm-4">
									<div class="single-item">
										@if($lsp->promotion_price != 0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
										@endif										
										<div class="single-item-header">
											<a href="{{route('san-pham',$lsp->id)}}"><img src="source/image/product/{{$lsp->image}}" alt="" height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$lsp->name}}</p>
											<p class="single-item-price" style="margin-bottom: 10px; font-size: 18px ">
												@if($lsp->promotion_price == 0)
												<span class="flash-sale">{{number_format($lsp->unit_price)}} đồng</span>
												@else
												<span class="flash-del">{{number_format($lsp->unit_price)}} đồng</span>
												<span class="flash-sale">{{number_format($lsp->promotion_price)}} đồng</span>
												@endif
											</p>
										</div>
										<div class="single-item-caption" style="margin-bottom: 10px;">
											<a class="add-to-cart pull-left" href="{{route('themgiohang', $lsp->id)}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('san-pham',$lsp->id)}}">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						<div class='row'>{{$loaisp->links()}}</div>							
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h4><b>SẢN PHẨM KHÁC</b></h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy: {{count($sanpham_khac)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
								@foreach($sanpham_khac as $spk)
								<div class="col-sm-4">
									<div class="single-item">
										@if($spk->promotion_price != 0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
										@endif										
										<div class="single-item-header">
											<a href="{{route('san-pham',$spk->id)}}"><img src="source/image/product/{{$spk->image}}" alt="" height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$spk->name}}</p>
											<p class="single-item-price" style="margin-bottom: 10px; font-size: 18px ">
												@if($spk->promotion_price == 0)
												<span class="flash-sale">{{number_format($spk->unit_price)}} đồng</span>
												@else
												<span class="flash-del">{{number_format($spk->unit_price)}} đồng</span>
												<span class="flash-sale">{{number_format($spk->promotion_price)}} đồng</span>
												@endif
											</p>
										</div>
										<div class="single-item-caption" style="margin-bottom: 10px;">
											<a class="add-to-cart pull-left" href="{{route('themgiohang', $spk->id)}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('san-pham',$spk->id)}}">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="row">{{$sanpham_khac->links()}}</div>
							<div class="space40">&nbsp;</div>
							
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection