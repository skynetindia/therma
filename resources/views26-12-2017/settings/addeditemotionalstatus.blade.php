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
       	<h1 class="user-profile-heading"><?php echo isset($taxation->id) ? 'Emotional Status Edit' : 'Emotional Status Add'; ?></h1><hr>
      </div>
    </div>
    <div class="setting-tab">
    <div class="row">
	   <div class="col-md-12 col-sm-12 col-xs-12">             		    	
      	<form action="{{url('/emotionalstatus/store')}}" id="taxation_form" method="post">
          {{ csrf_field() }}      
           <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
               <div class="form-group">
                  <label for="">Title <span class="required">(*)</span></label>
                  <input class="form-control" placeholder="Title" name="title" id="title" value="<?php if(isset($taxation->name)) echo $taxation->name;?>"type="text" required>                   
               </div>
             </div>             
         </div>
          	<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="form-group">
                  <ul class="nav nav-tabs">
                  <?php $selectecode = isset($language_selected->code) ? $language_selected->code : 'en';?>
                  @foreach ($language as $key => $val)
                  <li class="<?php echo ($val->code==$selectecode)?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
                  @endforeach
                  <!--<li class="active"><a data-toggle="tab" href="#en" aria-expanded="true">English</a></li>-->
                  </ul><br>
                <div class="tab-content"> 
                @foreach ($language as $key => $val)
                <?php 
                $phase_data = array();                  
                if(isset($taxation->language_key) && $taxation->language_key != "") {
                  $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$taxation->language_key)->first();
                }
                ?><div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code==$selectecode)?'in active':'';?>">
                  <div class="row">
                    <div class="col-sm-6">
                      <label> Emotional Status <span class="required">*</span> </label>
                      <textarea class="form-control" rows="5" cols="5" name="<?php echo $val->code.'_keyword_name';?>" id="<?php echo $val->code.'_keyword_name';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
                    </div>
                  </div>
                </div>
                @endforeach 
                </div>
              </div>                  
                 </div>               
                 <input type="hidden" name="language_key" value="{{(isset($taxation->language_key) && $taxation->language_key != "") ? $taxation->language_key : ''}}">
             </div>                                
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="text-right">
                    <input type="hidden" name="status_id" value="{{ isset($taxation->id) ? $taxation->id : "" }}">
                    <input class="btn btn-default btn-6-12" type="submit" value="{{isset($taxation->id) ? trans('messages.keyword_modify') : trans('messages.keyword_save')}}">
                    <a href="{{url('/emotionalstatus/')}}" class="btn btn-reject btn-cancel">{{trans('messages.keyword_cancel')}}</a>
                  </div>
              </div>                     
				</form>
    </div>
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
              title: {
                  required: true,
                  maxlength: 35
              }
          },
          messages: {
            title: {
              required: "{{trans('messages.keyword_please_enter_a_title')}}",
              maxlength: "{{trans('messages.keyword_please_enter_less_than_35_charters')}}"
            }
          }
        });
      });
  </script>
@endsection