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
                            <li class="navigation-item  navigation-previous-item navigation-active-item" " id="eight"></li>
                            <li class="navigation-item id="nine"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-hotel-8 payment-policies-wrap"><?php
        if (isset($hotelid) && !empty($hotelid)) {
            echo Form::open(array('url' => '/update/hotelpaymentpolicy' . "/" . $hotelid, 'files' => true, 'id' => 'frmHotelPaymentPolicy'));
        } else {
            echo Form::open(array('url' => '/update/hotelpaymentpolicy', 'files' => true, 'id' => 'frmHotelPaymentPolicy'));
        }
    ?><input type="hidden" name="hotel_id" value="{{isset($hotelid) ? $hotelid : ''}}">    
            <div class="row">
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="section-border">
                        <div class="add-hotel-lft-8-wrap">
                            <div class="add-hotel-lft-8">
                                <div class="form-group">
                                    <label>{{trans('messages.keyword_title')}}</label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{isset($policy_details->title) ? $policy_details->title : old('title')}}">                                    
                                </div>
                                <div class="form-group">
                                    <label>{{trans('messages.keyword_description')}}</label>                                    
                                    <textarea class="form-control" name="description" id="description">{{isset($policy_details->description) ? $policy_details->description : old('description')}}</textarea>
                                </div>                               
                                <label class="bold">{{trans('messages.keyword_payment_options_for_guests')}}</label>
                                <div class="form-group">
                                    <label>{{trans('messages.keyword_hw_many_day_before_stay_canceled_for_free')}}</label>
                                    <select class="form-control" name="cancel_days" id="cancel_days">
                                        <option>{{trans('messages.keyword_arrival_day')}} (By 18:00)</option>
                                        @foreach($arrivaldays as $key => $val)
                                        <option value="{{$val}}" <?php echo (isset($policy_details->cancel_days) && $policy_details->cancel_days == $val) ? 'selected' : '';?>>{{$val}}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('messages.keyword_otherwise_guests_pay')}}</label>
                                    <select class="form-control" name="pay_types" id="pay_types">
                                        <option>{{trans('messages.keyword_of_the_first_night')}}</option>
                                        @foreach($arrivaldays as $key => $val)
                                        <option value="{{$val}}" <?php echo (isset($policy_details->pay_types) && $policy_details->pay_types == $val) ? 'selected' : '';?>>{{$val}}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="alert alert-info alert-box">
                                        <a href="#"><i class="fa fa-bell" aria-hidden="true"></i>L'ospite deve cancellare entro le ore 18:00 del giomo di arrivo, in caso contrario paghera il 100% del costo della prima notte.</a>
                                        <p>Attenzione: potrai modificare le tue condizioni anche piu tardi. Queste sono soltanto le impostazioni iniziali.</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="bold">{{trans('messages.keyword_taxes')}}</p>
                                    <div class="bg-grey">
                                        <p>{{trans('messages.keyword_set_your_travel_tax_or_guests_what_included_price.')}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="bold">{{trans('messages.keyword_tax_/_vat_settings')}}</p>
                                    <div class="radio-wrap">
                                        <div class="radio round-radio">
                                            <input id="radio2" name="vat_settings" type="radio" 
                                            <?php echo (isset($policy_details->vat_settings) && $policy_details->vat_settings == '0') ? 'checked' : '';?> value="0" checked="checked">
                                            <label for="radio2">{{trans('messages.keyword_default_options_usually_room_prices')}}</label>
                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </div>
                                        <div class="radio round-radio">
                                            <input id="radio3" <?php echo (isset($policy_details->vat_settings) && $policy_details->vat_settings == '0') ? 'checked' : '';?> name="vat_settings" type="radio" value="1">
                                            <label for="radio3">{{trans('messages.keyword_i_do_not_have_to_pay_vat')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="bold">{{trans('messages.keyword_city_tax')}}</p>
                                    <div class="radio-wrap">
                                        <div class="radio round-radio">
                                            <input id="radio4" <?php echo (isset($policy_details->city_tax) && $policy_details->city_tax == '0') ? 'checked' : '';?>  name="city_tax" type="radio" value="0">
                                            <label for="radio4">{{trans('messages.keyword_default_options_city_tax')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="radio round-radio">
                                            <input id="radio5" <?php echo (isset($policy_details->city_tax) && $policy_details->city_tax == '1') ? 'checked' : '';?> name="city_tax" type="radio" value="1">
                                            <label for="radio5">{{trans('messages.keyword_custom')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="bold">{{trans('messages.keyword_payment_of_commissions')}}</p>
                                    <div class="bg-grey">{{trans('messages.keyword_pay_the_commission_text')}}</div>
                                </div>

                                <div class="form-group">
                                    <p class="bold blue-head">{{trans('messages.keyword_billing_information')}}</p>
                                    <div class="bg-grey">
                                        {{trans('messages.keyword_billing_information_text')}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('messsages.keyword_select_recipients_of_the_invoice')}}</label>
                                    <select class="form-control">
                                        <option>An Front</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p class="bold">{{trans('messages.keyword_the_recipient_holder_iva_match')}}</p>
                                    <div class="bg-grey">
                                        {{trans('messages.keyword_your_vat_id_is_required_note')}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio-wrap">
                                        <div class="radio round-radio radio-inline">
                                            <input id="radio6" <?php echo (isset($policy_details->is_iva_match) && $policy_details->is_iva_match == '0') ? 'checked' : '';?> name="is_iva_match" type="radio" value="0">
                                            <label for="radio6">{{trans('messages.keyword_yes,_the_iva_and')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="radio round-radio radio-inline">
                                            <input id="radio7" <?php echo (isset($policy_details->is_iva_match) && $policy_details->is_iva_match == '1') ? 'checked' : '';?> name="is_iva_match" type="radio" value="1">
                                            <label for="radio7">{{trans('messages.keyword_no,_the_recipient_does_not_have_an_vat_number')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="IT" name="iva_detail" value="<?php echo (isset($policy_details->iva_detail)) ? $policy_details->iva_detail : '';?>" type="text">
                                </div>

                                <div class="form-group"><hr></div>
                                <div class="form-group">
                                    <div class="bold blue-head">{{trans('messages.keyword_bank_data_for_direct_debit')}}</div>
                                    <div class="bg-grey"><p>{{trans('messages.keyword_registration_and_bullshit')}}</p></div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="">IBAN</label>
                                        <input class="form-control" placeholder="IBAN" value="<?php echo (isset($policy_details->iban)) ? $policy_details->iban : '';?>" name="iban" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                    <label for="">{{trans('messages.keyword_name_and_last_name_of_the_account_holder')}}</label>
                                    <input class="form-control" name="account_holder_name"  value="<?php echo (isset($policy_details->account_holder_name)) ? $policy_details->account_holder_name : '';?>" placeholder="{{trans('messages.keyword_name_and_last_name_of_the_account_holder')}}" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="ryt-chk">
                                        <input id="accept_terms_condition" value="1" type="checkbox">
                                        <label for="accept_terms_condition">{{trans('messages.keyword_accept_payment_poicy_terms_text')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="section-border">
                        <div class="add-hotel-ryt-8">
                            <div class="payment-box-wrap">
                                <label class="bold">{{trans('messages.keyword_payment_options_for_guests')}}</label>
                                <div class="bg-grey">
                                    <p>{{trans('messages.keyword_payment_policy_text_messsage1')}}</p>
                                </div>
                                <div class="form-group">
                                    <label class="blue-head">{{trans('messages.keyword_do_i_accept_credit_card_payments')}}</label>
                                    <div class="radio-wrap">
                                        <div class="radio-inline round-checkbox">
                                            <input id="radio" <?php echo (isset($policy_details->is_accept_cards) && $policy_details->is_accept_cards == '0') ? 'checked' : '';?> name="accept_card" type="radio" value="0">
                                            <label for="radio">{{trans('messages.keyword_yes')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                        <div class="radio-inline round-checkbox">
                                            <input id="radio1"  <?php echo (isset($policy_details->is_accept_cards) && $policy_details->is_accept_cards == '1') ? 'checked' : '';?> name="accept_card" type="radio" value="1">
                                            <label for="radio1">{{trans('messages.keyword_no')}}</label>
                                            <div class="check"><div class="inside"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group"><?php
                                    $selectCards = isset($policy_details->card_type) ? explode(",", $policy_details->card_type) : array();
                                        $wizardoptions = getWizardOptionByCategory('17');
                                        foreach ($wizardoptions as $key => $value) {                                            
                                         ?><div class="ryt-chk">
                                            <input id="pay{{$key}}" name="cards[]" <?php echo (in_array($value->id, $selectCards)) ? 'checked' : ''; ?> type="checkbox" value="{{$value->id}}">
                                            <label for="pay{{$key}}"><img src="{{url('images/widget_icon/'.$value->option_image)}}">{{trans('messages.'.$value->language_key)}}</label>
                                            </div><?php
                                        }
                                        ?></div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-shape">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left">                     
                    <a href="{{ url('hotel/edit/media').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                        <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
                    </div>
                </div>
            </div>
                <?php echo Form::close(); ?>
        </div>
    </div>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
          $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#frmHotelPaymentPolicy").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 50
                    },
                    description: {
                        required: true
                    },              
                    iban: {
                        required: true,                        
                    },
                    account_holder: {
                        required: true                        
                    }
                },
                messages: {
                    title: {
                        required: "{{trans('messages.keyword_please_enter_a_title')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    description:{
                        required: "{{trans('messages.keyword_please_enter_a_description')}}",
                    },
                    iban: {
                        required: "{{trans('messages.keyword_please_enter_a_iban')}}",                        
                    },
                    account_holder: {
                        required: "{{trans('messages.keyword_please_enter_a_account_holder')}}"
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
@endsection