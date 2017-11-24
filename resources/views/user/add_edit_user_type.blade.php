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
    <?php $modules = fetch_modules(0, '', 0); ?>

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
                                <label for="">@lang('messages.keyword_type') <span class="required">(*)</span></label>
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
                    <table class="table table-hover table-bordered permission_table">
                        <tr>
                            <th>@lang('messages.keyword_modules')</th>
                            <th class="text-center">@lang('messages.keyword_writing')</th>
                            <th class="text-center">@lang('messages.keyword_reading')</th>
                        </tr>

                        @forelse($modules as $row)
                            <tr class="{{ ($row['level'] == 1) ? 'info' : '' }}">
                                <td>
                                    @if($row['level'] == 1)

                                        <span class="{{ (($row['level'] == 1) ? 'text-primary' : 'text-primary') }}"><strong>{{ $row['name'] }}</strong></span>
                                    @else
                                        <?php
                                            $primaryWriteClass = ($row['parent_id'] != 0) ? getParentName($row['parent_id']): '';
                                        ?>
                                    &nbsp; &nbsp;<span class="{{ (($row['level'] == 1) ? 'text-primary' : 'text-primary') }}">{{ $row['name'] }}</span>
                                    @endif
                                </td>


                                {{--primary class--}}
                                <?php
                                    $primaryWriteID = ($row['level'] == 1) ? $row['class_name']."_1" : 'default_1_'.$row['module_id'];
                                    $primaryReadID = ($row['level'] == 1) ? $row['class_name']."_0" : 'default_0_'.$row['module_id'];
                                    $primaryWriteClass = ($row['level'] == 1) ? 'writing' : '';
                                    $primaryReadClass = ($row['level'] == 1) ? 'reading' : '';

                                    $secondaryWriteClass = ($row['level'] != 1) ? getParentName($row['parent_id'])."_1" : '';
                                    $secondaryReadClass = ($row['level'] != 1) ? getParentName($row['parent_id'])."_0" : '';
                                ?>
                                {{--primary class--}}

                                {{-- Fetching specific usertypes permission --}}
                                <?php $selected_array = array(); ?>
                                @if(isset($user_type->id))
                                    <?php $selected_array = getUserTypePermissions($user_type->id); ?>
                                @endif

                                <?php
                                // selected data array in module_id | parent_id | read:0 / write:1 format
                                $write_selected  = in_array($row['module_id']."|".$row['parent_id']."|1", $selected_array) ? 'checked' : '' ;
                                $read_selected  = in_array($row['module_id']."|".$row['parent_id']."|0", $selected_array) ? 'checked' : '' ;
                                ?>
                                <td class="text-center">
                                    <div class="ryt-chk">
                                        <input type="checkbox" name="writing[]" class="{{ $secondaryWriteClass }} {{ $primaryWriteClass }}" id="{{ $primaryWriteID }}" value="{{ $row['module_id']."|".$row['parent_id']."|1" }}" {{ $write_selected }}>
                                        <label for="{{ $primaryWriteID }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="ryt-chk">
                                        <input type="checkbox" name="reading[]" class="{{ $secondaryReadClass }} {{ $primaryReadClass }}" id="{{ $primaryReadID }}" value="{{ $row['module_id']."|".$row['parent_id']."|0" }}" {{ $read_selected }}>
                                        <label for="{{ $primaryReadID }}"></label>
                                    </div>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="3">@lang('messages.keyword_no_modules_found')</td>
                            </tr>
                        @endforelse
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
            $('.writing').click(function(){
                var $id = $(this).attr('id');
                $('.'+$id).prop('checked', this.checked);
            });

            $('.reading').click(function(){
                var $id = $(this).attr('id');
                $('.'+$id).prop('checked', this.checked);
            });

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

    </script>
@endsection
