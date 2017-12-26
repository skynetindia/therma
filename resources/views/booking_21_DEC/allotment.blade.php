@extends('layouts.app',['roomvalue'=>$room,'allotment_status'=>$allotment_status])
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')

<div class="allotment-wrap">
                  <div class="section-border">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                          <div class="data-table" id="datatable">
							<h2>@lang('messages.keyword_fill_detail')<br><br></h2>
                         
                            </div>
                          
                        </div>     
                     </div>
                  </div>
                  
               
            
              </div>
<script>
function fun_allotment(){
	 $("#preloaderdiv").show();
	var roomcheck=$('input:checked[name="roomcheck[]"]')
            .map(function () { return $(this).val(); }).get();
	var status=$('input:checked[name="status"]').val(); 
	var from=$('#from').val();
	var to=$('#to').val();
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
	data={'room':roomcheck,status:status,from:from,to:to,'_token':'{{ csrf_token() }}'};
	$.post("{{url('allotment/manager')}}",data,function(data){
		$('#datatable').html(data);
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
</script>
@endsection