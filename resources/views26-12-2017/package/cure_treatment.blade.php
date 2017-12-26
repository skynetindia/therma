@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    <style>

        #treatment_table thead > tr > th.detail,
        #treatment_table tbody > tr:not(.detail-view) > td:first-of-type,
        #cure_table thead > tr > th.detail,
        #cure_table tbody > tr:not(.detail-view) > td:first-of-type{
            display: none;
        }

        #cure_table thead > tr > th:nth-child(2),
        #cure_table tbody > tr:not(.detail-view) > td:nth-child(2) {
            border-left: none!important;
        }

    </style>
    @include('common.errors')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <div class="ssetting-wrap">
        <div class="col-md-6">
            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-btn">
                            <!--<a class="btn btn-add" data-backdrop="static" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>-->
                            <a href="{{ url('package/edit')."/".$hotel_id }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                            <a href="javascript:void(0);" onclick="multipleTreatmemtAction('modify');" class="btn btn-edit"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="javascript:void(0);" onclick="multipleTreatmemtAction('delete');" class="btn btn-delete"><i
                                        class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="data-table">
                            <div class="table-responsive">
                                <h1 class="cst-datatable-heading">@lang('messages.keyword_treatment')</h1>
                                <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                       data-show-refresh="true" data-show-columns="true"
                                       data-url="{{ url('package/property/json')."/".$hotel_id }}"
                                       data-classes="table table-bordered" id="table">
                                    <thead>
                                    <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                    <th data-field="code" data-sortable="true">{{trans('messages.keyword_code')}}</th>
                                    <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                    <th data-field="image" data-sortable="true">{{trans('messages.keyword_icon')}}</th>
                                    <th data-field="price" data-sortable="true">{{trans('messages.keyword_price')}}</th>
                                    <th data-field="description"
                                        data-sortable="true">{{trans('messages.keyword_description')}}</th>
                                    <th data-field="status" data-sortable="true">{{trans('messages.keyword_active')}}</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-btn">
                            <!--<a class="btn btn-add" data-backdrop="static" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>-->
                            <a href="{{ url('package/cure-treatment/edit')."/".$hotel_id }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                            <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                        class="fa fa-trash"></i></a>
                        </div>
                        <div class="data-table">

                            <div class="table-responsive">
                                <h1 class="cst-datatable-heading">@lang('messages.keyword_cure')</h1>
                                <table id="cure_table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true" data-id-field="id" data-toggle="table" data-detail-view="true" data-detail-formatter="detailFormatter">
                                    <thead>
                                    <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                    <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                    <th data-field="price" data-sortable="true">{{trans('messages.keyword_price')}}</th>
                                    <th data-field="discount" data-sortable="true">{{trans('messages.keyword_discount')}}</th>
                                    <th data-field="commission" data-sortable="true">{{trans('messages.keyword_commission')}}</th>
                                    <th data-field="net_price" data-sortable="true">{{trans('messages.keyword_net_price')}}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($cures as $key => $cure)
                                        <tr>
                                            <td>{{ $cure->id }}</td>
                                            <td>{{ $cure->name }}</td>
                                            <td>{{ $cure->price }}</td>
                                            <td>{{ $cure->discount }}</td>
                                            <td>{{ $cure->commission }}</td>
                                            <td>{{ $cure->net_price }}</td>
                                            <span style="display:none;" id="cure_desc{{ $key }}">
                                                    <div class="text-justify pull-left">{{ $cure->description }}</div>
                                                    <div class="">
                                                        @if(!empty($cure->image) && $cure->image != null)
                                                            <img src="{{ asset('public/images/cure_treatment')."/".$cure->image }}" class="thumbnail" style="width:60px" alt="">
                                                        @else
                                                            <img src="{{ asset('public/images/default/default_cure_treatment.jpg') }}" class="thumbnail" style="width:60px" alt="">
                                                        @endif
                                                    </div>
                                                </span>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="application/javascript">


        function updatePackageStatus(id) {
            var url = "{{ url('/package/changeactivestatus') }}"  + '/';
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
        
        function updatePackageOptionsStatus(id) {
            var url = "{{ url('/package/cure-treatment/changeactivestatus') }}"  + '/';
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


        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[0].innerHTML;
            if (!selezione[cod]) {
                $('#treatment_table tr.selected').removeClass("selected");
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

        function check_transfer() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_treatment')}}");
        }


        function multipleTreatmemtAction(act) {
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            var error = false;
            switch (act) {
                case 'delete':
                    link.href = "{{ url('package/delete') }}" + '/';
                    if (check_transfer() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/package/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('package/edit') }}" + '/' + '{{ $hotel_id }}' + '/' + indici[n];
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
        /*Treatment Table*/


        /*cure Table*/
        var $table_cure = $('#cure_table');

        $table_cure.on('expand-row.bs.table', function(e, index, row, $detail) {
            var res = $("#cure_desc" + index).html();
            $detail.html(res);
        });

        $table_cure.on("click-row.bs.table", function(e, row, $tr) {

            if ($tr.next().is('tr.detail-view')) {
                $table_cure.bootstrapTable('collapseRow', $tr.data('index'));
            } else {
                $table_cure.bootstrapTable('expandRow', $tr.data('index'));
            }
        });



        $('#cure_table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[1].innerHTML;
            if (!selezione[cod]) {
                $('#cure_table tr.selected').removeClass("selected");
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
                $('#cure_table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });
        /*cure Table*/


















        function check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_option')}}");
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
                    link.href = "{{ url('package/cure-treatment/delete') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('package/cure-treatment/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('package/cure-treatment/edit') }}" + '/' + '{{ $hotel_id }}' + '/' + indici[n];
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

