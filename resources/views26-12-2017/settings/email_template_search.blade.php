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

                {{ Form::open(array('url' => '/email/template/search', 'files' => true, 'id' => 'template_search_form')) }}

                <div class="email-template-tab">
                    <h3 class="email-heading">@lang('messages.keyword_search_template')</h3>
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
                                <label>@lang('messages.keyword_name') :</label>
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
            </div><hr>
        </div>

        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">@lang('messages.keyword_templates')</h1>
                            <table data-toggle="table" id="table"  data-search="true" data-pagination="true"  data-show-refresh="true"  data-show-columns="true" data-classes="table table-bordered" >
                                <thead>
                                <th>{{trans('messages.keyword_id')}}</th>
                                <th>{{trans('messages.keyword_status')}}</th>
                                <th>{{trans('messages.keyword_subject')}}</th>
                                <th>{{trans('messages.keyword_description')}}</th>

                                </thead>
                                <tbody>
                                @forelse($filtered_template as $template)
                                    <tr>

                                        <td>{{ $template->e_t_id }}</td>

                                        <?php $checked = ($template->is_active == 0) ? 'checked' : ''; ?>
                                        <td>
                                            <div class="switch"><input name="status" class="currencytogal" onchange="updateEmailTemplateStatus({{  $template->e_t_id  }})" id="activestatus_{{ $template->e_t_id }}" {{ $checked }} value="1"  type="checkbox"><label for="activestatus_{{ $template->e_t_id }}"></label></div>
                                        </td>
                                        <td>{{ $template->subject }}</td>
                                        <td>{!! html_entity_decode($template->description) !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No Template found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>



    <script>

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

    </script>


@endsection