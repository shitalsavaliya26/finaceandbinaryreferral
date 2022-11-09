<div class="col-sm-12">
    <div class="row ">
       <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Rank Name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Rank Name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div> 
        
        {{-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Request Direct Sale</label> 
                 {!! Form::number('req_direct_sale',old('req_direct_sale'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Request Direct Sale']) !!}
                <span class="help-block text-danger">{{ $errors->first('req_direct_sale') }}</span>
            </div> 
        </div> --}}
         <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Investment</label> 
                 {!! Form::number('investment',old('investment'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Investment.']) !!}
                <span class="help-block text-danger">{{ $errors->first('investment') }}</span>
            </div> 
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Addtional Benifit</label> 
                 {!! Form::number('addtional_benifit',old('addtional_benifit'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Addtional Benifit']) !!}
                <span class="help-block text-danger">{{ $errors->first('addtional_benifit') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Total No Of Sponsors</label> 
                 {!! Form::number('no_of_sponsors',old('no_of_sponsors'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Total No Of Sponsors']) !!}
                <span class="help-block text-danger">{{ $errors->first('no_of_sponsors') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Personal Monthly Sale</label> 
                 {!! Form::number('personal_monthly_sale',old('personal_monthly_sale'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Personal Monthly Sale']) !!}
                <span class="help-block text-danger">{{ $errors->first('personal_monthly_sale') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Personal Monthly Group Sale</label> 
                 {!! Form::number('personal_monthly_group_sale',old('personal_monthly_group_sale'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Personal Monthly Group Sale']) !!}
                <span class="help-block text-danger">{{ $errors->first('personal_monthly_group_sale') }}</span>
            </div> 
        </div>
        {{-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Addtional Benifit</label> 
                 {!! Form::number('addtional_benifit',old('addtional_benifit'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Addtional Benifit']) !!}
                <span class="help-block text-danger">{{ $errors->first('addtional_benifit') }}</span>
            </div> 
        </div> --}}
        {{-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Own Package</label> 
                 {!! Form::select('own_package',$packages,old('own_package'),['class'=>'form-control','placeholder'=>'Enter Own Package']) !!}
                <span class="help-block text-danger">{{ $errors->first('own_package') }}</span>
            </div> 
        </div>   --}}
        {{-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Direct Downline</label> 
                 {!! Form::number('direct_downline',old('direct_downline'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Direct Downline']) !!}
                <span class="help-block text-danger">{{ $errors->first('direct_downline') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Direct Downline Package</label> 
                 {!! Form::number('direct_downline_packages',old('direct_downline_packages'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Direct Downline Package']) !!}
                <span class="help-block text-danger">{{ $errors->first('direct_downline_packages') }}</span>
            </div> 
        </div>  
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Total Downline Packages</label> 
                 {!! Form::number('total_downline_packages',old('total_downline_packages'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Total Downline Packages']) !!}
                <span class="help-block text-danger">{{ $errors->first('total_downline_packages') }}</span>
            </div> 
        </div> --}}
        <!-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Package Amount</label> 
                 {{-- {!! Form::number('downline_criteria',old('downline_criteria'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Pakage amount']) !!} --}}
                <span class="help-block text-danger">{{ $errors->first('downline_criteria') }}</span>
            </div> 
        </div>   -->
        {{-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Pips Rebate Commission</label> 
                 {!! Form::number('pips_rebate_commission',old('pips_rebate_commission'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Pips Rebate Commission']) !!}
                <span class="help-block text-danger">{{ $errors->first('pips_rebate_commission') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Overridding Of Package</label> 
                 {!! Form::number('overriding_of_package',old('overriding_of_package'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Overridding Of Package']) !!}
                <span class="help-block text-danger">{{ $errors->first('overriding_of_package') }}</span>
            </div> 
        </div>  
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Leader Bonus</label> 
                 {!! Form::number('leaders_bonus',old('leaders_bonus'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Leader Bonus']) !!}
                <span class="help-block text-danger">{{ $errors->first('leaders_bonus') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Profit Sharing</label> 
                 {!! Form::number('profit_sharing',old('profit_sharing'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Profit Sharing']) !!}
                <span class="help-block text-danger">{{ $errors->first('profit_sharing') }}</span>
            </div> 
        </div> --}}   
    </div> 
    <!-- <div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Status</label> <br>
                <label>{!! Form::radio('status','active',@$package->status!='active'?false:true,[]) !!} Active</label> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>{!! Form::radio('status','Inactive',@$package->status!='active'?true:false,[]) !!} Inactive</label>
                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
            </div> 
        </div>    
    </div>     -->
</div>
<div class="">
    <button class="btn btn-md btn-primary m-t-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-xs" href="{{route('rank_setting.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


