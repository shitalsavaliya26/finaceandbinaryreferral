<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Package name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Package name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Image @if(@$package->image)- <a href="{{asset('uploads/pool-package/'.@$package->image)}}" target="_blank">{{@$package->image}}</a>@endif</label>
                {!! Form::file('image',['class'=>'form-control','placeholder'=>'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('image') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Dispaly Start</label> 
                 {!! Form::number('stacking_display_start',old('stacking_display_start'),['class'=>'form-control','placeholder'=>'Enter Staking Period (12 Month) Start','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_display_start') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Staking Dispaly End</label> 
                 {!! Form::number('stacking_display_end',old('stacking_display_end'),['class'=>'form-control','placeholder'=>'Enter Staking Period (12 Month) End','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('stacking_display_end') }}</span>
            </div> 
        </div>
    </div>
    <div class="row">    
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Symbol  @if(@$package->symbol)- <a href="{{asset('uploads/pool-package-symbol/'.@$package->symbol)}}" target="_blank">{{@$package->symbol}}</a>@endif</label>
                {!! Form::file('symbol',['class'=>'form-control']) !!}
                <span class="help-block text-danger">{{ $errors->first('symbol') }}</span>
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
    <div class="row">    
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Description</label>                 
                {!! Form::textarea('description', old('description'), ['class' => 'form-control form-control', 'rows' => 6,'placeholder' => 'Enter Description']) !!}
                <span class="help-block text-danger">{{ $errors->first('description') }}</span>
            </div>
        </div>
    </div>    
</div>
 
<hr>

<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('pool-packages.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


