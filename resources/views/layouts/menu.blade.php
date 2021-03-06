<div class="navigation-wrap">
            <div class="container-fluid">
                <div class="row">
                    		<div class="col-lg-12">	
                            	<div class="navbar-header">
                                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                    <i class="fa fa-bars" aria-hidden="true"></i>                       
                                  </button>
                                </div>
	                            <div class="collapse navbar-collapse" id="myNavbar">
                                    <div class="scrollbar-inner">
                                    <nav class="navbar navbar-default">

                                        <ul class="nav navbar-nav">
                                            @if(count(fetPrimaryDynamicMenu()) > 0)
                                                @foreach(fetPrimaryDynamicMenu() as $primary_dynamic_menu)
                                                    <li><a href="{{ url($primary_dynamic_menu->link) }}" class="{{ ($primary_dynamic_menu->menu_class) ? $primary_dynamic_menu->menu_class : '' }}"><img src="{{ asset('public/images/dynamic_menu')."/".$primary_dynamic_menu->image }}" alt="Home"/><p>{{ $primary_dynamic_menu->name }}</p></a></li>
                                                @endforeach
                                            @endif

                                            {{--<li class="divider"><a href=""></a>divide</li>--}}


	                                       	{{--<li><a href="{{url('home')}}"><img src="{{asset('public/images/home-nav.svg')}}" alt="Home"/><p>Home</p></a></li>--}}
                                        	{{--<li><a href="{{url('users')}}"><img src="{{asset('public/images/user-nav.svg')}}" alt="manage-user"/><p>Users</p></a></li>--}}
                                        	{{--<!--<li><a href="{{url('role-management.html')}}"><img src="{{asset('public/images/role-management.png')}}" alt="Role Management"/><p>Role management</p></a></li>-->--}}
                                        	{{--<li><a href="{{url('message/alert')}}"><img src="{{asset('public/images/email-nav.svg')}}" alt="Message"><p>Messages</p></a></li>--}}
                                            {{--<li><a href="{{url('hotel')}}"><img src="{{asset('public/images/hotel-nav.svg')}}" alt="Hotel List"/><p>hotel property listing</p></a></li>--}}
                                            {{--<li><a href="{{url('bookings')}}"><img src="{{asset('public/images/booking-nav.svg')}}" alt="Booking"><p>booking</p></a></li>--}}
                                        {{--<!--    <li><a href="{{url('calendar.html')}}"><img src="{{asset('public/images/calendar.png')}}" alt="calendar"><p>Calendar</p></a></li>-->--}}
                                            {{--<li><a href="{{url('packages')}}"><img src="{{asset('public/images/promotions-nav.svg')}}" alt="Manage Package"/><p>package / Promotions</p></a></li>--}}
                                        {{--<!--    <li><a href="{{url('promotions.html')}}"><img src="{{asset('public/images/promotion.png')}}" alt="Promotion"><p>Promotions</p></a></li>-->--}}
                                    	    {{--<li><a href="{{url('wizard/options').'/'.getFirstOptionOnList() }}"><img src="{{asset('public/images/magic-wand-nav.svg')}}" alt="wizard"/><p>wizard</p></a></li>--}}
                                     {{--<!--       <li><a href="{{url('discount-offer.html')}}"><img src="{{asset('public/images/discount-offer.png')}}" alt="Discount Offer"/><p>discount offer </p></a></li> -->--}}
                                            {{--<li><a href="{{url('reviews/list')}}"><img src="{{asset('public/images/review.png')}}" alt="Comment"/><p>reviews </p></a></li>--}}
                                            {{--<li><a href="{{url('payment.html')}}"><img src="{{asset('public/images/payment-nav.svg')}}" alt="Manage Payment"/><p>payment / invoice</p></a></li>--}}
                                        {{--<!--    <li><a href="{{url('invoice.html')}}"><img src="{{asset('public/images/invoices.png')}}" alt="Invoices"><p>Invoices</p></a></li>-->--}}
                                            {{--<li><a href="{{url('language')}}"><img src="{{asset('public/images/settings-nav.svg')}}"/><p>Settings</p></a></li>--}}
                                         {{--<!--   <li><a href="{{url('member-activity.html')}}"><img src="{{asset('public/images/member-activity.png')}}" alt="Message"><p>member activity</p></a></li>-->--}}
                                         {{--<!--   <li><a href="{{url('taxonomies-hotel.html')}}"><img src="{{asset('public/images/taxonomies.png')}}"/><p>Taxonomies</p></a></li>-->--}}
                                           	{{--<li><a href="{{url('report.html')}}"><img src="{{asset('public/images/chart-nav.svg')}}" alt="Stats"><p>Reports & Statistics</p></a></li>--}}
                                        {{----}}
										</ul>
                                        
                                    </nav>
                                 </div>   
                                 </div>
                            </div>
                    </div>
                </div>
            </div>
            
            
<script>
    jQuery(document).ready(function(){
        jQuery('.scrollbar-inner').scrollbar();
    });
</script>


  <script>	
		$('.user-menu-tab ul li a').on('click',function(){
  /*$('div').removeClass('active');*/
  $(this).addClass('active');
});
</script>


<script>
    jQuery(document).ready(function(){
        jQuery('.scrollbar-inner').scrollbar();
    });
</script>


<script>

    function FullScreen() {

        if ((document.fullScreenElement && document.fullScreenElement !== null) ||

            (!document.mozFullScreen && !document.webkitIsFullScreen)) {

            if (document.documentElement.requestFullScreen) {

                document.documentElement.requestFullScreen();

            } else if (document.documentElement.mozRequestFullScreen) {

                document.documentElement.mozRequestFullScreen();

            } else if (document.documentElement.webkitRequestFullScreen) {

                document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);

            }

        } else {

            if (document.cancelFullScreen) {

                document.cancelFullScreen();

            } else if (document.mozCancelFullScreen) {

                document.mozCancelFullScreen();

            } else if (document.webkitCancelFullScreen) {

                document.webkitCancelFullScreen();

            }

        }

    }

</script>
