@extends('layouts.app')
@section('content')
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <div class="hotel-basic-information-new-hotel">
        <div class="step-page">
            <div class="row">
                <div class="col-md-12">
                    <div class="navigation-root">
                        <ul class="navigation-list">
                            <li class="navigation-item navigation-previous-item " id="firstst"></li>
                            <li class="navigation-item navigation-previous-item " id="secondst"></li>
                            <li class="navigation-item navigation-previous-item " id="thirdst"></li>
                            <li class="navigation-item navigation-previous-item" id="fourthst"></li>
                            <li class="navigation-item navigation-previous-item navigation-active-item" id="fifthst"><span>Amenities</span></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div><?php
        if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
            echo Form::open(array('url' => 'hotel/update/saveamenities' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelAmenities'));
             $selectvaluesetop = isset($hotelFeatures->set_option) ? explode(',',$hotelFeatures->set_option) : array();
              $languagearry = isset($hotelFeatures->language_key) ? explode(',',$hotelFeatures->language_key) : array();
            
        } 
        ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
        <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
        {{ csrf_field() }}
        <div class="hotel-detail-wrap hotel-amenities">
         <div class="rytside-menu">
     <h1 class="heading-top">Hotel Features</h1>
                                </div>
            <div class="row">
    
    		
              
             @foreach($wizard_category as $wizardcatkey=>$wizardcat)
            @php $categoryoptions = getWizardOptionByCategory($wizardcat->id,'get');  @endphp
            
            <div class="col-md-6 col-sm-12 col-xs-12"> 
                            <div class="section-border">
                            	<div class="hotel-amenties">
                                	<p class="blue bold">{{trans('messages.keyword_'.$categoryoptions[0]->cat_lang_key)}}</p>
                                    <div class="hotel-amenties-chk">
                                    	 @foreach($categoryoptions as $keycat => $valcat)
                                        
                                        <div class="ryt-chk-content">
                                            <div class="ryt-chk">
                                            @php $islang=($valcat->is_language==1)?2:3;
                                                    $language = preg_grep('~'.$valcat->id.'->~', $languagearry);
                                                    $key=key($language);
                                                    $lang=isset($language[$key])?str_replace($valcat->id."->",'',$language[$key]):null;
                                                    if (isset($valcat->id) && $valcat->id != null) {
                                                      echo createwizard($valcat, $islang,'set_option',$selectvaluesetop,$lang);
                                                    }
                                          @endphp
                                            </div>
                                        </div>
                                         @endforeach
                                        
                                        
                                    </div>
                                    
                                    <div class="hotel-amenties-add">
                                    	<a href="javascript:void(0)" onclick="newoption({{$wizardcat->id}})" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-6-12">Add New</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
             
               
                 @endforeach
              
            </div>
            <div class="btn-shape">
                <div class="row">
                    {{--<div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/edit/basic').'/'.$hoteldetails->id}}" class="btn btn-default">Previous</a></div>--}}
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a
                                href="{{ url('hotel/edit/policies').'/'.$hoteldetails->id }}" class="btn btn-default">Previous</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                        <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
                    </div>
                </div>
            </div>
        </div>
    <?php echo Form::close(); ?>
    </div>
     <!-- Modal -->
  
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
		function newoption(val)
		{
			$('#catid').val(val);
		}
    </script>

    <script type="text/javascript">

		
		function saveoption()
		{
			
			var name=$('#name').val();
			var catid=$('#catid').val();
			var urlredirect="{{url('hotel/wizard/new')}}";
			$.ajax({
					type: "POST",
					url :urlredirect ,
					data:{'name':name,"catid":catid,'_token':'{{csrf_token()}}'},
					success: function(data) {
						 $('#myModal').modal('hide');
						 window.location.reload(true);
					}                                
				});
		}
    </script>


@endsection	
<div class="modal fade hotel-prices1-new-modal"  id="myModal" role="dialog">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Wizard</h4>
        </div>
        <div class="modal-body">
          						
                                <div class="row">
          								<div class="col-md-12 col-sm-12 col-xs-12"> 
                                    		<div class="form-group">
                                              <label for="">Name</label>
                                              <input class="form-control" id="name" placeholder="" name="name" type="text">
                                               <input class="form-control" id="catid" name="catid" placeholder="" type="hidden">
                                            </div>
                                        </div>
                                 </div>       
                                 
                                                 
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-6-12" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default btn-6-12" data-dismiss="modal" onclick="saveoption();">save</button>
        </div>
      </div>
      
    </div>
  </div>

