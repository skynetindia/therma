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
    <?php $currency = getActiveCurrency(); ?>

    {{--@if($action == 'edit')--}}
         {{--{{ pre($room_details) }}--}}
        {{--@endif--}}

    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="thirdst"></li>
                        <li class="navigation-item" id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
	echo Form::open(array('url' => '/hotel/room/update' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'room_info_form'));
} else {
	echo Form::open(array('url' => '/hotel/room/update'."/", 'files' => true, 'id' => 'room_info_form'));
}
?>
<input type="hidden" name="room_id" value="{{isset($room_details->id) ? $room_details->id : ''}}">
<input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

{{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="edit-room-lft-side">
                    <div class="section-border">
                        <p class="bold blue-head">{{trans('messages.keyword_basic_information')}}</p>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_select_hotel')</label>
                                    <select class="form-control" name="select_hotel" id="select_hotel">
                                        <option value="">-- Select --</option>
                                        @forelse(getHotels() as $key => $valhotel)
                                            <option value="{{ $valhotel->id }}" {{(isset($room_details->hotelid) && $room_details->hotelid == $valhotel->id) ? 'selected' : ''}} >{{ $valhotel->name }}</option>
                                        @empty
                                            <options>-- No Room Available</options>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_what_kind_of_room_do_you_want_to_add')</label>
                                    <select class="form-control" name="select_room">
                                        <option value="">-- Select --</option>
                                        @forelse(fetch_room_type() as $key => $roomty)
                                            <option value="{{ $roomty->id }}" {{(isset($room_details->type_of_rooms) && $room_details->type_of_rooms == $roomty->id) ? 'selected' : ''}} >   {{ $roomty->name }}</option>
                                        @empty
                                            <options>-- No Room Available</options>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>@lang('messages.keyword_personal_name_optional')</label>
                                    <input class="form-control" placeholder="personal name" name="personal_name" value="{{ isset($room_details->personal_name) ? $room_details->personal_name : '' }}"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>@lang('messages.keyword_how_many_rooms_do_you_have_with_this_name')</label>
                                    <input class="form-control" placeholder="@lang('messages.keyword_enter_room')" name="how_many_room" value="{{ isset($room_details->qt_same_name) ? $room_details->qt_same_name : '' }}"
                                           type="number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p class="bold blue-head">@lang('messages.keyword_size_of_the_accommodation')</p>
                            </div>
                        </div>

                        <div class="height10"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p class="bold">@lang('messages.keyword_which_unit_of_measure_do_you_prefer')</p>
                                <div class="form-group">
                                    <div class="radio-wrap">
                                        <div class="radio-inline round-checkbox">
                                            <input id="radio" name="unit" type="radio" value="cm" {{ (isset($room_details->unit_of_measurement) &&  $room_details->unit_of_measurement == 'cm') ? 'checked' : ((isset($room_details->unit_of_measurement) &&  $room_details->unit_of_measurement == 'feet') ? '' : 'checked' ) }}>
                                            <label for="radio">@lang('messages.keyword_cm')</label>
                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </div>
                                        <div class="radio-inline round-checkbox">
                                            <input id="radio1" name="unit" type="radio" value="feet" {{ (isset($room_details->unit_of_measurement) &&  $room_details->unit_of_measurement == 'feet') ? 'checked' : '' }}>
                                            <label for="radio1">@lang('messages.keyword_feet')</label>
                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="bold blue-head">@lang('messages.keyword_enter_the_size_of_the_accommodation')</p>
                        <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_height')</label>
                                    <div class="input-group">
                                        <input class="form-control" id="height" placeholder="@lang('messages.keyword_height')" value="{{ isset($room_details->height) ? $room_details->height : '' }}" name="height" type="text">
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_weight')</label>
                                    <div class="input-group">
                                        <input class="form-control" id="weight" placeholder="@lang('messages.keyword_weight')" value="{{ isset($room_details->weight) ? $room_details->weight : '' }}" name="weight" type="text">
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <?php /*
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_vision')</label>
                                    <div class="input-group">
                                        <input class="form-control" id="" placeholder="0" value="{{ isset($room_details->vision) ? $room_details->vision : '' }}" name="vision" type="text">
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_symphony')</label>
                                    <div class="input-group">
                                        <input class="form-control" id="" placeholder="0" value="{{ isset($room_details->symphony) ? $room_details->symphony : '' }}" name="symphony" type="text">
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_secret')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="secret" id="" value="{{ isset($room_details->secret) ? $room_details->secret : '' }}" placeholder="0" type="text" >
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                        </div>*/?>
                         <?php /*<div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_thought')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="thought" value="{{ isset($room_details->though) ? $room_details->though : '' }}" id="" placeholder="0" type="text" >
                                        <div class="input-group-addon">m2</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p class="bold">@lang('messages.keyword_ready_configuration')</p>
                                    <div class="bg-grey inline-block">@lang('messages.keyword_specify_here_only_turns_around_in_the_accommodation,_excluding_any_extra_beds')
                                </div>
                            </div>
                        </div>*/?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="textbox-with-icon-user">
                                    <label>@lang('messages.keyword_how_many_guests_can_sleep_in_this_unit')</label>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="" name="can_sleep" value="{{ isset($room_details->can_sleep) ? $room_details->can_sleep : '1' }}" type="text" required>
                                    </div>
                                    <div class="user-blue"><i class="fa fa-user" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php /*<div class="col-md-3 col-sm-12 col-xs-12">

                <div class="ryt-side-menu-collapse">
                    <div class="rytside-menu">
                        <h3>room amenities</h3>
                        <button href="#" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="height20"></div>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                        /*This will get checked checkboxes*
                        $options_id = '';
                        if(isset($room_details->id) && $action =='edit'){
                            $options_id = getAmenitiesOptionWithRoomId($room_details->id);
                        }
                        /*This will get checked checkboxes*

                        $getSubcategories = getWizardSubCategory(57);
                        foreach ($getSubcategories as $keysubcat => $valuesubcat) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapse{{$keysubcat}}" aria-expanded="false"
                                       aria-controls="collapse{{$keysubcat}}" class="collapsed">
                                        <i class="more-less fa-chevron-down fa" aria-hidden="true"></i>
                                        {{trans('messages.keyword_'.$valuesubcat->language_key)}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{$keysubcat}}" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body"><?php
                                    $optionsCategories = getWizardOptionByCategory($valuesubcat->id);



                                    ?>
                                    @foreach($optionsCategories as $keynoind => $valnoind)
                                        {{--{{ pre($valnoind) }}--}}
                                        <div class="room-hotel-innr-form"><?php
                                            if (isset($valnoind->id) && $valnoind->id != null) {

                                                if ($valnoind->is_language == 1) {
                                                    echo createwizard($valnoind, '2', $valnoind->cat_lang_key, $options_id);
                                                } else {
                                                    echo createwizard($valnoind, '1', $valnoind->cat_lang_key, $options_id);
                                                }
                                            }
                                            ?>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div><?php
                        }
                        ?></div>

                </div>
            </div>*/?>
        </div>
        <div class="btn-shape">
            <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left">
                <a href="{{ url('hotel/room/room-details') }}" class="btn btn-default">Back</a>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_proceeds')}}</button>
            </div>
        </div>
    </div>
    </div>

    <?php echo Form::close(); ?>

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js')}}"></script>
    <script type="text/javascript">


        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#room_info_form").validate({
                rules: {
					select_hotel:{
						required: true
					},
                    select_room: {
                        required: true
                    },
                    name_of_room: {
                        required: true
                    },
                    personal_name: {
                        required: true
                    },
                    how_many_room: {
                        required: true
                    },
                    unit: {
                        required: true
                    },
                    weight: {
                        required: true
                    },
                    height: {
                        required: true
                    },
                    at_night: {
                        required: true,
                        number: true
                    },
                    discount: {
                        required: true,
                        number: true,
                        max: 100
                    },
                },
                messages: {
					select_hotel:{
						required: "Please select hotel"
					},
                    select_room: {
                        required: "please select room"
                    },
                    name_of_room: {
                        required: "please select room"
                    },
                    personal_name: {
                        required: "please enter personal name"
                    },
                    how_many_room: {
                        required: "please choose how many room"
                    },
                    unit: {
                        required: "please select unit"
                    },
                    weight: {
                        required: "please enter weight"
                    },
                    height: {
                        required: "please enter height"
                    },                    
                    at_night: {
                        required: "this field is required",
                        number: "number",
                    },
                    discount: {
                        required: "this field is required",
                        number: "number",
                    },
                }

            });
            $.validator.setDefaults({
                ignore: []
            });
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('.inputmask-formate').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });
    </script>

@endsection

