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
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php
    if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
        echo Form::open(array('url' => '/update/hotelbasicinfo' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelBasicInfo'));
    } else {
        echo Form::open(array('url' => '/update/hotelbasicinfo', 'files' => true, 'id' => 'frmHotelBasicInfo'));
    }
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">

        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <p class="bold blue-head">Basic information</p>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_status')}} <span
                                                        class="required">(*)</span></label>
                                            <select class="form-control" name="status" id="status">
                                                @foreach($hotelstatus as $key => $val)
                                                    @php
                                                        $selectedStatus = (isset($hoteldetails->status) && ($key == $hoteldetails->status)) ? 'selected' : (old('status') == $key) ? 'selected' : ''
                                                    @endphp
                                                    <option value="{{$key}}" <?php echo $selectedStatus; ?>>{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_hotel_name')}} <span
                                                        class="required">(*)</span></label>
                                            <input class="form-control"
                                                   placeholder="{{trans('messages.keyword_hotel_name')}}"
                                                   value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}"
                                                   name="name" id="name" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_category')}}</label>
                                            <select class="form-control" name="hotel_category" id="hotel_category">
                                                <option value="0">-</option>
                                                @foreach($hotel_category as $keyhc => $valhc)
                                                    @php $selectedcatStatus = (isset($hoteldetails->category_id) && ($valhc->id == $hoteldetails->category_id)) ? 'selected' : (old('hotel_category') == $key) ? 'selected' : ''
                                                    @endphp
                                                    <option value="{{$valhc->id}}" {{$selectedcatStatus}}>{{$valhc->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_address')}} <span class="required">(*)</span></label>
                                            <input class="form-control addressautocomplete"
                                                   placeholder="{{trans('messages.keyword_find_your_address')}}"
                                                   value="{{(isset($hoteldetails->address)) ? $hoteldetails->address : old('address')}}"
                                                   name="address" id="address" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_communication_language')}}</label>
                                            <select class="form-control" name="communication_lang"
                                                    id="communication_lang">
                                                @foreach($arrlanguages as $keylang => $vallang)
                                                    @php $selectedcomlang = (isset($hoteldetails->communication_lang) && ($keylang == $hoteldetails->communication_lang)) ? 'selected' : (old('communication_lang') == $keylang) ? 'selected' : '' @endphp
                                                    <option value="{{$vallang->id}}" {{$selectedcomlang}}>{{strtoupper($vallang->code)}}
                                                        / {{$vallang->original_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="is_extarnal_login">{{trans('messages.keyword_extranet_login')}}</label>
                                            <select class="form-control" name="is_extarnal_login"
                                                    id="is_extarnal_login">
                                                @php
                                                    $selectedcomlangyes = (isset($hoteldetails->is_extarnal_login) && ('1'== $hoteldetails->is_extarnal_login)) ? 'selected' : (old('is_extarnal_login') == '1') ? 'selected' : '';
                                                    $selectedcomlangno = (isset($hoteldetails->is_extarnal_login) && ('0'== $hoteldetails->is_extarnal_login)) ? 'selected' : (old('is_extarnal_login') == '0') ? 'selected' : '' @endphp
                                                <option value="1" {{$selectedcomlangyes}}>Yes</option>
                                                <option value="0" {{$selectedcomlangno}}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_login_name')}}</label>
                                            <input class="form-control"
                                                   placeholder="{{trans('messages.keyword_login_name')}}"
                                                   name="{{ ($action == 'add') ? 'username_required' : 'username' }}" id="{{ ($action == 'add') ? 'username_required' : 'username' }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <p>{{ucwords(trans('messages.keyword_password'))}}</p>

                                            <a href="javascript:void(0);"
                                               class="change-pass bold  @if($action == 'add') none @endif"
                                               onclick="$(this).addClass('none');$('.change-pass-input').removeClass('none');">{{trans('messages.keyword_change_password')}}</a>
                                            <input class="form-control change-pass-input @if($action != 'add') none @endif"
                                                   placeholder="{{trans('messages.keyword_password')}}" name="{{ ($action == 'add') ? 'password_required' : 'password' }}"
                                                   id="{{ ($action == 'add') ? 'password_required' : 'password' }}" type="password">

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="email-address-blk">
                            <div class="section-border">
                                <p class="bold blue-head">{{trans('messages.keyword_email_addresses')}}</p>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_general_email')}} <span class="required">(*)</span></label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->general_email)) ? $hoteldetails->general_email : old('  general_email')}}"
                                                   placeholder="{{trans('messages.keyword_general_email')}}"
                                                   type="email" name="general_email" id="general_email">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_reservation_email')}}</label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->reservation_email)) ? $hoteldetails->reservation_email : old('reservation_email')}}"
                                                   placeholder="{{trans('messages.keyword_reservation_email')}}"
                                                   name="reservation_email" id="reservation_email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_email_for_transfers')}}</label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->transfer_email)) ? $hoteldetails->transfer_email : old('transfer_email')}}"
                                                   placeholder="{{trans('messages.keyword_email_for_transfers')}}"
                                                   name="transfer_email" id="transfer_email" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_email_for_billing')}}</label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->billing_email)) ? $hoteldetails->billing_email : old('billing_email')}}"
                                                   placeholder="{{trans('messages.keyword_email_for_billing')}}"
                                                   name="billing_email" id="billing_email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_email_for_sold_out')}}</label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->sold_out_email)) ? $hoteldetails->sold_out_email : old('sold_out_email')}}"
                                                   placeholder="{{trans('messages.keyword_email_for_sold_out')}}"
                                                   name="sold_out_email" id="sold_out_email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="email-address-blk">
                            <div class="section-border">
                                <p class="bold blue-head">{{trans('messages.keyword_location')}}</p>
                                <div class="row"><?php 
								$currenloacitonrc = isset($hoteldetails->location_ids) ? explode(",",$hoteldetails->location_ids) : array();								
								?>
	                               @foreach(getlocations() as $keylocation => $vallocation)
                                   <div class="col-md-4 col-sm-12 col-xs-12">
                                     <div class="ryt-chk">
                                    <input class="form-control" value="{{$vallocation->id}}" <?php echo (in_array($vallocation->id,$currenloacitonrc)) ? 'checked' : '';?> type="checkbox" name="locations[]" id="location_{{$vallocation->id}}">
                                            <label for="location_{{$vallocation->id}}">{{$vallocation->name}}</label></div>
                                    </div>                                    
                                    @endforeach                                   
                                </div>                                
                            </div>
                        </div>

                        <div class="text-info-blk">
                            <div class="section-border">
                                <div class="heading-with-pagination">
                                    <p class="bold blue-head">{{trans('messages.keyword_text_information')}}</p>
                                    <div class="pagination-type">

                                        <ul class="pagination nav nav-tabs nav-tabs-lang">
                                            <li><a href="#">
                                                    <div class="input-group-addon">
                                                        <div class="ryt-chk"><input id="chk-without-info2"
                                                                                    type="checkbox"><label
                                                                    for="chk-without-info2"></label></div>
                                                    </div>
                                                </a>
                                            </li>
                                            @foreach($arrlanguages as $keylang => $vallang)
                                                <li @if($keylang==0) class="active"@endif><a data-toggle="tab"
                                                                                             href="#{{$vallang->code}}">{{$vallang->code}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    @foreach($arrlanguages as $keylang => $vallang)
                                        <div id="{{$vallang->code}}"
                                             class="tab-pane fade in @if($keylang==0)active @endif">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               placeholder="{{trans('messages.keyword_name')}}"
                                                               value="{{ isset($text_information->name) && isset($text_information_language[$vallang->code][$text_information->name]) ? ($text_information_language[$vallang->code][$text_information->name]) : ''}}"
                                                               name="text_name_{{$vallang->code}}"
                                                               id="text_name_{{$vallang->code}}" type="text"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_language_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->language_name) && isset($text_information_language[$vallang->code][$text_information->language_name]) ? ($text_information_language[$vallang->code][$text_information->language_name]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_language_name')}}"
                                                               name="language_name_{{$vallang->code}}"
                                                               id="language_name_{{$vallang->code}}" type="text"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_supplement_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->supplement_name) && isset($text_information_language[$vallang->code][$text_information->supplement_name]) ? ($text_information_language[$vallang->code][$text_information->supplement_name]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_supplement_name')}}"
                                                               name="supplement_name_{{$vallang->code}}"
                                                               id="supplement_name_{{$vallang->code}}" type="text">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description__short')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  placeholder="{{trans('messages.keyword_enter_short_description')}}"
                                                                  name="desc_short_{{$vallang->code}}"
                                                                  id="desc_short_{{$vallang->code}}">{{isset($text_information->short_description) && isset($text_information_language[$vallang->code][$text_information->short_description]) ? ($text_information_language[$vallang->code][$text_information->short_description]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_full')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_full_{{$vallang->code}}"
                                                                  id="desc_full_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_full_description')}}">{{isset($text_information->full_description) && isset($text_information_language[$vallang->code][$text_information->full_description]) ? ($text_information_language[$vallang->code][$text_information->full_description]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_exceptionality')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_exception_{{$vallang->code}}""
                                                        id="desc_exception_{{$vallang->code}}"
                                                        placeholder="{{trans('messages.keyword_enter_exceptinality_description')}}
                                                        ">{{isset($text_information->exceptionality_dec) && isset($text_information_language[$vallang->code][$text_information->exceptionality_dec]) ? ($text_information_language[$vallang->code][$text_information->exceptionality_dec]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_expert_evaluation')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_experteval_{{$vallang->code}}"
                                                                  id="desc_experteval_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_expert_evaluation_description')}}">{{isset($text_information->expert_evalution_desc) &&  isset($text_information_language[$vallang->code][$text_information->expert_evalution_desc]) ? ($text_information_language[$vallang->code][$text_information->expert_evalution_desc]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_special_offer')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="special_offer_{{$vallang->code}}"
                                                                  id="special_offer_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_special_offer')}}">{{isset($text_information->special_offer) &&  isset($text_information_language[$vallang->code][$text_information->special_offer]) ? ($text_information_language[$vallang->code][$text_information->special_offer]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_videos')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control" name="videos_{{$vallang->code}}"
                                                                  id="videos_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_video_url')}}">{{isset($text_information->video_url) && isset($text_information_language[$vallang->code][$text_information->video_url]) ? ($text_information_language[$vallang->code][$text_information->video_url]) : ''}}</textarea>
                                                        <p>{{trans('messages.keyword_pattern')}}:
                                                            www.youtube.com/embed/NXLDoATXoh4<br/></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_video_expert_rating')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->video_assement) && isset($text_information_language[$vallang->code][$text_information->video_assement]) ? ($text_information_language[$vallang->code][$text_information->video_assement]) : ''}}"
                                                               name="video_expert_{{$vallang->code}}"
                                                               id="video_expert_{{$vallang->code}}"
                                                               placeholder="{{trans('messages.keyword_video_expert_rating')}}"
                                                               value="" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <hr/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_title')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->seo_title) && isset($text_information_language[$vallang->code][$text_information->seo_title]) ? ($text_information_language[$vallang->code][$text_information->seo_title]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_seo_title')}}"
                                                               name="seo_title_{{$vallang->code}}"
                                                               id="seo_title_{{$vallang->code}}" value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_description')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_desc_{{$vallang->code}}"
                                                                  id="seo_desc_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_description')}}">{{isset($text_information->seo_desc) && isset($text_information_language[$vallang->code][$text_information->seo_desc]) ? ($text_information_language[$vallang->code][$text_information->seo_desc]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_keywords')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_keywords_{{$vallang->code}}"
                                                                  id="seo_keywords_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_keywords')}}">{{isset($text_information->seo_keywords) && isset($text_information_language[$vallang->code][$text_information->seo_keywords]) ? ($text_information_language[$vallang->code][$text_information->seo_keywords]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_title_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->seo_title_ref) && isset($text_information_language[$vallang->code][$text_information->seo_title_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_title_ref]) : ''}}"
                                                               name="seo_titleref_{{$vallang->code}}"
                                                               id="seo_titleref_{{$vallang->code}}"
                                                               placeholder="{{trans('messages.keyword_seo_title_reference')}}"
                                                               value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo__description_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_descref_{{$vallang->code}}"
                                                                  id="seo_titleref_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo__description_reference')}}">{{isset($text_information->seo_desc_ref) &&  isset($text_information_language[$vallang->code][$text_information->seo_desc_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_desc_ref]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_keywords_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_keywordsref_{{$vallang->code}}"
                                                                  id="seo_keywordsref_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_keywords_reference')}}">{{isset($text_information->seo_keyword_ref) &&  isset($text_information_language[$vallang->code][$text_information->seo_keyword_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_keyword_ref]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>


                </div>


            </div>


            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="basic-info-lft">
                    <div class="section-border">
                        <p class="bold blue-head">@lang('messages.keyword_contact_us')</p>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p class="bold blue-head">this is the location we will provide guests. click and drag
                                    the map</p>
                                <div class="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12344567.431710659!2d3.5856134805201085!3d40.94182220553099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d4fe82448dd203%3A0xe22cf55c24635e6f!2sItaly!5e0!3m2!1sen!2sin!4v1502167975265"
                                            width="280" height="550" frameborder="0" style="border:0"
                                            allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}
                                        /{{trans('messages.keyword_hotel_name')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control" placeholder="{{trans('messages.keyword_hotel_name')}}"
                                           value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}"
                                           name="contact_hotel_name" id="contact_hotel_name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_contact_person')}} </label>
                                    <input class="form-control"
                                           value="{{(isset($hoteldetails->contact_person)) ? $hoteldetails->contact_person : old('contact_person')}}"
                                           id="contact_person" name="contact_person"
                                           placeholder="{{trans('messages.keyword_contact_person')}}" type="text">
                                </div>

                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_id')}}</label>
                                    <input class="form-control"
                                           value=""
                                           id="contact_id" placeholder="{{trans('messages.keyword_id')}}"
                                           name="contact_id" type="text">
                                </div>


                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_zip_code')}} </label>
                                    <input class="form-control"
                                           value="{{(isset($hoteldetails->zip_code)) ? $hoteldetails->zip_code : old('zip_code')}}"
                                           id="zip_code" name="zip_code"
                                           placeholder="{{trans('messages.keyword_zip_code')}}" type="text">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                                    <input class="form-control inputmask-formate" id="hotel_phone" name="hotel_phone"
                                           placeholder="{{trans('messages.keyword_phone')}}" type="text"
                                           value="{{(isset($hoteldetails->phone)) ? $hoteldetails->phone : old('hotel_phone')}}">
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_fax')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control"
                                           value="{{(isset($hoteldetails->fax)) ? $hoteldetails->fax : old('hotel_fax')}}"
                                           id="hotel_fax" placeholder="{{trans('messages.keyword_fax')}}"
                                           name="hotel_fax" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_vat_id')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->vat_id)) ? $billing_address->vat_id : old('billing_vat_id')}}"
                                           id="billing_vat_id" placeholder="{{trans('messages.keyword_vat_id')}}"
                                           name="billing_vat_id" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_web')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control"
                                           value="{{(isset($hoteldetails->web_url)) ? $hoteldetails->web_url : old('hotel_weburl')}}"
                                           id="hotel_weburl" name="hotel_weburl"
                                           placeholder="{{trans('messages.keyword_web')}}" type="text">
                                </div>


                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_address')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control addressautocomplete"
                                           value="{{(isset($billing_address->address)) ? $billing_address->address : old('billing_address')}}"
                                           id="contact_address" placeholder="{{trans('messages.keyword_address')}}"
                                           name="contact_address" type="text">
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="section-border">

                        <div class="heading-with-toggle-wrap">
                            <p class="bold blue-head">Invoice - Final Beneficiary</p>
                            <div class="float-right">
                                <div class="switch"><input value="" name="" id="switch2" type="checkbox"
                                                           onchange="valueChanged2()"><label for="switch2"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}
                                        /{{trans('messages.keyword_hotel_name')}}</label>
                                    <input class="form-control" id="invoice_hotel_name" placeholder="@lang('messages.keyword_hotel_name')" name="invoice_hotel_name" value="10" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_address')</label>
                                    <textarea class="form-control" name="invoice_address" id="invoice_address" placeholder="Enter Address"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">IBAN</label>
                                    <input class="form-control" id="" placeholder="" name="" value="10" type="text">
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="section-border switch2-show none">
                        <p class="bold blue-head">Invoice - Final recipient - Operator language</p>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Company</label>
                                    <input class="form-control" id="" placeholder="" name="" value="10" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea class="form-control" id="" placeholder="Enter Address"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">IBAN</label>
                                    <input class="form-control" id="" placeholder="" name="" value="10" type="text">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="section-border">
                        <p class="bold blue-head">{{trans('messages.keyword_billing_address')}}</p>
                        <div class="float-right">
                            <div class="switch"><input value="1" name="" id="switch3" type="checkbox"
                                                       onchange="valueChanged3()"><label for="switch3"></label></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}} / {{trans('messages.keyword_hotel_name')}}<span
                                                class="required">(*)</span></label>
                                    <input class="form-control" id="billing_company_name"
                                           placeholder="{{trans('messages.keyword_company')}}"
                                           name="billing_company_name"
                                           value="{{(isset($billing_address->company)) ? $billing_address->company : old('billing_company_name')}}"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_contact_person')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->contact_person)) ? $billing_address->contact_person : old('billing_hotel_name')}}"
                                           id="billing_contact_person"
                                           placeholder="{{trans('messages.keyword_contact_person')}}"
                                           name="billing_contact_person" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_address')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control addressautocomplete"
                                           value="{{(isset($billing_address->address)) ? $billing_address->address : old('billing_address')}}"
                                           id="billing_address" placeholder="{{trans('messages.keyword_address')}}"
                                           name="billing_address" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_zip_code')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->zip_code)) ? $billing_address->zip_code : old('billing_zipcode')}}"
                                           id="billing_zipcode" placeholder="{{trans('messages.keyword_zip_code')}}"
                                           name="billing_zipcode" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                                    <input class="form-control inputmask-formate"
                                           value="{{(isset($billing_address->phone)) ? $billing_address->phone : old('billing_phone')}}"
                                           id="billing_phone" placeholder="{{trans('messages.keyword_phone')}}"
                                           name="billing_phone" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_fax')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->fax)) ? $billing_address->fax : old('billing_fax')}}"
                                           id="billing_fax" placeholder="{{trans('messages.keyword_fax')}}"
                                           name="billing_fax" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_banking_connections')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->bank_connetion)) ? $billing_address->bank_connetion : old('billing_bank_detail')}}"
                                           id="billing_bank_detail"
                                           placeholder="{{trans('messages.keyword_enter_banking_detail')}}"
                                           name="billing_bank_detail" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-border switch3-show none">
                        <p class="bold blue-head">{{trans('messages.keyword_billing_address')}}
                            - {{trans('messages.keyword_operator_language')}}</p>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->company)) ? $operator_billing_address->company : old('billing_opert_company_name')}}"
                                           id="billing_opert_company_name"
                                           placeholder="{{trans('messages.keyword_company')}}"
                                           name="billing_opert_company_name" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_hotel_name')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->hotel_name)) ? $operator_billing_address->hotel_name : old('billing_opert_hotel_name')}}"
                                           id="billing_opert_hotel_name"
                                           placeholder="{{trans('messages.keyword_hotel_name')}}"
                                           name="billing_opert_hotel_name" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_address')}}</label>
                                    <input class="form-control addressautocomplete"
                                           value="{{(isset($operator_billing_address->address)) ? $operator_billing_address->address : old('billing_opert_address')}}"
                                           id="billing_opert_address"
                                           placeholder="{{trans('messages.keyword_address')}}"
                                           name="billing_opert_address" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_zip_code')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->zip_code)) ? $operator_billing_address->zip_code : old('billing_opert_zipcode')}}"
                                           id="billing_opert_zipcode"
                                           placeholder="{{trans('messages.keyword_zip_code')}}"
                                           name="billing_opert_zipcode" type="number">
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
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        function valueChanged3() {
            if ($('#switch3').is(":checked")) {
                $(".switch3-show").show();
            }
            else {
                $(".switch3-show").hide();
            }
        }


        function valueChanged2() {
            if ($('#switch2').is(":checked")) {
                $(".switch2-show").show();
            }
            else {
                $(".switch2-show").hide();
            }
        }


        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#frmHotelBasicInfo").validate({
                rules: {
                    status: {
                        required: true,
                    },
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    address: {
                        required: true,
                        maxlength: 255
                    },
                    hotel_phone: {
                        required: true
                    },
                    hotel_fax: {
                        required: true
                    },
                    hotel_weburl: {
                        required: true,
                        url: true
                    },
                    general_email: {
                        required: true,
                        email: true
                    },
                    invoice_company_name: {
                        required: true,
                    },
                    invoice_address: {
                        required: true,
                    },
                    billing_company_name: {
                        required: true,
                    },
                    billing_hotel_name: {
                        required: true
                    },
                    contact_hotel_name: {
                        required: true
                    },
                    contact_address: {
                        required: true,
                        maxlength: 255
                    },
                    billing_address: {
                        required: true,
                        maxlength: 255
                    },
                    billing_phone: {
                        required: true
                    },
                    username_required : {
                        required: true,
                        maxlength: 50
                    },
                    password_required : {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    status: {
                        required: "{{trans('messages.keyword_please_select_a_hotel_status')}}",
                    },
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    address: {
                        required: "{{trans('messages.keyword_please_enter_a_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    hotel_phone: {
                        required: "{{trans('messages.keyword_enter_phone')}}"
                    },
                    hotel_fax: {
                        required: "{{trans('messages.keyword_please_enter_a_fax')}}"
                    },
                    hotel_weburl: {
                        required: "{{trans('messages.keyword_please_enter_a_web_url')}}",
                        url: "{{trans('messages.keyword_please_enter_a_valid_ur')}}"
                    },
                    general_email: {
                        required: "{{trans('messages.keyword_please_enter_a_general_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_general_email')}}"
                    },
                    invoice_company_name: {
                        required: "{{trans('messages.keyword_please_enter_a_company')}}",
                    },
                    invoice_address: {
                        required: "{{trans('messages.keyword_please_enter_a_address')}}",
                    },
                    billing_company_name: {
                        required: "{{trans('messages.keyword_please_enter_a_company')}}"
                    },
                    billing_hotel_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    contact_hotel_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    contact_address: {
                        required: "{{trans('messages.keyword_please_enter_a_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    billing_address: {
                        required: "{{trans('messages.keyword_please_enter_an_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    billing_phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone')}}",
                    },
                    username_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    password_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    }
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&sensor=false&libraries=places"></script>
    <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&sensor=false&libraries=places">-->
    <script type="text/javascript">
        /* Google Autocomplete for address */
        google.maps.event.addDomListener(window, 'load', function () {




            /*For the Edit all the text box give autocomplete */
            var acInputs = document.getElementsByClassName("addressautocomplete");
            for (var i = 0; i < acInputs.length; i++) {
                /*var autocomplete = new google.maps.places.Autocomplete(acInputs[i],options);*/
                var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
                autocomplete.inputId = acInputs[i].id;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    //document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
                });
            }
        });
    </script>

    <script>
        $(document).on("change", "#name", function(){
            var main_val = $(this).val();
            $("#contact_hotel_name").val(main_val);
            $("#invoice_hotel_name").val(main_val);
            $("#billing_company_name").val(main_val);
        });

        $(document).on("change", "#general_email", function(){
            var main_val = $(this).val();
            $("#reservation_email").val(main_val);
            $("#transfer_email").val(main_val);
            $("#billing_email").val(main_val);
            $("#sold_out_email").val(main_val);
        });

        $(document).on("change", "#address", function(){
            var main_val = $(this).val();
            $("#contact_address").val(main_val);
            $("#invoice_address").val(main_val);
            $("#billing_address").val(main_val);
        });



    </script>


@endsection