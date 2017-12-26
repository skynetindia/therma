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
    <div class="hotel-options hotel-prices">

        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">Hotel Prices</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="{{ url('/hotel/prices/property/json') }}"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                                <th data-field="season_publish_at"
                                    data-sortable="true">{{trans('messages.keyword_season_publish_at')}}</th>
                                <th data-field="season_from"
                                    data-sortable="true">{{trans('messages.keyword_season_from')}}</th>
                                <th data-field="season_to"
                                    data-sortable="true">{{trans('messages.keyword_season_to')}}</th>
                                <th data-field="actions" data-sortable="true">{{trans('messages.keyword_actions')}}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

