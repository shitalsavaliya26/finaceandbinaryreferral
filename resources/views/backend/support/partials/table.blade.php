<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Package</th>
                <th>Latest Funding</th>
                <th>Latest Full Withdrawal</th>
                <th>Downlines</th>
                <th>Ticket Content</th>
                <th>File Attachment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="center">

            @if(count($support_tickets) > 0)
            @foreach($support_tickets as $row)
            @if(@$data['status'] && $data['status'] == 'Open')
            @if( ($row->last_message!=null && $row->last_message->reply_from != 'admin') || $row->last_message==null)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user_detail->username}}</td>
                <td>{{$row->user_detail->package_detail!=null ? $row->user_detail->package_detail->name : 'N/A'}}</td>
                <td>{!! $row->user_detail->fund_history!=null?round($row->user_detail->fund_history->amount,2).',<br>'.$row->user_detail->fund_history->created_at:"N/A" !!}</td>
                <td>{!! $row->user_detail->withdrawal_history!=null?round($row->user_detail->withdrawal_history->withdrawal_amount,2).',<br>'.$row->user_detail->withdrawal_history->created_at:'' !!}</td>
                <td>{{$row->user_detail->downlineuser->count()}}</td>
                <td  @if($row->last_message!=null) width="25%" @endif >
                    @if($row->messages!=null)
                    @foreach($row->messages as $message)
                    <div class="m-b-sm {{$message!=null && $message->reply_from=='admin'?'text-read':'text-unread'}} {{($message->reply_from == 'admin' ) ? 'admin-message' : 'user-message'}}" >
                        {{$message!=null?$message->message:""}}
                    </div>
                    @endforeach
                    @endif
                </td>
                <td width="5%">
                    @if($row->supportattach!=null)

                    @foreach($row->supportattach as $attachment)

                    <a class="font-s-12" href="{{asset('uploads/suport_ticket_attach'.'/'.$attachment->file_name)}}" target="_blank">
                        <i class="fa fa-file fa-2x"></i>
                        <!-- {{$attachment->file_name}} -->
                    </a>
                    @endforeach
                    @endif
                </td>
                <td>
                    @if($row->status=='1')
                    <label class="label label-primary">Close</label>
                    @elseif($row->last_message!=null && $row->last_message->reply_from == 'admin')
                    <label class="label label-info">Replied</label>
                    @else
                    <label class="label label-warning">Open</label>
                    @endif
                </td>
                <td width="10%">                                   
                    @if($row->status == '0')
                    {!! Form::hidden('username',$row->user_detail->username) !!}
                    {!! Form::hidden('subject',$row->subject->subject_en) !!}
                    {!! Form::hidden('withdraw_request_id',$row->slug) !!}
                    <a class="" onclick="opFundWallet(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Reply" href="javascript:;">Reply</a> | 
                    <a class="" onclick="closeTicket(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Close Ticket" href="javascript:;">Close Ticket</a> | 
                    @endif
                    <a class="" onclick="showDetail(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="View Detail" href="javascript:;">View Detail</a>
                </td>
            </tr>  
            @endif 
            @else
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user_detail->username}}</td>
                <td>{{$row->user_detail->package_detail!=null ? $row->user_detail->package_detail->name : 'N/A'}}</td>
                <td>{!! $row->user_detail->fund_history!=null?round($row->user_detail->fund_history->amount,2).',<br>'.$row->user_detail->fund_history->created_at:"N/A" !!}</td>
                <td>{!! $row->user_detail->withdrawal_history!=null?round($row->user_detail->withdrawal_history->withdrawal_amount,2).',<br>'.$row->user_detail->withdrawal_history->created_at:'' !!}</td>
                <td>{{$row->user_detail->downlineuser->count()}}</td>
                <td  @if($row->last_message!=null) width="25%" @endif >
                    @if($row->messages!=null)
                    @foreach($row->messages as $message)
                    <div class="m-b-sm {{$message!=null && $message->reply_from=='admin'?'text-read':'text-unread'}} {{($message->reply_from == 'admin' ) ? 'admin-message' : 'user-message'}}" >
                        {{$message!=null?$message->message:""}}
                    </div>
                    @endforeach
                    @endif
                </td>
                <td width="5%">
                    @if($row->supportattach!=null)

                    @foreach($row->supportattach as $attachment)

                    <a class="font-s-12" href="{{asset('uploads/suport_ticket_attach'.'/'.$attachment->file_name)}}" target="_blank">
                        <i class="fa fa-file fa-2x"></i>
                        <!-- {{$attachment->file_name}} -->
                    </a>
                    @endforeach
                    @endif
                </td>
                <td>
                    @if($row->status=='1')
                    <label class="label label-primary">Close</label>
                    @elseif($row->last_message!=null && $row->last_message->reply_from == 'admin')
                    <label class="label label-info">Replied</label>
                    @else
                    <label class="label label-warning">Open</label>
                    @endif
                </td>
                <td width="10%">                                   
                    @if($row->status == '0')
                    {!! Form::hidden('username',$row->user_detail->username) !!}
                    {!! Form::hidden('subject',$row->subject->subject_en) !!}
                    {!! Form::hidden('withdraw_request_id',$row->slug) !!}
                    <a class="" onclick="opFundWallet(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Reply" href="javascript:;">Reply</a> | 
                    <a class="" onclick="closeTicket(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Close Ticket" href="javascript:;">Close Ticket</a> | 
                    @endif
                    <a class="" onclick="showDetail(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="View Detail" href="javascript:;">View Detail</a>
                </td>
            </tr>  
            @endif             
            @endforeach                            
            @else
            <tr>
                <td>Oops! No Record Found.</td>
            </tr>
            @endif
            <tr>
                <td colspan="10" align="right">{!! $support_tickets->render('vendor.default_paginate') !!}</td>
            </tr>

        </tbody>
    </table>
</div>