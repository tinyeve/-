@extends('/backyard/backyard')
@section('content')

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-xs-12 col-sm-9">
			<p class="pull-right visible-xs">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
			</p>
			<h3>笔记类别添加</h3>
			<input type="hidden" id="domain" value="http://172.0.0.1/">
			<input type="hidden" id="uptoken_url" value="/admin.php/uptoken">
			<form class="form-horizontal col-sm-10" role="form" method="post"
						action="/web/categoryadd">
						
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">类别名称</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="inputEmail3" placeholder="text" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" class="btn btn-default" value="添加" />
							</div>
						</div>
					</form>
		</div> <!-- .col-xs-12 .col-sm-9 -->
		@include('backyard.include.sidebar')
		
	</div> <!-- row -->
</div>	<!-- container -->
@endsection