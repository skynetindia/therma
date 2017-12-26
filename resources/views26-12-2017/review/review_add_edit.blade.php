@extends('layouts.app')
@section('content')
    <!--suppress ALL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function(){
            $("#phone").mask("(999) 999-9999");
        });
    </script>
    @if(!empty(Session::get('msg')))
        <script>
            var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
            document.write(msg);
        </script>
    @endif
    @include('common.errors')
    <?php $arrlanguages = getlanguages(); ?>

    {{-- Single Review Data --}}
    <?php
    $review = json_decode($reviews->reviews, true);
    $averageRate = number_format(array_sum($review)/ count($review), 1);
    ?>

    {{-- Single Review Data --}}
    {{ Form::open(array('url' => '/review/update', 'files' => true, 'id' => 'review_edit_form')) }}

    <input type="hidden" name="review_id" value="{{ isset($review->id) ? $review->id : '' }}">
    <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">

    <div class="reviews-edit">

        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="review-detail-head">
                            <div class="review-point"><p><span>{{ $averageRate }}</span><br/></p></div>
                            <div class="review-detail-number"><span class="gry-clr">2017-05-29 Reservation number <a
                                            href="#">12229993951</a></span> <a href="#">Your Booking reviews
                                    page</a></div>

                        </div>
                    </div>
                    <div class="panel-footer">
                            @forelse(array_chunk(getReviewsTaxonomies(), 2) as $chunk)
                                <div class="row">
                                    @foreach($chunk as $taxonomyReviews)
                                        {{-- Merging Single Review rating in all reviews--}}
                                        @php
                                            if(isset($review[$taxonomyReviews->id])){
                                                $rate = number_format($review[$taxonomyReviews->id], 1);
                                                if($rate == '10')
                                                {
                                                    $rate = '10';
                                                }
                                            }else{
                                                $rate = number_format('0', 1);
                                            }
                                        @endphp
                                        {{--  Merging Single Review rating in all reviews --}}

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="review-progress-small">
                                                <div class="inline-block text-left">{{ $taxonomyReviews->name }}</div>
                                                <div class="inline-block pull-right">{{ $rate }}</div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                                         aria-valuemin="0" aria-valuemax="100" style="width:{{ $rate * 10 }}%;">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            @empty

                            @endempty
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="review-detail-head">
                            <div class="review-point"><p><span>9.6</span><br/>Pier Luigi, (IT)</p></div>
                            <div class="review-detail-number"><span class="gry-clr">2017-05-29 Reservation number <a
                                            href="#">12229993951</a></span> <a href="#">Your Booking reviews
                                    page</a></div>

                            <div class="revie-comment">
                                <div class="smile"><i class="fa fa-smile-o" aria-hidden="true"></i></div>
                                <div class="comment">
                                    <div class="bold blue-head">Bella novita in Langhe</div>
                                    <div class="review-message">Finelmente una Struttura raffinata a misura
                                        d'uomo (solo 4 stanze in una casa di paese), e non le solite SPA
                                        senz'anima. Struttura nuovissima e curata nei dettagli. Arredamento
                                        minimalista e funzionale. Docce con getti idromassaggio. Colazione
                                        ricca e varia, E disponibile anchhe un menu.
                                    </div>
                                </div>
                                <a href="#" class="btn btn-comment">Reply</a>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">Staff</div>
                                    <div class="inline-block pull-right">10.0</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">Facilities</div>
                                    <div class="inline-block pull-right">10.0</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">cleanliness</div>
                                    <div class="inline-block pull-right">10.0</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">comfort</div>
                                    <div class="inline-block pull-right">10.0</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">Location</div>
                                    <div class="inline-block pull-right">10.0</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="review-progress-small">
                                    <div class="inline-block text-left">Value for money</div>
                                    <div class="inline-block pull-right">7.5</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:70%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>




            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="revie-score">

                    <p class="revie-head">your review score</p>
                    <div class="total-revie-score"><span>{{ $averageRate }}</span>based on {{ count($review) }} reviews</div>

                    {{-- Taxonomies reviews loop --}}
                    @forelse(getReviewsTaxonomies() as $taxonomyReviews)
                        <div class="score-point">
                            <p>{{ $taxonomyReviews->name }}</p>
                            <div class="panel panel-default">
                                <div class="point-middle">

                                    {{-- Merging Single Review rating in all reviews--}}
                                    @php
                                        if(isset($review[$taxonomyReviews->id])){
                                            $rate = number_format($review[$taxonomyReviews->id], 1);
                                            if($rate == '10')
                                            {
                                                $rate = '10';
                                            }
                                        }else{
                                            $rate = number_format('0', 1);
                                        }
                                    @endphp
                                    {{--  Merging Single Review rating in all reviews --}}


                                    <div class="point">{{ $rate }}</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width:{{ $rate * 10 }}%;">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        No Reviews Found
                    @endforelse

                    {{-- Taxonomies reviews loop --}}

                </div>
            </div>

        </div>


    </div>

    <div class="btn-shape">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12 btn-left-shape text-left"><a href="{{ url('reviews/list') }}" class="btn btn-default">@lang('messages.keyword_previous')</a></div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-right"><button type="submit"  class="btn btn-default">@lang('messages.keyword_save')</button></div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script src="{{ url('public/js/jquery.validate.min.js')}}"></script>
    <script src="{{ url('public/js/additional-methods.min.js') }}"></script>

@endsection
