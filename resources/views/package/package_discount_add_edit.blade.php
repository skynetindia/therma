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
    <?php $arrlanguages = getlanguages();?>

    {{ Form::open(array('url' => '/package/discount/update', 'files' => true, 'id' => 'package_discount_edit_form')) }}

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
                                    <label for="">@lang('messages.keyword_type_of_discount') <span
                                                class="required">(*)</span></label>
                                    <select class="form-control" name="tax_discount_id" id="tax_discount_id">
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                        @foreach(getTaxonomiesDiscount() as $type)
                                            <option value="{{ $type->id }}" {{ (isset($discount->tax_discount_id) && $discount->tax_discount_id == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_accommodation_type') <span class="required">(*)</span></label>

                                    <select name="accommodation_type" id="" class="form-control">
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                        @forelse(discount_accommodation_type() as $type)
                                            <option value="{{ $type->id }}" {{ (isset($discount->accommodation_type) && $discount->accommodation_type == $type->id) ? 'selected' : '' }}>{{ $type->type }}</option>
                                        @empty
                                        @endforelse
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_valid') <span class="required">(*)</span></label>
                                    <div class="discount-set-width">
                                        <div><input type="text" class="form-control" id="valid_from" name="valid_from"
                                                    placeholder="@lang('messages.keyword_valid_from')" value="{{ isset($discount->valid_from) ? $discount->valid_from : '' }}" readonly></div>
                                        <div>-</div>
                                        <div><input type="text" class="form-control" id="valid_to" name="valid_to"
                                                    placeholder="@lang('messages.keyword_valid_to')" value="{{ isset($discount->valid_to) ? $discount->valid_to : '' }}" readonly></div>
                                    </div>
                                </div>

                                <div class="form-group" id="toggleDays">
                                    <label for="">@lang('messages.keyword_days_before_arrival') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="days_before_arrival" name="days_before_arrival"
                                           placeholder="@lang('messages.keyword_days_before_arrival')" value="{{ isset($discount->days_before_arrival) ? $discount->days_before_arrival : '' }}">
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="" name="discount"
                                           placeholder="@lang('messages.keyword_discount')" value="{{ isset($discount->discount) ? $discount->discount : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount_action') <span class="required">(*)</span></label>
                                    <select class="form-control" name="apply_the_discount">
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                        @forelse(getDiscountActions() as $action)
                                            <option value="{{ $action->id }}" {{ (isset($discount->apply_the_discount) && $discount->apply_the_discount == $action->id) ? 'selected' : '' }}>{{ $action->action }}</option>
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
                            href="{{ url('package/discount') }}"
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
                }
            },
            messages: {
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
                }
            }
        });


    </script>
    <script>
        $(document).ready(function () {

            $('#valid_from, #valid_to').datepicker({
                format: "yyyy-mm-dd",
            }).datepicker();

            var discount = $("#tax_discount_id").val();
            if(discount == '1' || discount == '')
            {
                $("#days_before_arrival").attr('readOnly', true);
                $("#toggleDays").hide();
            }
            else{
                $("#days_before_arrival").removeAttr('readOnly');
                $("#toggleDays").show();
            }

            $("#tax_discount_id").on("change", function(){
                var discount = $(this).val();
                if(discount  == '1' || discount == ''){
                    $("#days_before_arrival").attr('readOnly', true);
                    $("#toggleDays").hide();
                }
                else{
                    $("#days_before_arrival").removeAttr('readOnly');
                    $("#toggleDays").show();
                }
            });

        });
    </script>





@endsection
