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


    {{ Form::open(array('url' => '/role/modules/update', 'files' => true, 'id' => 'user_modules_form')) }}

    <input type="hidden" name="typeid" value="{{ $typeid }}">

    <table class="table table-hover">
        <tr>
            <th>@lang('messages.keyword_modules')</th>
            <th class="text-center">@lang('messages.keyword_writing')</th>
            <th class="text-center">@lang('messages.keyword_reading')</th>
        </tr>

    @forelse($modules as $row)
        <tr>
            <td>
                @if($row['level'] == 1)
                    <span class="{{ (($row['level'] == 1) ? 'text-primary' : 'text-primary') }}"><strong>{{ $row['name'] }}</strong></span>
                @else
                    &nbsp; &nbsp;<span class="{{ (($row['level'] == 1) ? 'text-primary' : 'text-primary') }}">{{ $row['name'] }}</span>
                @endif
            </td>

            {{-- Fetching specific usertypes permission --}}
            <?php $selected_array = getUserTypePermissions($typeid); ?>

            <?php
                // selected data array in module_id | parent_id | read:0 / write:1 format
                $write_selected  = in_array($row['module_id']."|".$row['parent_id']."|1", $selected_array) ? 'checked' : '' ;
                $read_selected  = in_array($row['module_id']."|".$row['parent_id']."|0", $selected_array) ? 'checked' : '' ;
            ?>
            <td class="text-center"><input type="checkbox" name="writing[]" id="" value="{{ $row['module_id']."|".$row['parent_id']."|1" }}" {{ $write_selected }}></td>
            <td class="text-center"><input type="checkbox" name="reading[]" id="" value="{{ $row['module_id']."|".$row['parent_id']."|0" }}" {{ $read_selected }}></td>
        </tr>

    @empty
        <tr>
            <td colspan="3">@lang('messages.keyword_no_modules_found')</td>
        </tr>
    @endforelse
    </table>
    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('user/roles') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
            <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
        </div>
    </div>

    {{ Form::close() }}
@endsection


