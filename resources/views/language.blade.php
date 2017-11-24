@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-table.min.css') }}">
<script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
<div class="ssetting-wrap">
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">	
           	<div class="table-btn">
                <a href="{{ url('/modify/language') }}" class="btn btn-add"><i class="fa fa-plus"></i></a>
                <a href="javascript:void(0);" onclick="multipleAction('modify');" class="btn btn-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="javascript:void(0);" onclick="multipleAction('delete');" class="btn btn-delete"><i class="fa fa-trash"></i></a>
                <!--<a href="{{ url('/language/add/translation') }}" class="btn btn-add">Add phrases</a>-->
                <a href="javascript:void(0);" onclick="multipleAction('updatePhase');" class="btn btn-add">{{trans('messages.keyword_phrases')}}</a>
            </div>                                    
        </div>
    </div> 
<div class="section-border"> 
    <div class="row">
 	    <div class="col-md-12 col-sm-12 col-xs-12">             		    
 		<div class="data-table">
            <div class="table-responsive">
             	<h1 class="cst-datatable-heading">{{trans('messages.keyword_languages&phases')}}</h1>
                <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('language/json');?>" data-classes="table table-bordered" id="table">
                <thead>
                <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
                <th data-field="code" data-sortable="true">{{trans('messages.keyword_code')}}</th>
                <th data-field="name" data-sortable="true">{{trans('messages.keyword_name')}}</th>
                <th data-field="original_name" data-sortable="true">{{trans('messages.keyword_original_name')}}</th>
                <th data-field="icon" data-sortable="true">{{trans('messages.keyword_icon')}}</th>
                </thead>
                </table>
            </div>
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
	return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}} {{trans('messages.keyword_languages')}}?");
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
				link.href = "{{ url('/destroy/language') }}" + '/';
				if(check() && n!= 0) {
                        for(var i = 0; i < n; i++) {                            
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/destroy/language') }}" + '/' + indici[n];
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
					link.href = "{{ url('/modify/language') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
            case 'updatePhase':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/language/translation/') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
            break;
			
			/*case 'duplicate':
				link.href = "{{ url('/enti/duplicate/corporation') }}" + '/';
                                for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
													window.location.href = "{{ url('/enti/duplicate/corporation') }}" + '/' + indici[n];
                                                    error = true;
                                                } 
                                            }
                                        });
                                    }
                                    selezione = undefined;
                                    
                                if(error === false)
                                    setTimeout(function(){location.reload();},100*n);
									
								n = 0;
			break;*/
		}
}
</script>


@endsection	