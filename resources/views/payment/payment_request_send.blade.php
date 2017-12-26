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
    
    
    <div class="manage-hotel-property-listing">
        
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm1-12 col-xs-12">
                    
                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">payment request</h1>
                            
                            
                            <div class="table-responsive">
                                
                                <table id="example" class="table table-striped table-bordered" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Reservation data</td>
                                        <td>Arrival</td>
                                        <td>Departure</td>
                                        <td>Guest</td>
                                        <td>Price</td>
                                        <td>Commission</td>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                    
                                    
                                        
                                        @if(count(getRequestedBookingAndPaymentDetail()) > 0)
                                            @foreach(getRequestedBookingAndPaymentDetail() as $booking)
                                                <tr>
                                                <td>113427577</td>
                                                <td>05.01.2017 16:01</td>
                                                <td>28.09.2017</td>
                                                <td>evanir yuri</td>
                                                <td>1638 €</td>
                                                <td>180 €</td>
                                                <td>
                                                    <div class="modify-payment-request-wrap">
                                                        <div class="modify-confirm-btn">
                                                            <a href="#" class="modify-payment-request">Modify</a>
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-default btn-6-12">Confirm</a>
                                                        </div>
                                                        <div class="modify-payment-request-form">
                                                            <div class="form-group">
                                                                <label>Commission</label>
                                                                <input type="text" class="form-control"
                                                                       value="154"/>
                                                                <span>€</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Change reason</label>
                                                                <input type="text" class="form-control"
                                                                       value="% is less no cure"/>
                                                            </div>
                                                            <button class="btn btn-default btn-6-12">confirm
                                                            </button>
                                                        </div>
                                                    </div>
                                                
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                
                                </table>
                            
                            
                            </div>
                        
                        
                        </div>
                    </div>
                
                </div>
            
            </div>
        </div>
    
    </div>


@endsection