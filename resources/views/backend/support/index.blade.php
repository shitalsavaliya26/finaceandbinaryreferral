@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">Support Tickets</div>
            <div class="col-xs-12 col-md-9 text-right">
                
                {!! Form::open(['route' => 'support_ticket.index','class'=>'form-inline','method'=>'get','id'=>'filter_request']) !!}
                <div class="col-sm-8">                                
                    <div class="form-group">                                
                        {!! Form::text('search',old('search',@$data['search']),['class'=>'form-control','placeholder'=>'Search by username']) !!}
                    </div>            
                    <div class="form-group">                                
                        {!! Form::select('status',['Open'=>'Open','Close'=>'Close','Replied'=>'Replied'],old('status',@$data['status']),['class'=>'form-control','placeholder'=>'All']) !!}
                    </div>            
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                    <a class="btn btn-danger" href="{{route('support_ticket.index')}}">Clear</a>
                </div>
                {!! Form::close() !!}    
            </div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content bg-dark-blue">        
                    <div class="include-html">
                        @include('backend.support.partials.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="view_ticket" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="username"></span>[<span class="id"></span>]</h4>
            </div>
            <div class="modal-body">                
                <div></div>
            </div>
        </div>
    </div>
</div>
<div id="reply_support" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(['route'=>['support_ticket.update',''],'method'=>'post','class'=>'form-vertical','id'=>'reply_support_ticket','autocomplete'=>'false','files'=>true]) !!}
            @method('patch')
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reply <span class="username"></span> to [<span class="id"></span>]</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="ticket_id" value="" />
                    <label>Subject:</label> 
                    {!! Form::text('subject',old('amount'),['readonly'=>'true','class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>Select Template: </label> 
                    {!! Form::select('template',$templates_list,old('template'),['min'=>'0','class'=>'form-control','placeholder'=>'Select Template']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Attachment: </label> 
                    {!! Form::file('template[]',['multiple'=>'true','class'=>'form-control','accept'=>'application/pdf,image/jpeg,image/png']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Desctipion:</label> 
                    {!! Form::textarea('message',old('message'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>5,'style'=>'resize:none']) !!}
                    <span class="help-block text-danger">{{ $errors->first('message') }}</span>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Reply</button>
                <a  class="btn btn-danger" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript"> var action_url = "{{route('support_ticket.update','')}}"</script>
<script type="text/javascript"> 
    var detail_url = "{{route('support_ticket.show','')}}"
    var close_ticket_url = "{{route('support_ticket.store')}}"
    var usernameExits = "{{route('usernameExits')}}";
    
</script>
<script type="text/javascript"> var array_data = @php echo json_encode((array)$templates_data); @endphp</script>
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/support_requests.js')}}"></script>
@endsection
