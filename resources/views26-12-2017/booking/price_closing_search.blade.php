@extends('layouts.app')
@section('content')

    <!----calendar----->
    <link href="{{ asset('public/css/fullcalendar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/fullcalendar.print.min.css') }}" rel="stylesheet" media="print" />
    <script src="{{ asset('public/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/js/fullcalendar.min.js') }}"></script>
    <!---------------->

    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')



    <div class="calendar-wrap availibility-wrap">
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="calendar_filter"></div>
                </div>
            </div>
        </div>


    </div>

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 btn-left-shape ">
                <a href="{{ url('price-closing') }}" class="btn btn-default">{{trans('messages.keyword_back')}}</a>
            </div>
        </div>
    </div>



    <script src="{{asset('public/js/calander/locale-all.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#calendar_filter').fullCalendar({
                locale: "{{session('locale')}}",
                defaultView: 'list',
                header: {
                    left: 'prevYear,prev,today,next,nextYear',
                    center: 'title',
                    right: 'listWeek,month,agendaWeek,agendaDay'
                },
                fullDay: 'false',
                visibleRange: {
                    start: '{!! $start_date !!}',
                    end: '{!! $end_date !!}'+ 'T23:59:00'
                },
                navLinks: true, // can click day/week names to navigate views
                events: JSON.parse(JSON.stringify({!!  $filter_calendar !!})),
                dayClick: function(date, events, view) {
                    moment(date).format('MM/DD/YYYY h:mm A');
                }
            });

        });
    </script>

@endsection