@extends('layouts.app')
@section('content')
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<style>
.ui-autocomplete {
z-index: 100;
}
</style>
<div class="ssetting-wrap">
  <div class="section-border">                 
   	<div class="row">
     	<div class="col-md-12 col-sm-12 col-xs-12">
       	<h1 class="user-profile-heading"><?php echo (isset($language_transalation->language_key) ) ? 'Edit language translate' : 'Add language translate'; ?></h1><hr>
      </div>
    </div>   
    <div class="setting-tab">
    <div class="row">
   	  <div class="col-md-12 col-sm-12 col-xs-12"><?php 
      if(isset($language_transalation->language_key)){
      	echo Form::open(array('url' => '/language/translation/update/' . $language_transalation->language_key, 'files' => true,'id'=>'frmModificaente')); 
      }
      else {
      	echo Form::open(array('url' => '/language/translation/store/', 'files' => true,'id'=>'frmModificaente'));
      }
      ?>
      {{ csrf_field() }} 
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
         <div class="form-group">
            <label for="">Keyword Title <span class="required">(*)</span></label>
            <input class="form-control" placeholder="Keyword Title" name="keyword_title" id="keyword_title" value="<?php if(isset($language_transalation->language_label)) echo $language_transalation->language_label;?>"type="text" required>
             <input type="hidden" name="hdSaveType" id="hdSaveType" value="0"> 
            <input type="hidden" name="nextrecordid" value="{{isset($NextRecord[0]->id) ? $NextRecord[0]->id : '' }}">
            <input type="hidden" name="previouserecordid" value="{{isset($PreviouseRecord[0]->id) ? $PreviouseRecord[0]->id : '' }}">
         </div>
       </div>
       <div class="col-md-6 col-sm-12 col-xs-12">
         <div class="form-group auto-search-innr">
            <label for="">Search</label>
            <input class="form-control bg-arrow" id="txtsearchpharse" placeholder="Search" type="text" >
         </div>
       </div>
   </div>
                                     
  <div class="row">               
    <div class="col-sm-12">
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
                      if(isset($language_transalation->language_key) && $language_transalation->language_key != ""){
      $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$language_transalation->language_key)->first();
                      }
      ?><div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code==$selectecode)?'in active':'';?>">
        <div class="row">
          <div class="col-sm-12">
            <label> Language Phrases <span class="required">*</span> </label>
            <textarea class="form-control" rows="10"  name="<?php echo $val->code.'_keyword_desc';?>" id="<?php echo $val->code.'_keyword_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
          </div>
        </div>
      </div>
      @endforeach 
      </div>
    </div>
  </div>
</div>                               
                                       
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="text-right">
     	<!--<button type="submit" class="btn btn-default btn-6-12">Submit</button>
      <button class="btn btn-reject btn-cancel">cancel</button>-->
      @if(isset($language_transalation->language_key) && isset($PreviouseRecord[0]->id))
        <button id="btnSubmitPreviouse" type="submit" class="btn btn-default btn-6-12">Save & Previous</button>  
        @endif
        <button  id="btnSubmitEnti" type="submit" class="btn btn-default btn-6-12">Save</button>
        @if(isset($language_transalation->language_key) && isset($NextRecord[0]->id))
        <button id="btnSubmitNext" type="submit" class="btn btn-primary">Save & Next</button>  
        @endif
        @if(isset($language_selected->id))
        <a href="{{url('/language/translation/').'/'.$language_selected->id}}" class="btn btn-reject btn-cancel">Cancel</a>
        @endif
    </div>
 </div>
</div>                                       
<?php echo Form::close(); ?>   
      </div>
    </div>      
  </div>
</div>          
</div>  
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>  
<script>
$('#btnSubmitNext').on("click", function() {
  $("#hdSaveType").val('1');//Next
});
$('#btnSubmitPreviouse').on("click", function() {
  $("#hdSaveType").val('2');//Previouse
});
$(document).ready(function() {
        // validate signup form on keyup and submit
        $("#frmModificaente").validate({
            rules: {
                keyword_title: {
                    required: true,
                    maxlength: 100
                }
            },
            messages: {
                keyword_title: {
                    required: "Please enter a label",
                    maxlength: "Label must be less than 50 characters"
                }
            }
        });
	  });
	//var $j = jQuery.noConflict();
  $( function() {
    $("#txtsearchpharse").autocomplete({
      source: function( request, response ) {
		var searcval = $("#txtsearchpharse").val();
        $.ajax( {
          url: "{{url('language/searchtranslation/')}}",
          dataType: "json",
          type: 'get',
          data: { "term": searcval },
          success:function(data){                               
               $('#preview_content').html(data);
			   response(data);
          }
        } );
      },
	  appendTo: $(".auto-search-innr"),
      minLength: 2,
      select: function( event, ui ) {
        var id = ui.item.id;
        var url = '{{url('language/modify/translation')}}';        
        window.location.href= url+'/'+id;        
      }
    } );
  } );
</script>
@endsection	