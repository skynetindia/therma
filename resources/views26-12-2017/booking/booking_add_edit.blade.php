@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.12.0/d3.min.js"></script>
@if(!empty(Session::get('msg')))
<script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);</script>
@endif
@include('common.errors')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<?php $arrlanguages = getlanguages(); ?>




<div class="hotel-basic-information-new-hotel">

    <div class="basic-info-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="basic-info-lft">
                    <div class="section-border">
                        <h1 class="user-profile-heading">
                            @if(isset($action) && $action == 'edit') @lang('messages.keyword_update_booking')@else @lang('messages.keyword_add_booking') @endif
                        </h1><hr>
                      
                     
                        <div class="row">
                        <?php
								echo Form::open(array('url' => 'booking/update', 'files' => true, 'id' => 'add_booking_form'));
								?>
								
								<input type="hidden" name="booking_id" value="{{isset($booking->id) ? $booking->id : ''}}">
								<input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
								<input type="hidden" name="step" value="1">
								
								{{ csrf_field() }}
                            <div class="col-md-12 col-sm-12 col-xs-12"> 

							<div class="row">
                            	<div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="hotel_country">{{trans('messages.keyword_country')}}<span class="required">(*)</span></label>
                                    <select required class="form-control selecttwoclass" id="hotel_country" name="hotel_country" placeholder="{{trans('messages.keyword_country')}}" >
                                        <option value="">{{trans('messages.keyword_country')}}</option>
                                        @foreach($country as $conkey=>$conval)
                                        <option value="{{$conval->i_id}}" {{(isset($booking->country)&& $booking->country==$conval->i_id)?'selected':''}}>{{$conval->v_name}}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                </div>

								  <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="hotel_state">{{trans('messages.keyword_types_and_states')}}<span class="required">(*)</span></label>
                                    <select required class="form-control selecttwoclass" id="hotel_state" name="hotel_state" >
                                        <option value="">{{trans('messages.keyword_state')}}</option>
                                        @foreach($states as $stkey=>$stval)
                                        <option value="{{$stval->i_id}}" {{(isset($hoteldetails->state)&& $hoteldetails->state==$stval->i_id)?'selected':''}}>{{$stval->v_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                             </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Adult <span class="required">(*)</span></label>
                                            <select name="adults" id="adults" class="form-control">
                                                @for($i=1;$i<=getHighestAdultChild();$i++)
                                                <option value="{{ $i }}">{{ $i }}  {{ ($i > 1 ? "Adults" : "Adult") }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Child </label>
                                            <select name="children" id="children" class="form-control">
                                                <option value="">@lang('messages.keyword_no_of_child')</option>
                                                @for($i=1;$i<=getHighestAdultChild();$i++)
                                                <option value="{{ $i }}">{{ $i }}  {{ ($i > 1 ? "children" : "child") }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group child_age_container" id="child_age_container">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_arrival') <span
                                                    class="required">(*)</span></label>
                                            <input type="text" id="start_date" value="{{ old('arrival') }}" name="arrival" placeholder="YYYY-MM-DD" class="form-control startdate" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_departure') <span
                                                    class="required">(*)</span></label>
                                            <input type="text" id="end_date" value="{{ old('departure') }}" placeholder="YYYY-MM-DD" name="departure" class="form-control enddate" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                   
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for=""></label>
                                            <button type="button" class=" btn btn-info" onclick="fetchHotelWiseRooms()">Search for Hotel</button>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <?php echo Form::close(); ?>
                             <div class="form-group" >

                                    {{--Don't remove this from here--}}
                                    <div id="select_rooms"></div>

                                    <div class="form-group">
                                        <div id="fetchRoomDetails"></div>
                                    </div>
                                    {{--Don't remove this from here--}}
                                </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('bookings') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>

        </div>
    </div>

</div>

</div>

<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
<script src="{{ url('public/js/additional-methods.min.js') }}"></script>
<script type="text/javascript">

    $('#hotel_country').select2();
    $('#hotel_country').change(function(e){
    $.post("{{url('check-country')}}",
    {'country':$(this).val(), '_token': "{{ csrf_token() }}"},
            function(data){
            $('#hotel_state').html(data);
            $('#hotel_state').select2();
            });
    });
    $('#hotel_state').change(function(e){
    $.post("{{url('check-state')}}",
    {'state':$(this).val(), '_token': "{{ csrf_token() }}"},
            function(data){
            //$('#hotel_city').html(data);
            //$('#hotel_city').select2();
            });
    });
    $(document).ready(function() {
    $("#add_booking_form").validate({
		rules: {
			user: {
				required: true
			},
			hotel_country: {
				required: true
			},
			hotel_state: {
				required: true
			},
			arrival: {
				required: true
			},
			departure: {
				required: true
			},
		},
        messages: {

            hotel_country: {
            	required: "{{trans('messages.keyword_please_enter_a_country')}}"
            },
            hotel_state: {
               required: "{{trans('messages.keyword_please_select_a_state')}}"
            },
            arrival: {
              required: "{{trans('messages.keyword_please_select_arrival_date')}}",
            },
            departure: {
               required: "{{trans('messages.keyword_please_select_departure_date')}}",
            }

      }
    });
});
</script>


<script>

    function fetchHotelWiseRooms(e){
		//var hotel_id = $(e).val();
		var standard_bed = $("#adults").val();
		var extra_bed = $("#children").val();
		var country = $("#hotel_country").val();
		var state = $("#hotel_state").val();
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		var age_missing = false;
		$("#child_age_container input[type='text']").each(function(){
		if ($.trim($(this).val()) == "")
				age_missing = true;
		})
	
		if (standard_bed == "" || country == "" || state == "" || start_date == "" || end_date == "")
		{
			$("#add_booking_form").submit();
		}
		else if (age_missing)
		{
			$("#child_age_container").append('<label for="child_age" generated="true" class="error">Please add child age.</label>');
		}
		else {
		form=$('#add_booking_form')
		$.ajax({
		method: "POST",
				url : "{{ url('booking/get/hotel/rooms') }}",
				data: form.serialize(),
				success: function(data){					
				$("#select_rooms").html(data);
				}
		});
		}
	}



    $('#select_rooms').on("change", function(e) {
    var room_id = $(this).val();
    $.ajax({
    method: "POST",
            url : '{{ url('booking / get / room / details') }}',
            data: {"_token": "{{ csrf_token() }}", room_id : room_id},
            success: function(data){
            $("#fetchRoomDetails").append(data);
            }
    });
    });
    $(document).ready(function () {

    $('#departure_date, #arrival_date, #end_date, #start_date').datepicker({
    format: "yyyy-mm-dd",
            startDate: "18-07-2015", //'-30d',
            endDate: '+30d',
    }).datepicker();
    });</script>


<script>
    d3.select("#children").on("change", function(d, i){
    $("#child_age_container").html("");
    $("#child_age_container").append('<label for="">@lang("messages.keyword_age_of_children") <span class="required">(*)</span></label>');
    var datachild = [];
    for (var cnt = 1; cnt <= this.value; cnt++)
    {
    datachild.push(cnt);
    }
    createElements("child_age_container", "input", datachild, "childage");
    })
            //alert(datachild);

	function createElements(container_id, element, uniqe_name_array, return_name_prefix)
	{
	d3.select("#" + container_id).selectAll(element)
			.data(uniqe_name_array)
			.enter()
			.append("input")
			.attr("type", "text")
			.attr("name", function(d, i){
			return return_name_prefix + d;
			})
			.attr("class", "");
	}

</script>
@endsection
