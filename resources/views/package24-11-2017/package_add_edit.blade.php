@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function(){
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
    <?php $arrlanguages = getlanguages(); ?>
    {{ Form::open(array('url' => '/package/update', 'files' => true, 'id' => 'package_edit_form')) }}

    <input type="hidden" name="package_id" value="{{ isset($package->id) ? $package->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="user-profile-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($package->id) && $action =='edit')@lang('messages.keyword_package_update')@else @lang('messages.keyword_package_add')@endif</h1>
            </div>
        </div><hr>

        <div class="row">
            <div class="package-add">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_code') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="" name="code" placeholder="@lang('messages.keyword_code')" value="{{ isset($package->code) ? $package->code : generateCode(6) }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="" name="name" placeholder="@lang('messages.keyword_name')" value="{{ isset($package->name) ? $package->name : '' }}" >
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="old_image" value="{{ isset($package->image) ? $package->image : '' }}">
                                    <label for="">@lang('messages.keyword_icon') </label>
                                    <input type="file" class="" id="" name="image" placeholder="" value="">
                                </div>


                                @if($action == 'edit')
                                    <div class="form-group">
                                        <div class="user-profile-img">
                                            @if($package->image != '')
                                            <img src="{{ asset('public/images/package')."/".$package->image }}" class="thumbnail" alt="{{ $package->name }}" width="150px">
                                            @else
                                                <img src="{{ asset('public/images/default/default_package.jpg') }}" class="thumbnail" alt="{{ $package->name }}" width="150px">
                                                <img src="{{ asset('public/images/default/default_package.jpg') }}" class="thumbnail" alt="{{ $package->name }}" width="150px">
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="" name="price" placeholder="@lang('messages.keyword_price')" value="{{ isset($package->price) ? $package->price : '' }}" >
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" id="" name="discount" placeholder="@lang('messages.keyword_discount')" value="{{ isset($package->discount) ? $package->discount : '' }}" >
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_minimum_individual') <span class="required">(*)</span></label>
                                            <select class="form-control" name="min_individual">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="1" {{ (isset($package->min_individual) && $package->min_individual == 1) ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ (isset($package->min_individual) && $package->min_individual == 2) ? 'selected' : '' }}>2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group" name="max_individual">
                                            <label for="">@lang('messages.keyword_maximum_individual') <span class="required">(*)</span></label>
                                            <select class="form-control" name="max_individual">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="1" {{ (isset($package->max_individual) && $package->max_individual == 1) ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ (isset($package->max_individual) && $package->max_individual == 2) ? 'selected' : '' }}>2</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_description') <span class="required">(*)</span></label>
                                    <textarea class="form-control" name="description" placeholder="@lang('messages.keyword_description')" >{{ isset($package->description) ? $package->description : '' }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12"><h4>@lang('messages.keyword_minimum_cretarea')</h4></div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="block">@lang('messages.keyword_room')</label>
                                            <div class="switch"><input value="1" name="list_of_room_status" id="switch1" class="toggleField" onchange="toggleField(this)" type="checkbox" {{ (isset($package->list_of_room_status) && $package->list_of_room_status == 1) ? 'checked' : '' }}><label for="switch1"></label></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="block">@lang('messages.keyword_individual')</label>
                                            <div class="switch"><input value="1" name="list_of_individual_status" class="toggleField" onchange="toggleField(this)" id="switch2" type="checkbox" {{ (isset($package->list_of_individual_status) && $package->list_of_individual_status == 1) ? 'checked' : '' }}><label for="switch2"></label></div>
                                        </div>
                                    </div>



                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="block">@lang('messages.keyword_number_of_days')</label>
                                            <div class="switch"><input value="1" name="list_of_days_status" class="toggleField" onchange="toggleField(this)" id="switch3" type="checkbox" {{ (isset($package->list_of_days_status) && $package->list_of_days_status == 1) ? 'checked' : '' }}><label for="switch3"></label></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="block">@lang('messages.keyword_on_hotel')</label>
                                            <div class="switch"><input value="1" id="switch4" name="on_hotel" class="toggleField" onchange="toggleField(this)" type="checkbox" {{ (isset($package->on_hotel) && $package->on_hotel == 1) ? 'checked' : '' }}><label for="switch4"></label></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group none switch1">
                                    <label for="">@lang('messages.keyword_list_of_room') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('messages.keyword_list_of_room')" name="list_of_room" value="{{ isset($package->list_of_room) ? $package->list_of_room : '' }}">
                                </div>

                                <div class="form-group none switch2">
                                    <label for="">@lang('messages.keyword_list_of_individual') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('messages.keyword_list_of_individual')" name="list_of_individual" value="{{ isset($package->list_of_individual) ? $package->list_of_individual : '' }}">
                                </div>

                                <div class="form-group none switch3">
                                    <label for="">@lang('messages.keyword_list_of_days') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('messages.keyword_list_of_days')" name="list_of_days" value="{{ isset($package->list_of_days) ? $package->list_of_days : '' }}">
                                </div>

                            </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="package-optional-add">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">@lang('messages.keyword_package_options')</h1>
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                        <?php $options_id_array = []; $price_array = []; ?>
                        @if(isset($package->id) && $action == 'edit')
                            <?php
                                $selected_array = getSelectedPackageOptions($package->id);

                            ?>

                            @foreach ($selected_array as $key => $value)
                                <?php
                                    $options_id_array[] = $value['options_id'];
                                    $price_array[] = $value['price'];
                                ?>
                            @endforeach

                            <?php $id_and_price_array = array_combine($options_id_array, $price_array); ?>
                        @endif

                    <table class="table table-bordered">
                        <tbody>
                        @forelse(array_chunk(getPackageOptions() , 4) as $chunk)

                            <tr>
                                @foreach($chunk as $options)
                                <td>
                                    <div class="ryt-chk-content">
                                        <div class="ryt-chk pull-left">
                                            <input id="{{ $options->language_key."_".$options->id }}" name="options_id[]" type="checkbox" onchange="togglePrice(this)" value="{{ $options->id }}" class="togglePrice" {{ in_array($options->id, $options_id_array) ? 'checked' : '' }}>
                                            <label for="{{ $options->language_key."_".$options->id }}">{{ $options->name }}</label>
                                        </div>


                                        <div class="input-group {{ $options->language_key."_".$options->id }}">

                                            <input type="text" class="form-control" value="{{ (count($options_id_array) > 0 && in_array($options->id, $options_id_array)) ? $id_and_price_array[$options->id] : $options->base_price }}" name="base_price[]" placeholder="@lang('messages.keyword_price')">
                                            <?php $cur = getActiveCurrency(); ?>
                                            <span class="input-group-addon">{{ $cur['symbol'] }}</span>
                                        </div>

                                    </div>

                                </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">@lang('messages.keyword_no_options_found')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('packages') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>

        $( "#package_edit_form" ).validate({
            rules: {
                code: {
                    required: true
                },
                name: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                discount: {
                    required: true,
                    number: true
                },
                min_individual: {
                    required: true
                },
                max_individual: {
                    required: true
                },
                "base_price[]": {
                    required: true,
                    number: true
                },
                description: {
                    required: true
                },
                list_of_room: {
                    required: true,
                    number: true
                },
                list_of_individual: {
                    required: true,
                    number: true
                },
                list_of_days: {
                    required: true,
                    number: true
                },
                image: {
                    extension: "jpeg|jpg|png|gif"
                }

            },
            messages: {
                code: {
                    required: "@lang('messages.keyword_please_enter_a_code')"
                },
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                discount : {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                min_individual: {
                    required: "@lang('messages.keyword_please_select_minimum_individual')"
                },
                max_individual: {
                    required: "@lang('messages.keyword_please_select_maximum_individual')"
                },
                "base_price[]" : {
                    required: "@lang('messages.keyword_please_enter_a_base_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                list_of_room: {
                    required: "@lang('messages.keyword_please_enter_list_of_room')",
                    number: "@lang('messages.keyword_please_enter_valid_value')"
                },
                list_of_individual: {
                    required: "@lang('messages.keyword_please_enter_list_of_individual')",
                    number: "@lang('messages.keyword_please_enter_valid_value')"
                },
                list_of_days: {
                    required: "@lang('messages.keyword_please_enter_list_of_days')",
                    number: "@lang('messages.keyword_please_enter_valid_value')"
                },
                image: {
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                }
            }
        });

    </script>

    <script>


        $(document).ready(function(){
            var getClass = $(".toggleField");
            $(getClass).each(function(){

                if($(this).prop("checked"))
                {
                    var getId = $(this).attr('id');
                    $("." + getId).fadeIn();
                }
            });
        });

        function toggleField(e)
        {
            var getId = $(e).attr('id');
            if(getId == 'switch4')
            {
                $(".switch1 > select.form-control").attr("disabled", "disabled");
                $(".switch2 > select.form-control").attr("disabled", "disabled");
                $(".switch3 > select.form-control").attr("disabled", "disabled");
                $('#switch1 , #switch2 , #switch3').not(e).prop('checked', false);
                $('.switch1 , .switch2 , .switch3').fadeOut();

            }
            if($(e).prop("checked"))
            {
                $("." + getId + " > select.form-control").removeAttr("disabled");
                $("." + getId).fadeIn();
            }
            else{
                $("." + getId + " > select.form-control").attr("disabled", "disabled");
                $("." + getId).fadeOut();
            }
        }



        /*Toggle Price event*/
        $(document).ready(function(){
            var className = $('[class="togglePrice"]');
            var options_id =  $('[class="togglePrice"]').attr('id');

            $(className).each(function(){
                var options_id =  $(this).attr('id');

                if($(this).prop("checked")){
                    $("." + options_id + " input[type='text']").removeAttr("disabled");
                }
                else{
                    $("." + options_id + " input[type='text']").attr("disabled", "disabled");
                }

            });
//            if($('[class="togglePrice"]').prop("checked"))
//            {
//
//            }
//            alert(test);
        });
        function togglePrice(e)
        {
            var options_id = $(e).attr('id');
            if($("#" + options_id).prop("checked"))
            {
                $("." + options_id + " input[type='text']").removeAttr("disabled");
            }
            else{
                $("." + options_id + " input[type='text']").attr("disabled", "disabled");
            }
        }

        /*Toggle Price event*/




    </script>

@endsection
