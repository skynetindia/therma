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

<?php 
echo Form::open(array('url' => 'booking/updatestep2', 'files' => true, 'id' => 'add_booking_form'));
?>

<input type="hidden" name="booking_id" value="{{isset($bookingdetail->id) ? $bookingdetail->id : ''}}">
<input type="hidden" name="hotel_id" value="{{isset($bookingdetail->hotel_id) ? $bookingdetail->hotel_id : ''}}">
<input type="hidden" name="room_id" value="{{isset($bookingdetail->room_id) ? $bookingdetail->room_id : ''}}">
<input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
<input type="hidden" name="step" value="1">

{{ csrf_field() }}


  

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
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                 <div class="row">
                                    <div class="col-md-6">
                                       
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_client_name') <span
                                                    class="required">(*)</span></label>
                                            <input type="text" name="client_name" id="client_name" class="form-control" value="{{isset($booking->client_name)?$booking->client_name:''}}">
                                        </div>
                                    </div>
                                @if(isset($bookingdetail->id))
                               
                                    <div class="col-md-6">
                                       
                                        <div class="form-group">
                                           <label>@lang('messages.keyword_order_status')</label>
                                            <select class="form-control bg-arrow" name="order_status">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getClientStatus() as $key => $status)
                                                    <option value="{{ $key }}" {{(isset($bookingdetail->order_status)&& $bookingdetail->order_status==$key)?"selected":""}}>{{ $status }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                   @endif         
                                       
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_email') <span class="required">(*)</span></label>
                                            <input  class="form-control" id="client_email" name="client_email" placeholder=""
                                                   type="text" value="{{isset($booking->client_email)?$booking->client_email:''}}">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                       
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_arrival') <span
                                                    class="required">(*)</span></label>
                                            <input type="text" name="arrival" id="arrival" class="form-control" value="{{isset($bookingdetail->arrival)?date('M/d/Y',strtotime($bookingdetail->arrival)):''}}" disabled>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                       
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_departure') <span
                                                    class="required">(*)</span></label>
                                            <input type="text" name="departure" id="departure" class="form-control" value="{{isset($bookingdetail->departure)?date('M/d/Y',strtotime($bookingdetail->departure)):''}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                     
                                            <label for="client_country">{{trans('messages.keyword_country')}}<span class="required">(*)</span></label>
                                            <select required class="form-control selecttwoclass" id="client_country" name="client_country" placeholder="{{trans('messages.keyword_country')}}" >
                                                <option value="">{{trans('messages.keyword_country')}}</option>
                                                @foreach($country as $conkey=>$conval)
                                                <option value="{{$conval->i_id}}" {{(isset($booking->country)&& $booking->country==$conval->i_id)?'selected':''}}>{{$conval->v_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                                <label for="client_state">{{trans('messages.keyword_types_and_states')}}<span class="required">(*)</span></label>
                                                <select required class="form-control selecttwoclass" id="client_state" name="client_state" >
                                                    <option value="">{{trans('messages.keyword_types_and_states')}}</option>
                                                    @foreach($states as $stkey=>$stval)
                                                    <option value="{{$stval->i_id}}" {{(isset($booking->state)&& $booking->state==$stval->i_id)?'selected':''}}>{{$stval->v_name}}</option>
                                                    @endforeach
                                                </select>
                                         </div>
                                    </div>
                                </div>  



                                 <div class="row">
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_phone') <span class="required">(*)</span></label>
                                            <input required class="form-control" id="phone" name="phone" placeholder=""
                                                   type="text" value="{{isset($booking->phone)?$booking->phone:''}}">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                                    <label for="client_city">{{trans('messages.keyword_city')}}</label>
                                                    <select required class="form-control selecttwoclass" id="client_city" name="client_city"  >
                                                        <option value="">{{trans('messages.keyword_city')}}</option>
                                                        @foreach($city as $ctkey=>$ctval)
                                                        <option value="{{$ctval->i_id}}" {{(isset($booking->city)&& $booking->city==$ctval->i_id)?'selected':''}}>{{$ctval->v_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                    </div>
                              
                                </div>
                                
                                 
                                
                                    
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_notes') </label>
                                            <textarea name="notes" id="notes" cols="30" rows="5" style="resize: vertical;" class="form-control">{{isset($booking->note)?$booking->note:''}}</textarea>
                                        </div>
                                 
                                <div class="row">
                                     <div class="col-md-12">
                                         
                                      <?php $arrMeal = getAllMealDetail($bookingdetail->room_id,$bookingdetail->arrival,$bookingdetail->departure);
									  		$standbed=$roomdetail->standard_bed; 
											$detailvalue=isset($booking->details_of_members)?json_decode($booking->details_of_members):array();
											?>
                                        @if($bookingdetail->adults > 0)                                         
                                            @for($i=1;$i<=$bookingdetail->adults;$i++)
                                           
                                           @if($standbed==0)
                                           @php $discount=discountamount($bookingdetail->hotel_id,true,18)->discount;@endphp
                                           @else
                                           @php $discount=0;@endphp
                                           @endif
                                                <div class='row'>
                                                        <div class="col-md-3">
                                                                <div class="form-group">
                                                                   <label for=""><?php echo trans('messages.keyword_adult')." ".$i; ?><span class="required">(*)</span></label>
                                                                   <input required class="form-control" id="adult{{$i}}_name" name="adult{{$i}}_name" placeholder="" type="text" value="{{(isset($detailvalue[$i-1]->name))?$detailvalue[$i-1]->name:''}}">
                                                                </div>
                                                        </div>
                                                    <div class="col-md-3">
                                                                <div class="form-group">
                                                                   <label for=""><?php echo trans('messages.keyword_age'); ?> <span class="required">(*)</span></label>
                                                                   <input required class="form-control" id="adult{{$i}}_age" name="adult{{$i}}_age" placeholder="" type="text" value="{{(isset($detailvalue[$i-1]->age))?$detailvalue[$i-1]->age:''}}">
                                                               </div>
                                                        </div>
                                                		
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                    <label for="meal_type">{{trans('messages.keyword_meals')}}</label>
                                                                    <select required class="form-control selecttwoclass mealdropdown" id="adult{{$i}}_meal_type" name="adult{{$i}}_meal_type"  >
                                                                        
                                                                        @foreach($arrMeal as $meal)
                                                                        <option value="{{$meal->id}}" data-price="{{($meal->price-(($meal->price *$discount)/100))}}" data-priceelement="adult{{$i}}_meal_price" @if(isset($detailvalue[$i-1]->meal_type) && $meal->id==$detailvalue[$i-1]->meal_type)) selected @endif>{{$meal->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-3">
                                                                <div class="form-group">
                                                                        <label for="meal_type">{{trans('messages.keyword_meal_price')}}</label>
                                                                        <input required class="form-control meal_price" id="adult{{$i}}_meal_price" name="adult{{$i}}_meal_price" placeholder="" type="hidden" value="{{(isset($detailvalue[$i-1]->age))?$detailvalue[$i-1]->meal_price:($arrMeal[0]->price -(($arrMeal[0]->price *$discount)/100)) }}">
                                                                        <input required class="form-control" id="adult{{$i}}_meal_price_temp"  placeholder=""
                                                                          type="text" readonly value="{{(isset($detailvalue[$i-1]->age))?$detailvalue[$i-1]->meal_price:($arrMeal[0]->price -(($arrMeal[0]->price *$discount)/100)) }}">
                                                                </div>
                                                            </div>
                                                    </div>
                                                    @php $standbed--;@endphp
                                           @endfor
                                        @endif
                                     </div>
                                    <div class="col-md-12">
                                        @if($bookingdetail->children > 0)
                                        @php $childage=json_decode($bookingdetail->childage,true);@endphp
                                              @for($i=1;$i<=$bookingdetail->children;$i++)
                                          
                                               @php $j=$bookingdetail->adults+$i -1;
                                               $discount=discountamount($bookingdetail->hotel_id,false,$childage[$i-1])->discount;@endphp
                                             
                                               <div class='row'>
                                                        <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{trans('messages.keyword_children')." ".$i}}<span class="required">(*)</span></label>
                                                                   <input required class="form-control" id="child{{$i}}_name" name="child{{$i}}_name" placeholder="" type="text" value="{{(isset($detailvalue[$j]->name))?$detailvalue[$i-1]->name:''}}">
                                                                </div>
                                                        </div>
                                                    <div class="col-md-3">
                                                                <div class="form-group">
                                                                   <label for="">{{trans('messages.keyword_age')}} <span class="required">(*)</span></label>
                                                                   <input required class="form-control" id="child{{$i}}_age" name="child{{$i}}_age" placeholder="" type="text" value="{{$childage[$i-1]}}">
                                                               </div>
                                                        </div>
                                                     <div class="col-md-3">
                                                            <div class="form-group">
                                                                    <label for="meal_type">{{trans('messages.keyword_meals')}}</label>
                                                                    <select required class="form-control selecttwoclass mealdropdown" id="child{{$i}}_meal_type" name="child{{$i}}_meal_type"  >
                                                                        
                                                                        @foreach($arrMeal as $meal)
                                                                        <option value="{{$meal->id}}" data-price="{{($meal->price-(($meal->price *$discount)/100))}}" data-priceelement="child{{$i}}_meal_price" @if(isset($detailvalue[$i-1]->meal_type) && $meal->id==$detailvalue[$j]->meal_type)){{'selected'}} @endif>{{$meal->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                                <div class="form-group">
                                                                        <label for="meal_type">{{trans('messages.keyword_meal_price')}}</label>
                                                                         <input required class="form-control meal_price" id="child{{$i}}_meal_price" name="child{{$i}}_meal_price" placeholder="" type="hidden" value="{{(isset($detailvalue[$j]->age))?$detailvalue[$j]->meal_price:($arrMeal[0]->price -(($arrMeal[0]->price *$discount)/100)) }}"">
                                                                        <input required class="form-control" id="child{{$i}}_meal_price_temp"  placeholder=""  type="text" readonly value="{{(isset($detailvalue[$j]->age))?$detailvalue[$j]->meal_price:($arrMeal[0]->price -(($arrMeal[0]->price *$discount)/100)) }}">
                                                                </div>
                                                            </div>
                                                   
                                                   
                                                  </div>  
                                                @endfor
                                        @endif
                                         
                                    </div>
                              
                                </div>


                                
                                
                                


                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
	<input type="hidden" name="total_fare" id="total_fare">
    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('bookings') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
            </div>

        </div>
    </div>

</div>

</div>
<?php echo Form::close(); ?>
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
<script src="{{ url('public/js/additional-methods.min.js') }}"></script>
<script type="text/javascript">
function total_price(){
	var meal=0;
	$('.meal_price').each(function(index, element) {
        meal+= parseInt($(this).val());
    });
	$('#total_fare').val(meal);
}
$(function(){
	setTimeout(function(){
		total_price();
	},200);
});
$(".mealdropdown").change(function(){
    var current_price = $("option:selected",this).attr("data-price");
    //alert("current_price = "+current_price);
    $("#"+$("option:selected",this).attr("data-priceelement")).val(current_price);
    $("#"+$("option:selected",this).attr("data-priceelement")+"_temp").val(current_price);
	total_price();
})

$("#client_name").keyup(function(){
    $("#adult1_name").val($(this).val());
})

$("#adult1_name").keyup(function(){
    $("#client_name").val($(this).val());
})

$('#meal_type').select2();
    $('#client_country').select2();
    $('#client_country').change(function(e){
    $.post("{{url('check-country')}}",
    {'country':$(this).val(), '_token': "{{ csrf_token() }}"},
            function(data){
            $('#client_state').html(data);
            $('#client_state').select2();
            });
    });
    $('#client_state').change(function(e){
    $.post("{{url('check-state')}}",
    {'state':$(this).val(), '_token': "{{ csrf_token() }}"},
            function(data){
            $('#client_city').html(data);
            $('#client_city').select2();
            });
    });
    $(document).ready(function() {
    $("#add_booking_form").validate({
    rules: {
    user: {
    required: true
    },
            client_country: {
            required: true
            },
            client_state: {
            required: true
            },
           client_email: {
            required: true,
             email: true

            },
            client_name: {
            required: true
            },
               client_age: {
            required: true
            },
             phone: {
            required: true,
			maxlength:10,
			minlength:10
            },
            
              @if($bookingdetail->adults > 0)             
                    @for($i=1;$i<=$bookingdetail->adults;$i++)
                 
                adult{{$i}}_name: {
                    required: true
               },
                   adult{{$i}}_age: {
                    required: true
               },
                    @endfor
               @endif
             
             @if($bookingdetail->children > 0)
                   @for($i=1;$i<=$bookingdetail->children;$i++)
                       
                        child{{$i}}_name: {
                                required: true
                           },
                   child{{$i}}_age: {
                    required: true
               },
                       
               @endfor
               @endif
             
    },
            messages: {

            client_country: {
            required: "{{trans('messages.keyword_please_enter_a_country')}}"
            },
            client_state: {
            required: "{{trans('messages.keyword_please_select_state')}}"
            },
             client_name: {
            required: "{{trans('messages.keyword_please_enter_a_name')}}"
            },
            client_age: {
            required: "{{trans('messages.keyword_please_enter_an_age')}}"
            },
             client_email: {
            required: "{{trans('messages.keyword_please_enter_an_email')}}",
            email:"{{trans('messages.keyword_please_enter_a_valid_email')}}"
            },
           phone: {
            required: "{{trans('messages.keyword_please_enter_a_phone')}}"
            },
            
             @if($bookingdetail->adults > 0) 
                @for($i=1;$i<=$bookingdetail->adults;$i++)
                 
                    adult{{$i}}_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                   },

                adult{{$i}}_age: {
                        required: "{{trans('messages.keyword_please_enter_an_age')}}"
                   },
                @endfor
              @endif

                 @if($bookingdetail->children > 0)
                   @for($i=1;$i<=$bookingdetail->children;$i++)
                       
                         child{{$i}}_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                   },

                child{{$i}}_age: {
                        required: "{{trans('messages.keyword_please_enter_an_age')}}"
                   },
                       
               @endfor
               @endif
            }
    });
    });</script>


<script>

    function fetchHotelWiseRooms(e)
    {
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
    $.ajax({
    method: "POST",
            url : '{{ url('booking/get/hotel/rooms') }}',
            data: {"_token": "{{ csrf_token() }}", "standard_bed": standard_bed, "extra_bed":extra_bed, "country":country, "state":state},
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



@endsection
