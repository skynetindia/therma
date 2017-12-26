@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jqColorPicker.min.js')}}"></script>
    @php
        $inputReadyOnlyOnReadPermission = (checkpermission($module_id,$parent_id, 1) == false) ? 'disabled' : '';
    @endphp
    
    
    <!-- ======================================================= Emotional Status ========================================== -->
    <div class="taxonomies-wrap">
        @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="middle-head-add">
                        <h3 class="heading">Emotional Status : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/emotionalstatus/savenew')}}" method="post" id="frmemotionalstatusadd" name="frmemotionalstatusadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control color no-alpha" type="text" name="color" value="#B6BD79">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="cst-datatable-heading">Emotional Status : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktasemotionalstatusall" name="chktasemotionalstatusall" type="checkbox"><label for="chktasemotionalstatusall">select all</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllemotionalstatusAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllemotionalstatusAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/emotionalstatus/update')}}" method="post" id="frmeditemotionalstatus">
                        <input type="hidden" id="actionemotionalstatus" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_emotional_status as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkemotionalstatus" type="checkbox" name="chkemotionalstatus[{{$types->id}}]" id="chkemotionalstatus_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkemotionalstatus_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.' . $types->language_key) : $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} disabled class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" type="button" onclick="SingleEmotionalstatusTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SingleEmotionalstatusTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- ========================================================= Credit Card ========================================== -->
    <div class="taxonomies-wrap">
        @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="middle-head-add">
                        <h3 class="heading">Credit Card : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/creditcard/savenew')}}" method="post" id="frmcreditcardadd" name="frmcreditcardadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control color no-alpha" type="text" name="color" value="#B6BD79">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="cst-datatable-heading">Credit Card : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktascreditcardall" name="chktascreditcardall" type="checkbox"><label for="chktascreditcardall">select all</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllCreditCardAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllCreditCardAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/creditcard/update')}}" method="post" id="frmeditcreditcard">
                        <input type="hidden" id="actiontype" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_credit_cards as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkcreditcardtype" type="checkbox" name="chkcreditcardtype[{{$types->id}}]" id="chkcreditcardtype_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkcreditcardtype_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.' . $types->language_key) : $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" onclick="SingleTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- ==================================================== VAT INVOICE SECTION ===================================================== -->
    <div class="taxonomies-wrap">
        @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="middle-head-add">
                        <h3 class="heading">VAT Invoicing : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/vatinvoice/savenew')}}" method="post" id="frmvatinvoiceadd" name="frmvatinvoiceadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control color no-alpha" type="text" name="color" value="#B6BD79">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="cst-datatable-heading">VAT Invoicing : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktasvatinvoiceall" name="chktasvatinvoiceall" type="checkbox"><label for="chktasvatinvoiceall">select all</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllvatinvoiceAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllvatinvoiceAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/vatinvoice/update')}}" method="post" id="frmeditvatinvoice">
                        <input type="hidden" id="actiontypevatinvoice" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_vat_invoicing as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkvatinvoicetype" type="checkbox" name="chkvatinvoicetype[{{$types->id}}]" id="chkvatinvoicetype_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkvatinvoicetype_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.' . $types->language_key) : $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" onclick="SingleVatinvoiceAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SingleVatinvoiceAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- ==================================================== Age Type SECTION ===================================================== -->
    <div class="taxonomies-wrap">
        @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="middle-head-add">
                        <h3 class="heading">Age Type : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/agetype/savenew')}}" method="post" id="frmagetypeadd" name="frmagetypeadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="age" placeholder="Age">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="cst-datatable-heading">Age Type : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktasagetypeall" name="chktasagetypeall" type="checkbox"><label for="chktasagetypeall">select all</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllagetypeAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllagetypeAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/agetype/update')}}" method="post" id="frmeditagetype">
                        <input type="hidden" id="actiontypeagetype" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_age_type as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkagetype" type="checkbox" name="chkagetype[{{$types->id}}]" id="chkagetype_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkagetype_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.' . $types->language_key) : $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" name="age[{{$types->id}}]" value="{{$types->age}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" onclick="SingleagetypeAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SingleagetypeAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <script>
        jQuery(document).ready(function () {
            jQuery('.scrollbar-inner').scrollbar();

            /******** Funtion start **********/

            setTimeout(function () {

                var oldURL = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
                var index = 0;
                var newURL = oldURL;
                index = oldURL.indexOf('?');
                if (index == -1) {
                    index = oldURL.indexOf('#');
                }
                if (index != -1) {
                    newURL = oldURL.substring(0, index);
                }

                /* START auto scroll to active menu */
                var total_menu_item = $(".navbar-default .navbar-nav > li > a").length;
                var avgpos = parseInt(parseInt($('.scrollbar-inner').width()) / parseInt(total_menu_item));
                var tempcount = 1;
                /* END auto scroll to active menu */
                $(".navbar-default .navbar-nav > li > a").each(function () {


                    if ($(this).attr("href") == newURL || $(this).attr("href") == '') {

                        $(this).addClass("active");

                        /* START auto scroll to active menu */
                        $('.scrollbar-inner').animate({
                            scrollLeft: parseInt(tempcount * avgpos)
                        }, 500);

                    }
                    tempcount++;

                    /* END auto scroll to active menu */


                })

                $(".user-menu-tab .list-unstyled > li a").each(function () {

                    if ($(this).attr("href") == newURL || $(this).attr("href") == '') {

                        $(this).addClass("active");

                    }
                })

                $(".sidebar-wrapper ul li a").each(function () {

                    if ($(this).attr("href") == newURL || $(this).attr("href") == '') {

                        $(this).addClass("active");

                    }
                })


            }, 1000);


            /******** Funtion END **********/
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script type="text/javascript">
        $('.color').colorPicker(); // that's it
    </script>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        function conferma(e) {
            var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
            if (!confirmation)
                e.preventDefault();
            return confirmation;
        }

        $(document).ready(function () {
            $("#frmemotionalstatusadd").validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

            $("#frmeditemotionalstatus").validate({
                rules: {
                    "name[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });
            $("#frmcreditcardadd").validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

            $("#frmeditcreditcard").validate({
                rules: {
                    "name[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });
            $("#frmvatinvoiceadd").validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

            $("#frmeditvatinvoice").validate({
                rules: {
                    "name[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

            $("#frmagetypeadd").validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

            $("#frmeditagetype").validate({
                rules: {
                    "name[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });

        });
        $("#chktascreditcardall").click(function () {
            $('.chkcreditcardtype').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkcreditcardtype").click(function () {
            addremoveclass();
        });

        $("#chktasemotionalstatusall").click(function () {
            $('.chkemotionalstatus').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkemotionalstatus").click(function () {
            addremoveclass();
        });


        $("#chktasvatinvoiceall").click(function () {
            $('.chkvatinvoicetype').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkvatinvoicetype").click(function () {
            addremoveclass();
        });

        $("#chktasagetypeall").click(function () {
            $('.chkagetype').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkagetype").click(function () {
            addremoveclass();
        });

        function SingleEmotionalstatusTaxonomiesAction(id, action) {
            $("#chkemotionalstatus_" + id).prop('checked', true);
            $("#actionemotionalstatus").val(action);
            $("#frmeditemotionalstatus").submit();
        }

        function SingleTaxonomiesAction(id, action) {
            $("#chkcreditcardtype_" + id).prop('checked', true);
            $("#actiontype").val(action);
            $("#frmeditcreditcard").submit();
        }

        function SingleVatinvoiceAction(id, action) {
            $("#chkvatinvoicetype_" + id).prop('checked', true);
            $("#actiontypevatinvoice").val(action);
            $("#frmeditvatinvoice").submit();
        }

        function SingleagetypeAction(id, action) {
            $("#chkagetype_" + id).prop('checked', true);
            $("#actiontypeagetype").val(action);
            $("#frmeditagetype").submit();
        }


        function AllemotionalstatusAction(action) {
            if ($("#frmeditemotionalstatus input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actionemotionalstatus").val(action);
                $("#frmeditemotionalstatus").submit();
            }
            else {
                alert("{{trans('messages.keyword_select_at_least_one_record')}}");
            }
        }


        function AllCreditCardAction(action) {
            if ($("#frmeditcreditcard input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actiontype").val(action);
                $("#frmeditcreditcard").submit();
            }
            else {
                alert("{{trans('messages.keyword_select_at_least_one_record')}}");
            }
        }


        function AllvatinvoiceAction(action) {
            if ($("#frmeditvatinvoice input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actiontypevatinvoice").val(action);
                $("#frmeditvatinvoice").submit();
            }
            else {
                alert("{{trans('messages.keyword_select_at_least_one_record')}}");
            }
        }

        function AllagetypeAction(action) {
            if ($("#frmeditagetype input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actiontypeagetype").val(action);
                $("#frmeditagetype").submit();
            }
            else {
                alert("{{trans('messages.keyword_select_at_least_one_record')}}");
            }
        }


        function addremoveclass() {
            $(".table input[type=checkbox]").each(function () {
                if (false == $(this).prop("checked")) {
                    $(this).closest("tr").removeClass("selected");
                }
                else {
                    $(this).closest("tr").addClass("selected");
                }
            });
        }
    </script>
@endsection	