@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <?php $modules = fetch_modules(0, '', 0); ?>
    
    {{ Form::open(array('url' => '/user/update', 'files' => true, 'id' => 'update_profile_form')) }}
    
    <input type="hidden" name="userid" value="{{ isset($user->id) ? $user->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    
    <div class="user-profile-wrap">
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">
                    
                    @if(isset($typeid))
                        @if($action == 'add')@lang('messages.keyword_add_new')@else @lang('messages.keyword_update') @endif {{ getUserTypesById($typeid) }}
                    @else
                        @if($action == 'add')@lang('messages.keyword_add_new')@else @lang('messages.keyword_update') @endif @if(isset($typeid)) {{ getUserTypesById($typeid) }} @else @lang('messages.keyword_user') @endif
                    @endif
                    
                    {{--{{ ($action == 'add') ? 'Add new' : 'Update' }} User--}}
                </h1>
                <hr/>
            </div>
        </div>
        
        <div class="row">
            <div class="user-profile">
                @if($action == 'edit')
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <h4>{{ isset($user->name) ? ucfirst($user->name) : '' }}</h4>
                        <hr>
                        <div class="user-profile-img">
                            @if(isset($user->image))
                                <img src="{{ asset('public/images/user')."/".$user->image }}" class="thumbnail" alt="{{ $user->name }}" width="150px">
                            @endif
                        </div>
                    
                    </div>
                @endif
                <div class="col-md-10 col-sm-12 col-xs-12">
                    <div class="user-form row">
                        
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                                <input type="text" name="name" value="{{ isset($user->name) ? $user->name : '' }}" class="form-control" id=""
                                       placeholder="Enter name">
                            </div>
                            
                            <div class="form-group form-control-file">
                                <label for="">@lang('messages.keyword_select_image')</label>
                                <input type="hidden" name="old_image" value="{{ isset($user->image) ? $user->image : '' }}">
                                <input type="file" name="image" class="" id="">
                            </div>
                            
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_profile_type')
                                    <span class="required">(*)</span></label>
                                <input type="hidden" id="storeOnloadValueOfUserType" value="">
                                <select name="profile_id" class="form-control" id="load_default_permissions">
                                    <option value="">@lang('messages.keyword_--select--')</option>
                                    @forelse(getUserTypes() as $key => $value)
                                        <?php
                                        if (isset($user->profile_id)) {
                                            $selected = ($user->profile_id == $value->id) ? "selected" : '';
                                        } else if (isset($typeid)) {
                                            $selected = ($typeid == $value->id) ? "selected" : '';
                                        } else {
                                            $selected = '';
                                        }
                                        ?>
                                        <option value="{{ $value->id }}" {{ $selected }} >{{ $value->type }}</option>
                                    @empty
                                        <option value="">@lang('messages.keyword_--select--')</option>
                                    @endforelse
                                </select>
                            </div>
                        
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_email') <span class="required">(*)</span></label>
                                <input type="email" name="email" value="{{ isset($user->email) ? $user->email : '' }}" class="form-control" id=""
                                       placeholder="example@email.com">
                            </div>
                            
                            
                            @if($action == 'add')
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_password')
                                        <span class="required">(*)</span></label>
                                    <input type="password" name="password" value="{{ isset($user->password) ? $user->password : '' }}" class="form-control" id="" placeholder="**********">
                                </div>
                            @endif
                            
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_phone_number')
                                    <span class="required">(*)</span></label>
                                <input type="text" name="phone" value="{{ isset($user->phone) ? $user->phone : '' }}" class="form-control inputmask-formate" id="phone"
                                       placeholder="Enter Phone Number">
                            </div>
                        
                        
                        </div>
                        
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_address')
                                    <span class="required">(*)</span></label>
                                <input class="form-control addressautocomplete gm-err-autocomplete" value="{{ isset($user->address) ? $user->address : '' }}" id="address" placeholder="{{trans('messages.keyword_address')}}"
                                       name="address" type="text">
                                <div class="map" id="map" style="height:250px;width:100%;"></div>
                            </div>
                        </div>
                    
                    
                    </div>
                    <hr>
                
                </div>
                
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="user-profile-heading">@lang('messages.keyword_change_permission')</h4><br>
                </div>
            
            
            </div>
        
        
        </div>
        
        <div class="row">
            <div id="user_permissions">
                <div class="col-md-12 col-sm-12 col-xs-12" id="">
                <table class="table table-hover table-bordered permission_table">
                    <tr>
                        <th>@lang('messages.keyword_modules')</th>
                        <th class="text-center">@lang('messages.keyword_writing')</th>
                        <th class="text-center">@lang('messages.keyword_reading')</th>
                    </tr>
                    
                    <?php $selected_array = array(); ?>
                    @if(isset($user->id))
                        <?php $selected_array = getUserPermissions($user->id); ?>
                    @endif
                    
                    
                    {{-- Modules--}}
                    @php $modules = fetch_modules_for_permission(1,0, '',array(), $selected_array) @endphp
                    @foreach($modules as $module)
                        {!! $module !!}
                    @endforeach
                
                
                </table>
            </div>
            </div>
            
            <div id="default_permissions"></div>
            
            
        </div>
    </div>
    
    <div class="btn-shape">
        
        <div class="row">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left">
                    <a href="{{ url('users') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                    <button type="submit" class="btn btn-default">@lang('messages.keyword_save')</button>
                </div>
            </div>
        
        </div>
    
    </div>
    
    {{ Form::close() }}
    
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>


        $("#update_profile_form").validate({
            rules: {
                name: {
                    required: true
                },
                profile_id: {
                    required: true
                },
                address: {
                    required: true
                },
                password: {
                    required: {{ ($action == 'edit') ? "false" : "true" }},
                    minlength: 6,
                    maxlength: 15
                },
                email: {
                    required: true,
                    email: true
                },
                image: {
                    extension: "jpeg|jpg|png|gif"
                },
                phone: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                address: {
                    required: "@lang('messages.keyword_please_enter_an_address')"
                },
                profile_id: {
                    required: "@lang('messages.keyword_please_select_profile')"
                },
                password: {
                    required: "@lang('messages.keyword_please_enter_password')"
                },
                email: {
                    required: "@lang('messages.keyword_please_enter_an_email')",
                    email: "@lang('messages.keyword_please_enter_valid_email')"
                },
                image: {
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                },
                phone: {
                    required: "@lang('messages.keyword_please_enter_number')"
                }

            }
        });

        $(document).ready(function () {
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });
    </script>
    
    
    
    <script>

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


            autocomplete.addListener('place_changed', function () {

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
    
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 41.885977605235377, lng: 12.480394244191757},
                zoom: 7
            });
            /** @type {!HTMLInputElement} */
            var input = document.getElementById('address');
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
            autocomplete.addListener('place_changed', function () {
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
            //google.maps.event.addDomListener(window, 'load', initMap);

        }
    </script>
    
    
    <script>
        $(document).ready(function () {


            // $(".permission_table input[type='checkbox']").change(function () {
            //     var className = $(this).attr('class');
            //     //alert(className);
            //     var countTotal = $('.' + className).length; // count total class
            //
            //     var countChecked = checkedLength(className); // count checked checkbox
            //
            //     if (countTotal == countChecked) {
            //         $("#" + className).prop("checked", this.checked);
            //     } else {
            //         $("#" + className).prop("checked", false);
            //     }
            //
            // });
        });

        function checkedLength(className) {
            var countChecked = $('[class="' + className + '"]:checked').length;
            return countChecked;
        }

        function checkAll(e) {
            var id = $(e).attr('id');
            if ($(e).prop('checked')) {
                $("." + id).prop('checked', true);
            } else {
                $("." + id).prop('checked', false);
            }
        }
    
    </script>
    
    <script>
        
        $(function(){
            
            //I'm storing onload value of select box of user type
            //thats why it's not load default permission when found stored value with ajax
            
            var onloadPermission = $("#load_default_permissions").val();
            if(onloadPermission != ''){
                $('#storeOnloadValueOfUserType').val(onloadPermission);
            }
        });
        
        $("#load_default_permissions").on("change", function(){
            var user_type_id = $(this).val();
            
            loadDefaultPermissions(user_type_id);
            
        });
        
        
        function loadDefaultPermissions(user_type_id) {
            
            var onloadUserTypeValue =  $('#storeOnloadValueOfUserType').val();
            
            if(user_type_id != '' && user_type_id != onloadUserTypeValue){
                $.ajax({
                    url: '{{ url('user/getDefaultPermission') }}' + "/" + user_type_id,
                    method: 'GET',
                    success: function(data){
                        $("#default_permissions").show();
                        $("#user_permissions").hide();
                        $("#default_permissions").html(data);
                    }
                });
            }else{
                $("#user_permissions").show();
                $("#default_permissions").hide();
            }
        }
    </script>

@endsection
