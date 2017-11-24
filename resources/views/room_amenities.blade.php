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
    <?php $arrlanguages = getlanguages();
        $options_id = '';
            if(isset($room_details->id)){
            $options_id = getAmenitiesOptionWithRoomId($room_details->id);            
            $options_id = implode(",", $options_id);            
        }
    ?>
    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item" id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item " id="thirdst"></li>
                        <li class="navigation-item" id="fourthst"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php 
    if (isset($room_details) && !empty($room_details)) {
        echo Form::open(array('url' => '/hotel/room/updateaminities' . "/" . $room_details->id, 'files' => true, 'id' => 'frmHotelAmenities'));
    } 
    ?><input type="hidden" name="room_id" value="{{isset($room_details->id) ? $room_details->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    <div class="hotel-detail-wrap">
        <div class="row"><?php
    $getSubcategories = getWizardSubCategory(16);
	
    foreach ($getSubcategories as $keysubcat => $valuesubcat) {
    ?><div class="col-md-6">
        <div class="set-option">
        <div class="section-border set-height-section-border"><?php
            $optionsCategories = getWizardOptionByCategory($valuesubcat->id);
            //pre($categoryoptions);
            ?>
            @if(isset($optionsCategories[0]->cat_lang_key))
                <p class="bold blue-head">{{trans('messages.keyword_'.$optionsCategories[0]->cat_lang_key)}}</p>
                	<div class="set-min-height">
                <div class="row">
                    @foreach($optionsCategories as $keynoind => $valnoind)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        	<div class="row">
                            <div class="form-group"><?php
                            if (isset($valnoind->id) && $valnoind->id != null) {
                                if ($valnoind->is_language == 1) {
                                    echo createwizard($valnoind, '2', $valnoind->cat_lang_key, $options_id);
                                } else {
                                    echo createwizard($valnoind, '1', $valnoind->cat_lang_key, $options_id);
                                }
                            }
                            ?></div>
                        </div></div>
                    @endforeach
                </div></div>
            @endif
        </div>
    </div>
</div>
    <?php
    }
    ?></div>
    </div>
     <div class="btn-shape">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/room/price-list').'/'.$room_details->id}}" class="btn btn-default">Previous</a></div>                
                <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                    <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
                </div>
            </div>
        </div>
    <!--<div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('hotel/room/room-details') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
        </div>
    </div>-->
    <?php echo Form::close(); ?>
    </div>
@endsection
