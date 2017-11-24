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

    {{ Form::open(array('url' => '/package/cure-treatment/update', 'files' => true, 'id' => 'cure_treatment_edit_form')) }}

    <input type="hidden" name="options_id" value="{{ isset($cure_treatment->id) ? $cure_treatment->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="user-profile-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($cure_treatment->id) && $action =='edit')@lang('messages.keyword_cure_treatment_update')@else @lang('messages.keyword_cure_treatment_add')@endif</h1>
            </div>
        </div><hr>

        <div class="row">
            <div class="package-add">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                                    <input type="text" name="name" class="form-control" id="" placeholder="@lang('messages.keyword_package_name')" value="{{ isset($cure_treatment->name) ? $cure_treatment->name : '' }}" required>
                                </div>


                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_description') <span class="required">(*)</span></label>
                                    <textarea class="form-control" name="description" placeholder="{{ trans('messages.keyword_description') }}" required>{{ isset($cure_treatment->description) ? $cure_treatment->description : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="old_image" value="{{ isset($cure_treatment->image) ? $cure_treatment->image : '' }}">
                                    <label for="">@lang('messages.keyword_icon') <span class="required">(*)</span></label>
                                    <input type="file" class="" id="" name="image" placeholder="" value="">
                                </div>

                                @if($action == 'edit')
                                <div class="form-group">
                                    <div class="user-profile-img">
                                        @if($cure_treatment->image != '')
                                            <img src="{{ asset('public/images/cure_treatment')."/".$cure_treatment->image }}" class="thumbnail" alt="{{ $cure_treatment->name }}" width="150px">
                                        @else
                                            <img src="{{ asset('public/images/default/default_cure_treatment.jpg') }}" class="thumbnail" alt="{{ $cure_treatment->name }}" width="150px">
                                        @endif
                                    </div>
                                </div>
                                @endif


                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_type') <span class="required">(*)</span></label>
                                    <select name="type" id="" class="form-control">
                                        <option value="1" {{ (isset($cure_treatment->type) && $cure_treatment->type == 1) ? 'selected' : '' }}>@lang('messages.keyword_cure')</option>
                                        <option value="0" {{ (isset($cure_treatment->type) && $cure_treatment->type == 0) ? 'selected' : '' }}>@lang('messages.keyword_treatment')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="price" id="" placeholder="@lang('messages.keyword_price')" value="{{ isset($cure_treatment->price) ? $cure_treatment->price : '' }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_discount') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" name="discount" id="" placeholder="@lang('messages.keyword_discount')" value="{{ isset($cure_treatment->discount) ? $cure_treatment->discount : '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_commission') <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" name="commission" id="" placeholder="@lang('messages.keyword_commission')" value="{{ isset($cure_treatment->commission) ? $cure_treatment->commission : '' }}" required>
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

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('package/cure-treatment') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>

        </div>

    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>



        $( "#cure_treatment_edit_form" ).validate({
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
                discount : {
                    required: true,
                    number: true
                },
                price : {
                    required: true,
                    number: true
                },
                commission: {
                    required: true,
                    number : true
                }
            },
            messages: {
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                image: {
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                discount : {
                    required: "@lang('messages.keyword_please_enter_a_discount')",
                    number: "@lang('messages.keyword_please_enter_valid_discount')"
                },
                price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                commission: {
                    required: "@lang('messages.keyword_please_enter_a_commission')",
                    number: "@lang('messages.keyword_please_enter_valid_number')"
                }
            }
        });


    </script>






@endsection
