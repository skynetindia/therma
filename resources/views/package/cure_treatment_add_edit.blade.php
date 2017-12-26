@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <?php
        $cur = getActiveCurrency();
        $modules = fetch_modules(0, '', 0);
        $hotel_data = getHotels($hotel_id);
        $hotel_data = (count($hotel_data)>0)? $hotel_data[0] : '';
        $max_commission_discount = ($hotel_data) ? $hotel_data->treatment_commission : null;
    ?>

    {{ Form::open(array('url' => '/package/cure-treatment/update', 'files' => true, 'id' => 'cure_treatment_edit_form')) }}

    <input type="hidden" name="hotel_id" value="{{ isset($hotel_id) ? $hotel_id : '' }}">
    <input type="hidden" name="options_id" value="{{ isset($cure_treatment->id) ? $cure_treatment->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="user-profile-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($cure_treatment->id) && $action =='edit')@lang('messages.keyword_cure') @lang('messages.keyword_update') @else @lang('messages.keyword_cure') @lang('messages.keyword_add')@endif</h1>
            </div>
        </div><hr>

        <div class="row">
            <div class="package-add">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                                    <input type="text" name="name" class="form-control" id="" placeholder="@lang('messages.keyword_package_name')" value="{{ isset($cure_treatment->name) ? $cure_treatment->name : '' }}" required>
                                </div>


                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_description') <span class="required">(*)</span></label>
                                    <textarea class="form-control" name="description" placeholder="{{ trans('messages.keyword_description') }}" required>{{ isset($cure_treatment->description) ? $cure_treatment->description : '' }}</textarea>
                                </div>
    
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_icon')</label>
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div class="dropdown icon-dropdown">
                                                <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">@lang('messages.keyword_select_icon')
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" id="all_icons">
                                                    <li role="presentation" class="icon-search">
                            
                                                        <div class="form-group">
                                                            <input class="form-control" name="icon-search" id="optional_search" placeholder="Search icon here">
                                                        </div>
                        
                                                    </li>
                                                    <script>
                                                        $('#optional_search').on('keyup', function() {
                                                            var val = $.trim(this.value);
                                                            if (val) {
                                                                $('.optional-section[data-filter!=' + val + ']').hide();
                                                                $('.optional-section[data-filter*=' + val + ']').show();
                                                            } else {
                                                                $('.optional-section[data-filter]').show();
                                                            }
                                                        });
                                                    </script>
                        
                                                    @foreach(fetchicons() as $icon)
                                                        <li role="presentation" style="cursor:pointer;" data-filter="{{ $icon->class_name }}" data-name="{{ $icon->class_name }}" class='optional-section' title="{{ $icon->class_name }}"><i class="{{ $icon->class_name }}"></i> </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="old_icon" value="{{(isset($cure_treatment->icon)) ? $cure_treatment->icon : '' }}">
                                            <input class="form-control" id="get_icon" placeholder="{{trans('messages.keyword_icon')}}"  value="{{(isset($cure_treatment->icon)) ? $cure_treatment->icon : '' }}" name="icon" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                


                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                            
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="price" id="price" onkeyup="calculateDiscountedAndNetPrice(this)" placeholder="@lang('messages.keyword_price')" value="{{ isset($cure_treatment->price) ? $cure_treatment->price : '' }}" required>
                                                <span class="input-group-addon"><strong>{{ $cur['symbol'] }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_total') @lang('messages.keyword_commission') <span class="required">(*)</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="total_discount" value="{{ $max_commission_discount }}" readonly>
                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                

                                <div class="row">
    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('messages.keyword_commission') <span class="required">(*)</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" onchange="handleDiscountCommission(this)" name="commission" id="commission" placeholder="@lang('messages.keyword_commission')" value="{{ isset($cure_treatment->commission) ? $cure_treatment->commission : $max_commission_discount }}" required>
                                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('messages.keyword_commission')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="commission_price" id="commission_price" placeholder="@lang('messages.keyword_commission')" value="" readonly>
                                                        <span class="input-group-addon"><strong>{{ $cur['symbol'] }}</strong></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" onchange="handleDiscountCommission(this)" name="discount" id="discount" placeholder="@lang('messages.keyword_discount')" value="{{ isset($cure_treatment->discount) ? $cure_treatment->discount : '' }}" required>
                                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('messages.keyword_discount')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="discount_price" id="discount_price" placeholder="@lang('messages.keyword_discounted_price')" value="" readonly>
                                                        <span class="input-group-addon"><strong>{{ $cur['symbol'] }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_net_price') <span class="required">(*)</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="net_price" id="net_price" placeholder="@lang('messages.keyword_net_price')" value="{{ isset($cure_treatment->net_price) ? $cure_treatment->net_price : '' }}" required>
                                                <span class="input-group-addon"><strong>{{ $cur['symbol'] }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
        
                                        {{--<div class="col-md-6 none">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="">@lang('messages.keyword_discounted_price') <span class="required">(*)</span></label>--}}
                                                {{--<input type="hidden" name="sale_price" value="" id="getDiscounted_price">--}}
                                                {{--<input type="text" class="form-control" name="discounted_price" id="discounted_price" placeholder="@lang('messages.keyword_discounted_price')" value="{{ isset($cure_treatment->discounted_price) ? $cure_treatment->discounted_price : '' }}" required>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
    
                                </div>
                                
    
                                <div class="form-group">
                                    <input type="hidden" name="old_image" value="{{ isset($cure_treatment->image) ? $cure_treatment->image : '' }}">
                                    <label for="">@lang('messages.keyword_feature_image') <span class="required">(*)</span></label>
                                    <input type="file" class="" id="" name="image" placeholder="" value="">
                                </div>
    
                                @if($action == 'edit')
                                    <div class="form-group">
                                        <div class="user-profile-img">
                                            @if($cure_treatment->image != '')
                                                <img src="{{ asset('public/images/cure_treatment')."/".$cure_treatment->image }}" class="thumbnail" alt="{{ $cure_treatment->name }}" width="150px">
                                            @else
                                                <img src="{{ asset('public/images/default/default_cure_treatment.jpg') }}" class="thumbnail" alt="{{ $cure_treatment->name }}" width="150px">
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
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
        $( "#cure_treatment_edit_form" ).validate({
            rules: {
                short_name: {
                    required: true
                },
                name: {
                    required: true
                },
                image: {
                    @if($action == 'add')
                        required: true,
                    @else
                        required: false,
                    @endif
                    extension: "jpeg|jpg|png|gif"
                },
                description: {
                    required: true
                },
                discount : {
                    required: true,
                    number: true
                },
                price : {
                    required: true,
                    number: true
                },
                discounted_price : {
                    required: true,
                        number: true
                },
                commission: {
                    required: true,
                    number : true
                }
            },
            messages: {
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                image: {
                    required: "@lang('messages.keyword_please_select_image')",
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                discount : {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                discounted_price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                commission: {
                    required: "@lang('messages.keyword_please_enter_a_commission')",
                    number: "@lang('messages.keyword_please_enter_valid_number')"
                }
            }
        });
    </script>
    <script>
        $("#all_icons").on("click", "li", function(){
            var icon_name = $(this).data('name');
            $("#get_icon").val(icon_name);
        });
    </script>

    {{--Handle Commision and discount Calculations--}}
    <script>
        function handleDiscountCommission(e)
        {
            var max_commission_discount = '{{ $max_commission_discount }}';
            
            var discount = $("#discount").val();
            var commission = $("#commission").val();
            var changed_field_value = $(e).val();


            if(parseFloat(changed_field_value) <= parseFloat(max_commission_discount)){
                //alert(changed_field_value + ','+ max_commission_discount);
                
                var remaining_field_value = parseFloat(max_commission_discount) - parseFloat(changed_field_value);
                var changed_field_name = $(e).attr('id');
                
                switch(changed_field_name){
                    case 'discount':
                        
                        $("#commission").val(remaining_field_value);
                        break;
                    case 'commission':
                        $("#discount").val(remaining_field_value);
                        break;
                    default:
                        break;
                }

                // calculate discount and commission with change
                var price = $("#price").val();
                if(parseFloat(price) != '' && parseFloat(price) != 0 ){
                    var discount = $("#discount").val();
                    var commission  = $("#commission").val();

                    var discounted_price = (parseFloat(price) * parseFloat(discount)) / 100;
                    $("#discount_price").val(discounted_price.toFixed(2));
                    var remaining_discounted_price = parseFloat(price) - parseFloat(discounted_price);

                    var commission_price = ( parseFloat(price) * parseFloat(commission)) / 100;
                    $("#commission_price").val(commission_price.toFixed(2));
                    var net_price = parseFloat(remaining_discounted_price) - parseFloat(commission_price);
                    $("#net_price").val(Math.round(net_price.toFixed(2)));
                }else{
                
                }
                
            }else if(parseFloat(changed_field_value) > parseFloat(max_commission_discount)){
                alert("maximum commission and discount is "+ max_commission_discount);
                $("#discount").val("{{ ($action == 'edit' && isset($cure_treatment->discount)) ? $cure_treatment->discount : '' }}");
                $("#commission").val("{{ ($action == 'edit' && isset($cure_treatment->commission))  ? $cure_treatment->commission : $max_commission_discount }}");
                setZero();
                calculationOnReady();
            }else{
                $("#discount").val("{{ ($action == 'edit' && isset($cure_treatment->discount)) ? $cure_treatment->discount : '' }}");
                $("#commission").val("{{ ($action == 'edit' && isset($cure_treatment->commission))  ? $cure_treatment->commission : $max_commission_discount }}");
                calculationOnReady();
            }
            
            
        }
        
        
    </script>
    {{--Handle Commision and discount Calculations--}}


    {{--Price Calculations--}}
    <script>
        function calculateDiscountedAndNetPrice(e)
        {
            
            var price = $(e).val();
            if(price == ''){
                var price = 0;
            }
            
            var discount = $("#discount").val();
            var commission  = $("#commission").val();
            
            var discounted_price = (parseFloat(price) * parseFloat(discount)) / 100;
            $("#discount_price").val(discounted_price.toFixed(2));
            var remaining_discounted_price = parseFloat(price) - parseFloat(discounted_price);
            //$("#discounted_price").val(discounted_price);
            
            // //discounted price or sell price will not shown in backend it's just for calculations
            // $("#getDiscounted_price").val(remaining_discounted_price);
            
            var commission_price = ( parseFloat(price) * parseFloat(commission)) / 100;
            $("#commission_price").val(commission_price.toFixed(2));
            var net_price = parseFloat(remaining_discounted_price) - parseFloat(commission_price);
            $("#net_price").val(Math.round(net_price.toFixed(2)));
        }
    </script>
    {{--Price Calculations--}}


    <script>
        function calculationOnReady(){
            var price = $("#price").val();
            var discount = $("#discount").val();
            var commission  = $("#commission").val();

            var discounted_price = (parseFloat(price) * parseFloat(discount)) / 100;
            $("#discount_price").val(discounted_price.toFixed(2));
            var remaining_discounted_price = parseFloat(price) - parseFloat(discounted_price);
            //$("#discounted_price").val(discounted_price);

            // //discounted price or sell price will not shown in backend it's just for calculations
            // $("#getDiscounted_price").val(remaining_discounted_price);

            var commission_price = ( parseFloat(price) * parseFloat(commission)) / 100;
            $("#commission_price").val(commission_price.toFixed(2));
            var net_price = parseFloat(remaining_discounted_price) - parseFloat(commission_price);
            $("#net_price").val(Math.round(net_price.toFixed(2)));
        }
        $(document).ready(function(){
            calculationOnReady();

            setZero();
        });
    </script>

    @if($action == 'add')
        <script>
            function setZero()
            {
                $("#commission_price, #discount_price").val(parseFloat(0).toFixed(2));
                $("#net_price, #price, #discount").val('0');
            
                if( $("#commission_price, #discount, #discount_price, #net_price, #price").val() == ''){
                    $("#commission_price, #discount_price").val(parseFloat(0).toFixed(2));
                    $("#net_price, #price, #discount").val('0');
                }
            }
          
        </script>
    @endif
    
@endsection
