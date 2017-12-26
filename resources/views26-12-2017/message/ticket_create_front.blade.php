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

    {{ Form::open(array('url' => '/ticket/store', 'files' => true, 'id' => 'message_support_edit_form')) }}
    <input type="hidden" name="support_id" value="{{ isset($support->id) ? $support->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">


    <div class="message-wrap ticket-wrap">


        <div class="section-border">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">Ticket Create Front Side</h1>
                    <hr>
                </div>
            </div>



            <div class="form-group">
                <label for=""> Ticket ID <span class="required">(*)</span></label>
                <input type="text" class="form-control" id="" name="unique_ticket" placeholder="" value="{{ isset($support->unique_ticket) ? $support->unique_ticket : generateTicketId() }}" readonly>
            </div>

            <div class="form-group">
                <label>Subject <span class="required">(*)</span></label>
                <input type="text" name="subject" id="" class="form-control">
            </div>


            <div class="form-group">
                <label>URL <span class="required">(*)</span></label>
                <input type="text" name="url" id="" class="form-control">
            </div>


            <div class="form-group">
                <label>Description <span class="required">(*)</span></label>
                <textarea class="form-control" name="description"></textarea>
            </div>

            <div class="form-group form-control-file">
                <label for="">@lang('messages.keyword_upload_file'):</label>
                <input name="image" class="" id="" type="file">
            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-default">@lang('messages.keyword_send')</button>
                    <a href="{{ url('message/support') }}" class="btn btn-reject btn-cancel">@lang('messages.keyword_cancel')</a>
                </div>
            </div>


        </div>


    </div>

    {{ Form::close() }}





    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>


    <script>

        $(document).ready(function () {

            $('#created_at').datepicker({
                format: "yyyy-mm-dd",
                endDate: '+30d',
            }).datepicker();

        });


        $( "#message_support_edit_form" ).validate({
            rules: {
                support_id: {
                    required: true
                },
                created_at: {
                    required: true
                },
                description: {
                    required: true
                }

            },
            messages: {
                support_id: {
                    required: "@lang('messages.keyword_please_enter_support_id')"
                },
                created_at: {
                    required: "@lang('messages.keyword_please_select_date')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                }
            }
        });




        function updateSupportStatus(id) {
            var url = "{{ url('message/support/changeactivestatus') }}"  + '/';
            var status = '1';
            if ($("#activestatus_" + id).is(':checked')) {
                status = '0';
            }
            $.ajax({
                type: "GET",
                url: url + id + '/' + status,
                error: function (url) {
                },
                success: function (data) {
                    /*$(".currencytogal").prop('checked',false);
                    $(".currencytogal").prop('disabled',false);*/
                    //$("#activestatus_"+id).prop('checked',true);
                    /*$("#activestatus_"+id).prop('disabled',true);*/
                }
            });
        }

    </script>


@endsection



