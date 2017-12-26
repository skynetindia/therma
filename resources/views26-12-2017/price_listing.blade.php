@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();
        if(isset($room_details->id)){
            $currency = getActiveCurrency($room_details->hotelid);
        }
      //  pre($room_details);

    ?>

    {{--@if($action == 'edit')--}}
    {{--{{ pre($room_details) }}--}}
    {{--@endif--}}

    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="thirdst"></li>
                        <li class="navigation-item" id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

`    <?php if(isset($room_details->id)) {
        echo Form::open(array('url' => '/hotel/room/price-list/update/'.$room_details->id,  'files' => true, 'id' => 'room_price_list_form'));
        }
    ?>

    {{ csrf_field() }}






    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">

            <div class="edit-room-lft-side">
                <div class="section-border">




                    <div class="height10"></div>
                    <p class="bold blue-head">@lang('messages.keyword_extra_bed')</p>
                    <div id="append_extra_bed">

                    </div>
                    
                    <div id="append_extra_bed">
                      @php $a=1;@endphp
                    @if(isset($extrabed))
                  
                    @foreach($extrabed as $extra)
					

                <div id="extra_bed_{{$a}}">   <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Select Extra Bed</label>
                            <select class="form-control valid" id="bed_type_1" name="extra_bed[]">
                               <option value="">--Select--</option> 
                               <option value="1" {{(isset($extra->bed_type)&& $extra->bed_type==1)?'selected':''}}>Full Bed</option> 
                               <option value="0" {{(isset($extra->bed_type)&& $extra->bed_type==0)?'selected':''}}>Half Bed</option> 
                            </select>
                        </div>
                    </div>
                       <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Base Price</label>
                                <input value="{{(isset($extra->base_price))?$extra->base_price:'0'}}" name="extra_bed_base_price[]" onchange="extrabedcalculation(1)" id="extra_bed_base_price_1" class="form-control valid" type="text">
                            </div>
                        </div>
                       <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input value="{{(isset($extra->quantity))?$extra->quantity:'0'}}" name="extra_bed_quantity[]" id="extra_bed_quantity_1" onchange="extrabedcalculation(1)" class="form-control valid" type="text">
                            </div>
                        </div>
                       <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Total fare</label>
                                <input value="{{(isset($extra->total_fare))?$extra->total_fare:'0'}}" name="extra_bed_total_fare[]" id="extra_bed_total_fare_1" class="form-control" readonly="readonly" type="text">
                                <span style="cursor:pointer;color: #337ab7;" class="pull-right" id="remove_extra_bed">× remove</span>
                            </div>
                        </div>
                    </div>
                     @php $a++;@endphp
					@endforeach
                    @endif
                   </div>
                   <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="#" id="add_extra_bed"><i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('messages.keyword_add_another_bed')</a>
                        </div>
                    </div>
				<input type="hidden" id="extrabedcounter" value="{{$a}}" />


                    <p class="bold blue-head">@lang('messages.keyword_base_price_per_night')</p>
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>@lang('messages.keyword_price_for_2_people')</label>
                                <div class="input-group">

                                    <div class="input-group-addon">{{ isset($currency) ? $currency['symbol'] : '' }} @lang('messages.keyword_at_night')</div>
                                    <input class="form-control" name="at_night" id="at_night" onkeyup="calculatePriceWithDiscount()" placeholder="" value="{{ isset($room_details->price_per_night) ? $room_details->price_per_night : '' }}" type="text"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="imporatant-notice">
                        <p class="gry-clr">@lang('messages.keyword_room_note_one')</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p class="bold">@lang('messages.keyword_room_note_two')</p>
                            <div class="form-group">
                                <div class="radio-wrap">
                                    <div class="radio-inline round-checkbox">
                                        <input id="rad1" name="fare_lower" type="radio" value="1" {{ (isset($room_details->is_fare_lower) &&  $room_details->is_fare_lower == '1') ? 'checked' : '' }}>
                                        <label for="rad1">@lang('messages.keyword_yes')</label>
                                        <div class="check">
                                            <div class="inside"></div>
                                        </div>
                                    </div>
                                    <div class="radio-inline round-checkbox">
                                        <input id="rad2" name="fare_lower" type="radio" value="0" {{ (isset($room_details->is_fare_lower) &&  $room_details->is_fare_lower == '0') ? 'checked' : '' }}>
                                        <label for="rad2">@lang('messages.keyword_no')</label>
                                        <div class="check">
                                            <div class="inside"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="set-width-edit-room-detail">
                                <div class="form-group">
                                    <input class="form-control" name="discount" id="discount" onkeyup="calculatePriceWithDiscount()" placeholder="discount" value="{{ isset($room_details->discount) ? $room_details->discount : '' }}" type="text" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="discount_type" id="select_discount_type" onchange="calculatePriceWithDiscount()">
                                        <option value="">-- Select --</option>
                                        <option value="per" {{ (isset($room_details->discount_type)&& $room_details->discount_type=='per') ? 'selected' : '' }}>%</option>
                                        <option value="cur" {{ (isset($room_details->discount_type)&& $room_details->discount_type=='cur') ? 'selected' : '' }}>{{ isset($currency) ? $currency['symbol'] : '' }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="set-eedit-room-prezzo">
                                <div><p>@lang('messages.keyword_no_guests')</p><br/><i class="fa fa-user" aria-hidden="true"></i></div>
                                <div><p>@lang('messages.keyword_discount')</p><br/><span id="display_discount">--</span> <span id="display_discount_type"></span></div>
                                <div><p>@lang('messages.keyword_price')</p><br/><input type="text" name="total_price" id="totalPrice" value="{{ isset($room_details->fare_amount) ? $room_details->fare_amount : '' }}" class="form-control input-xs" readonly> {{ isset($currency) ? $currency['symbol'] : '' }}</div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="bg-grey inline-block">
                            <i class="fa fa-hand-o-right" aria-hidden="true"></i> @lang('messages.keyword_room_note_three') 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="btn-shape">
        <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left">
            <a href="{{ url('hotel/room/edit'.'/'.$room_details->id) }}" class="btn btn-default">Back</a>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
            <button type="submit" class="btn btn-default">{{trans('messages.keyword_proceeds')}}</button>
        </div>
    </div>
    </div>
    </div>

    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#room_price_list_form").validate({
                rules: {
                    select_room: {
                        required: true
                    },
                    name_of_room: {
                        required: true
                    },
                    personal_name: {
                        required: true
                    },
                    how_many_room: {
                        required: true
                    },
                    unit: {
                        required: true
                    },
                    vision: {
                        required: true
                    },
                    symphony: {
                        required: true
                    },
                    secret: {
                        required: true
                    },
                    thought: {
                        required: true
                    },
                    at_night: {
                        required: true,
                        number: true
                    },
                    discount: {
                        required: true,
                        number: true,
                        max: 100
                    },
                },
                messages: {
                    select_room: {
                        required: "please select room"
                    },
                    name_of_room: {
                        required: "please select room"
                    },
                    personal_name: {
                        required: "please enter personal name"
                    },
                    how_many_room: {
                        required: "please choose how many room"
                    },
                    unit: {
                        required: "please select unit"
                    },
                    vision: {
                        required: "please enter vision"
                    },
                    symphony: {
                        required: "please enter symphony"
                    },
                    secret: {
                        required: "please enter secret"
                    },
                    thought: {
                        required: "please enter thought"
                    },
                    at_night: {
                        required: "this field is required",
                        number: "number",
                    },
                    discount: {
                        required: "this field is required",
                        number: "number",
                    },
                }

            });
            $.validator.setDefaults({
                ignore: []
            });
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('.inputmask-formate').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });
    </script>



    <script>
            $(document).ready(function(){
                var maxRow = 5; var x = $('#extrabedcounter').val();
                /* Adding and remove kind of room dynamic field */
                $('#add_extra_bed').on("click", function(){
                    if(x <= maxRow)
                    {
                        var add_room_html = '<div id="extra_bed_'+ x +'">' +
                            '   <div class="col-md-3 col-sm-12 col-xs-12">\n' +
                            '        <div class="form-group">\n' +
                            '            <label for="">@lang("messages.keyword_select_extra_bed")</label>\n' +
                            '            <select class="form-control" id="bed_type_'+ x +'" name="extra_bed[]">\n' +
                            '               <option>--Select--</option> \n' +
                            '               <option value="1">Full Bed</option> \n' +
                            '               <option value="0">Half Bed</option> \n' +
                            '            </select>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '   <div class="col-md-3 col-sm-12 col-xs-12">\n' +
                            '        <div class="form-group">\n' +
                            '            <label for="">@lang("messages.keyword_base_price")</label>\n' +
                            '            <input type="text" value="0" name="extra_bed_base_price[]" onchange="extrabedcalculation('+ x +')" id="extra_bed_base_price_'+ x +'" class="form-control">\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '   <div class="col-md-3 col-sm-12 col-xs-12">\n' +
                            '        <div class="form-group">\n' +
                            '            <label for="">@lang("messages.keyword_quantity")</label>\n' +
                            '            <input type="text" value="0" name="extra_bed_quantity[]" id="extra_bed_quantity_'+ x +'" onchange="extrabedcalculation('+ x +')" class="form-control">\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '   <div class="col-md-3 col-sm-12 col-xs-12">\n' +
                            '        <div class="form-group">\n' +
                            '            <label for="">@lang("messages.keyword_total_fare")</label>\n' +
                            '            <input type="text" value="0" name="extra_bed_total_fare[]" id="extra_bed_total_fare_'+ x +'" class="form-control">\n' +
                            '            <span style="cursor:pointer;color: #337ab7;" class="pull-right" id="remove_extra_bed">&times; remove</span>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div>';


                        $("#append_extra_bed").append(add_room_html);
                        x++;
						$('#extrabedcounter').val(x);

                    }
                });


                $('body').on("click", "#remove_extra_bed", function(){
                    $(this).closest('#extra_bed_' + x).remove();
                    x--;
					$('#extrabedcounter').val(x);
                });


            });





        $(document).ready(function(){
            calculatePriceWithDiscount()
        });

        function calculatePriceWithDiscount()
        {
            var discount_type = $("#select_discount_type").val();

            if(discount_type != '' && discount_type == 'per')
            {
                var room_price_per_night = parseFloat($("#at_night").val());
                var percentage_discount = parseFloat($("#discount").val());

                var discounted_price =  room_price_per_night * percentage_discount / 100;

                var totalPrice = room_price_per_night - discounted_price;

                if($("#discount").val() == ''){
                    $("#display_discount").val('');
                    var totalPrice = room_price_per_night;
                } else {
                    $("#display_discount").html(percentage_discount);
                    $("#display_discount_type").html(' %');
                }


                if($("#discount").val() > 100)
                {
                    $("#totalPrice").val('--');
                }else {
                    $("#totalPrice").val(totalPrice);
                }

            }
            else if(discount_type != '' && discount_type == 'cur')
            {
                var room_price_per_night = parseFloat($("#at_night").val());
                var percentage_discount = parseFloat($("#discount").val());



                var totalPrice = room_price_per_night - percentage_discount;

                if($("#discount").val() == ''){
                    $("#display_discount").val('');
                    var totalPrice = room_price_per_night;
                } else {
                    $("#display_discount").html(percentage_discount);
                    var currency_symbol = '{{ isset($currency) ? $currency['symbol'] : '' }}';
                    $("#display_discount_type").html(currency_symbol);
                }


                if($("#discount").val() > 100)
                {
                    $("#totalPrice").val('');
                }else {
                    $("#totalPrice").val(totalPrice);
                }

            }
            else {
                $("#display_discount").val('');
                $("#display_discount_type").html('');
                $("#totalPrice").val('');
                //alert("Please select discount type");
            }




        }

        /*  Calculation extra bed */
        function extrabedcalculation(x)
        {
            var extra_bed_base_price = $("#extra_bed_base_price_" + x).val();
            var extra_bed_quantity = $("#extra_bed_quantity_"  + x).val();
            var extra_bed_total_fare = $("#extra_bed_total_fare_"  + x);
            var total =  extra_bed_base_price * extra_bed_quantity;
            $("#extra_bed_total_fare_"  + x).val(total);
			 $("#extra_bed_total_fare_"  + x).attr('readonly','readonly');
        }
        /*  Calculation extra bed */
    </script>



@endsection

