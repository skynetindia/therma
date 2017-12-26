@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/js/dropzone.js')}}"></script>

    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
        <div class="step-page"><div class="row">
                <div class="col-md-12">
                    <div class="navigation-root">
                        <ul class="navigation-list">
                            <li class="navigation-item navigation-previous-item" id="firstst"></li>
                            <li class="navigation-item navigation-previous-item" id="secondst"></li>
                            <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                            <li class="navigation-item navigation-previous-item" id="fourthst"></li>
                            <li class="navigation-item navigation-previous-item" id="fifthst"></li>
                            <li class="navigation-item navigation-previous-item " id="sixthst"></li>
                            <li class="navigation-item navigation-previous-item navigation-active-item " id="seven"></li>
                            <li class="navigation-item " id="eight"></li>
                            <li class="navigation-item" id="nine"></li>
                        </ul>
                    </div>
                </div>
            </div></div>

        <div class="media-wrap">
             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="row">
                    <?php $mediaCode = date('dmyhis');?>
                    <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
                     <div class="upload-file-form col-md-12 col-sm-12 col-xs-12">
                        <?php echo Form::open(array('url' => '/hotel/media/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                        {{ csrf_field() }}
                        <input type="hidden" name="master_id" value="{{ $holetdetail->id }}">
                        </form>             
                    </div>
                    <!--<div class="upload-file">
                        <form><div class="dz-default dz-message"><span>Drop files here to upload</span></div></form>
                    </div>-->
                    <div id="medialist" class="col-md-12 col-sm-12 col-xs-12"><?php
                    foreach($holetmedia as $prev) {
                        $imagPath = url('/storage/app/images/hotel/'.$prev->name);
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
                        ?><div class="uploaded-img">
                        <img src="{{$imagPath}}" alt="Upload Image" height="100px;" width="100px;">
                        <h3>{{$prev->title}}</h3><br><p>{{$prev->description}}</p>
                        <div class="radio round-checkbox">
                            <input id="radio{{$prev->id}}" type="radio">
                            <label for="radio{{$prev->id}}"></label>
                            <div class="check">
                                <div class="inside">
                                    
                                </div>
                            </div>
                        </div>                        
                        </div><?php
                    }
                    ?></div>                      
                </div>
            </div>
          </div>
        
            <div class="btn-shape">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('hotel/edit/amenities').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                    <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right"><a href="{{ url('hotel/edit/policies').'/'.$hotelid }}" class="btn btn-default">@lang('messages.keyword_next')</a></div>
                </div>
            </div>
        </div>    
    </div>
 <script>
    var urlgetfile = '<?php echo url('/hotel/media/getfiles/'.$mediaCode.'/'.$hotelid); ?>';
    Dropzone.autoDiscover = false;
    $(".dropzone").each(function() {
      $(this).dropzone({
        complete: function(file) {
          if (file.status == "success") {
             $.ajax({url: urlgetfile, success: function(result){
                $("#medialist").html(result);
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
                
      $('#commnetform').on('submit',function(e){
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
            });
</script>
@endsection

<div class="modal fade" id="addMediacommnetmodal" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_add_title_and_description')}}</h3>
            </div>
            <div class="modal-body">
                <!-- Start form to add a new event -->
                <form action="{{ url('/hotel/media/comment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
                    {{ csrf_field() }}
                    @include('common.errors')                       
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">                               
                            <div class="form-group">
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }}</label>
                                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }}</label>
                                <textarea rows="5" name="descriptions" id="descriptions" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_description')) }}">{{ old('descriptions') }}</textarea>
                            </div>
                        </div>
                     </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }} ">
                    </div>
                </form>
                <!-- End form to add a new event -->
            </div>
        </div>
    </div>
</div>