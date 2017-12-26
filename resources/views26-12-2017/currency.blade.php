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
<div class="ssetting-wrap currencies-wrap">
  <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">	
    	<div class="table-btn">
        <a href="javascript:void(0);" onclick="multipleAction('add');" class="btn btn-add"><i class="fa fa-plus"></i></a>
        <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
      </div>
    </div>
  </div>
  <div class="section-border">   
   <div class="row">
   	<div class="col-md-12 col-sm-12 col-xs-12">		    
   		<div class="data-table">
        <div class="table-responsive">
          <h1 class="cst-datatable-heading">{{trans('messages.keyword_currency')}}</h1>
          <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="currency/json" data-classes="table table-bordered" id="table">
            <thead>
            <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
            <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
            <th data-field="code" data-sortable="true">{{trans('messages.keyword_code')}}</th>
            <th data-field="symbol" data-sortable="true">{{trans('messages.keyword_symbol')}}</th>
            <th data-field="status" data-sortable="true">{{trans('messages.keyword_active')}}</th>
            </thead>
            </table>
        </div>
      </div>
    </div>
  </div>      
</div>
</div>   
<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
  var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
  if (!selezione[cod]) {
    $('#table tr.selected').removeClass("selected");       
    $(el[0]).addClass("selected");
    selezione[cod] = cod;
    indici[n] = cod;
    n++;
  } else {
    $(el[0]).removeClass("selected");
    selezione[cod] = undefined;
    for(var i = 0; i < n; i++) {
      if(indici[i] == cod) {
        for(var x = i; x < indici.length - 1; x++)
          indici[x] = indici[x + 1];
        break;  
      }
    }
    n--;
    $('#table tr.selected').removeClass("selected");       
    $(el[0]).addClass("selected");
    selezione[cod] = cod;
    indici[n] = cod;
    n++;
  }
});
function check() { return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} " + n + " {{trans('messages.keyword_currency')}}?"); }
 function updateTaxionStatus(id){
        var url = "{{ url('/currency/changestatus') }}" + '/';
        var status = '1';
        if ($("#activestatus_"+id).is(':checked')) {
            status = '0';
        }
        $.ajax({
            type: "GET",
            url: url + id +'/'+status,
            error: function (url) {                
            },
            success:function (data) { 
				$(".currencytogal").prop('checked',false);
            	$(".currencytogal").prop('disabled',false);
            	$("#activestatus_"+id).prop('checked',true);
            	$("#activestatus_"+id).prop('disabled',true);            
            }
         });
    }
function multipleAction(act) {
  var error = false;
  var link = document.createElement("a");
  var clickEvent = new MouseEvent("click", {
      "view": window,
      "bubbles": true,
      "cancelable": false
  });
  switch(act) {
    case 'delete':
      link.href = "{{ url('/currency/delete/') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/currency/delete/') }}" + '/' + indici[n];
                link.dispatchEvent(clickEvent);
              } 
            }
          });
        }
        selezione = undefined;
        setTimeout(function(){location.reload();},100*n);
        n = 0;
       }
      break;
    case 'modify':
         if(n!=0) {
          n--;
          link.href = "{{ url('/currency/add/') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
    case 'add':             
          link.href = "{{ url('/currency/add/') }}";
          link.dispatchEvent(clickEvent);        
      break;
    }
}
</script>
@endsection	