<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
</head>
<body>
	@if(Session('thongbao'))
		<div class="alert alert-success">
			{{Session('thongbao')}}
		</div>
	@endif
    <form action="{{route('upload')}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="form-group">
            <label>link</label>
            <input class="form-control" name="link" placeholder="Nhập link ở đây" />
        </div>     
        <div class="form-group">
            <label>Hình ảnh</label>
            <input class="form-control" type="file" name="image" />
        </div>
        <button type="submit" class="btn btn-default">Thêm</button>
    </form>
</body>
</html>