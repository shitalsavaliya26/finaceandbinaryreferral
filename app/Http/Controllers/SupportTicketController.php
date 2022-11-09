<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Model;
use Auth;
use Session;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->limit = 10;  
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        if($locale == 'en'){
            $locale = 'subject_en';
        }else{
            $locale = 'subject_ch';
        }
        $user = Model\User::with('userbank')->where('id',$this->user->id)->where(['status' => 'active', 'deleted_at' => null])->first();
        // echo $request->get('htype');
        // exit;
        $query = Model\SupportTicket::where('user_id',$this->user->id);
        if ($request->get('htype') != "" && $request->get('htype') != 2) {
            $query->where('status', $request->get('htype'));
        }
        $general_search = $request->get('general_search');
        if ($general_search && $general_search != '') {
            $query = $query->where(function ($query) use ($general_search) {
                $query->where('message', 'LIKE', '%' . $general_search . '%');
                $query->orWhere('subject_id', 'LIKE', '%' . $general_search . '%');
            });
        }
        $supportTicket = $query->orderBy('created_at', 'desc')->paginate($this->limit);
        if ($request->ajax()) {
            return view('help_support/help_supportajax', compact('supportTicket','locale'));
        }
        $openTicketCount =  Model\SupportTicket::where('user_id',$this->user->id)->where('status','0')->count();
        $closeTicketCount = Model\SupportTicket::where('user_id',$this->user->id)->where('status','1')->count();
        
        $supportSubject = Model\SuportSubject::where('status','Active')->pluck($locale,'id');
        return view('help_support.index',compact('user','supportTicket','supportSubject','openTicketCount','closeTicketCount','locale'));
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
        $usercheck = Model\User::where('id',$this->user->id)->where(['status' => 'active', 'deleted_at' => null])->first();
        if($usercheck == null ){
            Session::flash('success',trans('custom.session_has_been_expired_try_agian'));  
            return redirect()->route('help-support.index');
        }
        $supportTickes = new Model\SupportTicket;
        $supportTickes->user_id = $this->user->id;        
        $supportTickes->slug = '0'; //open close
        $supportTickes->status = '0'; //open close
        $supportTickes->is_read = '0'; //read and unread
        $supportTickes->subject_id = $request->subject_id;
        $supportTickes->save();

        $supportTickesMessage = new Model\SupportTicketMessages();
        $supportTickesMessage->support_id  = $supportTickes->id;
        $supportTickesMessage->message  = $request->message;
        $supportTickesMessage->is_read  = '0';
        $supportTickesMessage->save();

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $key => $image) {
                // $filename=time() .'.'. $image->getClientOriginalName();
                // $path = public_path('customer/suport_ticket_attach/');
                // $image->move($path, $filename);
                $filename= time() .$key.'.'. $image->getClientOriginalExtension(); 
                $path = public_path('uploads/suport_ticket_attach/');      
                // $image->storeAs('suport_ticket_attach',$filename);
                $image->move($path, $filename);
                $supportAttach = new Model\SupportTicketAttachment;
                $supportAttach->support_tkt_id = $supportTickes->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $filename;
                $supportAttach->save();
            }
        }
        \Log::channel('supportticket')->info('user created request', ['userwalletobject' => json_encode($supportTickes), 'file' => __FILE__, 'line' => __LINE__]);
        Session::flash('success',trans('custom.ticket_submit'));  
        return redirect()->route('help_support.index')->with('success',trans('custom.ticket_submit'));
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
    public function supportReplay(Request $request){
        $openTicketCount =  Model\SupportTicket::where('user_id',$this->user->id)->where('status','0')->count();
        $closeTicketCount = Model\SupportTicket::where('user_id',$this->user->id)->where('status','1')->count();
        $supportSubject = Model\SuportSubject::where('status','Active')->pluck('subject_en','id');
        $ticket_id = $request->id;
        $user = Model\User::where('id',$this->user->id)->where(['status' => 'active', 'deleted_at' => null])->first();
        
        $supportChat = Model\SupportTicket::with('messages','messages.attchment')->where('slug',$ticket_id)->first();
        if(empty($supportChat)){
            return redirect()->back()->with('error',trans('custom.ticket_not_found') );
        }
        $supportChat->is_read = '1';
        $supportChat->save();
        foreach ($supportChat->messages as $key => $value) {
            $value->is_read = '1';
            $value->save();
        }
        return view('help_support.helpsupportreplay',compact('user','openTicketCount','closeTicketCount','supportSubject','ticket_id','supportChat'));
    }
    public function supportReplayPost(Request $request){
        $user = Model\User::where('id',$this->user->id)->where(['status' => 'active', 'deleted_at' => null])->first();
        if(empty($user)){
            return redirect()->back()->with('error',trans('custom.session_has_been_expired_try_agian') );
        }
        $supportChat = Model\SupportTicket::with('messages')->where('slug',$request->ticket_id)->first();
        if(empty($supportChat)){
            return redirect()->back()->with('error',trans('custom.ticket_not_found') );
        }
        $supportChat->status = '0';
        $supportChat->save();
        $supportTickesMessage = new Model\SupportTicketMessages();
        $supportTickesMessage->support_id  = $supportChat->id;
        $supportTickesMessage->message  = $request->message;
        $supportTickesMessage->is_read  = '0';
        $supportTickesMessage->save();

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $key => $image) {
                // $filename=time() .'.'. $image->getClientOriginalName();
                $path = public_path('uploads/suport_ticket_attach/');
                // $image->move($path, $filename);
                
                $filename= time() .$key.'.'. $image->getClientOriginalExtension();            
                // $image->storeAs('suport_ticket_attach',$filename);
                $image->move($path, $filename);        
                $supportAttach = new Model\SupportTicketAttachment;
                $supportAttach->support_tkt_id = $supportChat->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $filename;
                $supportAttach->save();
            }
        }
        return redirect()->back()->with('success', trans('custom.Ticket_message_sent_to_admin'));
    }
}
