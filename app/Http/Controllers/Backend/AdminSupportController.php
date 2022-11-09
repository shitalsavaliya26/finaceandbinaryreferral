<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTemplate;
use App\Models\SuportSubject;
use App\Models\SupportTicketMessages;
use App\Models\User;
use App\Models\SupportTicketAttachment;

class AdminSupportController extends Controller
{
    public function __construct(Request $request){
        $this->limit = $request->limit?$request->limit:100;
        $this->limit1 = $request->limit1?$request->limit1:10;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $support_tickets = SupportTicket::with('supportattach','subject','last_message')->with(['user_detail'=>function($q){
            $q->with('package_detail','downlineuser');
        }])->whereHas('user_detail',function($q){
            $q->whereNotNull('username');
        });
        if($request->status && $request->status != ""){
            if($request->status == "Replied"){
                    $status = ['Replied'=>'0'];
                    $support_tickets = $support_tickets->where('status',$status[$request->status]);
                    if($request->status == 'Replied'){
                        $support_tickets = $support_tickets->where(function($q){
                            $q->whereHas('last_message',function($query){
                            $query->where('reply_from','=','admin')->where('is_read','=','0');
                        })->orWhereDoesntHave('last_message');
                        });
                    }
            }else{
                    $status = ['Open'=>'0','Close'=>'1']; 
                    $support_tickets = $support_tickets->where('status',$status[$request->status]);
                    if($request->status == 'Open'){
                        $support_tickets = $support_tickets->where(function($q){
                            $q->whereHas('last_message',function($query){
                            $query->where('reply_from','!=','admin');
                        })->orWhereDoesntHave('last_message');
                        });
                    }
            }
        }
        if($request->search && $request->search != ""){

            $support_tickets = $support_tickets->whereHas('user_detail',function($q) use ($request){
                $q->where('username','like','%'.$request->search.'%');
            });
        }
        $data = $request->all();

        $templates = SupportTemplate::all();
        $templates_list = [];
        $templates_data = [];
        foreach ($templates as $key => $value) {
            # code...
            $templates_list[$value->id] = $value->title;

            $templates_data[$value->id] =$value->message;
        }

        $support_tickets = $support_tickets->orderBy('status','asc')->orderBy('created_at','desc')->paginate($this->limit)->appends($data);
        // echo "<pre>";
        // print_r($support_tickets->toArray());
        // die();
        return view('backend.support.index',compact('support_tickets','templates_list','templates_data','data'));
    }

    public function index1($slug,Request $request)
    {
        //
        if($slug=='open'){
            $status = '0';
        }else if($slug=='close'){       
            $status = '1';
        }
        $support_tickets = SupportTicket::with('supportattach','subject','last_message')->with(['user_detail'=>function($q){
            $q->with('package_detail','downlineuser');
        }])->whereHas('user_detail',function($q){
            $q->whereNotNull('username');
        });
        if($request->subject && $request->subject != ""){
            $status = ['Open'=>'0','Close'=>'1']; 
            $support_tickets = $support_tickets->where('subject_id',$request->subject);
        }
        if($slug!='all'){
            $support_tickets = $support_tickets->where('status',$status);
        }
        if($request->search && $request->search != ""){

            $support_tickets = $support_tickets->whereHas('user_detail',function($q) use ($request){
                $q->where('username','like','%'.$request->search.'%');
            });
        }
        $data = $request->all();

        $subjects  = SuportSubject::pluck('subject_en','id');

        $support_tickets = $support_tickets->orderBy('status','asc')->orderBy('created_at','desc')->paginate($this->limit1)->appends($data);
        return view('backend.support.index1',compact('support_tickets','subjects','data','slug'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->ajax()){
            $support_ticket = SupportTicket::with('supportattach','subject','messages')->with(['user_detail'=>function($q){
                $q->with('package_detail','downlineuser');
            }])->whereSlug($request->slug)->first();
            $support_ticket->status = '1';
            $support_ticket->save();
            $templates = SupportTemplate::all();
            $templates_list = [];
            $templates_data = [];
            foreach ($templates as $key => $value) {
                # code...
                $templates_list[$value->id] = $value->title;

                $templates_data[$value->id] =$value->message;
            }
            $support_tickets = SupportTicket::orderBy('status','asc')->orderBy('created_at','desc')->paginate($this->limit);
            $view = view('backend.support.index',compact('support_tickets','templates_list','templates_data'))->render();
            return response()->json(['status'=>'success','data'=>$view,'message'=>'Ticket close successfully....']);
        }
        $usercheck = User::where('username',$request->username)->where('status','active')->first();
        if($usercheck == null ){
            return redirect()->back()->with('error','User name not valid.');
        }
        $supportTickes = new SupportTicket;
        $supportTickes->user_id = $usercheck->id;        
        $supportTickes->slug = '0'; //open close
        $supportTickes->status = '0'; //open close
        $supportTickes->is_read = '0'; //read and unread
        $supportTickes->subject_id = $request->subject;
        $supportTickes->save();

        $supportTickesMessage = new SupportTicketMessages();
        $supportTickesMessage->support_id  = $supportTickes->id;
        $supportTickesMessage->message  = $request->message;
        $supportTickesMessage->reply_from  = 'admin';
        $supportTickesMessage->is_read  = '0';
        $supportTickesMessage->save();

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $image) {
                // $filename=time() .'.'. $image->getClientOriginalName();
                // $path = public_path('customer/suport_ticket_attach/');
                // $image->move($path, $filename);
                $filename=time() .'.'. $image->getClientOriginalExtension();              
                // $image->storeAs('suport_ticket_attach',$filename);
                $image->move(public_path('uploads/suport_ticket_attach'),$filename); 
                $supportAttach = new SupportTicketAttachment;
                $supportAttach->support_tkt_id = $supportTickes->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $filename;
                $supportAttach->save();
            }
        }
        return redirect()->back()->with('success','Ticket create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $support_ticket =SupportTicket::with('supportattach','subject','messages')->with(['user_detail'=>function($q){
            $q->with('package_detail','downlineuser');
        }])->whereSlug($id)->first();
        $view = view('backend.support.partials.messages',compact('support_ticket'))->render();
        return response()->json(['status'=>'success','data'=>$view]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $support_ticket = SupportTicket::whereSlug($id)->first();

        if($support_ticket){
            $support_ticket->is_read = '1';
            $support_ticket->status = '0';
            $support_ticket->save();
            SupportTicketMessages::where(['support_id'=>$support_ticket->id,'reply_from'=>'user'])->update(['is_read'=>'1']);
            $ticket_message = new SupportTicketMessages();
            $ticket_message->support_id = $support_ticket->id;
            $ticket_message->message = $request->message;
            $ticket_message->reply_from = 'admin';
            $ticket_message->save();

            if($request->hasFile('template')){
                foreach($request->file('template') as $image) {
                    $filename=time() .'.'. $image->getClientOriginalExtension();               
                    // $image->storeAs('suport_ticket_attach',$filename);  
                    $image->move(public_path('uploads/suport_ticket_attach'),$filename);               
                    $supportAttach = new SupportTicketAttachment;
                    $supportAttach->support_tkt_id = $support_ticket->id;
                    $supportAttach->message_id = $ticket_message->id;
                    $supportAttach->file_name = $filename;
                    $supportAttach->save();
                }
            }

            if($request->ajax()){
                $support_tickets = SupportTicket::with('supportattach','subject','last_message')->with(['user_detail'=>function($q){
                    $q->with('package_detail','downlineuser');
                }])->whereHas('user_detail',function($q){
                    $q->whereNotNull('username');
                });;
                $support_tickets = $support_tickets->orderBy('status','asc')->orderBy('created_at','desc');
                $support_tickets = $support_tickets->paginate($this->limit);
                $support_tickets = $support_tickets->setPath(route('support_ticket.index')); 
                $html = view('backend.support.partials.table',compact('support_tickets'))->render();

                return response()->json(['status'=>'success','data'=>$html,'message'=>'Reply sent successfully....']);
            }
            return redirect()->back()->with('success','Reply sent successfully....');
        }else{
           if($request->ajax()){
            return response()->json(['status'=>'error','message'=>'Something went wrong....']);
        }
        return redirect()->back()->with('with','Something went wrong....');
    }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
