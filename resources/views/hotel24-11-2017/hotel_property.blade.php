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
<script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
<div class="ssetting-wrap">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">	
	   <div class="table-btn">
        	<a href="{{ url('/hotel/edit/basic') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
            <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
        </div>                                    
    </div>
 </div> 
<div class="section-border"> 
 <div class="row">
 	<div class="col-md-12 col-sm-12 col-xs-12">             		    
 		<div class="data-table">
		<div class="table-responsive">
            <h1 class="cst-datatable-heading">{{trans('messages.keyword_manage_hotel_property')}}</h1>
            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('hotel/property/json');?>" data-classes="table table-bordered" id="table">
                <thead>
                    <th data-field="status" data-sortable="true">{{trans('messages.keyword_active')}}</th>
                    <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                    <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                    <th data-field="category" data-sortable="true">{{trans('messages.keyword_category')}}</th>                    
                    <th data-field="phone" data-sortable="true">{{trans('messages.keyword_phone')}}</th>
	                <th data-field="address" data-sortable="true">{{trans('messages.keyword_address')}}</th>
                    <th data-field="general_email" data-sortable="true">{{trans('messages.keyword_email')}}</th>
                    <th data-field="commission" data-sortable="true">{{trans('messages.keyword_commissions')}}</th>
                </thead>
        	</table>
        </div>
    </div>
</div>
</div>      
</div>
 
 
</div>   
</div>                           

<script>
 function updateHotelStatus(id){
    var url = "{{ url('/hotel/changeactivestatus') }}" + '/';
    var status = '1';
    if ($("#activestatus_"+id).is(':checked')) {
        status = '0';
    }
    $.ajax({
        type: "GET",
        url: url + id +'/'+status,
        error: function (url) {                
        },
        success:function (data) { 
            /*$(".currencytogal").prop('checked',false);
            $(".currencytogal").prop('disabled',false);*/
            //$("#activestatus_"+id).prop('checked',true);
            /*$("#activestatus_"+id).prop('disabled',true);*/
        }
     });
}
var selezione = [];
var indici = [];
var n = 0;
var selectedid = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = $(el[0]).children()[1].innerHTML;    
	if (!selezione[cod]) {
		$('#table tr.selected').removeClass("selected");       
		$(el[0]).addClass("selected");
		selezione[cod] = cod;
		indici[n] = cod;
        selectedid = cod;
		//n++;

	} else {
		$(el[0]).removeClass("selected");
		/*selezione[cod] = undefined;
		for(var i = 0; i < n; i++) {
			if(indici[i] == cod) {
				for(var x = i; x < indici.length - 1; x++)
					indici[x] = indici[x + 1];
				break;	
			}
		}
		n--;*/
    $('#table tr.selected').removeClass("selected");       
    $(el[0]).addClass("selected");
    selezione[cod] = cod;
    indici[n] = cod;
    selectedid = cod;
    //n++;
	}
});
function check() {
	return confirm("{{trans('messages.keyword_are_you_sure_want__delete_hotel')}}");
}
function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
        var error = false;
		switch(act) {
			case 'delete':                                
				link.href = "{{ url('/hotel/delete') }}" + '/';
				if(check() && selectedid!= 0) {                                            
                    $.ajax({
                        type: "GET",
                        url : link.href + selectedid,
                        error: function(url) {                                    
                            if(url.status==403) {
                                link.href = "{{ url('/hotel/delete') }}" + '/' + selectedid;
                                link.dispatchEvent(clickEvent);
                                error = true;
                            }
                        },
                        success:function(url){
                            location.reload();
                        }                                
                    });                    
                    selezione = undefined;                    
					selectedid = 0;
                }					
			break;
			case 'modify':
                if(selectedid != 0) {					
					link.href = "{{ url('/hotel/edit/basic') }}" + '/' + selectedid ;
					selectedid = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;            
		}
}
</script>


@endsection	