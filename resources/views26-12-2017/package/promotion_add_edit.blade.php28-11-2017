@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function(){
            $("#phone").mask("(999) 999-9999");
        });
    </script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages(); ?>
    {{ Form::open(array('url' => '/promotion/update', 'files' => true, 'id' => 'promotion_edit_form')) }}

    <input type="hidden" name="promotion_id" value="{{ isset($promotion->id) ? $promotion->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{--Content--}}
    <div class="promotion-wrap promotion-detail">



            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1 class="user-profile-heading">promotions</h1>
                        <hr/>
                        <form>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="promotion-head">What's the name of your promotion ?</label>
                                        <input type="text" class="form-control" placeholder="Enter promotion name here"/>
                                        <span class="gry-clr"> <div class="inline-block show-tip"><i class="fa fa-info-circle" aria-hidden="true"></i> <div class="tip-hide">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever</div></div> This name is just for your reference. It won't be displayed to customers browsing</span>
                                    </div>
                                </div>
                            </div>

                            <div class="promition">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="promotion-head">what type of promotion is it?</label>
                                    </div>

                                    @foreach(getPromotionsType() as $type)
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="promotion-box">
                                                <img src="{{ asset('public/images/promotions')."/".$type->image }}"/>
                                                <p class="blue">{{ $type->type }}</p>
                                                <p class="gry-clr">{{ $type->short_description }}</p>
                                                <div class="promotion-foote">
                                                    {!! $type->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>


                            <div class="promition">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="promotion-head">who will see this promotion?</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="promotion-box">
                                            <img src="{{ asset('public/images/promotions/everyone.png') }}"/>
                                            <p class="blue">everyone</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="promotion-box">
                                            <img src="{{ asset('public/images/promotions/secreal-deal.png') }}"/>
                                            <p class="blue">Member and newletter subscribers only</p>
                                            <span class="gry-clr">secret-deal</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="promotion-head">How long do guests need to stay to get this promotion?</label>
                                        <span>guest need to stay for at least <select class="form-control inline-block"><option>Match Your chosen rate</option><option>demo</option></select> night to get this promotion. <div class="inline-block show-tip"><i class="fa fa-info-circle" aria-hidden="true"></i> <div class="tip-hide">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever</div></div>
</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="promotion-head">How much of a discount do you want to give?</label>
                                        <input type="text" class="form-control inline-block" value="10" required/>
                                        <select class="form-control inline-block">
                                            <option>demo</option><option>1</option><option>2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="promotion-head">Which rates?</label>
                                        <p>The discount will be deducted from the rate(s) you select here.</p>
                                        <div class="ryt-chk">
                                            <input id="chk-without-info" type="checkbox">
                                            <label for="chk-without-info">Standard Rate</label></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group promition-room">
                                        <label class="promotion-head">Which rooms?</label>
                                        <p>The discount will be applied to the room(s) you select</p>
                                        <p>Make sure you select at least one rate in the section above so the choice of rooms will show.</p>
                                        <div class="ryt-chk">
                                            <input id="chk-without-info1" type="checkbox">
                                            <label for="chk-without-info1">Crystal rooms</label></div>
                                        <div class="ryt-chk">
                                            <input id="chk-without-info2" type="checkbox">
                                            <label for="chk-without-info2">Royal rooms</label></div>
                                        <div class="ryt-chk">
                                            <input id="chk-without-info3" type="checkbox">
                                            <label for="chk-without-info3">Signature rooms</label></div>
                                        <div class="ryt-chk">
                                            <input id="chk-without-info4" type="checkbox">
                                            <label for="chk-without-info4">Presidential rooms</label></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="promotion-head">When can guests stay using the discounted rate?</label>
                                        <p>your discount will apply to stay on the following date(s): <span class="btn btn-default-border" id="example1">Resent dates</span></p>
                                    </div>
                                </div>
                            </div>



                            <div class="advanced-settings-promotion">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="fa fa-caret-down" aria-hidden="true"></i> Show advanced settings</a>
                                                    <p class="pull-right inline-block">You can still set up a promotion <br/> without these settings</p>
                                                </h4>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse">

                                                <div class="panel-body">

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group promition-room">
                                                                <label class="promotion-head">Non-refundable promotion</label>
                                                                <div class="ryt-chk">
                                                                    <input id="chk-without-info5" type="checkbox">
                                                                    <label for="chk-without-info5">Add a non-refundable policy and decrease cancellations.</label></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="promotion-head">When can guests see this promotion on therma?</label>
                                                                <p>Guest can see this promotion on the following dates: <span class="btn btn-default-border" id="example2">Resent dates</span></p>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group promition-room">
                                                                <label class="promotion-head">Set the timing for your promotion</label>
                                                                <div class="ryt-chk">
                                                                    <input id="chk-without-info6" type="checkbox">
                                                                    <label for="chk-without-info6">Limit your promotion to the following hours, based on your local time</label></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group promition-detail-date">
                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                                        <input type="text" id="example3" placeholder="30/10/2017" class="form-control"/>
                                                                    </div>

                                                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                                                        <span>to</span>
                                                                    </div>

                                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                                        <input type="text" id="example4" placeholder="30/10/2017" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group promition-room">
                                                                <label class="promotion-head">No credit card required</label>
                                                                <div class="ryt-chk">
                                                                    <input id="chk-without-info7" type="checkbox">
                                                                    <label for="chk-without-info7">A creadit card will not be required for this promotion. (This helps to increase, by making booking easier and faster)</label></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <button class="btn btn-default btn-6-12">Save</button>
                                <button class="btn btn-default btn-reject btn-6-12">Back</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    {{--Content--}}

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('promotions') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>

        $( "#promotion_edit_form" ).validate({
            rules: {
                code: {
                    required: true
                },
                name: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                description: {
                    required: true
                },
                updated_at: {
                    required: true
                }
            },
            messages: {
                code: {
                    required: "@lang('messages.keyword_please_enter_a_code')"
                },
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                price : {
                    required: "@lang('messages.keyword_please_enter_a_price')",
                    number: "@lang('messages.keyword_please_enter_valid_price')"
                },
                description: {
                    required: "@lang('messages.keyword_please_enter_a_description')"
                },
                updated_at: {
                    required: "@lang('messages.keyword_please_select_date')"
                }
            }
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#updated_at').datepicker({
                format: "yyyy-mm-dd",
            }).datepicker();
        });
    </script>
@endsection
