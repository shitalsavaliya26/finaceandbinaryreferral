<div class="col-sm-12">
    <div class="row">
        <input type="hidden" name="packageid" id="packageid" value="{{ $package->id }}">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Symbol</label> 
                 {!! Form::text('symbol',old('symbol'),['class'=>'form-control','placeholder'=>'Enter Symbol']) !!}
                <span class="help-block text-danger">{{ $errors->first('symbol') }}</span>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Icon @if(@$product->image)- <a href="{{asset('uploads/nft-product/'.@$product->image)}}" target="_blank">{{@$product->image}}</a>@endif</label>
                {!! Form::file('image',['class'=>'form-control','placeholder'=>'Enter url', 'accept'=>'image/*']) !!}
                <span class="help-block text-danger">{{ $errors->first('image') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Price</label> 
                 {!! Form::number('price',old('price'),['class'=>'form-control','placeholder'=>'Enter price','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('price') }}</span>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Coingecko ID</label> 
                {!! Form::text('chain',old('chain'),['class'=>'form-control','placeholder'=>'Enter Coingecko ID']) !!}
                <span class="help-block text-danger">{{ $errors->first('chain') }}</span>
            </div>
        </div>
        <!-- <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Address</label> 
                 {!! Form::text('address',old('address'),['class'=>'form-control','placeholder'=>'Enter Address']) !!}
                <span class="help-block text-danger">{{ $errors->first('address') }}</span>
            </div> 
        </div> -->
    </div>
</div>
<hr>
<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('stacking-pools-coin.show',[$package->id])}}">Cancel</a>
</div>
<div class="clearfix"></div>
