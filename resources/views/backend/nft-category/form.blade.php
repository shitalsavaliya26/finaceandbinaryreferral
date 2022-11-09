<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Image @if(@$category->image)- <a href="{{asset(@$category->image)}}" target="_blank">{{basename(@$category->image)}}</a>@endif</label>
                {!! Form::file('image',['class'=>'form-control','placeholder'=>'Enter url', 'accept'=>'image/*']) !!}
                <span class="help-block text-danger">{{ $errors->first('image') }}</span>
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
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Status</label> <br>
                <label>{!! Form::radio('status','active',@$category->status=='inactive'?false:true,[]) !!} Active</label> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>{!! Form::radio('status','inactive',@$category->status=='active'?true:false,[]) !!} Inactive</label>
                <span class="help-block text-danger">{{ $errors->first('status') }}</span>

            </div> 
            <div class="form-group">
                <label>Arrangement Sequence Number</label>
                {!! Form::number('order_id',old('order_id'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Arrangement Sequence Number']) !!}
                <span class="help-block text-danger">{{ $errors->first('order_id') }}</span>
            </div>  
        </div>
    </div>    
</div>
 
<hr>

<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('nft-category.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


