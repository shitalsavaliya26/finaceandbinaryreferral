<div class="row">
    <div class="col-12 pb-3">
        <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        {!! trans('custom.withdrawal_wallet_terms_and_conditions1') !!}
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        {!! trans('custom.withdrawal_wallet_terms_and_conditions2') !!}
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        {!! trans('custom.withdrawal_wallet_terms_and_conditions3') !!}
    </div>
    <div class="col-12 mt-4">
        <div class="login-gradient rounded text-white py-4 px-md-5 text-center text-md-left">
            <div class="row">
                <div class="col-12 col-md-6 col-xl-auto">
                    <h4 class="mb-0">{{($user->userbank['account_number']) ? $user->userbank['account_number'] : '-'}}</h4>
                    <span class="font-12">{{ trans('custom.account_no')}}</span>
                </div>
                <div class="col-12 col-md-6 col-xl-auto mt-4 mt-md-0">
                    <h4 class="mb-0">{{($user->userbank['account_holder']) ? $user->userbank['account_holder'] : '-'}}</h4>
                    <span class="font-12">{{ trans('custom.account_name')}}</span>
                </div>
                <div class="col-12 col-md-6 col-xl-auto mt-4 mt-xl-0">
                    <h4 class="mb-0">{{($user->userbank['name']) ? $user->userbank['name'] : '-'}}  </h4>
                    <span class="font-12">{{ trans('custom.bank_name')}}</span>
                </div>
                <div class="col-12 col-md-6 col-xl-auto mt-4 mt-xl-0">
                    <h4 class="mb-0">{{($user->userbank['bank_country_id']) != null ? $user->userbank->country['country_name'] : '-'}}</h4>
                    <span class="font-12">{{ trans('custom.bank_location')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>