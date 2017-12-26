@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>

<a href="{{url('booking/transfer/'.$bookingdetail->id)}}">@lang('messages.keyword_skip')</a>

    <?php echo Form::open(array('url' => url('booking/savepackage/'.$bookingdetail->id), 'files' => true, 'id' => 'wizard_category_form')); ?>


	<input type="hidden" name="bookingid" value="{{$bookingdetail->id}}">
    {{ csrf_field() }}

    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <h1 class="user-profile-heading">
                                 <strong>@lang('messages.keyword_hotel_name'):</strong>{{ucwords($hotelDetail->name)}}
                                </h1><hr>
                                <div class="row">
                                    <div class="col-md-6">
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_booking_id')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_booking_id')}}" value="{{isset($bookingdetail->temp_booking_id)?$bookingdetail->temp_booking_id:0}}" disabled id="adult" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_adult')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_adult')}}" value="{{isset($bookingdetail->adults)?$bookingdetail->adults:0}}" disabled id="adult" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_number_of_children')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_child')}}" value="{{isset($bookingdetail->children)?$bookingdetail->children:0}}" disabled name="child" id="child" type="text">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_price_per_bed')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_price')}}" disabled value="{{isset($bookingdetail->price)?$bookingdetail->price:0}}"  id="price" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_price_per_night')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_price')}}" disabled value="{{isset($bookingdetail->price_night)?$bookingdetail->price_night:0}}" id="price" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4><strong>@lang('messages.keyword_room_details'):</strong>{{ucwords($roomDetail->personal_name)}}</h4>
                                        <table class="table table-striped table-bordered table-condensed table-hover">
                                            <tr>
                                            	<th>@lang('messages.keyword_type')</th>
                                                <th>@lang('messages.keyword_standard_bed')</th>
                                                <th>@lang('messages.keyword_extra_bed')</th>
                                                <th>@lang('messages.keyword_discounted_price')</th>
                                                 <th>@lang('messages.keyword_total')</th>
                                               
                                            </tr>
                                            <tr>
                                                <td >@lang('messages.keyword_adult')</td>
                                                <td >{{$bookingdetail->adults}}</td>
                                                <td >@php $adultextra=($roomDetail->standard_bed < $bookingdetail->adults)?($bookingdetail->adults-$roomDetail->standard_bed):0;@endphp
                                                {{$adultextra}}</td>
                                                @php $adultdiscount=($bookingdetail->price *10)/100;
                                                	$adultdis=$bookingdetail->price - $adultdiscount;
                                                    $adultdiscval=$adultextra * $adultdiscount;
                                                 @endphp
                                                <td >{{$adultdiscval}}</td>
                                                <td >{{$bookingdetail->adults * $bookingdetail->price - $adultdiscval}}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('messages.keyword_child')</td>
                                                <td>0</td>
                                                <td>{{$bookingdetail->children}}</td>
                                                <td>{{$bookingdetail->discountedprice- $adultdiscval}}</td>
                                                 <td>{{($bookingdetail->adults * $bookingdetail->price) -($bookingdetail->discountedprice- $adultdiscval)}}</td>
                                            </tr>
                                            <tr>
                                                <?php $cur = getActiveCurrency(); ?>
                                                <td colspan="5" class="text-right"><b>@lang('messages.keyword_package_total') :<input type="hidden" name="total_package" value="{{$bookingdetail->total_package}}"> <span id="priceCalculate">{{$bookingdetail->total_package}}</span> {{ $cur['symbol'] }}</b></td>
                                            </tr>
                                             <tr>
                                                <?php $cur = getActiveCurrency(); ?>
                                                <td colspan="5" class="text-right"><b>@lang('messages.keyword_grand_total') : <input type="hidden" name="grand_total" value="{{$bookingdetail->total_price}}"> <span id="grand_total">{{$bookingdetail->total_price}}</span> {{ $cur['symbol'] }}</b></td>
                                            </tr>
                                             <tr>
                                                <?php $cur = getActiveCurrency(); ?>
                                                <td colspan="5" class="text-right"><b>@lang('messages.keyword_total_fare') : <input type="hidden" name="total_fare" value="{{$bookingdetail->total_fare}}"> <span id="total_fare">{{$bookingdetail->total_fare}}</span> {{ $cur['symbol'] }}</b></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                                <div class="row selected_package_area @if($bookingdetail->is_package==0) none @endif">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h2 for="">{{trans('messages.keyword_selected_package') }}</h2>
                                        </div>
                                        <div id="selected_package">
                                        <?php $clientpackage=explode(',',trim($bookingdetail->package,','));
										?>
                                         @foreach($clientpackage as $customer)
                                         @php $subdetail=explode('->',$customer);@endphp
                                            <h2 class="page-header">{{ $subdetail[0] }}</h2>
                                            <div class="well">
                                          @foreach($packages as $package)
                                          	@if(isset($subdetail[1]) && $package->id==$subdetail[1])
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">{{ $package->name }}</div>
                                                        <div class="panel-body">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <p>{{ $package->description }}</p>
                                                                    <p>{{ $cur['symbol'] }}{{ $package->price }}</p>
                                                                </div>
                                                                    
                                                                <div class="media-right">
                                                                    <button type="button" class="btn btn-danger removePackage" data-price="{{ $package->price }}" data-name="{{ $subdetail[0] }}" data-package="{{ $package->id }}" data-class="package_{{ $package->id }}" onclick="addRemoveToggle(this)"><i class="fa fa-remove"></i> Remove Package</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                    </div>

                                </div>
                                <hr>

                                <?php
                              
                                function customers($bookingdetail,$bookingmember)
                                {
								  $bookinguser=json_decode($bookingmember->details_of_members);
								 // dd($bookinguser);
                                  foreach($bookinguser as $bkey=>$bval):
								  
								  	$adult['type']=($bval->age>=18)?'Adults':'Child';
									$adult['name']=$bval->name;
									$adult['age']=$bval->age;
									$customer[]=$adult;
								
								  endforeach; 
								  //dd($bookingdetail->adults);
								  return $customer;
                                }
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach(customers($bookingdetail,$bookingmember) as $customer)
                                            <h2 class="page-header">{{ $customer['name'] }}</h2>
                                            <div class="well">
                                                @foreach($packages as $package)
                                             
                                                	@if($package->min_age <= $customer['age'] && $package->max_age>=$customer['age'])
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">{{ $package->name }}</div>
                                                        <div class="panel-body">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <p>{{ $package->description }}</p>
                                                                    <p>{{ $cur['symbol'] }}{{ $package->price }}</p>
                                                                </div>
                                                                <div class="media-right">
                                                                    <button type="button" class="btn btn-primary package_{{ $package->id }}_{{ str_replace(' ','_',$customer['name']) }}" data-price="{{ $package->price }}" data-name="{{ $customer['name'] }}" data-package="{{ $package->id }}" data-class="package_{{ $package->id }}_{{ str_replace(' ','_',$customer['name'])}}" onclick="addRemoveToggle(this)"><i class="fa fa-hand-pointer-o"></i> Select Package</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
	<input type="hidden" name="package" id="package" value="{{$bookingdetail->package}}">
    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('booking/managedetail/'.$bookingdetail->id) }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
            </div>

        </div>
    </div>


    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#wizard_category_form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_category_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    }
                }
            });
        });
    </script>

    <script>

        function addRemoveToggle(e)
        {
            $(".selected_package_area").show();
			var pack=$('#package').val();
			var total_package=$('input[name=total_package]');
			var grand_total=$('input[name=grand_total]');
			var total_fare=$('input[name=total_fare]');

            var package_class = $(e).data('class');

            if($(e).hasClass('removePackage'))
            {
                if(confirm('Do you want to remove this package?') == true)
                {
					
                    $("." + package_class).removeClass('removePackage btn-danger');
                    $("." + package_class).addClass('btn-primary');
                    $('.' + package_class).prop("disabled", false);
                    $('.' + package_class).html('<i class="fa fa-hand-pointer-o"></i> Select Package');

                    var price = $('#priceCalculate').text();
					var customername=$(e).data('name');
					
					var packageid=$(e).data('package');
					packdetail=customername+'->'+packageid+',';
					pack = pack.replace(packdetail,'');
					$('#package').val(pack);
					
                    var price_to_minus = $(e).data('price');
                    var total = parseInt(price) - parseInt(price_to_minus);
                    var total = parseInt(price) - parseInt(price_to_minus);
					var total_far=parseInt(total)+ parseInt(grand_total.val());
                    $("#priceCalculate").text(total.toFixed(2));
					total_package.val(total.toFixed(2));
					total_fare.val(total_far.toFixed(2));
					$('#total_fare').text(total_far.toFixed(2));

                    $('.appended_' + package_class).remove();
                    if($("#selected_package").html() == '')
                    {
                        $(".selected_package_area").css('display', 'none');
                    }
                   return false
                }else{ return false; }
            }


            $(e).removeClass('btn-primary');
            $(e).addClass('btn-danger removePackage');
            $(e).html('<i class="fa fa-remove"></i> Remove Package');


            $('.'+ package_class).not(e).html('selected');
            $('.'+ package_class).not(e).prop('disabled', 'disabled');

            /*Addding html to selected_package*/
            var html = $(e).closest('.panel').html();
            var name = $(e).data('name');
            var price = $(e).data('price');
			var packageid=$(e).data('package');
			packdetail=name+'->'+packageid+',';
			pack +=packdetail;
			$('#package').val(pack);


            $('#selected_package').append("<div class='appended_"+ package_class +"'><b>" + name + "</b><br> "  + "<div class='panel panel-default'>" + html + "</div></div>");
            calculatePrice(price);

        }


        function calculatePrice(addPrice)
        {
			var total_package=$('input[name=total_package]');
			var grand_total=$('input[name=grand_total]');
			var total_far=$('input[name=total_fare]');
            var old_price = $("#priceCalculate").text();
            new_price = parseInt(old_price) + parseInt(addPrice);
            $("#priceCalculate").text(new_price.toFixed(2));
			var total_fare=parseInt(new_price)+ parseInt(grand_total.val());
			
			total_package.val(new_price.toFixed(2));
			$('#total_fare').text(total_fare.toFixed(2));
			total_far.val(total_fare.toFixed(2));
			
        }

    </script>

@endsection

