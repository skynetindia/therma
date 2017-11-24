@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')




    <div class="allotment-wrap">
        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">Junior Suite</h1>
                            <table id="" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th rowspan="2"></th>
                                    <th colspan="12">9/2017</th>
                                    <th colspan="5">10/2017</th>
                                </tr>
                                <tr>


                                    <th>26</th>
                                    <th>27</th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>01</th>
                                    <th>02</th>
                                    <th>03</th>
                                    <th>04</th>
                                    <th>05</th>
                                    <th>06</th>
                                    <th>07</th>
                                    <th>08</th>
                                    <th>09</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>Giorno</td>


                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>

                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </td>

                                </tr>


                                <tr>
                                    <td>Aperto</td>


                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>

                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </td>

                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="section-border">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="data-table">
                        <div class="table-responsive">
                            <h1 class="cst-datatable-heading">Suite</h1>


                            <table id="" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th rowspan="2"></th>
                                    <th colspan="12">9/2017</th>
                                    <th colspan="5">10/2017</th>
                                </tr>
                                <tr>


                                    <th>26</th>
                                    <th>27</th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>01</th>
                                    <th>02</th>
                                    <th>03</th>
                                    <th>04</th>
                                    <th>05</th>
                                    <th>06</th>
                                    <th>07</th>
                                    <th>08</th>
                                    <th>09</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>Giorno</td>


                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>

                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </td>

                                </tr>


                                <tr>
                                    <td>Aperto</td>


                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="yellow-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="green-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/right-check-allot.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>

                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>

                                        </div>
                                        <input type="text" class="form-control"/>
                                    </td>
                                    <td class="red-bg">
                                        <div class="selectBox" value="en">

                                            <span class="selected"><img src="images/delete-close.png" width="30"
                                                                        height="30"></span>
                                            <span class="selectArrow"><i class="fa fa-caret-down"
                                                                         aria-hidden="true"></i></span>

                                            <div class="selectOptions">
                                                <span class="selectOption"><img src="images/delete-close.png" width="30"
                                                                                height="30"></span>
                                            </div>
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </td>

                                </tr>


                                </tbody>
                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <script>
        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('fa fa-chevron-down fa fa-chevron-up');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    </script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            $('#example1 , #example2').datepicker({
                format: "dd-mm-yyyy",
                daysOfWeekDisabled: [0],
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
            }).datepicker();

        } );
    </script>


@endsection




