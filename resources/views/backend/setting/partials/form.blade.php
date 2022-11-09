    {!! Form::open(['route' => ['setting.store'],'autocomplete'=>'false','id'=>'genral_setting','class'=>'fix-input','files'=>true]) !!}
    {!! Form::hidden('type','general_setting') !!}
    <div class="ibox ">
        {{-- <div class="ibox-content ibox-border-rad cus-heght-full"> --}}
        <div class="ibox-content ibox-border-rad">
            <h4 class="p-b-sm">General Settings</h4>
            <div class="row ">
                <div class="col-sm-12 ">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Admin Email Address</label>                 
                                    {!! Form::email('admin_email',old('admin_email',@$setting['admin_email']),['class'=>'form-control','placeholder'=>'Enter Admin Email address']) !!}
                                    <span class="help-block text-danger">{{ $errors->first('admin_email') }}</span>
                                </div>
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Withdrawal Fees</label> 
                                    {!! Form::number('withdrawal_fee',old('withdrawal_fee',@$setting['withdrawal_fee']),['class'=>'form-control','placeholder'=>'Enter Withdrawal fees','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('withdrawal_fee') }}</span>
                                </div> 
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Minimum Stackingpool Amount</label> 
                                    {!! Form::number('min_stackingpool_amount',old('min_stackingpool_amount',@$setting['min_stackingpool_amount']),['class'=>'form-control','placeholder'=>'Enter Minimum stackingpool amount','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('min_stackingpool_amount') }}</span>
                                </div> 
                            </div>
                            {{-- <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Withdrawal window from day</label> 
                                    {!! Form::number('withdrawal_window_from_day',old('withdrawal_window_from_day',@$setting['withdrawal_window_from_day']),['class'=>'form-control','placeholder'=>'Enter Withdrawal window from day','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('withdrawal_window_from_day') }}</span>
                                </div> 
                            </div>  --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>USD 1 = USDT</label> 
                                    {!! Form::text('bank_usdt_amount',old('bank_usdt_amount',@$setting['bank_usdt_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to USDT']) !!}
                                    <span class="help-block text-danger">{{ $errors->first('bank_usdt_amount') }}</span>
                                </div>
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>USD 1 = MYR</label> 
                                    {!! Form::text('bank_myr_amount',old('bank_myr_amount',@$setting['bank_myr_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to MYR']) !!}
                                    <span class="help-block text-danger">{{ $errors->first('bank_myr_amount') }}</span>
                                </div>
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Date Format</label> 
                                    <br>
                                    {{ Form::select('date_format',$dateformat,@$setting['date_format'],['class' => 'form-control']) }}
                                    <span class="help-block text-danger">{{ $errors->first('date_format') }}</span>
                                </div>
                            </div> 
                            {{-- <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Withdrawal window to day</label> 
                                    {!! Form::number('withdrawal_window_to_day',old('withdrawal_window_to_day',@$setting['withdrawal_window_to_day']),['class'=>'form-control','placeholder'=>'Enter Withdrawal window to day','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('withdrawal_window_to_day') }}</span>
                                </div> 
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Allow first withdrawal after days</label> 
                                    {!! Form::number('allow_first_withdrawal_after_days',old('allow_first_withdrawal_after_days',@$setting['allow_first_withdrawal_after_days']),['class'=>'form-control','placeholder'=>'Allow first withdrawal after days','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('allow_first_withdrawal_after_days') }}</span>
                                </div> 
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Minimum withdrawal request amount</label> 
                                    {!! Form::number('min_withdrawal_request_amount',old('min_withdrawal_request_amount',@$setting['min_withdrawal_request_amount']),['class'=>'form-control','placeholder'=>'Minimum withdrawal request amount','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('min_withdrawal_request_amount') }}</span>
                                </div> 
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>NFT Commission(%)</label> 
                                    {!! Form::number('nft_commission',old('nft_commission',@$setting['nft_commission']),['class'=>'form-control','max'=>'100','placeholder'=>'Enter Nft Commission(%)','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('nft_commission') }}</span>
                                </div> 
                            </div>
                            {{-- <div class="col-sm-4 pl-0 ">
                                <div class="form-group">
                                    <label>Minimum stock wallet investment amount</label> 
                                    {!! Form::number('min_stock_wallet_investment_amount',old('min_stock_wallet_investment_amount',@$setting['min_stock_wallet_investment_amount']),['class'=>'form-control','placeholder'=>'Minimum stock wallet investment amount','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('min_stock_wallet_investment_amount') }}</span>
                                </div> 
                            </div> --}}
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-4 pl-0 ">
                            <div class="form-group">
                                    <label>Profit Sharing Commission Percent Level-1</label> 
                                    {{-- {!! Form::number('rebate_comm_perc_level_1',old('rebate_comm_perc_level_1',@$setting['rebate_comm_perc_level_1']),['class'=>'form-control','placeholder'=>'Enter Profit Sharing Commission Percent Level-1','min'=>0]) !!}
                                    <span class="help-block text-danger">{{ $errors->first('rebate_comm_perc_level_1') }}</span> --}}
                                </div> 
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                            <div class="form-group">
                                    <label>Profit Sharing Commission Percent Level-2</label> 
                                    {{-- {!! Form::number('rebate_comm_perc_level_2',old('rebate_comm_perc_level_2',@$setting['rebate_comm_perc_level_2']),['class'=>'form-control','placeholder'=>'Enter Profit Sharing Commission Percent Level-2','min'=>0]) !!} --}}
                                    {{-- <span class="help-block text-danger">{{ $errors->first('rebate_comm_perc_level_2') }}</span> --}}
                                </div> 
                            </div> 
                            <div class="col-sm-4 pl-0 ">
                            <div class="form-group">
                                    <label>Profit Sharing Commission Percent Level-3</label> 
                                    {{-- {!! Form::number('rebate_comm_perc_level_3',old('rebate_comm_perc_level_3',@$setting['rebate_comm_perc_level_3']),['class'=>'form-control','placeholder'=>'Enter Profit Sharing Commission Percent Level-3','min'=>0]) !!} --}}
                                    {{-- <span class="help-block text-danger">{{ $errors->first('rebate_comm_perc_level_3') }}</span> --}}
                                </div> 
                            </div> 
                        </div>  --> 
                        {{-- @role('admin')--}}
                        <div class="row">
                            <div class="col-sm-4 pl-0 ">
                                <button class="btn  btn-primary m-t-xs" type="submit"><strong>Save</strong></button>
                            </div>   
                        </div>
                        {{-- @endrole --}}
                    </div>  
                </div>   
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    {{-- <div class="row  d-flex">
        <div class="col-sm-12 ">
            {!! Form::open(['route' => ['setting.store'],'autocomplete'=>'false','id'=>'bank_setting','class'=>'fix-input','files'=>true]) !!}
            {!! Form::hidden('type','bank_setting') !!}
            <div class="ibox ">
                <div class="ibox-content ibox-border-rad cus-heght-full">
                    <h4 class="p-b-sm">Payment Bank Details</h4>
                    <div class="col-sm-4 pl-0 ">
                        <div class="form-group">
                            <label>Bank Account Name</label>                 
                            {!! Form::text('bank_acc_name',old('bank_acc_name',@$setting['bank_acc_name']),['class'=>'form-control','placeholder'=>'Enter Bank account name']) !!}
                            <span class="help-block text-danger">{{ $errors->first('bank_acc_name') }}</span>
                        </div>
                    </div> 
                    <div class="col-sm-4 pl-0 ">
                        <div class="form-group">
                            <label>Bank Name</label> 
                            {!! Form::text('bank_name',old('bank_name',@$setting['bank_name']),['class'=>'form-control','placeholder'=>'Enter Bank Name']) !!}
                            <span class="help-block text-danger">{{ $errors->first('bank_name') }}</span>
                        </div> 
                    </div> 
                    <div class="col-sm-4 pl-0 ">
                     <div class="form-group">
                        <label>Account Number</label> 
                        {!! Form::text('bank_acc_no',old('bank_acc_no',@$setting['bank_acc_no']),['class'=>'form-control','placeholder'=>'Enter Bank account number']) !!}
                        <span class="help-block text-danger">{{ $errors->first('bank_acc_no') }}</span>
                    </div> 
                </div>     
                <div class="col-sm-4 pl-0 ">        
                    <div class="form-group">
                        <label>Account opening</label> 
                        {!! Form::text('bank_acc_no_cn',old('bank_acc_no_cn',@$setting['bank_acc_no_cn']),['class'=>'form-control','placeholder'=>'Enter account opening number']) !!}
                        <span class="help-block text-danger">{{ $errors->first('bank_acc_no_cn') }}</span>
                    </div>       
                </div>
                <div class="col-sm-4 pl-0 ">
                    <div class="form-group">
                        <label>China Bank Account Name</label>                 
                        {!! Form::text('cn_bank_acc_name',old('cn_bank_acc_name',@$setting['cn_bank_acc_name']),['class'=>'form-control','placeholder'=>'Enter Bank account name']) !!}
                        <span class="help-block text-danger">{{ $errors->first('cn_bank_acc_name') }}</span>
                    </div>
                </div> 
                <div class="col-sm-4 pl-0 ">
                    <div class="form-group">
                        <label>China Bank Name</label> 
                        {!! Form::text('cn_bank_name',old('cn_bank_name',@$setting['cn_bank_name']),['class'=>'form-control','placeholder'=>'Enter Bank Name']) !!}
                        <span class="help-block text-danger">{{ $errors->first('cn_bank_name') }}</span>
                    </div> 
                </div> 
                <div class="col-sm-4 pl-0 ">
                 <div class="form-group">
                    <label>China Account Number</label> 
                    {!! Form::text('cn_bank_acc_no',old('cn_bank_acc_no',@$setting['cn_bank_acc_no']),['class'=>'form-control','placeholder'=>'Enter Bank account number']) !!}
                    <span class="help-block text-danger">{{ $errors->first('cn_bank_acc_no') }}</span>
                </div> 
            </div>     
            <div class="col-sm-4 pl-0 ">        
                <div class="form-group">
                    <label>China Account opening</label> 
                    {!! Form::text('cn_bank_swift_no',old('cn_bank_swift_no',@$setting['cn_bank_swift_no']),['class'=>'form-control','placeholder'=>'Enter account opening number']) !!}
                    <span class="help-block text-danger">{{ $errors->first('cn_bank_swift_no') }}</span>
                </div>       
            </div>
            <div class="col-sm-4 pl-0 ">                      
                <div class="form-group">
                    <label>USD 1 = RMB</label> 
                    {!! Form::text('todays_cn_rate',old('todays_cn_rate',@$setting['todays_cn_rate']),['class'=>'form-control','placeholder'=>'Conversion rate USD to RMB']) !!}
                    <span class="help-block text-danger">{{ $errors->first('todays_cn_rate') }}</span>
                </div> 
            </div>
            <div class="col-sm-4 pl-0 ">
                <div class="form-group">
                    <label>USD 1 = IDR</label> 
                    {!! Form::text('bank_idr_amount',old('bank_idr_amount',@$setting['bank_idr_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to IDR']) !!}
                    <span class="help-block text-danger">{{ $errors->first('bank_idr_amount') }}</span>
                </div>
            </div> 
            <div class="col-sm-4 pl-0 ">                      
                <div class="form-group">
                    <label>USD 1 = YUN</label> 
                    {!! Form::text('bank_yun_amount',old('bank_yun_amount',@$setting['bank_yun_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to YUN']) !!}
                    <span class="help-block text-danger">{{ $errors->first('state') }}</span>
                </div> 
            </div>
            <div class="col-sm-4 pl-0 ">
                <div class="form-group">
                    <label>USD 1 = USDT</label> 
                    {!! Form::text('bank_usdt_amount',old('bank_usdt_amount',@$setting['bank_usdt_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to USDT']) !!}
                    <span class="help-block text-danger">{{ $errors->first('bank_usdt_amount') }}</span>
                </div>
            </div> 
            <div class="col-sm-4 pl-0 ">
                <div class="form-group">
                    <label>USD 1 = MYR</label> 
                    {!! Form::text('bank_myr_amount',old('bank_myr_amount',@$setting['bank_myr_amount']),['class'=>'form-control','placeholder'=>'Conversion rate USD to MYR']) !!}
                    <span class="help-block text-danger">{{ $errors->first('bank_myr_amount') }}</span>
                </div>
            </div> 
            <div class="clearfix"></div>
            @role('admin')
            <div class="col-sm-4 pl-0 ">
                <button class="btn  btn-primary m-t-xs" type="submit"><strong>Save</strong></button>
            </div>  
            @endrole
            <div class="clearfix"></div>
        </div>    
    </div>
    {!! Form::close() !!}    
</div>  
</div>
 --}}

