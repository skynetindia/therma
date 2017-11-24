@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="ssetting-wrap">
  <div class="section-border">                 
		<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
       	<h1 class="user-profile-heading"><?php echo isset($taxation->id) ? trans('messages.keyword_location_edit') : trans('messages.keyword_location_add') ?></h1><hr>
      </div>
    </div>
    <div class="row">
	   <div class="col-md-12 col-sm-12 col-xs-12">             		    	
      	<form action="{{url('/location/store')}}" id="taxation_form" method="post">
          {{ csrf_field() }}      
          	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                   <div class="form-group">
                      <label for="">{{trans('messages.keyword_name')}} <span class="required">(*)</span></label>
                      <input class="form-control" placeholder="{{trans('messages.keyword_name')}}" id="name" name="name" value="{{ isset($taxation->name) ? $taxation->name : "" }}" type="text" required>
                   </div>
                 </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                 <div class="form-group">
                    <label for="">{{trans('messages.keyword_description')}} <span class="required">(*)</span></label>
                    <textarea class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description" id="description" required="required">{{isset($taxation->description) ? $taxation->description : ""}}</textarea>
                 </div>
               </div>
             </div>
             <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                   <div class="form-group">
                      <label for="">{{trans('messages.keyword_latitude')}} <span class="required">(*)</span></label>
                      <input class="form-control" placeholder="{{trans('messages.keyword_latitude')}}" id="lat" name="lat" value="{{ isset($taxation->lat) ? $taxation->lat : "" }}" type="text">
                   </div>
                 </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                 <div class="form-group">
                    <label for="">{{trans('messages.keyword_longitude')}} <span class="required">(*)</span></label>
                    <input class="form-control" placeholder="{{trans('messages.keyword_longitude')}}" id="long" name="long" value="{{ isset($taxation->long) ? $taxation->long : "" }}" type="text">
                 </div>
               </div>
             </div>                   
              <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label for="">{{trans('messages.keyword_address')}}</label>
                        <input class="form-control" placeholder="{{trans('messages.keyword_address')}}" name="address" id="pac-input" value="{{ isset($taxation->address) ? $taxation->address: "" }}"type="text" required>                     </div>
                     <div id="map" style="height:400px;width:100%;"></div>   
                   </div>

               </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="text-right">
                    <input type="hidden" name="location_id" value="{{ isset($taxation->id) ? $taxation->id : "" }}">
                    <input class="btn btn-default btn-6-12" type="submit" value="{{isset($taxation->id) ? trans('messages.keyword_modify') : trans('messages.keyword_add')}}">
                    <a href="{{url('/location/')}}" class="btn btn-reject btn-cancel">{{trans('messages.keyword_cancel')}}</a>
                  </div>
              </div>                     
				</form>
    </div>
  </div>      
</div>
</div>   
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script> 
<script type="text/javascript">
  $(document).ready(function() {
     // validate taxation form on keyup and submit
        $("#taxation_form").validate({
          rules: {
              name: {
                  required: true,
                  maxlength: 35
              },
              address: {
                  required: true
              }
          },
          messages: {
            name: {
              required: "{{trans('messages.keyword_please_enter_a_name')}}",
              maxlength: "{{trans('messages.keyword_please_enter_less_than_35_charters')}}"
            },
            address: {
              required: "{{trans('messages.keyword_please_enter_address')}}"                  
            }
          }
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
		
		function onCircleComplete(shape) {
			if (shape == null || (!(shape instanceof google.maps.Circle))) return;
	
			if (circle != null) {
				circle.setMap(null);
				circle = null;
			}
	
			circle = shape;
			console.log('radius', circle.getRadius());
			console.log('lat', circle.getCenter().lat());
			console.log('lng', circle.getCenter().lng());
			
			var latlng = {lat: circle.getCenter().lat(), lng: circle.getCenter().lng()};
			geocoder.geocode({'location': latlng}, function(results, status) {
			  if (status === 'OK') {
				if (results[1]) {
				  //map.setZoom(6);
				  /*var marker = new google.maps.Marker({
					position: latlng,
					center:latlng,
					map: map
				  });*/
					 var city = results[0].formatted_address;
					//alert(city);
					city = city.split(",");
					city = city[city.length - 2];
					//alert(city);
					city = city.split(" ");
					city = city[2];
					alert(city);
	
					if((typeof city === 'string' || city instanceof String) && isNaN(parseInt(city))) {
						jQuery("#city").val(city);
						showHide();
					}
				  
				} else {
				  window.alert('No results found');
				}
			  } else {
				window.alert('Geocoder failed due to: ' + status);
			  }
			});
		}
		//google.maps.event.addDomListener(window, 'load', initMap);		
      }
	  

  </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>
@endsection