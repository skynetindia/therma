@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $("#phone").mask("(999) 999-9999");
        });
    </script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();
    $hotel_data = getHotels($hotel_id);
    $hotel_data = (count($hotel_data)>0)? $hotel_data[0] : '';
    $max_commission_discount = ($hotel_data) ? $hotel_data->commission : null;
    ?>
    

    {{ Form::open(array('url' => '/package/discount/update', 'files' => true, 'id' => 'package_discount_edit_form')) }}

    
    <input type="hidden" name="hotel_id" value="{{ isset($hotel_id) ? $hotel_id : '' }}">
    <input type="hidden" name="discount_id" value="{{ isset($discount->id) ? $discount->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">



    <div class="discount-offer-edit">
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">@if(isset($discount->id) && $action =='edit')@lang('messages.keyword_discount_offer_update')@else @lang('messages.keyword_discount_offer_add')@endif</h1>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="discount-offer">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="user-form row">

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                
                                
    
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount_name') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="discount_name" name="discount_name"
                                           placeholder="@lang('messages.keyword_discount_name')" value="{{ isset($discount->discount_name) ? $discount->discount_name : '' }}">
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_type_of_discount') <span
                                                class="required">(*)</span></label>
                                    <select class="form-control" name="tax_discount_id" id="tax_discount_id">
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                        @foreach(getTaxonomiesDiscount() as $type)
                                            <option value="{{ $type->id }}" {{ (isset($discount->tax_discount_id) && $discount->tax_discount_id == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{--<div class="form-group">--}}
                                    {{--<label for="">@lang('messages.keyword_accommodation_type') <span class="required">(*)</span></label>--}}

                                    {{--<select name="accommodation_type" id="" class="form-control">--}}
                                        {{--<option value="">@lang('messages.keyword_--select--')</option>--}}
                                        {{--@forelse(discount_accommodation_type() as $type)--}}
                                            {{--<option value="{{ $type->id }}" {{ (isset($discount->accommodation_type) && $discount->accommodation_type == $type->id) ? 'selected' : '' }}>{{ $type->type }}</option>--}}
                                        {{--@empty--}}
                                        {{--@endforelse--}}
                                    {{--</select>--}}

                                {{--</div>--}}

                                <div class="form-group">
                                    @if(isset($discount->valid_from) && isset($discount->valid_from) )
                                        @php $valid_from = date('m/d/Y',strtotime($discount->valid_from));
                                        $valid_to = date('m/d/Y',strtotime($discount->valid_to)); @endphp
                                    @endif
                                    
                                    <label for="">@lang('messages.keyword_valid') <span class="required">(*)</span></label>
                                    <div class="discount-set-width">
                                        <div><input type="text" class="form-control startdate" id="" name="valid_from"
                                                    placeholder="@lang('messages.keyword_valid_from')" value="{{ isset($discount->valid_from) ? $valid_from : '' }}" ></div>
                                        <div>-</div>
                                        <div><input type="text" class="form-control enddate" id="" name="valid_to"
                                                    placeholder="@lang('messages.keyword_valid_to')" value="{{ isset($discount->valid_to) ? $valid_to : '' }}" ></div>
                                    </div>
                                </div>

                                
                                
                                <div class="form-group" id="toggleDays">
                                    <label for="">@lang('messages.keyword_days_before_arrival') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="days_before_arrival" name="days_before_arrival"
                                           placeholder="@lang('messages.keyword_days_before_arrival')" value="{{ isset($discount->days_before_arrival) ? $discount->days_before_arrival : '' }}">
                                </div>
    
                                <div class="row" id="toggleStayPay">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_stay_night') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" id="stay_night" name="stay_night"
                                                   placeholder="@lang('messages.keyword_stay_night')" value="{{ isset($discount->stay_night) ? $discount->stay_night : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_pay_night') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" id="pay_night" name="pay_night"
                                                   placeholder="@lang('messages.keyword_pay_night')" value="{{ isset($discount->pay_night) ? $discount->pay_night : ''}}" required>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" id="discount" onchange="" name="discount"
                                                   placeholder="@lang('messages.keyword_discount')" value="{{ isset($discount->discount) ? $discount->discount : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_commission') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" id="commission" onchange="changeDiscount(this)" name="commission"
                                                   placeholder="@lang('messages.keyword_commission')" value="{{ isset($discount->commission) ? $discount->commission : $max_commission_discount }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount_action') <span class="required">(*)</span></label>
                                    <select class="form-control" name="apply_the_discount">
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                        @forelse(getDiscountActions() as $action)
                                            <option value="{{ $action->id }}" {{ (isset($discount->apply_the_discount) && $discount->apply_the_discount == $action->id) ? 'selected' : '' }}>{{ $action->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_room') @lang('messages.keyword_categories')</label>
                                </div>
                                <?php
                                    if(isset($discount->rooms))
                                    {
                                        $selected_rooms = explode(",", $discount->rooms);
                                    }
                                ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        @forelse(fetch_room_type() as $rooms)
                                        <div class="col-md-6">
                                                <div class="ryt-chk">
                                                    <input id="{{ $rooms->name."_".$rooms->id }}" value="{{ $rooms->id }}" type="checkbox" name="rooms_id[]" {{ (isset($discount->rooms) && in_array($rooms->id , $selected_rooms) ) ? 'checked' : '' }}>
                                                    <label for="{{ $rooms->name."_".$rooms->id }}">{{ $rooms->name }}</label>
                                                </div>
                                        </div>
                                        @empty
                                            @lang('messages.keyword_no_rooms_available')
                                        @endforelse

                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="btn-shape">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a
                            href="{{ url('package/discount')."/".$hotel_id }}"
                            class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                    <button type="submit" class="btn btn-default">@lang('messages.keyword_save')</button>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>


        $("#package_discount_edit_form").validate({
            rules: {
                discount_name: {
                    required: true
                },
                type_of_discount: {
                    required: true
                },
                accommodation_type: {
                    required: true
                },
                valid_from: {
                    required: true
                },
                valid_to: {
                    required: true
                },
                days_before_arrival : {
                    required: true,
                    number: true
                },
                discount: {
                    required: true,
                    number: true
                },
                apply_the_discount: {
                    required: true
                },
                stay_night: {
                    required: true
                },
                pay_night: {
                    required: true
                }
            },
            messages: {
                discount_name: {
                    required: "@lang('messages.keyword_please_enter_discount_name')"
                },
                type_of_discount: {
                    required: "@lang('messages.keyword_please_select_discount_type')"
                },
                accommodation_type: {
                    required: "@lang('messages.keyword_please_select_accommodation_type')"
                },
                valid_from: {
                    required: "@lang('messages.keyword_please_select_date')"
                },
                valid_to: {
                    required: "@lang('messages.keyword_please_select_date')"
                },
                days_before_arrival : {
                    required: "@lang('messages.keyword_please_enter_days_before_arrival')",
                    number: "@lang('messages.keyword_please_enter_valid_days')"
                },
                discount: {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                apply_the_discount: {
                    required: "@lang('messages.keyword_please_select_apply_the_discount')"
                },
                stay_night: {
                    required: "@lang('messages.keyword_please_enter_a_stay_night')"
                },
                pay_night: {
                    required: "@lang('messages.keyword_please_enter_a_pay_night')"
                }
            }
        });


    </script>
    <script>
        $(document).ready(function () {

            $('#valid_from, #valid_to').datepicker({
                format: "dd/mm/yyyy",
            }).datepicker();

            var discount = $("#tax_discount_id").val();
            if(discount == '1' || discount == '2')
            {
                $("#stay_night").attr('disabled', true);
                $("#pay_night").attr('disabled', true);
                $("#toggleStayPay").hide();
                $("#days_before_arrival").removeAttr('disabled');
                $("#toggleDays").show();
            }else if(discount == '3'){
                $("#days_before_arrival").attr('disabled', true);
                $("#toggleDays").hide();
                $("#stay_night").attr('disabled', true);
                $("#pay_night").attr('disabled', true);
                $("#toggleStayPay").hide();
            }else if(discount == '4'){
                $("#days_before_arrival").attr('disabled', true);
                $("#toggleDays").hide();
                $("#stay_night").removeAttr('disabled');
                $("#pay_night").removeAttr('disabled');
                $("#toggleStayPay").show();
            }
            else{
                $("#stay_night").attr('disabled', true);
                $("#pay_night").attr('disabled', true);
                $("#toggleStayPay").hide();
                $("#days_before_arrival").attr('disabled', true);
                $("#toggleDays").hide();
            }
            
            

            $("#tax_discount_id").on("change", function(){
                var discount = $(this).val();
                if(discount == '1' || discount == '2')
                {
                    $("#stay_night").attr('disabled', true);
                    $("#pay_night").attr('disabled', true);
                    $("#toggleStayPay").hide();
                    $("#days_before_arrival").removeAttr('disabled');
                    $("#toggleDays").show();
                }else if(discount == '3'){
                    $("#days_before_arrival").attr('disabled', true);
                    $("#toggleDays").hide();
                    $("#stay_night").attr('disabled', true);
                    $("#pay_night").attr('disabled', true);
                    $("#toggleStayPay").hide();
                }else if(discount == '4'){
                    $("#days_before_arrival").attr('disabled', true);
                    $("#toggleDays").hide();
                    $("#stay_night").removeAttr('disabled');
                    $("#pay_night").removeAttr('disabled');
                    $("#toggleStayPay").show();
                }
                else{
                    $("#stay_night").attr('disabled', true);
                    $("#pay_night").attr('disabled', true);
                    $("#toggleStayPay").hide();
                    $("#days_before_arrival").attr('disabled', true);
                    $("#toggleDays").hide();
                }
            });

        });
    </script>


    <script>
        function changeDiscount(e){
            var max_commission_discount = '{{ $max_commission_discount }}';
            var new_val = $(e).val();
            var msg = '{{ trans('messages.keyword_maximum_commission_is') }} ' + max_commission_discount + ' {{ trans('messages.keyword_for_this_hotel') }}';
            if(new_val > max_commission_discount){
                alert(msg);
            }
        }
        
        {{--function changeDiscount(e)--}}
        {{--{--}}
            {{--var max_commission_discount = '{{ $max_commission_discount }}';--}}
            {{--var new_val = $(e).val();--}}
            {{--alert(new_val);--}}
            {{--var other_field_value = max_commission_discount - new_val;--}}
            {{--//alert(max_commission_discount);--}}
            {{--alert(other_field_value);--}}
            {{----}}
            {{--var checksum = parseInt(new_val ) + parseInt(other_field_value);--}}
            {{--alert(checksum);--}}
            {{--if( checksum > max_commission_discount || new_val > max_commission_discount ){--}}
                {{--alert("maximum discount and commission is "+max_commission_discount+ " for this hotel");--}}
                {{--$("#discount").val('{{ $discount->discount }}');--}}
                {{--$("#commission").val('{{ $discount->commission }}');--}}
                {{--exit;--}}
            {{--}else{--}}
                {{--var field = ($(e).attr('id'));--}}
        
                {{--var other_field_value = max_commission_discount - new_val;--}}
                {{--switch(field){--}}
                    {{--case 'commission':--}}
                        {{--$("#discount").val(other_field_value);--}}
                        {{--break;--}}
                    {{--case 'discount':--}}
                        {{--$("#commission").val(other_field_value);--}}
                        {{--break;--}}
                    {{--default:--}}
                        {{--alert('default');--}}
                        {{--break;--}}
                {{--}--}}
            {{--}--}}
        {{--}--}}
    </script>


@endsection
