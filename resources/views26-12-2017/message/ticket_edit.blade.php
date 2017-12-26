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

    {{ Form::open(array('url' => 'myticket/update', 'files' => true, 'id' => 'ticket_edit_form')) }}
    <input type="hidden" name="support_id" value="{{ isset($support->id) ? $support->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">


    <div class="message-wrap ticket-wrap">

        <div class="section-border">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">@lang('messages.keyword_support')</h1>
                    <hr>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">@lang('messages.keyword_support_id') <span class="required">(*)</span></label>
                        <input type="text" class="form-control" id="" name="unique_ticket" placeholder="@lang('messages.keyword_support_id')" value="{{ isset($support->unique_ticket) ? $support->unique_ticket : generateTicketId() }}" readonly>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">@lang('messages.keyword_created_at') <span class="required">(*)</span></label>
                        <input class="form-control" id="created_at" placeholder="@lang('messages.keyword_created_at')" value="{{ isset($support->created_at) ? $support->created_at : '' }}"
                               required="" type="text" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p><b>@lang('messages.keyword_subject') : </b> {{ $support->subject }}</p>
                    <p><b>@lang('messages.keyword_url') : </b> <a href="{{ $support->url }}" target="_blank">{{ $support->url }}</a></p>
                </div>
            </div>


            {{--{{ getSupportReply($support->id) }}--}}
            <hr>
            <div class="ticket-chat">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">

                            <div class="">
                                <ul class="list-unstyled chat">

                                    @forelse(getSupportReply($support->id) as $chat)
                                        <?php $user = getUserWithId($chat->user_id); ?>
                                        <li class="left clearfix">
                                            <span class="chat-img pull-left"><img src="{{ asset('public/images/user')."/".$user->image }}" alt="User Avatar" class="img-circle"></span>
                                            <div class="chat-body clearfix {{ ($chat->replied_by_admin == '1') ? 'admin-comment' : '' }}">
                                                <div class="header">

                                                    <strong class="primary-font">{{ $user->name }}</strong>
                                                    <small class="pull-right text-muted">
                                                        <span class="glyphicon glyphicon-time"></span> {{ \Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <p>{{ $chat->description }} </p>
                                                @if(isset($chat->image) && !empty($chat->image))
                                                    <span><a href="{{ asset('public/images/support')."/".$chat->image }}" target="_blank" class="" download><i class="fa fa-download"></i> {{ $chat->image }}</a></span>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <li class="left clearfix">
                                            <div class="chat-body clearfix">
                                                @lang('messages.keyword_no_conversations_found')
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <hr>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>@lang('messages.keyword_reply_to_user') <span class="required">(*)</span></label>
                        <textarea class="form-control" name="description" placeholder="@lang('messages.keyword_description')">{{ isset($support->description) ? $support->description : '' }}</textarea>
                    </div>
                </div>
            </div>


            <div class="form-group form-control-file">
                <label for="">@lang('messages.keyword_upload_file'):</label>
                <input name="image" class="" id="" type="file">
            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-default">@lang('messages.keyword_send')</button>
                    <a href="{{ url('mytickets') }}" class="btn btn-reject btn-cancel">@lang('messages.keyword_cancel')</a>
                </div>
            </div>


        </div>


    </div>

    {{ Form::close() }}


@endsection



