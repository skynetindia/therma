@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <link href="{{asset('public/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('public/js/select2.full.min.js')}}"></script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages();?>
    <?php $modules = fetch_modules(0, '', 0); ?>
    {{ Form::open(array('url' => 'hotel/season/save', 'files' => true, 'id' => 'update_profile_form')) }}
    <input type="hidden" name="season_id" value="{{ isset($seasonDetails->id) ? $seasonDetails->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
    <div class="user-profile-wrap">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="user-profile-heading">
                    @if($action == 'add')
                        @lang('messages.keyword_add_new')
                    @else 
                        @lang('messages.keyword_update') 
                    @endif  
                        
                    @lang('messages.keyword_seasons')                     
                </h1>
                
                <hr/>
            </div>
        </div>
        <div class="row">                         
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="user-form row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">@lang('messages.keyword_name') <span class="required">(*)</span></label>
                                <input type="text" name="name" value="{{ isset($seasonDetails->name) ? $seasonDetails->name : '' }}"  class="form-control" id="name" placeholder="{{trans('messages.keyword_name')}}">
                            </div>                            
                            <div class="form-group">
                                <label for="">{{ trans('messages.keyword_markets')}} <span class="required">(*)</span></label>
                                <?php $selectedVal = (isset($seasonDetails->category)) ? explode(",", $seasonDetails->category) : array(); ?>
                                <select name="category[]" class="form-control" id="category" multiple="multiple">
                                    <option value="ALL" {{(in_array('ALL', $selectedVal)) ? 'selected' : ''}} >ALL</option>                                    
                                    @foreach($countries as $key => $value) 
                                    <option value="{{ $value->v_sortname }}" {{(in_array($value->v_sortname, $selectedVal)) ? 'selected' : ''}} > {{ $value->v_sortname.' | '.$value->v_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">{{ trans('messages.keyword_hotel')}} <span class="required">(*)</span></label>
                                <?php 
                                $arrHotels = getHotels();    
                                if(Auth::user()->profile_id != "0"){
                                    $hotelid =  Auth::user()->hotel_id;
                                   $arrHotels = getHotels($hotelid);    
                                }
                                ?>
                                <select name="hotel_id" class="form-control" id="hotel_id">                                    
                                    @foreach( $arrHotels as $key => $value) 
                                    <option value="{{ $value->id }}" <?php echo (isset($seasonDetails->hotel_id) && $seasonDetails->hotel_id == $value->id) ? 'selected' : '';?> > {{ $value->id.' | '.$value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">{{trans('messages.keyword_from')}}<span class="required">(*)</span></label>
                                <input type="text" name="season_from" value="{{ isset($seasonDetails->season_from) ? dateFormate($seasonDetails->season_from,'d-m-Y') : ''}}" class="form-control" id="season_from" placeholder="{{trans('messages.keyword_from')}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('messages.keyword_to')}} <span class="required">(*)</span></label>
                                <input type="text" name="season_to" value="{{ isset($seasonDetails->season_to) ?  dateFormate($seasonDetails->season_to,'d-m-Y') : '' }}" class="form-control" id="season_to" placeholder="{{trans('messages.keyword_to')}}">
                            </div>
                        </div>
                    </div><hr>
                </div>
        </div>
    </div>
    <div class="btn-shape">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{url('hotel/seasons')}}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>
    <script>
    $(document).ready(function () {
            $('#season_from,#season_to').datepicker({
                format: "dd-mm-yyyy",
                daysOfWeekDisabled: [0],
                startDate: "18-07-2015",//'-30d',
                endDate: '+30d',
                orientation: "top"
            }).datepicker("setDate", res[4]);
        });
    $('#category,#hotel_id').select2();
        $("#update_profile_form").validate({
            rules: {
                name: {
                    required: true
                },
                season_from: {
                    required: true
                },
                season_to:{
                   required: true
                }
            },
            messages: {
                name: {
                    required: "@lang('messages.keyword_please_enter_a_name')"
                },
                season_from:{
                    required: "@lang('messages.keyword_please_enter_season_from')"
                },
                season_to: {
                    required: "@lang('messages.keyword_please_enter_season_to')"
                }
            }
        });
        $(document).ready(function() {
            var phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
            $('#phone').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });
    </script>
@endsection
