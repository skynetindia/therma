@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

    <?php if(isset($page->page_id)){ echo Form::open(array('url' => '/admin/page/update/' . $page->page_id, 'files' => true, 'id'=>'page_edit_form')); } else { echo Form::open(array('url' => '/admin/page/store/', 'files' => true,'id'=>'page_add_form')); } ?>

        <input type="hidden" name="template_id" value="{{isset($template->id) ? $template->id : '' }}">
        <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

        <div class="package-add-wrap">
            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1 class="user-profile-heading">@lang('messages.keyword_email_template') @if($action == 'add') @lang('messages.keyword_add') @else @lang('messages.keyword_update')  @endif</h1>
                        <hr/>
                    </div>
                </div>

                 <div class="row">
      <div class="col-lg-10">
					<div class="form-wrap">
            	<div class="col-sm-6">
                  <div class="form-group">
                    <label><font color="#FF0000">*</font> {{trans('messages.keyword_page_title')}} </label>
                    <input type="text" class="form-control" name="page_title" id="page_title" value="<?php if(isset($page->page_title)) echo $page->page_title;?>">
									</div>
              </div>	

              

          <div class="col-sm-12">
              <div class="form-group"><?php ?>
              <ul class="nav nav-tabs">
                  @foreach ($language as $key => $val)
                   <li class="<?php echo ($val->code=='en')?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
                  @endforeach
              </ul><br>

              <div class="tab-content">
              @foreach ($language as $key => $val)
              <?php $phase_data = array(); 
              if(isset($language_transalation->language_key) && $language_transalation->language_key != ""){                      $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$language_transalation->language_key)->first(); } ?>

            <div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code=='en')?'in active':'';?>">

              <div class="col-sm-12">
                <label><font color="#FF0000"></font> {{trans('messages.keyword_page_description')}} </label>
                <textarea class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_page_desc';?>" id="<?php echo $val->code.'_page_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
              </div>
              <script type="text/javascript" >
                CKEDITOR.replace( '<?php echo $val->code.'_page_desc';?>' );
              </script>  
				<div class="col-sm-6">
                <label><font color="#FF0000"></font> Seo Title </label>
                <input type="text" class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_seotitle';?>" id="<?php echo $val->code.'_seotitle';?>" value="<?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?>">
              </div>
              <div class="col-sm-6">
                <label><font color="#FF0000"></font> OG title </label>
               <input type="text" class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_ogtitle';?>" id="<?php echo $val->code.'_ogtitle';?>" value="<?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?>">
              </div>
              <div class="col-sm-12">
                <label><font color="#FF0000"></font> Seo description </label>
                <textarea class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_seo_desc';?>" id="<?php echo $val->code.'_seo_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
              </div>
              <div class="col-sm-12">
                <label><font color="#FF0000"></font> OG description </label>
                <textarea class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_og_desc';?>" id="<?php echo $val->code.'_og_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
              </div>
              </div>
              @endforeach
            </div>
          </div>        
        </div> 
      </div>        
	   </div>
  </div>
  

        </div>


        <div class="btn-shape">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                    <a href="{{ url('email/template') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
                </div>

            </div>
        </div>



    {{ Form::close() }}


    <script>
        function AddTags(id,tag){
            var current = $("#"+id).val();
            var newVal = current + tag;
            CKEDITOR.instances["description"].insertHtml(tag);
        }

    </script>

@endsection