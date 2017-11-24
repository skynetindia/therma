@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')

    {{ pre($booking) }}

    <div class="booking-wrap reservations-id">


            <div class="row">

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="section-border">


                        <div class="reservation-data">
                            <p class="bold blue-head">@lang('messages.keyword_reservation_data')</p>


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td>@lang('messages.keyword_client')</td>
                                        <td>{{ isset($booking->client_name) ? $booking->client_name : '--' }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.keyword_country')</td>
                                        <td>{{ isset($booking->country) ? $booking->country : '--' }} <img src="images/flag2.png"/></td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.keyword_phone')</td>
                                        <td>{{ isset($booking->phone) ? $booking->phone : '--' }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.keyword_email')</td>
                                        <td>{{ isset($booking->email) ? $booking->email : '--' }}</td>
                                    </tr>
                                </table>
                            </div>


                            <div class="client-note">
                                <p class="client-note-heading">client note</p>
                                <p class="clinet-description">Lorem Ipsum is simply dummy text of the printing
                                    and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley of type and
                                    scrambled it to make a type specimen book. </p>
                            </div>

                        </div>

                    </div>

                    <div class="section-border">
                        <div class="reservation-data">
                            <p class="bold blue-head">ID transfer</p>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td>ID 4241244214</td>
                                        <td>View</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="section-border">
                        <div class="resend-confirm-email">
                            <p class="bold blue-head">Resend Confirmation Again</p>


                            <form class="form-horizontal" action="/action_page.php">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-12 col-xs-12"
                                           for="email">Email:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <input type="email" class="form-control" id="email"
                                               placeholder="Enter email" name="email">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <button class="btn btn-default">send</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>


                    <div class="section-border">
                        <div class="policies-reservation-id">
                            <p class="bold blue-head">Policies</p>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Cancelliation</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Prepayment</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Internet</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Children and extra bad policy</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Parking</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pets</th>
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="col-md-8 col-sm-12 col-xs-12">

                    <div class="section-border">
                        <div class="history">
                            <p class="bold blue-head">History</p>


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client Status</th>
                                        <th>Hotel Status</th>
                                        <th>Who</th>
                                        <th>IP Address</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>02/10/2015 hi2.35'12"</td>
                                        <td>Booked</td>
                                        <td></td>
                                        <td>Client</td>
                                        <td>195.124.481</td>
                                    </tr>

                                    <tr>
                                        <td>03/10/2015 hi2.35'12"</td>
                                        <td></td>
                                        <td>Waiting</td>
                                        <td>Hotel</td>
                                        <td>198.144.481</td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                    <div class="section-border">
                        <div class="spa-hotel">
                            <p class="bold blue-head">Spa Hotel Terme All'Alba</p>


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">


                                    <tbody>
                                    <tr>
                                        <td>Check in</td>
                                        <td>23.10.2017</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>Check Out</td>
                                        <td>23.10.2017</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>Amount Room</td>
                                        <td>1000,00€</td>
                                        <td>Commission Room</td>
                                        <td>100,00€ (10%)</td>
                                    </tr>

                                    <tr>
                                        <td>Amount Extra</td>
                                        <td>500,00€</td>
                                        <td>Commission Room</td>
                                        <td>25,00€ (5%)</td>
                                    </tr>

                                    <tr>
                                        <td>Amount Total</td>
                                        <td>1500,00€</td>
                                        <td>Commission Total</td>
                                        <td>125,00€ (10%)</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                    <div class="section-border">
                        <div class="information-extra">
                            <p class="bold blue-head">Information about Extra</p>


                            <div class="table-responsive">

                            </div>

                        </div>
                    </div>


                    <div class="section-border">
                        <div class="information-extra">
                            <p class="bold blue-head">Booking Information</p>


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">

                                    <thead>
                                    <tr>
                                        <td>1 Room</td>
                                        <td>Client/Age</td>
                                        <td>Bed</td>
                                        <td>Meals</td>
                                        <td>Price Room</td>
                                        <td>Extra</td>
                                        <td>Extra Price</td>
                                        <td>Total Price</td>
                                    </tr>
                                    </thead>

                                    <tbody>


                                    <tr>
                                        <td rowspan="2">Double Superior</td>
                                        <td>Name1/32</td>
                                        <td>Standard</td>
                                        <td>Full Board</td>
                                        <td>750.00€</td>
                                        <td>Pack 1</td>
                                        <td>200,00€</td>
                                        <td>950,00€</td>
                                    </tr>

                                    <tr>
                                        <td>Name2/32</td>
                                        <td>Standard</td>
                                        <td>Half Board</td>
                                        <td>250.00€</td>
                                        <td>Pack 2</td>
                                        <td>300,00€</td>
                                        <td>550,00€</td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" class="text-right">1500,00€</td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>


                    <div class="section-border">
                        <div class="conversation-guest-wrap">
                            <p class="bold blue-head">Conversation with guest</p>


                            <div class="conversation-min-height-scroll">
                                <div class="conversation-guest-blk">
                                    <div class="send chat-blk">
                                        <p class="text-right">26 sep,2017 16:37:40</p>
                                        <div class="chat-txt">
                                            <p>Dear Mrs. Fehr, <br/> Lorem Ipsum is simply dummy text of the
                                                printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500s,</p>
                                        </div>
                                    </div>


                                    <div class="receive chat-blk">

                                        <p class="text-left">26 sep,2017 18:32:21</p>
                                        <div class="chat-txt">
                                            <p>Dear Mrs. Fehr, <br/> Lorem Ipsum is simply dummy text of the
                                                printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500s,</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="conversation-guest-text">
                                <textarea class="form-control"></textarea>
                                <button class="btn btn-default btn-6-12">Send a new message</button>
                            </div>

                        </div>

                    </div>


                </div>


            </div>
        </div>


@endsection