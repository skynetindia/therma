@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
<script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="ssetting-wrap">
  <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">	
    	<div class="table-btn">
      	<a href="{{url('language/add/translation')}}" class="btn btn-add"><i class="fa fa-plus"></i></a>
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
           	<h1 class="cst-datatable-heading">{{trans('messages.keyword_language_phrases')}} : {{ $language->name }}</h1>
           	<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('language/translation/json').'/'.$code;?>" data-classes="table table-bordered" id="table">
              <thead>
                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                <th data-field="language_label" data-sortable="true">{{trans('messages.keyword_language_label')}}</th>
                <th data-field="language_value" data-sortable="true">{{trans('messages.keyword_language_phase')}}</th>
                <th data-field="language_key" data-sortable="true">{{trans('messages.keyword_phrase_key')}}</th>
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
	var cod = $(el[0]).children()[0].innerHTML;
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


function check() {
	return confirm("Are you sure you want to delete language phrase?");
}
function multipleAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
        var error = false;
		switch(act) {
			case 'delete':                                
				link.href = "{{ url('/language/translation/delete') }}" + '/';
				if(check() && n!= 0) {
                        for(var i = 0; i < n; i++) {                            
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/language/translation/delete') }}" + '/' + indici[n];
                                        link.dispatchEvent(clickEvent);
                                        error = true;
                                    }
                                }                                
                            });
                        }                        
                        selezione = undefined;
                        if(error === false)
                            setTimeout(function(){location.reload();},100*n);
							
						n = 0;
                    }					
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/language/modify/translation') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
		}
}

</script> 

@endsection	