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

    {{ Form::open(array('url' => '/email/template/update/', 'files' => true, 'id' => 'template_edit_form')) }}

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
                    <div class="email-template-add">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="user-form row">

                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_category') <span
                                                    class="required">(*)</span></label>
                                        <div class="form-group">
                                            <select class="form-control" name="email_cat_id">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                @forelse(getEmailTemplateCategory() as $category)
                                                    <option value="{{ $category->id }}" {{ (isset($template->email_cat_id) && $category->id == $template->email_cat_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @empty
                                                    <option value="">@lang('messages.keyword_no_categories')</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="" class="block">@lang('messages.keyword_subject') <span
                                                    class="required">(*)</span></label>
                                        <input class="form-control" id="" name="subject"
                                               placeholder="@lang('messages.keyword_subject')"
                                               value="{{ isset($template->subject) ? $template->subject : '' }}"
                                               type="text">
                                    </div>



                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_status') <span class="required">(*)</span></label>
                                        <div class="form-group">
                                            <select class="form-control" name="is_active">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="0" {{ (isset($template->is_active) && $template->is_active == 0) ? 'selected' : '' }}>@lang('messages.keyword_active')</option>
                                                <option value="1" {{ (isset($template->is_active) && $template->is_active == 1) ? 'selected' : '' }}>@lang('messages.keyword_inactive')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="" class="block">@lang('messages.keyword_message') </label>
                                        <textarea class="form-control" id="description"
                                                  name="description">{{ isset($template->description) ? html_entity_decode($template->description) : '' }}</textarea>
                                        <script>
                                            CKEDITOR.replace('description');
                                        </script>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <h4 for="" class="block">@lang('messages.keyword_email_tags')</h4>
                                        @if(count(getEmailTags()) > 0)
                                            <table class="table">
                                                @foreach(array_chunk(getEmailTags(),4) as $chunk)
                                                    <tr>
                                                        @foreach($chunk as $stag => $tag)
                                                            <td class="link-mail"><a href="javascript:void(0);" onclick="AddTags('<?php echo $category->id . '_' . $tag->id . '_message';?>','[<?php echo $tag->tag;?>]');">[<?php echo $tag->tag;?> ] </a>- <?php echo $tag->description;?> </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
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


            <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#template_edit_form").validate({
                        rules: {
                            email_cat_id: {
                                required: true
                            },
                            is_active: {
                                required: true
                            },
                            subject: {
                                required: true
                            }
                        },
                        messages: {
                            email_cat_id: {
                                required: "{{trans('messages.keyword_please_select_category_name')}}"
                            },
                            is_active: {
                                required: "{{trans('messages.keyword_please_select_status')}}"
                            },
                            subject: {
                                required: "{{trans('messages.keyword_please_enter_a_subject')}}"
                            }
                        }
                    });
                });
            </script>

@endsection