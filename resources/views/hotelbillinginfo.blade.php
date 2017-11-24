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
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="thirdst"></li>
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
        echo Form::open(array('url' => '/update/hotelbillinfo' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelBillingInfo'));
    } 
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">

        <div class="row">            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="basic-info-lft">                    
                    <div class="section-border">
                        <p class="bold blue-head">{{trans('messages.keyword_billing_address')}}</p>
                        <div class="float-right">
                            <div class="switch"><input value="1" name="is_billing_operator" id="switch3" type="checkbox"
                                                       onchange="valueChanged3()"><label for="switch3"></label></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}} / {{trans('messages.keyword_hotel_name')}}<span
                                                class="required">(*)</span></label>
                                    <input class="form-control" id="billing_company_name"
                                           placeholder="{{trans('messages.keyword_company')}}"
                                           name="billing_company_name"
                                           value="{{(isset($billing_address->company)) ? $billing_address->company : $hoteldetails->name}}"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_contact_person')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->contact_person)) ? $billing_address->contact_person : $hoteldetails->contact_person}}"
                                           id="billing_contact_person"
                                           placeholder="{{trans('messages.keyword_contact_person')}}"
                                           name="billing_contact_person" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_address')}} <span
                                                class="required">(*)</span></label>
                                    <input class="form-control addressautocomplete"
                                           value="{{(isset($billing_address->address)) ? $billing_address->address : $hoteldetails->address}}"
                                           id="billing_address" placeholder="{{trans('messages.keyword_address')}}"
                                           name="billing_address" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_zip_code')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->zip_code)) ? $billing_address->zip_code : old('billing_zipcode')}}"
                                           id="billing_zipcode" placeholder="{{trans('messages.keyword_zip_code')}}"
                                           name="billing_zipcode" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                                    <input class="form-control inputmask-formate"
                                           value="{{(isset($billing_address->phone)) ? $billing_address->phone : $hoteldetails->phone}}"
                                           id="billing_phone" placeholder="{{trans('messages.keyword_phone')}}"
                                           name="billing_phone" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_fax')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->fax)) ? $billing_address->fax : old('billing_fax')}}"
                                           id="billing_fax" placeholder="{{trans('messages.keyword_fax')}}"
                                           name="billing_fax" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_banking_connections')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->bank_connetion)) ? $billing_address->bank_connetion : old('billing_bank_detail')}}"
                                           id="billing_bank_detail"
                                           placeholder="{{trans('messages.keyword_enter_banking_detail')}}"
                                           name="billing_bank_detail" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-border switch3-show none">
                        <p class="bold blue-head">{{trans('messages.keyword_billing_address')}}
                            - {{trans('messages.keyword_operator_language')}}</p>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->company)) ? $operator_billing_address->company : $hoteldetails->name}}"
                                           id="billing_opert_company_name"
                                           placeholder="{{trans('messages.keyword_company')}}"
                                           name="billing_opert_company_name" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                    <label for="">{{trans('messages.keyword_contact_person')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->contact_person)) ? $operator_billing_address->contact_person : $hoteldetails->contact_person}}"
                                           id="billing_opert_contact_person"
                                           placeholder="{{trans('messages.keyword_contact_person')}}"
                                           name="billing_opert_contact_person" type="text">
                                </div>                               
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_address')}}</label>
                                    <input class="form-control addressautocomplete"
                                           value="{{(isset($operator_billing_address->address)) ? $operator_billing_address->address : $hoteldetails->address}}"
                                           id="billing_opert_address"
                                           placeholder="{{trans('messages.keyword_address')}}"
                                           name="billing_opert_address" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_zip_code')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($operator_billing_address->zip_code)) ? $operator_billing_address->zip_code : old('billing_opert_zipcode')}}"
                                           id="billing_opert_zipcode"
                                           placeholder="{{trans('messages.keyword_zip_code')}}"
                                           name="billing_opert_zipcode" type="number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-border">
                        <div class="heading-with-toggle-wrap">
                            <p class="bold blue-head">Invoice - Final Beneficiary</p>
                            <div class="float-right">
                                <div class="switch"><input value="1" name="is_invoice_operator" id="switch2" type="checkbox"
                                                           onchange="valueChanged2()"><label for="switch2"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}
                                        /{{trans('messages.keyword_hotel_name')}}</label>
                                    <input class="form-control" id="invoice_hotel_name" placeholder="@lang('messages.keyword_hotel_name')" name="invoice_hotel_name" value="{{isset($invoice_address->company) ? $invoice_address->company : $hoteldetails->name}}" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_address')</label>
                                    <input type="text" class="form-control addressautocomplete" name="invoice_address" id="invoice_address" placeholder="{{trans('messages.keyword_address')}}" value="{{isset($invoice_address->address) ? $invoice_address->address : $hoteldetails->address}}" />
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">IBAN</label>
                                    <input class="form-control" id="IBAN" placeholder="IBAN" name="IBAN" value="{{isset($invoice_address->IBAN) ? $invoice_address->IBAN : old('IBAN')}}" type="text">
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="section-border switch2-show none">
                        <p class="bold blue-head">Invoice - Final recipient - Operator language</p>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">{{trans('messages.keyword_company')}}
                                        /{{trans('messages.keyword_hotel_name')}}</label>
                                    <input class="form-control" id="invoice_hotel_name_op" placeholder="@lang('messages.keyword_hotel_name')" value="{{isset($operator_invoice_address->company) ? $operator_invoice_address->company : $hoteldetails->name}}" name="invoice_hotel_name_op" value="10" type="text">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_address')</label>
                                    <input type="text" class="form-control addressautocomplete" id="invoice_address_op" name="invoice_address_op" placeholder="{{trans('messages.keyword_address')}}" value="{{isset($operator_invoice_address->address) ? $operator_invoice_address->address : $hoteldetails->address}}" />
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">IBAN</label>
                                    <input class="form-control" id="iban_op" placeholder="IBAN" name="iban_op" value="{{isset($operator_invoice_address->IBAN) ? $operator_invoice_address->IBAN : old('IBAN')}}" type="text">
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
            $("#frmHotelBillingInfo").validate({
                rules: {
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
                    }
                },
                messages: {
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
 <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places" ></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&sensor=false&libraries=places"></script>-->
    <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&sensor=false&libraries=places">-->
    <script type="text/javascript">
       /*  Google Autocomplete for address */
        google.maps.event.addDomListener(window, 'load', function () {

            /*For the Edit all the text box give autocomplete */
            var acInputs = document.getElementsByClassName("addressautocomplete");
            for (var i = 0; i < acInputs.length; i++) {
                /*var autocomplete = new google.maps.places.Autocomplete(acInputs[i],options);*/
                var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
                autocomplete.inputId = acInputs[i].id;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    //document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
                });
            }
        });
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