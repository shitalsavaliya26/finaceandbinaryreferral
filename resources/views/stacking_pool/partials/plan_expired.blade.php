<div class="col-md-12 nopadding">
  <div class="form-group">
   <div class="from-inner-space">
    <div class="custom-control custom-checkbox d-inline-block">
     <input id="changeplan{{$stacking_pool->id}}" type="radio"
     class="custom-control-input @error('changeplan') is-invalid @enderror" name="changeplan"
     autocomplete="current-changeplan" value="changeplan" data-id="{{$stacking_pool->id}}">
     <label class="custom-control-label"
     for="changeplan{{$stacking_pool->id}}">{!! trans('custom.change_plan_txt') !!}</label><br>
     <div class="changeplanDis" id="changeplanDis{{$stacking_pool->id}}">
       <label id="changeplan-error" class="error" for="changeplan" style="color:#c71d25 !important;"></label>
       <select name="duration" id="duration" class="form-control h-auto py-4">
        <option value="">{{__('custom.duration_term')}}</option>
        <option value="12">12 {{__('custom.months')}}</option>
        <option value="24">24 {{__('custom.months')}}</option>
        @error('duration')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
       </span>
       @enderror
     </select>
     <label class="error" for="time_period{{$stacking_pool->id}}"  style="color:#c71d25 !important;"></label>
     <label id="end_period{{$stacking_pool->id}}" class="text-danger" style="color:#f14336 !important;"></label>
   </div>
 </div>
</div>
</div>
</div>
<div class="col-md-12 nopadding">
  <div class="form-group">
   <div class="from-inner-space">
    <div class="custom-control custom-checkbox d-inline-block"> 
     <input id="close_investment{{$stacking_pool->id}}" type="radio"
     class="custom-control-input @error('changeplan') is-invalid @enderror" name="changeplan"
     autocomplete="current-close_investment" value="close_investment" data-id="{{$stacking_pool->id}}">
     <label class="custom-control-label col-md-12 noppading"
     for="close_investment{{$stacking_pool->id}}">{!! trans('custom.close_investment') !!}</label><br>
   </div>
 </div>
</div>
</div>
<input type="hidden" name="staking_pool_id" value="{{$stacking_pool->id}}">
