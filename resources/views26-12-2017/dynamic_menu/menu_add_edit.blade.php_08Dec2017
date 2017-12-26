@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>

    <?php
    if(isset($menudetails) && !empty($menudetails) && $action == 'edit'){
        echo Form::open(array('url' => 'menu/update' . "/".$menudetails->id, 'files' => true, 'id' => 'dynamic_menu_form'));
    }
    else {
        echo Form::open(array('url' => 'menu/update', 'files' => true, 'id' => 'dynamic_menu_form'));
    }
    ?>
    <input type="hidden" name="parent_menu_id" value="{{isset($menudetails->id) ? $menudetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">
                                <h1 class="user-profile-heading">@lang('messages.keyword_dynamic_menu')</h1><hr>
                                <div class="col-md-4">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_menu_name')}} <span
                                                        class="required">(*)</span></label>
                                            <input class="form-control"
                                                   placeholder="{{trans('messages.keyword_menu_name')}}"
                                                   value="{{(isset($menudetails->name)) ? $menudetails->name : old('name')}}"
                                                   name="name" id="name" type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_link_for_menu')}} </label>
                                            <input class="form-control"
                                                   placeholder="{{trans('messages.keyword_link_for_menu')}}"
                                                   value="{{ isset($menudetails->link) ? $menudetails->link : '' }}"
                                                   name="link" id="link" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_type')}} <span
                                                        class="required">(*)</span></label>
                                            <select class="form-control" name="type" id="menu_type">
                                                <option value="">@lang('messages.keyword_--select--')</option>
                                                <option value="1" {{ (isset($menudetails->type) && $menudetails->type == 1) ? 'selected' : '' }}>@lang('messages.keyword_front_menu')</option>
                                                <option value="0" {{ (isset($menudetails->type) && $menudetails->type == 0) ? 'selected' : '' }}>@lang('messages.keyword_back_menu')</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_departments')}}</label>
                                            <select class="form-control selectpicker" name="user_types[]"
                                                    data-live-search="true" id="user_types" multiple>
                                                @forelse(getUserTypes() as $key => $value)
                                                    <?php
                                                    $selected = array();
                                                    if (isset($menudetails->user_types)) {
                                                        $selected = explode(",", $menudetails->user_types);
                                                    }
                                                    ?>
                                                    <option value="{{ $value->id }}" {{ (in_array($value->id, $selected)) ? 'selected' : '' }}>{{ $value->type }}</option>
                                                @empty
                                                    <option value="">@lang('messages.keyword_--select--')</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-4">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_parent_menu')}}</label>
                                            <select class="form-control" name="parent_id" id="parent_id"
                                                    onChange="togglePriority(this)">
                                                <option value="0">@lang('messages.keyword_--select--')</option>
                                                @foreach($menus as $key => $val)
                                                    <?php $selectedcatStatus = (isset($menudetails->parent_id) && ($val->id == $menudetails->parent_id)) ? 'selected' : ''; ?>
                                                    <option value="{{ $val->id }}" {{$selectedcatStatus}}>{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_menu_class')}} </label>
                                            <input class="form-control"
                                                   placeholder="{{trans('messages.keyword_menu_class')}}"
                                                   value="{{ isset($menudetails->menu_class) ? $menudetails->menu_class : '' }}"
                                                   name="menu_class" id="menu_class" type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12" id="priority">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_priority')}} <span class="required">(*)</span></label>
                                            <input type="text" name="priority" id="priority"
                                                   placeholder="@lang('messages.keyword_priority')" class="form-control"
                                                   value="{{ isset($menudetails->priority) ? $menudetails->priority : getLastPriority() }}">

                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12 none" id="show_sub_category">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_sub_priority')}} <span class="required">(*)</span></label>
                                            <input type="text" name="sub_priority" id="sub_priority"
                                                   placeholder="@lang('messages.keyword_sub_priority')" class="form-control"
                                                   value="{{ isset($menudetails->sub_priority) ? $menudetails->sub_priority : getLastPriority() }}">

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-control-file">
                                        <label for="">@lang('messages.keyword_choose_icon')</label>
                                        <input type="hidden" name="old_image"
                                               value="{{ isset($menudetails->image) ? $menudetails->image : '' }}">
                                        <input type="file" name="image" class="" id="">
                                    </div>
                                    @if(isset($menudetails->image) && !empty($menudetails->image))
                                        <div class="col-md-4">
                                            <img src="{{ asset('public/images/dynamic_menu')."/".$menudetails->image }}"
                                                 alt="" class="thumbnail" style="height:180px;background:lightgrey;">
                                        </div>
                                    @endif
                                </div>

                                <div class="clearfix"></div>
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
                <a href="{{ url('menu/list') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>

        </div>
    </div>
    </div>
    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script type="text/javascript">

        function togglePriority(e)
        {
            var getval = $(e).val();
            if(getval != '0')
            {
                $("#show_sub_category").show();
            }
            else{
                $("#show_sub_category").hide();
            }
        }

        $(document).ready(function() {
            $("#dynamic_menu_form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    image: {
                        extension: "jpeg|jpg|png|gif|svg"
                    },
                    "user_types[]" : {
                        required: true
                    },
                    type: {
                        required: true
                    },
//                    link2: {
//                        required: true
//                    },
                    priority: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    name: {
                        required: "{{trans('messages.keyword_please_enter_a_menu_name')}}",
                        maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
                    },
                    image: {
                        extension: "@lang('messages.keyword_please_choose_valid_extension')"
                    },
                    "user_types[]" : {
                        required: "@lang('messages.keyword_please_select_user_type')"
                    },
                    type: {
                        required: "@lang('messages.keyword_please_select_menu_type')"
                    },
                    {{--link: {--}}
                        {{--required: "@lang('messages.keyword_please_enter_a_link')"--}}
                    {{--},--}}
                    priority: {
                        required: "@lang('messages.keyword_please_enter_priority')",
                        number: "@lang('messages.keyword_please_enter_valid_number')"
                    }
                }
            });
        });
    </script>

@endsection