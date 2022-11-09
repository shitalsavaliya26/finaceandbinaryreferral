<div class="">
    <div class="ibox-content ibox-border-rad cus-heght-full col-sm-12">
        <h4 class="p-b-sm">Personal details</h4>
        <!-- <h3 class="m-t-none m-b">Personal details</h3> -->
        <div class="row">
            <div class="col-sm-4 ">
                <div class="form-group">
                    <label>Full name</label>
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Full name', 'id' => 'fullname']) !!}
                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Identification Number</label>
                    {!! Form::text('ic_number', old('ic_number', $user->identification_number), ['class' => 'form-control', 'placeholder' => 'Enter Identification Number', 'maxlength' => 12, 'id' => 'ic_number']) !!}
                    <span class="help-block text-danger">{{ $errors->first('ic_number') }}</span>
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="form-group">
                    <label>Phone number</label>
                    {!! Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'placeholder' => 'Enter Phone Number']) !!}
                    <span class="help-block text-danger">{{ $errors->first('phone_number') }}</span>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-6 ">
                <div class="form-group">
                    <label>Address</label>
                    {!! Form::textarea('address', old('address'), ['class' => 'form-control form-control', 'rows' => 6, 'style' => 'resize:none', 'placeholder' => 'Enter Address']) !!}
                    <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="row">
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>State</label>
                            {!! Form::text('state', old('state'), ['class' => 'form-control', 'placeholder' => 'Enter State']) !!}
                            <span class="help-block text-danger">{{ $errors->first('state') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>City</label>
                            {!! Form::text('city', old('city'), ['class' => 'form-control', 'placeholder' => 'Enter City']) !!}
                            <span class="help-block text-danger">{{ $errors->first('city') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 m-t-sm ">
                        <div class="form-group">
                            <label>Country</label>
                            {!! Form::select('country', $counties, old('country', @$user->country_id), ['class' => 'form-control', 'placeholder' => 'Select Country', 'id' => 'country_id']) !!}
                            <span class="help-block text-danger">{{ $errors->first('country') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
            </div>
        </div>
    </div>
    <div class="row d-flex ">
        <div class=" col-sm-6 m-t-lg">
            <div class="ibox-content ibox-border-rad cus-heght-full">
                <h4 class="p-b-sm">Account Details</h4>
                <div class="row ">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter Email']) !!}
                            <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Username</label>
                            {!! Form::text('username', old('username', @$user->username), ['class' => 'form-control', 'placeholder' => 'Enter Username', 'readonly']) !!}
                            <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Login Password</label>
                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Enter Password']) !!}
                            <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Repeat Login Password</label>
                            {!! Form::password('retype_password', ['class' => 'form-control', 'placeholder' => 'Enter Repeat Password']) !!}
                            <span class="help-block text-danger">{{ $errors->first('retype_password') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Security Password</label>
                            {!! Form::password('secure_password', ['class' => 'form-control', 'id' => 'secure_password', 'placeholder' => 'Enter Security Password']) !!}
                            <span class="help-block text-danger">{{ $errors->first('secure_password') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Repeat Security Password</label>
                            {!! Form::password('retype_secure_password', ['class' => 'form-control', 'placeholder' => 'Enter Repeat Security Password']) !!}
                            <span
                                class="help-block text-danger">{{ $errors->first('retype_secure_password') }}</span>
                        </div>
                    </div>

                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Sponsor Name</label>
                            {!! Form::text('sponsor', old('sponsor', isset($user->sponsor) && $user->sponsor != null ? $user->sponsor->username : ''), ['class' => 'form-control', 'placeholder' => 'Enter Sponsor', 'id' => 'sponsor_username','readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6  ">
                        <div class="form-group">
                            <label>Placement Name</label>
                            {!! Form::text('placement_username', old('placement_username', isset($user->placementusername) && $user->placementusername != null ? $user->placementusername->username : ''), ['class' => 'form-control', 'placeholder' => 'Enter Placement', 'id' => ' 	placement_username','readonly']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <div class="checkbox ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-sm-6 m-t-lg">
        <div class="ibox-content ibox-border-rad cus-heght-full">
            <h4 class="p-b-sm">Bank Details</h4>
            <div class="row">
                <div class="col-sm-12  ">
                    <div class="form-group">
                        <label>Name of Bank</label>
                        {!! Form::text('bank_name', old('bank_name', isset($user->userbank) && $user->userbank != null ? $user->userbank->name : ''), ['class' => 'form-control', 'placeholder' => 'Enter Name of Bank']) !!}
                        <span class="help-block text-danger">{{ $errors->first('bank_name') }}</span>
                    </div>
                </div>
                <div class="col-sm-12  ">
                    <div class="form-group">
                        <label>Name of Account Holder</label>
                        {!! Form::text('acc_holder_name', old('acc_holder_name', isset($user->userbank) && $user->userbank != null ? $user->userbank->account_holder : ''), ['class' => 'form-control', 'placeholder' => 'Enter Account Holder Name','readonly','id'=> 'acc_holder_name']) !!}
                        <span class="help-block text-danger">{{ $errors->first('acc_holder_name') }}</span>
                    </div>
                </div>
                <div class="col-sm-6  ">
                    <div class="form-group">
                        <label>Account Number</label>
                        {!! Form::text('acc_number', old('acc_number', isset($user->userbank) && $user->userbank != null ? $user->userbank->account_number : ''), ['class' => 'form-control', 'placeholder' => 'Enter Account Number']) !!}
                        <span class="help-block text-danger">{{ $errors->first('acc_number') }}</span>
                    </div>
                </div>
                <div class="col-sm-6  ">
                    <div class="form-group">
                        <label>Swift Code</label>
                        {!! Form::text('swift_code', old('swift_code', isset($user->userbank) && $user->userbank != null ? $user->userbank->swift_code : ''), ['class' => 'form-control', 'placeholder' => 'Enter Swift Code']) !!}
                        <span class="help-block text-danger">{{ $errors->first('swift_code') }}</span>
                    </div>
                </div>
                <div class="col-sm-6  ">
                    <div class="form-group">
                        <label>Bank Branch</label>
                        {!! Form::text('branch', old('branch', isset($user->userbank) && $user->userbank != null ? $user->userbank->branch : ''), ['class' => 'form-control', 'placeholder' => 'Enter Bank Branch']) !!}
                        <span class="help-block text-danger">{{ $errors->first('branch') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Bank Account Country</label>
                        {!! Form::select('bank_country_id', $counties, old('bank_country_id', @$user->userbank['bank_country_id']), ['class' => 'form-control', 'placeholder' => 'Select Bank Account Country']) !!}
                        <span class="help-block text-danger">{{ $errors->first('bank_country_id') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row d-flex ">
    <div class=" col-sm-6 m-t-lg">
        <div class="ibox-content ibox-border-rad cus-heght-full">
            <h4 class="p-b-sm">User Agreement</h4>
            <p>I hereby attest and certify that the above information is complete and accurate and I agree to be bound
                by these terms and conditions. I also authorize to verify and or all of the foregoing
                information. This electronic signature has the same validity and effect as a signature affixed by hand.
            </p>
            <p>Please check the boxes below to acknowledge your acceptance, agreement and understanding of these terms
                and agreements</p>
            <div class="row">
                <div class="col-sm-6">
                    <div class="col-sm-12">
                        <div class="checkbox ">
                            {!! Form::checkbox('terms_condition[]', 'antimoney_laundering', isset($user->user_agreement) && @$user->user_agreement->antimoney_laundering != 0 ? true : false, ['class' => 'ml-0', 'id' => 'antimoney_laundering']) !!}
                            <label for="antimoney_laundering">
                                <a href="{{asset('terms/antimoney_laundering.pdf')}}" target="_blank" class="font-regular text-darkGrey">Anti-Money Laundering</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <div class="checkbox ">
                            {!! Form::checkbox('terms_condition[]', 'coockie_policy', isset($user->user_agreement) && @$user->user_agreement->coockie_policy != 0 ? true : false, ['class' => 'ml-0', 'id' => 'coockie_policy']) !!}

                            <label for="coockie_policy">
                                <a href="{{asset('terms/coockie_policy.pdf')}}" target="_blank" class="font-regular text-darkGrey">Cookie Policy</a>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 ">
                        <div class="checkbox ">
                            {!! Form::checkbox('terms_condition[]', 'privacy_policy', isset($user->user_agreement) && @$user->user_agreement->privacy_policy != 0 ? true : false, ['class' => 'ml-0', 'id' => ' privacy_policy']) !!}
                            <label for=" privacy_policy">
                                <a href="{{asset('terms/privacy_policy.pdf')}}" target="_blank" class="font-regular text-darkGrey">Privacy Policy</a>
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-12 ">
                        <div class="checkbox ">
                            {!! Form::checkbox('terms_condition[]', 'risk_disclosure', isset($user->user_agreement) && @$user->user_agreement->risk_disclosure  != 0 ? true : false, ['class' => 'ml-0', 'id' => 'user_agreement']) !!}
                            <label for="risk_disclosure">
                                <a href="{{asset('terms/risk_disclosure.pdf')}}" target="_blank" class="font-regular text-darkGrey">Risk Disclosure</a>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 ">
                        <div class="checkbox ">
                            {!! Form::checkbox('terms_condition[]', 'terms_and_condition', isset($user->user_agreement) && @$user->user_agreement->terms_and_condition != 0 ? true : false, ['class' => 'ml-0', 'id' => 'terms_and_condition']) !!}
                            <label for="terms_and_condition">
                                <a href="{{asset('terms/terms_and_condition.pdf')}}" target="_blank" class="font-regular text-darkGrey">Terms Of Use</a>
                            </label>
                        </div>
                    </div>

                    <label id="terms_condition_edit_error_msg"style="color:#c71d25 !important;font-weight: 600;"></label>
                </div>
            </div>
            <span class="help-block text-danger">{{ $errors->first('terms_condition') }}</span>
        </div>
    </div>
</div>
<div class="row d-flex ">
    <div class="col-sm-6">
        <div class="ibox-content ibox-border-rad cus-heght-full m-t-lg">
            <h4 class="p-b-sm">Other Details</h4>
            <div class="row ">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">User Status</label> <br>
                        <label>{!! Form::radio('status', 'active', $user->status != 'active' ? false : true, []) !!} Active</label>
                        <label>{!! Form::radio('status', 'inactive', $user->status != 'active' ? true : false, []) !!} Inactive</label>
                        <span class="help-block text-danger">{{ $errors->first('package_id') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">PROMO Account</label> <br>
                        <label>{!! Form::radio('promo_account','1',$user->promo_account!='0'?true:false,[]) !!} Yes</label>
                        <label>{!! Form::radio('promo_account','0',$user->promo_account!='1'?true:false,[]) !!} No</label>
                        <span class="help-block text-danger">{{ $errors->first('promo_account') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<hr>
<div class="m-t-lg">
    <button class="btn btn-primary " type="submit"><strong>Save</strong></button>
    <a class="btn btn-danger " href="{{ \URL::previous() }}"><strong>Cancel</strong></a>
</div>
<div class="clearfix"></div>
