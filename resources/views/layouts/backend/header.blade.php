<nav class="navbar navbar-static-top   cus-static-top " role="navigation" style="background-image: linear-gradient(to right, #cf62db , #3a1eb7);">
	<div class="navbar-header nav-logo-mob">
        <img src="{{url('/assets/images/assets/Register_Account/Group83.png')}}"  class="logo-header cus-height">
        {{-- <h3 style="margin-top: 18px;color:black">{{env('APP_NAME')}}</h3> --}}
    </div>
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2   cus-minibar text-white" href="#"><i class="fa fa-bars"></i> </a>
    </div>
    <ul class="nav navbar-top-links navbar-right nav-mobile-right">
		<li class="dropdown">
    		<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
				<span class="text-white">{{Auth::user()->name}}</span>
				<i class="fa fa-angle-top"></i>
    		</a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <div class="text-center link-block">
                        <a href="{{route('setting.index')}}">
                            <strong>Setting</strong>
                        </a>
					</div>
					<div class="text-center link-block">
						<a href="{{ route('admin.logout') }}" class="fw-700"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							 {{trans('Logout')}}
						</a>
                    </div>
                </li>
            </ul>
    	</li> 
    </ul>
</nav>