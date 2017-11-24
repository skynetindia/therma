@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="ssetting-wrap">
  <div class="section-border">                 
		<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
       	<h1 class="user-profile-heading"><?php echo isset($taxation->id) ? trans('messages.keyword_currency_edit') : trans('messages.keyword_currency_add') ?></h1><hr>
      </div>
    </div>
    <div class="row">
	   <div class="col-md-12 col-sm-12 col-xs-12">             		    	
      	<form action="{{url('/currency/store')}}" id="taxation_form" method="post">
          {{ csrf_field() }}      
          	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                   <div class="form-group">
                      <label for="">{{trans('messages.keyword_name')}} <span class="required">(*)</span></label>
                      <input class="form-control" placeholder="{{trans('messages.keyword_name')}}" id="name" name="name" value="{{ isset($taxation->name) ? $taxation->name : "" }}" type="text" required>
                   </div>
                 </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                 <div class="form-group">
                    <label for="">{{trans('messages.keyword_symbol')}} <span class="required">(*)</span></label>
                    <input class="form-control" placeholder="{{trans('messages.keyword_symbol')}}"  maxlength="4" name="symbol" id="symbol" value="{{ isset($taxation->symbol) ? $taxation->symbol : "" }}" type="text" required>
                 </div>
               </div>
             </div>                   
              <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <div class="form-group">
                        <label for="">{{trans('messages.keyword_code')}}</label>
                        <input class="form-control" placeholder="{{trans('messages.keyword_code')}}" maxlength="4" name="code" id="code" value="{{ isset($taxation->code) ? $taxation->code : "" }}"type="text" required>
                     </div>
                   </div>                                         
               </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="text-right">
                    <input type="hidden" name="curreny_id" value="{{ isset($taxation->id) ? $taxation->id : "" }}">
                    <input class="btn btn-default btn-6-12" type="submit" value="{{isset($taxation->id) ? trans('messages.keyword_modify') : trans('messages.keyword_add')}}">
                    <a href="{{url('/currency/')}}" class="btn btn-reject btn-cancel">{{trans('messages.keyword_cancel')}}</a>
                  </div>
              </div>                     
				</form>
    </div>
  </div>      
</div>
</div>   
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script> 
<script type="text/javascript">
  $(document).ready(function() {
     // validate taxation form on keyup and submit
        $("#taxation_form").validate({
          rules: {
              name: {
                  required: true,
                  maxlength: 35
              },
              symbol: {
                  required: true
              },
    				code:{
    					required: true
    				}
          },
          messages: {
            name: {
              required: "{{trans('messages.keyword_please_enter_a_name')}}",
              maxlength: "{{trans('messages.keyword_please_enter_less_than_35_charters')}}"
            },
            symbol: {
              required: "{{trans('messages.keyword_please_enter_symbol')}}"                  
            },
				    code:{
					   required: "{{trans('messages.keyword_please_enter_code')}}"                  
				    }
          }
        });
      });
  </script>
@endsection