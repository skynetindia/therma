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
    
                @if(checkpermission($module_id,$parent_id, 1))
                <div class="col-md-4">
                    <div class="table-btn">
                        <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                    class="fa fa-trash"></i></a>
                    </div>
                </div>
                @endif
{{--                {{ Form::open(array('url' => 'activity/list', 'files' => true, 'id' => 'change_log_form')) }}--}}
                <div class="col-md-8">
                        <div class="form-group">
                            <label for="log">@lang('messages.keyword_choose_log_type') : </label>
                            <select name="type_id" onchange="submitForm(this)" id="" class="form-control">
                                <option value="">@lang('messages.keyword_--select--')</option>
                                    <option value="all" <?php if(isset($type_id) && $type_id == 'all') { echo "selected";} else { echo '';} ?>>@lang('messages.keyword_all')</option>
                                @forelse(getUserTypes() as $key => $value)
                                    <option value="{{ $value->id }}" <?php if(isset($type_id) && $type_id == $value->id) { echo "selected";} else { echo ''; } ?>>{{ $value->type }}</option>
                                @empty
                                    <option value="">@lang('messages.keyword_--select--')</option>
                                @endforelse
                            </select>
                        </div>
                </div>
{{--                {{ Form::close() }}--}}
            </div>
        </div>
        <br>
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">
                                    @lang('messages.keyword_activity_log') @if(isset($type_id)) {{ getUserTypesById($type_id) }} @endif
                            </h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="<?php  echo isset($type_id) ? (url('activity/json')."/".$type_id) : url('activity/json');?>"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="user_id" data-sortable="true">{{trans('messages.keyword_user')}}</th>
                                <th data-field="type" data-sortable="true">{{trans('messages.keyword_type')}}</th>
                                <th data-field="logs" data-sortable="true">{{trans('messages.keyword_activity_log')}}</th>
                                <th data-field="log_date" data-sortable="true">{{trans('messages.keyword_log_date')}}</th>
                                <th data-field="ip_address" data-sortable="true">{{trans('messages.keyword_ip_address')}}</th>
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

        function updateUsersStatus(id) {
            var url = "{{ url('/users/changeactivestatus') }}"  + '/';
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





    </script>

    <script>
        function submitForm(e)
        {
            var id = $(e).val();
            if(id == 'all')
            {
                window.location=  '{{ url('activity/list') }}';
            }
            else{
                window.location=  '{{ url('activity/list') }}' + '/' + id;
            }


        }
    </script>


    <script>
        var selezione = [];
        var indici = [];
        var n = 0;

        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
            if (!selezione[cod]) {
                // $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;
            } else {
                //$(el[0]).removeClass("selected");
                selezione[cod] = undefined;
                for(var i = 0; i < n; i++) {
                    if(indici[i] == cod) {
                        for(var x = i; x < indici.length - 1; x++)
                            indici[x] = indici[x + 1];
                        break;
                    }
                }
                /*n--;
                $('#table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;*/
                n++;
            }
        });
        function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_logs')}}?"); }

        function multipleAction(act) {
            var error = false;
            var link = document.createElement("a");
            var clickEvent = new MouseEvent("click", {
                "view": window,
                "bubbles": true,
                "cancelable": false
            });
            switch(act) {
                case 'delete':
                    link.href = "{{ url('activity/delete') }}" + '/';
                    if(check() && n!=0) {
                        for(var i = 0; i < n; i++) {
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    if(url.status==403) {
                                        link.href = "{{ url('/activity/delete/') }}" + '/' + indici[i];
                                        link.dispatchEvent(clickEvent);
                                    }
                                }
                            });
                            if(i==n){
                                setTimeout(function(){location.reload();},100*n);
                                n = 0;
                            }
                        }
                        selezione = undefined;
                        setTimeout(function(){location.reload();},100*n);
                        n = 0;
                    }
                    break;
            }
        }
    </script>
@endsection

