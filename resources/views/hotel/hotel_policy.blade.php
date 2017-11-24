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
    <div class="hotel-basic-information-new-hotel">
    
                   	
                    	<!---------------------===============================-------------------------------------->
                        
                     
             	<div class="step-page"><div class="row">
                		<div class="col-md-12">
                		<div class="navigation-root">
                            <ul class="navigation-list">
                                <li class="navigation-item navigation-previous-item " id="firstst"></li>
                                <li class="navigation-item navigation-previous-item " id="secondst"></li>
                                <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                                <li class="navigation-item navigation-previous-item navigation-active-item" id="fourthst"><span>Payment Information</span></li>
                                <li class="navigation-item" id="fifthst"></li>   
                            </ul>
                        </div>
                        </div>
					</div></div>
                    
                    <?php if (isset($hotelid) && !empty($hotelid)) {
							echo Form::open(array('url' => '/update/hotelpaymentpolicy' . "/" . $hotelid, 'files' => true, 'id' => 'frmHotelPaymentPolicy'));
						} else {
							echo Form::open(array('url' => '/update/hotelpaymentpolicy', 'files' => true, 'id' => 'frmHotelPaymentPolicy'));
						}
					?><input type="hidden" name="hotel_id" value="{{isset($hotelid) ? $hotelid : ''}}">    
                   <div class="row">
                   		<div class="col-md-6 col-sm-12 col-xs-12"> 
                            <div class="section-border">
                            
                                <div class="payment-information">
                                    	<p class="blue-head bold">{{trans('messages.keyword_credit_cards')}}</p>
                                        <div class="form-group">
                                        	<label>{{trans('messages.keyword_how_to_work_with_a_card')}}</label>
                                           <?php $arrtaxocc = getTaxonomies('taxinomies_credit_cards');?>
                                            <select class="form-control" name="work_with_credit_card" id="work_with_credit_card">
                                            @foreach($arrtaxocc as $kccwork => $vccwork)
                                                <option value="{{$vccwork->id}}" {{(isset($hotel_detail->work_with_credit_card) && $hotel_detail->work_with_credit_card == $vccwork->id) ? 'selected' : ''}}>{{trans('messages.'.$vccwork->language_key)}}</option>
                                            @endforeach                                                
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	 <label for="">{{trans('messages.keyword_amount')}} (%)</label>
                                       <input type="text" class="form-control" id="credit_card_amount" placeholder="{{trans('messages.keyword_amount')}} (%)" value="{{(isset($hotel_detail->credit_card_amount)) ? $hotel_detail->credit_card_amount : ''}}" name="credit_card_amount">
                                        </div>
                                        
                                       
                                        <?php
                            $notingroup = getWizardOptionByCategory(22);
							//dd($notingroup)
                            ?>
                              <div class="payment-checkbox">
                            @foreach($notingroup as $keynoind => $valnoind)

                               <div class="ryt-chk-content">
                                                <div class="ryt-chk">
                                        <?php 
                                        if (isset($valnoind->id) && $valnoind->id != null) {
                                        $selectvalcredit_card_options = isset($hotel_detail->credit_card_options) ? $hotel_detail->credit_card_options : null;
                                            echo createwizard($valnoind, '1','credit_cards',$selectvalcredit_card_options);
                                        }
                                        ?>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                                        	
                               </div>
                            
                           </div> 
                    	</div>
                        
                        
                        <div class="col-md-6 col-sm-12 col-xs-12"> 
                            <div class="section-border">
                            	<div class="payment-information-ryt">
                            		<p class="blue-head bold">Penalty</p>
                                    @php $taxoinfo = getTaxonomies('taxinomies_cancellation_policy');
                                 
                                    @endphp
                          <div class="ryt-chk-content">
                            @foreach($taxoinfo as $keytaxo => $valtaxo)
                             @php $policyday=isset($cancelation_policy[$keytaxo]->policy_day)?$cancelation_policy[$keytaxo]->policy_day:0;
                                 $policyper=isset($cancelation_policy[$keytaxo]->percentage)?$cancelation_policy[$keytaxo]->percentage:0;
                                  $checked=isset($cancelation_policy[$keytaxo]->percentage)?"checked":'';
                                  $disabled=isset($cancelation_policy[$keytaxo]->percentage)?"":'disabled';
                             @endphp
                                <div class="ryt-chk">
                                    <input id="one{{$keytaxo}}" type="checkbox" onClick="fun_checked(this.id)"  {{$checked}}>
                                    <label for="one{{$keytaxo}}">
                                        <input type="number" name="policy_day[]" class="one{{$keytaxo}}" value="{{$policyday}}" {{$disabled}}/> days before arrival 
                                        <input type="number" name="percentage[]" class="one{{$keytaxo}}" value="{{$policyper}}" {{$disabled}}/> % of the price per person
                                    </label>
                                </div>
                               @endforeach
                            </div>       
								<script>
                                function fun_checked(id){
                                    if($('#'+id).is(':checked')){
                                    
                                        $('.'+id).prop('disabled',false);
                                    }
                                    else
                                    $('.'+id).prop('disabled',true);
                                }
                                </script>
                                </div>
                            </div>
                        </div>    
                        
                 	</div>
                 
                   <div class="btn-shape">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left">                     
                    <a href="{{ url('hotel/edit/billinginfo').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                        <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
                    </div>
                </div>
            </div>
                <?php echo Form::close(); ?>
                                 
               </div>
       
       
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
          $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#frmHotelPaymentPolicy").validate({
                rules: {
                    work_with_credit_card: {
                        required: true,
                        maxlength: 50
                    },
                    credit_card_amount: {
                        required: true
                    },              
                    'policy_days[]': {
                        required: true,                        
                    },
                    'percentage[]': {
                        required: true                        
                    }
                },
                messages: {
                    work_with_credit_card: {
                        required: "{{trans('messages.keyword_please_enter_a_title')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    credit_card_amount:{
                        required: "{{trans('messages.keyword_please_enter_a_description')}}",
                    },
                     'policy_days[]': {
                        required: "{{trans('messages.keyword_please_enter_a_iban')}}",                        
                    },
                    'percentage[]': {
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