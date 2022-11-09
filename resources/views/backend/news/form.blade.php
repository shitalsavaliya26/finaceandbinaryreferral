<div class="col-sm-12">
    <div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Title</label> 
                 {!! Form::text('title',old('title'),['class'=>'form-control','placeholder'=>'Enter title']) !!}
                <span class="help-block text-danger">{{ $errors->first('title') }}</span>
            </div> 
        </div>    
       <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Language</label>                 
                {!! Form::select('language',['cn'=>'Chinese','en'=>'English'],old('language',@$news->lang),['class'=>'form-control','placeholder'=>'select language']) !!}
                <span class="help-block text-danger">{{ $errors->first('language') }}</span>
            </div>
        </div> 
    </div><div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Detail</label> 
                 {!! Form::textarea('details',old('details'),['class'=>'form-control','placeholder'=>'Enter Detail','rows'=>'8','style'=>'resize:none;']) !!}
                <span class="help-block text-danger">{{ $errors->first('details') }}</span>
            </div> 
        </div>    
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Image</label>
                {!! Form::file('image',['class'=>'form-control','placeholder'=>'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('image') }}</span>
            </div> 
            <div class="form-group">
                <label>URL</label>
                {!! Form::text('url',old('url'),['class'=>'form-control','placeholder'=>'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('url') }}</span>
            </div> 
            <div class="form-group">
                <label>Status</label> <br>
                <label>{!! Form::radio('status','Active',@$news->status!='Active'?false:true,[]) !!} Active</label> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>{!! Form::radio('status','Inactive',@$news->status!='Active'?true:false,[]) !!} Inactive</label>
                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
            </div> 
        </div>    
    </div>    
</div>
<div class="">
    <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
    <a class="btn btn-md btn-danger m-t-n-xs" href="{{route('news.index')}}">Cancel</a>
</div>
<div class="clearfix"></div>


