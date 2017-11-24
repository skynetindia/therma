@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
    <script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
    <div class="hotel-options hotel-prices hotel-prices2"><?php
    if (isset($hotelDetails) && !empty($hotelDetails)) {
        echo Form::open(array('url' => '/hotel/update/roomnetprices' . "/" . $hotelDetails->id, 'files' => true, 'id' => 'frmNetPrices'));
    } 
    ?><input type="hidden" name="hotel_id" value="{{isset($hotelDetails->id) ? $hotelDetails->id : ''}}">
     <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
     <input type="hidden" name="season_id" value="{{isset($seasons->id) ? $seasons->id : '0'}}"><?php        
        $oldDataArray = array();   
        foreach ($room_net_prices as $keyold => $valueold) {
           $oldDataArray[$valueold->room_id][$valueold->is_extra_id] = $valueold->prices;
        }                
     ?>


    
                    <div class="section-border">
                                <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">netto price</a></li>
    <li><a data-toggle="tab" href="#menu1">sale price</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">    	
                                <div class="row">     
                              		<div class="col-md-12 col-sm1-12 col-xs-12">                                    	
                                        <div class="data-table">
							<div class="table-responsive">
                                    <table id="" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th rowspan="2">Room </th>
                <th rowspan="2">Placement</th>
                <th rowspan="2">Person</th>
                <th colspan="6">Meals</th>
            </tr>
            <tr>
            @foreach($hotelMeals as $kmeals => $vmeals)
                <th>{{$vmeals->name}}</th>
            @endforeach                
            </tr>
        </thead>     
        <tbody></tbody>
    </table>
    </div><?php pre($hotelRooms);?>
        <div class="table-responsive set-height">        
            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                <tbody>
                @foreach($hotelRooms  as $kroom => $vroom)
                <tr>
                	<td>{{(isset($vroom->typename) && $vroom->typename != "") ? $vroom->typename : $vroom->personal_name}}</td>
                    <td><?php $placement = ($vroom->child_count > 0) ? $vroom->child_count.' CHD' : '';
                             $placement .= ($vroom->adult_count > 0) ? ' + '.$vroom->adult_count.' ADL' : ''; 
                             echo ($placement != "") ? trim($placement) : 'ANY';
                    ?></td>
                    <td><?php 
                            $Person = ($vroom->child_count > 0) ? $vroom->child_count.' Adult' : '';
                            $Person .= ($vroom->adult_count > 0) ? ' + '.$vroom->adult_count.' Child' : ''; 
                            echo ($Person != "") ? trim($Person) : 'ANY';
                    ?><!--<i class="fa fa-files-o" aria-hidden="true"></i>--></td>
                    @foreach($hotelMeals as $kmeals => $vmeals)
                    <?php                                                                      
                        $mealprice = ($vroom->fare_amount != NULL && $vroom->fare_amount != 0) ? ($vroom->fare_amount * $vmeals->price) : $vmeals->price;
                        if(isset($oldDataArray[$vroom->id][0])){
                           $arrmealsprice = json_decode($oldDataArray[$vroom->id][0],true);                                                       
                           $mealprice = isset($arrmealsprice[$vmeals->id]) ? $arrmealsprice[$vmeals->id] : $mealprice;
                        }                         
                     ?>
                    <td><input type="text" name="meals[{{$vroom->id}}][{{$vmeals->id}}]" value="{{$mealprice}}" /></td>
                    @endforeach                    
                </tr>
                @if($vroom->room_extra_places != "")
                    @php                
                    $vroom->room_extra_places = trim($vroom->room_extra_places,",");
                    $arrExtraplaces = explode(",", $vroom->room_extra_places);                
                    @endphp

                    @foreach ($arrExtraplaces as $keyEP => $valueEP) 
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{isset($allPersonType[$valueEP]) ? 'Extra '.$allPersonType[$valueEP] : ''}}</td>
                        @foreach($hotelMeals as $kmeals => $vmeals)
                        <?php                                              
                        $extramealprice = ($vroom->fare_amount != NULL && $vroom->fare_amount != 0) ? ($vroom->fare_amount * $vmeals->price) : $vmeals->price;
                        if(isset($oldDataArray[$vroom->id][$valueEP])){
                           $arrmealsprice = json_decode($oldDataArray[$vroom->id][$valueEP],true);
                           $extramealprice = isset($arrmealsprice[$vmeals->id]) ? $arrmealsprice[$vmeals->id] : $extramealprice;
                        }                         
                        ?><td><input type="text" name="extrameals[{{$vroom->id}}][{{$valueEP}}][{{$vmeals->id}}]" value="{{$extramealprice}}" /></td>
                        @endforeach                    
                    </tr>
                    @endforeach
                @endif
                @endforeach                
                </tbody>
            </table>
            </div>
        </div>                                        
    </div>
</div>  
<div class="button-blk-price">
	<a href="{{url('hotel/season/').'/'.$hotelDetails->id}}" class="btn btn-danger btn-6-12">Cancel</a>	  
    <button type="submit" class="btn btn-default btn-6-12">{{trans('messages.keyword_proceeds')}}</button>                                      
</div>
</div>
<div id="menu1" class="tab-pane fade"><?php 
    $oldSaleDataArray = array();
    $discount = 0;   
    foreach ($room_sale_prices as $keyold => $valueold) {
       $oldSaleDataArray[$valueold->room_id][$valueold->is_extra_id] = $valueold->prices;
       $discount = ($valueold->discount != null) ? $valueold->discount : 0;
    }            
    ?><div class="row">     
  		<div class="col-md-12 col-sm1-12 col-xs-12">        	
            <div class="record-list"><p>Sale to netto discount($):  <input type="text" id="discount" value="{{$discount}}" name="discount" /></p></div>            
            <div class="data-table">
                <div class="table-responsive">
                    <table id="" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th rowspan="2">Room </th>
                            <th rowspan="2">Placement</th>
                            <th rowspan="2">Person</th>
                            <th colspan="6">Meals</th>
                        </tr>
                        <tr>
                        @foreach($hotelMeals as $kmeals => $vmeals)
                        <th>{{$vmeals->name}}</th>
                        @endforeach                
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive set-height">        
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <tbody>
                @foreach($hotelRooms  as $kroom => $vroom)
                <tr>
                    <td>{{(isset($vroom->typename) && $vroom->typename != "") ? $vroom->typename : $vroom->personal_name}}</td>
                    <td><?php $saleplacement = ($vroom->child_count > 0) ? $vroom->child_count.' CHD' : '';
                             $saleplacement .= ($vroom->adult_count > 0) ? ' + '.$vroom->adult_count.' ADL' : ''; 
                             echo ($saleplacement != "") ? trim($saleplacement) : 'ANY';
                    ?></td>
                        <td><?php 
                        $salePerson = ($vroom->child_count > 0) ? $vroom->child_count.' Adult' : '';
                        $salePerson .= ($vroom->adult_count > 0) ? ' + '.$vroom->adult_count.' Child' : ''; 
                        echo ($salePerson != "") ? trim($salePerson) : 'ANY';
                    ?><!--<i class="fa fa-files-o" aria-hidden="true"></i>--></td>
                    @foreach($hotelMeals as $kmeals => $vmeals)
                    <?php                                                                      
                        $salemealprice = ($vroom->fare_amount != NULL && $vroom->fare_amount != 0) ? ($vroom->fare_amount * $vmeals->price) : $vmeals->price;
                        if(isset($oldSaleDataArray[$vroom->id][0])){
                           $arrmealsprice = json_decode($oldSaleDataArray[$vroom->id][0],true);                                                       
                           $salemealprice = isset($arrmealsprice[$vmeals->id]) ? $arrmealsprice[$vmeals->id] : $salemealprice;
                        }                         
                     ?>
                    <td><input type="text" class="sales_meals_value" name="salemeals[{{$vroom->id}}][{{$vmeals->id}}]" value="{{$salemealprice}}" /></td>
                    @endforeach                    
                </tr>
                @if($vroom->room_extra_places != "")
                    @php                
                    $vroom->room_extra_places = trim($vroom->room_extra_places,",");
                    $arrExtraplaces = explode(",", $vroom->room_extra_places);                
                    @endphp

                    @foreach ($arrExtraplaces as $keyEP => $valueEP) 
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{isset($allPersonType[$valueEP]) ? 'Extra '.$allPersonType[$valueEP] : ''}}</td>
                        @foreach($hotelMeals as $kmeals => $vmeals)
                        <?php                                              
                        $saleextramealprice = ($vroom->fare_amount != NULL && $vroom->fare_amount != 0) ? ($vroom->fare_amount * $vmeals->price) : $vmeals->price;
                        if(isset($oldSaleDataArray[$vroom->id][$valueEP])){
                           $arrmealsprice = json_decode($oldSaleDataArray[$vroom->id][$valueEP],true);
                           $saleextramealprice = isset($arrmealsprice[$vmeals->id]) ? $arrmealsprice[$vmeals->id] : $saleextramealprice;
                        }                         
                        ?><td><input type="text" class="sales_meals_value" name="saleextrameals[{{$vroom->id}}][{{$valueEP}}][{{$vmeals->id}}]" value="{{$saleextramealprice}}" /></td>
                        @endforeach                    
                    </tr>
                    @endforeach
                @endif
                @endforeach                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!--<div class="button-blk-price">
	<a href="hotel-prices1.html" class="btn btn-danger btn-6-12">cancel</a>
</div>-->                                      
</div>
</div>
</div>
<?php echo Form::close(); ?>
</div>
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
<script type="application/javascript">
$('#discount').on('change', function (row, tr, el) {
    var discount =$(this).val();
    $(".sales_meals_value").each(function( index ) {
        var newval = ($(this).val() - discount);
        $(this).val(newval);
        //console.log( index + ": " + $( this ).value() );
    });        
});
// validations
$(document).ready(function () {
    $("#add_season_form").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50
            }
        },
        messages: {
            name: {
                required: "{{trans('messages.keyword_please_enter_name')}}",
                maxlength: "{{trans('messages.keyword_hotel_name_must_be_less_than_50_characters')}}"
            }
        }
    });
});     
var selezione;
var indici;
var n = 0;

/*  
$('#table').on('click-row.bs.table', function (row, tr, el) {
    var cod = $(el[0]).children()[1].innerHTML;
    if (!selezione) {
        $('#table tr.selected').removeClass("selected");
        $(el[0]).addClass("selected");
        selezione = cod;
        indici = cod;
        n++;

    } else {
        $(el[0]).removeClass("selected");
        selezione = undefined;
        n--;
        $('#table tr.selected').removeClass("selected");
        $(el[0]).addClass("selected");
        selezione = cod;
        indici = cod;
        n++;

    }
});*/
</script>
@endsection
