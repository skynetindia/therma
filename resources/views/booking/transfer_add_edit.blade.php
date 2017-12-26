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


    <?php $arrlanguages = getlanguages();?>



      {{  Form::open(array('url' => 'booking/savetransfer', 'files' => true, 'id' => 'wizard_category_form')) }}

	<a href="{{url('bookings')}}">@lang('messages.keyword_skip')</a>
    <input type="hidden" name="transfer_id" value="{{isset($transfer->id) ? $transfer->id : ''}}">
     <input type="hidden" name="hotel_id" value="{{isset($transfer->booking_id) ? $transfer->booking_id :$bookingdetail->hotel_id}}">
      <input type="hidden" name="booking_id" value="{{isset($transfer->booking_id) ? $transfer->booking_id : $bookingdetail->id}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <h1 class="user-profile-heading">
                                    @if(isset($action) && $action == 'edit') @lang('messages.keyword_update_transfer')@else @lang('messages.keyword_add_transfer') @endif
                                </h1><hr>
                                <div class="row">
									<div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_booking_id') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($bookingdetail->temp_booking_id)) ? $bookingdetail->temp_booking_id : generateTransferId(10)}}" name="temp_booking_id" id="temp_booking_id" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_id') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->unique_transfer_id)) ? $transfer->unique_transfer_id : generateTransferId(10)}}" name="unique_transfer_id" id="unique_transfer_id" type="text" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_client') @lang('messages.keyword_name') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($bookingdetail->name)) ? $bookingdetail->name : ''}}" name="client_name" id="client_name" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_client') @lang('messages.keyword_phone') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($bookingdetail->phone)) ? $bookingdetail->phone : ''}}" name="client_phone" id="phone" type="text">
                                        </div>
                                    </div>

                               
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_direction') <span class="required">(*)</span></label>
                                            <select name="direction" id="direction" class="form-control">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="1" {{ (isset($transfer->direction) && $transfer->direction == '1') ? 'selected' : '' }}>@lang('messages.keyword_arrival')</option>
                                                <option value="0" {{ (isset($transfer->direction) && $transfer->direction == '0') ? 'selected' : '' }}>@lang('messages.keyword_departure')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_type') <span class="required">(*)</span></label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="1" {{ (isset($transfer->type) && $transfer->type == '1') ? 'selected' : '' }}>@lang('messages.keyword_group')</option>
                                                <option value="0" {{ (isset($transfer->type) && $transfer->type == '0') ? 'selected' : '' }}>@lang('messages.keyword_individual')</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_pax') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->pax)) ? $transfer->pax :($bookingdetail->adults+$bookingdetail->children)}}" name="pax" id="pax" type="text">
                                        </div>
                                    </div>
                              

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_start') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->start)) ? $transfer->start : ''}}" name="start" id="start" type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_transfer') @lang('messages.keyword_destination') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->destination)) ? $transfer->destination : ''}}" name="destination" id="destination" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_client_status') <span class="required">(*)</span></label>
                                            <select name="client_status" id="client_satatus" class="form-control">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getClientStatus() as $key => $status)
                                                    <option value="{{ $key }}" {{ (isset($transfer->type) && $transfer->type == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>


                               

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_flight_time') <span class="required">(*)</span></label>
                                            <div style="position:relative">
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->flight_time)) ? date('Y-m-d h:i A',strtotime($transfer->flight_time)) : ''}}" name="flight_time" id="flight_time" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_flight') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->flight)) ? $transfer->flight : ''}}" name="flight" id="flight" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_pickup_time') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->pickup_time)) ? date('Y-m-d h:i A',strtotime($transfer->pickup_time)) : ''}}" name="pickup_time" id="pickup_time" type="text">
                                        </div>
                                    </div>

                               

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_arrival') <span class="required">(*)</span></label>
                                            <input class="form-control datepicker" placeholder="" value="{{(isset($transfer->arrival)) ? $transfer->arrival : date('m/d/Y',strtotime($bookingdetail->arrival))}}" name="arrival" id="arrival" type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_departure') <span class="required">(*)</span></label>
                                            <input class="form-control datepicker" placeholder="" value="{{(isset($transfer->departure)) ? $transfer->departure : date('m/d/Y',strtotime($bookingdetail->departure))}}" name="departure" id="departure" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="" value="{{(isset($transfer->price)) ? $transfer->price : ''}}" name="price" id="price" type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_notes') <span class="required">(*)</span></label>
                                            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control">{{(isset($transfer->notes)) ? $transfer->notes: ''}}</textarea>
                                        </div>
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
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('transfer/list') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>

        </div>
    </div>
    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#wizard_category_form").validate({
                rules: {
                    client_name: {
                        required: true,
                        maxlength: 50
                    },
                    client_phone: {
                        required: true,
                    },
					direction:"required",
					type:"required",
					pax:"required",
					start:"required",
					destination:"required",
					client_status:"required",
					filght:"required",
					flight_time:"required",
					pickup_time:"required",
					arrival:"required",
					departure:"required",
					price: {
                        required: true,
                        numeric: true
                    },
					
					
					
                },
                messages: {
                    client_name: {
                        required: "{{trans('messages.keyword_please_enter_a_client_name')}}",
                        maxlength: "{{trans('messages.keyword_client_name_must_be_less_than_50_characters')}}"
                    },
                    client_phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone')}}"

                    },
					direction:"{{trans('messages.keyword_please_enter_transfer_direction')}}",
					type:"{{trans('messages.keyword_please_enter_transfer_type')}}",
					pax:"{{trans('messages.keyword_please_enter_ptax')}}",
					start:"{{trans('messages.keyword_please_enter_transfer_start_point')}}",
					destination:"{{trans('messages.keyword_please_enter_transfer_destination_point')}}",
					client_status:"{{trans('messages.keyword_please_select_client_status')}}",
					filght:"{{trans('messages.keyword_please_enter_flight_name')}}",
					flight_time:"{{trans('messages.keyword_please_enter_flight_time')}}",
					pickup_time:"{{trans('messages.keyword_please_enter_pickup_time')}}",
					arrival:"{{trans('messages.keyword_please_enter_arrival_date')}}",
					departure:"{{trans('messages.keyword_please_enter_departure_date')}}",
					price: {
                        required: "{{trans('messages.keyword_please_enter_transfer_price')}}",
                        numeric: "{{trans('messages.keyword_please_enter_number')}}"
                    },
                }
            });
        });

        $(document).ready(function(){
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });

           

        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#pickup_time,#flight_time').datetimepicker({
				   
					
					
					format: 'YYYY-MM-DD hh:mm A'

			});
        });
    </script>
   <link rel="stylesheet" href="{{ asset('public/css/bootstrap-datetimepicker.css') }}">
    <script src="{{ asset('public/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-datetimepicker.js') }}"></script>
@endsection