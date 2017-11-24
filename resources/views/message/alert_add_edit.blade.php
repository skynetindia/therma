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
    <!--  Bootstrap Select  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <!--  Bootstrap Select  -->

    {{ Form::open(array('url' => '/message/alert/update', 'files' => true, 'id' => 'message_alert_edit_form')) }}
         <input type="hidden" name="alert_id" value="{{ isset($alert->id) ? $alert->id : '' }}">
        <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

        <div class="message-wrap alert-wrap">

            <div class="section-border">


                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1 class="user-profile-heading">@lang('messages.keyword_message')</h1><hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                            <input class="form-control" name="name" id="" placeholder="@lang('messages.keyword_alert_name')" type="text" value="{{ isset($alert->name) ? $alert->name : '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">@lang('messages.keyword_alert_type') <span class="required">(*)</span></label>
                            <select id="" class="form-control" name="type">
                                <option value="">@lang('messages.keyword_--select--')</option>
                                @forelse(getAlertTaxonomies() as $key => $value)
                                    <?php

                                    if(isset($alert->type)){
                                        $selected = ($alert->type == $value->id) ? "selected" : '';
                                    }else{
                                        $selected = '';
                                    }

                                    ?>
                                    <option value="{{ $value->id }}" {{ $selected }} >{{ $value->name }}</option>
                                @empty
                                    <option value="">@lang('messages.keyword_--select--')</option>
                                @endforelse
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-12 col-xs-12">

                        <div class="form-group">
                            <label for="">@lang('messages.keyword_roles') <span class="required">(*)</span></label>
                            <select id="user_type" class="form-control selectpicker" name="user_type_id[]" multiple >
                                <?php
                                    $user_types = getUserTypes();
                                    $ids = array();
                                    foreach($user_types as $key => $value)
                                    {
                                        $ids[] = $value->id;
                                    }
                                    $all_user_type_ids = implode(",", $ids);
                                ?>
                                <option value="{{ $all_user_type_ids }}" class="all_user_type">@lang('messages.keyword_all_users')</option>
                            @forelse(getUserTypes() as $key => $value)
                                <?php
                                if(isset($alert->user_type_id)){
                                    $selected_ids_array = explode(",", $alert->user_type_id);
                                    $selected = in_array($value->id, $selected_ids_array) ? "selected" : '';
                                }else{
                                    $selected = '';
                                }

                                $users = getUsersByUserType($value->id);
                                $countUsers = count($users);
                                ?>
                                <option class="specific_user_type" value="{{ $value->id }}" {{ $selected }} >{{ $value->type }} ({{ $countUsers }})</option>
                            @empty
                                <option value="">@lang('messages.keyword_--select--')</option>
                            @endforelse
                            </select>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>@lang('messages.keyword_description') <span class="required">(*)</span></label>
                            <textarea placeholder="@lang('messages.keyword_message') @lang('messages.keyword_description')" name="description" class="form-control">{{ isset($alert->description) ? $alert->description : '' }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-default" type="submit">@lang('messages.keyword_send')</button>
                    </div>
                </div>

            </div>
        </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>

        $( "#message_alert_edit_form" ).validate({
            rules: {
                type: {
                    required: true
                },
                name: {
                    required: true
                },
                warning_time: {
                    required: true,
                    number: true
                },
                "user_type_id[]" : {
                    required: true
                    //needsSelection:true
                },
                description: {
                    required: true
                }
            },
            messages: {
                type: {
                    required: "@lang('messages.keyword_please_enter_a_type')"
                },
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                warning_time: {
                    required: "@lang('messages.keyword_please_enter_warning_time')",
                    number : "@lang('messages.keyword_please_enter_valid_time')"
                },
                "user_type_id[]" : {
                    required: "@lang('messages.keyword_please_select_user_type')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                }
            }
        });






    </script>


@endsection
