<!DOCTYPE html>
<html lang="en">
<head>
  <title>Therma Europe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/jqColorPicker.min.js"></script>

<!--<script src="js/custom.js"></script>-->
<script src="js/jquery.scrollbar.js"></script>
  <script> 
	$( document ).ready(function() {
	
  $("#menu").load("menu.html"); 
 

    
});
</script>
</head>
<body>


<div class="main-wrap super-admin">
<div class="top-header">
	<div class="logo"><a href="index.html"><img src="images/logo.png" alt="logo"/></a></div>
    
    <div class="float-right">
    <div class="search-box-top"><input type="text" placeholder="Search for reservations"/></div>
    <div class="tab-menu">
    
     <ul class="nav nav-tabs" role="tablist">
            <li><a href="#ciao"  data-toggle="tab"> <img src="images/user.png" alt="User"/> <span>Ciao.</span> <p>Marco</p> </a></li>
            <li ><a href="#hotel"  data-toggle="tab"> <img src="images/hotel.png" alt="Hotel"/> <span>user</span> <p>id 784789</p> </a></li>
            <li ><a href="#lang"  data-toggle="tab"><img src="images/english.jpg" alt="English"/></a></li>
          </ul>
        
    
          <div class="tab-content"><div  class="tab-pan" id="ciao">
                	
                    <div class="user-menu-tab">
                    	<ul class="list-unstyled">
                    		<li><a href="my-profile.html">My Profile</a></li>
                            <li><a href="change-password.html">change passoword</a></li>
                            <li><a href="message.html">my notification</a></li>
                            <li><a href="#">Log out</a></li>
                        </ul>
                    </div>
                
                   <!-- <div class="radio round-checkbox">
                             <input type="radio" id="myprofile" name="ossm"> 
                            <label for="myprofile">my profile</label> 
                            <div class="check"><div class="inside"></div></div>
                    </div>
                    
                    <div class="radio round-checkbox">
                             <input type="radio" id="change-pass" name="ossm"> 
                            <label for="change-pass">change password</label> 
                            <div class="check"><div class="inside"></div></div>
                    </div>
                
                    <div class="radio round-checkbox">
                            <input type="radio" id="my-notifi" name="ossm"> 
                       		<label for="my-notifi">my notification</label>
                            <div class="check"><div class="inside"></div></div>
                    </div>
                
                    <div class="radio round-checkbox">
                             <input type="radio" id="log-out" name="ossm"> 
                            <label for="log-out">log out</label> 
                            <div class="check"><div class="inside"></div></div>
                    </div>-->
                    
			</div><div  class="tab-pane" id="hotel"><div class="search-box-top"><input type="text" placeholder="Search hotel"/></div>
            			<div class="add-new-hotel">
                        	<input type="text" placeholder="Add a new hotel"/><div class="search-link"><a href="basic-info.html"><img src="images/plus.png"/></a></div></div></div> <div  class="tab-pane" id="lang"><div class="search-box-top"><input type="text" placeholder="Language selector"/></div></div>
          </div>
     
    
          
    </div> 
    </div>
</div>


<div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="sidebar-wrapper">
        	<div class="side-heading"><h1>Admin</h1></div>
            <ul class="sidebar-nav third-step-dropdown">
                
                
                
                <li class="dropdown">
    <a href="setting.html" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">setting
    <span class="caret"></span></a>
    <ul class="dropdown-menu ">
                <li><a href="setting.html">Languages and Phases</a></li>
                <li><a href="currencies.html">currencies</a></li>
                <li><a href="email-template.html">Email template</a></li>
    </ul>
                </li>
                
                
              <li class="dropdown">
    <a href="taxonomies-hotel.html" class="btn btn-primary dropdown-toggle" type="button" >taxonomies
  <span class="caret"></span></a>
     
     <ul class="dropdown-menu ">
     	<li>
        	<ul class="sub-dropdown-menu">
            
            	<li class="dropdown">
    <a href="taxonomies-hotel.html" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">types & States
    <span class="caret"></span></a>
    <ul class="dropdown-menu ">
     <li><a href="taxonomies-hotel.html">hotel</a></li>
                <li><a href="taxonomies-booking.html">booking</a></li>
                <li><a href="taxonomies-customer.html">customer</a></li>
                <li><a href="taxonomies-payment.html">payment</a></li>
    </ul>
                </li>
                
                <li class="dropdown">
    <a href="#" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">sales
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="taxonomies-packages.html">Packages</a></li>
      <li><a href="taxonomies-promotions.html">Promotions</a></li>
      <li><a href="taxonomies-taxation.html">Taxation</a></li>
    </ul>
                </li>
                
            </ul>
        </li>
    </ul>
    
    
    </li>
        
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="page-content-wrapper">
        	<div id="menu"></div>  
            
            <!-------------------------------->
             <div class="content">
              
            
       <div class="taxonomies-wrap">     
          
            <div class="row">
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<div class="middle-head-add">
                        	<h3 class="heading">Add Type</h3>
                            <div class="row">
                                
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" required placeholder="Name">			
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control"  type="text" required placeholder="Description">			
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control color no-alpha" type="text" value="#B6BD79">			
                                    </div>
                                </div>
                                
                             </div>
                             
                            <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <div class="form-group"><button class="btn btn-default btn-6-12">add</button></div>
                                </div></div> 
         
                        </div>
                    </div>
                </div>
            
         <div class="section-border">   
         		
         
         		<div class="row">                          
                     <div class="col-md-12 col-sm-12 col-xs-12">	
                     <h1 class="cst-datatable-heading">hotel</h1>
                     
                     <div class="select-all">
                     	<div class="row">
                        	<div class="col-md-6 col-sm-6 col-xs-12"><div class="ryt-chk"><input id="chk-without" type="checkbox"><label for="chk-without">select all</label></div></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right"><button class="btn btn-default btn-6-12">Save selected</button><button class="btn btn-default btn-reject btn-6-12">delete seklected</button></div>
                        </div>
                     </div>
                     
                    <div class="table-responsive">
                                	
                                <table class="table table-striped table-bordered">
                                	<tr>
                                    	<td><div class="ryt-chk"><input id="chk-without-info" type="checkbox"><label for="chk-without-info"></label></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control color no-alpha" value="#000000"/></div></td>
                                        <td><button class="btn btn-default btn-6-12">Save</button><button class="btn btn-default btn-reject btn-6-12">delete</button></td>
                                    </tr>
                                    
                                    <tr>
                                    	<td><div class="ryt-chk"><input id="chk-without-info1" type="checkbox"><label for="chk-without-info1"></label></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control color no-alpha" value="#1f4887"/></div></td>
                                        <td><button class="btn btn-default btn-6-12">Save</button><button class="btn btn-default btn-reject btn-6-12">delete</button></td>
                                    </tr>
                                    
                                    <tr>
                                    	<td><div class="ryt-chk"><input id="chk-without-info2" type="checkbox"><label for="chk-without-info2"></label></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control color no-alpha" value="#000000"/></div></td>
                                        <td><button class="btn btn-default btn-6-12">Save</button><button class="btn btn-default btn-reject btn-6-12">delete</button></td>
                                    </tr>
                                    
                                    <tr>
                                    	<td><div class="ryt-chk"><input id="chk-without-info3" type="checkbox"><label for="chk-without-info3"></label></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control" value="Hotel Admin"/></div></td>
                                        <td><div class="form-group"><input type="text" class="form-control color no-alpha" value="#1f4887"/></div></td>
                                        <td><button class="btn btn-default btn-6-12">Save</button><button class="btn btn-default btn-reject btn-6-12">delete</button></td>
                                    </tr>
                                    
                                </table>
                                    
                                </div>
                            </div>
                 </div>
             </div>               
            </div>
       
</div>            
            <!---------------------------------->
            
            
            
        </div>
        <!-- /#page-content-wrapper -->

    </div>
  
</div>


</body>
</html>
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