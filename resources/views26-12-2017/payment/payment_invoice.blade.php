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
    @php $cur = getActiveCurrency(); @endphp
    @php $commission_paid = $invoice->commission; @endphp
   
    
    
    
    
    <div class="payment-invoice">
        
        <div class="section-border">
            <div class="row">
                
                <div class="col-md-12 col-sm-12 col-xs-12"><h1 class="cst-datatable-heading">@lang('messages.keyword_invoicing_details')</h1></div>
                
                <div class="col-md-4 col-sm1-12 col-xs-12">
                    
                    <div class="data-table">
                        <div class="table-responsive">
                            
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    @lang('messages.keyword_basic_information')
                                </div>
                                
                                
                                <div class="panel-body">
                                    
                                    <div class="basic-information">
                                        
                                        <div class="detail">
                                            <p class="heading-payment-invoice">@lang('messages.keyword_subscriber')</p>
                                            <p class="description">
                                                {{ $hotel->name }} <br/>
                                                {{ $hotel->address }} <br/>
                                            </p>
                                        </div>
                                        
                                        <div class="detail">
                                            
                                            <p class="description">
                                                @lang('messages.keyword_company') @lang('messages.keyword_id') : <span>{{ (!empty($hotel->contract_number)) ? $hotel->contract_number : '' }} </span><br>
                                                @lang('messages.keyword_vat_number') : <span>{{ (!empty($hotel->vat_number)) ? $hotel->vat_number : '' }} </span>
                                            </p>
                                        </div>
                                        
                                        
                                        <div class="detail">
                                            <p class="heading-payment-invoice">@lang('messages.keyword_invoice_parameters')</p>
                                            <p class="description">
                                                <b>VS : {{$invoice->invoiceid}}</b><br>
                                                <b>@lang('messages.keyword_amount') : {{ number_format($commission_paid, 2) }} {{ $cur['symbol'] }}</b>
                                            </p>
                                        </div>
                                        
                                        <div class="detail">
                                            
                                            <p class="description">
                                                @lang('messages.keyword_issued') : <b>{{date('d/m/Y',strtotime($invoice->issued_dt))}}</b><br/>
                                                @lang('messages.keyword_maturity') : <b>{{date('d/m/Y',strtotime($invoice->due_dt ))}}</b> <br/>
                                                @lang('messages.keyword_duzp') : <b>{{date('t/m/Y',strtotime($invoice->vat_dt ))}}</b> <br/>
                                            </p>
                                        </div>
                                    
                                    
                                    </div>
                                
                                </div>
                            </div>
                        
                        
                        </div>
                    </div>
                
                </div>
                
                
                <div class="col-md-4 col-sm1-12 col-xs-12">
                    
                    <div class="data-table">
                        <div class="table-responsive">
                            
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    @lang('messages.keyword_reservation')
                                </div>
                                
                                
                                <div class="panel-body">
                                    
                                    <div class="basic-information">
                                        
                                        <div class="detail">
                                            <ul class="list-unstyled">
                                                @foreach($booking_invoice_ids as $booking_id)
                                                    <li><a href="{{ url('booking/detail')."/".$booking_id }}">{{ getTempBookingId($booking_id) }}</a></li>
                                                @endforeach
                                            </ul>
                                            <p><b>@lang('messages.keyword_total') @lang('messages.keyword_commission'): <span>{{ number_format($commission_paid, 2) }} {{ $cur['symbol'] }}</span></b></p>
                                        </div>
                                    
                                    
                                    </div>
                                
                                </div>
                            </div>
                        
                        
                        </div>
                    </div>
                
                </div>
                
                
                <div class="col-md-4 col-sm1-12 col-xs-12">
                    
                    <div class="data-table">
                        <div class="table-responsive">
                            
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    @lang('messages.keyword_actions')
                                </div>
                                
                                
                                <div class="panel-body">
                                    
                                    <div class="basic-information">
                                        
                                        <div class="action-description">
                                            <button class="btn btn-default btn-6-12">@lang('messages.keyword_waiting_for_invoice')</button>
                                            <hr/>
                                            <p class="heading-payment-invoice">@lang('messages.keyword_download_the_invoice')</p>
                                            <div class="btn-pdf">
                                                <a class="btn btn-info btn-6-12" href="{{url('payment/invoice/pdf/'.$invoice->id)}}">@lang('messages.keyword_download_pdf_invoice')</a>
                                                <button class="btn btn-info btn-6-12">@lang('messages.keyword_download_pdf_invoice') -- @lang('messages.keyword_operator_language')
                                                </button>
                                            </div>
                                            <hr/>
                                            <div class="form-group">
                                                <label>@lang('messages.keyword_send_an_invoice')</label>
                                                <input type="text" class="form-control"/>
                                                <button class="btn btn-info btn-6-12">@lang('messages.keyword_send_by_email')</button>
                                            </div>
                                            <hr/>
    
                                            {{ Form::open(array('url' => 'payment/invoice/save/note', 'files' => true, 'id' => 'payment_save_note_form', 'method'=> 'post')) }}
                                            <input type="hidden" name="hotel_id" value="{{ $invoice->hotel_id }}">
                                            <div class="form-group">
                                                <label>@lang('messages.keyword_comment')</label>
                                                <textarea class="form-control" style="resize: vertical" name="note">{{ (isset($invoice->note)) ? $invoice->note : '' }}</textarea>
                                            </div>
                                            
                                            <button class="btn btn-default btn-6-12">{{ (isset($invoice->note) && !empty($invoice->note)) ? trans('messages.keyword_update') : trans('messages.keyword_save') }} @lang('messages.keyword_note')</button>
                                            {{ Form::close() }}
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

@endsection