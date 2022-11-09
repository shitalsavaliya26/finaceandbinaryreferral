<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group848.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.dashboard')}}</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('stacks') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group955.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.staking_pools')}}</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-toggle="collapse" href="#node" aria-expanded="false" aria-controls="tables">
        <img src="{{ asset('assets/images/assets/Dashboard/Group953.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.nodes-management')}}</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="node">
        <ul class="nav flex-column sub-menu rounded-bottom">
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('node_register') }}">{{trans('custom.register')}}</a>
          </li>
          @if(auth()->user()->staking_history->count() > 0 ) 
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('node_management') }}">{{trans('custom.nodes')}}</a>
          </li>
          @endif
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-toggle="collapse" href="#wallets" aria-expanded="false" aria-controls="tables">
        <img src="{{ asset('assets/images/assets/Dashboard/Group952.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.wallets')}}</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="wallets">
        <ul class="nav flex-column sub-menu rounded-bottom">
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('crypto_wallets') }}">{{trans('custom.crypto_wallet')}}</a>
          </li>
          @if(auth()->user()->staking_history->count() > 0 ) 
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('yield_wallet') }}">{{trans('custom.yield_wallet')}}</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('commission_wallet') }}">{{trans('custom.commission-wallet')}}</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('nft_wallet') }}">{{trans('custom.nft_wallet')}}</a>
          </li>
          @endif
        </ul>
      </div>
    </li>
    <li class="nav-item nftproduct {{(\Request::is('nft_marketplace/*')) ? 'active':''}}">
      <a class="nav-link" href="{{ route('nft_marketplace') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group951.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{ __('custom.nft_marketplace')}} </span>
      </a>
    </li>
    @if(auth()->user()->staking_history->count() > 0 ) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('withdrawal') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group850.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.withdrawals')}}</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('ledger') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group956.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.Ledger')}}</span>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a class="nav-link collapsed" data-toggle="collapse" href="#account" aria-expanded="false" aria-controls="tables">
        <img src="{{ asset('assets/images/assets/Dashboard/Group851.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.accounts')}}</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="account">
        <ul class="nav flex-column sub-menu rounded-bottom">
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('account') }}">{{trans('custom.my-account')}}</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('my_collection') }}">{{ __('custom.my_collection')}}</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('sell_nft') }}">{{ __('custom.sell_nft')}}</a>
          </li>
        </ul>
      </div>
    </li>
    @if(auth()->user()->staking_history->count() > 0 ) 
    <li class="nav-item">
      <a class="nav-link collapsed" data-toggle="collapse" href="#news" aria-expanded="false" aria-controls="tables">
        <img src="{{ asset('assets/images/assets/Dashboard/Group2.png') }}" class="cus-sidebar-icon-news" alt="">
        <span class="menu-title">{{trans('custom.news')}}</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="news">
        <ul class="nav flex-column sub-menu rounded-bottom">
          <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('news-and-events.index') }}">{{trans('custom.news-events')}}</a>
          </li>
          <!-- <li class="nav-item"> 
            <a class="nav-link pl-0" href="{{ route('my_collection') }}">My Collection</a>
          </li> -->
        </ul>
      </div>
    </li>
    @endif
    
    <li class="nav-item">
      <a class="nav-link" href="{{ route('help_support.index') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Path1214.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.help_support')}}</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('helpandfaq') }}">
        <img src="{{ asset('assets/images/assets/Dashboard/Group1.png') }}" class="cus-sidebar-icon" alt="">
        <span class="menu-title">{{trans('custom.help_and_faq')}}</span>
      </a>
    </li>
    
  </ul>
</nav>