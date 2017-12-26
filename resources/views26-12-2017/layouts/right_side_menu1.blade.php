<div id="sidebar-wrapper" class="sidebar-wrapper">
  <div class="side-heading"><h1>Admin</h1></div><?php
    $request = parse_url($_SERVER['REQUEST_URI']);
    $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/thermapro/', '', $request["path"]), '/') : $request["path"];
    $cpath = explode('/',$path);

    $last = end($cpath);    
    if($last == 'home') {
      ?><ul class="sidebar-nav"><li><a href="{{url('index.html')}}" class="active">dashboard</a></li></ul><?php 
    }
    elseif(in_array('hotel',$cpath)){
      ?><ul class="sidebar-nav">                
          <li><a class="active" href="{{url('hotel')}}">manage hotel property</a></li>
          <li><a href="hotel-options.html">hotels options</a></li>
          <li><a href="hotel-prices.html">hotels prices</a></li>
      </ul><?php
    }
    else if(in_array('category', $cpath)){
      ?><ul class="sidebar-nav">
      <li><a class="active" href="{{url('category')}}">Category</a></li>
    </ul><?php
    }
    else {
    ?><ul class="sidebar-nav third-step-dropdown">
    <li class="dropdown">
      <a href="setting.html" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">setting <span class="caret"></span></a>
      <ul class="dropdown-menu ">
        <li><a class="active" href="{{url('language')}}">Languages and Phases</a></li>
        <li><a href="{{url('currencies.html')}}">currencies</a></li>
        <li><a href="{{url('email-template.html')}}">Email template</a></li>
      </ul>
    </li>
  <li class="dropdown"><a href="{{url('taxonomies-hotel.html')}}" class="btn btn-primary dropdown-toggle" type="button">taxonomies</a>   
   <ul class="dropdown-menu ">
    <li>
      <ul class="sub-dropdown-menu">          
        <li class="dropdown"><a href="{{url('taxonomies-hotel.html')}}" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">types & States<span class="caret"></span></a>
        <ul class="dropdown-menu ">
          <li><a href="{{url('taxonomies-hotel.html')}}">hotel</a></li>
          <li><a href="{{url('taxonomies-booking.html')}}">booking</a></li>
          <li><a href="{{url('taxonomies-customer.html')}}">customer</a></li>
          <li><a href="{{url('taxonomies-payment.html')}}">payment</a></li>
        </ul>
        </li>
        <li class="dropdown"><a href="#" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">sales<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="{{url('taxonomies-packages.html')}}">Packages</a></li>
          <li><a href="{{url('taxonomies-promotions.html')}}">Promotions</a></li>
          <li><a href="{{url('taxonomies-taxation.html')}}">Taxation</a></li>
        </ul>
        </li>
      </ul>
    </li>
  </ul>
  </li>
</ul><?php } ?>
</div>