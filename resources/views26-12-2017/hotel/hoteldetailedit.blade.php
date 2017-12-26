@extends('layouts.app')
@section('content')
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>-->
  <link rel="stylesheet" href="{{asset('public/css/lightslider.css')}}">
  <script src="{{asset('public/js/lightslider.js')}}"></script>
      <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/js/dropzone.js')}}"></script>
<link rel="stylesheet" href="//rawgit.com/jonthornton/jquery-timepicker/master/jquery.timepicker.css">
<script src="//rawgit.com/jonthornton/jquery-timepicker/master/jquery.timepicker.js"></script>
  
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
                        <li class="navigation-item navigation-previous-item " id="firstst"></li>
                        <li class="navigation-item navigation-previous-item  navigation-active-item" id="secondst"><span>{{trans('messages.keyword_hotel_information')}}</span></li>
                        <li class="navigation-item" id="thirdst"></li>
                        <li class="navigation-item" id="fourthst"></li>
                        <li class="navigation-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><?php 
    if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
        echo Form::open(array('url' => '/update/hoteldetail' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelBasicInfo'));
    } else {
        echo Form::open(array('url' => '/update/hoteldetail', 'files' => true, 'id' => 'frmHotelBasicInfo'));
    }
    ?><input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    {{ csrf_field() }}
   

        <div class="hotel-information hotel-info-rel">
           
                <div class="row" id="row">
                    		
                            <div class="col-md-12 col-sm-12 col-xs-12">	
                            	
                                	<div class="section-border">
                               
                                <div class="row">
                                  
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                            @if(Auth::user()->profile_id==0)
                                            	<div class="row hotel-information-head-blk ">
                                            		<div class="col-md-5 col-sm-12 col-xs-12">
                                            			<p>Check-in</p>
                                                        <div class="form-group" id="checkinfrom">
                                                        @php $checkin=explode('-',$hoteldetails->check_in);
                                                        $checkout=explode('-',$hoteldetails->check_out);
                                                        @endphp
                                                            <label for="checkinstart">{{trans('messages.keyword_from')}}<span class="required">*</span></label>
                                                            <input type="text" name="checkin[]" value="{{(isset($hoteldetails->check_in) && isset($checkin[0]) &&  $hoteldetails->check_in!='')?$checkin[0]:''}}" id="checkinstart" class="form-control timepicker" placeholder="{{trans('messages.keyword_from')}}">
                                                               
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="checkinend">{{trans('messages.keyword_to')}}<span class="required">*</span></label>
                                                            <input type="text" name="checkin[]" id="checkinend" value="{{(isset($hoteldetails->check_in) && isset($checkin[1]) && $hoteldetails->check_in!='')?$checkin[1]:''}}" class="form-control timepicker" placeholder="{{trans('messages.keyword_to')}}">
                                                        </div>
                                                	</div>
                                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                                        <p>Check-out</p>
                                                        <div class="form-group">
                                                            <label for="checkoutstart">{{trans('messages.keyword_from')}}<span class="required">*</span></label>
                                                            <input type="text" name="checkout[]" id="checkoutstart" value="{{(isset($hoteldetails->check_out) && isset($checkout[0]) && $hoteldetails->check_out!='')?$checkout[0]:''}}" class="form-control timepicker" placeholder="{{trans('messages.keyword_from')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="checkoutend">{{trans('messages.keyword_to')}}<span class="required">*</span></label>
                                                             <input type="text" name="checkout[]" id="checkoutend" value="{{(isset($hoteldetails->check_out) && isset($checkout[1]) && $hoteldetails->check_out!='')?$checkout[1]:''}}" class="form-control timepicker" placeholder="{{trans('messages.keyword_to')}}">
                                                        </div>
                                                	</div>
                                                    
                                                    <div class="col-md-2 col-sm-12 col-xs-12 wifi-head">
                                                        <div class="form-group">
                                                            <label for="wifi">Wifi </label>
                                                            <select class="form-control" name="wifi" id="wifi">
                                                           <option value="1" {{(isset($hoteldetails->wifi) && $hoteldetails->wifi==1)?"selected":''}}>Yes</option>
                                                             <option value="2" {{(isset($hoteldetails->wifi) && $hoteldetails->wifi==2)?"selected":''}}>No</option>
                                                               <option value="3" {{(isset($hoteldetails->wifi) && $hoteldetails->wifi==3)?"selected":''}}>To Pay</option>
                                                            </select>
                                                        </div>
                                                	</div>
                                                    
                                                    
                                                </div>
                                                @else
                                                     <div class="form-group">
                                                        <label for="name">{{trans('messages.keyword_hotel_name')}} <span class="required">(*)</span></label>
                                                        <input class="form-control" placeholder="{{trans('messages.keyword_hotel_name')}}" value="{{(isset($hoteldetails->name)) ? $hoteldetails->name : old('name')}}"
                                                               name="name" id="name" disabled type="text" required>
                                                    </div>
                                                @endif
                                                <script>
												/*$(function() {
													$('.timepicker').timepicker({appendTo: function($el) { alert(); return $el.parent() } })
												})*/
												$(document).ready(function(){
													

													$('input.timepicker').timepicker({
														
														appendTo:function($el) { return $('#checkinfrom').parent() },	
														'scrollDefault': 'now',
														'timeFormat':'H:i',
														});
												});
												</script>
                                               <div class="text-area">
                                                	<div class="form-group">
                                                     <label for="opinion">@lang('messages.keyword_thermaeurope_opinion')<span class="required">*</span></label>
                                                	<textarea class="form-control" name="opinion" id="opinion">{{(isset($hoteldetails->opinion)) ? $hoteldetails->opinion : old('opinion')}}</textarea>
                                                    	</div>
                                                </div>
                                                <div class="row">
                                                	<div class="col-md-6 col-sm-12 col-xs-12">
                                                    	<div class="form-group">
                                                        	<label>@lang('messages.keyword_logo') <span class="required">(*)</span></label>
	                                                    	<input type="file" name="logo" accept="image/*"/>
                                                            @if(isset($hoteldetails->logo)&& $hoteldetails->logo!='')
                                                            <img src="{{url('storage/app/images/hotel/'.$hoteldetails->logo)}}" width="100">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                    	<div class="form-group">
                                                        	<label>@lang('messages.keyword_feature_image') <span class="required">(*)</span></label>
	                                                    	<input type="file" name="feature" accept="image/*"/>
                                                             @if(isset($hoteldetails->feature)&& $hoteldetails->feature!='')
                                                            <img src="{{url('storage/app/images/hotel/'.$hoteldetails->feature)}}" width="100">
                                                            @endif
                                                        </div>
                                                    </div>
                                                 <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                 <div class="text-area">
                                               		 <div class="form-group">
                                                     <label for="">Summary <span class="required">(*)</span></label>
                                                	<textarea class="form-control" name="summary">{{(isset($hoteldetails->summary)) ? $hoteldetails->summary : old('summary')}}</textarea>
                                                    	</div>
                                                </div>
                                                </div>
                                                </div>
                                                
                                                
                                                
                                                 <div class="ck-editor-abs">
                                                    
                                                        <label>{{trans('messages.keyword_description')}} <span class="required">(*)</span></label>
                                                        <textarea  placeholder="{{trans('messages.keyword_description')}}" name="description" id="description" required>{{(isset($hoteldetails->description)) ? $hoteldetails->description : old('description')}}</textarea>
                                            	
                                          		 </div>
                                                 <div class="btn-shape">
        <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/edit/basic/'.$hoteldetails->id)}}" class="btn btn-default">{{trans('messages.keyword_previous')}}</a></div>
        	                <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</a></div>

        </div>
    </div> 
                                            </div>
                                            
                                            
                                      </form>      
                                         
                                            
                                            
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                            	
                                                <div class="slider-hotel-information">
                                                	 <ul id="imageGallery" class="slider-hotel-booking-detail"><?php
														foreach($holetmedia as $prev) {
															$imagPath = url('/storage/app/images/hotel/'.$prev->name);
															$thumbnailpath = url('/storage/app/images/hotel/thumbnail/'.$prev->name);
															$downloadlink = url('/storage/app/images/hotel/'.$prev->name);
															$filename = $prev->name;            
															$arrcurrentextension = explode(".", $filename);
															$extention = end($arrcurrentextension);
																			
															$arrextension['docx'] = 'docx-file.jpg';
															$arrextension['pdf'] = 'pdf-file.jpg';
															$arrextension['xlsx'] = 'excel.jpg';
															if(isset($arrextension[$extention])){
																$imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);          
															}
															?><li data-thumb="{{$thumbnailpath}}">
																<img src="{{$imagPath}}" />
															</li>
															
															<?php
														}
														?>
                                                        
                                                    </ul>
                                                </div>
												<div class="upload-file">
														<?php $mediaCode = date('dmyhis');?>
														<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
														 <div class="upload-file-form">
															<?php echo Form::open(array('url' => '/hotel/media/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
															{{ csrf_field() }}
															<input type="hidden" name="master_id" value="{{ $hoteldetails->id }}">
															</form>           
														 </div>
												</div>
                                            </div>
                                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        
                                    </div>
                                                                        
                                    </div>
                              
                        </div>
                    </div>
                </div>
            </div>
            
     
   
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{url('/public/js/ckeditor.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script type="text/javascript" >
        CKEDITOR.replace( 'description' );
    </script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#frmHotelBasicInfo").validate({
                rules: {
                    summary: {
                        required: true,
                    },
					"checkin[]":{
						required:true
					},
					"checkout[]":{
						required:true
					},
					opinion:"required",
                   
                    description: {
                        required: true
					},
                    logo: {
                       // required: true,
                        extension: "jpeg|jpg|png|gif|svg"
                    },
					feature: {
                       // required: true,
                        extension: "jpeg|jpg|png|gif|svg"
                    }
                },
                messages: {
                    summary: {
                        required: "{{trans('messages.keyword_please_enter_summary_of_hotel')}}",
                    },
					 "checkin[]": {
                        required: "{{trans('messages.keyword_please_enter_check-in_time')}}",
                    },
					 "checkout[]": {
                        required: "{{trans('messages.keyword_please_enter_check-out_time')}}",
                    },
					 summary: {
                        required: "{{trans('messages.keyword_please_enter_summary_of_hotel')}}",
                    },
					opinion:"{{trans('messages.keyword_please_enter_opinion_of_hotel')}}",
                   
                    description: {
                        required: "{{trans('messages.keyword_please_enter_a_description')}}"
                    },
                    logo: {
                        //required: "{{trans('messages.keyword_please_select_logo')}}",
                        extension: "@lang('messages.keyword_please_choose_valid_extension')"
                    },
					feature: {
                       // required: "{{trans('messages.keyword_please_select_feature_image')}}",
                        extension: "@lang('messages.keyword_please_choose_valid_extension')"
                    }
                }
            });
            $.validator.setDefaults({
                ignore: []
            });
			slidercall();
		});
var sliderfun='';		
function slidercall(){
   sliderfun=$('#imageGallery').lightSlider({
		gallery:true,
		item:1,
		loop:true,
		thumbItem:9,
		slideMargin:0,
		enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
       // autoWidth: true,
		verticalHeight:710,
		mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
        speed: 400, //ms'
        auto: true,
        loop: true,
        slideEndAnimation: true,
        pause: 5000,
        gallery: true,
        galleryMargin: 5,
        thumbMargin: 5,
 		currentPagerPosition: 'middle',
        onSliderLoad: function() {
              selector: '#imageGallery .lslide'
            }   
        });  
}

    </script>

<script>
    var urlgetfile = '<?php echo url('/hotel/media/getfiles/'.$mediaCode.'/'.$hotelid); ?>';
    Dropzone.autoDiscover = false;
	var maxImageWidth = 740,
    maxImageHeight = 710;


    $(".dropzone").each(function() {
      $(this).dropzone({
		acceptedFiles: ".png,.jpg,.jpeg,.gif",
		init: function() {
			
			// Register for the thumbnail callback.
			// When the thumbnail is created the image dimensions are set.
			
			this.on("thumbnail", function(file) {
			  // Do the dimension checks you want to do
			  if ((file.width < maxImageWidth || file.height < maxImageHeight) ) {
				file.rejectDimensions()
			  }
			  else {
				file.acceptDimensions();
			  }
			});
		  },
		  accept: function(file, done) {
			file.acceptDimensions = done;
			file.rejectDimensions = function() { done("@lang('messages.keyword_invalid_dimension')"); };
			// Of course you could also just put the `done` function in the file
			// and call it either with or without error in the `thumbnail` event
			// callback, but I think that this is cleaner.
		  },
        complete: function(file) {
			
          if (file.status == "success") {
			   $("#preloaderdiv").show(); 
			  sliderfun.destroy();
             $.ajax({url: urlgetfile, success: function(result){
				
                $("#imageGallery").html(result);
				$("#imageGallery").hide();
				setTimeout(function(){
					$("#imageGallery").show();
					slidercall();
     				$("#preloaderdiv").hide();
				},1000);
				 
				//sliderfun();
                $(".dz-preview").remove();
                $(".dz-message").show();
            }});
          }
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
               $( "#addMediacommnetmodal" ).modal();
               $('#addMediacommnetmodal').on('shown.bs.modal', function(){});
          }
        }
      });
    });

    function deleteMediaFile(id){
        var urlD = '<?php echo url('/hotel/media/deletefiles/'); ?>/'+id;
            $.ajax({url: urlD, success: function(result){
                $(".hotelmedia_"+id).remove();
            }});
        }
                
     /* $('#commnetform').on('submit',function(e){
            $.ajaxSetup({
                header:$('meta[name="_token"]').attr('content')
            })
            e.preventDefault(e);
                $.ajax({
                type:"POST",
                url:'{{ url('/hotel/media/comment/').'/'.$mediaCode }}',
                data:$(this).serialize(),
                //dataType: 'json',
                success: function(data) {                    
                    if(data == 'success'){
                         $.ajax({url: urlgetfile, success: function(result){                
                            $("#medialist").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                },
                error: function(data){                   
                  if(data == 'success'){
                        $.ajax({url: urlgetfile, success: function(result){                
                            $("#files").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                }
            })
            });*/

</script>

@endsection