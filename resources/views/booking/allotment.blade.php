@extends('layouts.app',['roomvalue'=>$room,'allotment_status'=>$allotment_status])
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
	<link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('public/js/select2.full.min.js')}}"></script>
			<div class="reservations-list allotment-wrap allotment-super-admin">
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
                                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                                           <div class="input form-group select-cont">
                                                                                <label for="status">@lang('messages.keyword_availability')<span class="required">*</span></label>
                                                                                <select class="form-control bg-arrow selecttwoall" name="searchstatus" id="searchstatus" multiple>
                                                                                    
                                                                                    @foreach($allotment_status as $akey=>$aval)
                                                                                    <option value="{{$aval->id}}">{{$aval->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                </div>
                                                                           <div class="input form-group select-cont">
                                                                                <label for="hotel_id">@lang('messages.keyword_days')</label>
                                                                                <select class="form-control bg-arrow selecttwoall" name="searchdays" id="searchdays" multiple>
                                                                                   <option value="all">@lang('messages.keyword_all')</option>
                                                                                    @foreach($daysdetail as $dkey=>$dval)
                                                                                    <option value="{{$dkey}}">{{ucwords($dval)}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                           </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                                            <div class="input form-group">
                                                                                <label>@lang('messages.keyword_from')<span class="required">*</span></label>                                                                <input id="searchfrom" required name="searchfrom" placeholder="MM/DD/YYYY" class="form-control startdate" type="text" value="{{date('m/d/Y')}}">
                                                                            </div>
                                                                            <div class="input form-group">
                                                                                <label>@lang('messages.keyword_to')<span class="required">*</span></label>
                                                                                <input id="searchto" required name="searchto" placeholder="30/10/2017" class="form-control enddate" type="text" value="{{date('m/d/Y',strtotime('+ 30days'))}}">
                                                                           
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
                                             	<div id="datatable">
                                                	 <h2>@lang('messages.keyword_fill_detail')<br><br></h2>
                                                </div>
                                             </div>
                                      </div>
                                  </div>
                              </div>
                          
                          
                        </div>     
                     </div>
                  </div>
              </div>
<script>
var counter=0;
function fun_allotment(){
	 $("#preloaderdiv").show();
	var roomcheck=$('#roomcheck')
            .map(function () { return $(this).val(); }).get();
	
	var status=$('input:checked[name="status"]').val(); 
	var from=$('#from').val();
	var to=$('#to').val();
	var refund=$('input:checked[name="refund"]').val();
	var rooms=$('#rooms').val();
	var min_stay=$('#min_stay').val();
	var released=$('#released').val();
	var day=$('#days')
            .map(function () { return $(this).val(); }).get();
	var paper=$('input:checked[name="paper"').val();
	if(from=='' || to==''){
		 $("#preloaderdiv").hide();
			alert('please enter start date and end date');
			return false;
	}
	if(status==''){
			  $("#preloaderdiv").hide();
			  alert("@lang('messages.keyword_please_select_hotel_avaialibity')");
			  return false
	}
	if(status=='2' && rooms!='0'){
			  $("#preloaderdiv").hide();
			  alert("@lang('messages.keyword_sold_out_zero')");
			  return false
	}
	data={'room':roomcheck,status:status,from:from,to:to,refund:refund,rooms:rooms,min_stay:min_stay,released:released,paper:paper,counter:counter,'days':day,'_token':'{{ csrf_token() }}'};
	$.post("{{url('allotment/manager')}}",data,function(data){
		$('#datatable').html(data);
		counter++;
		 $("#preloaderdiv").hide();
	});
	
}
function fun_typechange(e){
		value=$(e).data('value');
		var val=$('#open_'+value).val();
		var id=("type_"+value);
		if(val==1){
			$('.'+id).removeClass('red-bg').addClass('green-bg');
		}
		else if(val==3){
			$('.'+id).removeClass('green-bg').addClass('red-bg');
		}
	}
	function fun_saveallotment(e){
		val=$(e).data('value');
		var roomid=$('#roomid_'+val).val();
		var room=$('#room_'+val).val();
		var hotel=$('#hotelid_'+val).val();
		var type=$('#open_'+val).val();
		var refund=$('#refund_'+val).val();
		var min_stay=$('#min_stay_'+val).val();
		var release=$('#released_'+val).val();
		var paper=$('#paper_'+val).val();
		var date=$('#date_'+val).val();
		var data={  roomid:roomid,
					room:room,
					hotel:hotel,
					type:type,
					refund:refund,
					min_day:min_stay,
					released:release,
					paper:paper,
					date:date,
					"_token":"{{csrf_token()}}"
				};
		$.post("{{url('allotmentupdatemain')}}",data,function(data){
			console.log(data);
		});
	}
	setTimeout(function(){
		$('#allotmentbtn').click();
	},300);
	
	$('#filter').click(function(e) {
        $("#preloaderdiv").show();
		
		var status=$('#searchstatus').val();
		var from=$('#searchfrom').val();
		var to=$('#searchto').val();
		var days=$('#searchdays').val();
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
		
		data={status:status,from:from,to:to,days:days,counter:'0','_token':'{{ csrf_token() }}'};
		$.post("{{url('allotment/manager')}}",data,function(data){
		$('#datatable').html(data);
           $("#preloaderdiv").hide();
		});
    });
	$('.selecttwoclass').each(function(index, element) {
        $(this).select2({
			dropdownParent:$(this).parent('.select-container')
		});
    });
	$('.selecttwoall').each(function(index, element) {
        $(this).select2({
			dropdownParent:$(this).parent('.select-cont')
		});
    });
	
$(':checkbox').on('change',function(){
 var th = $(this), name = th.prop('name'); 
 if(th.is(':checked')){
     $(':checkbox[name="'  + name + '"]').not($(this)).prop('checked',false);   
  }
});
	
</script>
@endsection