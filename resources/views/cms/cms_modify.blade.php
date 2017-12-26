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
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <style>
        .ui-autocomplete {
            z-index: 100;
        }
    </style>
    <div class="ssetting-wrap">
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading"><?php echo ((isset($action) && $action == 'edit')) ? 'Edit CMS' : 'Add CMS'; ?></h1>
                    <hr>
                </div>
            </div>
            <div class="setting-tab">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                        {{  Form::open(array('url' => '/cms/update/', 'files' => true,'id'=>'cms_form')) }}
                        
                        
                        <input type="hidden" name="cms_id" value="{{ isset($cms->id) ? $cms->id : '' }}">
                        <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
                        
                        {{ csrf_field() }}
                        
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_title') <span
                                                class="required">(*)</span></label>
                                    <input class="form-control" placeholder="@lang('messages.keyword_title')"
                                           name="title" id="title" value="{{ isset($cms->title) ? $cms->title : '' }}"
                                           type="text" required>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <ul class="nav nav-tabs">
                                        <?php $selectecode = isset($language_selected->code) ? $language_selected->code : 'en';?>
                                        @foreach ($language as $key => $val)
                                            <li class="<?php echo ($val->code == $selectecode) ? 'active' : '';?>"><a
                                                        data-toggle="tab"
                                                        href="<?php echo '#' . $val->code;?>"><?php echo $val->name;?></a>
                                            </li>
                                    @endforeach
                                    <!--<li class="active"><a data-toggle="tab" href="#en" aria-expanded="true">English</a></li>-->
                                    </ul>
                                    <br>
                                    <div class="tab-content">
                                        @foreach ($language as $key => $val)
                                            
                                            <div id="<?php echo $val->code;?>"
                                                 class="tab-pane fade <?php echo ($val->code == $selectecode) ? 'in active' : '';?>">
                                                <div class="row">
                                                    
                                                    <div class="col-sm-12">
                                                        <label> @lang('messages.keyword_description') <span class="required">(*)</span> </label>
                                                        
                                                        <textarea class="form-control" rows="10" name="{{ $val->code.'_cms_desc' }}"id="{{ $val->code.'_cms_desc' }}">
                                                            {{ isset($cms) ? getCMSeditvalue($val->code, $cms->description, $cms->title_language_key) : '' }}
                                                        </textarea>
                                                        <script>
                                                            CKEDITOR.replace('{{ $val->code.'_cms_desc' }}');
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="clearfix"><br></div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                @lang('messages.keyword_seo_fields')
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_seo_title')</label>
                                                                            <input class="form-control" placeholder="@lang('messages.keyword_seo_title')" name="{{ $val->code.'_seo_title' }}" id="{{ $val->code.'_seo_title' }}"
                                                                                   value="{{ isset($cms) ? getCMSeditvalue($val->code, $cms->seo_title, $cms->title_language_key) : '' }}" type="text">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_og_title')</label>
                                                                            <input class="form-control"
                                                                                   placeholder="@lang('messages.keyword_og_title')"
                                                                                   name="{{ $val->code.'_og_title' }}" id="{{ $val->code.'_og_title' }}"
                                                                                   value="{{ isset($cms) ? getCMSeditvalue($val->code, $cms->og_title, $cms->title_language_key) : '' }}"
                                                                                   type="text">
                                                                        </div>
                                                                    </div>
                                                                
                                                                
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_seo_description')</label>
                                                                            <textarea name="{{ $val->code.'_seo_description' }}" class="form-control" id="{{ $val->code.'_seo_description' }}" cols="30" rows="5" style="resize:vertical;" placeholder="@lang('messages.keyword_seo_description')">{{ isset($cms) ? getCMSeditvalue($val->code, $cms->seo_description, $cms->title_language_key) : '' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_og_description')</label>
                                                                            <textarea name="{{ $val->code.'_og_description' }}" class="form-control" id="{{ $val->code.'_og_description' }}" cols="30" rows="5" style="resize:vertical;" placeholder="@lang('messages.keyword_og_description')">{{ isset($cms) ? getCMSeditvalue($val->code, $cms->og_description, $cms->title_language_key) : '' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_seo_keywords')</label>
                                                                            <input name="{{ $val->code.'_keywords' }}" class="form-control"
                                                                                   id="{{ $val->code.'_keywords' }}" value="{{ isset($cms) ? getCMSeditvalue($val->code, $cms->keywords, $cms->title_language_key) : '' }}"
                                                                                   placeholder="@lang('messages.keyword_keywords')">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="">@lang('messages.keyword_og_url')</label>
                                                                            <input name="{{ $val->code.'_og_url' }}" class="form-control" id="{{ $val->code.'_og_url' }}" value="{{ isset($cms) ? getCMSeditvalue($val->code, $cms->og_url, $cms->title_language_key) : '' }}" placeholder="@lang('messages.keyword_og_url')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="text-right">
                            <button id="" type="submit" class="btn btn-default btn-6-12">Save</button>
                            <a href="{{ url('cms') }}" class="btn btn-reject btn-cancel">Cancel</a>
                            
                        </div>
                    </div>
                    
                    
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script>

        $(document).ready(function () {
            $("#cms_form").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    }

                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        maxlength: "Label must be less than 255 characters"
                    }
                }
            });
        });
        //var $j = jQuery.noConflict();
    
    </script>
@endsection