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
        echo Form::open(array('url' => '/update/hotelbasicinfo' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelDetailInfo'));
    } else {
        echo Form::open(array('url' => '/update/hotelbasicinfo', 'files' => true, 'id' => 'frmHotelDetailInfo'));
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
                                            <label>{{trans('messages.keyword_hotel_name')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_hotel_name')}}" value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}" name="name" id="name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_password')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_password')}}" value="" name="password" id="password" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_category')}}<span class="required">(*)</span></label>
                                            <select class="form-control" name="hotel_category" id="hotel_category">
                                                <option value="">-</option>
                                                @foreach($hotel_category as $keyhc => $valhc)
                                                    @php $selectedcatStatus = (isset($hoteldetails->category_id) && ($valhc->id == $hoteldetails->category_id)) ? 'selected' : (old('hotel_category') == $valhc->id) ? 'selected' : ''
                                                    @endphp
                                                    <option value="{{$valhc->id}}" {{$selectedcatStatus}}>{{$valhc->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--<div class="form-group">
                                            <label for="">{{trans('messages.keyword_hotel_status')}} <span class="required">(*)</span></label>
                                            <select class="form-control" name="status" id="status">
                                                @foreach($hotelstatus as $key => $val)
                                                    @php
                                                        $selectedStatus = (isset($hoteldetails->status) && ($val->id == $hoteldetails->status)) ? 'selected' : (old('status') == $val->id) ? 'selected' : ''
                                                    @endphp
                                                    <option value="{{$val->id}}" <?php //echo $selectedStatus; ?>>{{trans('messages.'.$val->language_key)}}</option>
                                                @endforeach
                                            </select>
                                        </div>-->
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_communication_language')}}</label>
                                            <select class="form-control selecttwoclass" name="communication_lang[]" id="communication_lang" multiple="multiple">
                                                @foreach($arrlanguages as $keylang => $vallang)
                                                    @php $comlan=(isset($hoteldetails->communication_lang))?explode(',',$hoteldetails->communication_lang):array();
                                                    $selectedcomlang = (in_array($vallang->id,$comlan)) ? 'selected' : (old('communication_lang') == $keylang) ? 'selected' : '' @endphp
                                                    <option value="{{$vallang->id}}" {{$selectedcomlang}}>{{strtoupper($vallang->code)}}
                                                        / {{$vallang->original_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_contact_person')}}<span class="required">(*)</span></label>
                                            <input class="form-control " id="contact_person" name="contact_person"
                                               placeholder="{{trans('messages.keyword_contact_person')}}" type="text" value="{{isset($hoteldetails->contact_person) ? $hoteldetails->contact_person : ''}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_number">{{trans('messages.keyword_contact_number')}}<span class="required">(*)</span></label>
                                            <input class="form-control phone" id="contact_number" name="contact_number" placeholder="{{trans('messages.keyword_contact_number')}}" type="text" value="{{isset($hoteldetails->contact_no) ? $hoteldetails->contact_no : ''}}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                  <label for="hotel_phone ">{{trans('messages.keyword_phone')}}</label>
                                                  <input class="form-control phone" id="hotel_phone" name="hotel_phone" placeholder="{{trans('messages.keyword_phone')}}" type="text" value="{{isset($hoteldetails->phone) ? $hoteldetails->phone : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                  <label for="hotel_fax ">{{trans('messages.keyword_fax')}}</label>
                                                  <input class="form-control phone" id="hotel_fax" name="hotel_fax" placeholder="{{trans('messages.keyword_fax')}}" type="text" value="{{isset($hoteldetails->fax) ? $hoteldetails->fax : ''}}">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label for="hotel_country">{{trans('messages.keyword_country')}}<span class="required">(*)</span></label>
                                            <select required class="form-control selecttwoclass" id="hotel_country" name="hotel_country" placeholder="{{trans('messages.keyword_country')}}" >
                                                <option value="">{{trans('messages.keyword_country')}}</option>
                                                @foreach($country as $conkey=>$conval)
                                                <option value="{{$conval->i_id}}" {{(isset($hoteldetails->country)&& $hoteldetails->country==$conval->i_id)?'selected':''}}>{{$conval->v_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>    
                                        <div class="form-group">
                                            <label for="hotel_website">{{trans('messages.keyword_website')}}</label>
                                            <input class="form-control" id="hotel_website" name="hotel_website" placeholder="{{trans('messages.keyword_website')}}" type="text" value="{{isset($hoteldetails->web_url) ? $hoteldetails->web_url : ''}}" type="url">
                                        </div>                                                
                                    </div>                                    
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>{{trans('messages.keyword_general_email')}}<span class="required">(*)</span> </label>
                                            <input class="form-control" value="{{(isset($hoteldetails->general_email)) ? $hoteldetails->general_email : old('general_email')}}" placeholder="{{trans('messages.keyword_general_email')}}" type="email" name="general_email" id="general_email">
                                        </div>
                                        <div class="form-group">
                                          <label for="reservation_email">{{trans('messages.keyword_email_for_reservation')}}</label>
                                          <input required class="form-control" id="reservation_email" value="{{(isset($hoteldetails->reservation_email)) ? $hoteldetails->reservation_email : old('reservation_email')}}" name="reservation_email" placeholder="{{trans('messages.keyword_email_for_reservation')}}" type="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="billing_email">{{trans('messages.keyword_email_for_billing')}}</label>
                                            <input class="form-control" id="billing_email" name="billing_email" value="{{(isset($hoteldetails->billing_email)) ? $hoteldetails->billing_email : old('billing_email')}}" placeholder="{{trans('messages.keyword_email_for_billing')}}" type="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="transfer_email">{{trans('messages.keyword_email_for_transfers')}}</label>
                                            <input class="form-control" id="transfer_email" name="transfer_email" value="{{(isset($hoteldetails->transfer_email)) ? $hoteldetails->transfer_email : old('transfer_email')}}" placeholder="{{trans('messages.keyword_email_for_transfers')}}" type="email">
                                        </div>
                                        <div class="form-group">
                                           <label for="sold_out_email">{{trans('messages.keyword_email_for_sold_out')}}</label>
                                           <input class="form-control" id="sold_out_email" name="sold_out_email" value="{{(isset($hoteldetails->sold_out_email)) ? $hoteldetails->sold_out_email : old('sold_out_email')}}" placeholder="{{trans('messages.keyword_email_for_sold_out')}}" type="email">
                                        </div> 
                                        <div class="form-group">
                                            <label for="city_tax">{{trans('messages.keyword_city_tax')}}</label>
                                            <input class="form-control" id="city_tax" name="city_tax" value="{{(isset($hoteldetails->city_tax)) ? $hoteldetails->city_tax : old('city_tax')}}" placeholder="{{trans('messages.keyword_city_tax')}}" type="text">
                                        </div>
                                         <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                  <label for="">{{trans('messages.keyword_hotel_commission')}} (%)</label>
                                                  <input required class="form-control" id="hotel_commission" name="hotel_commission" value="{{(isset($hoteldetails->commission)) ? $hoteldetails->commission : old('hotel_commission')}}" placeholder="{{trans('messages.keyword_commission_will_be_approved_after_confirmation')}}" <?php echo (isset(Auth::user()->profile_id) && Auth::user()->profile_id == '0') ? '' : 'disabled'; ?>  type="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                  <label for="treatment_commission">{{trans('messages.keyword_treatment_commission')}} (%)</label>
                                                  <input required class="form-control" <?php echo (isset(Auth::user()->profile_id) && Auth::user()->profile_id == '0')  ? '' : 'disabled'; ?> value="{{(isset($hoteldetails->treatment_commission)) ? $hoteldetails->treatment_commission : old('treatment_commission')}}" id="treatment_commission" name="treatment_commission" placeholder="{{trans('messages.keyword_commission_will_be_approved_after_confirmation')}}" type="number">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="hotel_state">{{trans('messages.keyword_state')}}</label>
                                                    <select required class="form-control selecttwoclass" id="hotel_state" name="hotel_state" >
                                                        <option value="">{{trans('messages.keyword_state')}}</option>
                                                        @foreach($states as $stkey=>$stval)
                                                        <option value="{{$stval->i_id}}" {{(isset($hoteldetails->state)&& $hoteldetails->state==$stval->i_id)?'selected':''}}>{{$stval->v_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="hotel_country">{{trans('messages.keyword_city')}}</label>
                                                    <select required class="form-control selecttwoclass" id="hotel_city" name="hotel_city"  >
                                                        <option value="">{{trans('messages.keyword_city')}}</option>
                                                        @foreach($city as $ctkey=>$ctval)
                                                        <option value="{{$ctval->i_id}}" {{(isset($hoteldetails->city)&& $hoteldetails->city==$ctval->i_id)?'selected':''}}>{{$ctval->v_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                         
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">                                        
                                        <p class="bold blue-head">{{trans('messages.keyword_address')}}</p>
                                         <div class="form-group">
                                            <!--<label for="">{{trans('messages.keyword_address')}} <span class="required">(*)</span></label>-->
                                            <input class="form-control" placeholder="{{trans('messages.keyword_find_your_address')}}" value="{{(isset($hoteldetails->address)) ? $hoteldetails->address : old('address')}}" id="contact_address" placeholder="{{trans('messages.keyword_address')}}" name="address" type="text">
                                        </div>
                                        <div class="map" id="map" style="height:450px;width:100%;"></div>
                                    </div>  
                                </div>
                            </div>                                        
                                <!--<div class="row">
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
                                     </div>-->
                                    <!--<div class="row">
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
                                        </div>-->                                       
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
	
	$('#hotel_country').change(function(e){
			$.post("{{url('check-country')}}",
				{'country':$(this).val(),'_token': "{{ csrf_token() }}"},
				function(data){
					$('#hotel_state').html(data);
					$('#hotel_state').select2();
			});
});
$('#hotel_state').change(function(e){
	$.post("{{url('check-state')}}",
			{'state':$(this).val(),'_token': "{{ csrf_token() }}"},
			function(data){
				$('#hotel_city').html(data);
				$('#hotel_city').select2();
			});
});
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

		$.validator.addMethod("pwcheck", function(value) {
			if(value!='')
			return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
				 && /[a-z]/.test(value)
				 && /[A-Z]/.test(value) // has a lowercase letter
				 && /\d/.test(value) ;// has a digit
			else return true;	 
		});
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
                    password: {
						@if(!isset($hoteldetails->id))
                        required: true,
						@endif
						pwcheck:true
                       
                    },
                    general_email: { 
						required:true ,                   
                        email: true
                    },
                   
					contact_number:{
						required:true
					},
					contact_person:{
						required:true
					},
					hotel_commission:{
						max:100
					},
					treatment_commission:{
						max:100
					},
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
					password: {
						@if(!isset($hoteldetails->id))
                        required: "{{trans('messages.keyword_please_enter_password')}}",
						@endif
                        pwcheck:"{{trans('messages.keyword_password_check')}}"
                    },
                    general_email: {
                        required: "{{trans('messages.keyword_please_enter_a_general_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_general_email')}}"
                    },
                   
					contact_number:{
						 required: "{{trans('messages.keyword_please_enter_contact_person_number')}}"
					},
					contact_person:{
						 required: "{{trans('messages.keyword_please_enter_contact_person')}}"
					},
					hotel_commission:{
						max:"@lang('messages.keyword_please_enter_value_less_than_100')"
					},
					treatment_commission:{
						max:"@lang('messages.keyword_please_enter_value_less_than_100')"
					},
                }
            });
            $.validator.setDefaults({
                ignore: []
            });
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-######"}];
            $('.phone').inputmask({
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
	  //AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE    AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&libraries=places&callback=initMap" async defer></script>
 
@endsection