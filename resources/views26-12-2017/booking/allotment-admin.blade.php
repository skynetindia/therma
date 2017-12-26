@extends('layouts.app',['allotment_status' => $allotment_status])
@section('content')
<link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{asset('public/js/select2.full.min.js')}}"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
<div class=" reservations-list allotment-wrap allotment-super-admin ">
                  <div class="section-border">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                          <div class="data-table">
							<div class="table-responsive">
                                                              
                                    
                                    <div class="panel panel-default">
                                       <div class="panel-heading">
                                            <div class="allotment-super-admin-heading allotment-system-change">
                                            	<div class="form-wrap">
                                                	<div class="allotment-widthcalc">
                                                            <div class="row">
                                                            	<div class="col-md-10 col-sm-12 col-xs-12">
                                                    				<div class="row">
                                                                	<div class="col-md-4 col-sm-12 col-xs-12">
                                                                    		<div class="input form-group select-container">
                                                                                <label for="country">@lang('messages.keyword_country')</label>
                                                                                <select class="form-control bg-arrow select2" name="country" id="country">
                                                                                <option value="">@lang('messages.keyword_country')</option>
                                                                                    @foreach($country as $ckey=>$cval)
                                                                                    <option value="{{$cval->i_id}}">{{$cval->v_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="input form-group select-container">
                                                                                <label for="hotel_id">Hotel</label>
                                                                                <select class="form-control bg-arrow select2" name="hotel" id="hotel_id">
                                                                                   <option value="">@lang('messages.keyword_select_hotel')</option>
                                                                                    @foreach($hotel as $hkey=>$hval)
                                                                                    <option value="{{$hval->id}}">{{$hval->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="input form-group select-container">
                                                                                <label for="hotel_id">@lang('messages.keyword_days')</label>
                                                                                <select class="form-control bg-arrow select2" name="days" id="days">
                                                                                   <option value="all">@lang('messages.keyword_all')</option>
                                                                                    @foreach($daysdetail as $dkey=>$dval)
                                                                                    <option value="{{$dkey}}">{{ucwords($dval)}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                                                            <div class="input form-group">
                                                                                <label for="category">@lang('messages.keyword_star')</label>
                                                                                <select class="form-control bg-arrow" name="category" id="category">
                                                                                    <option value="">-</option>
                                                                                    @foreach($category as $catkey=>$catval)
                                                                                    <option value="{{$catval->id}}">{{$catval->title}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="input form-group">
                                                                                <label for="status">@lang('messages.keyword_availability')<span class="required">*</span></label>
                                                                                <select class="form-control bg-arrow" name="status" id="status">
                                                                                    @foreach($allotment_status as $akey=>$aval)
                                                                                    <option value="{{$aval->id}}">{{$aval->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                                                            	<div class="input form-group">
                                                                                    <label>@lang('messages.keyword_from')<span class="required">*</span></label>
                                                                                    <input id="from" required name="from" placeholder="MM/DD/YYYY" class="form-control startdate" type="text" value="{{date('m/d/Y')}}">
                                                                                </div>
                                                                                <div class="input form-group">
                                                                                    <label>@lang('messages.keyword_to')<span class="required">*</span></label>
                                                                                    <input id="to" required name="to" placeholder="30/10/2017" class="form-control enddate" type="text" value="{{date('m/d/Y',strtotime('+ 30days'))}}">
                                                                                 </div>
                                                                    </div>
                                                                </div>
                                                           		</div>
                                                            	<div class="col-md-2 col-sm-12 col-xs-12">
                                                                    <div class="dashbord-filter inline-block pull-right">
                                                                        <button type="button" id="filter" class="btn btn-default">filter</button>
                                                                        <a href="{{url('allotment')}}" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                                     </div>
                                                            	</div>
                                                            </div>    
                                                		 </div>   
                                               		 </div>
  												 </div>
                                            </div>
                                       
                                   <div class="panel-body">	
                              		 <div id="allotmentrecord"></div>
                                

                                </div>
                            </div>
                                    
                                    
                                  
                                </div>
                            </div>
                          
                        </div>     
                     </div>
                  </div>
                 

              </div>
	<script>
   $('.select2').each(function(index, element) {
        $(this).select2({
			dropdownParent:$(this).parent('.select-container')
		});
    });
	$('#filter').click(function(e) {
        $("#preloaderdiv").show();
		var country=$('#country').val();
		var hotel=$('#hotel_id').val();
		var category=$('#category').val();
		var status=$('#status').val();
		var from=$('#from').val();
		var to=$('#to').val();
		var days=$('#days').val();
		if(from=='' || to=='')
		{
	        $("#preloaderdiv").hide();
			alert('please enter start date and end date');
			return false;
		}
		if(status==''){
			  $("#preloaderdiv").hide();
			  alert("@lang('messages.keyword_please_select_hotel_avaialibity')");
			  return false
		}
		
		data={'country':country,'hotel':hotel,category:category,status:status,from:from,to:to,days:days,'_token':'{{ csrf_token() }}'};
		$.post("{{url('allotmentlist')}}",data,function(data){
			$('#allotmentrecord').html(data);
           $("#preloaderdiv").hide();
		});
    });
	function fun_typechange(e){
		val=$(e).val();
		var id=$(e).attr('id');
		if(val==1){
			$('.'+id).removeClass('red-bg').addClass('green-bg');
			$('.'+id).removeClass('yellow-bg').addClass('green-bg');
		}
		else if(val==3){
			$('.'+id).removeClass('green-bg').addClass('red-bg');
			$('.'+id).removeClass('yellow-bg').addClass('red-bg');
		}
	}
	function fun_allotment(e){
		val=$(e).data('value');
		var roomid=$('#roomid_'+val).val();
		var room=$('#room_'+val).val();
		var hotel=$('#hotelid_'+val).val();
		var type=$('#type_'+val).val();
		var date=$('#date_'+val).val();
		var data={roomid:roomid,room:room,hotel:hotel,type:type,date:date,"_token":"{{csrf_token()}}"};
		$.post("{{url('allotmentupdatemain')}}",data,function(data){
			console.log(data);
		});
	}
	setTimeout(function(){
		$('#filter').click();
	},300);
    </script>
@endsection