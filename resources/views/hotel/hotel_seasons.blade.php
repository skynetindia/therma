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
            <a href="{{ url('/hotel/season/add') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
            <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
             <a href="javascript:void(0);" onclick="multipleAction('copy');" class="btn btn-edit"><i class="fa fa-copy"></i></a>
            <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
        </div>                                    
    </div>
 </div> 
        <div class="section-border">
            <?php /*<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"><div class="new"><a href="#" class="pull-right btn btn-default btn-6-12" data-toggle="modal" data-target="#add_season">new</a></div></div>
            </div>*/?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">

                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">{{trans('messages.keyword_seasons')}}</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="{{ url('/hotel/seasons/json/').'/'.$hotel_id }}"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                <th data-field="category" data-sortable="true">{{trans('messages.keyword_markets')}}</th>
                                <?php /*<th data-field="season_publish_at" data-sortable="true">{{trans('messages.keyword_season_publish_at')}}</th>*/?>
                                <th data-field="season_from" data-sortable="true">{{trans('messages.keyword_from')}}</th>
                                <th data-field="season_to" data-sortable="true">{{trans('messages.keyword_to')}}</th>
                                <th data-field="actions" data-sortable="true">{{trans('messages.keyword_actions')}}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="application/javascript">
    function confermfun(e) {
        var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_you_want_to_delete');?>") ;
        if (!confirmation)
            e.preventDefault();
        return confirmation ;
    }

        $(document).ready(function () {
            $('#date1,#date2,#date3,#date4,#date5,#date6,#date7,#date8,#date9,#date10').datepicker({
                format: "dd-mm-yyyy",
                daysOfWeekDisabled: [0],
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
                orientation: "top"
            }).datepicker("setDate", res[4]);
        });
        // validations
        $(document).ready(function () {
            $("#add_season_form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_name')}}",
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

        var selezione;
        var indici;
        var n = 0;

        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[0].innerHTML;
            if (!selezione) {
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione = cod;
                indici = cod;
                n++;

            } else {
                $(el[0]).removeClass("selected");
                selezione = undefined;
                n--;
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione = cod;
                indici = cod;
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
                    link.href = "{{ url('/hotel/season/delete') }}";
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + '/' +indici,
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/hotel/season/delete') }}" + '/' + indici;
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
                        link.href = "{{ url('hotel/season/edit') }}" + '/' + indici;
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
				case 'copy':
                    if (n != 0) {
                        n--;
                        link.href = "{{ url('hotel/season/copy') }}" + '/' + indici;
                        n = 0;
                        selezione = undefined;
                        link.dispatchEvent(clickEvent);
                    }
                    break;
            }
        }


    </script>
    <!-- Modal -->
<div class="modal fade hotel-prices1-new-modal" id="add_season" role="dialog">
    <div class="modal-dialog">

        {{ Form::open(array('url' => 'hotel/season/add', 'files' => true, 'id' => 'add_season_form')) }}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_add_season')</h4>
            </div>
            <?php /*<input type="hidden" name="hotel_id" value="{{ $hotel_id }}">*/?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input class="form-control" name="name" id="" placeholder="" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select class="form-control" name="category">
                                <option>all markets</option>
                                <option>all hotels</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Season From</label>
                            <input class="form-control" name="season_from" id="date9" placeholder="" type="text">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Season To</label>
                            <input class="form-control" name="season_to" id="date10" placeholder="" type="text">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12">save</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection



