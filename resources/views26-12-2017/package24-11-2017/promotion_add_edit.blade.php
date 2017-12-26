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
    <?php $arrlanguages = getlanguages(); ?>
    {{ Form::open(array('url' => '/promotion/update', 'files' => true, 'id' => 'promotion_edit_form')) }}

    <input type="hidden" name="promotion_id" value="{{ isset($promotion->id) ? $promotion->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="user-profile-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@if(isset($promotion->id) && $action =='edit')@lang('messages.keyword_promotion_update')@else @lang('messages.keyword_promotion_add')@endif</h1>
            </div>
        </div><hr>

        <div class="row">
            <div class="package-add">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">

                        <div class="col-md-6 col-sm-12 col-xs-12">

                            <div class="form-group">
                                <label for="">@lang('messages.keyword_code') <span class="required">(*)</span></label>
                                <input type="text" class="form-control" id="" name="code"
                                       placeholder="@lang('messages.keyword_code')"
                                       value="{{ isset($promotion->code) ? $promotion->code : generateCode(6) }}"
                                       required readonly>
                            </div>

                            <div class="form-group">
                                <label for="">@lang('messages.keyword_promotion_name') <span class="required">(*)</span></label>
                                <input type="text" class="form-control" id="" name="name"
                                       placeholder="@lang('messages.keyword_name')"
                                       value="{{ isset($promotion->name) ? $promotion->name : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="">@lang('messages.keyword_description') <span
                                            class="required">(*)</span></label>
                                <textarea class="form-control" name="description"
                                          placeholder="@lang('messages.keyword_description')">{{ isset($promotion->description) ? $promotion->description : '' }}</textarea>
                            </div>




                        </div>


                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_date_modified') <span class="required">(*)</span></label>
                                <input type="text" class="form-control" id="updated_at" name="updated_at"
                                       placeholder="@lang('messages.keyword_date_modified')"
                                       value="{{ isset($promotion->updated_at) ? $promotion->updated_at : '' }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">@lang('messages.keyword_price') <span class="required">(*)</span></label>
                                <input type="text" class="form-control" id="price" name="price"
                                       placeholder="@lang('messages.keyword_price')"
                                       value="{{ isset($promotion->price) ? $promotion->price : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="status" class="block">@lang('messages.keyword_status')</label>
                                <div class="switch"><input value="0" name="is_active" id="is_active" type="checkbox" {{ (isset($promotion->is_active) && $promotion->is_active == 0) ? 'checked' : '' }}><label for="is_active"></label></div>
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
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('promotions') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>

        $( "#promotion_edit_for" ).validate({
            rules: {
                code: {
                    required: true
                },
                name: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                description: {
                    required: true
                },
                updated_at: {
                    required: true
                }
            },
            messages: {
                code: {
                    required: "@lang('messages.keyword_please_enter_a_code')"
                },
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                updated_at: {
                    required: "@lang('messages.keyword_please_select_date')"
                }
            }
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#updated_at').datepicker({
                format: "yyyy-mm-dd",
            }).datepicker();
        });
    </script>
@endsection
