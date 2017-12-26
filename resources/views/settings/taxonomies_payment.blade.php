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
                        <h3 class="heading">@lang('messages.keyword_payment') : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/payment/savenew')}}" method="post" id="frmpaymentadd" name="frmpaymentadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}" required>
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
                    <h1 class="cst-datatable-heading">@lang('messages.keyword_payment') : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktaspaymentall" name="chktaspaymentall" type="checkbox"><label for="chktaspaymentall">@lang('messages.keyword_select_all')</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllpaymentAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllpaymentAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/payment/update')}}" method="post" id="frmeditpayment">
                        <input type="hidden" id="actionpayment" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_payment as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkpayment" type="checkbox" name="chkpayment[{{$types->id}}]" id="chkpayment_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkpayment_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" id="description" value="<?php echo $types->description; ?>"/>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" type="button" onclick="SinglepaymentTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SinglepaymentTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
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

    <div class="taxonomies-wrap">
        @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
            
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="middle-head-add">
                        <h3 class="heading">@lang('messages.keyword_invoice_action') : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/invoice_action/savenew')}}" method="post" id="frminvoice_actionadd" name="frminvoice_actionadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="description" placeholder="{{trans('messages.keyword_description')}}" required>
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
                    <h1 class="cst-datatable-heading">@lang('messages.keyword_invoice_action') : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktasinvoice_actionall" name="chktasinvoice_actionall" type="checkbox"><label for="chktasinvoice_actionall">@lang('messages.keyword_select_all')</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="Allinvoice_actionAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="Allinvoice_actionAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{url('/taxonomies/invoice_action/update')}}" method="post" id="frmeditinvoice_action">
                        <input type="hidden" id="actioninvoice_action" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxonomies_invoice_actions as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkinvoice_action" type="checkbox" name="chkinvoice_action[{{$types->id}}]" id="chkinvoice_action_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkinvoice_action_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                    
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" id="description" value="<?php echo $types->description; ?>"/>
                                            </div>
                                        </td>
                                    
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission }} class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" type="button" onclick="Singleinvoice_actionTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:Singleinvoice_actionTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
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
            var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_options');?>");
            if (!confirmation)
                e.preventDefault();
            return confirmation;
        }

        $(document).ready(function () {
            $("#frmpaymentadd").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    description: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    }
                }
            });

            $("#frmeditpayment").validate({
                rules: {
                    "name[]": {
                        required: true,
                    },
                    "description[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    "description[]": {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    }
                }
            });
        });


        $("#chktaspaymentall").click(function () {
            $('.chkpayment').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkpayment").click(function () {
            addremoveclass();
        });


        function SinglepaymentTaxonomiesAction(id, action) {
            $("#chkpayment_" + id).prop('checked', true);
            $("#actionpayment").val(action);
            $("#frmeditpayment").submit();
        }


        function AllpaymentAction(action) {
            if ($("#frmeditpayment input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_options');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actionpayment").val(action);
                $("#frmeditpayment").submit();
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

    <script type="text/javascript">
        function conferma(e) {
            var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_options');?>");
            if (!confirmation)
                e.preventDefault();
            return confirmation;
        }

        $(document).ready(function () {
            $("#frmeditinvoice_action").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    description: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    }
                }
            });

            $("#frmeditinvoice_action").validate({
                rules: {
                    "name[]": {
                        required: true,
                    },
                    "description[]": {
                        required: true,
                    }
                },
                messages: {
                    "name[]": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    },
                    "description[]": {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    }
                }
            });
        });


        $("#chktasinvoice_actionall").click(function () {
            $('.chkinvoice_action').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkinvoice_action").click(function () {
            addremoveclass();
        });


        function Singleinvoice_actionTaxonomiesAction(id, action) {
            $("#chkinvoice_action_" + id).prop('checked', true);
            $("#actioninvoice_action").val(action);
            $("#frmeditinvoice_action").submit();
        }


        function Allinvoice_actionAction(action) {
            if ($("#frmeditinvoice_action input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_options');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actioninvoice_action").val(action);
                $("#frmeditinvoice_action").submit();
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