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

    <?php
    $parent = getParentIdFromCategoryId($categories->id);

    if(isset($optionsdetails) && !empty($optionsdetails) && $action == 'edit'){
        echo Form::open(array('url' => '/wizard/update/options/'.$optionsdetails->id, 'files' => true, 'id' => 'wizard_options_form'));
    }
    else {
        echo Form::open(array('url' => '/wizard/update/options', 'files' => true, 'id' => 'wizard_options_form'));
    }
    ?>
    <input type="hidden" name="options_id" value="{{isset($optionsdetails->id) ? $optionsdetails->id : ''}}">
    <input type="hidden" name="category_id" value="{{isset($categories->id) ? $categories->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
    <div class="basic-info-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="basic-info-lft">
                        <div class="basic-data-blk">
                            <div class="section-border">


                                <h1 class="user-profile-heading">@if(isset($action) && $action == 'edit') {{trans('messages.keyword_update_option')}} : {{ $parent->name }} @else {{trans('messages.keyword_add_option')}} : {{ $parent->name }} @endif</h1><hr>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">{{trans('messages.keyword_title')}} <span class="required">(*)</span></label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_options_name')}}" value="{{(isset($optionsdetails->title))?$optionsdetails->title : old('name')}}" name="options" id="name" type="text">
                                        </div>



                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_icon')</label>
                                            <div class="row" >
                                                <div class="col-md-6">
                                                    <div class="dropdown icon-dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">@lang('messages.keyword_select_icon')
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" id="all_icons">
                                                            <li role="presentation" class="icon-search">

                                                                <div class="form-group">
                                                                    <input class="form-control" name="icon-search" id="optional_search" placeholder="Search icon here">
                                                                </div>

                                                            </li>
                                                            <script>
                                                                $('#optional_search').on('keyup', function() {
                                                                    var val = $.trim(this.value);
                                                                    if (val) {
                                                                        $('.optional-section[data-filter!=' + val + ']').hide();
                                                                        $('.optional-section[data-filter*=' + val + ']').show();
                                                                    } else {
                                                                        $('.optional-section[data-filter]').show();
                                                                    }
                                                                });
                                                            </script>

                                                            @foreach(fetchicons() as $icon)
                                                                <li role="presentation" style="cursor:pointer;" data-filter="{{ $icon->class_name }}" data-name="{{ $icon->class_name }}" class='optional-section' ><i class="{{ $icon->class_name }}"></i> </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" name="old_icon" value="{{(isset($optionsdetails->icon)) ? $optionsdetails->icon : '' }}">
                                                    <input class="form-control" id="get_icon" placeholder="{{trans('messages.keyword_icon')}}" value="{{(isset($optionsdetails->icon)) ? $optionsdetails->icon : '' }}" name="icon" type="text">
                                                </div>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <div class="">@lang('messages.keyword_language') ? </div><div class="switch"><input value="1"  name="is_language" id="is_language" type="checkbox" {{ (isset($optionsdetails->is_language) && $optionsdetails->is_language == 1) ? 'checked' : '' }}><label for="is_language"></label></div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{trans('messages.keyword_select_category')}} <span class="required">(*)</span></label>
                                                    <select name="parent_category" id="parent_category" class="form-control">
                                                        <option value="">@lang('messages.keyword_--select--')</option>
                                                        @foreach(fetSecondaryCategory($parent->parent_id) as $key => $category)
                                                            <option value="{{ $category->id }}" {{ ($category->id == $parent->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{trans('messages.keyword_select_subcategory')}}</label>
                                                    <select name="category_id" id="category_id" class="form-control">
                                                        <option value="">@lang('messages.keyword_--select--')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="">@lang('messages.keyword_description')</label>
                                            <input class="form-control" placeholder="{{trans('messages.keyword_description')}}" value="{{(isset($optionsdetails->description))?$optionsdetails->description : old('description')}}" name="description" id="description" type="text">
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
                <a href="{{ url('wizard/options').'/'.$categories->id }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button type="submit" class="btn btn-default">{{trans('messages.keyword_save')}}</button>
            </div>

        </div>
    </div>




    <?php echo Form::close(); ?>
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        /*Validations*/
        $(document).ready(function() {
            $("#wizard_options_form").validate({
                rules: {
                    parent_category: {
                        required: true
                    },
                    options: {
                        required: true,
                        maxlength: 50
                    },

                },
                messages: {
                    parent_category: {
                        required: "@lang('messages.keyword_please_select_category')",
                    },
                    options: {
                        required: "{{trans('messages.keyword_please_enter_an_option_name')}}",
                        maxlength: "{{trans('messages.keyword_option_name_must_be_less_than_50_characters')}}"
                    },


                }
            });
        });
        /*Validations*/




        /* for dynamic category list */
        $(document).ready(function(){
            var parent_id = $("#parent_category").val();
            var subcategory_id = '{{ isset($optionsdetails->category_id) ? $optionsdetails->category_id : '' }}';
            if(parent_id != '')
            {
                        @if(isset($optionsdetails->id) && $action == 'edit')
                var link = "{{ url('wizard/fetch_subcategory') }}" + '/' + parent_id + '/' + subcategory_id ;
                        @else
                var link = "{{ url('wizard/fetch_subcategory') }}" + '/' + parent_id;
                @endif
                $.ajax({
                    type: 'GET',
                    url: link,
                    success: function(data){
                        $("#category_id").html(data);
                    }
                });
            }else{
                $("#category_id").html('<option value="">{{ trans('messages.keyword_--select--') }}</option>');
            }

        });
        $("#parent_category").on("change", function(){
            var parent_id = $(this).val();
            var subcategory_id = '{{ isset($optionsdetails->category_id) ? $optionsdetails->category_id : '' }}';
            if(parent_id != '')
            {
                        @if(isset($optionsdetails->id) && $action == 'edit')
                var link = "{{ url('wizard/fetch_subcategory') }}" + '/' + parent_id + '/' + subcategory_id ;
                        @else
                var link = "{{ url('wizard/fetch_subcategory') }}" + '/' + parent_id;
                @endif

                $.ajax({
                    type: 'GET',
                    url: link,
                    success: function(data){
                        $("#category_id").html(data);

                    }
                });
            }else{
                $("#category_id").html('<option value="">--Select--</option>');
            }

        });

        $("#all_icons").on("click", "li", function(){
            var icon_name = $(this).data('name');
            $("#get_icon").val(icon_name);
        });

    </script>
@endsection