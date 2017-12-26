@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function(){
			if($("#phone").length>1)
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
    
    <input type="hidden" name="hotel_id" value="{{ isset($hotel_id) ? $hotel_id : '' }}">
    <input type="hidden" name="package_id" value="{{ isset($package->id) ? $package->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    
    
    
    <div class="user-profile-wrap">
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($package->id) && $action =='edit')@lang('messages.keyword_treatment') @lang('messages.keyword_update')@else @lang('messages.keyword_treatment') @lang('messages.keyword_add')@endif</h1>
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
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_minimum_individual') <span class="required">(*)</span></label>
                                        <select class="form-control" name="min_individual">
                                            <option value="">@lang('messages.keyword_--select--')</option>
                                            @for($i = 1; $i <= getMinMaxIndividuals($hotel_id) ; $i++)
                                                <option value="{{ $i }}" {{ (isset($package->min_individual) && $package->min_individual == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" name="max_individual">
                                        <label for="">@lang('messages.keyword_maximum_individual') <span class="required">(*)</span></label>
                                        <select class="form-control" name="max_individual">
                                            <option value="">@lang('messages.keyword_--select--')</option>
                                            @for($i = 1; $i <= getMinMaxIndividuals($hotel_id) ; $i++)
                                                <option value="{{ $i }}" {{ (isset($package->max_individual) && $package->max_individual == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_days') <span class="required">(*)</span></label>
                                        <input class="form-control" type="text" name="valid_days" id="valid_days" value="{{ isset($package->valid_days) ? $package->valid_days : '' }}">
                                    </div>
                                </div>
                            
                            
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_minimum_age')  <span class="required">(*)</span></label>
                                        <input class="form-control" type="text" name="min_age" id="min_age" value="{{ isset($package->min_age) ? $package->min_age : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" name="max_individual">
                                        <label for="">@lang('messages.keyword_maximum_age') <span class="required">(*)</span></label>
                                        <input class="form-control" type="text" name="max_age" id="max_age" value="{{ isset($package->max_age) ? $package->max_age : '' }}">
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
                                        <div class="switch"><input value="1" name="list_of_room_status" id="switch1" class="toggleField" onchange="toggleField(this)" type="checkbox" {{ (isset($package->list_of_room_status) && $package->list_of_room_status == 1 && $package->on_hotel==0) ? 'checked' : '' }}><label for="switch1"></label></div>
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
                                <select name="list_of_room" id="" class="form-control">
                                    <option value="">@lang('messages.keyword_--select--')</option>
                                    @forelse(fetch_room_type_by_hotel_id($hotel_id) as $room)
                                        <option value="{{ $room->id }}" {{ (isset($package->list_of_room) && $package->list_of_room == $room->id) ? 'selected' : '' }}>{{ $room->personal_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                {{--<input type="text"  placeholder="@lang('messages.keyword_list_of_room')" name="list_of_room" value="{{ isset($package->list_of_room) ? $package->list_of_room : '' }}">--}}
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
    
    
        <hr>
        <div class="package-optional-add">
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">@lang('messages.keyword_cure_options')</h1>
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
                        @forelse(array_chunk(getPackageOptions($hotel_id) , 4) as $chunk)
                            
                            <tr>
                                @foreach($chunk as $options)
                                    <td>
                                        <div class="ryt-chk-content">
                                            <div class="ryt-chk pull-left">
                                                <input id="{{ $options->language_key."_".$options->id }}" name="options_id[]" type="checkbox" onchange="togglePrice(this)" value="{{ $options->id }}" class="togglePrice" {{ in_array($options->id, $options_id_array) ? 'checked' : '' }}>
                                                <label for="{{ $options->language_key."_".$options->id }}">{{ $options->name }}</label>
                                            </div>
                                            
                                            
                                            <div class="input-group {{ $options->language_key."_".$options->id }}">
                                                <input type="text" class="form-control option_price{{ $options->id }}" value="{{ (count($options_id_array) > 0 && in_array($options->id, $options_id_array)) ? $id_and_price_array[$options->id] : $options->price }}" name="base_price[]" placeholder="@lang('messages.keyword_price')" onkeyup="checkNotBlank(this);checkedSum()">
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
    
    
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="price" name="price" placeholder="@lang('messages.keyword_price')" value="{{ isset($package->price) ? $package->price : '' }}" >
                                <span class="input-group-addon">{{ $cur['symbol'] }}</span>
                            </div>
                
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="" name="discount" placeholder="@lang('messages.keyword_discount')" value="{{ isset($package->discount) ? $package->discount : '' }}" >
                                <span class="input-group-addon">%</span>
                            </div>
                
                        </div>
                    </div>
    
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">@lang('messages.keyword_commission') <span class="required">(*)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="" name="commission" placeholder="@lang('messages.keyword_commission')" value="{{ isset($package->commission) ? $package->commission : (isset($hotel_data)) ? $hotel_data->commission : '' }}" >
                                <span class="input-group-addon">%</span>
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
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('package/cure-treatment')."/".$hotel_id }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
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
                hotel_id: {
                    required: true,
                },
                valid_days: {
                    required: true,
                    number: true
                },
                min_age: {
                    required: true,
                    number: true
                },
                max_age: {
                    required: true,
                    number: true
                },
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
                net_price: {
                    required: true,
                    number: true
                },
                discount: {
                    required: true,
                    number: true
                },
                commission: {
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
                    @if($action == 'add')
                    required: true,
                    @else
                    required: false,
                    @endif
                    extension: "jpeg|jpg|png|gif"
                }

            },
            messages: {
                hotel_id: {
                    required: "{{trans('messages.keyword_please_select_hotel')}}",
                },
                valid_days: {
                    required: "{{trans('messages.keyword_please_enter_valid_days')}}",
                    number: "{{trans('messages.keyword_please_enter_valid_number')}}",
                },
                min_age: {
                    required: "{{trans('messages.keyword_please_enter_minimum_age')}}",
                    number: "{{trans('messages.keyword_please_enter_valid_number')}}",
                },
                max_age: {
                    required: "{{trans('messages.keyword_please_enter_maxmum_age')}}",
                    number: "{{trans('messages.keyword_please_enter_valid_number')}}",
                },
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
                net_price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                discount : {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                commission : {
                    required: "@lang('messages.keyword_please_enter_a_commission')",
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
                    required: "@lang('messages.keyword_please_select_image')",
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
            
            var checked = $(e).prop('checked');
            
            
            switch(getId){
                case 'switch1':
                    if(checked == true)
                    {
                        $(".switch1 > .form-control").removeAttr("disabled");
                        $(".switch1").fadeIn();
                        
                    }else{
                        $(".switch1 > .form-control").attr("disabled", "disabled");
                        $(".switch1").fadeOut();
                    }
                    break;
                case 'switch2':
                    if(checked == true)
                    {
                        $(".switch2 > .form-control").removeAttr("disabled");
                        $(".switch2").fadeIn();

                    }else{
                        $(".switch2 > .form-control").attr("disabled", "disabled");
                        $(".switch2").fadeOut();
                    }
                    break;
                case 'switch3':
                    if(checked == true)
                    {
                        $(".switch3 > .form-control").removeAttr("disabled");
                        $(".switch3").fadeIn();

                    }else{
                        $(".switch3 > .form-control").attr("disabled", "disabled");
                        $(".switch3").fadeOut();
                    }
                    break;
                case 'switch4':
                    if(checked == true)
                    {
                        $(".switch1 > .form-control").attr("disabled", "disabled");
                        $(".switch1").fadeOut();
                        $('#switch1').not(e).prop('checked', false);
                    }else{
                        $(".switch1 > .form-control").removeAttr("disabled");
                        
                    }
                    break;
                default:
                    break;
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
            
        });
        function togglePrice(e)
        {
            var options_id = $(e).attr('id');
            if($("#" + options_id).prop("checked"))
            {
                $("." + options_id + " input[type='text']").removeAttr("disabled");
                var addPrice = $("." + options_id + " input[type='text']").val();
                checkedSum();
                
            }
            else{
                var minusPrice = $("." + options_id + " input[type='text']").val();
                $("." + options_id + " input[type='text']").attr("disabled", "disabled");
                checkedSum();
            }
        }

        /*Toggle Price event*/
    
    </script>

    <script>
        function checkedSum(){
            var className = $('[class="togglePrice"]');

            var price = 0;
            $(className).each(function(){
                var options_id =  $(this).attr('id');
                
                
                if($(this).prop("checked")){
                    var new_price = $("." + options_id + " input[type='text']").val();
                    
                    price += parseInt(new_price);
                }
                
                
            });
            $("#price").val(price);
        }

        function checkNotBlank(e){
            if($(e).val()==''){
                $(e).val('0');
            }
        }
        
    </script>

@endsection
