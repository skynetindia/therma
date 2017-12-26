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

	                                       	<li><a href="{{url('home')}}"><img src="{{asset('public/images/home.png')}}" alt="Home"/><p>Home</p></a></li>
                                        	<li><a href="{{url('manage-users.html')}}"><img src="{{asset('public/images/manage-user.png')}}" alt="manage-user"/><p>Users</p></a></li>
                                        	<!--<li><a href="{{url('role-management.html')}}"><img src="{{asset('public/images/role-management.png')}}" alt="Role Management"/><p>Role management</p></a></li>-->
                                        	<li><a href="{{url('message.html')}}"><img src="{{asset('public/images/message.png')}}" alt="Message"><p>Messages</p></a></li>
                                            <li><a href="{{url('hotel-property-listing.html')}}"><img src="{{asset('public/images/hotel-list.png')}}" alt="Hotel List"/><p>hotel property listing</p></a></li>
                                            <li><a href="{{url('booking.html')}}"><img src="{{asset('public/images/booking.png')}}" alt="Booking"><p>booking</p></a></li>
                                        <!--    <li><a href="{{url('calendar.html')}}"><img src="{{asset('public/images/calendar.png')}}" alt="calendar"><p>Calendar</p></a></li>-->
                                            <li><a href="{{url('package.html')}}"><img src="{{asset('public/images/manage-package.png')}}" alt="Manage Package"/><p>package / Promotions</p></a></li>
                                        <!--    <li><a href="{{url('promotions.html')}}"><img src="{{asset('public/images/promotion.png')}}" alt="Promotion"><p>Promotions</p></a></li>-->
                                    	   <li><a href="{{url('wizard.html')}}"><img src="{{asset('public/images/wizard.png')}}" alt="wizard"/><p>wizard</p></a></li>
                                     <!--       <li><a href="{{url('discount-offer.html')}}"><img src="{{asset('public/images/discount-offer.png')}}" alt="Discount Offer"/><p>discount offer </p></a></li> -->
                                            <li><a href="{{url('reviews.html')}}"><img src="{{asset('public/images/review.png')}}" alt="Comment"/><p>reviews </p></a></li>
                                            <li><a href="{{url('payment.html')}}"><img src="{{asset('public/images/manage-payment.png')}}" alt="Manage Payment"/><p>payment / invoice</p></a></li>
                                        <!--    <li><a href="{{url('invoice.html')}}"><img src="{{asset('public/images/invoices.png')}}" alt="Invoices"><p>Invoices</p></a></li>-->
                                            <li><a href="{{url('language')}}"><img src="{{asset('public/images/settings.png')}}"/><p>Settings</p></a></li>
                                         <!--   <li><a href="{{url('member-activity.html')}}"><img src="{{asset('public/images/member-activity.png')}}" alt="Message"><p>member activity</p></a></li>-->
                                         <!--   <li><a href="{{url('taxonomies-hotel.html')}}"><img src="{{asset('public/images/taxonomies.png')}}"/><p>Taxonomies</p></a></li>-->
                                           	<li><a href="{{url('report.html')}}"><img src="{{asset('public/images/stats.png')}}" alt="Stats"><p>Reports & Statistics</p></a></li> 
                                        
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