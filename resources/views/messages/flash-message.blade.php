@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
        <p>{{ $message }}</p>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
        <p>{{ $message }}</p>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<p>{{ $message }}</p>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<p>{{ $message }}</p>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
	Please check the form below for errors
</div>
@endif