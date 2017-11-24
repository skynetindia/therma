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

     {{ Form::open(array('url' => '/user/profile/update', 'files' => true, 'id' => 'update_profile_form')) }}

        <input type="hidden" name="userid" value="{{ isset($user->id) ? $user->id : '' }}">

        <div class="user-profile-wrap">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="user-profile-heading">Manage profile</h1>
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="user-profile">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="user-profile-img">
                            <input type="hidden" name="name" value="{{ isset($user->name) ? $user->name : '' }}">
                            <h4>{{ ucfirst($user->name) }}</h4><hr>
                            @if(isset($user->image))
                                <img src="{{ asset('public/images/user')."/".$user->image }}" class="thumbnails" alt="{{ $user->name }}" width="150px">
                            @endif

                        </div>
                    </div>
                    <div class="col-md-10 col-sm-12 col-xs-12">
                        <div class="user-form row">

                                <div class="col-md-4 col-sm-12 col-xs-12">


                                    <div class="form-group form-control-file">
                                        <label for="">@lang('messages.keyword_upload_image')</label>
                                        <input type="hidden" name="old_image" value="{{ isset($user->image) ? $user->image : '' }}">
                                        <input type="file" name="image" class="" id="">
                                    </div>



                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_profile_type')</label>
                                        <input type="text" name="profile_id" value="{{ isset($user->id) ? getUserTypesById($user->id) : '' }}" class="form-control disabled" id=""
                                               readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_phone_number') <span class="required">(*)</span></label>
                                        <input type="text" name="phone" value="{{ isset($user->phone) ? $user->phone : '' }}"  class="form-control" id=""
                                               placeholder="Enter Phone Number">
                                    </div>

                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.keyword_email') <span class="required">(*)</span></label>
                                        <input type="email" name="email" value="{{ isset($user->email) ? $user->email : '' }}"  class="form-control" id=""
                                               placeholder="example@email.com">
                                    </div>

                                    <div class="text-right">
                                        <input type="submit" class="btn btn-default" value="Submit">
                                    </div>


                                </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{ Form::close() }}



    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>



        $( "#update_profile_form" ).validate({
            rules: {
                image: {
                    extension: "jpeg|jpg|png|gif"
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                image: {
                    extension: "@lang('messages.keyword_please_choose_valid_extension')"
                },
                phone: {
                    required: "@lang('messages.keyword_please_enter_number')"
                },
                email: {
                    required: "@lang('messages.keyword_please_enter_an_email')",
                    email: "@lang('messages.keyword_please_enter_valid_email')"
                }
            }
        });
    </script>
@endsection
