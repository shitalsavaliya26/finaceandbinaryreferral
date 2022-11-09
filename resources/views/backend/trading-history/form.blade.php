<div class="col-sm-12">
    <div class="row">
        <input type="hidden" name="productid" id="productid" value="{{ $product->id }}">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Amount</label> 
                 {!! Form::number('purchase_amount',old('purchase_amount'),['class'=>'form-control','placeholder'=>'Enter amount','min'=>'0']) !!}
                <span class="help-block text-danger">{{ $errors->first('purchase_amount') }}</span>
            </div> 
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Date</label> 
                 {!! Form::date('date',old('date'),['class'=>'form-control']) !!}
                <span class="help-block text-danger">{{ $errors->first('date') }}</span>
            </div> 
        </div>
    </div>
</div>
<hr>
<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('trading-history.show',[$product->id])}}">Cancel</a>
</div>
<div class="clearfix"></div>
