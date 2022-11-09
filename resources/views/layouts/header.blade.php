 <nav class="navbar col-lg-12 col-12 p-0 d-flex flex-row shadow-none">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
 
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-end justify-content-end justify-content-md-between">
    <div class="d-none d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown align-self-md-end">
        <div class="ml-2 mx-4">
          <div class="">
            <div class="navigation-cus">
             <div class="cus-dropdown text-right mb-3 select-lang-de mt-3">
              <select style=" height:35px;" class="form-control cus-bg-tra-b" data-width="fit"
              onchange="javascript:window.location.href='<?php echo $local_url; ?>/'+this.value;">
              <option <?php if(app()->getLocale() == 'en'){ echo 'selected' ;} ?> value="en"
                data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
                <option <?php if(app()->getLocale() == 'cn'){ echo 'selected' ;} ?> value="cn"
                  data-content='<span class="flag-icon flag-icon-cn"></span> China'>中文(Chinese)</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{auth()->user()->profile_image}}" alt="">
        </a>
          <div class="ml-2">
            <h4 class="text-warning font-weight-bold mb-0">{{auth()->user()->name}}</h4>
            <!-- <span>Active</span> -->
          </div>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          {{-- <a class="dropdown-item">
            <i class="ti-settings text-primary"></i>
            Settings
          </a> --}}
          <a class="dropdown-item"  href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-primary"></i>
            {{trans('custom.logout')}}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </li>
    </ul>
  </div>
</nav>
