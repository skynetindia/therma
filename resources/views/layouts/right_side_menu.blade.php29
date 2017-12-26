<div id="sidebar-wrapper" class="sidebar-wrapper">
  <div class="side-heading"><h1>@lang('messages.keyword_admin')</h1></div>
 <?php
    $request = parse_url($_SERVER['REQUEST_URI']);
    $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/betasystemtherma/', '', $request["path"]), '/') : ltrim($request["path"],'/');
    $cpath = explode('/',$path);    
    $last = end($cpath);   

  ?>




@if(!in_array('login', $cpath) && !in_array('logout', $cpath) && !in_array('wizard',$cpath))
  @if(checkIfLinkExist($path) == true )
    {{-- This will run when primary url found --}}
    {!! checkUrlAndGetMenus($path) !!}
  @else
    {{-- This will run when secondary means edit or update or other urls found --}}
    {!! checkUrlAndGetMenus(Session::get('main_link')) !!}
  @endif
@elseif(in_array('wizard',$cpath))


  {{--Category listing--}}
  <!--  Tree view  -->
    @if(count(fetPrimaryCategory()) > 0)
      @foreach(fetPrimaryCategory() as $primary_category)
        <ul class="sidebar-nav third-step-dropdown">
          <li class="dropdown">
            <a href="javascript:void(0)" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> {{ $primary_category->name }} <span class="caret"></span></a>
          </li>
        </ul>

        @if(count(fetSecondaryCategory($primary_category->id)) > 0 )
          @foreach(fetSecondaryCategory($primary_category->id) as $sub_cat)
            <ul class="sidebar-nav third-step-dropdown">
              <li class="dropdown">
                <ul class="dropdown-menu">
                  <li><a href="{{ url('wizard/options/')."/".$sub_cat->id }}" class="{{ ($sub_cat->id == $last) ? 'active' : '' }}">{{ $sub_cat->name }} </a></li>
                </ul>
              </li>
            </ul>

            @if(count(fetSecondaryCategory($sub_cat->id)) > 0)
              @foreach(fetSecondaryCategory($sub_cat->id) as $third_cat)
                <ul class="sidebar-nav third-step-dropdown">
                  <li class="dropdown">
                    <ul class="dropdown-menu">
                      <li><a href="{{ url('wizard/options/')."/".$third_cat->id }}" class="{{ ($third_cat->id == $last) ? 'active' : '' }}">&nbsp; &nbsp; &nbsp; -- {{ $third_cat->name }} </a></li>
                    </ul>
                  </li>
                </ul>
              @endforeach
            @endif
          @endforeach
        @endif
      @endforeach

    @endif
  <!--  Tree view  -->

  {{--Category listing--}}

@elseif(in_array('allotment',$cpath))

    {{--Allot Ment--}}
        <ul class="sidebar-nav third-step-dropdown">
            <li class="dropdown">
                <a href="" class="btn btn-primary dropdown-toggle " >Hello</a>
            </li>
        </ul>
    {{--Allot Ment--}}

@endif



  <div class="sidebar-footer hidden-small">
    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Home"> <span class="fa fa-home" aria-hidden="true"> </span> </a>
    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite"> <span class="fa fa-star-o" aria-hidden="true"></span> </a>
    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ticket"> <span class="fa fa-ticket" aria-hidden="true"></span> <span class="count-ticket">10</span></a>
    <a href="#" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="Therma"><span> β</span> </a>
    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Profile"> <span class="fa fa-user" aria-hidden="true"> </span>  </a>
    <a href="javascript:void(0)" onClick="FullScreen()" data-toggle="tooltip" data-placement="top" title="" data-original-title="FullScreen"> <span class="fa fa-arrows-alt" aria-hidden="true"></span> </a>
    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><span class="fa fa-trash" aria-hidden="true"></span> </a>
    <a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <span class="fa fa-sign-out" aria-hidden="true"></span> </a>
  </div>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
  </form>



</div>
<script>
    //appendUserType
    $(function(){

        $.ajax({
            url: '{{ url('/appendUserType') }}',
            method: "GET",
            success: function(data){
                $(".appendUserType").after(data);
            }
        });


    });
</script>


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

