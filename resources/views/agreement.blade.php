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
                            <li class="navigation-item navigation-previous-item" id="firstst"></li>
                            <li class="navigation-item navigation-previous-item" id="secondst"></li>
                            <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                            <li class="navigation-item navigation-previous-item" id="fourthst"></li>
                            <li class="navigation-item navigation-previous-item" id="fifthst"></li>
                            <li class="navigation-item navigation-previous-item" id="sixthst"></li>
                            <li class="navigation-item navigation-previous-item" id="seven"></li>
                            <li class="navigation-item navigation-previous-item" id="eight"></li>
                            <li class="navigation-item  navigation-previous-item navigation-active-item " id="nine"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="aggrement-wrap">
            <div class="row"><?php
            if (isset($hoteldetails) && !empty($hoteldetails)) {
             echo Form::open(array('url' => '/update/hotelcontractagree' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelContractAgree'));
            } 
            else {
             echo Form::open(array('url' => '/update/hotelcontractagree', 'files' => true, 'id' => 'frmHotelContractAgree'));
            }
            ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">            
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-border">
                        <div class="agreement-heading">{{trans('messages.keyword_contract_with_thermaeurope.com')}}</div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="agreement-lft">
                                    <div class="agreement-heading-subheading">tra:</div>
                                    <div class="agreement-address">
                                        <b>Thermaeurope</b><br/>
                                        Herengracht 597 <br/>
                                        1017 CE Amsterdam<br/>
                                        Netherlands
                                    </div>
                                    <div class="agreement-txt-address">
                                        {{trans('messages.keyword_contract_text_one')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="agreement-ryt">
                                    <div class="agreement-heading-subheading">{{trans('messages.keyword_and_you,_the_accommodation')}}</div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_name_of_the_structure')}}</p>
                                        <p>{{isset($contract_details->contact_person) ? $contract_details->contact_person : $users->name}}</p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_contact_person')}}</p>
                                        <input type="text" class="form-control none" name="contact_person" value="{{$users->name}}" placeholder="{{trans('messages.keyword_contact_person')}}" id="contact_person">                                    
                                        <p>{{isset($contract_details->contact_person) ? $contract_details->contact_person : $users->name}} <a href="javascript:showbox('contact_person');"> <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('messages.keyword_edit')}}</a></p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_business_name')}}</p>
                                        <input type="text" class="form-control none" name="bussiness_name" value="{{isset($contract_details->bussiness_name) ? $contract_details->bussiness_name : $users->name}}" placeholder="{{trans('messages.keyword_contact_person')}}" id="bussiness_name">                                    
                                        <p>{{isset($contract_details->bussiness_name) ? $contract_details->bussiness_name : $users->name}}<a href="javascript:showbox('bussiness_name');"> <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('messages.keyword_edit')}}</a></p>
                                        <p class="gry-font-agree">"{{trans('messages.keyword_contract_text_two')}}"</p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_registered_office_address')}}</p>
                                        <input type="text" class="form-control none" name="office_address" value="{{isset($contract_details->address) ? $contract_details->address : $hoteldetails->address}}" placeholder="{{trans('messages.keyword_contact_person')}}" id="office_address">                                    
                                        <p>{{isset($contract_details->address) ? $contract_details->address : $hoteldetails->address}}<a href="javascript:showbox('office_address');"> <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('messages.keyword_edit')}}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="agreement-middle">
                                    <div class="agreement-heading-subheading">{{trans('messages.keyword_the_following_is_agreed')}}:</div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_percentage_of_commission')}}</p>
                                        <p>{{trans('messages.keyword_percentage_of_commission_description')}}</span></p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_validation_and_execution')}}</p>
                                        <p>{{trans('messages.keyword_contract_text_three')}}</p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>{{trans('messages.keyword_general_clauses')}}</p>
                                        <p>{{trans('messages.keyword_contract_text_four')}}</p>
                                    </div>
                                    <div class="agreement-edit-name">
                                        <p>Data</p>
                                        <p>{{date('d M Y')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="alert alert-info alert-box" role="alert">
                                <h3 class="heading-three">{{trans('messages.keyword_check_out_both_boxes_below')}}:</h3>
                                <div class="ryt-chk-content">
                                    <div class="ryt-chk">
                                        <input id="is_terms_agreed" name="is_terms_agreed" {{(isset($contract_details->is_terms_agreed) && $contract_details->is_terms_agreed == "1") ? 'checked' : ''}} value="1" type="checkbox">
                                        <label for="is_terms_agreed">{{trans('messages.keyword_i_declare_have_read_accepted_and_agreed_with')}}</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="agreement-lst">
                                    <p>{{trans('messages.keyword_youre_almost_there')}}</p>
                                    <p>{{trans('messages.keyword_contract_text_five')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-shape">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('hotel/edit/policies').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                    <button type="submit" class="btn btn-default">{{trans('messages.keyword_accept')}}</button></div>
                </div>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
    <script type="text/javascript">
        function showbox(id){
            $("#"+id).show();
        }
    </script>
@endsection