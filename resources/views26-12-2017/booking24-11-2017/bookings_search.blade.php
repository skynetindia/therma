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
                    <a href="{{ url('/booking/detail/') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i
                                class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>

        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">@lang('messages.keyword_bookings')</h1>
                            <table data-toggle="table" id="table"  data-search="true" data-pagination="true"  data-show-refresh="true"  data-show-columns="true" data-classes="table table-bordered" >
                                <thead>
                                    <th>{{trans('messages.keyword_id')}}</th>
                                    <th>{{trans('messages.keyword_hotel')}}</th>
                                    <th>@lang('messages.keyword_confirm')</th>
                                    <th>@lang('messages.keyword_client')</th>
                                    <th>@lang('messages.keyword_phone')</th>
                                    <th>@lang('messages.keyword_email')</th>
                                    <th>@lang('messages.keyword_city')</th>
                                    <th>@lang('messages.keyword_card')</th>
                                    <th>@lang('messages.keyword_price')</th>
                                    <th>@lang('messages.keyword_notes')</th>
                                    <th>@lang('messages.keyword_arrival')</th>
                                    <th>@lang('messages.keyword_departure')</th>
                                </thead>
                                <tbody>
                                    @forelse($filtered_booking as $booking)
                                        <tr>
                                            <td>{{ $booking->booking_id }}</td>
                                            <td>{{ $booking->hotel_name }}<br>{{ $booking->category_title }}</td>
                                            <?php $checked = ($booking->confirm == 1) ? 'checked' : ''; ?>
                                            <td><div class="switch"><input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus({{ $booking->booking_id }})" id="confirmstatus_{{ $booking->booking_id }}"  {{ $checked }} value="1"  type="checkbox"><label for="confirmstatus_{{  $booking->booking_id }}"></label></div></td>
                                            <td>{{ $booking->client }}</td>
                                            <td>{{ $booking->phone}}</td>
                                            <td>{{ $booking->email }}</td>
                                            <td>{{ $booking->city }}</td>
                                            <td>{{ $booking->card }}</td>
                                            <?php $cur = getActiveCurrency(); ?>
                                            <td>{{ $booking->price }} {{ $cur['symbol'] }}</td>
                                            <td>{{ $booking->notes }}</td>
                                            <td>{{ $booking->arrival }}</td>
                                            <td>{{ $booking->departure }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No bookings found</td>
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

        function updateBookingStatus(id) {
            var url = "{{ url('/menu/changeactivestatus') }}" + '/';
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

        function updateBookingConfirmStatus(id) {
            var url = "{{ url('/booking/changeconfirmstatus') }}" + '/';
            var status = '0';
            if ($("#confirmstatus_" + id).is(':checked')) {
                status = '1';
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
            return confirm("{{trans('messages.keyword_are_you_sure_want__delete_category')}}");
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
                    link.href = "{{ url('/menu/delete') }}" + '/';
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/menu/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('/menu/edit/') }}" + '/' + indici[n];
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