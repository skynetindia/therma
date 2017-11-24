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

    <?php
    if(isset($room_details) && !empty($room_details) && $action == 'edit'){
        echo Form::open(array('url' => '/hotel/room/update' . "/".$room_details->id, 'files' => true, 'id' => 'add_room_form'));
    }
    else {
        echo Form::open(array('url' => '/hotel/room/update/'.$hotelid, 'files' => true, 'id' => 'add_room_form'));
    }
    ?>
    <input type="hidden" name="room_id" value="{{isset($room_details->id) ? $room_details->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <p class="bold blue-head">@lang('messages.keyword_update_room_details')</p>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_room_title')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_room_title')}}" value="{{(isset($room_details->room_title)) ? $room_details->room_title : old('room_title')}}" name="room_title" id="room_title" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <?php $arrAvailableFor = array("Single", "Double", "Triple", "Family"); ?>
                                            <label for="">{{trans('messages.keyword_available_for')}} <span class="required">(*)</span></label>
                                            <select name="available_for" id="available_for" class="form-control">
                                                <option value="">-- @lang('messages.keyword_please_select')</option>
                                                @foreach($arrAvailableFor as $val)
                                                    <?php $selected_available_for = ($action == 'edit' && $val == $room_details->available_for) ? 'selected' : ''; ?>
                                                    <option value="{{ $val }}" {{ $selected_available_for }}>{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_floor')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_floor')}}" value="{{(isset($room_details->floor)) ? $room_details->floor : old('floor')}}" name="floor" id="floor" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_room_number')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_room_number')}}" value="{{(isset($room_details->room_number)) ? $room_details->room_number : old('room_number')}}" name="room_number" id="room_number" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_price')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_price')}}" value="{{(isset($room_details->price)) ? $room_details->price : old('price')}}" name="price" id="price" type="text">
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
                <a href="{{ url('hotel/edit/room-details').'/'.$hotelid }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
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
            $("#add_room_form").validate({
                rules: {
                    room_title: {
                        required: true,
                    },
                    available_for: {
                        required: true,
                    },
                    floor: {
                        required: true,
                        number: true,
                        maxlength: 3

                    },
                    room_number: {
                        required: true,
                        number: true,
                        maxlength: 5
                    },
                    price: {
                        required: true,
                        number: true,
                        maxlength: 8
                    }
                },
                messages: {
                    room_title: {
                        required: "{{trans('messages.keyword_please_enter_a_room_title')}}",
                    },
                    available_for: {
                        required: "Please select available for",
                    },
                    floor: {
                        required: "{{trans('messages.keyword_please_enter_a_floor_number')}}",
                        number: "{{trans('messages.keyword_please_enter_a_valid_number')}}",
                        maxlength: "{{trans('messages.keyword_floor_number_must_be_less_than_3_characters')}}"
                    },
                    room_number: {
                        required: "{{trans('messages.keyword_please_enter_a_room_number')}}",
                        number: "{{trans('messages.keyword_please_enter_a_valid_number')}}",
                        maxlength: "{{trans('messages.keyword_room_number_must_be_less_than_5_characters')}}"
                    },
                    price: {
                        required: "{{trans('messages.keyword_please_enter_a_price')}}",
                        number: "{{trans('messages.keyword_please_enter_a_valid_number')}}",
                        maxlength: "{{trans('messages.keyword_price_must_be_less_than_8_characters')}}"
                    }
                }
            });
        });
    </script>

    </script>




@endsection