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
                        <h3 class="heading">@lang('messages.keyword_booking') : {{ trans('messages.keyword_add')}}</h3>
                        <form action="{{url('/taxonomies/booking/savenew')}}" method="post" id="frmbookingadd" name="frmbookingadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
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
                    <h1 class="cst-datatable-heading">@lang('messages.keyword_booking') : {{trans('messages.keyword_edit')}}</h1>
                    <div class="select-all">
                        @if(checkpermission($module_id,$parent_id, 1))
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="ryt-chk">
                                        <input id="chktasbookingall" name="chktasbookingall" type="checkbox"><label for="chktasbookingall">@lang('messages.keyword_select_all')</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                    <input type="button" onclick="AllbookingAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                    <input type="button" onclick="AllbookingAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <form action="{{url('/taxonomies/booking/update')}}" method="post" id="frmeditbooking">
                        <input type="hidden" id="actionbooking" name="action" value="update">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered checkbox-tbl">
                                @foreach($taxinomies_booking as $types)
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id[]" value="{{$types->id}}">
                                    <tr>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <div class="ryt-chk">
                                                    <input class="chkbooking" type="checkbox" name="chkbooking[{{$types->id}}]" id="chkbooking_{{$types->id}}" value="{{$types->id}}">
                                                    <label for="chkbooking_{{$types->id}}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission  }} class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo $types->name; ?>"/>
                                                <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <input type="text" {{ $inputReadyOnlyOnReadPermission  }} class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"/>
                                            </div>
                                        </td>
                                        @if(checkpermission($module_id,$parent_id, 1))
                                            <td>
                                                <button class="btn btn-default btn-6-12" type="button" onclick="SingleBookingTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                                                <a onclick="conferma(event);" type="button" href="javascript:SingleBookingTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
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
            var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_bookings');?>");
            if (!confirmation)
                e.preventDefault();
            return confirmation;
        }

        $(document).ready(function () {
            $("#frmbookingadd").validate({
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

            $("#frmeditbooking").validate({
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


        $("#chktasbookingall").click(function () {
            $('.chkbooking').not(this).prop('checked', this.checked);
            addremoveclass();
        });
        $(".chkbooking").click(function () {
            addremoveclass();
        });


        function SingleBookingTaxonomiesAction(id, action) {
            $("#chkbooking_" + id).prop('checked', true);
            $("#actionbooking").val(action);
            $("#frmeditbooking").submit();
        }


        function AllbookingAction(action) {
            if ($("#frmeditbooking input:checkbox:checked").length > 0) {
                if (action == 'delete') {
                    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_want_to_remove_selected_bookings');?>");
                    if (!confirmation) {
                        return false;
                    }
                }
                $("#actionbooking").val(action);
                $("#frmeditbooking").submit();
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