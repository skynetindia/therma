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
    <div class="ssetting-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-btn">
                    <!--<a class="btn btn-add" data-backdrop="static" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>-->
                    <a href="{{url('wizard/option/addedit').'/'.(isset($category->id) ? $category->id : '') }}" class="btn btn-add btn-9-12"><i class="fa fa-plus"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit btn-9-12"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete btn-9-12"><i
                                class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        <div class="section-border wizard-screen">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">{{ isset($category->language_key) ? trans('messages.keyword_'.$category->language_key) : '' }}</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="<?php  echo url('wizard/optionsjson/'.(isset($category->id) ? $category->id : '0'));?>"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="status" data-sortable="true">{{trans('messages.keyword_active')}}</th>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="icon" data-sortable="true">{{trans('messages.keyword_icon')}}</th>
                                <th data-field="title" data-sortable="true">{{trans('messages.keyword_title')}}</th>
                                <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}</th>
                                <!--<th data-field="type" data-sortable="true">{{trans('messages.keyword_type')}}</th>-->
                                </thead>
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
        // validations
        $(document).ready(function() {
            $("#add_options_form").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    title: {
                        required: "{{trans('messages.keyword_please_enter_title')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    }
                }
            });
        });
        //validations

        function updateoptionsStatus(id) {
            var url = "{{ url('/wizard/options/changeactivestatus') }}" + '/';
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
            return confirm("{{trans('messages.keyword_are_you_sure_want__delete_options')}}");
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
                    link.href = "{{ url('/wizard/options/delete') }}" + '/' + {{$category->id}} + '/';
                    if (check() && n != 0) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n-1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/wizard/options/delete') }}" + '/'  + {{$category->id}} + '/' + indici[n];
                                    link.dispatchEvent(clickEvent);
                                    error = true;
                                }
                            }
                        });

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
                        link.href = "{{ url('/wizard/option/addedit') }}" + '/' + {{$category->id}} + '/' + indici;
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }







    </script>
@endsection
