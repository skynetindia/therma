@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function(){
            $("#phone").mask("(999) 999-9999");
        });
    </script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <?php $modules = fetch_modules(0, '', 0); ?>

    {{ Form::open(array('url' => '/package/options/update', 'files' => true, 'id' => 'package_options_edit_form')) }}

    <input type="hidden" name="options_id" value="{{ isset($options->id) ? $options->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="user-profile-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($options->id) && $action =='edit')@lang('messages.keyword_package_option_update')@else @lang('messages.keyword_package_option_add')@endif</h1>
            </div>
        </div><hr>

        <div class="row">
            <div class="package-add">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_short_name') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="short_name" id="" placeholder="@lang('messages.keyword_short_name')" value="{{ isset($options->short_name) ? $options->short_name : '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_package_name') <span class="required">(*)</span></label>
                                    <input type="text" name="name" class="form-control" id="" placeholder="@lang('messages.keyword_package_name')" value="{{ isset($options->name) ? $options->name : '' }}" required>
                                </div>


                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_description') <span class="required">(*)</span></label>
                                    <textarea class="form-control" name="description" placeholder="{{ trans('messages.keyword_description') }}" required>{{ isset($options->description) ? $options->description : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="old_image" value="{{ isset($options->image) ? $options->image : '' }}">
                                    <label for="">@lang('messages.keyword_icon') <span class="required">(*)</span></label>
                                    <input type="file" class="" id="" name="image" placeholder="" value="">
                                </div>

                                @if($action == 'edit')
                                <div class="form-group">
                                    <div class="user-profile-img">
                                        @if($options->image != '')
                                            <img src="{{ asset('public/images/package')."/".$options->image }}" class="thumbnail" alt="{{ $options->name }}" width="150px">
                                        @else
                                            <img src="{{ asset('public/images/default/default_option.png') }}" class="thumbnail" alt="{{ $options->name }}" width="150px">
                                        @endif
                                    </div>
                                </div>
                                @endif


                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_base_price_list') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="base_price" id="" placeholder="@lang('messages.keyword_base_price_list')" value="{{ isset($options->base_price) ? $options->base_price : '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="discount" id="" placeholder="@lang('messages.keyword_discount')" value="{{ isset($options->discount) ? $options->discount : '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_quick_description') <span class="required">(*)</span></label>
                                    <textarea class="form-control" name="quick_description" placeholder="{{ trans('messages.keyword_quick_description') }}" required>{{ isset($options->quick_description) ? $options->quick_description : '' }}</textarea>
                                </div>



                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-shape">

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('package/options') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>

        </div>

    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>



        $( "#package_options_edit_form" ).validate({
            rules: {
                short_name: {
                    required: true
                },
                name: {
                    required: true
                },
                image: {
                    extension: "jpeg|jpg|png|gif"
                },
                description: {
                    required: true
                },
                quick_description: {
                    required: true
                },
                discount : {
                    required: true,
                    number: true
                },
                base_price : {
                    required: true,
                    number: true
                }
            },
            messages: {
                short_name: {
                    required: "@lang('messages.keyword_please_enter_a_short_name')"
                },
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                image: {
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                quick_description: {
                    required: "@lang('messages.keyword_please_enter_a_quick_description')"
                },
                discount : {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                base_price : {
                    required: "@lang('messages.keyword_please_enter_a_base_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                }
            }
        });


    </script>






@endsection
