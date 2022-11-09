 <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">          
            <li >
                <a href="{{route('admin.dashboard')}}" title="Dashboard"><i class="fa fa-th-large"></i> <span class="nav-label"> Dashboard</span></a>
            </li> 
            {{-- <li class=" @if(strstr(\Request::route()->getName(),'ticket') || strstr(\Request::route()->getName(),'ticket_request')) {{'active'}} @endif">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="">
                    <li class=" @if(\Request::is('admin/user') || \Request::is('admin/user/*')) {{'active'}} @endif">
                        <a href="{{route('user.index')}}" title="Manage Users"><i class="fa fa-users"></i><span class="nav-label"> Manage Users</span></a>
                    </li>
                    @php $proof_count = Helper::getPendingProofCount() @endphp
                    <li class=" @if(strstr(\Request::route()->getName(),'proof_request')) {{'active'}} @endif">
                        <a href="{{route('proof_request.index')}}" title="Proof Request"><i class="fa fa-file-o"></i><span class="nav-label"> Proof Request <span class="label label-info pull-right">{{$proof_count}}</span></span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'package_history')) {{'active'}} @endif">
                        <a href="{{route('package_history.index')}}" title="Package History"><i class="fa fa-list-alt"></i><span class="nav-label"> Package History</span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'payment_history')) {{'active'}} @endif">
                        <a href="{{route('payment_history.index')}}" title="Package History"><i class="fa fa-list-alt"></i><span class="nav-label"> Payment History</span></a>
                    </li>
                    @php $count = Helper::getUnreadCount() @endphp
                    <li class=" @if(strstr(\Request::route()->getName(),'support_ticket')) {{'active'}} @endif">
                        <a href="{{route('support_ticket.index1','all')}}" title="Payment History"><i class="fa fa-question-circle"></i><span class="nav-label"> Support</span><span class="label label-info pull-right">{{$count}}</span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'ticket') || strstr(\Request::route()->getName(),'ticket_request')) {{'active'}} @endif">
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">Ticket Request</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="">
                        <li class=" @if(\Request::is('admin/package_setting') || \Request::is('admin/package_setting/*')) {{'active'}} @endif"><a href="{{route('ticket_request.index')}}">Without Receipt</a></li>
                        <li class=" @if(\Request::is('admin/rank_setting')|| \Request::is('admin/rank_setting/*')) {{'active'}} @endif"><a href="{{route('ticket_request.show','request-2')}}">With Receipt</a></li>
                    </ul>
                </li>
                </ul>
            </li>         --}}
            {{-- <li class=" @if(strstr(\Request::route()->getName(),'ticket') || strstr(\Request::route()->getName(),'ticket_request')) {{'active'}} @endif">
                <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Wallet</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="">
                    <li class=" @if(\Request::is('admin/admin_fund_wallet')) {{'active'}} @endif">
                        <a href="{{route('admin_fund_wallet.index')}}" title="Bank Credits Requests"><i class="fa fa-bank"></i><span class="nav-label"> Bank Credits Requests</span></a>
                    </li>
                    <li class=" @if(\Request::is('admin/withdrawal_request') || \Request::is('admin/withdrawal_request/*')) {{'active'}} @endif">
                        <a href="{{route('withdrawal_request.index')}}" title="Withdrawal Requests"><i class="fa fa-send-o"></i><span class="nav-label"> Withdrawal Requests</span></a>
                    </li>
                    <li class=" @if(\Request::is('admin/mt4-wallet-withdrawl-requests')) {{'active'}} @endif">
                        <a href="{{route('mt4_withdrawal_requests')}}" title="MT5 Withdrawal Requests"><i class="fa fa-users"></i><span class="nav-label">MT5 Withdrawal Requests</span></a>
                    </li>
                    <li class=" @if(\Request::route()->getName() =='admin_pips_rebate.index' || \Request::route()->getName()=='admin_pips_rebate.import') {{'active'}} @endif">
                        <a href="{{route('admin_pips_rebate.index')}}" title="Pips Rebates"><i class="fa fa-cubes"></i><span class="nav-label">Pips Rebates</span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'profit_sharing')) {{'active'}} @endif">
                        <a href="{{route('profit_sharing.index')}}" title="MT4 Top-up Requests"><i class="fa fa-money"></i><span class="nav-label">Profit Sharing</span></a>
                    </li>
                </ul>
            </li>  --}}
            {{-- <li class=" @if(strstr(\Request::route()->getName(),'ticket') || strstr(\Request::route()->getName(),'ticket_request')) {{'active'}} @endif">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Reports</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="">
                     <li class=" @if(strstr(\Request::route()->getName(),'report.user')) {{'active'}} @endif">
                        <a href="{{route('report.user')}}" title="User Report"><i class="fa fa-money"></i><span class="nav-label">User Report</span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'report.show')) {{'active'}} @endif">
                        <a href="{{route('report.show','user-wallet-report')}}" title="User Report"><i class="fa fa-money"></i><span class="nav-label">User Wallet Report</span></a>
                    </li>
                    <li class=" @if(strstr(\Request::route()->getName(),'report.fund_withdrawal_report')) {{'active'}} @endif">
                        <a href="{{route('report.fund_withdrawal_report')}}" title="User Report"><i class="fa fa-exchange"></i><span class="nav-label">FundIn Withdrawal Report</span></a>
                    </li>
                </ul>
            </li>            
            <li class=" @if(\Request::is('admin/package_setting') || \Request::is('admin/rank_setting')|| \Request::is('admin/setting') || \Request::is('admin/package_setting/*') || \Request::is('admin/rank_setting/*')|| \Request::is('admin/general_setting/*')) {{'active'}} @endif">
                <a href="#"><i class="fa fa-gear"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="">
                    <li class=" @if(\Request::is('admin/setting')) {{'active'}} @endif"><a href="{{route('setting.index')}}">General Setting</a></li>
                    <li class=" @if(\Request::is('admin/package_setting') || \Request::is('admin/package_setting/*')) {{'active'}} @endif"><a href="{{route('package_setting.index')}}">Package Setting</a></li>
                    <li class=" @if(\Request::is('admin/rank_setting')|| \Request::is('admin/rank_setting/*')) {{'active'}} @endif"><a href="{{route('rank_setting.index')}}">Rank Setting</a></li>
                </ul>
            </li> --}}
            {{-- <div class="footerlogodiv">
                <a title="CMS" href="javascript:void(0)">
                   <span class="nav-label colorwhite"> <b class="ml18">Powered by,</b>
                    <div>
                        <img src="" alt="Logo"  class="footerlogo">
                    </div>
                   </span> 
                </a>
            </div> --}}
        </ul>
    </div>
</nav>
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>