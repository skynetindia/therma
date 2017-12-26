@php $selected_array = []; @endphp

    {{--used for selected checkboxes permissions--}}
<?php $selected_array = getUserTypePermissions($user_type_id); ?>




<div class="col-md-12 col-sm-12 col-xs-12">
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