@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>



     <?php echo Form::open(array('url' => 'template/categories/update', 'files' => true, 'id' => 'email_template_category_form')); ?>


    <input type="hidden" name="template_category_id" value="{{isset($template_category->id) ? $template_category->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <h1 class="user-profile-heading">
                                    @if(isset($action) && $action == 'edit') @lang('messages.keyword_update_template_category')@else @lang('messages.keyword_add_template_category') @endif
                                </h1><hr>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_name')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_template_category_name')}}" value="{{(isset($template_category->name)) ? $template_category->name : old('name')}}" name="name" id="name" type="text">
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

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('email/template/category') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>

        </div>
    </div>
    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#email_template_category_form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_category_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    }
                }
            });
        });
    </script>

@endsection