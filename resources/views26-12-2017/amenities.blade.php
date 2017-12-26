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
    <div class="step-page">
        <div class="row">
            <div class="col-md-12">
                <div class="navigation-root">
                    <ul class="navigation-list">
                        <li class="navigation-item navigation-previous-item" id="firstst"></li>
                        <li class="navigation-item navigation-previous-item" id="secondst"></li>
                        <li class="navigation-item navigation-previous-item" id="thirdst"></li>
                        <li class="navigation-item navigation-previous-item" id="fourthst"></li>
                        <li class="navigation-item navigation-previous-item navigation-active-item" id="fifthst"></li>
                        <li class="navigation-item" id="sixthst"></li>
                        <li class="navigation-item" id="seven"></li>
                        <li class="navigation-item" id="eight"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($hoteldetails) && !empty($hoteldetails) && $action == 'edit') {
        echo Form::open(array('url' => 'hotel/update/saveamenities' . "/" . $hoteldetails->id, 'files' => true, 'id' => 'frmHotelAmenities'));
		 $selectvaluesetop = isset($hotelFeatures->set_option) ? explode(',',$hotelFeatures->set_option) : array();
		  $languagearry = isset($hotelFeatures->language_key) ? explode(',',$hotelFeatures->language_key) : array();
		
    } 
    ?>
    <input type="hidden" name="hotel_id" value="{{isset($hoteldetails->id) ? $hoteldetails->id : ''}}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    {{ csrf_field() }}
    <div class="hotel-detail-wrap hotel-amenities">
        <div class="rytside-menu">
            <h1 class="heading-top">Hotel Features</h1>
        </div>
        <div class="row">
            @foreach($wizard_category as $wizardcatkey=>$wizardcat)
                <?php 
                DB::enableQueryLog();
                $categoryoptions = getWizardOptionByCategory($wizardcat->id);
                 ?>
                @if(isset($categoryoptions[0]->cat_lang_key))
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="hotel-detail-lft">
                            <div class="set-option">
                                <div class="section-border set-height-section-border">
                                    <p class="bold blue-head">{{trans('messages.keyword_'.$categoryoptions[0]->cat_lang_key)}}</p>
                                    <div class="set-min-height">
                                        <div class="row">
                                            @foreach($categoryoptions as $keycat => $valcat)
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="form-group"><?php
                                                            $language = preg_grep('~' . $valcat->id . '->~', $languagearry);
                                                            $key = key($language);
                                                            $lang = isset($language[$key]) ? str_replace($valcat->id . "->", '', $language[$key]) : null;
                                                            $islang = ($valcat->is_language == 1) ? 2 : 3;
                                                            if (isset($valcat->id) && $valcat->id != null) {
                                                                echo createwizard($valcat, $islang, 'set_option', $selectvaluesetop, $lang);
                                                            }
                                                            ?></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="fixed-bottom">
                                            <a href="javascript:void(0)" onclick="newoption({{$wizardcat->id}})" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-6-12">Add New</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
        <div class="btn-shape">
            <div class="row">
                {{--<div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/edit/basic').'/'.$hoteldetails->id}}" class="btn btn-default">Previous</a></div>--}}
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a
                            href="{{url('hotel/edit/basic') }}" class="btn btn-default">Previous</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 btn-right-shape text-right">
                    <button type="submit" class="btn btn-default">{{trans('messages.keyword_next')}}</button>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
    <!-- Modal -->

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        function newoption(val) {
            $('#catid').val(val);
        }
    </script>

    <script type="text/javascript">


        function saveoption() {

            var name = $('#name').val();
            var catid = $('#catid').val();
            var urlredirect = "{{url('hotel/wizard/new')}}";
            $.ajax({
                type: "POST",
                url: urlredirect,
                data: {'name': name, "catid": catid, '_token': '{{csrf_token()}}'},
                success: function (data) {
                    $('#myModal').modal('hide');
                }
            });
        }
    </script>


@endsection
<div class="modal fade hotel-prices1-new-modal" id="myModal" role="dialog">
    <div class="modal-dialog">

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
                <button type="button" class="btn btn-default btn-6-12" data-dismiss="modal" onclick="saveoption();">
                    save
                </button>
            </div>
        </div>

    </div>
</div>

