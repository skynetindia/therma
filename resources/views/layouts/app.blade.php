<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>Therma Europe</title>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('public/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">
    <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
  <script src="{{asset('public/js/jquery.min.js')}}"></script>
  <script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>-->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">

<script src="{{asset('public/js/custom.js')}}"></script>
<script src="{{asset('public/js/jquery.scrollbar.js')}}"></script>

<link href="{{asset('public/css/attivita-e-sport/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/cure-termali1/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/cure-termali3/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/generali/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/indicazioni1/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/indicazioni2/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/personale-medico/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/servizi-di-accoglienza/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/servizi-di-pulizia1/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/servizi-di-ristorazione/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/servizi-termali1/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/servizi-generali/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/spa1/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/spa2/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/spazi-aperto/flaticon.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/spazi-interno/flaticon.css')}}" rel="stylesheet" type="text/css">



<script>
        function confirmToggle(status, msg, msg2)
        {
            if(msg == ''){
                msg = '{{ trans('messages.keyword_are_you_sure_want_to_active') }}';
            }
            if(msg2 == '')
            {
                msg2 = '{{ trans('messages.keyword_are_you_sure_want_to_deactive') }}';
            }

            if(status == '0'){
                return confirm(msg);
            }else{
                return confirm(msg2);
            }

        }
    </script>
</head>
<body class="@if (Auth::guest()){{'login-body'}}@endif">


<div class="main-wrap super-admin">
<div class="top-header">
    <div class="logo"><a href="{{url('/')}}"><img src="{{asset('public/images/logo-t.svg')}}" alt="logo"/></a> <a href="javascript:void(0)"><img src="{{asset('public/images/logo-side.svg')}}" alt="logo" class="logo-side"/></a> <a href="javascript:void(0)" class="hideshow-sidemenu"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
    <div class="float-right">
        {{ Form::open(array('url' => 'bookings/search', 'files' => true, 'id' => 'booking_search_form')) }}<div class="search-box-top"> <input type="text" name="general_search"  placeholder="{{trans('messages.keyword_search_for_booking')}}" /> {{ Form::close() }}</div>
    
    <div class="tab-menu">
    
     <ul class="nav nav-tabs" role="tablist">
         @if (!Auth::guest())
         	@php 
            	$image = "";
            @endphp
         	@if(Auth::user()->image != "" && Auth::user()->image != 0)
            	<?php  
                	$image = asset('public/images/user').'/'.Auth::user()->image;
                 ?>
            @endif
             <li><a href="#ciao"  data-toggle="tab"> <img src="{{$image}}" style="width:20px;" alt="User"/><p>{{ Auth::user()->name }}</p> </a></li>
            
             <li ><a href="#hotel"  data-toggle="tab"> <img src="{{asset('public/images/hotel.png')}}" alt="Hotel"/> <span>@lang('messages.keyword_property')</span> <p>@lang('messages.keyword_id') : {{ Auth::user()->id }}</p> </a></li>
        @endif     
      <li><a href="#lang"  data-toggle="tab"><img src="{{asset('public/images/english.jpg')}}" alt="English"/></a></li>
    </ul>
        
    
          <div class="tab-content">
            @if (!Auth::guest())
            <div  class="tab-pan" id="ciao">
                	
                    <div class="user-menu-tab">
                         <ul class="list-unstyled">
                    		<li><a href="{{url('user/profile')}}"><i class="fa fa-users" aria-hidden="true"></i> {{trans('messages.keyword_my_profile')}}</a></li>
                            <li><a href="{{url('user/profile/change_password')}}"><i class="fa fa-key" aria-hidden="true"></i> {{trans('messages.keyword_change_password')}}</a></li>
                            <li><a href="{{url('message/alert')}}"><i class="fa fa-bell" aria-hidden="true"></i> {{trans('messages.keyword_notification')}}</a></li>                            
                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off" aria-hidden="true"></i> {{trans('messages.keyword_logout')}}</a></li>
                         	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            	{{ csrf_field() }}
                            </form>
                        </ul>                        
                        <div class="aggiungi-strutture-account">	
                        	<p>{{trans('messages.keyword_add_more_hotel_to_your_account')}}</p>                            
                            <ul class="list-unstyled">
                                <li><a href="{{url('hotel/edit/basic')}}"><i class="fa fa-plus" aria-hidden="true"></i>{{trans('messages.keyword_add_a_new_hotel')}}</a></li>
                                <li><a href="{{url('hotel')}}"><i class="fa fa-plus" aria-hidden="true"></i>{{trans('messages.keyword_modify_existing_hotel')}}</a></li>
                        	</ul>                        
                        </div>
                    </div>
			</div>
            <div  class="tab-pane hotel-header" id="hotel">            			
                    <div class="hotel-img-blk">
                        <div class="hotel-img"><img src="{{asset('images/hotel-img.jpg')}}" class="img-responsive"/></div>
                        <div class="hotel-txt">
                            <p>An Pais</p>
                            <p>ID della struttura: 1965764</p>
                            <a href="#">vedi la pagina della tua struttura sul Frontend</a>
                        </div>
                    </div>                        
                    <div class="aggiungi-strutture-account">	
                        <p>Altre strutture nel tuo gruppo</p>
                    </div>                        
                    <div class="hotel-img-blk">
                        <div class="hotel-img"><img src="{{asset('images/hotel-img.jpg')}}" class="img-responsive"/></div>
                        <div class="hotel-txt">
                            <p>An Pais</p>
                            <p>2692754</p>
                        </div>
                    </div>                        
                    <div class="aggiungi-strutture-account">	
                        <p>Gestisci il tuo gruppo</p>        
                             <ul class="list-unstyled">                   
                                <li><a href="#"><i class="fa fa-reply" aria-hidden="true"></i> Vai alla home di gruppo</a></li>
                            </ul>
                    </div>                            
              </div>
             <!--<div  class="tab-pane" id="hotel">
             	<div class="search-box-top">
                	<input type="text" placeholder="Search hotel"/></div>
            			<div class="add-new-hotel">
                        	<input type="text" placeholder="Add a new hotel" />
                            <div class="search-link">
                            	<a href="{{url('basic-info.html')}}"><img src="{{asset('images/plus.png')}}"/></a>
                             </div>
                         </div>
             </div>--> 
             @endif 
             <div  class="tab-pane lang-select" id="lang">                  		
                        <div class="aggiungi-strutture-account">	
                        	<p>Your Favourite language is</p>        
                        </div><?php
			              $currentLangCode = session('locale');
            			  $allLanguages = getlanguages();              
						  $selectLangName = 'English';
		              	?><ul class="list-unstyled list-3">
                                @foreach($allLanguages as $langs)
                            		<li><a href="#" onClick="languageSelectBoxes('<?php echo $langs->code;?>');">
                                    <img src="{{url('storage/app/images/languageicon/').'/'.$langs->icon}}" data-toggle="tooltip" data-placement="bottom" title="{{$langs->original_name}}"> </a></li><?php
									if($currentLangCode == $langs->code){
										$selectLangName = $langs->original_name;
									}
									$selectLangName = ($currentLangCode == $langs->code) ? 'selected':'';?>
                                @endforeach
                            </ul>                        
                        <div class="aggiungi-strutture-account">	
                        	<p>{{$selectLangName}}</p>        
                        </div>                        
                  </div>
            <!-- <div  class="tab-pane" id="lang">
              <div class="search-box-top">
              <select id="mainlanguageselections" onchange="languageSelectBoxes(this);"><?php
              /*$currentLangCode = session('locale');
              $allLanguages = getlanguages();
              */
              ?>
              @foreach($allLanguages as $langs)
              <option <?php //echo ($currentLangCode == $langs->code) ?'selected':'';?> value="{{$langs->code}}">{{$langs->original_name}} <img src="{{url('storage/app/images/languageicon/').'/'.$langs->icon}}"></option>
              @endforeach
              </select>
                <input type="text" placeholder="Language selector"/>
              </div></div>-->
          </div>
     
    
          
    </div> 
    </div>
</div>

<div id="wrapper" class="toggled">
        <!-- Sidebar -->
        <?php
			    $allotment_status = (isset($allotment_status) && $allotment_status != '') ? $allotment_status : [];
			    $roomvalue = (isset($roomvalue) && $roomvalue != '') ? $roomvalue : [];
			?>
		@include('layouts.right_side_menu', ['allotment_status' => $allotment_status, 'roomvalue' => $roomvalue])

        
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper" class="page-content-wrapper">
        	   <div id="menu">@include('layouts.menu')</div>


             <div class="content">
              @yield('content')
            </div>
            <div class="cst-loader" style="display: none;" id="preloaderdiv">
		       <div class="cst-loader-img"></div>
			</div>

        </div>

        <!-- /#page-content-wrapper -->
    </div>  
</div>

@yield('modals')


<script>
$(document).ready(function() {
    $('#example').DataTable();
	$('#preloaderdiv').addClass('none');
});





function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);
    event.target.style.opacity = "1";
}






function languageSelectBoxes(code){
    /*var locale = object.value;*/
    var locale = code;            
    //var _token = $("input[name=_token]").val();
    var saveData = $.ajax({
      type: "GET",
      url: "{{url('/languagechange')}}",
      data: {locale:locale},
      dataType: "json",
      success: function(resultData){            
      },
      complete: function(){
       window.location.reload(true);
      }
    });  
}
$('.datepicker').datepicker();
 $(".startdate").datepicker({
        todayBtn:  1,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.enddate').datepicker('setStartDate', minDate);
    });

$(".enddate").datepicker({autoclose:true})
	.on('changeDate', function (selected) {
		var maxDate = new Date(selected.date.valueOf());
		$('.startdate').datepicker('setEndDate', maxDate);
});

/*$(".nav-tabs").mouseout(function(){
    $("#ciao").removeClass("active");
     $("#hotel").removeClass("active");
     $("#lang").removeClass("active");
}) */

/************ Menu closing solution *******************/
$(".top-header .nav-tabs").click( function(event) {
    event.stopPropagation();
});
$(".top-header .nav-tabs a").click( function(event) {
    event.stopPropagation();
    $(".top-header .nav-tabs a").each(function(){
        $(this).parent().removeClass("active");
        $($(this).attr("href")).removeClass("active");
        $(this).attr("aria-expanded","false");
    })
    
        
      $(this).parent().toggleClass("active");
     $($(this).attr("href")).toggleClass("active");
     if($(this).parent().hasClass("active"))
     {
         $(this).attr("aria-expanded","true");
     }
     else
     {
         
     }
});


$('html').click(function() {
  $(".top-header .nav-tabs a").each(function(){
        $(this).parent().removeClass("active");
        $($(this).attr("href")).removeClass("active");
        $(this).attr("aria-expanded","false");
    })
});





/*$(document).ready(function(){
    $(".top-header .tab-menu .nav.nav-tabs a").click(function(){
        if ($(this).parent().hasClass('active')){
            $('#' + this.hash.substr(1).toLowerCase()).toggleClass('active');
        }
    });
});*/
/************ Menu *******************/
</script>
@include('common.languagesjs')
</body>
</html>






