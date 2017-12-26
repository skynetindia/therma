@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{--Style for add review slider remove it after css done--}}
    <style>
        .review_slider_ul li{
            display:inline;
            margin-left:0px;
            margin-right:14px;
        }
        .ui-widget.ui-widget-content{
            width:91%;
        }
    </style>
    {{--Style for add review slider remove it after css done--}}
    @include('common.errors')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <div class="ssetting-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-btn">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#editReviewModal" id="getBookingandHotelIdHere" data-hotel-id="" data-booking-id="" onclick="getHotelAndBookingId(this)" class="btn btn-edit"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);"  onclick="multipleAction('delete');" class="btn btn-delete"><i
                                class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">


                            <h1 class="cst-datatable-heading">@lang('messages.keyword_reviews')</h1>
                            <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id"
                                   data-show-refresh="true" data-show-columns="true"
                                   data-url="{{ url('reviews/property/json') }}"
                                   data-classes="table table-bordered" id="table">
                                <thead>
                                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>


                                <?php $user_type = getUserTypeByUserID(Auth::user()->id); ?>
                                
                                <th data-field="is_active" data-sortable="true">{{trans('messages.keyword_status')}}</th>
                                <th data-field="hotel_id" data-sortable="true">{{trans('messages.keyword_hotel')}}</th>
                                <th data-field="client_name" data-sortable="true">{{trans('messages.keyword_client_name')}}</th>
                                <th data-field="title" data-sortable="true">{{trans('messages.keyword_title')}}</th>
                                <th data-field="description" data-sortable="true">{{trans('messages.keyword_description')}}</th>
                                {{--<th data-field="edit_review" data-sortable="true">{{trans('messages.keyword_reviews')}}</th>--}}
                                
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



        function updateReviewConfirm(id) {
            var url = "{{ url('/reviews/changereviewconfirm') }}"  + '/';
            var status = '1';
            if ($("#activeconfirm_" + id).is(':checked')) {
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

        function updateReviewStatus(id) {
            var url = "{{ url('/reviews/changeactivestatus') }}"  + '/';
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



        function sendHotelandBookingToEditButton(cod){
            $.ajax({
                url: '{{ url('reviews/getAjaxHotelAndBookingId') }}' + '/' + cod,
                method: 'GET',
                success: function(data){

                    var data = jQuery.parseJSON(data);
                    var booking_id = data[0];
                    var hotel_id = data[1];
                    
                    //$("#getBookingandHotelIdHere").hide();
                    $("#getBookingandHotelIdHere").data('hotel-id', hotel_id);
                    $("#getBookingandHotelIdHere").data('booking-id', booking_id);

                    $("#add_review_hotel_id").val(hotel_id);
                    $("#add_review_booking_id").val(booking_id);
                    
                }
            });
        }

        var selezione = [];
        var indici = [];
        var n = 0;

        
        
        
        $('#table').on('click-row.bs.table', function (row, tr, el) {
            var cod = $(el[0]).children()[0].innerHTML;
            sendHotelandBookingToEditButton(cod);
            $("#add_review_id").val(cod);
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
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_remove_review')}}");
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
                    link.href = "{{ url('reviews/delete') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/reviews/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('reviews/edit') }}" + '/' + indici[n];
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


    <script>

        $('#editReviewModal').on('shown.bs.modal', function (e) {

            var hotel_id = $("#add_review_hotel_id").val();
            var booking_id = $("#add_review_booking_id").val();
            var review_id = $("#add_review_id").val();

            $.ajax({
                    url: '{{ url('booking/getAddReviews') }}' + "/" + review_id,
                    method: 'POST',
                    data : {"_token": "{{ csrf_token() }}",review_id: review_id, hotel_id: hotel_id,booking_id: booking_id, action: 'edit'},
                    success: function(data){
                        $("#getEditReviewForm").html(data);
                    }
                });

        });

        function clearModalBody(e){
            $("#getEditReviewForm").empty();
            $("#editReviewModal").modal('hide');
        }
        
    </script>
@endsection



{{-- Add Review Modal --}}
<div id="editReviewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            {{--{{ Form::open(array('url' => 'booking/submit/note', 'method'=> 'post' , 'id' => 'get_notes_modal_form')) }}--}}
            <div class="modal-header">
                <h4 class="modal-title" >@lang('messages.keyword_notes') <span class="getDynamicBookingId pull-right"></span></h4>
            </div>
            <input type="hidden" id="add_review_id" name="review_id" value="">
            <input type="hidden" id="add_review_hotel_id" name="hotel_id" value="">
            <input type="hidden" id="add_review_booking_id" name="booking_id" value="">
            <div id="getEditReviewForm"></div>
            {{--{{ Form::close() }}--}}
        </div>
    
    </div>
</div>
{{-- Add Review Modal --}}
