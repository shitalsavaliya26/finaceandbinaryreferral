<div class="col-sm-12">
    <div class="row ">
       <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Package name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Package name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Package Amount</label> 
                 {!! Form::number('amount',old('amount'),['class'=>'form-control','placeholder'=>'Enter Pakage amount','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('amount') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Period (12 Month) Start</label> 
                 {!! Form::number('stacking_actual12_start',old('stacking_actual12_start',@$package->stacking_actual12_start),['class'=>'form-control','placeholder'=>'Enter Staking Period (12 Month) Start','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_actual12_start') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Period (12 Month) End</label> 
                 {!! Form::number('stacking_actual12_end',old('stacking_actual12_end',@$package->stacking_actual12_end),['class'=>'form-control','placeholder'=>'Enter Staking Period (12 Month) End','min'=>'0', 'id' => 'stacking_actual12_end']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_actual12_end') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Period (24 Month) Start</label> 
                 {!! Form::number('stacking_actual24_start',old('stacking_actual24_start',@$package->stacking_actual24_start),['class'=>'form-control','placeholder'=>'Enter Staking Period (24 Month) Start','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_actual24_start') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Period (24 Month) End</label> 
                 {!! Form::number('stacking_actual24_end',old('stacking_actual24_end',@$package->stacking_actual24_end),['class'=>'form-control','placeholder'=>'Enter Staking Period (24 Month) End','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_actual24_end') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Direct Refferal</label> 
                 {!! Form::number('direct_refferal',old('direct_refferal'),['class'=>'form-control','placeholder'=>'Enter Pakage Direct Refferal','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('direct_refferal') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Network Pairing</label> 
                 {!! Form::number('network_pairing',old('network_pairing'),['class'=>'form-control','placeholder'=>'Enter Pakage Network Pairing','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('network_pairing') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Daily Limit</label> 
                 {!! Form::number('daily_limit',old('daily_limit'),['class'=>'form-control','placeholder'=>'Enter Pakage Daily Limit','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('daily_limit') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Status</label> <br>
                <label>{!! Form::radio('status','active',@$package->status=='inactive'?false:true,[]) !!} Active</label> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>{!! Form::radio('status','inactive',@$package->status=='active'?true:false,[]) !!} Inactive</label>
                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
            </div> 
        </div>
    </div>    
</div>
 
<hr>

<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('packages.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


