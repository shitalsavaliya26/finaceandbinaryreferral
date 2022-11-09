 @extends('layouts.app')
 @section('title', __('custom.staking_pool'))
 @section('page_title', __('custom.staking_pool'))

 @section('content')
 <div class="content-wrapper staking-pool-indi">
   <div class="ml-2 mb-4 d-none-desk d-md-block">
    <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
    @if(Route::currentRouteName() == 'dashboard')
    <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
    @endif
  </div>
  <div class="row align-items-center pt-5">
    <div class="col-12 col-xl-5">
      <div class="card">
        <div class="card-body">
          <div class="row px-md-4 py-2">
            <div class="col-12 col-md-4">
              <h1 class="text-violate rounded-circle font-weight-bold text-center alpha-symbol"><img class="stake-logo" src="{{$stakingpool->symbol}}" class="img-fluid card-img-top" alt=""></h1>
            </div>
            <div class="col-12 col-md-8">
              <h3 class="text-blue font-weight-bold">{{$stakingpool->name}}</h3>
            </div>
            <!-- <div class="col-12 mt-2">
              <p class="font-12">{{$stakingpool->description}}</p>
            </div> -->
            <div class="col-12 col-md-12">
              <p class="border-violate my-3"></p>
            </div>
            <div class="col-12 col-md-7">
              <p class="text-blue font-12 font-weight-bold">{{__('custom.expected_anual_rate')}}</p>
              <h3 class="text-blue font-weight-bold mt-2">{{$stakingpool->stacking_display_start}}% - {{$stakingpool->stacking_display_end}}%</h3>
            </div>
            @if($totalInvested > 0)
            <div class="col-12 col-md-5 px-xl-0">
              <p class="text-blue font-12 font-weight-bold">{{str_replace('<br>','',__('custom.invested_amount'))}}</p>
              <button class="btn bg-blue text-white rounded-0 w-100">${{number_format($totalInvested,2)}}</button>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 tokenp col-xl-7 text-white mt-4 mt-xl-0">
      <div class="row text-white">
        @foreach($stakingpool->stackingpoolcoins as $coin)
        <div class="col-12 col-md-6">
          <div class="indv d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{$coin->icon}}" class="img-fluid w-70 " alt="">
              <h4>{{$coin->name}}</h4>
            </div>
            <div>
              <h3>${{number_format($coin->price,2)}}</h3>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <hr class="border-white mt-5" />
  <div class="row mt-5">
    <div class="col-12 col-xl-4">
      <div>
        <h3 class="text-white pb-3">{{__('custom.staking_history')}}</h3>
      </div>
      <div class="table-responsive table-history">
        @include('stacking_pool.stack_history')
      </div>

    </div>
    <div class="col-12 col-xl-8 mt-4 mt-xl-0 pl-xl-5 staf">
      <div>
        <h3 class="text-white pb-3">{{__('custom.terms_conditions')}}</h3>
      </div>
      {!!__('custom.staking_terms')!!}
      <div>
        <h3 class="text-white pb-3 mt-4">{{__('custom.stake_now')}}</h3>
      </div>
      <form method="post" action="{{ route('staking_pool') }}" id="staking_pool">
        @csrf
        <div class="row align-items-center bg-warning px-3 py-4 rounded">
          <div class="col-12 col-md-12">
           @if(Session::has('success'))
           <div class="alert alert-success alert-dismissable">
             {{ Session::get('success') }}
           </div>
           @endif

           @if(Session::has('error'))
           <div class="alert alert-danger alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             {{ Session::get('error') }}
           </div>
           @endif
         </div>
         <div class="col-12 col-md-7">
          <input type="hidden" name="stacking_pool_package_id" value="{{$stakingpool->id}}">
          <input type="text" name="amount" class="form-control h-auto py-4" placeholder="{{__('custom.stake_amount')}}" id="amount">
          @error('amount')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror
       </div>
       <div class="col-12 col-md-5 mt-3 mt-md-0">
        <h3 class="font-weight-bold"><span class="font-12">{{trans('custom.available_fund')}}</span> ${{($user->userwallet) ? number_format($user->userwallet->crypto_wallet,2) : '0.00' }}</h3>
      </div>
      <div class="col-12 col-md-7 mt-3">
        <input type="hidden" name="name" id="name" value="{{$stakingpool->name}}">
        <input name="security_password" id="security_password" type="password" class="form-control h-auto py-4" placeholder="{{ trans('custom.security_password') }}">
        @error('secure_password')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
       </span>
       @enderror
     </div>
     <div class="col-12 col-md-5 mt-3">
      <select name="duration" id="duration" class="form-control h-auto py-4">
        <option value="">{{__('custom.duration_term')}}</option>
        <option value="12">12 {{__('custom.months')}}</option>
        <option value="24">24 {{__('custom.months')}}</option>
        @error('duration')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
       </span>
       @enderror
     </select>
   </div>
   <input type="hidden" name="package" id="package" value="{{$stakingpool->name}}">
   <input type="hidden" name="signature" id="poolsignature" value="">

   <input type="hidden" name="agreement" id="agreement">
   <div class="col-12 mt-3">
    <button class="btn bg-white text-warning p-4 rounded-0 w-100 text-uppercase">{{__('custom.stake')}} <img src="{{ asset('images/assets/Dashboard/Group930.png') }}" class="img-fluid d-inline align-middle ml-4" alt=""></button>
  </div>
</div>
</form>
</div>
</div>
@foreach($user_investments as $user_investment)
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="points-alert" aria-hidden="true"  id="planExpiredModal{{$user_investment->id}}">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content cus-blue-bg text-white">
      <div class="modal-header">
        <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span> {{trans('custom.staking_popup_title')}}</h5>
      </div>
      <div class="modal-body">
        {{Form::open(['route' => ['stake-plan-change',':id'],'class' => '','id' =>'stake-plan-change'.$user_investment->id,'class' =>'stake-plan-change','enctype' => 'multipart/form-data','method'=>'POST'])}}
        <div class="font-16 text-left">
          {{trans('custom.investment_desc')}}
          <div id="planExpiredContent{{$user_investment->id}}"></div>
          <div class="col-lg-3 form-group-sub mr-btn" >
            <div class="form-group row mt-3">
              <button type="submit" class="btn btn-primary cus-width-full cus-bg-green ">{{trans('custom.submit')}}</button>
            </div>
          </div>
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>
@endforeach

<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="points-alert" aria-hidden="true"  id="stakingpoolagreement">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content cus-blue-bg text-white">
      <div class="modal-header">
        <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span> <span id="agreetitle">{{trans('custom.agreement_title')}}</span></h5>
      </div>
      <div class="modal-body">
        {{Form::open(['','class' => '','id' =>'staking_agreement','class' =>'staking_agreement','enctype' => 'multipart/form-data','method'=>'POST'])}}
        <div class="font-16 text-left">
          {!!trans('custom.staking_agreement')!!}
          <div class="col-12 col-md-12">
           <div class="card rounded-0" style="background-color:transparent;">
            <div class="card-body">
              <label class="" for="">{{__('custom.signature')}}</label>
              <br/>
              <div id="sigpad"></div>
              <br><br>
              <button id="clear" class="btn btn-danger rounded-0">{{__('custom.clear_signature')}}</button>
              <textarea id="signature" name="signature" style="display: none"></textarea>
            </div>
          </div>
        </div>
        <div class="col-12 align-items-center mt-3">
          <input type="checkbox" name="terms_agree" id="terms_agree"><label class="font-10 ml-2 text-coffee" for="terms_agree">{{trans('custom.accept_terms')}}</label> 
        </div>
        <label id="terms_agree-error" class="error col-12" for="terms_agree"></label>
        <div class="col-lg-12 form-group-sub mr-btn" >
          <div class="form-group row mt-3">
            <button type="button" class="btn bg-primary text-white rounded-0  mr-3" id="cancelstaking">{{trans('custom.cancel')}}</button>
            <button type="submit" class="btn bg-warning text-white py-4 px-5 rounded-0 ">{{trans('custom.confirm')}}</button>
          </div>
        </div>
      </div>
      {{Form::close()}}
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/custom/stacking_pool.js').'?v='.time() }}"></script>
<script type="text/javascript">
  $(document).ready(function(e) {
    $('.nav-item').removeClass('active');
    $('.collapse').removeClass('show');
    $('.staking').addClass('active');

  })
  var plan_get = "{{route('stock-market-investment-period',':id')}}";
  @if(count($user_investments) > 0)
  @foreach($user_investments as $user_investment)
  var id = '{{$user_investment->id}}';
  plan_get_action = plan_get.replace(':id',id);
  var action = $('#stake-plan-change{{$user_investment->id}}').attr('action');
  action = action.replace(':id',id);
  $('#stake-plan-change{{$user_investment->id}}').attr('action',action)
  $.get(plan_get_action,function(response){
    if(response.status == 'success'){
      $('#planExpiredContent{{$user_investment->id}}').html(response.html);
      $("#planExpiredModal{{$user_investment->id}}").modal('show');
    }else{
      alert('Bank Proofs are not available');
    }
  });
  $("#stake-plan-change{{$user_investment->id}}").validate({

    ignore: "input[type='text']:hidden",
    rules: {
      changeplan: {
        required: true,
      },
      time_period: {
        required: '#changeplan{{$user_investment->id}}:checked',
      },
      iagreechange: {
        required: true,
      }
    },
    messages: {
      time_period: {
        required: select_period,
      },
      iagreechange:{
        required: please_accept_aggrement
      }

    },
    submitHandler: function(form) {
      var text = "";
      if($("input:radio[name=changeplan]:checked").val() == 'changeplan'){
        text = "You want to renew investment with duration "+' '+$('#duration').val()+" Months !";
      }
      swal({
        title: "Are you sure? ",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4B49AC",
        confirmButtonText: "Yes",
        closeOnConfirm: false
      }, function(isConfirm){
        if (isConfirm) form.submit();
      });
    }
  });
  $(document).on('change','#time_period{{$user_investment->id}}',function(e) {
    end_period1 = end_period.replace(':date',$(this).val());
    if($(this).val() != ''){

      $('#time_period-error{{$user_investment->id}}').text('');
      $('#end_period{{$user_investment->id}}').text(end_period1);
      $('#plan{{$user_investment->id}}').val($( "#time_period{{$user_investment->id}} option:selected" ).text());
    }else{
      $('#end_period{{$user_investment->id}}').text('');
      $('#plan{{$user_investment->id}}').val('');
    }
  });
  $(document).on('change','input:radio[name=changeplan]',function(e) {
    if($(this).val() == 'changeplan'){
      $('#changeplanDis'+$(this).data('id')).show();
      $('#close_investmentDis'+$(this).data('id')).hide();
    }else if($(this).val() == 'close_investment'){
     $('#changeplanDis'+$(this).data('id')).hide();
     $('#close_investmentDis'+$(this).data('id')).show(); 
   }else{
    $('#changeplanDis'+$(this).data('id')).hide();
    $('#close_investmentDis'+$(this).data('id')).hide(); 
  }
});
  @endforeach
  @endif
</script>

@endsection
