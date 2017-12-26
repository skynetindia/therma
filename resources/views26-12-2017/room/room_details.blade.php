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


    <!--<div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="thirdst"></li>
                        <li class="navigation-item " id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->


    <div class="rooms-list">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-btn">
                    <a href="{{ url('hotel/room/edit') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="section-border">
                    	<div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">@lang('messages.keyword_room_details')</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="<?php  echo url('hotel/room/property/json/'.$hotelid) ;?>"
                                   data-classes="table table-striped table-bordered" id="table">
                                <thead>
                                <th data-field="status" data-sortable="true">{{trans('messages.keyword_room_availability')}}</th>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="category" data-sortable="true">{{trans('messages.keyword_category')}}</th>
                                <th data-field="personal_name" data-sortable="true">{{trans('messages.keyword_personal_name')}}</th>
                                <th data-field="standard_bed" data-sortable="true">{{trans('messages.keyword_standard_bed')}}</th>
                                <th data-field="extra_bed" data-sortable="true">{{trans('messages.keyword_extra_bed')}}</th>
                              
                                <th data-field="action" data-sortable="true">{{trans('messages.keyword_actions')}}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                                      
                     <div class="section-border">
                     <?php    
					 echo Form::open(array('url' => '/hotel/age/update' . "/" . $hotelid, 'files' => true, 'id' => 'room_info_form'));?>
                        <div class="payment-information-ryt">
                            <div class="pull-right">
                                    <button class="btn btn-info" type="button" id="addchild"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-danger" type="button" id="removechild"><i class="fa fa-minus"></i></button>
                            </div>
                            <p class="blue-head bold">{{ucwords(trans('messages.keyword_age_of_children'))}}  
                                
                            </p>
                           
                            <div class="ryt-chk-content childmain set-height">
                            @if($age_detail->count()>0)
                            	@foreach($age_detail as $akey=>$aval)
                                <div class="ryt-chk one{{$akey}}">
                                    <input id="one{{$akey}}" type="checkbox" class="checkbox">
                                    <label for="one{{$akey}}">{{ucwords(trans('messages.keyword_from'))}}
                                        <input  type="number" name="age_from[]" id="age_from{{$akey}}" value="{{$aval->age_from}}" required>
                                    {{ucwords(trans('messages.keyword_to'))}}
                                     <input value="{{$aval->age_to}}" type="number" name="age_to[]" id="age_to{{$akey}}" required>
                                     {{ucwords(trans('messages.keyword_discount'))}}
                                     <input  type="number" name="age_discount[]" id="age_discount{{$akey}}" value="{{$aval->discount}}" required>
                                     
                                     			<div class="block">
                                     {{ucwords(trans('messages.keyword_display_name'))}}
                                      <input  type="text" name="display_name[]" id="display_name{{$akey}}" value="{{$aval->display_name}}" required>
                                      			</div>
                                      </label>
                                       <input  type="hidden" class="checkbox" name="fixed_price[{{$akey}}]" value="0" >
                                      <input  type="checkbox" class="checkbox" name="fixed_price[{{$akey}}]" id="fixed_price{{$akey}}" value="1" {{(isset($aval->fixed_price)&& $aval->fixed_price==1)?'checked':''}} >
                                        <label for="fixed_price{{$akey}}">{{ucwords(trans('messages.keyword_fixed_price'))}}</label>
                                 </div>
                                @endforeach
                            @else
                                <div class="ryt-chk one0">
                                    <input id="one0" type="checkbox" class="checkbox">
                                    <label for="one0">{{ucwords(trans('messages.keyword_from'))}}<input  type="number" name="age_from[]" id="age_from0" required>
                                    {{ucwords(trans('messages.keyword_to'))}} <input  type="number" name="age_to[]" id="age_to0" required>
                                      {{ucwords(trans('messages.keyword_discount'))}}
                                     <input type="number" name="age_discount[]" id="age_discount0" >
                                     		
                                            <div class="block">
                                     {{ucwords(trans('messages.keyword_display_name'))}}
                                      <input type="text" name="display_name[]" id="display_name0" required>
                                     
                                      		</div>
                                            </label>
                                             <label for="fixed_price0">{{ucwords(trans('messages.keyword_fixed_price'))}}</label>
                                     
                                      <input  type="hidden" class="checkbox" name="fixed_price[0]" value="0" >
                                      <input  type="checkbox" class="checkbox" name="fixed_price[0]" id="fixed_price0" value="1" >
                                 </div>
                             @endif
                                       
                            </div>
                            <input type="hidden" id="noofchild" value="{{($age_detail->count()>0)?$age_detail->count():0}}" >    
                             <input type="hidden" name="hotel_id" value="{{$hotelid}}">  
                                    
                            <div class="payment-ryt-footer">
                                        <button class="btn btn-cancel btn-danger" type="button">Close</button>
                                        <button class="btn btn-default">Save Changes</button>
                                    </div>
                        </div>
                      @php echo Form::close();@endphp
                     </div>
                                      
                </div>
                  <div class="col-md-7 col-sm-12 col-xs-12">
                      <div class="section-border">
                         
                            <form action="{{url('/hotel/meals/savenew')}}" method="post" id="mealadd">
                                {{ csrf_field() }}
                                <div class="payment-information-ryt">
                                   
                                    <p class="blue-head bold">{{ucwords(trans('messages.keyword_meals'))}}  
                                        
                                    </p>
                                     <div class="row mealmain set-height">
                                   
                                        @foreach($taxinomies_meals as $mkey=>$types)
                                        @php $mealdetail=isset($hotelmeal->meals)?explode(',',$hotelmeal->meals):array();@endphp
                                        <div class="col-md-12 mealone{{$mkey}}">
                                                <input  type="checkbox" name="mealtype[]" id="mealtype{{$mkey}}" value="{{$types->id}}" class="checkbox" {{(in_array($types->id,$mealdetail))?"checked":''}}>
                                                 <label for="mealtype{{$mkey}}">{{ucwords($types->name)}}({{ucwords($types->description)}})
                                                 </label>
                                         	
                                     </div>
                                       
                                        @endforeach
                                  
                                     
                                               
                                    </div>
                                    
                                    <input type="hidden" id="noofmeal" value="{{($taxinomies_meals->count()>0)?$taxinomies_meals->count():0}}" >    
                             <input type="hidden" name="hotel_id" value="{{$hotelid}}">  
                                    
                            <div class="payment-ryt-footer">
                                        <button class="btn btn-cancel btn-danger" type="button">Close</button>
                                        <button class="btn btn-default">Save Changes</button>
                                    </div>
                               </div>
                            </form>
                  
                     </div>
                                      
                </div>
            </div>

    </div>

    <script>
	counter=$('#noofchild').val();
	$('#addchild').click(function(e) {
		counter++;
        $('.childmain').append("<div class='ryt-chk mealone"+counter+"'><input id='mealone"+counter+"' type='checkbox' class='checkbox' >\
		<label for='one"+counter+"'>{{ucwords(trans('messages.keyword_from'))}}<input value='' type='number' name='age_from[]' required id='age_from"+counter+"'>\
         {{ucwords(trans('messages.keyword_to'))}} <input value='' type='number' name='age_to[]' id='age_to"+counter+"' required>\
         {{ucwords(trans('messages.keyword_discount'))}}<input  type='number' name='age_discount[]' id='age_discount"+counter+"' required>\
       <div class='block'>  {{ucwords(trans('messages.keyword_display_name'))}}<input  type='text' name='display_name[]' id='display_name"+counter+"' required></label><label for='fixed_price"+counter+"'>{{ucwords(trans('messages.keyword_fixed_price'))}}</label><input  type='hidden'  name='fixed_price["+counter+"]' value='0' ><input  type='checkbox' class='checkbox' name='fixed_price["+counter+"]' id='fixed_price"+counter+"' value='1' ></div</div>");
		  $('#noofchild').val(counter)
    });
	$('#removechild').click(function(e) {
		$('.checkbox').each(function(index, element) {
            if($(this).is(':checked')){
				
				
				if(counter==0){
					alert("you cannot delete first record");
					return true;
				}
				var id=$(this).attr('id');
				$('.'+id).remove();
				counter--;
				 $('#noofchild').val(counter);
			}
        });
	});

	
        function updateRoomStatus(id) {
            var url = "{{ url('/hotel/room/changeactivestatus') }}" + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }
            if(confirmToggle(status, '', '') == true)
            {
                $.ajax({
                    type: "GET",
                    url: url + id + '/' + status,
                    error: function (url) {
                    },
                    success: function (data) {
                    }
                });
            }else{
                if($("#activestatus_" + id).is(':checked')){
                    $("#activestatus_" + id).prop('checked', false);
                }else{
                    $("#activestatus_" + id).prop('checked', true);
                }
            }
        }

        var selezione = [];
        var indici = [];
        var n = 0;

        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[1].innerHTML;
            if (!selezione[cod]) {
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            } else {
                $(el[0]).removeClass("selected");
                selezione[cod] = undefined;
                for (var i = 0; i < n; i++) {
                    if (indici[i] == cod) {
                        for (var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                n--;
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });

        function check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_delete_room')}}");
        }

        function multipleAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('/hotel/room/delete/') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/hotel/room/delete/') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });
                        //}
                        selezione = undefined;
                        if (error === false)
                            setTimeout(function () {
                                location.reload();
                            }, 100 * n);

                        n = 0;
                    }
                    break;
                case 'modify':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('/hotel/room/edit/') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
                case 'updatePhase':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('/language/translation/') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }
		 function fun_modal(room_id) {
        var url = "{{ url('hotel/get/room_placement/') }}"+ "/" + room_id;
        $.get(url , function(data) {
            $("#Placement_details").html(data);
        });        
        $("#place_op_hotel_id").val(room_id);
        $("#placement_modal").modal('show');
    }
	function remove_room(){
		if(confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete')}}")){
			$('.checkremove:checkbox:checked').each(function(index, element) {
			   var classname=$(this).attr('id');
			   $('.'+classname).remove();
			});
		}
	}
    </script>


@endsection
<div class="modal fade placement-modal1" id="placement_modal" role="dialog">
    <div class="modal-dialog modal-lg">
    {{ Form::open(array('url' => 'hotel/placement_options/update/', 'files' => true, 'id' => 'add_placement_form')) }}
    <input type="hidden" name="room_id" id="place_op_hotel_id">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Placement options</h4>
            </div>

            <div class="modal-body">
            <button class="btn btn-danger" type="button" onClick="remove_room()"><i class="fa fa-trash"></i></button>
                <div id="Placement_details" class="table-responsive">
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12">save changes</button>
            </div>
        </div>
    {{ Form::close() }}

    </div>
</div>