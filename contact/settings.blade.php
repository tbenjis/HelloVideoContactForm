@extends('admin.master')

@section('content')



	<div class="admin-section-title">
		<h3><i class="fa fa-plug"></i> Contact Form Plugin</h3>
	</div>

	<form method="POST" action="">

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Plugin Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">

				<p>Email (sends mail to this email and displays it on form):</p>
				<input type="text" class="form-control" name="email" value="@if(isset($email)){{ $email }}@endif" />
				<br />
				<p>Phone (leave blank if you wish):</p>
				<input type="text" class="form-control" name="phone" value="@if(isset($phone)){{ $phone }}@endif" />
				<br />
				<p>Address (leave blank if you wish):</p>
				<input type="text" class="form-control" name="address" value="@if(isset($address)){{ $address }}@endif" />
				<br />
				<p>Header Text:</p>
				<input type="text" class="form-control" name="header_text" value="@if(isset($header_text)){{ $header_text }}@else{{"Contact Us"}}@endif" />
				<br />

			</div>
		</div>

		<input type="submit" class="btn btn-success pull-right" value="Save Settings" />
		<div class="clear"></div>

	</form>


@stop
