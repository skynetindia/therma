@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')



        <div class="calendar-wrap allotment-wrap">
            <div class="section-border">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="data-table">
                            <div class="table-responsive">
                                <h1 class="cst-datatable-heading">Spa Hotel Terme Milano</h1>
                                <table id="" class="table table-striped table-bordered" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th rowspan="2"></th>
                                        <th colspan="19">9/2017</th>
                                        <th colspan="12">10/2017</th>
                                    </tr>
                                    <tr>

                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                        <th>19</th>
                                        <th>20</th>
                                        <th>21</th>
                                        <th>22</th>
                                        <th>23</th>
                                        <th>24</th>
                                        <th>25</th>
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
                                        <td>Dvoulůžkový pokoj "superior"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    <tr>
                                        <td>Jednolůžkový pokoj "superior"</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                    </tr>

                                    <tr>
                                        <td>Dvoulůžkový pokoj "standard"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
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
                                <h1 class="cst-datatable-heading">Spa Hotel Terme Venezia</h1>
                                <table id="" class="table table-striped table-bordered" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th rowspan="2"></th>
                                        <th colspan="19">9/2017</th>
                                        <th colspan="12">10/2017</th>
                                    </tr>
                                    <tr>

                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                        <th>19</th>
                                        <th>20</th>
                                        <th>21</th>
                                        <th>22</th>
                                        <th>23</th>
                                        <th>24</th>
                                        <th>25</th>
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
                                        <td>Dvoulůžkový pokoj "superior"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    <tr>
                                        <td>Jednolůžkový pokoj "superior"</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="yellow-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                        <td class="red-bg">0</td>
                                    </tr>

                                    <tr>
                                        <td>Dvoulůžkový pokoj "deluxe"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    <tr>
                                        <td>Dvoulůžkový pokoj "comfort"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    <tr>
                                        <td>Dvulůžkový pokoj "estasi"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    <tr>
                                        <td>Jednolůžkový pokoj "comfort"</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">9</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="green-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                        <td class="red-bg">10</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

@endsection