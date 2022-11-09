@extends('layouts.app')
@section('title', $supportChat->subject['subject_en'])
@section('page_title', $supportChat->subject['subject_en'])
@section('content')
<div class="content-wrapper">
  <div class="row mt-5 pt-5">
    <div class="col-12">
      <div class="login-gradient rounded text-white py-4 px-5">
        <h2 class="mb-0 font-weight-bold">{{$supportChat->subject['subject_en']}}</h2>
      </div>
    </div>
  </div>
  @if(count($supportChat->messages))
  @foreach($supportChat->messages as $key => $value)
    @if($value->reply_from == 'user')
      <div class="row mt-5">
        <div class="col-12 col-xl-6 mt-4 mt-xl-0">
          <div class="card tale-bg overflow-hidden bg-warning pb-3">
            <div class="bg-warning p-4 pb-5">
              <h4 class="pb-2">{{ $supportChat->user_detail['name'] }}</h4>
            </div>
            <div class="px-4 cus-my-profile-img">
              @if(!empty($value->attchment) && isset($value->attchment[0]))
                @foreach($value->attchment as $keyAttach => $valueAttach)
                  @php
                      $proofType = 0;
                      if($valueAttach->file_name !=null && $valueAttach->file_name != ''){
                          $proofType = substr(strrchr($valueAttach->file_name,'.'),1);
                      }
                  @endphp
                  @if( $proofType ==  'pdf' || $proofType ==  'doc' || $proofType ==  'docx')
                      <a href="{{asset('uploads/suport_ticket_attach/'.$valueAttach->file_name)}}" target="_blank">{{ trans('custom.view')}}</a> 
                  @else
                      <img src="{{asset('uploads/suport_ticket_attach/'.$valueAttach->file_name)}}" class="rounded-circle img-fluid">
                  @endif
                    {{-- <img src="{{ asset('assets/images/assets/Dashboard/Group853.png') }}" class="rounded-circle img-fluid" alt=""> --}}
                @endforeach
              @endif  
            </div>
            <div class="row px-4 mt-4">
              <div class="col-md-6">
                  <h4 class="font-weight-bold mb-0">{!! nl2br($value['message']) !!}</h4>
                  <span class="font-12">{{ $value->created_at->diffForHumans() }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    @else  
      <div class="row mt-5">
        <div class="col-12 col-xl-6 mt-4 mt-xl-0"></div>
        <div class="col-12 col-xl-6 mt-4 mt-xl-0">
          <div class="card tale-bg overflow-hidden bg-warning pb-3">
            <div class="p-4 pb-5">
              <h4 class="pb-2">Admin</h4>
            </div>
            <div class="px-4 cus-my-profile-img">
              @if(!empty($value->attchment) && isset($value->attchment[0]))
                @foreach($value->attchment as $keyAttach => $valueAttach)
                  @php
                      $proofType = 0;
                      if($valueAttach->file_name !=null && $valueAttach->file_name != ''){
                          $proofType = substr(strrchr($valueAttach->file_name,'.'),1);
                      }
                  @endphp
                  @if( $proofType ==  'pdf' || $proofType ==  'doc' || $proofType ==  'docx')
                      <a href="{{asset('uploads/suport_ticket_attach/'.$valueAttach->file_name)}}" target="_blank">{{ trans('custom.view')}}</a> 
                  @else
                      <img src="{{asset('uploads/suport_ticket_attach/'.$valueAttach->file_name)}}" class="rounded-circle img-fluid">
                  @endif
                    {{-- <img src="{{ asset('assets/images/assets/Dashboard/Group853.png') }}" class="rounded-circle img-fluid" alt=""> --}}
                @endforeach
              @endif
              {{-- <img src="{{ asset('assets/images/assets/Dashboard/Group853.png') }}" class="rounded-circle img-fluid" alt=""> --}}
            </div>
            <div class="row px-4 mt-4">
              <div class="col-md-6">
                  <h4 class="font-weight-bold mb-0">{!! nl2br($value['message']) !!}</h4>
                  <span class="font-12">{{ $value->created_at->diffForHumans() }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif  
  @endforeach
  @else
  <div class="row mt-5 pt-5">
    <div class="col-12">
      <div class="login-gradient rounded text-white py-4 px-5">
        <h2 class="mb-0 font-weight-bold">{{ trans('custom.no_ticket_found')}}</h2>
      </div>
    </div>
  </div>
  @endif
  <div class="col-12 mt-4">
    <div class="tab-content border-0">
      <div class="text-white">
        <div class="row">
          {{Form::open(['route' => 'supportReplayPost','class' => '','id' =>'support-ticket','enctype' => 'multipart/form-data'])}}
              
              {{Form::hidden('ticket_id',$ticket_id,['class' => 'form-control','readonly' => true])}}
              <div class="form-group row">
                  <div class="col-lg-12 form-group-sub">
                      <div class="form-group">
                          <div class="from-inner-space">
                              <label>{{trans('custom.attachment')}}:</label>
                              <input class="form-control blue-ph h-auto" name="attachment[]" type="file" multiple  />
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-lg-12 form-group-sub">
                      <div class="form-group">
                          <div class="from-inner-space">
                              <label>{{trans('custom.message')}}:<span class="text-red">*</span></label>
                              {!! Form::textarea('message', null, ['class'=> 'form-control blue-ph h-auto' ,'id' => 'message', 'rows' => 4, 'cols' => 54]) !!}
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-lg-12 form-group-sub">
                      <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary">{{trans('custom.replay')}}</button>
                  </div>
              </div>
          {{Form::close()}}
        </div>
      </div>
    </div>
  </div>
@endsection