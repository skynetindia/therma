@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
	<link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('public/js/select2.full.min.js')}}"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();
    ?>
    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item" id="firstst"></li>
                        <li class="navigation-item navigation-previous-item  navigation-active-item" id="secondst"></li>
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
        echo Form::open(array('url' => '/update/hoteldetail' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelDetailInfo'));
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
                                <p class="bold blue-head">{{trans('messages.keyword_basic_information')}}</p>
                                
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_status')}} <span class="required">(*)</span></label>
                                            <select class="form-control" name="status" id="status">
                                                @foreach($hotelstatus as $key => $val)
                                                    @php
                                                        $selectedStatus = (isset($hoteldetails->status) && ($val->id == $hoteldetails->status)) ? 'selected' : (old('status') == $val->id) ? 'selected' : ''
                                                    @endphp
                                                    <option value="{{$val->id}}" <?php echo $selectedStatus; ?>>{{trans('messages.'.$val->language_key)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_hotel_name')}} <span
                                                        class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_hotel_name')}}" value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}"  name="name" id="name" type="text" required readonly>
                                        </div>
                                    </div>
                                      <div class="col-md-4 col-sm-12 col-xs-12">
                                     @if(isset($hoteldetails->logo) && $hoteldetails->logo !="")
                                    
                                            <img src="{{url('storage/app/images/hotel/'.$hoteldetails->logo)}}" width="100px"/>
                                            
                                      @endif 
                                      </div>
                                      </div>
                                        <div class="row">
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
                                                               
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_communication_language')}}</label>
                                            <select class="form-control selecttwoclass" name="communication_lang"
                                                    id="communication_lang" multiple="multiple">
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
                                            <label>{{trans('messages.keyword_email')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_email')}}"  value="{{(isset($hoteldetails->email)) ? $hoteldetails->email : old('email')}}" name="email" id="email" type="email">
                                        </div>
                                    </div>
                                     </div>
                                        <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_general_email')}} </label>
                                            <input class="form-control"
                                                   value="{{(isset($hoteldetails->general_email)) ? $hoteldetails->general_email : old('  general_email')}}"
                                                   placeholder="{{trans('messages.keyword_general_email')}}"
                                                   type="email" name="general_email" id="general_email">
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="is_extarnal_login">{{trans('messages.keyword_extranet_login')}}</label>
                                            <select class="form-control" name="is_extarnal_login"
                                                    id="is_extarnal_login">
                                                 @foreach(getyesno() as $ynkey => $ynval)   
                                                  @php
                                                    $selectedyeson = (isset($hoteldetails->is_extarnal_login) && ($ynkey== $hoteldetails->is_extarnal_login)) ? 'selected' : (old('is_extarnal_login') == $ynkey) ? 'selected' : '';
												  @endphp
                                                <option value="{{$ynkey}}" {{$selectedyeson}}>{{$ynval}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                              
                                    <div class="col-md-4 col-sm-12 col-xs-12 credentials">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_login_name')}}</label>
                                            <input class="form-control" value="{{isset($userdetail->username)?$userdetail->username:''}}"
                                                   placeholder="{{trans('messages.keyword_login_name')}}"
                                                   name="{{ ($action == 'add') ? 'username' : 'username' }}" id="{{ ($action == 'add') ? 'username_required' : 'username' }}" type="text">
                                        </div>
                                    </div>
                                     </div>
                                        <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12 credentials">
                                        <div class="form-group">
                                            <p>{{ucwords(trans('messages.keyword_password'))}}</p>

                                            <a href="javascript:void(0);"
                                               class="change-pass bold  @if($action == 'add') none @endif"
                                               onclick="$(this).addClass('none');$('.change-pass-input').removeClass('none');">{{trans('messages.keyword_change_password')}}</a>
                                            <input class="form-control change-pass-input @if($action != 'add') none @endif" placeholder="{{trans('messages.keyword_password')}}" name="{{ ($action == 'add') ? 'password_required' : 'password' }}" id="{{ ($action == 'add') ? 'password' : 'password' }}" type="password">

                                        </div>
                                    </div>                                   
                          
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_portal_commission')}} (%)</label>
                                        <input class="form-control" id="commission" value="{{isset($hoteldetails->commission) ? $hoteldetails->commission : ''}}" name="commission"
                                               placeholder="{{trans('messages.keyword_portal_commission')}} (%)" type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_hotel_minimum_price')}}({{isset($defaultCurrency->symbol) ? $defaultCurrency->symbol : '€'}})</label>
                                        <input class="form-control" id="min_price" value="{{isset($hoteldetails->min_price) ? $hoteldetails->min_price : ''}}" name="min_price" placeholder="{{trans('messages.keyword_hotel_minimum_price')}}({{isset($defaultCurrency->symbol) ? $defaultCurrency->symbol : '€'}})" type="text" required>
                                    </div>
                                </div>
                                 </div>
                                        <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_contact_person')}}<span class="required">(*)</span></label>
                                        <input class="form-control" id="contact_person" name="contact_person"
                                               placeholder="{{trans('messages.keyword_contact_person')}}" type="text" value="{{isset($hoteldetails->contact_person) ? $hoteldetails->contact_person : ''}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_contact_number')}}<span class="required">(*)</span></label>
                                        <input class="form-control" id="contract_number" name="contract_number" placeholder="{{trans('messages.keyword_contact_number')}}" type="text" value="{{isset($hoteldetails->phone) ? $hoteldetails->phone : ''}}">
                                    </div>
                                </div>
                          
                                
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_resale_non_refundable_booking')}}</label>
                                        <select class="form-control" name="resel_non_refundable" id="resel_non_refundable">
                                            @foreach(getyesno() as $keyss => $valss)
                                            <option value="{{$keyss}}" {{(isset($hoteldetails->resale_non_refund_boking) && $hoteldetails->resale_non_refund_boking == $keyss) ? 'selected' : ''}}>{{$valss}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 </div>
                                        <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_check-in')}}</label>
                                        <input class="form-control" id="check_in" name="check_in"
                                               placeholder="{{trans('messages.keyword_check-in')}}" type="text" value="{{isset($hoteldetails->check_in) ? $hoteldetails->check_in : ''}}">
                                    </div>
                                </div>
                        
                                <div class="col-md-4 col-sm-12 col-xs-12 vat-chk">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_vat')}}</label>
                                        <div class="border-vat-chk">
                                            <div class="ryt-chk">
                                                <input type="checkbox"  {{(isset($hoteldetails->is_vat) && $hoteldetails->is_vat == '1') ? 'checked' : ''}} value="1" id="is_vat" name="is_vat" onchange="fun_vat(this.checked);">
                                                <label for="is_vat"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
								function fun_vat(val)
								{
									if(val==1)
									{
										$('.vat_number').removeClass('none');
									}
									else
									{
										$('.vat_number').addClass('none');
									}
									
								}
								</script>
                                <div class="col-md-4 col-sm-12 col-xs-12 @if(isset($hoteldetails->is_vat) && $hoteldetails->is_vat == '1') ''@else none @endif vat_number">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_vat_number')}}</label>
                                        <input class="form-control" id="vat_number" name="vat_number"
                                               placeholder="{{trans('messages.keyword_vat_number')}}" type="text" value="{{isset($hoteldetails->vat_number) ? $hoteldetails->vat_number : ''}}">
                                    </div>
                                </div>
                                 </div>
                                  <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_check-out')}}</label>
                                        <input class="form-control" id="check_out" name="check_out"
                                               placeholder="{{trans('messages.keyword_check-out')}}" type="text" value="{{isset($hoteldetails->check_out) ? $hoteldetails->check_out : ''}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_sale_standard_reservation')}}</label>
                                        <select class="form-control" name="sale_standard_reservation" id="sale_standard_reservation">
                                            @foreach(getyesno() as $keyss => $valss)
                                            <option value="{{$keyss}}" {{(isset($hoteldetails->sale_reservation) && $hoteldetails->sale_reservation == $keyss) ? 'selected' : ''}}>{{$valss}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">{{trans('messages.keyword_currency')}}</label>
                                     <select name="currency" id="currency" class="form-control">
                                     <option value=""></option>
                                     @foreach($currency as $cur)
                                     <option value="{{$cur->code}}" {{(isset($hotel_detail->currency_id) && $hotel_detail->currency_id==$cur->code)?'selected':''}}>{{$cur->name}}</option>
                                     @endforeach
                                     </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="basic-info-lft">
                    <div class="section-border">
                        <p class="bold blue-head">@lang('messages.keyword_location')</p>
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p class="bold blue-head">{{trans('messages.keyword_real_hotel_address')}}</p>
                                <div class="form-group">
                                    <!--<label for="">{{trans('messages.keyword_address')}} <span class="required">(*)</span></label>-->
                                    <input class="form-control" placeholder="{{trans('messages.keyword_find_your_address')}}" value="{{(isset($hoteldetails->address)) ? $hoteldetails->address : old('address')}}" id="contact_address" placeholder="{{trans('messages.keyword_address')}}" name="address" type="text">
                                </div>
                            </div> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="map" id="map" style="height:400px;width:100%;"></div>
                                <!--<div class="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12344567.431710659!2d3.5856134805201085!3d40.94182220553099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d4fe82448dd203%3A0xe22cf55c24635e6f!2sItaly!5e0!3m2!1sen!2sin!4v1502167975265"
                                            width="280" height="550" frameborder="0" style="border:0"
                                            allowfullscreen></iframe>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        {{--Credit Cards--}}
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="hotel-detail-lft">
                    <div class="credit-card-box">
                        <div class="section-border set-height-section-border">
                            <p class="bold blue-head">{{trans('messages.keyword_credit_cards')}}</p>
                           
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_how_to_work_with_a_card')}}</label>
                                            <?php $arrtaxocc = getTaxonomies('taxinomies_vat_invoicing');
                                            ?>
                                            <select class="form-control" name="work_with_credit_card" id="work_with_credit_card">
                                            @foreach($arrtaxocc as $kccwork => $vccwork)
                                                <option value="{{$vccwork->id}}" {{(isset($hotel_detail->work_with_credit_card) && $hotel_detail->work_with_credit_card == $vccwork->id) ? 'selected' : ''}}>{{trans('messages.'.$vccwork->language_key)}}</option>
                                            @endforeach                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <label for="">{{trans('messages.keyword_amount')}} (%)</label>
                                       <input type="text" class="form-control" id="credit_card_amount" placeholder="{{trans('messages.keyword_amount')}} (%)" value="{{(isset($hotel_detail->credit_card_amount)) ? $hotel_detail->credit_card_amount : ''}}" name="credit_card_amount">
                                        </div>
                                    </div>
                                </div>
                            </div><?php
                            $notingroup = getWizardOptionByCategory(22);
                            ?>
                             <div class="set-min-height">
                            @foreach($notingroup as $keynoind => $valnoind)

                                <div class="row">
                                    <div class="form-group">
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
            </div>
            {{--Credit Cards--}}
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
	$(".selecttwoclass").select2();
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
            $("#frmHotelDetailInfo").validate({
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
                    email: {
                        required: true,
                        email: true
                    },
                    general_email: {                     
                        email: true
                    },
                    username_required : {
                        required: true,
                        maxlength: 50
                    },
                    password_required : {
                        required: true,
                        maxlength: 50
                    },
					contract_number:{
						required:true
					},
					contact_person:{
						required:true
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
					email: {
                        required: "{{trans('messages.keyword_please_enter_a_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_email')}}"
                    },
                    general_email: {
                        required: "{{trans('messages.keyword_please_enter_a_general_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_general_email')}}"
                    },
                    username_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    password_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
					contract_number:{
						 required: "{{trans('messages.keyword_please_enter_contact_person_number')}}"
					},
					contact_person:{
						 required: "{{trans('messages.keyword_please_enter_contact_person')}}"
					}
                }
            });
            $.validator.setDefaults({
                ignore: []
            });
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('#contract_number').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 41.885977605235377, lng: 12.480394244191757},
          zoom: 7
        });     
      /** @type {!HTMLInputElement} */
      var input = document.getElementById('contact_address');
      //var types = document.getElementById('type-selector');

       map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
       //map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        var image = "{{asset('public/marker.png')}}";
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
        icon: image,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
          anchorPoint: new google.maps.Point(0, -29)
        });
       autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
          /*var lat = place.geometry.location.lat();
          var long = place.geometry.location.lng();
          $("#lat").val(lat);
          $("#long").val(long);*/
          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });

        var acInputs = document.getElementsByClassName("addressautocomplete");
            for (var i = 0; i < acInputs.length; i++) {
                /*var autocomplete = new google.maps.places.Autocomplete(acInputs[i],options);*/
                var autocomplete1 = new google.maps.places.Autocomplete(acInputs[i]);
                autocomplete1.inputId = acInputs[i].id;
                google.maps.event.addListener(autocomplete1, 'place_changed', function () {
                    //document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
                });
            }
			function initAutocomplete() {
      //....codes...
       //....add this code just before close function...
    setTimeout(function(){ 
                $(".pac-container").prependTo("#mapMoveHere");
            }, 300);
}
        //google.maps.event.addDomListener(window, 'load', initMap);       
         
      }
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&sensor=false&libraries=places"></script>-->
    <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&sensor=false&libraries=places">-->
    <script type="text/javascript">
        /* Google Autocomplete for address *
        google.maps.event.addDomListener(window, 'load', function () {

            /*For the Edit all the text box give autocomplete *
            var acInputs = document.getElementsByClassName("addressautocomplete");
            for (var i = 0; i < acInputs.length; i++) {
                /*var autocomplete = new google.maps.places.Autocomplete(acInputs[i],options);*
                var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
                autocomplete.inputId = acInputs[i].id;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    //document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
                });
            }
        });*/
    </script>
@endsection