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


    <div class="step-page"><div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="thirdst"></li>
                        <li class="navigation-item " id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div></div>


    <div class="ssetting-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-btn">
                    <a href="{{ url('hotel/room/edit') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">@lang('messages.keyword_room_details')</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="<?php  echo url('hotel/room/property/json') ;?>"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="status" data-sortable="true">{{trans('messages.keyword_room_availability')}}</th>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="hotel" data-sortable="true">{{trans('messages.keyword_hotel')}}</th>
                                <th data-field="personal_name" data-sortable="true">{{trans('messages.keyword_personal_name')}}</th>
                                <th data-field="unit_of_measurement" data-sortable="true">{{trans('messages.keyword_unit_of_measurement')}}</th>
                                <th data-field="price_per_night" data-sortable="true">{{trans('messages.keyword_base_price_per_night')}}</th>
                                <th data-field="discount" data-sortable="true">{{trans('messages.keyword_discount')}}</th>
                                <th data-field="fare_amount" data-sortable="true">{{trans('messages.keyword_fare_amount')}}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-shape">

            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="javascript:void(0);" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><a href="{{ url('hotel/edit/room-options') }}" class="btn btn-default">@lang('messages.keyword_next')</a></div>
            </div>


        </div>
    </div>
    </div>

    <script>
        function updateRoomStatus(id) {
            var url = "{{ url('/hotel/room/changeactivestatus') }}" + '/';
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

        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[1].innerHTML;
            if (!selezione[cod]) {
                $('#table tr.selected').removeClass("selected");
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
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });

        function check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_delete_room')}}");
        }

        function multipleAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('/hotel/room/delete/') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/hotel/room/delete/') }}" + '/' + indici[n];
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
                        link.href = "{{ url('/hotel/room/edit/') }}" + '/' + indici[n];
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


@endsection