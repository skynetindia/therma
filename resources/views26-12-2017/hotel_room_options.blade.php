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


    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item  " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item"
                            id="fourthst"></li>
                        <li class="navigation-item " id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                        <li class="navigation-item" id="nine"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


        <div class="wizard-wrap">
            <div class="section-border">

                <div class="wizard-date-picker">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group inline-block"><label>Date from - a</label></div>
                            <div class="form-group inline-block">
                                <input type="text" class="form-control" id="example1" placeholder="Select Date"/>
                            </div>
                            <div class="inline-block">-</div>
                            <div class="form-group inline-block">
                                <input type="text" class="form-control" id="example2" placeholder="Select Date"/>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12"><div class="text-center"><a href="#">Add another date</a></div></div>
                    </div>


                </div>

                <div class="wizard-table">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <!--
                                <div class="table-btn">
                                    <a href="add-form.html" class="btn btn-add"><i class="fa fa-plus"></i></a>
                                    <a href="#" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="#" class="btn btn-delete"><i class="fa fa-trash"></i></a>
                                </div>
                            -->
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Superior double room <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                        <th>Suite <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>State</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group"><select class="form-control">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>--></div></div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group"><select class="form-control">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>--></div></div></td>
                                    </tr>


                                    <tr>
                                        <td>Number of rooms</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>Release</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>Minimum length of stay</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>-->
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>Requires paper</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group"><select class="form-control">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>--></div></div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group"><select class="form-control">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select><!--<div class="pull-right-fa-times"><i class="fa fa-times" aria-hidden="true"></i></div>--></div></div></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>



                            <div class="table-responsive">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Age 18 and older</th>
                                        <th>Single room confort<!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                        <th>Suite <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>FB - bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>FB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>FB - SGL use</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB - SGL use</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>




                            <div class="table-responsive">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Age 12 to 17 years</th>
                                        <th>Standard Double Room <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                        <th>Suite <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>FB - bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>FB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Age 3 to 11 years</th>
                                        <th>double room "comfort" <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                        <th>Suite <!--<i class="fa fa-times" aria-hidden="true"></i>--></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>FB - bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB bed base</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>FB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    <tr>
                                        <td>HB - extra bed</td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                        <td><div class="click-for-setting">
                                                <!--<div class="setting"><a href="#">click for settings</a></div>-->
                                                <div class="form-group">
                                                    <input class="form-control"/><div class="pull-right-fa-times"><span>€</span><!--<i class="fa fa-times" aria-hidden="true"></i>--></div>
                                                </div>
                                            </div></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                </div>



                <div class="wizard-btn">
                    <button class="btn btn-default  btn-6-12">save changes</button>
                    <button class="btn btn-default  btn-6-12">save changes and view editor</button>
                </div>


                <div class="btn-shape">

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('hotel/edit/room-details').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                        <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><a href="{{ url('hotel/edit/amenities').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_next')</a></div>
                    </div>

                </div>



            </div>
        </div>
    </div>



@endsection
