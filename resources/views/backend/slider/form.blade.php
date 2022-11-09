<div class="col-sm-12 ">
    <div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Title</label>
                {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
                <span class="help-block text-danger">{{ $errors->first('title') }}</span>
            </div>
        </div>

        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Desktop Image @if (@$slider->image_url)- <a href="{{ @$slider->image_url }}" target="_blank">{{ @$slider->image }}</a>@endif</label>
                {!! Form::file('image', ['class' => 'form-control', 'placeholder' => 'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('image') }}</span>

            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>Mobile Image @if (@$slider->mobile_image_url)- <a href="{{ @$slider->mobile_image_url }}" target="_blank">{{ @$slider->mobile_image }}</a>@endif</label>
                {!! Form::file('mobile_image', ['class' => 'form-control', 'placeholder' => 'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('mobile_image') }}</span>

            </div>
        </div>
        <div class="col-sm-6 pl-0 ">
            <div class="form-group">
                <label>URL</label>
                {!! Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => 'Enter url']) !!}
                <span class="help-block text-danger">{{ $errors->first('url') }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-12 ">
        <div class="row">
            <button class="btn btn-md btn-primary m-t-n-xs" type="submit">Save</button>
            <a class="btn btn-md btn-danger m-t-n-xs" href="{{ route('slider.index') }}">Cancel</a>
        </div>
    </div>    
</div>
<div class="clearfix"></div>
