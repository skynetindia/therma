@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')             
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">

<div class="page-under-constuction">
	<div class="under-constuction-img">
		<img src="{{asset('public/images/UnderConstruction2.png')}}" alt="under Construction">
	</div>
</div>
@endsection