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

    {{ Form::open(array('url' => 'user_type/update', 'files' => true, 'id' => 'user_type_form')) }}




    <input type="hidden" name="typeid" value="{{ isset($user_type->id) ? $user_type->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    <div class="user-profile-wrap change-passowrd-wrap">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">@lang('messages.keyword_user_type')</h1>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="user-profile change-pass">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">

                            <div class="form-group">
                                <label for="">@lang('messages.keyword_type')</label>
                                <input type="text" value="{{ isset($user_type->type) ? $user_type->type : '' }}" name="type" class="form-control" id=""
                                       placeholder="@lang('messages.keyword_user_type')" required>

                            </div>
                            {{--<div class="error">{{ $errors->first('type') }}</div>--}}

                        </div>
                    </div>
                    <hr>
                </div>


                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="user-profile-heading">@lang('messages.keyword_change_permission')</h4><br>
                </div>


                <div class="col-md-12 col-sm-12 col-xs-12">
    
                    @php $selected_array = []; @endphp
                    @if(isset($user_type->id))
                        {{--used for selected checkboxes permissions--}}
                        <?php $selected_array = getUserTypePermissions($user_type->id); ?>
                    @endif
                    
                    
                    <table class="table table-hover table-bordered permission_table table-condensed">
                        <tr>
                            <th>@lang('messages.keyword_modules')</th>
                            <th class="text-center">@lang('messages.keyword_writing')</th>
                            <th class="text-center">@lang('messages.keyword_reading')</th>
                        </tr>

                        {{-- Modules--}}
                        @php $modules = fetch_modules_for_permission(1,0, '',array(), $selected_array) @endphp
                        @foreach($modules as $module)
                            {!! $module !!}
                        @endforeach
                        
                        
                        
                    </table>
                </div>


            </div>
        </div>
    </div>




    <div class="btn-shape">

        <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('user_type') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
                </div>

        </div>

    </div>

    {{ Form::close() }}
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>
        $( "#user_type_form" ).validate({
            rules: {
                type: "required",
            },
            messages: {
                type: {
                    required: "@lang('messages.keyword_please_enter_type')",
                }
            }
        });


        $(document).ready(function(){
            //Unchecks main checkbox if all not checked
            $(".permission_table input[type='checkbox']").change(function(){
                var className = $(this).attr('class');
                //alert(className);
                var countTotal = $('.' + className).length; // count total class

                var countChecked = checkedLength(className); // count checked checkbox

                if(countTotal == countChecked){
                    $("#" + className).prop("checked", this.checked);
                }else{
                    $("#" + className).prop("checked", false);
                }
            });

        });


        function checkedLength(className)
        {
            var countChecked =  $('[class="'+ className +'"]:checked').length;
            return countChecked;
        }
        
        
         function checkAll(e){
            var id = $(e).attr('id');
            if($(e).prop('checked')){
                $("." + id).prop('checked', true);
            }else{
                $("." + id).prop('checked', false);
            }
        }

    </script>
@endsection
