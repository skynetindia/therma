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
                            	<h1 class="user-profile-heading"><?php echo (isset($language) && !empty($language)) ? 'Language Edit' : 'Language Add';?></h1><hr>
                            </div>
                        </div>
                 
                 
                 <div class="row">
                 	<div class="col-md-12 col-sm-12 col-xs-12">
             		    	
                            	  <?php 
  if(isset($language) && !empty($language)){
  	echo Form::open(array('url' => '/update/language' . "/$language->id", 'files' => true, 'id' => 'frmLanguage'));
  }
  else {
   	echo Form::open(array('url' => '/update/language', 'files' => true, 'id' => 'frmLanguage'));
  }
   ?>
    {{ csrf_field() }}

                                	<div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                           <div class="form-group">
                                               <input type="hidden" name="language_id" value="{{ isset($language->id) ? $language->id : '' }}">
                                              <label for="">Name <span class="required">(*)</span></label>
                                              <input class="form-control" id="name" name="name" placeholder="Name" maxlength="50" value="{{ isset($language->name) ? $language->name : old('name') }}" type="text" required>
                                           </div>
                                         </div>
                                         <div class="col-md-6 col-sm-12 col-xs-12">
                                           <div class="form-group">
                                              <label for="">code <span class="required">(*)</span></label>
                                              <input class="form-control" value="{{ isset($language->code) ? $language->code : old('code') }}"  maxlength="3" name="code" id="code" type="text" required>
                                           </div>
                                         </div>
                                     </div>
                                     
                                     <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                           <div class="form-group">
                                              <label for="">Original Name</label>
                                              <input class="form-control" name="original_name" id="original_name" placeholder="Original Name" value="{{isset($language->original_name) ? $language->original_name : old('original_name')}}" maxlength="50" type="text" required>
                                           </div>
                                         </div>
                                         <div class="col-md-6 col-sm-12 col-xs-12">
                                           <div class="form-group form-control-file">
                                              <label for="icon">Icon</label>
                                              <?php echo Form::file('icon', ['class' => '']); ?>
                                           </div>
                                         </div>
                                     </div>
                                       
                                       
                                       <div class="row">
                                       	<div class="col-md-12 col-sm-12 col-xs-12">
                                        	<div class="ryt-chk">
												<input  type="checkbox" name="is_default" id="is_default" value="1" <?php if(isset($language->is_default) && $language->is_default == '1'){ echo 'checked';} ?>>
		            	                        <label for="is_default">is Default?</label></div>
                                        </div>
                                       </div>                                       
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                           <div class="text-right">
                                           	<button type="submit" class="btn btn-default btn-6-12">Save</button>
    										{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-reject btn-cancel']) !!}    
                                           </div>
                                </div>
                                       
    <?php echo Form::close(); ?>  
                      </div>
                      </div>      
             </div>
                 
                 
              </div>   
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script> 
<script type="text/javascript">  
    $(document).ready(function() {

        // validate signup form on keyup and submit
        $("#frmLanguage").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                original_name:{
                   required: true,
                   maxlength: 50
                },
                code: {
                   required: true,
					         minlength : 2,
                   maxlength: 3
                }
            },
            messages: {
                name: {
                    required: "Please enter a language name",
                    maxlength: "Language Name must be less than 50 characters"
                },
                original_name:{
                   required: "Please enter a origianal name",
                   maxlength: "Original Name must be less than 50 characters"
                },
                code: {
                   required: "Please enter a code",
					         minlength : "Code must 2 characters long",
                   maxlength: "Code must 3 characters long"
                }
            }
        });
        $.validator.setDefaults({
        	ignore: []
    	});
   });

</script>

@endsection	