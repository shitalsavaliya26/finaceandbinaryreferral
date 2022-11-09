<div class="col-sm-12">
    <div class="row ">
       <div class="col-sm-12 pl-0 ">
        <div class="form-group">
            <label>Name</label>                 
            {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter name']) !!}
            <span class="help-block text-danger">{{ $errors->first('name') }}</span>
        </div>
    </div> 
</div>
<div class="row ">
    <div class="col-sm-12 pl-0 ">
        <div class="form-group">
            <label>USDT Address</label> 
            {!! Form::text('value',old('value'),['class'=>'form-control','placeholder'=>'Enter USDT Address']) !!}
            <span class="help-block text-danger">{{ $errors->first('value') }}</span>
        </div> 
    </div>    
</div>  
<div class="row ">
    <div class="col-sm-12 pl-0 ">
        <div class="form-group">
            <label>QRCode Image</label>
            {!! Form::file('image',['class'=>'form-control']) !!}
            <span class="help-block text-danger">{{ $errors->first('image') }}</span>
        </div>
    </div> 
</div>
<div class="row ">
    <div class="col-sm-12 pl-0 ">
        <div class="form-group">
            <label>Status</label> <br>
            <label>{!! Form::radio('status','1',@$usdt_address->status==0?false:true,[]) !!} Active</label> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>{!! Form::radio('status','0',@$usdt_address->status==0?true:false,[]) !!} Inactive</label>
            <span class="help-block text-danger">{{ $errors->first('status') }}</span>
        </div> 
    </div>    
</div> 
</div>

<hr>

<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('usdt_address.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


