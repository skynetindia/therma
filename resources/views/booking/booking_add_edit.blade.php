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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <?php $arrlanguages = getlanguages();?>

    <?php
        echo Form::open(array('url' => 'booking/update', 'files' => true, 'id' => 'add_booking_form'));
    ?>

    <input type="hidden" name="booking_id" value="{{isset($booking->id) ? $booking->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

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
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" >
                                        <label for="">@lang('messages.keyword_select_user') <span class="required">(*)</span></label>
                                        <select class="form-control" name="user" id="user">
                                            <option value="">@lang('messages.keyword_--select--')</option>
                                            @foreach(getUsers() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_select_hotel') <span class="required">(*)</span></label>
                                        <select class="form-control" name="hotel" id="hotel" onchange="fetchHotelWiseRooms(this)">
                                            <option value="">@lang('messages.keyword_--select--')</option>
                                            @foreach(getHotels() as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{--Don't remove this from here--}}
                                    <div id="select_rooms"></div>

                                    <div class="form-group">
                                        <div id="fetchRoomDetails"></div>
                                    </div>
                                    {{--Don't remove this from here--}}


                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_booking_id')</label>
                                        <input required class="form-control" id="" placeholder=""
                                               type="text" name="unique_booking_id" value="{{ generateBookingId(6) }}" readonly>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_arrival') <span
                                                            class="required">(*)</span></label>
                                                <input type="text" id="start_date" value="{{ old('arrival') }}" name="arrival" placeholder="YYYY-MM-DD" class="form-control" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_departure') <span
                                                            class="required">(*)</span></label>
                                                <input type="text" id="end_date" value="{{ old('departure') }}" placeholder="YYYY-MM-DD" name="departure"
                                                       class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_client_name') <span
                                                            class="required">(*)</span></label>
                                                <input type="text" name="client_name" id="client_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_age') <span
                                                            class="required">(*)</span></label>
                                                <input type="text" name="age" id="age" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_card') ? <span
                                                            class="required">(*)</span></label>
                                                <input type="text" name="cart" id="cart" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_transfer') <span
                                                            class="required">(*)</span></label>
                                                <input type="text" name="transfer" id="transfer" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_email') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="email" name="email" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_phone') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="phone" name="phone" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_city') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="city" name="city" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_country') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="country" name="country" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="price" name="price" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_price') @lang('messages.keyword_extra') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="price_extra" name="price_extra" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_commission') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="commission" name="commission" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('messages.keyword_commission') @lang('messages.keyword_extra') <span class="required">(*)</span></label>
                                                <input required class="form-control" id="commission_extra" name="commission_extra" placeholder=""
                                                       type="text" value="">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_notes') <span class="required">(*)</span></label>
                                        <textarea name="notes" id="notes" cols="30" rows="4" style="resize: vertical;" class="form-control"></textarea>
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
                    <a href="{{ url('bookings') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
                </div>

            </div>
        </div>

    </div>

    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#add_booking_form").validate({
                rules: {
                    user: {
                        required: true
                    },
                    hotel: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    client_name: {
                        required: true
                    },
                    age: {
                        required: true,
                        number: true
                    },
                    arrival: {
                        required: true
                    },
                    departure: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    country:{
                        required: true
                    },
                    city:{
                        required: true
                    },
                    cart:{
                        required: true
                    },
                    transfer:{
                        required: true
                    },
                    notes:{
                        required: true
                    }

                },
                messages: {
                    user: {
                        required: "{{trans('messages.keyword_please_select_user')}}"
                    },
                    hotel: {
                        required: "{{trans('messages.keyword_please_select_hotel')}}"
                    },
                    phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone_number')}}"
                    },
                    client_name: {
                        required: "{{trans('messages.keyword_please_enter_a_phone_number')}}"
                    },
                    age: {
                        required: "{{trans('messages.keyword_please_enter_an_age')}}",
                        number: "{{trans('messages.keyword_please_enter_a_valid_age')}}"
                    },
                    arrival: {
                        required: "{{trans('messages.keyword_please_select_arrival_date')}}",
                    },
                    departure: {
                        required: "{{trans('messages.keyword_please_select_departure_date')}}",
                    },
                    email: {
                        required: "{{trans('messages.keyword_please_enter_an_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_email')}}",
                    },
                    country:{
                        required: "{{trans('messages.keyword_please_enter_a_country')}}"
                    },
                    city:{
                        required: "{{trans('messages.keyword_please_enter_a_city')}}"
                    },
                    cart:{
                        required: "{{trans('messages.keyword_please_select_card')}}"
                    },
                    transfer:{
                        required: "{{trans('messages.keyword_please_select_transfer')}}"
                    },
                    notes:{
                        required: "{{trans('messages.keyword_please_enter_a_note')}}"
                    }
                }
            });
        });
    </script>


    <script>

        function fetchHotelWiseRooms(e)
        {
            var hotel_id = $(e).val();
            //
            $.ajax({
                method: "POST",
                url : '{{ url('booking/get/hotel/rooms') }}',
                data: {"_token": "{{ csrf_token() }}", hotel_id : hotel_id},
                success: function(data){
                    $("#select_rooms").html(data);
                }
            });
        }



        $('#select_rooms').on("change", function(e) {
            var room_id = $(this).val();

            $.ajax({
                method: "POST",
                url : '{{ url('booking/get/room/details') }}',
                data: {"_token": "{{ csrf_token() }}", room_id : room_id},
                success: function(data){
                    $("#fetchRoomDetails").append(data);
                }
            });
        });

        $(document).ready(function () {

            $('#departure_date, #arrival_date, #end_date, #start_date').datepicker({
                format: "yyyy-mm-dd",
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
            }).datepicker();

        });
    </script>
@endsection




<!-----------Review Modal------------>
<div id="room_booking_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_reviews')</h4>
            </div>


            <div class="modal-body">
                {{ Form::open(['url'=> '','method'=> 'post']) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Client Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Status</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Adult</label>
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Child</label>
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pull-right">
                    <button type="submit" class="btn btn-default" data-dismiss="modal">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

                {{ Form::close() }}
                <div class="clearfix"></div>
            </div>

        </div>

    </div>
</div>
<!-----------Review Modal------------>