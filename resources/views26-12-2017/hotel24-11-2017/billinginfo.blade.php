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
     <div class="section-border">
                    <div class="billing-information">
           
                            <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
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
                                    
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                    	<div class="contact-with-pdf">
                                    	<div class="form-group">
                                          <label for="">Contract no*</label>
                                          <input type="text" readonly class="form-control" id="contract_no" placeholder="Imperial Srl" value="{{(isset($billing_address->contract_no)) ? $billing_address->contract_no : old('contract_no')}}" name="contract_no">
                                        </div>
                                        <div class="pdf"><a href="#" onclick="showHidepdf()"><img src="{{asset('images/pdf.png')}}"/></a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                    	<div class="input-file-with-pdf">
                                        <input type="file" name="filetype"/>
                                        @if(isset($billing_address->filetype)&& $billing_address->filetype!='')
                                           <div class="pdf"><img src="{{assest('storage/app/image/hotel/'.$billing_address->filetype)}}"/></div>
                                      	@endif
                                        </div>
                                    </div>
                             </div>   
                             
                             
                             <div class="row">
                             	<div class="col-md-6 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                           <label for="">{{trans('messages.keyword_contact_person')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->contact_person)) ? $billing_address->contact_person : $hoteldetails->contact_person}}"
                                           id="billing_contact_person"
                                           placeholder="{{trans('messages.keyword_contact_person')}}"
                                           name="billing_contact_person" type="text">
                                        </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                            <label for="">{{trans('messages.keyword_billing_language')}}</label>
                                            <select class="form-control selecttwoclass" name="billing_lang[]" id="billing_lang" multiple="multiple">
                                            @php $billing_lang=(isset($billing_address->billing_lang))?explode(',',$billing_address->billing_lang):array();@endphp
                                           
                                                @foreach($arrlanguages as $keylang => $vallang)
                                                    @php $selectedcomlang = (in_array($vallang->id, $billing_lang)) ? 'selected' : (in_array(old('billing_lang'),$billing_lang) ? 'selected' : '') @endphp
                                                    <option value="{{$vallang->id}}" {{$selectedcomlang}}>{{strtoupper($vallang->code)}}
                                                        / {{$vallang->original_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                             </div>
                             
                 			<div class="row">
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
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                    	 <label for="">{{trans('messages.keyword_zip_code')}}</label>
                                    <input class="form-control"
                                           value="{{(isset($billing_address->zip_code)) ? $billing_address->zip_code : old('billing_zipcode')}}"
                                           id="billing_zipcode" placeholder="{{trans('messages.keyword_zip_code')}}"
                                           name="billing_zipcode" type="text">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                    	  <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                                    <input class="form-control inputmask-formate"
                                           value="{{(isset($billing_address->phone)) ? $billing_address->phone : $hoteldetails->phone}}"
                                           id="billing_phone" placeholder="{{trans('messages.keyword_phone')}}"
                                           name="billing_phone" type="text">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                    	 <label for="">{{trans('messages.keyword_fax')}}</label>
                                    <input class="form-control inputmask-formate"
                                           value="{{(isset($billing_address->fax)) ? $billing_address->fax : old('billing_fax')}}"
                                           id="billing_fax" placeholder="{{trans('messages.keyword_fax')}}"
                                           name="billing_fax" type="text">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-6 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                   <label for="">IBAN</label>
                                    <input class="form-control" id="IBAN" placeholder="IBAN" name="IBAN" value="{{isset($billing_address->iban) ? $billing_address->iban : old('IBAN')}}" type="text">
                               
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                    	<label for="">VAT ID</label>
	                                	<input class="form-control" id="vat" placeholder="VAT ID" name="vat" value="{{isset($billing_address->vat_id) ? $billing_address->vat_id : old('vat')}}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                	<div class="form-group">
                                    	<label for="">IVA</label>
	                                	<input class="form-control" id="iva" placeholder="IVA" name="iva" value="{{isset($billing_address->ivan) ? $billing_address->ivan : old('iva')}}" type="text">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                            	<div class="col-md-7 col-sm-12 col-xs-12">
                                	<div class="pagamento-txt">
                                    	<p class="blue-head">@lang('messages.keyword_commissions_payout')</p>
                                        <p class="txt">@lang('messages.keyword_commission_text')</p>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                	<div class="iban-form-wrap">
                                    	<p class="blue-head">@lang('messages.keyword_bank_details_for_direct_debit')</p>
                                        <div class="bg-grey">
                                        	@lang('messages.keyword_bank_detail_text')
                                        </div>
                                        <div class="ibn-form-blk">
                                        	<div class="form-group">	
                                            	<label>IBAN</label>
                                                <input type="text" class="form-control" name="debit_iban" placeholder="IBAN" value="{{(isset($billing_address->debit_iban)) ? $billing_address->debit_iban : old('debit_iban')}}"/>
                                            </div>
                                            <div class="form-group">	
                                            	<label>@lang('messages.keyword_account_holder_name_and_surname')</label>
                                                <input type="text" class="form-control" name="holder_name" placeholder="@lang('messages.keyword_account_holder_name_and_surname')" value="{{(isset($billing_address->holder_name)) ? $billing_address->holder_name : old('holder_name')}}"/>
                                            </div>
                                            <div class="ryt-chk-content">
                                                <div class="ryt-chk">
                                                <input id="one" type="checkbox">
                                                <label for="one">@lang('messages.keyword_therma_authorize')</label></div>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                 
             	    </div>
                    
                 </div>
                 
                 	<div class="btn-shape">
                    
                    <div class="row">
                    	<div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/edit/detail/'.$hoteldetails->id)}}" class="btn btn-default">Previous</a></div>
        	                <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><button type="submit" class="btn btn-default">Next</a></div>
                    </div>
		
             
                
                 
                             
                                          
                   </div>
    <link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('public/js/select2.full.min.js')}}"></script>
   <script>
   $(".selecttwoclass").select2();
   $(document).ready(function(e) {
	   
   		 $('#contactname').text($('#billing_contact_person').val());
		 $('#companyname').text($('#billing_company_name').val());
		 $('#registeraddress').text($('#billing_address').val());
	});
   </script>
   
    <?php echo Form::close(); ?>
    
<div id="please_wait-pdf">

<div class="aggrement-wrap">
                                <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                          				<div class="section-border">
                                        	<div class="agreement-heading">@lang('messages.keyword_contract_with_thermaeurope.com')</div>
                                            <div class="row pos-rel">
                                            	<div class="col-md-6 col-sm-12 col-xs-12">
                                                	<div class="agreement-lft">
                                                        <div class="agreement-heading-subheading">tra:</div>
                                                        <div class="agreement-address">
                                                            <b>Booking.com B.V</b><br> 
                                                            Herengracht 597 <br>
                                                            1017 CE Amsterdam<br>
                                                            Netherlands
                                                        </div>
                                                        <div class="agreement-txt-address">
                                                            Registro della camera di commercio e industria di amsterdam, numero di iscrizione all' autorita olandese per la protezione dei dati personali: 1288246.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12">
                            						
                                                    <div class="agreement-ryt">
                                                    	<div class="agreement-heading-subheading">@lang('messages.keyword_and_you,_the_accommodation'):</div>
                                                        <div class="agreement-edit-name">
                                                        	<p>@lang('messages.keyword_name_of_the_structure')</p>
                                                            <p>An front</p>
                                                        </div>
                                                        
                                                        <div class="agreement-edit-name">
                                                        	<p>@lang('messages.keyword_contact_person')</p>
                                                            <p><span id="contactname">Caria Gallo</span> <a href="#"> <i class="fa fa-pencil" aria-hidden="true"></i> Modifica</a></p>
                                                        </div>
                                                        
                                                        <div class="agreement-edit-name">
                                                        	<p>@lang('messages.keyword_business_name')</p>
                                                            <p><span id="companyname">Imprenditore individuale Carla Gallo</span> <a href="#"> <i class="fa fa-pencil" aria-hidden="true"></i> Modifica</a></p>
                                                            <p class="gry-font-agree">"Se si tratta di una struttura gestita da privati, inserisci il nome e cognome del proprietario."</p>
                                                        </div>
                                                        
                                                        
                                                        <div class="agreement-edit-name">
                                                        	<p>@lang('messages.keyword_registered_office_address')</p>
                                                            <p><span id="registeraddress">via cavour, 12060, Barolo, Italia</span> <a href="#"> <i class="fa fa-pencil" aria-hidden="true"></i> Modifica</a></p>
                                                        </div>
                                                        
                                                    </div>
                                                                        	
                                                </div>
                                                <div class="bg-line"></div>
                                                
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="row">
                                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="agreement-middle">
                                                            <div class="agreement-heading-subheading">si concorda quanto segue:</div>
                                                           
                                                            <div class="agreement-edit-name">
                                                                <p>Percentuale di commissione</p>
                                                                <p>La percentuale di commissione ammontera al 15% <span class="btm-dotted-agreement">Cosa ottengo in cambio della commissione che pago?</span></p>
                                                            </div>
                                                            
                                                            <div class="agreement-edit-name">
                                                                <p>validita ed esecuzione</p>
                                                                <p>Il Contratto sara valido solo in seguito ad approvazione e conferma da parte di Booking.com B.V.</p>
                                                            </div>
                                                            
                                                            <div class="agreement-edit-name">
                                                                <p>Clausole generali</p>
                                                                <p>questo Contratto e soggetto alle clausole generali ("Termini e condizioni") e regolato dalle stesse. La Struttura ricettiva dichiara di aver letto e accettato i suddetti termini e condizioni.</p>
                                                            </div>
                                                            
                                                           <div class="agreement-edit-name">
                                                                <p>Data</p>
                                                                <p>10 lug 2017</p>
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    
                                                  </div>  
                                            </div>
                                            
                                            
                                            <div class="row">
                                            	 <div class="col-md-12 col-sm-12 col-xs-12">
                                            	<div class="alert alert-info alert-box" role="alert">
                                                    <h3 class="heading-three">Spunta entrambe le caselle qui sotto:</h3>
                                                    <div class="ryt-chk-content">
                                                        <div class="ryt-chk">
                                                        <input id="one1" type="checkbox">
                                                        <label for="one1">Dichiaro di aver letto, accettato e di concordare con le</label></div>
                                                    </div>
                                                    <div class="ryt-chk-content">
                                                        <div class="ryt-chk">
                                                        <input id="two" type="checkbox">
                                                        <label for="two">Dichiaro di aver letto, accettato e di concordare con le</label></div>
                                                    </div>
                                                    <div class="ryt-chk-content">
                                                        <div class="ryt-chk">
                                                        <input id="three" type="checkbox">
                                                        <label for="three">Dichiaro di aver letto, accettato e di concordare con le</label></div>
                                                    </div>
                                                </div> 
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="row">
                                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                                	<div class="agreement-lst">
                                                                <p>Ci sei quasi!</p>
                                                                <p>Quando avrai finito, riceverai un' e-mail con la copia del contratto firmato, E ricorda, puoi decidere in qualsiasi momento di chiudere temporaneamente o rimuovere in via definitiva la tua struttura su Booking.com</p>
                                                            </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                              
                           			 </div>            
                                
                             	</div>
                             
                        
                             
                             
                             </div>

</div>

<div id="please_wait_bg-pdf" onclick="showHidepdf()">
<script>
  
function showHidepdf(){
	var el = document.getElementById("please_wait-pdf");
	var bg = document.getElementById("please_wait_bg-pdf");
    if( el && el.style.display == 'block')    
        el.style.display = 'none';
    else 
        el.style.display = 'block';
		
	if( bg && bg.style.display == 'block'){    
        bg.style.display = 'none';
		JQuery(window).unbind('scroll');
		  
	}
    else {
        bg.style.display = 'block';
		JQuery(window).scroll(function() { return false; });
	}
}
</script>
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
                    
                    billing_company_name: {
                        required: true,
                    },
                    
                    
                    billing_address: {
                        required: true,
                        maxlength: 255
                    },
                    billing_phone: {
                        required: true
                    },
					 IBAN: {
                        required: true
                    },
					 vat: {
                        required: true
                    }
                },
                messages: {
                   
                    billing_company_name: {
                        required: "{{trans('messages.keyword_please_enter_a_company')}}"
                    },
                  
                  
                    billing_address: {
                        required: "{{trans('messages.keyword_please_enter_an_address')}}",
                        maxlength: "{{trans('messages.keyword_address_name_must_be_less_than_255_characters')}}"
                    },
                    billing_phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone')}}",
                    },
					 IBAN: {
                        required: "@lang('messages.keyword_please_enter_a_iban')"
                    },
					 vat: {
                        required: "@lang('messages.keyword_please_enter_a_vat')"
                    },
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
 <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&libraries=places" ></script>
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