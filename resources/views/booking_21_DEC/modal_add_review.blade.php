
{{-- This is for getting score data in json for slider --}}
@php
    if(isset($edit_review_data) && count($edit_review_data) > 0 && $action == 'edit'):
        $edit_data_review_option_id = [];
        $edit_data_review_score = [];
        foreach($edit_review_score_data as  $key => $review_data):
            $edit_data_review_option_id[] = $review_data->option_id;
            $edit_data_review_score[] = $review_data->review_score;
        endforeach;
        $edit_review = array_combine($edit_data_review_option_id, $edit_data_review_score);
        $edit_review_json = json_encode($edit_review);
        //$edit_review_json = $edit_review;
    endif;
@endphp
{{-- This is for getting score data in json--}}


{{ Form::open(['url' =>'/booking/reviews/save/', 'method'=> 'post']) }}
<div class="modal-body">
    
    
<input type="hidden" name="review_id" value="{{ isset($edit_review_data) ? $edit_review_data->id : '' }}">
<input type="hidden" name="hotel_id" value="{{ $hotel_id }}">
<input type="hidden" name="booking_id" value="{{ $booking_id }}">
<input type="hidden" name="action" value="{{ $action }}">



<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="review-form">
            <h4>Leave a Review</h4>
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="review_title" value="{{ isset($edit_review_data) ? $edit_review_data->title : '' }}"/>
            </div>
            <div class="form-group">
                <label>Message Text</label>
                <textarea class="form-control" name="review_description">{{ isset($edit_review_data) ? $edit_review_data->description : '' }}</textarea>
            </div>
            <button class="btn btn-default">Submit</button>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12 col-xs-12">
        
        
        <div class="evaluations evaluations-review">
            @if(count(fetchSelectedOptionsByCategory('23', $selected_options)) > 0)
                <h4>Your Evaluations</h4>
                {{-- This will loop selected options from review category and display, review category id is 23 --}}
                @foreach(fetchSelectedOptionsByCategory('23', $selected_options) as $key => $review)
                    <div class="slide-blk">
                        <div class="name-of-slide">{{ $review->title }}</div>
                        
                        <div class="slide-rating">
                            <ul class="list-unstyled review_slider_ul" style="">
                                <li>1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                                <li>5</li>
                                <li>6</li>
                                <li>7</li>
                                <li>8</li>
                                <li>9</li>
                                <li>10</li>
                            </ul>
                            <div id="review_slider{{ $review->id }}" data-review-id="{{ $review->id }}"
                                 onchange="getReviewOptionValue(this)"
                                 class="review_slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"
                                     style="left: 0%; width: 0%;"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"
                                      style="left: 0%;"></span>
                                <input type="hidden" name="option_id[]" value="{{ $review->id }}">
                                <input type="hidden" name="review_score[]" id="review_score_{{ $review->id }}" value="">
                            
                            </div>
                        </div>
                    
                    </div>
                @endforeach
            @endif
        </div>
    
    
    </div>

</div>

</div>

{{ Form::close() }}

<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" onclick="clearModalBody(this)">close</button>
</div>





@if(isset($edit_review_data) && count($edit_review_data) > 0 && $action == 'edit')
    <script>
        $(function () {
            
            var json_string = '<?php echo $edit_review_json; ?>';
            json_string = jQuery.parseJSON(json_string);
            
            $.each(json_string, function(key, value){
                
                
                score = parseInt(value) * 10;

                $("#review_slider"+ key).slider({
                    range: false,
                    value:score,
                    animate: "fast",
                    step: 10,
                    change: function(event, ui) {
                        var review_id = $(this).data('review-id');
                        $("#review_score_"+key).val(ui.value);
                    }
                });

                $("#review_score_"+key).val(score);
            });
            
            
            
        });
    </script>
@else
    <script>
        $(function () {
            $(".review_slider").slider({
                range: false,
                animate: "fast",
                step: 10,
                change: function(event, ui) {
                    var review_id = $(this).data('review-id');
                    //ui.value gives slider value
                    $("#review_score_"+review_id).val(ui.value);
                }
            });
        });
    </script>
@endif

