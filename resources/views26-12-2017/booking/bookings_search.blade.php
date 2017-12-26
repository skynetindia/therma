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
    
    <div class="booking-wrap booking-search reservations-list">
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
                        <!--<h1 class="cst-datatable-heading">@lang('messages.keyword_bookings') @lang('messages.keyword_search')</h1>-->
                         <h1 class="cst-datatable-heading">@lang('messages.keyword_bookings')</h1>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="heading-search-dashboard">
                                    {{ Form::open(array('url' => 'bookings/search', 'files' => true, 'id' => 'booking_search_form')) }}
                                    <div class="form-wrap">                                    
                                    		<div class="booking-width-calc">                                    
                                        <div class="input form-group">
                                           <label>@lang('messages.keyword_search')</label>
                                           <input type="text" class="form-control" name="general_search" value="{{isset($post_data->general_search) ? $post_data->general_search : ''}}" placeholder="@lang('messages.keyword_search')"/>
                                        </div>
                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_order_status')</label>
                                            <select class="form-control bg-arrow" name="client_status">
                                                
                                                 <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getClientStatus() as $key => $status)
                                                    <option value="{{ $key }}" {{(isset($post_data->client_status) && $post_data->client_status == $key) ? 'selected' : ''}}>{{ $status }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <div class="date-input ">
                                                <label>@lang('messages.keyword_start_date')</label>
                                                <input type="text" id="start_date" value="{{isset($post_data->arrival) ? date('m/d/Y', strtotime($post_data->arrival)) : old('arrival')}} " name="arrival" class="form-control startdate"/>
                                            </div>
                                            <div>-</div>
                                            <div class="date-input">
                                                <label>@lang('messages.keyword_end_date')</label>
                                                <input type="text" id="end_date" value="{{isset($post_data->departure) ? date('m/d/Y', strtotime($post_data->departure))  : old('departure')}}" placeholder="mm/dd/yyyy" name="departure" class="form-control enddate"/>
                                            </div>
                                        </div>
                                         <div class="input form-group">
                                            <label>@lang('messages.keyword_booking') @lang('messages.keyword_status')</label>
                                            <select class="form-control bg-arrow" name="booking_status">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                 @forelse(getStatus() as $key => $bookingStatus)
                                                	<option value="{{ $key}}" {{(isset($post_data->booking_status) && $post_data->booking_status == $key) ? 'selected' : ''}}>{{ ucfirst($bookingStatus) }}</option>
                                                 @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_hotel') @lang('messages.keyword_status')</label>
                                            <select class="form-control bg-arrow" name="hotel_status">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getEmotionalStatus() as $key => $emotionalStatus)
                                                    <option value="{{ $emotionalStatus->id }}" <?php echo (isset($post_data->hotel_status) && $post_data->hotel_status == $emotionalStatus->id) ? 'selected' : ''; ?>>{{ $emotionalStatus->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_country') / @lang('messages.keyword_location')</label>
                                            <input type="text" name="hotel_country" id="hotel_country" value="{{isset($post_data->hotel_country) ? $post_data->hotel_country : old('hotel_country')}}" class="input form-control hotel-country" onKeyup="//getHotelList(this)">
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_hotel_list')</label>
                                            <select class="form-control bg-arrow" id="getHotelList" name="hotel_list">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_country')</label>
                                            <select class="form-control bg-arrow" name="booking_country">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getBookingsCountries() as $key => $country)
                                                    <option value="{{ $country->i_id }}" <?php echo (isset($post_data->booking_country) && $post_data->booking_country == $country->i_id ) ? 'selected' : ''; ?>>{{ $country->v_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_transfer')</label>
                                            <select class="form-control bg-arrow" name="transfer">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getStatus() as $key => $status)
                                                    <option value="{{ $key }}" <?php echo (isset($post_data->transfer) && $post_data->transfer == $key ) ? 'selected' : ''; ?>>{{ $status }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_currencies')</label>
                                            <select class="form-control bg-arrow" name="currency">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getCurrencies() as $key => $currency)
                                                    <option value="{{ $currency->code }}" <?php echo (isset($post_data->currency) && $post_data->currency == $currency->code ) ? 'selected' : ''; ?>>{{ $currency->name }} - {{ $currency->symbol }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_cart_guarantee')</label>
                                            <select class="form-control bg-arrow" name="cart_guarantee">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getCardStatus() as $key => $status)
                                                    <option value="{{ $key }}" <?php echo (isset($post_data->cart_guarantee) && $post_data->cart_guarantee ==  $key ) ? 'selected' : ''; ?>>{{ $status }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input form-group">
                                            <label>@lang('messages.keyword_who_has_booked')</label>
                                            <select class="form-control bg-arrow" name="user_type">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="0" <?php echo (isset($post_data->user_type) && $post_data->user_type ==  '0') ? 'selected' : ''; ?>>Super Admin</option>
                                                @forelse(getUserTypes() as $userType)
                                                    <option value="{{ $userType->id }}" <?php echo (isset($post_data->user_type) && $post_data->user_type ==  $userType->id ) ? 'selected' : ''; ?>>{{ $userType->type }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
											
                                            </div>
                                            
                                        <div class="clearfix"></div>
                                        <div class="dashbord-filter inline-block pull-right">
                                            <button type="submit" id="booking_filtes_button" href="#" class="btn btn-default">@lang('messages.keyword_filter')</button>
                                            <a href="{{url('bookings')}}" class="btn btn-default"><i class="fa fa-times"
                                                                                   aria-hidden="true"></i></a>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                    {{ Form::close() }}
                                </div>


                            </div>


                            </div>


                            <div class="panel-body">

                                <div class="table-responsive">

                                    <table data-toggle="table" id="table"  data-search="true" data-pagination="true"  data-show-refresh="true"  data-show-columns="true" data-classes="table table-bordered" >
                                        <thead>
                                            <th class="none">{{trans('messages.keyword_id')}}</th>
                                             <th>{{trans('messages.keyword_id')}}</th>
                                            <th>{{trans('messages.keyword_order_status')}}</th>
                                          
                                            <th>{{trans('messages.keyword_date_and_hour')}}</th>
                                            <th>{{trans('messages.keyword_hotel_status')}}</th>
                                            <th>{{trans('messages.keyword_clientname_country')}}</th>
                                            <th>{{trans('messages.keyword_client_email')}}</th>
                                            <th>{{trans('messages.keyword_client_phone')}}</th>
                                            <th>{{trans('messages.keyword_hotel')}}</th>
                                            <!--<th>{{trans('messages.keyword_city')}} / {{trans('messages.keyword_country')}}</th>-->
                                            <th>{{trans('messages.keyword_check_in')}}</th>
                                            <th>{{trans('messages.keyword_check_out')}}</th>
                                            <th>{{trans('messages.keyword_cart')}}</th>
                                            <th>{{trans('messages.keyword_amount')}}</th>
                                            <th>{{trans('messages.keyword_commission')}}</th>
                                            <th>{{trans('messages.keyword_transfer')}}</th>
                                            <th>{{trans('messages.keyword_who_has_booked')}}</th>
                                            <th>{{trans('messages.keyword_reviews')}}</th>
                                            <th>{{trans('messages.keyword_checked')}}</th>
                                            <th>{{trans('messages.keyword_note')}}</th>
                                        </thead>
                                        <tbody>
                                        @forelse($filtered_booking as $booking)
                                      
                                            <tr>
                                            
                                            
											<td class="none">{{$booking->id}}</td>
                                        
                                             <td>{!! $booking->temp_booking_id !!}</td>
                                                <td>{!! $booking->order_status !!}</td>
                                               
                                                <td>{{ $booking->create_date }}</td>
                                                <td>{!! $booking->hotel_status !!}</td>
                                                <td>{{ $booking->name}} ( {{ $booking->country }})</td>
                                                <td>{{ $booking->email }}</td>
                                                <td>{{ $booking->phone}}</td>
                                                <td>{{ $booking->hotel_name }} <br> {{ $booking->category_title }}</td>                                                
                                                <td>{{ $booking->arrival }}</td>
                                                <td>{{ $booking->departure }}</td>
                                                <td>{!! $booking->cart !!}</td>
                                                <?php $cur = getActiveCurrency(); ?>
                                                <td>{{ $booking->total_fare }} {{ $cur['symbol'] }}</td>
                                                <td>{{ $booking->commission }} {{ $cur['symbol'] }}</td>
                                                <td>{!! $booking->transfer !!}</td>
                                                <td>{{ getUserTypesById($booking->who_booked) }}</td>
                                                <td>{!! $booking->reviews !!}</td>
                                                <td>{!! $booking->checked !!}</td>
                                                <td>{!! $booking->notes !!}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center">@lang('messages.keyword_no_bookings_found')</td>
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
            return confirm("{{trans('messages.keyword_are_you_sure_want_to_delete_booking')}}");
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
                    link.href = "{{ url('booking/delete') }}" + '/';
                    alert(link.href + (n));
                    if (check() && n != 0) {
                        //for(var i = 0; i < n; i++) {
                        $.ajax({
                            type: "GET",
                            url: link.href + indici[n - 1],
                            error: function (url) {
                                if (url.status == 403) {
                                    link.href = "{{ url('/booking/delete') }}" + '/' + indici[n];
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
                        link.href = "{{ url('booking/managedetail') }}" + '/' + indici[n];
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
		$('#booking_filtes_button').click(function(e) {
		$("#preloaderdiv").show();
	});


        function getNotesIdToModal(e)
        {
            var unique_booking_id = $(e).data('unique-id');
            $(".getDynamicBookingId").html(" {{ trans('messages.keyword_booking_id') }}: " + unique_booking_id);

            var booking_id = $(e).data('id');
            $("#booking_id").val(booking_id);
        }

        $('#notesModal').on('shown.bs.modal', function (e) {

            var booking_id = $("#booking_id").val();

            $.ajax({
                url: '{{ url('booking/getNotes') }}',
                method: 'POST',
                data : {"_token": "{{ csrf_token() }}",booking_id: booking_id},
                success: function(data){
                    $("#getNotes").html(data);
                }
            });

        });


        $('#get_notes_modal_form').on('submit', function(e) {
            e.preventDefault();



            var booking_id = $("#booking_id").val();
            var description = $("#description").val();


            if(description != '' &&  description.length <= 200)
            {
                $("#descriptionValidation").html("");
                $.ajax({
                    url: '{{ url('booking/submit/note') }}',
                    method: 'POST',
                    data : {"_token": "{{ csrf_token() }}", booking_id: booking_id, description: description},
                    success: function(data){
                        $("#getNotes").html(data);
                        $("#description").val('');
                    }
                });
            }else if (description.length > 200){
                $("#descriptionValidation").html("Please enter lower than 200 characters");
            }
            else{
                $("#descriptionValidation").html("Please enter note");
            };
        });
        $(document).ready(function () {
            $('#departure_date, #arrival_date, #end_date, #start_date').datepicker({
                format: "yyyy-mm-dd",
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
            }).datepicker();
        });
        $("#hotel_country").on("blur", function(){
            var location = $(this).val();
            if(location != '')
            {
                $.ajax({
                    url: '{{ url('booking/get/hotel_list') }}',
                    method: 'POST',
                    data : {"_token": "{{ csrf_token() }}", location: location},
                    success: function(data){
                        $("#getHotelList").html(data);
                    }
                });
            }
        });

    </script>

@endsection




<!-----------Notes Modal------------>
<div id="notesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            {{ Form::open(array('url' => 'booking/submit/note', 'method'=> 'post' , 'id' => 'get_notes_modal_form')) }}
            <div class="modal-header">
                <h4 class="modal-title" >@lang('messages.keyword_notes') <span class="getDynamicBookingId pull-right"></span></h4>

            </div>
            <div class="modal-body">
                <input type="hidden" name="booking_id" id="booking_id" value="">
                <div id="getNotes"></div>
                <hr>
                <textarea name="description" id="description" cols="30" rows="3" style="resize: vertical;" class="form-control"></textarea>
                <span class="required" id="descriptionValidation"></span>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">close</button>
                <button type="submit" class="btn btn-default" >Send</button>
            </div>
            {{ Form::close() }}
        </div>

    </div>
</div>
<!-----------Notes Modal------------>


<!-----------Review Modal------------>
<div id="reviewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('messages.keyword_reviews')</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-----------Review Modal------------>
