@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/css/tableexport.min.css">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <script src="{{ asset('public/js/xlsx.core.min.js') }}"></script>
    <script src="{{ asset('public/js/tableExport.js') }}"></script>

    {{--{{ pre(getModules()) }}--}}

    <div class="dashbord-super-admin2">

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="upload-file">
                    <form>
                        <div class="dz-default dz-message" id="droptarget" data-size="1" ondrop="drop(event, this)" ondragover="allowDrop(event)"><span>Drag Module Here</span></div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="upload-file">
                    <form>
                        <div class="dz-default dz-message" id="droptarget" data-size="0" ondrop="drop(event, this)" ondragover="allowDrop(event)"><span>Drag Module Here</span></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            {{--Transfer Section--}}
            <?php $transfer = showHideModule('52'); ?>
            <div class="col-sm-12 col-xs-12 {{ $transfer }}">
                <div class="section-border">
                    <div class="transfer" onclick="removeConfirm(this)" data-remove-module="52"><h5>Transfer <i class="fa fa-times" aria-hidden="true"></i></h5></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-btn">
                                <a href="{{ url('transfer/edit') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                                <a href="javascript:void(0);" onclick="multipleTransferAction('modify');" class="btn btn-edit"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="javascript:void(0);" onclick="multipleTransferAction('delete');" class="btn btn-delete"><i
                                            class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="data-table">
                                <div class="table-responsive">

                                    <h1 class="cst-datatable-heading">@lang('messages.keyword_transfer') @lang('messages.keyword_list')</h1>
                                    <hr>
                                    <table data-toggle="table" data-search="true" data-pagination="true"
                                           data-id-field="id"
                                           data-show-refresh="true" data-toolbar="#toolbar" data-show-columns="true"
                                           data-url="<?php  echo url('/transfer/property/json');?>"
                                           data-classes="table table-bordered" data-show-export="true"
                                           id="transfer_table">
                                        <thead>
                                        <th data-field="checkbox">
                                            <input type="checkbox" onchange="toggleCheck(this)" name="" id="checkall">
                                        </th>
                                        <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                        <th data-field="status"
                                            data-sortable="true">{{trans('messages.keyword_confirm')}}</th>
                                        <th data-field="send_info_status"
                                            data-sortable="true">{{trans('messages.keyword_transfer')}} {{trans('messages.keyword_send_status')}}</th>
                                        <th data-field="unique_transfer_id"
                                            data-sortable="true">{{trans('messages.keyword_transfer')}} {{trans('messages.keyword_id')}}</th>
                                        <th data-field="client_name"
                                            data-sortable="true">{{trans('messages.keyword_client')}} {{trans('messages.keyword_name')}}</th>
                                        <th data-field="client_phone"
                                            data-sortable="true">{{trans('messages.keyword_client')}} {{trans('messages.keyword_phone')}}</th>
                                        <th data-field="direction"
                                            data-sortable="true">{{trans('messages.keyword_direction')}}</th>
                                        <th data-field="type"
                                            data-sortable="true">{{trans('messages.keyword_type')}}</th>
                                        <th data-field="pax" data-sortable="true">{{trans('messages.keyword_pax')}}</th>
                                        <th data-field="start"
                                            data-sortable="true">{{trans('messages.keyword_start')}}</th>
                                        <th data-field="destination"
                                            data-sortable="true">{{trans('messages.keyword_destination')}}</th>
                                        <th data-field="flight_time"
                                            data-sortable="true">{{trans('messages.keyword_flight')}} {{trans('messages.keyword_time')}}</th>
                                        <th data-field="flight"
                                            data-sortable="true">{{trans('messages.keyword_flight')}}</th>
                                        <th data-field="pickup_time"
                                            data-sortable="true">{{trans('messages.keyword_pickup_time')}}</th>
                                        <th data-field="notes"
                                            data-sortable="true">{{trans('messages.keyword_notes')}}</th>
                                        <th data-field="price"
                                            data-sortable="true">{{trans('messages.keyword_price')}}</th>
                                        </thead>
                                    </table>



                                </div>




                                <div class="transfer-list-btn">
                                    <button class="btn btn-default btn-6-12" onclick="checkNotEmptyReservations(this);">
                                        Confirm reservations
                                    </button>
                                    <button class="btn btn-info btn-6-12" type="button"
                                            onclick="checkNotEmptySendInfo(this)">Send info to Hotel
                                    </button>
                                    <button class="btn btn-success btn-6-12 text-right" id="exportCSV">Export (CSV)
                                    </button>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{--Transfer Section--}}


            {{--Promotions Section--}}
            <?php $promotions = showHideModule('7'); ?>
            <div class="col-sm-12 col-xs-12 {{ $promotions }}">
                <div class="ssetting-wrap">
                    <div class="transfer" onclick="removeConfirm(this)" data-remove-module="7"><h5>Promotions <i class="fa fa-times" aria-hidden="true"></i></h5></div>
                    <div class="section-border">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-btn">
                                    <!--<a class="btn btn-add" data-backdrop="static" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>-->
                                    <a href="{{ url('promotion/edit') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                                    <a href="javascript:void(0);" onclick="multiplePromotionsAction('modify');" class="btn btn-edit"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0);" onclick="multiplePromotionsAction('delete');" class="btn btn-delete"><i
                                                class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="data-table">
                                    <div class="table-responsive">
                                        <h1 class="cst-datatable-heading">@lang('messages.keyword_promotions')</h1><hr>
                                        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                               data-show-refresh="true" data-show-columns="true"
                                               data-url="{{ url('promotion/property/json') }}"
                                               data-classes="table table-bordered" id="promotions_table">
                                            <thead>
                                            <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                            <th data-field="code" data-sortable="true">{{trans('messages.keyword_code')}}</th>
                                            <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                            <th data-field="price" data-sortable="true">{{trans('messages.keyword_price')}}</th>
                                            <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}</th>
                                            <th data-field="is_active" data-sortable="true">{{trans('messages.keyword_status')}}</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Promotions Section--}}


            {{--Bookings Section--}}
            <?php $bookings = showHideModule('6'); ?>
            <div class="col-sm-12 col-xs-12 {{ $bookings }}">
                <div class="booking-wrap reservations-list">
                    <div class="section-border">
                        <div class="transfer" onclick="removeConfirm(this)" data-remove-module="6"><h5>Bookings <i class="fa fa-times" aria-hidden="true"></i></h5></div>
                        <div class="row">
                            <div class="col-md-12 col-sm1-12 col-xs-12">
                                <div class="table-btn">
                                    <a href="{{ url('/booking/edit/') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                                    <a href="javascript:void(0);" onclick="multipleBookingsAction('modify');"
                                       class="btn btn-edit"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0);" onclick="multipleBookingsAction('delete');"
                                       class="btn btn-delete"><i
                                                class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="data-table">
                                    <div class="table-responsive">
                                        <h1 class="cst-datatable-heading">@lang('messages.keyword_bookings')</h1>
                                        <hr>
                                        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                               data-show-refresh="true" data-show-columns="true"
                                               data-url="<?php  echo url('booking/property/json');?>"
                                               data-classes="table table-bordered" id="table">
                                            <thead>

                                            <th data-field="id" data-sortable="true" >{{trans('messages.keyword_id')}}</th>
                                            <th data-field="order_status" data-sortable="true">{{trans('messages.keyword_client_status')}}</th>
                                            <th data-field="temp_booking_id" data-sortable="true">{{trans('messages.keyword_booking_id')}}</th>
                                            <th data-field="create_date" data-sortable="true">{{trans('messages.keyword_date_and_hour')}}</th>
                                            <th data-field="hotel_status" data-sortable="true">{{trans('messages.keyword_hotel_status')}}</th>
                                            <th data-field="name" data-sortable="true">{{trans('messages.keyword_clientname_country')}}</th>
                                            <th data-field="email" data-sortable="true">{{trans('messages.keyword_client_email')}}</th>
                                            <th data-field="phone" data-sortable="true">{{trans('messages.keyword_client_phone')}}</th>
                                            <th data-field="hotel_id" data-sortable="true">{{trans('messages.keyword_hotel')}}</th>
                                            <!--<th data-field="city" data-sortable="true">{{trans('messages.keyword_city')}} / {{trans('messages.keyword_country')}}</th>-->
                                            <th data-field="arrival" data-sortable="true">{{trans('messages.keyword_check_in')}}</th>
                                            <th data-field="departure" data-sortable="true">{{trans('messages.keyword_check_out')}}</th>
                                            <th data-field="cart" data-sortable="true">{{trans('messages.keyword_cart')}}</th>
                                            <th data-field="total_fare" data-sortable="true">{{trans('messages.keyword_amount')}}</th>
                                            <th data-field="commission" data-sortable="true">{{trans('messages.keyword_commission')}}</th>
                                            <th data-field="transfer" data-sortable="true">{{trans('messages.keyword_transfer')}}</th>
                                            <th data-field="who_booked" data-sortable="true">{{trans('messages.keyword_who_has_booked')}}</th>
                                            <th data-field="reviews" data-sortable="true">{{trans('messages.keyword_reviews')}}</th>
                                            <th data-field="checked" data-sortable="true">{{trans('messages.keyword_checked')}}</th>
                                            <th data-field="notes" data-sortable="true">{{trans('messages.keyword_note')}}</th>


                                            </thead>
                                        </table>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Bookings Section--}}


            {{--Hotel Section--}}
            <?php $hotel = showHideModule('5'); ?>
            <div class="col-sm-12 col-xs-12 {{ $hotel }}">
                <div class="section-border">
                    <div class="transfer" onclick="removeConfirm(this)" data-remove-module="5"><h5>Hotel <i class="fa fa-times" aria-hidden="true"></i></h5></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-btn">
                                <a href="{{ url('/hotel/edit/basic') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                                <a href="javascript:void(0);" onclick="multipleHotelAction('modify');" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="javascript:void(0);" onclick="multipleHotelAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="data-table">
                                <div class="table-responsive">
                                    <h1 class="cst-datatable-heading">{{trans('messages.keyword_hotel')}}</h1><hr>
                                    <table data-toggle="table" data-search="true" data-pagination="true"
                                           data-id-field="id" data-show-refresh="true" data-show-columns="true"
                                           data-url="<?php  echo url('hotel/property/json');?>"
                                           data-classes="table table-bordered" id="hotel_table">
                                        <thead>
                                        <th data-field="status"
                                            data-sortable="true">{{trans('messages.keyword_active')}}</th>
                                        <th data-field="id"
                                            data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                        <th data-field="name"
                                            data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                        <th data-field="category"
                                            data-sortable="true">{{trans('messages.keyword_category')}}</th>
                                        <th data-field="phone"
                                            data-sortable="true">{{trans('messages.keyword_phone')}}</th>
                                        <th data-field="address"
                                            data-sortable="true">{{trans('messages.keyword_address')}}</th>
                                        <th data-field="email"
                                            data-sortable="true">{{trans('messages.keyword_email')}}</th>
                                        <th data-field="commissions"
                                            data-sortable="true">{{trans('messages.keyword_commissions')}}</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Hotel Section--}}

        </div>

    </div>


    {{--Test Drag Drop--}}
    <script type="text/javascript">
        //jq223 = jQuery.noConflict(true);
        function dragStart(event) {
            event.dataTransfer.setData("Text", event.target.id);
            event.target.style.opacity = "1";
        }

        function allowDrop(event) {
            event.preventDefault();
            /*event.target.style.border = "4px dotted #f37f0d";*/
        }


        function drop(event, e) {
            event.preventDefault();
            var data = event.dataTransfer.getData("Text");
            var module_id = $("#"+data).attr('valid');
            /*check for size 1 = col-md-8 and 0 = col-md-4*/
            var size_type = $(e).data('size');
            event.target.appendChild(document.getElementById(data));
            widgetupdate('add',module_id, size_type);
        }
        function widgetupdate(action,module_id, size_type){
            if(action=='delete'){
                var confirmation = confirm("{{trans('messages.keyword_are_you_sure?')}}");
                if (!confirmation)
                    return confirmation ;
            }
            $.ajax({
                type:'POST',
                data: { 'module_id': module_id,size_type: size_type,'action':action, '_token': '{{ csrf_token() }}' },
                url: '{{ url('dashboard/widgetupdate') }}',
                success:function(data) {
                    if(data == 'success'){
                        $("#droptarget").html("Drag Module Here");
                        window.location.reload(true);
                    }
                }
            });
        }

        function removeConfirm(e)
        {
            var module_id = $(e).data('remove-module');
            var confirmation = confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_this_module')}}");
            if(confirmation == true)
            {
                removeModule(module_id);
            }
        }
        function removeModule(module_id)
        {
            $.ajax({
                type:'POST',
                data: { 'module_id': module_id, '_token': '{{ csrf_token() }}' },
                url: '{{ url('dashboard/removewidget') }}',
                success:function(data) {

                    $("#droptarget").html("Drag Module Here");
                    window.location.reload(true);

                }
            });

        }
    </script>
    {{--Test Drag Drop--}}




    {{--Transfer Js Don't add Extra js here--}}
    <script>

        function updateTransferStatus(id) {
            var url = "{{ url('transfer/changeactivestatus') }}" + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }


                $.ajax({
                    type: "GET",
                    url: url + id + '/' + status,
                    error: function (url) {
                    },
                    success: function (data) {
                        /*$(".currencytogal").prop('checked',false);
                        $(".currencytogal").prop('disabled',false);*/
                        //$("#activestatus_"+id).prop('checked',true);
                        /*$("#activestatus_"+id).prop('disabled',true);*/
                    }
                });



        }


        var selezione = [];
        var indici = [];
        var n = 0;

        $('#transfer_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = /\d+/.exec($(el[0]).children()[1].innerHTML);
            if (!selezione[cod]) {
                $('#transfer_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;
            } else {
                $(el[0]).removeClass("selected");
                selezione[cod] = undefined;
                for(var i = 0; i < n; i++) {
                    if(indici[i] == cod) {
                        for(var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                n--;
                $('#transfer_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;
            }
        });

        function transfer_check_confirm() {

            return confirm("{{trans('messages.keyword_are_you_sure_want_to_confirm_selected_reservations?')}}");
        }

        function remove_transfer_confirm()
        {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_transfer')}}");
        }


        function transfer_confirm($checkedLength)
        {
            if( transfer_check_confirm()) {

                var sendUrl = "{{ url('transfer/confirm-reservations') }}" + '/';
                $(".child_checkbox:checked").each(function(){
                    id = $(this).data('id');
                    //alert(id);

                    $.ajax({
                        type: "GET",
                        url : sendUrl + id,

                    });

                });
                var n = $(".child_checkbox:checked").length;
                setTimeout(function () {

                    location.reload();
                }, 100 * n);

            }
        }
        function transfer_send()
        {
            var sendUrl = "{{ url('transfer/send-info-to-hotel') }}";
            $(".child_checkbox:checked").each(function(){


                id = $(this).data('id');

                var description = $("#description").val();

                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", description: description, id: id},
                    url : sendUrl,

                });

            });

            var n = $(".child_checkbox:checked").length;
            setTimeout(function () {

                location.reload();
            }, 100 * n);

        }

        function multipleTransferAction(act) {
            var error = false;
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            switch(act) {
                case 'modify':
                    if (n != 0 && n == 1) {
                        n--;
                        link.href = "{{ url('/transfer/edit/') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
                case 'delete':
                    link.href = "{{ url('/transfer/delete') }}" + '/';
                    if (remove_transfer_confirm() && n != 0 && n==1) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/transfer/delete') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });
                        //}
                        selezione = undefined;
                        if (error === false)
                            setTimeout(function () {
                                location.reload();
                            }, 100 * n);

                        n = 0;
                    }
                    break;
            }
        }

        $("#exportCSV").on("click", function(){
            //$('#table').tableExport({type:'csv', fileName: 'Transfer List', ignoreCols:1});
            $("table").tableExport({
                headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
                footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
                type: 'csv',
                fileName: "Transfer List",                    // (id, String), filename for the downloaded file
                bootstrap: true,                   // (Boolean), style buttons using bootstrap
                position: "bottom",                 // (top, bottom), position of the caption element relative to table
                ignoreRows: [1,2,3],                  // (Number, Number[]), row indices to exclude from the exported file(s)
                ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
                ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
                emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
                trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
            });

        });

        function toggleCheck(e)
        {
            if($(e).prop('checked'))
            {
                $(".child_checkbox").prop('checked', true);
            }else{
                $(".child_checkbox").prop('checked', false);
            }
        }

        function checkNotEmptyReservations(e)
        {
            var checkedLength = $(".child_checkbox:checked").length;
            if(checkedLength == '0')
            {
                alert('{{ trans('messages.keyword_please_select_atleast_one_record') }}');

            }else{
                transfer_confirm();
            }
        }

        function checkNotEmptySendInfo(e)
        {
            var checkedLength = $(".child_checkbox:checked").length;
            if(checkedLength == '0')
            {
                alert('{{ trans('messages.keyword_please_select_atleast_one_record') }}');
            }else{
                $("#info_to_hotel").modal('show');
            }
        }

        $(document).ready(function () {

            $('#departure_date, #arrival_date, #end_date, #start_date').datepicker({
                format: "yyyy-mm-dd",
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
            }).datepicker();

        });
    </script>
    {{--End : Transfer Js Don't add Extra js here--}}

    {{-- Hotel Js Don't add Extra js here--}}
    <script>
        function updateHotelStatus(id) {
            var url = "{{ url('/hotel/changeactivestatus') }}" + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }
            if(confirmToggle(status, '', '') == true)
            {
                $.ajax({
                    type: "GET",
                    url: url + id + '/' + status,
                    error: function (url) {
                    },
                    success: function (data) {
                    }
                });
            }else{
                if($("#activestatus_" + id).is(':checked')){
                    $("#activestatus_" + id).prop('checked', false);
                }else{
                    $("#activestatus_" + id).prop('checked', true);
                }
            }
        }

        var selezione = [];
        var indici = [];
        var n = 0;
        var selectedid = 0;

        $('#hotel_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[1].innerHTML;
            if (!selezione[cod]) {
                $('#hotel_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                selectedid = cod;
                //n++;

            } else {
                $(el[0]).removeClass("selected");
                /*selezione[cod] = undefined;
                for(var i = 0; i < n; i++) {
                    if(indici[i] == cod) {
                        for(var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                n--;*/
                $('#hotel_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                selectedid = cod;
                //n++;
            }
        });

        function hotel_check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want__delete_hotel')}}");
        }

        function multipleHotelAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('/hotel/delete') }}" + '/';
                    if (hotel_check() && selectedid != 0) {
                        $.ajax({
                            type: "GET",
                            url: link.href + selectedid,
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/hotel/delete') }}" + '/' + selectedid;
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            },
                            success: function (url) {
                                location.reload();
                            }
                        });
                        selezione = undefined;
                        selectedid = 0;
                    }
                    break;
                case 'modify':
                    if (selectedid != 0) {
                        link.href = "{{ url('/hotel/edit/basic') }}" + '/' + selectedid;
                        selectedid = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }
    </script>
    {{--End : Hotel Js Don't add Extra js here--}}

    {{--Bookings Js Don't add Extra js here--}}
    <script>
        function updateBookingStatus(id) {
            var url = "{{ url('/menu/changeactivestatus') }}" + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }
            $.ajax({
                type: "GET",
                url: url + id + '/' + status,
                error: function (url) {
                },
                success: function (data) {
                    /*$(".currencytogal").prop('checked',false);
                    $(".currencytogal").prop('disabled',false);*/
                    //$("#activestatus_"+id).prop('checked',true);
                    /*$("#activestatus_"+id).prop('disabled',true);*/
                }
            });
        }

        function updateBookingConfirmStatus(id) {
            var url = "{{ url('/booking/changeconfirmstatus') }}" + '/';
            var status = '0';
            if ($("#confirmstatus_" + id).is(':checked')) {
                status = '1';
            }
            $.ajax({
                type: "GET",
                url: url + id + '/' + status,
                error: function (url) {
                },
                success: function (data) {
                    /*$(".currencytogal").prop('checked',false);
                    $(".currencytogal").prop('disabled',false);*/
                    //$("#activestatus_"+id).prop('checked',true);
                    /*$("#activestatus_"+id).prop('disabled',true);*/
                }
            });
        }

        var selezione = [];
        var indici = [];
        var n = 0;

        $('#bookings_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[0].innerHTML;
            if (!selezione[cod]) {
                $('#bookings_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            } else {
                $(el[0]).removeClass("selected");
                selezione[cod] = undefined;
                for (var i = 0; i < n; i++) {
                    if (indici[i] == cod) {
                        for (var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                n--;
                $('#bookings_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });

        function bookings_check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_delete_booking')}}");
        }

        function multipleBookingsAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('booking/delete') }}" + '/';
                    alert(link.href + (n));
                    if (bookings_check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/booking/delete') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });
                        //}
                        selezione = undefined;
                        if (error === false)
                            setTimeout(function () {
                                location.reload();
                            }, 100 * n);

                        n = 0;
                    }
                    break;
                case 'modify':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('booking/edit') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
                case 'updatePhase':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('/language/translation/') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }
    </script>
    <script>

        function getNotesIdToModal(e) {
            var unique_booking_id = $(e).data('unique-id');
            $(".getDynamicBookingId").html(" {{ trans('messages.keyword_booking_id') }}: " + unique_booking_id);

            var booking_id = $(e).data('id');
            $("#booking_id").val(booking_id);
        }

        $('#notesModal').on('shown.bs.modal', function (e) {

            var booking_id = $("#booking_id").val();

            $.ajax({
                url: '{{ url('booking/getNotes') }}',
                method: 'POST',
                data: {"_token": "{{ csrf_token() }}", booking_id: booking_id},
                success: function (data) {
                    $("#getNotes").html(data);
                }
            });

        });


        $('#get_notes_modal_form').on('submit', function (e) {
            e.preventDefault();


            var booking_id = $("#booking_id").val();
            var description = $("#description").val();


            if (description != '' && description.length <= 200) {
                $("#descriptionValidation").html("");
                $.ajax({
                    url: '{{ url('booking/submit/note') }}',
                    method: 'POST',
                    data: {"_token": "{{ csrf_token() }}", booking_id: booking_id, description: description},
                    success: function (data) {
                        $("#getNotes").html(data);
                        $("#description").val('');
                    }
                });
            } else if (description.length > 200) {
                $("#descriptionValidation").html("Please enter lower than 200 characters");
            }
            else {
                $("#descriptionValidation").html("Please enter note");
            }
            ;


        });


        $(document).ready(function () {

            $('#departure_date, #arrival_date, #end_date, #start_date').datepicker({
                format: "yyyy-mm-dd",
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
            }).datepicker();

        });


        $("#hotel_country").on("blur", function () {
            var location = $(this).val();
            if (location != '') {
                $.ajax({
                    url: '{{ url('booking/get/hotel_list') }}',
                    method: 'POST',
                    data: {"_token": "{{ csrf_token() }}", location: location},
                    success: function (data) {
                        $("#getHotelList").html(data);
                    }
                });
            }
        });

    </script>
    {{--End: Bookings Js Don't add Extra js here--}}

    {{--Promotions Js Don't add Extra js here--}}
    <script type="application/javascript">

        function updatePromotionStatus(id) {
            var url = "{{ url('/promotion/changeactivestatus') }}"  + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }

            if(confirmToggle(status, '', '') == true)
            {
                $.ajax({
                    type: "GET",
                    url: url + id + '/' + status,
                    error: function (url) {
                    },
                    success: function (data) {
                    }
                });
            }else{
                if($("#activestatus_" + id).is(':checked')){
                    $("#activestatus_" + id).prop('checked', false);
                }else{
                    $("#activestatus_" + id).prop('checked', true);
                }
            }
        }


        var selezione = [];
        var indici = [];
        var n = 0;

        $('#promotions_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[0].innerHTML;
            if (!selezione[cod]) {
                $('#promotions_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            } else {
                $(el[0]).removeClass("selected");
                selezione[cod] = undefined;
                for (var i = 0; i < n; i++) {
                    if (indici[i] == cod) {
                        for (var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                n--;
                $('#promotions_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });

        function promotions_check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_promotion')}}");
        }

        function multiplePromotionsAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('promotion/delete') }}" + '/';
                    if (promotions_check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/promotion/delete') }}" + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });
                        //}
                        selezione = undefined;
                        if (error === false)
                            setTimeout(function () {
                                location.reload();
                            }, 100 * n);

                        n = 0;
                    }
                    break;
                case 'modify':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('promotion/edit') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
                case 'updatePhase':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('/language/translation/') }}" + '/' + indici[n];
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }



    </script>
    {{--Promotions Js Don't add Extra js here--}}
@endsection




{{--Transfer Modals--}}
<div id="info_to_hotel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_send_info_to_hotel')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="description">@lang('messages.keyword_description')</label>
                    <textarea name="description" id="description" cols="30" rows="3" style="resize: vertical;" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="transfer_send();">@lang('messages.keyword_send')</button>
            </div>

        </div>

    </div>
</div>
{{--Transfer Modals--}}

{{--Bookings Modals--}}
<div id="notesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => 'booking/submit/note', 'method'=> 'post' , 'id' => 'get_notes_modal_form')) }}
            <div class="modal-header">
                <h4 class="modal-title">@lang('messages.keyword_notes') <span
                            class="getDynamicBookingId pull-right"></span></h4>

            </div>
            <div class="modal-body">
                <input type="hidden" name="booking_id" id="booking_id" value="">
                <div id="getNotes" class="getNotes"></div>

                <textarea name="description" id="description" cols="30" rows="3" style="resize: vertical;"
                          class="form-control"></textarea>
                <span class="required" id="descriptionValidation"></span>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">close</button>
                <button type="submit" class="btn btn-default btn-def-boot">Send</button>
            </div>
            {{ Form::close() }}
        </div>

    </div>
</div>

<div id="reviewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_reviews')</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{--Bookings Modals--}}






