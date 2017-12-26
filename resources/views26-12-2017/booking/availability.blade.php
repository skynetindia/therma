@extends('layouts.app')
@section('content')

    <!----calendar----->
    <link href="{{ asset('public/css/fullcalendar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/fullcalendar.print.min.css') }}" rel="stylesheet" media="print" />
    <script src="{{ asset('public/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/js/fullcalendar.min.js') }}"></script>
    <!---------------->

    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')

    <div class="calendar-wrap availibility-wrap">
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>


        <div class="booking-calendar">
            <div class="booking-head">
                <div class="booking-id">booking id:524587</div>
                <div class="booking-name">Mr. Daniela Spada</div>
            </div>
            <div class="section-border">
                <div class="row">

                    <div class="col-md-3 col-sm-12 col-xs-12 border-ryt-gry">
                        <div class="booking-info">
                            <div class="gry-clr">Arrival:</div>
                            <div class="book-info">Fri, 15 sep 2017</div>
                        </div>
                        <div class="booking-info">
                            <div class="gry-clr">departure:</div>
                            <div class="book-info">sat, 16 sep 2017</div>
                        </div>
                        <div class="booking-info">
                            <div class="gry-clr">total guests:</div>
                            <div class="book-info">8 adults</div>
                        </div>
                        <div class="booking-info">
                            <div class="gry-clr">total rooms:</div>
                            <div class="book-info">3</div>
                        </div>
                        <div class="booking-info">
                            <div class="gry-clr">total price:</div>
                            <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i> 530</div>
                        </div>
                        <div class="booking-info">
                            <div class="gry-clr">payment status:</div>
                            <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i> the guest
                                has paid online
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="booking-info">
                                    <div class="gry-clr">guest preferred language:</div>
                                    <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i>
                                        Italian
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <button class="btn btn-default">modify booking</button>
                                <button class="btn btn-default">go to ticket</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="booking-info">
                                    <div class="gry-clr">booking reference number:</div>
                                    <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i>
                                        1297575523
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="booking-info">
                                    <div class="gry-clr">commissionable amount:</div>
                                    <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i> 530
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="booking-info">
                                    <div class="gry-clr">received:</div>
                                    <div class="book-info">Sun, 02 jul 2017</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="booking-info">
                                    <div class="gry-clr">commission:</div>
                                    <div class="book-info"><i class="fa fa-eur" aria-hidden="true"></i>
                                        79.50
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="gry-clr">commission:</div>
                                <div class="txtbox">
                                                <textarea class="form-control"
                                                          placeholder="Enter Commission"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="height40"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="booking-collapse">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-group" id="accordion" role="tablist"
                                         aria-multiselectable="true">


                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       data-parent="#accordion" href="#collapseOne"
                                                       aria-expanded="true" aria-controls="collapseOne"
                                                       class="">
                                                        <div class="float-left">
                                                            <div><label class="bold">Room 1</label> - Deluxe
                                                                Double Room (Silenzio)
                                                            </div>
                                                            <div><span><i class="fa fa-sign-in"
                                                                          aria-hidden="true"></i> 15 Sept 2017</span>
                                                                <span><i class="fa fa-sign-out"
                                                                         aria-hidden="true"></i> 16 Sept 2017</span>
                                                            </div>
                                                        </div>
                                                        <div class="float-right">
                                                            <div class="price"><i class="fa fa-eur"
                                                                                  aria-hidden="true"></i>
                                                                153
                                                            </div>
                                                            <div><span class="show1">see Details</span><span
                                                                        class="hide1">Hide Details</span><i
                                                                        class="more-less fa fa-chevron-up"
                                                                        aria-hidden="true"></i></div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in"
                                                 role="tabpanel" aria-labelledby="headingOne"
                                                 aria-expanded="true" style="">
                                                <div class="panel-body">

                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                                            <div class="booking-info">
                                                                <div class="gry-clr">Guest name:</div>
                                                                <div class="book-info">daniela spda</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">max occupancy:</div>
                                                                <div class="book-info">2 guests</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">meal options:</div>
                                                                <div class="book-info">breakfast is included
                                                                    in the room rae.
                                                                </div>
                                                            </div>

                                                            <div class="img-room"><img
                                                                        src="images/room-img.jpg"
                                                                        class="img-responsive"></div>

                                                        </div>

                                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Rate</th>
                                                                    <th>Price per night</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>15-16 Sep</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">Subtotal</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </th>
                                                                </tr>


                                                                <tr>
                                                                    <td>City Tax</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 1.50 per
                                                                        person per night
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 3.00
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">total room price</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 153
                                                                    </th>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                            <p class="booking-vat">rate included 10% VAT</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button"
                                                       data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseTwo" aria-expanded="false"
                                                       aria-controls="collapseTwo">
                                                        <div class="float-left">
                                                            <div><label class="bold">Room 2</label> - Double
                                                                Room (Silenzio)
                                                            </div>
                                                            <div><span><i class="fa fa-sign-in"
                                                                          aria-hidden="true"></i> 15 Sept 2017</span>
                                                                <span><i class="fa fa-sign-out"
                                                                         aria-hidden="true"></i> 16 Sept 2017</span>
                                                            </div>
                                                        </div>
                                                        <div class="float-right">
                                                            <div class="price"><i class="fa fa-eur"
                                                                                  aria-hidden="true"></i>
                                                                204.50
                                                            </div>
                                                            <div><span class="show1">see Details</span><span
                                                                        class="hide1">Hide Details</span><i
                                                                        class="more-less fa-chevron-down fa"
                                                                        aria-hidden="true"></i></div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse"
                                                 role="tabpanel" aria-labelledby="headingTwo"
                                                 aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                                            <div class="booking-info">
                                                                <div class="gry-clr">Guest name:</div>
                                                                <div class="book-info">daniela spda</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">max occupancy:</div>
                                                                <div class="book-info">2 guests</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">meal options:</div>
                                                                <div class="book-info">breakfast is included
                                                                    in the room rae.
                                                                </div>
                                                            </div>

                                                            <div class="img-room"><img
                                                                        src="images/room-img.jpg"
                                                                        class="img-responsive"></div>

                                                        </div>

                                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Rate</th>
                                                                    <th>Price per night</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>15-16 Sep</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">Subtotal</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </th>
                                                                </tr>


                                                                <tr>
                                                                    <td>City Tax</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 1.50 per
                                                                        person per night
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 3.00
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">total room price</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 153
                                                                    </th>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                            <p class="booking-vat">rate included 10% VAT</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button"
                                                       data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseThree" aria-expanded="false"
                                                       aria-controls="collapseThree">
                                                        <div class="float-left">
                                                            <div><label class="bold">Room 3</label> - Double
                                                                Room (Silenzio)
                                                            </div>
                                                            <div><span><i class="fa fa-sign-in"
                                                                          aria-hidden="true"></i> 15 Sept 2017</span>
                                                                <span><i class="fa fa-sign-out"
                                                                         aria-hidden="true"></i> 16 Sept 2017</span>
                                                            </div>
                                                        </div>
                                                        <div class="float-right">
                                                            <div class="price"><i class="fa fa-eur"
                                                                                  aria-hidden="true"></i>
                                                                184.50
                                                            </div>
                                                            <div><span class="show1">see Details</span><span
                                                                        class="hide1">Hide Details</span><i
                                                                        class="more-less fa-chevron-down fa"
                                                                        aria-hidden="true"></i></div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse"
                                                 role="tabpanel" aria-labelledby="headingThree"
                                                 aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                                            <div class="booking-info">
                                                                <div class="gry-clr">Guest name:</div>
                                                                <div class="book-info">daniela spda</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">max occupancy:</div>
                                                                <div class="book-info">2 guests</div>
                                                            </div>
                                                            <div class="booking-info">
                                                                <div class="gry-clr">meal options:</div>
                                                                <div class="book-info">breakfast is included
                                                                    in the room rae.
                                                                </div>
                                                            </div>

                                                            <div class="img-room"><img
                                                                        src="images/room-img.jpg"
                                                                        class="img-responsive"></div>

                                                        </div>

                                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Rate</th>
                                                                    <th>Price per night</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>15-16 Sep</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">Subtotal</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 150
                                                                    </th>
                                                                </tr>


                                                                <tr>
                                                                    <td>City Tax</td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 1.50 per
                                                                        person per night
                                                                    </td>
                                                                    <td><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 3.00
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="2">total room price</th>
                                                                    <th><i class="fa fa-eur"
                                                                           aria-hidden="true"></i> 153
                                                                    </th>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                            <p class="booking-vat">rate included 10% VAT</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

    <script>

        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '2017-05-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    {
                        title: 'All Day Event',
                        start: '2017-05-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2017-05-07',
                        end: '2017-05-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2017-05-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2017-05-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2017-05-11',
                        end: '2017-05-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2017-05-12T10:30:00',
                        end: '2017-05-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2017-05-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2017-05-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2017-05-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2017-05-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2017-05-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2017-05-28'
                    }
                ]
            });

        });

    </script>

@endsection