@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
    
    </script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    
    {{ Form::open(array('url' => 'invoice/detail', 'files' => true, 'id' => 'invoice_detail_form', 'method' => 'post')) }}
    
    

    
    
    
    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <h1 class="user-profile-heading">
                                    @lang('messages.keyword_invoice_detail')
                                </h1><hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_name')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_name')}}" value="{{(isset($invoice_detail->name)) ? $invoice_detail->name : old('name')}}" name="name" id="name" type="text">
                                            </div>
                                        </div>
    
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_website')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_website')}}" value="{{(isset($invoice_detail->website)) ? $invoice_detail->website : old('website')}}" name="website" id="website" type="text">
                                            </div>
                                        </div>
    
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_phone')}} <span class="required">(*)</span></label>
                                                <input class="form-control" placeholder="{{trans('messages.keyword_phone')}}" value="{{(isset($invoice_detail->phone)) ? $invoice_detail->phone : old('phone')}}" name="phone" id="phone" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">{{trans('messages.keyword_address')}} <span class="required">(*)</span></label>
                                                <input class="form-control addressautocomplete" placeholder="{{trans('messages.keyword_address')}}" value="{{(isset($invoice_detail->address)) ? $invoice_detail->address : old('address')}}" name="address" id="address" type="text">
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                
                                
                                <hr>
    
                                <div class="row">
                                    <div class="col-md-12">
                                        {{--Iban--}}
                                        <div class="col-md-4" >
                                            <div class="pull-right">
                                                <button class="btn btn-info" type="button" id="addiban"><i class="fa fa-plus"></i></button>
                                                <button class="btn btn-danger" type="button" id="removeiban"><i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="hidden" id="noofchildiban" value="0">
                                            
                                            @if(isset($invoice_detail->iban) && !empty($invoice_detail->iban))
                                                @php $edit_iban = explode(',', $invoice_detail->iban) @endphp
                                                @foreach($edit_iban as $key => $value)
                                                    @if($value ==  '') @continue @endif
                                                    
                                                    <div class="form-group" id="row_iban0">
                                                        <label for="">{{trans('messages.keyword_iban')}} <span class="required">(*)</span></label>
                                                        <input class="form-control" placeholder="{{trans('messages.keyword_iban')}}" value="{{ $value }}" name="iban[]" id="iban" type="text">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="form-group" id="row_iban0">
                                                    <label for="">{{trans('messages.keyword_iban')}} <span class="required">(*)</span></label>
                                                    <input class="form-control" placeholder="{{trans('messages.keyword_iban')}}" value="" name="iban[]" id="iban" type="text">
                                                </div>
                                            @endif
                                            
                                            
    
                                            <div class="childiban"></div>
                                            
                                        </div>
                                        {{-- Iban--}}
                                        <div class="col-md-4" >
                                            <div class="pull-right">
                                                <button class="btn btn-info" type="button" id="addvat_id"><i class="fa fa-plus"></i></button>
                                                <button class="btn btn-danger" type="button" id="removevat_id"><i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="hidden" id="noofchildvat_id" value="0">
        
                                            @if(isset($invoice_detail->vat_id) && !empty($invoice_detail->vat_id))
                                                @php $edit_vat_id = explode(',', $invoice_detail->vat_id) @endphp
                                                @foreach($edit_vat_id as $key => $value)
                                                    @if($value ==  '') @continue @endif
                
                                                    <div class="form-group" id="row_vat_id0">
                                                        <label for="">{{trans('messages.keyword_vat_id')}} <span class="required">(*)</span></label>
                                                        <input class="form-control" placeholder="{{trans('messages.keyword_vat_id')}}" value="{{ $value }}" name="vat_id[]" id="vat_id" type="text">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="form-group" id="row_vat_id0">
                                                    <label for="">{{trans('messages.keyword_vat_id')}} <span class="required">(*)</span></label>
                                                    <input class="form-control" placeholder="{{trans('messages.keyword_vat_id')}}" value="" name="vat_id[]" id="vat_id" type="text">
                                                </div>
                                            @endif
        
        
        
                                            <div class="childvat_id"></div>
    
                                        </div>
                                        <div class="col-md-4" >
                                            <div class="pull-right">
                                                <button class="btn btn-info" type="button" id="addswift"><i class="fa fa-plus"></i></button>
                                                <button class="btn btn-danger" type="button" id="removeswift"><i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="hidden" id="noofchildswift" value="0">
        
                                            @if(isset($invoice_detail->swift) && !empty($invoice_detail->swift))
                                                @php $edit_swift = explode(',', $invoice_detail->swift) @endphp
                                                @foreach($edit_swift as $key => $value)
                                                    @if($value ==  '') @continue @endif
                
                                                    <div class="form-group" id="row_swift0">
                                                        <label for="">{{trans('messages.keyword_swift')}} <span class="required">(*)</span></label>
                                                        <input class="form-control" placeholder="{{trans('messages.keyword_swift')}}" value="{{ $value }}" name="swift[]" id="swift" type="text">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="form-group" id="row_swift0">
                                                    <label for="">{{trans('messages.keyword_swift')}} <span class="required">(*)</span></label>
                                                    <input class="form-control" placeholder="{{trans('messages.keyword_swift')}}" value="" name="swift[]" id="swift" type="text">
                                                </div>
                                            @endif
        
        
        
                                            <div class="childswift"></div>
    
                                        </div>
                                    </div>
    
    
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
            <div class="col-md-6 col-sm-6 col-xs-6 text-right pull-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>
        </div>
    </div>
    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#invoice_detail_form").validate({
                rules: {
                    name: {
                        required: true
                    },
                    website: {
                        required: true,
                        url: true
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    "iban[]" : {
                        required: true
                    },
                    "vat_id[]" : {
                        required: true
                    },
                    "swift[]" : {
                        required: true
                    }
                    
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    website: {
                        required: "{{trans('messages.keyword_please_enter_a_web_url')}}",
                        url: "{{trans('messages.keyword_please_enter_valid_web_url')}}",
                    },
                    phone: {
                        required: "{{trans('messages.keyword_please_enter_a_phone')}}"
                    },
                    address: {
                        required: "{{trans('messages.keyword_please_enter_an_address')}}"
                    },
                    "iban[]" : {
                        required : "{{trans('messages.keyword_please_enter_a_iban')}}"
                    },
                    "vat_id[]" : {
                        required : "{{trans('messages.keyword_please_enter_a_vat_id')}}"
                    },
                    "swift[]" : {
                        required : "{{trans('messages.keyword_please_enter_a_swift')}}"
                    }
                }
            });

            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-######"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });
    </script>

    <script>
        iban_counter=$('#noofchildiban').val();

        $('#addiban').click(function(e) {
            iban_counter++;
            $('.childiban').append("<div class=\"form-group\" id=\"row_iban"+ iban_counter +"\">\n" +
                "    <label for=\"\">{{trans('messages.keyword_iban')}} <span class=\"required\">(*)</span></label>\n" +
                "    <input class=\"form-control\" placeholder=\"{{trans('messages.keyword_iban')}}\" value=\"\" name=\"iban[]\" id=\"iban\" type=\"text\">\n" +
                "</div>");
            $('#noofchildiban').val(iban_counter);
        });
        $('#removeiban').click(function(e) {
            if(iban_counter==0){
                alert("you cannot delete first record");
                return true;
            }
            $("#row_iban" + iban_counter).remove();
            iban_counter--;
        });
    </script>
    <script>
        swift_counter=$('#noofchildswift').val();

        $('#addswift').click(function(e) {
            swift_counter++;
            $('.childswift').append("<div class=\"form-group\" id=\"row_swift"+ swift_counter +"\">\n" +
                "    <label for=\"\">{{trans('messages.keyword_swift')}} <span class=\"required\">(*)</span></label>\n" +
                "    <input class=\"form-control\" placeholder=\"{{trans('messages.keyword_swift')}}\" value=\"\" name=\"swift[]\" id=\"swift\" type=\"text\">\n" +
                "</div>");
            $('#noofchildswift').val(swift_counter);
        });
        $('#removeswift').click(function(e) {
            if(swift_counter==0){
                alert("you cannot delete first record");
                return true;
            }
            $("#row_swift" + swift_counter).remove();
            swift_counter--;
        });
    </script>
    <script>
        vat_id_counter=$('#noofchildvat_id').val();

        $('#addvat_id').click(function(e) {
            vat_id_counter++;
            $('.childvat_id').append("<div class=\"form-group\" id=\"row_vat_id"+ vat_id_counter +"\">\n" +
                "    <label for=\"\">{{trans('messages.keyword_vat_id')}} <span class=\"required\">(*)</span></label>\n" +
                "    <input class=\"form-control\" placeholder=\"{{trans('messages.keyword_vat_id')}}\" value=\"\" name=\"vat_id[]\" id=\"vat_id\" type=\"text\">\n" +
                "</div>");
            $('#noofchildvat_id').val(vat_id_counter);
        });
        $('#removevat_id').click(function(e) {
            if(vat_id_counter==0){
                alert("you cannot delete first record");
                return true;
            }
            $("#row_vat_id" + vat_id_counter).remove();
            vat_id_counter--;
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

@endsection