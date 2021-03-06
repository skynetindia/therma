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


                {{ Form::open(['url'=> 'hotel/update/policies', 'id'=> 'hotel_policy_form', 'method'=> 'post']) }}

                <div class="row">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php
						$hotelPolicys = getHotelPolicies($hotelid);
                            $countPolicy = count($hotelPolicys);
                        ?>


                        <input type="hidden" id="noofchild" value="{{ ($countPolicy > 0) ? $countPolicy : '0' }}">
                        <input type="hidden" name="hotel_id" value="{{ isset($hotelid) ? $hotelid : ''}}">


                        <div class="section-border">
                            <div class="payment-information">
                                <div class="pull-right">
                                    <button class="btn btn-info" type="button" id="addchild"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-danger" type="button" id="removechild"><i class="fa fa-minus"></i></button>
                                </div>
                                <p class="blue-head bold">{{trans('messages.keyword_hotel')}} {{ trans('messages.keyword_policies') }}</p>
								@if($countPolicy > 0)	
                                @foreach($hotelPolicys as $key => $policy)
                                <div class="row" id="row0">
                                    <input type="hidden" name="policy_id[]" value="{{ $policy->id }}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_title')}} <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" value="{{ !empty($policy->title) ? $policy->title : '' }}" id="title" placeholder="{{trans('messages.keyword_title')}}"  name="title[]">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_description')}} <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" value="{{ !empty($policy->description) ? $policy->description : '' }}" id="description" placeholder="{{trans('messages.keyword_description')}}" name="description[]">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                  <div class="row" id="row0">
                                    <input type="hidden" name="policy_id[]" value="0">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_title')}} <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" value="" id="title" placeholder="{{trans('messages.keyword_title')}}"  name="title[]">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_description')}} <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" value="" id="description" placeholder="{{trans('messages.keyword_description')}}" name="description[]">
                                        </div>
                                    </div>
                                </div>                                
                                @endif

                                <div class="childmain"></div>

                                <div class="payment-ryt-footer">
                                    <button class="btn btn-default">@lang('messages.keyword_save')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::close() }}

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

                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_how_many_days_before_arrival')}}</label>
                                            <input type="text" class="form-control" id="credit_card_amount" placeholder="{{trans('messages.keyword_how_many_days_before_arrival')}}" value="{{(isset($hotel_detail->days_before_arrival)) ? $hotel_detail->days_before_arrival : ''}}" name="days_before_arrival">
                                        </div>
                                       
                                        <?php
                            $notingroup = getWizardOptionByCategory(22);
							//dd($notingroup)
							$arrselectcardcvc = explode(",",$hotel_detail->requested_card_cvc);
                            ?>
                              <div class="payment-checkbox">
                            @foreach($notingroup as $keynoind => $valnoind)

                               <div class="ryt-chk-content">
                                                <div class="ryt-chk"><?php 
											if (isset($valnoind->id) && $valnoind->id != null) {
											$selectvalcredit_card_options = isset($hotel_detail->credit_card_options) ? $hotel_detail->credit_card_options : null;
												echo createwizard($valnoind, '1','credit_cards',$selectvalcredit_card_options);
											}
                                       ?></div><?php 
									 $checkCVC = (in_array($valnoind->id,$arrselectcardcvc)) ? 'checked' : '';
										echo '<div class="ryt-chk">
                                        <input name="card_cvc[]" id="id_card_cvc'.$valnoind->title.'" '.$checkCVC.'  value="'.$valnoind->id.'" type="checkbox"><label class="control-label" for="id_card_cvc'.$valnoind->title.'">Requested Card CVC? </label></div>';  
								?></div>
                            @endforeach
                                <div class="hotel-amenties-add">
                                    <a href="javascript:void(0)" onclick="newoption(22)" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-6-12">Add New</a>
                                </div>
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
                             @php $policyday=(isset($cancelation_policy[$keytaxo]) && (isset($cancelation_policy[$keytaxo]->policy_day)))?$cancelation_policy[$keytaxo]->policy_day:0;
                             
                                 $policyper=(isset($cancelation_policy[$keytaxo]) && (isset($cancelation_policy[$keytaxo]->percentage))) ? $cancelation_policy[$keytaxo]->percentage:0;

                                  $checked=(isset($cancelation_policy[$keytaxo]) && (isset($cancelation_policy[$keytaxo]->percentage))) ?"checked":'';

                                  $disabled=(isset($cancelation_policy[$keytaxo]) && (isset($cancelation_policy[$keytaxo]->percentage)))?"":'disabled';
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



    <script>

        $("#hotel_policy_form").validate({
            rules: {
                "title[]": {
                    required: true,
                    maxlength: 50
                },
                "description[]": {
                    required: true
                }
            },
            messages: {
                "title[]": {
                    required: "{{trans('messages.keyword_please_enter_a_title')}}"
                },
                "description[]": {
                    required: "{{trans('messages.keyword_please_enter_a_description')}}"
                }
            }
        });



        counter=$('#noofchild').val();

        $('#addchild').click(function(e) {
            counter++;
            $('.childmain').append("<div class='row' id='row"+ counter +"'><input type=\"hidden\" name=\"policy_id[]\" value=\"0\"><div class=\"col-md-6\">\n" +
                "        <div class=\"form-group\">\n" +
                "            <label for=\"\">{{trans('messages.keyword_title')}} <span class=\"required\">(*)</span></label>\n" +
                "            <input type=\"text\" class=\"form-control\" id=\"title\" placeholder=\"{{trans('messages.keyword_title')}}\" value=\"\" name=\"title[]\">\n" +
                "        </div>\n" +
                "    </div>\n" +
                "\n" +
                "    <div class=\"col-md-6\">\n" +
                "        <div class=\"form-group\">\n" +
                "            <label for=\"\">{{trans('messages.keyword_description')}} <span class=\"required\">(*)</span></label>\n" +
                "            <input type=\"text\" class=\"form-control\" id=\"description\" placeholder=\"{{trans('messages.keyword_description')}}\" value=\"\" name=\"description[]\">\n" +
                "        </div>\n" +
                "    </div></div>");
            $('#noofchild').val(counter);
        });
        $('#removechild').click(function(e) {

                //alert(counter);

                if(counter==0){
                    alert("you cannot delete first record");
                    return true;
                }

                $("#row" + counter).remove();
                counter--;

        });
    </script>

    <script type="text/javascript">
        function newoption(val)
        {
            $('#catid').val(val);
        }
    </script>

    <script type="text/javascript">


        function saveoption()
        {

            var name=$('#name').val();
            var catid=$('#catid').val();
            var urlredirect="{{url('hotel/wizard/new')}}";
            $.ajax({
                type: "POST",
                url :urlredirect ,
                data:{'name':name,"catid":catid,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    $('#myModal').modal('hide');
                    window.location.reload(true);
                }
            });
        }
    </script>

@endsection



<div class="modal fade hotel-prices1-new-modal"  id="myModal" role="dialog">
    <div class="modal-dialog" >

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Wizard</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input class="form-control" id="name" placeholder="" name="name" type="text">
                            <input class="form-control" id="catid" name="catid" placeholder="" type="hidden">
                        </div>
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default btn-6-12" data-dismiss="modal" onclick="saveoption();">save</button>
            </div>
        </div>

    </div>
</div>

