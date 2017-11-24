@extends('layouts.app')
@section('content')
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>-->

    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  navigation-active-item" id="firstst"></li>
                        <li class="navigation-item " id="secondst"></li>
                        <li class="navigation-item" id="thirdst"></li>
                        <li class="navigation-item" id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php
    if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
        echo Form::open(array('url' => '/update/hoteldetail' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelBasicInfo'));
    } else {
        echo Form::open(array('url' => '/update/hoteldetail', 'files' => true, 'id' => 'frmHotelBasicInfo'));
    }
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <p class="bold blue-head">Basic information</p>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_name')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_hotel_name')}}" value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}"
                                                   name="name" id="name" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_logo')}} <span class="required">(*)</span></label>
                                            <input type="file" name="logo" id="logo" />
                                            @if(isset($hoteldetails->logo) && $hoteldetails->logo !="")
                                            <img src="{{url('storage/app/images/hotel/'.$hoteldetails->logo)}}" width="100px"/>
                                            @endif                                            
                                        </div>
                                    </div>
                                    
                                    </div>
                                 <div class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                     	<div class="form-group">
                                        	<label>{{trans('messages.keyword_summary')}} <span class="required">(*)</span></label>
                                            <textarea class="form-control" rows="10" placeholder="{{trans('messages.keyword_summary')}}" name="summary" id="summary">{{(isset($hoteldetails->summary)) ? $hoteldetails->summary : old('summary')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_description')}} <span class="required">(*)</span></label>
                                            <textarea class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description" id="description" required>{{(isset($hoteldetails->description)) ? $hoteldetails->description : old('description')}}</textarea>
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
            <div class="col-md-12 col-sm-12 col-xs-12 btn-right-shape text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_proceeds')}}</button>
            </div>
        </div>
    </div>
        </div>
    </div>

    
    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{url('/public/js/ckeditor.js')}}"></script>
    <script type="text/javascript" >
        CKEDITOR.replace( 'description' );
    </script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#frmHotelBasicInfo").validate({
                rules: {
                    summary: {
                        required: true,
                    },
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    description: {
                        required: true
					},
                    logo: {
                        required: true,
                        extension: "jpeg|jpg|png|gif"
                    }
                },
                messages: {
                    summary: {
                        required: "{{trans('messages.keyword_please_enter_summary_of_hotel')}}",
                    },
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    description: {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    },
                    logo: {
                        required: "{{trans('messages.keyword_please_select_logo')}}",
                        extension: "@lang('messages.keyword_please_choose_valid_extension')"
                    }
                }
            });
            $.validator.setDefaults({
                ignore: []
            });
		});



    </script>


@endsection