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
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>


        </div>


    <script src="{{asset('public/js/calander/locale-all.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                locale: "{{session('locale')}}",
                header: {
                    left: 'prevYear,prev,today,next,nextYear',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                navLinks: true, // can click day/week names to navigate views
                events: '{{ url('price-closing/get/booking') }}',
                {{--eventRender: function (events, element) {--}}
                    {{--element.attr('href', '{{ url('booking') }}');--}}
                {{--},--}}
                dayClick: function(date, events, view) {
                    moment(date).format('MM/DD/YYYY h:mm A');
                }
            });

        });
    </script>

@endsection