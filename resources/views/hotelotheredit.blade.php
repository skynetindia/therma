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
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="eight"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php
    if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
        echo Form::open(array('url' => '/update/hotelotherinfo' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelotherInfo'));
    } 
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="text-info-blk">
                            <div class="section-border">
                                <div class="heading-with-pagination">
                                    <p class="bold blue-head">{{trans('messages.keyword_text_information')}}</p>
                                    <div class="pagination-type">
                                        <ul class="pagination nav nav-tabs nav-tabs-lang">
                                            <li><a href="#">
                                                    <div class="input-group-addon">
                                                        <div class="ryt-chk">
                                                            <input id="chk-without-info2" type="checkbox"><label for="chk-without-info2"></label>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            @foreach($arrlanguages as $keylang => $vallang)
                                            <li @if($keylang==0) class="active"@endif><a data-toggle="tab" href="#{{$vallang->code}}">{{$vallang->code}}</a></li>
                                            @endforeach
                                        </ul>                                        
                                    </div>
                                </div>
                                <div class="tab-content">
                                    @foreach($arrlanguages as $keylang => $vallang)
                                        <div id="{{$vallang->code}}"
                                             class="tab-pane fade in @if($keylang==0)active @endif">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               placeholder="{{trans('messages.keyword_name')}}"
                                                               value="{{ isset($text_information->name) && isset($text_information_language[$vallang->code][$text_information->name]) ? ($text_information_language[$vallang->code][$text_information->name]) : ''}}"
                                                               name="text_name_{{$vallang->code}}"
                                                               id="text_name_{{$vallang->code}}" type="text"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_language_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->language_name) && isset($text_information_language[$vallang->code][$text_information->language_name]) ? ($text_information_language[$vallang->code][$text_information->language_name]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_language_name')}}"
                                                               name="language_name_{{$vallang->code}}"
                                                               id="language_name_{{$vallang->code}}" type="text"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_supplement_name')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->supplement_name) && isset($text_information_language[$vallang->code][$text_information->supplement_name]) ? ($text_information_language[$vallang->code][$text_information->supplement_name]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_supplement_name')}}"
                                                               name="supplement_name_{{$vallang->code}}"
                                                               id="supplement_name_{{$vallang->code}}" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description__short')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  placeholder="{{trans('messages.keyword_enter_short_description')}}"
                                                                  name="desc_short_{{$vallang->code}}"
                                                                  id="desc_short_{{$vallang->code}}">{{isset($text_information->short_description) && isset($text_information_language[$vallang->code][$text_information->short_description]) ? ($text_information_language[$vallang->code][$text_information->short_description]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_full')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_full_{{$vallang->code}}"
                                                                  id="desc_full_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_full_description')}}">{{isset($text_information->full_description) && isset($text_information_language[$vallang->code][$text_information->full_description]) ? ($text_information_language[$vallang->code][$text_information->full_description]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_exceptionality')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_exception_{{$vallang->code}}""
                                                        id="desc_exception_{{$vallang->code}}"
                                                        placeholder="{{trans('messages.keyword_enter_exceptinality_description')}}
                                                        ">{{isset($text_information->exceptionality_dec) && isset($text_information_language[$vallang->code][$text_information->exceptionality_dec]) ? ($text_information_language[$vallang->code][$text_information->exceptionality_dec]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_description_expert_evaluation')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="desc_experteval_{{$vallang->code}}"
                                                                  id="desc_experteval_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_expert_evaluation_description')}}">{{isset($text_information->expert_evalution_desc) &&  isset($text_information_language[$vallang->code][$text_information->expert_evalution_desc]) ? ($text_information_language[$vallang->code][$text_information->expert_evalution_desc]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_special_offer')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="special_offer_{{$vallang->code}}"
                                                                  id="special_offer_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_special_offer')}}">{{isset($text_information->special_offer) &&  isset($text_information_language[$vallang->code][$text_information->special_offer]) ? ($text_information_language[$vallang->code][$text_information->special_offer]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_videos')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control" name="videos_{{$vallang->code}}"
                                                                  id="videos_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_enter_video_url')}}">{{isset($text_information->video_url) && isset($text_information_language[$vallang->code][$text_information->video_url]) ? ($text_information_language[$vallang->code][$text_information->video_url]) : ''}}</textarea>
                                                        <p>{{trans('messages.keyword_pattern')}}:
                                                            www.youtube.com/embed/NXLDoATXoh4<br/></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_video_expert_rating')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->video_assement) && isset($text_information_language[$vallang->code][$text_information->video_assement]) ? ($text_information_language[$vallang->code][$text_information->video_assement]) : ''}}"
                                                               name="video_expert_{{$vallang->code}}"
                                                               id="video_expert_{{$vallang->code}}"
                                                               placeholder="{{trans('messages.keyword_video_expert_rating')}}"
                                                               value="" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <hr/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_title')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->seo_title) && isset($text_information_language[$vallang->code][$text_information->seo_title]) ? ($text_information_language[$vallang->code][$text_information->seo_title]) : ''}}"
                                                               placeholder="{{trans('messages.keyword_seo_title')}}"
                                                               name="seo_title_{{$vallang->code}}"
                                                               id="seo_title_{{$vallang->code}}" value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_description')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_desc_{{$vallang->code}}"
                                                                  id="seo_desc_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_description')}}">{{isset($text_information->seo_desc) && isset($text_information_language[$vallang->code][$text_information->seo_desc]) ? ($text_information_language[$vallang->code][$text_information->seo_desc]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_keywords')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_keywords_{{$vallang->code}}"
                                                                  id="seo_keywords_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_keywords')}}">{{isset($text_information->seo_keywords) && isset($text_information_language[$vallang->code][$text_information->seo_keywords]) ? ($text_information_language[$vallang->code][$text_information->seo_keywords]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_title_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <input class="form-control"
                                                               value="{{isset($text_information->seo_title_ref) && isset($text_information_language[$vallang->code][$text_information->seo_title_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_title_ref]) : ''}}"
                                                               name="seo_titleref_{{$vallang->code}}"
                                                               id="seo_titleref_{{$vallang->code}}"
                                                               placeholder="{{trans('messages.keyword_seo_title_reference')}}"
                                                               value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo__description_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_descref_{{$vallang->code}}"
                                                                  id="seo_titleref_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo__description_reference')}}">{{isset($text_information->seo_desc_ref) &&  isset($text_information_language[$vallang->code][$text_information->seo_desc_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_desc_ref]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>{{trans('messages.keyword_seo_keywords_reference')}}
                                                            ({{strtoupper($vallang->code)}})</label>
                                                        <textarea class="form-control"
                                                                  name="seo_keywordsref_{{$vallang->code}}"
                                                                  id="seo_keywordsref_{{$vallang->code}}"
                                                                  placeholder="{{trans('messages.keyword_seo_keywords_reference')}}">{{isset($text_information->seo_keyword_ref) &&  isset($text_information_language[$vallang->code][$text_information->seo_keyword_ref]) ? ($text_information_language[$vallang->code][$text_information->seo_keyword_ref]) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                    <a href="{{ url('hotel/edit/policies').'/'.$hoteldetails->id }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
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
            $("#frmHotelotherInfo").validate({
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
                    hotel_phone: {
                        required: true
                    },
                    hotel_fax: {
                        required: true
                    },
                    hotel_weburl: {
                        required: true,
                        url: true
                    },
                    general_email: {
                        required: true,
                        email: true
                    },
                    invoice_company_name: {
                        required: true,
                    },
                    invoice_address: {
                        required: true,
                    },
                    billing_company_name: {
                        required: true,
                    },
                    billing_hotel_name: {
                        required: true
                    },
                    contact_hotel_name: {
                        required: true
                    },
                    contact_address: {
                        required: true,
                        maxlength: 255
                    },
                    billing_address: {
                        required: true,
                        maxlength: 255
                    },
                    billing_phone: {
                        required: true
                    },
                    username_required : {
                        required: true,
                        maxlength: 50
                    },
                    password_required : {
                        required: true,
                        maxlength: 50
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
                    hotel_phone: {
                        required: "{{trans('messages.keyword_enter_phone')}}"
                    },
                    hotel_fax: {
                        required: "{{trans('messages.keyword_please_enter_a_fax')}}"
                    },
                    hotel_weburl: {
                        required: "{{trans('messages.keyword_please_enter_a_web_url')}}",
                        url: "{{trans('messages.keyword_please_enter_a_valid_ur')}}"
                    },
                    general_email: {
                        required: "{{trans('messages.keyword_please_enter_a_general_email')}}",
                        email: "{{trans('messages.keyword_please_enter_a_valid_general_email')}}"
                    },
                    invoice_company_name: {
                        required: "{{trans('messages.keyword_please_enter_a_company')}}",
                    },
                    invoice_address: {
                        required: "{{trans('messages.keyword_please_enter_a_address')}}",
                    },
                    billing_company_name: {
                        required: "{{trans('messages.keyword_please_enter_a_company')}}"
                    },
                    billing_hotel_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    contact_hotel_name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    contact_address: {
                        required: "{{trans('messages.keyword_please_enter_a_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    billing_address: {
                        required: "{{trans('messages.keyword_please_enter_an_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    billing_phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone')}}",
                    },
                    username_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    password_required: {
                        required: "{{trans('messages.keyword_please_enter_a_hotel_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
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

    <script>
    /*$(document).ready(function () {
     initMap();
    });*/
        $(document).on("change", "#name", function(){
            var main_val = $(this).val();
            $("#contact_hotel_name").val(main_val);
            $("#invoice_hotel_name").val(main_val);
            $("#billing_company_name").val(main_val);
        });

        $(document).on("change", "#general_email", function(){
            var main_val = $(this).val();
            $("#reservation_email").val(main_val);
            $("#transfer_email").val(main_val);
            $("#billing_email").val(main_val);
            $("#sold_out_email").val(main_val);
        });

        $(document).on("change blur", ".addressautocomplete", function(){
			 $id=$(this).attr('id');
			setTimeout(function(){
				var main_val = $('#'+$id).val();
				$( ".addressautocomplete" ).each(function() {
					if($(this).val()=='')
					$(this).val(main_val);
			  
				});
			},700);
        });



    </script>


@endsection