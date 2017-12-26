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

        <div class="section-border">
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">Hotel Options</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="{{ url('/hotel/options/property/json') }}"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                                <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
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


<script>
   function percentageActive(e) {
        var id = $(e).attr('id');
        if($(e).prop('checked')) {
            $('.percentage_'+ id).removeAttr('disabled');
        } else {
			$('.percentage_'+ id).val("");
            $('.percentage_'+ id).attr("disabled", "disabled");
        }
    }

    function showRoomsModal(hotel_id)
    {
        var url = '{{ url('hotel/get/room_list/') }}'+ "/" + hotel_id;
        $.get(url , function( data ) {
            $("#append_rooms_html").html(data);
        });

        $("#rooms_modal").modal('show');
    }


    function showMealsModal(hotel_id)
    {
        var url = '{{ url('hotel/get/meals_list/') }}'+ "/" + hotel_id;
        $.get(url , function( data ) {
            $("#append_meals_html").html(data);
        });

        $("#meals_modal").modal('show');
    }


    function showMealsCombinationModal(hotel_id)
    {
        var url = '{{ url('hotel/get/meals_combination_list/') }}'+ "/" + hotel_id;
        $.get(url , function( data ) {
            $("#append_meals_combination_html").html(data);
        });

        $("#meals_combination_modal").modal('show');
    }

    function showPenaltyModal(hotel_id)
    {
        var url = '{{ url('hotel/get/penalty_list/') }}'+ "/" + hotel_id;
        $.get(url , function( data ) {
            $("#append_penalty_html").html(data);
        });

        $("#penalty_modal").modal('show');
    }
	
    function showRoomsModal(hotel_id)
    {
        var url = "{{ url('hotel/get/room_list/') }}"+ "/" + hotel_id;
        $.get(url , function( data ) {
            $("#append_rooms_html").html(data);
        });

        $("#rooms_modal").modal('show');
    }
    function showPlacementModal(hotel_id) {
        var url = "{{ url('hotel/get/room_placement/') }}"+ "/" + hotel_id+"/"+"{{$max_room_places}}"+"/{{$max_room_extra_places}}";
        $.get(url , function(data) {
            $("#Placement_details").html(data);
        });        
        $("#place_op_hotel_id").val(hotel_id);
        $("#placement_modal").modal('show');
    }
</script>

<!-- Penalty Modal-->
<div class="modal fade room-modal" id="penalty_modal" role="dialog">

    <div class="modal-dialog">
    {{ Form::open(array('url' => 'hotel/penalty/update/', 'files' => true, 'id' => 'add_penalty_form')) }}
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_penalty')</h4>
            </div>
            <div class="modal-body" id="append_penalty_html">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12" >save changes</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<!-- Penalty Modal-->



<!-- Meals combination Modal-->
<div class="modal fade room-modal" id="meals_combination_modal" role="dialog">

    <div class="modal-dialog">
    {{ Form::open(array('url' => 'hotel/meals_combination/update/', 'files' => true, 'id' => 'add_meals_combination_form')) }}
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_meals_combination')</h4>
            </div>
            <div class="modal-body" id="append_meals_combination_html">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12" >save changes</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<!-- Meals combination Modal-->


<!-- Meals Modal-->
<div class="modal fade room-modal" id="meals_modal" role="dialog">

    <div class="modal-dialog">
    {{ Form::open(array('url' => 'hotel/meals/update/', 'files' => true, 'id' => 'add_meals_form')) }}
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_meals')</h4>
            </div>
            <div class="modal-body" id="append_meals_html">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12" >save changes</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<!-- Meals Modal-->



<!-- Modal -->
<div class="modal fade room-modal" id="rooms_modal" role="dialog">

    <div class="modal-dialog">
    {{ Form::open(array('url' => 'hotel/options/update/', 'files' => true, 'id' => 'add_season_form')) }}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">rooms</h4>
            </div>
            <div class="modal-body" id="append_rooms_html">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12" >save changes</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade placement-modal1" id="placement_modal" role="dialog">
    <div class="modal-dialog modal-lg">
    {{ Form::open(array('url' => 'hotel/placement_options/update/', 'files' => true, 'id' => 'add_placement_form')) }}
    <input type="hidden" name="hotel_id" id="place_op_hotel_id">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Placement options</h4>
            </div>

            <div class="modal-body">
                <div id="Placement_details" class="table-responsive">
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-6-12">save changes</button>
            </div>
        </div>
    {{ Form::close() }}

    </div>
</div>