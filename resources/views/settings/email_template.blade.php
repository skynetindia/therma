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


    <div class="ssetting-wrap email-template-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                {{ Form::open(array('url' => '/email/template/search', 'files' => true, 'id' => 'template_search_form')) }}

                <div class="email-template-tab">
                    <h3 class="email-heading">@lang('messages.keyword_email_template')</h3>
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>@lang('messages.keyword_category') :</label>
                                <select class="form-control" name="email_cat_id">
                                    <option value="">@lang('messages.keyword_--select--')</option>
                                    @forelse(getEmailTemplateCategory() as $category)
                                        <option value="{{ $category->id }}" {{ (isset($template->email_cat_id) && $category->id == $template->email_cat_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @empty
                                        <option value="">@lang('messages.keyword_no_categories')</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>@lang('messages.keyword_subject') :</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="filter_name"/>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group search-text">
                                <label>@lang('messages.keyword_tags') :</label>
                                <input type="text" class="form-control" placeholder="Enter Search tags"
                                       name="filter_tag"/>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <button class="btn btn-default">@lang('messages.keyword_search')</button>
                        </div>

                    </div>

                    {{--Main Loop--}}
                    @foreach(array_chunk(getEmailTemplateCategory(), 1) as $chunk)
                        <div class="row">
                            @foreach($chunk as $key => $category)

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="section-border">
                                        <div class="table-btn">
                                            <a href="{{url('email/template/edit') }}" class="btn btn-add"><i
                                                        class="fa fa-plus"></i></a>
                                            <a href="javascript:void(0)" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0)" onclick="multipleAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <hr/>
                                        <div class="table-responsive">
                                            <div class="data-table">
                                                <div class="table-responsive">
                                                    <h1 class="cst-datatable-heading">{{ $category->name }}</h1>
                                                    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                                           data-show-refresh="true" data-show-columns="true"
                                                           data-url="<?php  echo url('email/template/json/')."/".$category->id ;?>"
                                                           data-classes="table table-bordered" class="table">
                                                        <thead>
                                                            <th data-field="status" data-sortable="true">{{trans('messages.keyword_active')}}</th>
                                                            <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                                            <th data-field="subject" data-sortable="true">{{trans('messages.keyword_subject')}}</th>
                                                            <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}</th>
                                                        </thead>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    {{--Main Loop--}}

                </div>

            </div>


        </div>
    </div>

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>

    <script>

        $( "#template_search_form" ).validate({
            rules: {
                email_cat_id: {
                    required: true
                }
            },
            messages: {
                email_cat_id: {
                    required: "@lang('messages.keyword_please_select_category')"
                }
            }
        });




        function updateEmailTemplateStatus(id) {
            var url = "{{ url('/email/template/changeactivestatus') }}" + '/';
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

        $('.table').on('click-row.bs.table', function (row, tr, el) {
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
                $('.table tr.selected').removeClass("selected");
                $(el[0]).addClass("selected");
                selezione[cod] = cod;
                indici[n] = cod;
                n++;

            }
        });

        function check() {
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_template')}}");
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
                    link.href = "{{ url('email/template/delete') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/email/template/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('email/template/edit') }}"  + '/'  + indici[n];
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

