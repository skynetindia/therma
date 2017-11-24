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
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item  navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php
    if (isset($contactdetail) && !empty($contactdetail) && $action == 'edit') {
        echo Form::open(array('url' => '/update/hotelcontactdetail' . "/" . $contactdetail->id, 'files' => true, 'id' => 'frmHotelContactDetails'));
    } else {
        echo Form::open(array('url' => '/update/hotelcontactdetail', 'files' => true, 'id' => 'frmHotelContactDetails'));
    }
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="contact_id" value="{{isset($contactdetail->id) ? $contactdetail->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">                    		
        <div class="col-md-12 col-sm-12 col-xs-12">	
            <div class="basic-info-lft">
                <div class="section-border">
                    <p class="bold blue-head">@lang('messages.keyword_contact_us')</p>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         	<label for="">{{trans('messages.keyword_company')}}/{{trans('messages.keyword_hotel_name')}} <span class="required">(*)</span></label>
                         	<input class="form-control" placeholder="{{trans('messages.keyword_company')}}/{{trans('messages.keyword_hotel_name')}}" value="{{(isset($contactdetail->hotel_name)) ? $contactdetail->hotel_name : $hoteldetails->name}}" name="contact_hotel_name" id="contact_hotel_name" type="text" required>
			                  </div>
                       <div class="form-group">
              			    <label for="">{{trans('messages.keyword_contact_person')}} <span class="required">(*)</span></label>
  		                  <input class="form-control"  value="{{(isset($contactdetail->contact_person)) ? $contactdetail->contact_person : $hoteldetails->contact_person}}" id="contact_person" name="contact_person" placeholder="{{trans('messages.keyword_contact_person')}}" type="text">
              			   </div>
             <div class="form-group">
                <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                <input class="form-control inputmask-formate" id="hotel_phone" name="hotel_phone"
                       placeholder="{{trans('messages.keyword_phone')}}" type="text"
                       value="{{(isset($contactdetail->phone)) ? $contactdetail->phone :$hoteldetails->phone}}">
            </div>
            <div class="form-group">
                <label for="">{{trans('messages.keyword_fax')}} <span
                            class="required">(*)</span></label>
                <input class="form-control"
                       value="{{(isset($contactdetail->fax)) ? $contactdetail->fax : old('hotel_fax')}}"
                       id="hotel_fax" placeholder="{{trans('messages.keyword_fax')}}"
                       name="hotel_fax" type="text">
            </div>        
            <div class="form-group">
                <label for="">{{trans('messages.keyword_zip_code')}} </label>
                <input class="form-control"
                       value="{{(isset($contactdetail->zip_code)) ? $contactdetail->zip_code : old('zip_code')}}"
                       id="zip_code" name="zip_code"
                       placeholder="{{trans('messages.keyword_zip_code')}}" type="text">
            </div>
          
             <div class="form-group">
                <label for="">{{trans('messages.keyword_web')}}</label>
                <input class="form-control"
                       value="{{(isset($contactdetail->web)) ? $contactdetail->web : old('hotel_weburl')}}"
                       id="hotel_weburl" name="hotel_weburl"
                       placeholder="{{trans('messages.keyword_web')}}" type="text">
            </div>
             <div class="form-group">
                <label for="">{{trans('messages.keyword_id')}}</label>
                <input class="form-control" value="{{(isset($contactdetail->identifications)) ? $contactdetail->identifications : old('identifiaction')}}" id="identifications" placeholder="{{trans('messages.keyword_id')}}" name="identifications" type="text">
            </div>
            <div class="form-group">
                <label for="">{{trans('messages.keyword_vat_id')}}</label>
                <input class="form-control" value="{{(isset($contactdetail->vat_id)) ? $contactdetail->vat_id : old('vat_id')}}" id="vat_id" placeholder="{{trans('messages.keyword_vat_id')}}" name="vat_id" type="text">
            </div>   </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
             <p class="bold blue-head">This is the location we will provide guests. click and drag the map</p>
              <input class="form-control" value="{{(isset($contactdetail->address)) ? $contactdetail->address : $hoteldetails->address}}" id="pac-input" placeholder="{{trans('messages.keyword_address')}}"
               name="address" type="text">
                <div class="map" id="map" style="height:550px;width:100%;"></div>
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
            $("#frmHotelContactDetails").validate({
                rules: {
                    contact_hotel_name: {
                        required: true,
                        maxlength: 50
                    },
                    contact_person: {
                        required: true
                    },				
                    contact_address: {
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
						url:true
					}
                },
                messages: {
                    contact_hotel_name: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
					contact_person:{
						required: "{{trans('messages.keyword_please_enter_a_conatct_person')}}",
					},
                    contact_address: {
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
                        url: "{{trans('messages.keyword_please_enter_a_valid_url')}}"
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
    
	
    
	  var circle;

      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 41.885977605235377, lng: 12.480394244191757},
          zoom: 7
        });
        /*var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 41.885977605235377, lng: 12.480394244191757},
          zoom: 7
        });*/
		//var infowindow = new google.maps.InfoWindow;
		/*var circle1 = new google.maps.Circle({
				center: new google.maps.LatLng(41.88597760523537, 12.480394244191757),
				map: map,
				radius: 65824.04444800339,          // IN METERS.
				fillColor: '#FF6600',
				fillOpacity: 0.3,
				strokeColor: "#FFF",
				strokeWeight: 0 ,
				       // DON'T SHOW CIRCLE BORDER.
			});*/
      /** @type {!HTMLInputElement} */
      var input = document.getElementById('pac-input');
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
		  var lat = place.geometry.location.lat();
		  var long = place.geometry.location.lng();
		  $("#lat").val(lat);
 		  $("#long").val(long);
          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });
		//google.maps.event.addDomListener(window, 'load', initMap);		
      }
	  

  </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>
@endsection