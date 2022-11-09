<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Name</label>                 
                {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Enter Name']) !!}
                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-sm-6 pl-0">
            <div class="form-group">
                <label>Category</label> 
                {!! Form::select('category',$categories,old('category',@$product->category_id),['class'=>'form-control','placeholder'=>'Select Category','id'=>'category']) !!}
                <span class="help-block text-danger">{{ $errors->first('category') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Image @if(@$product->image)- <a href="{{asset(@$product->image)}}" target="_blank">{{basename(@$product->image)}}</a>@endif</label>
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
              @php
              $productCount = 0;
              if(@$product){
                  $productCount = \App\Models\NftPurchaseHistory::where(['product_id' => @$product->id])->whereIn('status',[1,2])->count(); 
              }

              @endphp
              <label>Product Status</label> <br>
              @if ($productCount == 0)
              <label>{!! Form::radio('product_status','Normal',@$product->product_status=='Normal'?false:true,[]) !!} Normal</label> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              @endif
              <label>{!! Form::radio('product_status','Sold',@$product->product_status=='Sold'?true:false,[]) !!} Sold</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>{!! Form::radio('product_status','Hidden',@$product->product_status=='Hidden'?true:false,[]) !!} Hidden</label>
              <span class="help-block text-danger">{{ $errors->first('product_status') }}</span>
          </div> 
      </div>
      <div class="col-sm-6 pl-0 ">
        <div class="form-group">
            <label>Status</label> <br>
            <label>{!! Form::radio('status','active',@$product->status=='inactive'?false:true,[]) !!} Active</label> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>{!! Form::radio('status','inactive',@$product->status=='active'?true:false,[]) !!} Inactive</label>
            <span class="help-block text-danger">{{ $errors->first('status') }}</span>
        </div> 
    </div>
</div>
<div class="row">    
    <div class="col-sm-6 pl-0 ">
        <div class="form-group">
            <label>Description</label>                 
            {!! Form::textarea('description', old('description'), ['class' => 'form-control form-control', 'rows' => 7,'placeholder' => 'Enter Description']) !!}
            <span class="help-block text-danger">{{ $errors->first('description') }}</span>
        </div>
    </div>
    <div class="col-sm-6 pl-0">
        <div class="form-group">
            <label>Other Images</label>
            <div class="m-dropzone dropzone m-dropzone--primary"  id="productDropZonenew" action="/" method="post">
                <div class="m-dropzone__msg dz-message needsclick" >
                    <h3 class="m-dropzone__msg-title">Drop image here</h3>
                    <span class="m-dropzone__msg-desc">Allowed only image files</span>
                </div>
                <div id="image_data"></div>
                <div id="image-holder"></div>
            </div> 
        </div>
        <div class="form-group">
            <div id="image_preview"></div>
        </div>
        <div class="form-group">
            @if(@$product)
            @foreach($product->images as $image)
            <span id="{{ $image->id }}" >
                <img src="{{ asset('public/uploads/nft-product').'/'.$image->image }}"  width="100" height="100" style="margin-left: 21px;"/>
                <a onclick="removeimg({{ $image->id }})"  m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon" aria-describedby="tooltip_xr8lyasjaw" style="position: absolute; color: red;text-decoration: none;" >×</a>
            </span>
            @endforeach
            <input type="hidden" name="remove_img" id="removeimg">
            @endif
        </div>
    </div>
</div>
<div class="row">

</div>    
</div>

<hr>

<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('nft-product.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


