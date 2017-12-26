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
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
<script src="{{ asset('public/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-table-it-IT.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/jqColorPicker.min.js')}}"></script>
<script src="{{asset('public/js/select2.full.min.js')}}"></script>

<!-- ======================================================= Meals Status ========================================== -->
<div class="taxonomies-wrap">            
            <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="middle-head-add">
                          <h3 class="heading">Meals : {{ trans('messages.keyword_add')}}</h3>
                            <form action="{{url('/taxonomies/meals/savenew')}}" method="post" id="frmmealsadd" name="frmmealsadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control"  type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">      
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="code" placeholder="Meal Code">      
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="price" placeholder="Defaul Price">      
                                    </div>
                                </div>
                             </div>
                            <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">    
                                   </div>
                            </div></div> 
                           </form>
                        </div>
                    </div>
                </div>
         <div class="section-border">   
            <div class="row">                          
                     <div class="col-md-12 col-sm-12 col-xs-12">  
                     <h1 class="cst-datatable-heading">Meals : {{trans('messages.keyword_edit')}}</h1>                     
                     <div class="select-all">
                      <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12"><div class="ryt-chk">
                            <input id="chktasmealsall" name="chktasmealsall" type="checkbox"><label for="chktasmealsall">select all</label></div></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                              <input type="button" onclick="AllmealsAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                              <input type="button" onclick="AllmealsAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                            </div>
                        </div>
                     </div>
                     <form action="{{url('/taxonomies/meals/update')}}" method="post" id="frmeditmeals">
                      <input type="hidden" id="actionmeals" name="action" value="update">                     
                    <div class="table-responsive">                                  
                    <table class="table table-striped table-bordered checkbox-tbl">
                     @foreach($taxinomies_meals as $types)
                      {{ csrf_field() }}
                      <input type="hidden" name="id[]" value="{{$types->id}}">            
                        <tr>
                            <td>
                                <div class="ryt-chk">
                                  <input class="chkmeals" type="checkbox" name="chkmeals[{{$types->id}}]" id="chkmeals_{{$types->id}}" value="{{$types->id}}">
                                    <label for="chkmeals_{{$types->id}}"></label>
                                </div>
                            </td>
                            <td>
                              <div class="form-group">
                                  <input type="text" class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.'.$types->language_key) : $types->name; ?>"/>
                                    <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                 </div>
                             </td>
                            <td><div class="form-group">
                              <input type="text" class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}" />
                                </div></td>
                            <td>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="code[{{$types->id}}]" value="{{$types->code}}"/>
                                </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" name="price[{{$types->id}}]" value="{{$types->price}}"/>
                              </div>
                            </td>
                            <td>
                            <button class="btn btn-default btn-6-12" type="button" onclick="SinglemealsTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                            <a onclick="conferma(event);" type="button" href="javascript:SinglemealsTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                            </td>
                        </tr>
                      @endforeach
                    </table>                                    
                    </div>
                   </form>
                 </div>
                 </div>
             </div>               
            </div>
<hr>
<!-- ======================================================= Meals Combinations Status ========================================== -->
<div class="taxonomies-wrap">            
            <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="middle-head-add">
                          <h3 class="heading">Meals Combinations : {{ trans('messages.keyword_add')}}</h3>
                            <form action="{{url('/taxonomies/mealscombination/savenew')}}" method="post" id="frmmealsadd" name="frmmealsadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select id="mealid" name="mealscombination[]" class="js_selecttwo_multiple form-control" multiple="multiple">
                                            @foreach($taxinomies_meals as $meals)
                                            <option value="{{ $meals->id }}">
                                               {{ $meals->code }} | {{ ucwords(strtolower($meals->name)) }}
                                            </option>
                                            @endforeach
                                      </select>
                                    </div>
                                </div>                               
                             </div>
                            <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">    
                                   </div>
                            </div></div> 
                           </form>
                        </div>
                    </div>
                </div>
         <div class="section-border">   
            <div class="row">                          
                     <div class="col-md-12 col-sm-12 col-xs-12">  
                     <h1 class="cst-datatable-heading">Meals Combination : {{trans('messages.keyword_edit')}}</h1>                     
                     <div class="select-all">
                      <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12"><div class="ryt-chk">
                            <input id="chktasmealscombinationall" name="chktasmealscombinationall" type="checkbox"><label for="chktasmealscombinationall">select all</label></div></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                              <input type="button" onclick="AllmealscombinationAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                              <input type="button" onclick="AllmealscombinationAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                            </div>
                        </div>
                     </div>
                     <form action="{{url('/taxonomies/mealscombination/update')}}" method="post" id="frmeditmealscombination">
                      <input type="hidden" id="actionmealscombination" name="action" value="update">                     
                    <div class="table-responsive">                                  
                    <table class="table table-striped table-bordered checkbox-tbl">
                     @foreach($taxinomies_meals_combination as $types)
                      {{ csrf_field() }}
                      <input type="hidden" name="id[]" value="{{$types->id}}">            
                        <tr>
                            <td>
                                <div class="ryt-chk">
                                  <input class="chkmealscombination" type="checkbox" name="chkmealscombination[{{$types->id}}]" id="chkmealscombination_{{$types->id}}" value="{{$types->id}}">
                                    <label for="chkmealscombination_{{$types->id}}"></label>
                                </div>
                            </td>
                            <td>
                              <div class="form-group">
                                  <input type="text" class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.'.$types->language_key) : $types->name; ?>"/>
                                    <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                 </div>
                             </td>
                            <td><div class="form-group"><?php 
                               $mealids = explode(",",$types->meal_id); 
                                ?><select id="mealid" name="mealscombination[{{$types->id}}][]" class="js_selecttwo_multiple form-control" multiple="multiple">
                                @foreach($taxinomies_meals as $meals)
                                <option value="{{ $meals->id }}" <?php echo (in_array($meals->id,$mealids)) ? 'selected' : ''; ?>>
                                   {{ $meals->code }} | {{ ucwords(strtolower($meals->name)) }}
                                </option>
                                @endforeach
                                </select>
                            </div></td>                            
                            <td>
                            <button class="btn btn-default btn-6-12" type="button" onclick="SinglemealscombinationTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                            <a onclick="conferma(event);" type="button" href="javascript:SinglemealscombinationTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                            </td>
                        </tr>
                      @endforeach
                    </table>                                    
                    </div>
                   </form>
                 </div>
                 </div>
             </div>               
            </div>
            <script type="text/javascript">
                    $(".js_selecttwo_multiple").select2();
                    //$('#mealid').on("select2:selecting", function(e) {});
                </script>
<hr>
<!-- ========================================================= Room Type ========================================== -->
       <div class="taxonomies-wrap">            
            <div class="row">
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<div class="middle-head-add">
                        	<h3 class="heading">Room Type : {{ trans('messages.keyword_add')}}</h3>
                            <form action="{{url('/taxonomies/roomtype/savenew')}}" method="post" id="frmroomtypeadd" name="frmroomtypeadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>			
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control"  type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">			
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="code" placeholder="code">			
                                    </div>
                                </div>
                             </div>
                            <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">    
                                   </div>
                            </div></div> 
                           </form>
                        </div>
                    </div>
                </div>
         <div class="section-border">   
         		<div class="row">                          
                     <div class="col-md-12 col-sm-12 col-xs-12">	
                     <h1 class="cst-datatable-heading">Room Type : {{trans('messages.keyword_edit')}}</h1>                     
                     <div class="select-all">
                     	<div class="row">
                        	<div class="col-md-6 col-sm-6 col-xs-12"><div class="ryt-chk">
                            <input id="chktasroomtypeall" name="chktasroomtypeall" type="checkbox"><label for="chktasroomtypeall">select all</label></div></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
	                            <input type="button" onclick="AllroomtypeAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
    							<input type="button" onclick="AllroomtypeAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                            </div>
                        </div>
                     </div>
                     <form action="{{url('/taxonomies/roomtype/update')}}" method="post" id="frmeditroomtype">
					 <input type="hidden" id="actionroomtype" name="action" value="update">                     
                    <div class="table-responsive">                                	
                    <table class="table table-striped table-bordered checkbox-tbl">
                     @foreach($taxinomies_room_type as $types)
                      {{ csrf_field() }}
                      <input type="hidden" name="id[]" value="{{$types->id}}">            
                        <tr>
                            <td>
                            	<div class="ryt-chk">
                                	<input class="chkroomtype" type="checkbox" name="chkroomtype[{{$types->id}}]" id="chkroomtype_{{$types->id}}" value="{{$types->id}}">
                                    <label for="chkroomtype_{{$types->id}}"></label>
                                </div>
                            </td>
                            <td>
                            	<div class="form-group">
                                	<input type="text" class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.'.$types->language_key) : $types->name; ?>"/>
                                    <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                 </div>
                             </td>
                            <td><div class="form-group">
                            	<input type="text" class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}" />
                                </div></td>
                            <td>
                            	<div class="form-group">
                                	<input type="text" class="form-control" name="code[{{$types->id}}]" value="{{$types->code}}"/>
                                </div>
                            </td>
                            <td>
                           	<button class="btn btn-default btn-6-12" onclick="SingleroomtypeTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                            <a onclick="conferma(event);" type="button" href="javascript:SingleroomtypeTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                            </td>
                        </tr>
                      @endforeach
                    </table>                                    
                    </div>
                   </form>
                 </div>
                 </div>
             </div>               
            </div>
<hr>
<!-- ========================================================= Room Bed ========================================== -->
       <div class="taxonomies-wrap">            
            <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="middle-head-add">
                            <h3 class="heading">Room Bed : {{ trans('messages.keyword_add')}}</h3>
                            <form action="{{url('/taxonomies/roombed/savenew')}}" method="post" id="frmroombedadd" name="frmroombedadd">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{trans('messages.keyword_name')}}" required>          
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control"  type="text" name="description" placeholder="{{trans('messages.keyword_description')}}">            
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="code" placeholder="code">         
                                    </div>
                                </div>
                             </div>
                            <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_add')}}">    
                                </div>
                                </div>
                            </div> 
                           </form>
                        </div>
                    </div>
                </div>
         <div class="section-border">   
                <div class="row">                          
                     <div class="col-md-12 col-sm-12 col-xs-12">    
                     <h1 class="cst-datatable-heading">Room Bed : {{trans('messages.keyword_edit')}}</h1>                     
                     <div class="select-all">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12"><div class="ryt-chk">
                            <input id="chktasroombedall" name="chktasroombedall" type="checkbox"><label for="chktasroombedall">select all</label></div></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                <input type="button" onclick="AllroombedAction('update')" class="btn btn-default btn-6-12" value="{{trans('messages.keyword_save_selected')}}">
                                <input type="button" onclick="AllroombedAction('delete')" class="btn btn-default btn-reject btn-6-12" value="{{trans('messages.keyword_delete_selected')}}">
                            </div>
                        </div>
                     </div>
                     <form action="{{url('/taxonomies/roombed/update')}}" method="post" id="frmeditroombed">
                     <input type="hidden" id="actionroombed" name="action" value="update">                     
                    <div class="table-responsive">                                  
                    <table class="table table-striped table-bordered checkbox-tbl">
                     @foreach($taxinomies_room_bed as $types)
                      {{ csrf_field() }}
                      <input type="hidden" name="id[]" value="{{$types->id}}">            
                        <tr>
                            <td>
                                <div class="ryt-chk">
                                    <input class="chkroombed" type="checkbox" name="chkroombed[{{$types->id}}]" id="chkroombed_{{$types->id}}" value="{{$types->id}}">
                                    <label for="chkroombed_{{$types->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="{{trans('messages.keyword_name')}}" name="name[{{$types->id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.'.$types->language_key) : $types->name; ?>"/>
                                    <input type="hidden" name="langkey[{{$types->id}}]" value="{{$types->language_key}}">
                                 </div>
                             </td>
                            <td><div class="form-group">
                                <input type="text" class="form-control" placeholder="{{trans('messages.keyword_description')}}" name="description[{{$types->id}}]" value="{{$types->description}}" />
                                </div></td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="code[{{$types->id}}]" value="{{$types->code}}"/>
                                </div>
                            </td>
                            <td>
                            <button class="btn btn-default btn-6-12" onclick="SingleroombedTaxonomiesAction('{{$types->id}}','update')">{{trans('messages.keyword_save')}}</button>
                            <a onclick="conferma(event);" type="button" href="javascript:SingleroombedTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-default btn-reject btn-6-12"> {{trans('messages.keyword_delete')}}</a>
                            </td>
                        </tr>
                      @endforeach
                    </table>                                    
                    </div>
                   </form>
                 </div>
                 </div>
             </div>               
            </div>
<script>
    jQuery(document).ready(function(){
        jQuery('.scrollbar-inner').scrollbar();		
		/******** Funtion start **********/		
				setTimeout(function() {		
			var oldURL = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
			var index = 0;
			var newURL = oldURL;
			index = oldURL.indexOf('?');
			if(index == -1){
				index = oldURL.indexOf('#');
			}
			if(index != -1){
				newURL = oldURL.substring(0, index);
			}
				 /* START auto scroll to active menu */		
				var total_menu_item = $(".navbar-default .navbar-nav > li > a").length;
				var avgpos = parseInt(parseInt($( '.scrollbar-inner' ).width()) / parseInt(total_menu_item));
				var tempcount = 1;
				 /* END auto scroll to active menu */
				$(".navbar-default .navbar-nav > li > a").each(function(){
						
							
						  if($(this).attr("href") == newURL || $(this).attr("href") == '' ){
							 
						  $(this).addClass("active");
						 
						 /* START auto scroll to active menu */					
						  $( '.scrollbar-inner' ).animate( {
									scrollLeft: parseInt(tempcount *  avgpos)
								}, 500 );
						  
						  }
						  tempcount++;
						  
						   /* END auto scroll to active menu */
						  
						  
					 })
					 
				$(".user-menu-tab .list-unstyled > li a").each(function(){
					
						  if($(this).attr("href") == newURL || $(this).attr("href") == '' ){
							 
						  $(this).addClass("active");
						  
						  }
					 })
				 
				 $(".sidebar-wrapper ul li a").each(function(){
				
					  if($(this).attr("href") == newURL || $(this).attr("href") == '' ){
						 
					  $(this).addClass("active");
					 
					  }
				 })
				 
				 
				}, 1000);

		

		/******** Funtion END **********/
    });
</script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script type="text/javascript">          
    $('.color').colorPicker(); // that's it
</script>
<script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
 $(document).ready(function() {
    
   $("#frmmealsadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
      
   $("#frmeditmeals").validate({            
        rules: {
          "name[]": {
            required: true,
          }
        },
        messages: {
          "name[]": {
            required: "{{trans('messages.keyword_please_enter_a_name')}}"
          }
        }
      });
   $("#frmmealscombinationadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
      
   $("#frmeditmealscombination").validate({            
        rules: {
          "name[]": {
            required: true,
          }
        },
        messages: {
          "name[]": {
            required: "{{trans('messages.keyword_please_enter_a_name')}}"
          }
        }
      });
	  $("#frmroomtypeadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
		  
   $("#frmeditroomtype").validate({            
			  rules: {
				  "name[]": {
					  required: true,
				  }
			  },
			  messages: {
				  "name[]": {
					  required: "{{trans('messages.keyword_please_enter_a_name')}}"
				  }
			  }
		  });

 $("#frmroombedadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
          
   $("#frmeditroombed").validate({            
              rules: {
                  "name[]": {
                      required: true,
                  }
              },
              messages: {
                  "name[]": {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });

  });
 
  $("#chktasmealsall").click(function () {
     $('.chkmeals').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chkmeals").click(function () {        
    addremoveclass();
 });

  $("#chktasmealscombinationall").click(function () {
     $('.chkmealscombination').not(this).prop('checked', this.checked);
     addremoveclass();
  });
  $(".chkmealscombination").click(function () {        
    addremoveclass();
  });

  $("#chktasroomtypeall").click(function () {
     $('.chkroomtype').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chkroomtype").click(function () {        
    addremoveclass();
 });

  $("#chktasroombedall").click(function () {
     $('.chkroombed').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chkroombed").click(function () {        
    addremoveclass();
 });
 
 function SinglemealscombinationTaxonomiesAction(id,action) {  
  $("#chkmealscombination_"+id).prop('checked', true);
  $("#actionmealscombination").val(action);
  $("#frmeditmealscombination").submit();
}
function SinglemealsTaxonomiesAction(id,action) {  
  $("#chkmeals_"+id).prop('checked', true);
  $("#actionmeals").val(action);
  $("#frmeditmeals").submit();
}
function SingleroomtypeTaxonomiesAction(id,action) {
  $("#chkroomtype_"+id).prop('checked', true);
  $("#actionroomtype").val(action);
  $( "#frmeditroomtype" ).submit();
}
function SingleroombedTaxonomiesAction(id,action) {
  $("#chkroombed_"+id).prop('checked', true);
  $("#actionroombed").val(action);
  $( "#frmeditroombed" ).submit();
}


function AllmealscombinationAction(action) {
    if ($("#frmeditmealscombination input:checkbox:checked").length > 0) {    
      if(action == 'delete'){
        var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
        if (!confirmation) {
          return false;
        }        
      }
      $("#actionmealscombination").val(action);
      $( "#frmeditmealscombination").submit();  
    }
    else {
        alert("{{trans('messages.keyword_select_at_least_one_record')}}");
    }
}



function AllmealsAction(action) {
if ($("#frmeditmeals input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actionmeals").val(action);
  $( "#frmeditmeals").submit();  
}
else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
}
}


function AllroomtypeAction(action) {
if ($("#frmeditroomtype input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actionroomtype").val(action);
  $( "#frmeditroomtype").submit();  
 }
 else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
 }
}

function AllroombedAction(action) {
if ($("#frmeditroombed input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actionroombed").val(action);
  $( "#frmeditroombed").submit();   
 }
 else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
 }
}


function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}
</script>
@endsection	