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
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <?php $arrlanguages = getlanguages();?>


        <div class="message-wrap alert-wrap">
    
            @if(checkpermission($module_id,$parent_id, 1))
            <div class="row">
                <div class="col-md-12 col-sm1-12 col-xs-12">
                    <!--<p class="invoice-information-head">This is was issued on 1 nov 2016, based on the information displayed below. <a href="#">Click here to view the reservations.</a></p>-->
                    <div class="table-btn">
                        <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                    class="fa fa-trash"></i></a>
                    </div>

                </div>
            </div>
            @endif

            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="data-table">
                            <div class="table-responsive">
                                <h1 class="cst-datatable-heading">@lang('messages.keyword_support')</h1>
                                <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                       data-show-refresh="true" data-show-columns="true"
                                       data-url="{{ url('message/support/property/json') }}"
                                       data-classes="table table-bordered" id="table">
                                    <thead>
                                    <th data-field="id" data-sortable="true">{{trans('messages.keyword_support_id')}}</th>
                                    <th data-field="unique_ticket" data-sortable="true">{{trans('messages.keyword_ticket_id')}}</th>
                                    <th data-field="subject" data-sortable="true">{{trans('messages.keyword_subject')}}</th>
                                    <th data-field="created_at" data-sortable="true">{{trans('messages.keyword_created_at')}}</th>
                                    <th data-field="updated_at" data-sortable="true">{{trans('messages.keyword_last_update')}}</th>
                                    <th data-field="is_active" data-sortable="true">{{trans('messages.keyword_status')}}</th>
                                    
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    <script type="application/javascript">

        function updateSupportStatus(id) {
            var url = "{{ url('message/support/changeactivestatus') }}"  + '/';
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
            var cod = $(el[0]).children()[0].innerHTML;
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
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_support')}}");
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
                    link.href = "{{ url('message/support/delete') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('message/support/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('support/edit') }}" + '/' + indici[n];
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
