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
                            <li class="navigation-item navigation-previous-item navigation-active-item" id="seven"></li>
                            <li class="navigation-item" id="eight"></li>
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
                        <p class="bold blue-head">Cancellation Policy</p>
                        <div class="add-hotel-lft-8-wrap"><?php 
                        $taxoinfo = getTaxonomies('taxinomies_cancellation_policy');
                        $selecedArray = array();
                        $selecedPercentage = array();

                        foreach($cancelation_policy as $kcp => $vcp){
                            $selecedArray[$kcp] = $vcp->policy_id;
                            $selecedPercentage[$vcp->policy_id] = $vcp->percentage;
                        }                        
                        ?>
                            @foreach($taxoinfo as $keytaxo => $valtaxo)
                            <div class="add-hotel-lft-8">
                                <div class="form-group">
                                    <label for="">{{trans('messages.'.$valtaxo->language_key)}}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <div class="ryt-chk">
                                                <input id="chk_policy_{{$valtaxo->id}}" {{(in_array($valtaxo->id,$selecedArray)) ? 'checked' : ''}} name="chk_policy[{{$valtaxo->id}}]" type="checkbox" value="{{$valtaxo->id}}">
                                                <label for="chk_policy_{{$valtaxo->id}}"></label>
                                            </div>
                                        </div>
                                        <input class="form-control" id="fees" value="{{isset($selecedPercentage[$valtaxo->id]) ? $selecedPercentage[$valtaxo->id] : ''}}" 
                                        name="percentage[{{$valtaxo->id}}]" placeholder="{{trans('messages.keyword_fees')}}" type="text">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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