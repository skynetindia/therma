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


        <div class="step-page"><div class="row">
                <div class="col-md-12">
                    <div class="navigation-root">
                        <ul class="navigation-list">
                            <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                            <li class="navigation-item  navigation-previous-item" id="secondst"></li>
                            <li class="navigation-item  navigation-previous-item" id="thirdst"></li>
                            <li class="navigation-item  navigation-previous-item" id="fourthst"></li>
                            <li class="navigation-item   navigation-previous-item" id="fifthst"></li>
                            <li class="navigation-item   navigation-previous-item navigation-active-item" id="sixthst"></li>
                            <li class="navigation-item" id="seven"></li>
                            <li class="navigation-item" id="eight"></li>
                            <li class="navigation-item" id="nine"></li>
                        </ul>
                    </div>
                </div>
            </div></div>

        <div class="extra-wrap">


            <div class="amenities-wrap">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <div class="lft-side-amenities">

                            <div class="section-border">

                                <div class="bg-grey-amenities">
                                    <div class="heading-amenities">Extra 1</div>

                                    <div class="row bg-grey">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Tueco 3 Cure</p>
                                            <span>Active</span>
                                            <div class="switch"><input value="" name="" id="switch1" type="checkbox"><label for="switch1"></label></div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <textarea placeholder="Enter Description"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="extra-detail">
                                                <div class="inline-block">Prezzo listino</div>
                                                <div class="">50 <i class="fa fa-eur" aria-hidden="true"></i></div>
                                            </div>
                                            <div class="extra-detail">
                                                <div class="inline-block">Sconto</div>
                                                <div class="">10 %</div>
                                            </div>
                                            <div class="extra-detail">
                                                <div class="inline-block">Numero massimo</div>
                                                <div class="">9</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 6 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 9 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 12 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 7 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 8 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <p class="">Turco 20 Cure</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">

                                        </div>
                                    </div>

                                </div>
                            </div>




                        </div>
                    </div>



                    <div class="col-md-6 col-sm-12 col-xs-12">


                        <div class="section-border">

                            <div class="bg-grey-amenities">
                                <div class="heading-amenities">Extra 2</div>

                                <div class="row bg-grey">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">sauna 3 Cure</p>
                                        <span>Active</span>
                                        <div class="switch"><input value="" name="" id="switch2" type="checkbox"><label for="switch2"></label></div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <textarea placeholder="Enter Description"></textarea>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="extra-detail">
                                            <div class="inline-block">Prezzo listino</div>
                                            <div class="">50 <i class="fa fa-eur" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="extra-detail">
                                            <div class="inline-block">Sconto</div>
                                            <div class="">10 %</div>
                                        </div>
                                        <div class="extra-detail">
                                            <div class="inline-block">Numero massimo</div>
                                            <div class="">9</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna 6 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna 9 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna 42 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna 97 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna 2 + 2 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <p class="">Sauna + Turco 25 Cure</p>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>

                </div>
            </div>


            <div class="btn-shape">

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('hotel/edit/amenities').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><a href="{{ url('hotel/edit/media').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_next')</a></div>
                </div>

            </div>


        </div>

    </div>


@endsection