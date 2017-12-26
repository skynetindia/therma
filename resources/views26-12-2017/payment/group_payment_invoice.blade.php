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
    <link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('public/js/select2.full.min.js')}}"></script>
    <?php
    $cur = getActiveCurrency();
    $user_type = getUserTypeByUsertypeId(Auth::user()->profile_id);
    
    ?>
    
    
    <div class="grouping-payment-invoice">
        
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm1-12 col-xs-12">
                    
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">@lang('messages.keyword_grouping_payment_invoice')</h1>
                            
                            
                            <div class="panel panel-default">
                                
                                <div class="panel-heading">
                                    <div class="heading-search-dashboard">
                                        {{ Form::open(array('url' => 'payment/group-invoices', 'files' => true, 'id' => 'payment_group_invoices_form')) }}
                                        <div class="form-wrap">
                                            <input type="hidden" name="search" value="1">
                                            <div class="reservation-list-widthcalc">
                                            <div class="input form-group">
                                                    
                                                        <label>@lang('messages.keyword_invoice')</label>
                                                        <input type="text" id="invoiceid" name="invoiceid" value="{{isset($post->invoiceid)?$post->invoiceid:''}}" class="form-control" placeholder="@lang('messages.keyword_invoice')"/>
                                                </div>
                                                
                                                <div class="input form-group select-container">
                                                    <label>@lang('messages.keyword_country')</label>
                                                    <select class="form-control bg-arrow select2" name="country" id="country">
                                                       <option value="">{{trans('messages.keyword_country')}}</option>
                                                        @foreach($country as $conkey=>$conval)
                                                        <option value="{{$conval->i_id}}" {{(isset($post->country)&& $post->country==$conval->i_id)?'selected':''}}>{{$conval->v_name}}</option>
                                                @endforeach
                                                    </select>
                                                </div>
                                                 <div class="input form-group select-container">
                                                    <label>@lang('messages.keyword_state')</label>
                                                    <select class="form-control bg-arrow select2" name="state" id="state">
                                                       <option value="">{{trans('messages.keyword_state')}}</option>
                                                        @foreach($state as $statkey=>$statval)
                                                        <option value="{{$statval->i_id}}" {{(isset($post->state)&& $post->state==$statval->i_id)?'selected':''}}>{{$statval->v_name}}</option>
                                                @endforeach
                                                    </select>
                                                </div>
                                                 <div class="input form-group select-container">
                                                    <label>@lang('messages.keyword_city')</label>
                                                    <select class="form-control bg-arrow select2" name="city" id="city">
                                                       <option value="">{{trans('messages.keyword_city')}}</option>
                                                        @foreach($city as $citkey=>$citval)
                                                        <option value="{{$citval->i_id}}" {{(isset($post->city)&& $post->city==$citval->i_id)?'selected':''}}>{{$citval->v_name}}</option>
                                                @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="input form-group select-container">
                                                    <label>@lang('messages.keyword_hotel')</label>
                                                    <select class="form-control bg-arrow select2" name="hotelid" id="hotelid">
                                                        <option value="">{{trans('messages.keyword_hotel')}}</option>
                                                        @foreach($hotels as $hotelkey=>$hotelval)
                                                        <option value="{{$hotelval->id}}" {{(isset($post->hotelid)&& $post->hotelid==$hotelval->id)?'selected':''}}>{{$hotelval->name}}</option>
                                                @endforeach
                                                    </select>
                                                </div>
                                                
                                               
                                                
                                                <div class="input form-group">
                                                    
                                                        <label>@lang('messages.keyword_date_range')</label>
                                                        <input type="text" id="example1" name="startdate" value="{{date('m-Y')}}" class="form-control monthpicker"/>
                                                </div>
                                            
                                            </div>
                                            
                                            <div class="dashbord-filter inline-block pull-right">
                                                <button type="submit" class="btn btn-default">@lang('messages.keyword_filter')</button>
                                                <button  type="reset" class="btn btn-default"><i class="fa fa-times"
                                                                                       aria-hidden="true"></i></button>
                                            </div>
                                        
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                
                                
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        
                                         @php $daterange=(isset($post->startdate))?$post->startdate:date('m-Y');@endphp
                                        <table id="main_table" class="table table-striped table-bordered payment-invoice-tbl" width="100%" cellspacing="0">
                                            {{--Main Table Heading--}}
                                            <thead>
                                            <tr class="hotellist">
                                                <th>@lang('messages.keyword_hotel')</th>
                                                <th>@lang('messages.keyword_state') / @lang('messages.keyword_city')</th>
                                                <th>@lang('messages.keyword_reservation')</th>
                                                <th>@lang('messages.keyword_total_price')</th>
                                                <th>@lang('messages.keyword_commission') @lang('messages.keyword_total')</th>
                                                <th>@lang('messages.keyword_last_status')</th>
                                                <th>@lang('messages.keyword_invoice')</th>
                                                <th>@lang('messages.keyword_reservation')</th>
                                            </tr>
                                            </thead>
                                            
                                            <tbody>
                                            
                                            {{--Loop--}}
                                            
                                            @foreach($hotels as $hotel)
                                                
                                                {{--Calculation for table heading total price and commissions--}}
                                                @php $total_price = 0; @endphp
                                                @if(count(getBookingAndPaymentDetail($hotel->id,$daterange)) >0)
                                                    @foreach(getBookingAndPaymentDetail($hotel->id,$daterange) as $value)
                                                        @php $total_price += $value->total_fare @endphp
                                                    @endforeach
                                                @endif
                                                @php
                                                    $total_commission = ((int)$total_price * ($hotel->commission)) / 100;
                                                    $bookings_count = count(getBookingAndPaymentDetail($hotel->id,$daterange));
                                                @endphp
                                                {{--Calculation for table heading total price and commissions--}}
                                                
                                                <tr class="hotellist">
                                                    <td>{{ toUcWord($hotel->name) }} ({{ $hotel->id }})</td>
                                                    <td> {{ getState($hotel->state) }}
                                                        / {{ getCity($hotel->city) }}</td>
                                                    <td data-booking-count="{{ ( $bookings_count >0) ? $bookings_count : 0 }}"> {{ ( $bookings_count >0) ? $bookings_count : '--' }} </td>
                                                    <td data-total-price="{{ $total_price }}">
                                                        {{--Total Price Field, only available when bookings count bigger than 0--}}
                                                        {{ ($bookings_count > 0) ? $total_price."".$cur['symbol'] : "--" }}
                                                    </td>
                                                    <td data-commission-total="{{ $total_commission }}">
                                                        {{--Commissions Total Field, only available when bookings count bigger than 0--}}
                                                        @if($bookings_count > 0)
                                                            {{ $total_commission }}{{ $cur['symbol'] }}
                                                            ({{ $hotel->commission }}%)
                                                        @else -- @endif
                                                    </td>
                                                    <td>
                                                        @php $last_invoice_status = getLastPaymentInvoice($hotel->id,$daterange); @endphp
                                                        @if(count($last_invoice_status) > 0 && $last_invoice_status->hotel_id == $hotel->id)
                                                            @if($last_invoice_status->is_requested == '1' || $last_invoice_status->is_requested == '0')
                                                                @php $pro_type =  getUserTypeIdByUserId($last_invoice_status->requester_id); @endphp
                                                                @if($pro_type == '0')
                                                                    <span class="text-primary"><i class="fa fa-bullhorn"
                                                                                                  aria-hidden="true"></i> @lang('messages.keyword_requested_by_admin')</span>
                                                                @else
                                                                    <span class="text-primary"><i class="fa fa-bullhorn"
                                                                                                  aria-hidden="true"></i> @lang('messages.keyword_requested_by_hotel_manager')</span>
                                                                @endif
                                                            
                                                            @else
                                                                @php $pro_type = getUserTypeIdByUserId($last_invoice_status->requester_id); @endphp
                                                                @if($pro_type == '0')
                                                                    <span class="green"><i class="fa fa-check"
                                                                                           aria-hidden="true"></i> @lang('messages.keyword_confirmed_by_admin')</span>
                                                                @else
                                                                    <span class="green"><i class="fa fa-check"                                                                                          aria-hidden="true"></i> @lang('messages.keyword_confirmed_by_hotel_manager')</span>
                                                                @endif
                                                            @endif
                                                        @elseif ($bookings_count >0)
                                                            <span class="red"><i class="fa fa-exclamation-triangle"
                                                                                 aria-hidden="true"></i> @lang('messages.keyword_pending')</span>
                                                        @else
                                                            --
                                                        @endif
                                                    
                                                    
                                                    </td>
                                                    <td>
                                                        @php 
                                                            $href = (isset($hotel->invoiceid)) ? url('payment/request/invoice/')."/".$hotel->invoiceid : 'javascript:void(0)' ; @endphp
                                                        @if(isset($hotel->invoiceid))
                                                            <span class="{{ (isset($hotel->invoiceid)) ? 'green' : 'red' }}">
                                                                <i class="fa fa-{{ (isset($hotel->invoiceid)) ? 'check-circle' : 'minus-circle' }}" aria-hidden="true"></i>
                                                                <a href="{{ $href }}"  class="{{ (isset($hotel->invoiceid)) ? 'green' : 'red' }}">{{ (isset($hotel->invoiceid))?$hotel->invoiceid:'--'}}</a> </span>
                                                            <span class="green getCommissionPaid_{{ $hotel->id }}"></span>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="reservation-second-tbl"
                                                           data-toggle="collapse" data-target="#reservation_{{$hotel->id}}">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                            Reservation</a>
                                                    </td>
                                                </tr>
                                                <tr id="reservation_{{ $hotel->id }}" class="collapse">
                                                    <td colspan="8"><br>
                                                        
                                                        {{--This button only shows when invoices available--}}
                                                        @if(count(getBookingAndPaymentDetail($hotel->id,$daterange)) >0)
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm1-12 col-xs-12">
                                                                    <div class="table-btn">
                                                                        <button class="btn btn-default btn-6-12" onclick="multipleAction('confirm_payment')">
                                                                            <i class="fa fa-money"></i>
                                                                            @lang('messages.keyword_confirm_payment') </button>
                                                                        <button class="btn btn-info btn-6-12" onclick="multipleAction('send_request')">
                                                                            <i class="fa fa-paper-plane"></i>
                                                                            @lang('messages.keyword_send_request')
                                                                        </button>
                                                                        <button class="btn btn-default btn-6-12 checkAllInvoices" data-id="check_all_{{ $hotel->id }}" >
                                                                            <i class="fa fa-check-square-o"></i>
                                                                            @lang('messages.keyword_select_all')
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        {{--This button only shows when invoices available--}}
                                                        
                                                        <table data-toggle="table" data-search="true"
                                                               data-pagination="true" data-id-field="id"
                                                               data-show-refresh="true" data-show-columns="true"
                                                               data-classes="table table-bordered"
                                                               data-show-export="true" class="inner_table">
                                                           
                                                            <thead>
                                                            <tr>
                                                                <th>@lang('messages.keyword_id')</th>
                                                                <th class="none"></th>
                                                                <th class="none"></th>
                                                                <th>@lang('messages.keyword_client')</th>
                                                                <th>@lang('messages.keyword_created')</th>
                                                                <th>@lang('messages.keyword_arrival')</th>
                                                                <th>@lang('messages.keyword_departure')</th>
                                                                <th>@lang('messages.keyword_price')</th>
                                                                <th>@lang('messages.keyword_commission_system') (%)</th>
                                                                <th>@lang('messages.keyword_commission_paid')</th>
                                                                <th>@lang('messages.keyword_remaining_commission')</th>
                                                                <th>@lang('messages.keyword_payment_type')</th>
                                                                <th>@lang('messages.keyword_confirmed')</th>
                                                            
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                           
                                                            @forelse(getBookingAndPaymentDetail($hotel->id,$daterange) as $booking)
                                                                
                                                                <?php $dis = ($booking->is_requested == 1 && $booking->confirm == '0' && $booking->requester_id == Auth::user()->id) ? 'disabled' : ''; ?>
                                                                
                                                                
                                                                <tr class="check_all_{{ $hotel->id }} {{ $dis }}"
                                                                    data-booking-id="{{ $booking->id }}">
                                                                    <td>{{ $booking->id }}</td>
                                                                    <td class="none">{{ $booking->is_payment_online }}</td>
                                                                    <td class="none">{{ $booking->is_requested }}</td>
                                                                    <td>{{ toUcWord($booking->name) }}</td>
                                                                    <td>{{ $booking->create_date }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($booking->arrival)->format('d.m.Y')  }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($booking->departure)->format('d.m.Y')  }}</td>
                                                                    <td>{{ $booking->total_fare }}{{ $cur['symbol'] }}</td>
                                                                    <td>
                                                                        @php
                                                                            $commission_price = ((int) $booking->total_fare * (int) $booking->hotel_commission ) / 100;
                                                                            echo $commission_price."".$cur['symbol']." (".$booking->hotel_commission.")%";
                                                                        @endphp
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            if($booking->commission_paid > 0 && $booking->confirm == '1'){
                                                                                if($booking->commission_remaining_price == '0'):
                                                                                    echo "<span class='green'>".$booking->commission_paid."".$cur['symbol']."</span>";
                                                                                else:
                                                                                    echo "<span class='red'>".$booking->commission_paid."".$cur['symbol']." (".$booking->reason_incomplete_payment.")</span>";
                                                                                endif;
                                                                            }else{
                                                                                echo "--";
                                                                            }
                                                                        
                                                                        @endphp
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            if(isset($booking->commission_remaining_price) && $booking->confirm == '1'){
                                                                                if($booking->commission_remaining_price == '0'){
                                                                                    echo "<span class='green'>".$booking->commission_remaining_price."".$cur['symbol']."</span>";
                                                                                }else{
                                                                                    echo "<span class='red'>".$booking->commission_remaining_price."".$cur['symbol']."</span>";
                                                                                }
                                                                            }else{
                                                                                echo '--';
                                                                            }
                                                                        @endphp
                                                                    
                                                                    </td>
                                                                    
                                                                    <td>{{ (isset($booking->is_payment_online) && $booking->is_payment_online == '0') ? 'Cash' : 'Online' }}</td>
                                                                    
                                                                    <td>
                                                                        
                                                                        @if(isset($booking->is_payment_online) && $booking->is_payment_online == '0' && $booking->is_requested=='1' && $user_type->id == 1)
                                                                            
                                                                            {{--Swith will disabled when payment confirmed or checked by database dafault--}}
                                                                            @php
                                                                                $checkedAndDisabled = (isset($booking->confirm) && $booking->confirm == '1') ? 'checked disabled' : '';
                                                                            @endphp
                                                                            {{-- Data max payable price used in modal to prevent user to enter bigger amount then given--}}
                                                                            <div class="switch">
                                                                                <input value="" class="booking_switch"
                                                                                       name=""
                                                                                       id="booking_switch_{{ $booking->id }}"
                                                                                       data-max-payable-price="{{ $commission_price }}"
                                                                                       onclick="showPaymentConfirmModal(this)"
                                                                                       type="checkbox" {{ $checkedAndDisabled }} >
                                                                                <label for="booking_switch_{{ $booking->id }}"></label>
                                                                            </div>
                                                                        
                                                                        @elseif(isset($booking->is_payment_online) && $booking->is_payment_online == '1' && $booking->is_requested == '1' && $user_type->id == 0)
                                                                            
                                                                            {{--Swith will disabled when payment confirmed or checked by database dafault--}}
                                                                            @php
                                                                                $checkedAndDisabled = (isset($booking->confirm) && $booking->confirm == '1') ? 'checked disabled' : '';
                                                                            @endphp
                                                                            <div class="switch">
                                                                                <input value="" class="booking_switch"
                                                                                       name=""
                                                                                       id="booking_switch_{{ $booking->id }}"
                                                                                       data-max-payable-price="{{ $commission_price }}"
                                                                                       onclick="showPaymentConfirmModal(this)"
                                                                                       type="checkbox" {{ $checkedAndDisabled }} >
                                                                                <label for="booking_switch_{{ $booking->id }}"></label>
                                                                            </div>
                                                                        
                                                                        @elseif($booking->is_requested == '1')
                                                                            <strong class="red">@lang('messages.keyword_requested')</strong>
                                                                        @elseif($booking->is_requested == '2')
                                                                            <strong class="green">@lang('messages.keyword_confirmed')</strong>
                                                                        @else
                                                                            --
                                                                        @endif
                                                                    </td>
                                                                
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11"
                                                                        class="text-center">@lang('messages.keyword_no_bookings_found')</td>
                                                                </tr>
                                                            @endforelse
                                                            
                                                            
                                                            </tbody>
                                                            
                                                            {{-- Table foot only available when bookings count bigger than 0--}}
                                                            @if($bookings_count > 0)
                                                                
                                                                @php
                                                                    $commission_payments = getAfterPaymentFromPaymentInvoice($hotel->id);
                                                                    $commission_paid = '0';
                                                                    $remaining_commission = '0';
                                                                @endphp
                                                                
                                                                @if(count($commission_payments) > 0)
                                                                    @foreach($commission_payments as $payment)
                                                                        @php
                                                                            $commission_paid += $payment->commission_paid;
                                                                            $remaining_commission += $payment->remaining_price;
                                                                        @endphp
                                                                    @endforeach
                                                                @else
                                                                    @php $commission_paid = '0';$remaining_commission = '0';  @endphp
                                                                @endif
                                                                
                                                                <tfoot>
                                                                <th>--</th>
                                                                <th>--</th>
                                                                <th>--</th>
                                                                <th>--</th>
                                                                <th>--</th>
                                                                <th>
                                                                    {{--Total Price Field, only available when bookings count bigger than 0--}}
                                                                    {{ ($bookings_count > 0) ? $total_price."".$cur['symbol'] : "--" }}
                                                                </th>
                                                                <th>
                                                                    {{--Commissions Total Field, only available when bookings count bigger than 0--}}
                                                                    @if($bookings_count > 0)
                                                                        {{ $total_commission }}{{ $cur['symbol'] }}
                                                                        ({{ $hotel->commission }}%)
                                                                    @else -- @endif
                                                                </th>
                                                                <th data-commission-paid="{{ $commission_paid }}"
                                                                    data-class="getCommissionPaid_{{ $hotel->id }}"
                                                                    class="sendValueToInvoice">{{ ($commission_paid != '0') ? $commission_paid."".$cur['symbol'] : '--' }}</th>
                                                                <th>{{ ($remaining_commission != '0') ? $remaining_commission."".$cur['symbol'] : '--' }}</th>
                                                                <th>--</th>
                                                                <th>--</th>
                                                                </tfoot>
                                                            @endif
                                                        
                                                        </table>
                                                    </td>
                                                
                                                
                                                </tr>
                                            @endforeach
                                            {{--Loop--}}
                                            
                                            </tbody>
                                            
                                            <tfoot>
                                            <tr>
                                                <th>--</th>
                                                <th>--</th>
                                                <th id="booking_count">--</th>
                                                <th id="total_price">--</th>
                                                <th id="commission_total">--</th>
                                                <th>--</th>
                                                <th>--</th>
                                                <th>--</th>
                                            </tr>
                                            </tfoot>
                                        
                                        
                                        </table>
                                    
                                    
                                    </div>
                                
                                </div>
                            </div>
                        
                        
                        </div>
                    </div>
                
                </div>
            
            </div>
        </div>
    
    </div>
    
    
    
    <div class="clearfix"></div>
    
    {{--=============Validation Js =================--}}
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>
	 $('#country').change(function(e){
		 $.post("{{url('check-country')}}",
				{'country':$(this).val(), '_token': "{{ csrf_token() }}"},
				function(data){
				$('#state').html(data);
				$('#state').select2();
				});
	});
    $('#state').change(function(e){
    	$.post("{{url('check-state')}}",
				{'state':$(this).val(), '_token': "{{ csrf_token() }}"},
				function(data){
				$('#city').html(data);
				$('#city').select2();
				});
    });
	$('.select2').each(function(index, element) {
        $(this).select2({
			dropdownParent:$(this).parent('.select-container')
		});
		
    });
	$(".monthpicker").datepicker( {
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
});
        $("#paymentConfirmModalForm").validate({
            rules: {
                payable_commission_price: {
                    required: true,
                    number: true
                },
                reason_incomplete_payment: {
                    required: true,
                    maxlength: 50
                }
            },
            messages: {
                payable_commission_price: {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                reason_incomplete_payment: {
                    required: "@lang('messages.keyword_please_enter_a_reason')",
                    maxlength: "@lang('messages.keyword_please_enter_no_more_than_50_characters')"
                }
            }
        });
    </script>
    {{--=============Validation Js =================--}}
    
    
    {{--===========Document on ready functions============--}}
    <script>
        $(document).ready(function () {
            $('.reservation-second-tbl').click(function () {
                $(this).find('.fa').toggleClass('fa-plus fa-minus');
            });
        });
    </script>
    {{--===========Document on ready functions============--}}
    
    {{--==========Inner Table Js=====================--}}
    <script>
        var selezione = [];
        var indici = [];
        var n = 0;


        $('.inner_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
            var check_payment = /\d+/.exec($(el[0]).children()[1].innerHTML);
            var check_id_requested = /\d+/.exec($(el[0]).children()[2].innerHTML);
			
            
            //sending booking id to the modal for getting records after submitting modal form
            $("#booking_id_for_modal").val(cod);


            if (!selezione[cod]) {
				
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

            }
        });

        $(".checkAllInvoices").on("click", function () {
            var check_id = $(this).data('id');
            if ($("." + check_id).hasClass("selected")) {
                $("." + check_id).removeClass("selected");
                n = 0;
                indici = [];
            } else {
                n = 0;
                indici = [];
                $("." + check_id).each(function () {
                    $(this).addClass("selected");
                    var cod = $(this).data('booking-id');
                    indici[n] = cod;
                    n++;
                });
            }
        });


        function check_confirm_payment() {
            return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_do_full_payment_of_selected_booking_invoices')}}");
        }

        function check_send_request() {
            return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_send_request_of_selected_booking_invoices')}}");
        }

        function checkRecordSelected() {
            alert('{{ trans('messages.keyword_please_select_atleast_one_record') }}');
            $(".inner_table tbody tr.selected").removeClass("selected");
            n = 0;
            indici = [];selezione=[];
            return false;
        }

        function checkPaymentType() {

            //below functions is used for selecting records filtered with superadmin and hotel manager
            //admin can not select online payment record and hotel manager can not select cash payment record to request
            var condition = 0;
            $(".inner_table tbody tr.selected").each(function () {
                var check_val = $(this).children().eq(1).text();
                @if(Auth::user()->profile_id == '0')
                if (check_val == '1') {
                    alert("{{ trans('messages.keyword_you_can_only_request_payment_those_records_whose_payment_done_with_cash_or_debit_cards') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }
                @else(Auth::user()->id == '1')
                if (check_val == '0') {
                    alert("{{ trans('messages.keyword_you_can_only_request_payment_those_records_whose_payment_done_online') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }
                @endif
            });
            return (condition == 0) ? true : false;
        }


        function checkRequestedInvoice() {
            var condition = 0;
            $(".inner_table tbody tr.selected").each(function () {
                var check_val = $(this).children().eq(2).text();
                if (check_val == '0' || check_val == '') {
                    alert("{{ trans('messages.keyword_invoice_not_requested_yet') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }
                if (check_val == '2') {
                    alert("{{ trans('messages.keyword_payment_already_confirmed') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }

            });
            return (condition == 0) ? true : false;
        }

        function checkSendRequestedInvoice() {
            var condition = 0;
            $(".inner_table tbody tr.selected").each(function () {
                var check_val = $(this).children().eq(2).text();
                if (check_val == '1') {
                    alert("{{ trans('messages.keyword_invoice_already_requested') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }
                if (check_val == '2') {
                    alert("{{ trans('messages.keyword_payment_already_confirmed') }}");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0;
                    indici = [];selezione=[];
                    condition++;
                }

            });
            return (condition == 0) ? true : false;
        }


        function checkConfirmPayment() {

            //below functions is used for selecting records filtered with superadmin and hotel manager
            //admin can not select online payment record and hotel manager can not select cash payment record to request
            var condition = 0;
            $(".inner_table tbody tr.selected").each(function () {
                var check_val = $(this).children().eq(1).text();
                @if(Auth::user()->profile_id == '0')
                if (check_val == '0') {
                    alert("You can only confirm those payment whose payment done online");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0; indici = [];selezione=[];
                    condition++;
                }
                @else(Auth::user()->id == '1')
                if (check_val == '1') {
                    alert("You can only confirm those payment whose payment done with cash or debit card");
                    $(".inner_table tbody tr.selected").removeClass("selected");
                    n = 0; indici = [];selezione=[];
                    condition++;
                }
                @endif
            });
            return (condition == 0) ? true : false;
        }

        function multipleAction(act) {
            var error = false;
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });


            switch (act) {
                case 'confirm_payment':
				
                    if (n == '0') {
                        checkRecordSelected();
                        break;
                    }
					
                    if (checkRequestedInvoice() == false) {
						
                        break;
                    }
                    if (checkConfirmPayment() == false) {
                        break;
                    }


                    link.href = "{{ url('payment/confirm/multiple') }}" + '/';

                    if (check_confirm_payment()) {
                        for (var i = 0; i < n; i++) {
                            $.ajax({
                                type: "GET",
                                url: link.href + indici[i],
                            });
                            
                        }
                        selezione = undefined;
                        setTimeout(function () {
                            location.reload();
                        }, 100 * n);
                        n = 0;
                    }
                    break;
                case 'send_request':
                    if (n == '0') {
                        checkRecordSelected();
                        break;
                    }
						
                    if (checkSendRequestedInvoice() == false){
                        return false;
					}
                    if (checkPaymentType() == false)
                        return false;

                    link.href = "{{ url('payment/send/multiple') }}" + '/'+$('#example1').val()+'/';

                    if (check_send_request()) {

                        for (var i = 0; i < n; i++) {

                            $.ajax({
                                type: "GET",
                                url: link.href + indici[i],
                            });
                          
                        }
                        selezione = undefined;
                        setTimeout(function () {
                            location.reload();
                        }, 100 * n);
                        n = 0;
                    }
                    break;
            }
        }
    
    
    </script>
    {{--==========Inner Table Js=====================--}}
    
    {{--==========Modal Js ====================--}}
    <script>
        function showPaymentConfirmModal(e) {
            $(e).prop("checked", false);
            var max_payable_price = $(e).data('max-payable-price');
            max_payable_price = Math.round(max_payable_price);

            // showing max value on modal show
            $('#max_payable_price').val(max_payable_price);

            //storing value for comparison in modal on change price , used in preventBiggerAmount function
            $('#storeMaxAmountForComparison').val(max_payable_price);

            // dynamic value in modal for not
            $('#showMaxAmountForNote').text(max_payable_price);

            $("#paymentConfirmModal").modal('show');
        }

        function preventBiggerAmount(e) {
            $(".max_value_error").remove();
            var max_value = $("#storeMaxAmountForComparison").val();
            var field_value = $(e).val();

            if (parseFloat(field_value) > parseInt(max_value)) {
                $(e).val(max_value);
                alert('{{ trans('messages.keyword_maximum_payable_amount_for_this_booking_is') }} ' + max_value);
                $("#reason_incomplete_payment").hide();
            } else if (parseFloat(field_value) < parseInt(max_value)) {
                $("#reason_incomplete_payment").show();
            } else {
                $("#reason_incomplete_payment").hide();
            }
        }
    </script>
    {{--========== Modal Js ====================--}}'


    <script>
        $(document).ready(function () {
            var total_price = 0;
            commission_total = 0;
            booking_count = 0;
            $("#main_table tbody tr.hotellist").each(function () {

                if (typeof $(this).attr('id') === "undefined") {
                    var price = $(this).children().eq(3).data('total-price');
                    total_price += parseFloat(price);
                    var cm = $(this).children().eq(4).data('commission-total');
                    commission_total += parseFloat(cm);

                    var b_count = $(this).children().eq(2).data('booking-count');
                    booking_count += parseInt(b_count);
                }
            });
            $("#commission_total").text(parseFloat(commission_total).toFixed(2) + '' + '{{ $cur["symbol"] }}');
            $("#total_price").text(parseFloat(total_price).toFixed(2) + '' + '{{ $cur["symbol"] }}');
            $("#booking_count").text(parseInt(booking_count));
        });
    </script>



    <script>
        $(document).ready(function () {


            $(".sendValueToInvoice").each(function () {
                var classSend = $(this).data('class');
                var commissionValue = $(this).data('commission-paid');
                //alert(commissionValue);
                $("." + classSend).text('(' + commissionValue + '' + '{{ $cur['symbol'] }}' + ')');
            });
        });
    </script>

    <script>
        $('.datepicker_month_year').datepicker({
            format: "mm/yyyy",
            endDate: '+30d',
        }).datepicker();
        
    </script>
@endsection






<!-- Modal -->
<div id="paymentConfirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => 'payment/confirm/', 'files' => true, 'id' => 'paymentConfirmModalForm', 'method'=> 'post')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">@lang('messages.keyword_confirm') @lang('messages.keyword_payment')</h4>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="storeMaxAmountForComparison" value="">
                
                <div class="form-group">
                    <label for="Commission Price">@lang('messages.keyword_payable_commission_price') <span
                                class="required">(*)</span></label>
                    <div class="input-group">
                        <input type="text" name="payable_commission_price" id="max_payable_price" value=""
                               onchange="preventBiggerAmount(this)" class="form-control">
                        <span class="input-group-addon"><strong>{{ $cur['symbol'] }}</strong></span>
                    </div>
                    <div class="help-block">{{ trans('messages.keyword_maximum_payable_amount_for_this_booking_is') }}
                        <strong><span id="showMaxAmountForNote"></span></strong> {{ $cur['symbol'] }}</div>
                </div>
                
                <div class="form-group none" id="reason_incomplete_payment">
                    <label for="Discription">@lang('messages.keyword_reason_for_incomplete_payment') <span
                                class="required">(*)</span></label>
                    <textarea name="reason_incomplete_payment" class="form-control" id="" row="3"
                              style="resize: vertical;"></textarea>
                </div>
            
            </div>
            
            <div class="modal-footer">
                <input type="hidden" name="booking_id" id="booking_id_for_modal" value="">
                <button type="submit" class="btn btn-default" onclick="">@lang('messages.keyword_send')</button>
            </div>
            {{ Form::close() }}
        </div>
    
    </div>
</div>

