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

    {{ Form::open(array('url' => 'user/update_password', 'files' => true, 'id' => 'update_password_form')) }}

        <div class="user-profile-wrap change-passowrd-wrap">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">Change Password</h1>
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="user-profile change-pass">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="userid" value="{{ $user->id }}">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_old_password')</label>
                                        <input type="password" name="old_password" id="old_password" onkeyup="checkPassword(this)" class="form-control" id=""
                                               placeholder="Enter Current Password" required>
                                        <span id="password_response"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_new_password')</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="Enter New Password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_confirm_password')</label>
                                        <input type="password" class="form-control" name="confirm_password" id=""
                                               placeholder="Enter Confirm Password" required>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-default" type="submit" id="change_password_button">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>


    {{ Form::close() }}


    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>




        $( "#update_password_form" ).validate({
            rules: {
                old_password: "required",
                password: "required",
                confirm_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                old_password: {
                    required: "@lang('messages.keyword_please_enter_old_password')",
                }
            }
        });

    </script>
@endsection
