@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')


        <div class="booking-wrap booking-detail">


            <div class="row">

                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="section-border">
                        <p class="bold blue-head">Booking events</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date and time</th>
                                    <th>Action type</th>
                                    <th>Parameters</th>
                                    <th>IP address</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>21.07.2017 10:56</td>
                                    <td>Reservation</td>
                                    <td></td>
                                    <td><a href="#">89.237.98.2</a></td>
                                </tr>
                                <tr>
                                    <td>21.07.2017 12:33</td>
                                    <td>Confirmation</td>
                                    <td>Belorusija</td>
                                    <td><a href="#">81.198.66.152</a></td>
                                </tr>
                                <tr>
                                    <td>27.07.2017 14:19</td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="#">172.98.87.207</a></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="section-border">
                        <p class="bold blue-head">hotel Belorusija</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <th>Arrival</th>
                                    <td>11.09.2017</td>
                                </tr>
                                <tr>
                                    <th>Departure</th>
                                    <td>18.09.2017</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>624 €</td>
                                </tr>
                                <tr>
                                    <th>Commission</th>
                                    <td>50 €</td>
                                </tr>
                                <tr>
                                    <th>Closed</th>
                                    <td>no</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="section-border">
                        <p class="bold blue-head">1st room - Double room "plus"</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Guest</th>
                                    <th>Bed</th>
                                    <th>Services</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>ИЦИК ЭЛИЯГУ</td>
                                    <td>Standard</td>
                                    <td>3x meal</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            <li>Procedures: 28</li>
                                            <li>Examination: 2</li>
                                            <li>Drinking cure</li>
                                            <li>Entry into term. Swimming pool</li>
                                        </ul>
                                    </td>
                                    <td>312 €</td>
                                </tr>
                                <tr>
                                    <td>OLEG GORELIK</td>
                                    <td>Standard</td>
                                    <td>3x meal</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            <li>Procedures: 28</li>
                                            <li>Examination: 2</li>
                                            <li>Drinking cure</li>
                                            <li>Entry into term. Swimming pool</li>
                                        </ul>
                                    </td>
                                    <td>312 €</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>624 €</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>


                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="section-border">
                        <p class="bold blue-head">Basic information</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <th>Reservation number</th>
                                    <td>174731837</td>
                                </tr>
                                <tr>
                                    <th>Client</th>
                                    <td>demo</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>Israel</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>(+972) 54778274</td>
                                </tr>
                                <tr>
                                    <th>E-mail</th>
                                    <td><a href="mailto:demo@gmail.com">demo@gmail.com</a></td>
                                </tr>
                                <tr>
                                    <th>New email</th>
                                    <td>
                                        <div class="form-group booking-email">
                                            <input type="email" required class="form-control"
                                                   placeholder="Enter Email">
                                            <button class="btn btn-default btn-6-12">set up</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Client Currency</th>
                                    <td>€</td>
                                </tr>

                                <tr>
                                    <th>Client language</th>
                                    <td>RU</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>


@endsection