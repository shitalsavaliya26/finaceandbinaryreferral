<div class="block cus-heght-full">
    <div class="ibox-content ibox-border-rad ">
        {{-- @if($type == 0) --}}
        <div class="row">
            <div class="col-md-12 text-center">
            <h4>Bank Proofs</h4>
            @if($proof->payment_proof!=null)
            <div class="img-thumbnail">
                 {{-- <img onerror="this.src='{{asset('backend/media/no_found.png')}}'" src="{{($user->proofs!=null?$user->proofs->bank_proof:'')}}" width="auto" > --}}
                 <img src="{{asset('uploads/withdrawl_request/'.$proof->payment_proof)}}" width="500" height="500">
            </div>
            @else
            <div class="cus-view-content">
                No Proofs available
            </div>
            @endif
            </div>
        </div>
        {{-- @else --}}
        {{-- <div class="row">
            <div class="col-md-12 text-center">
            <h4>USDT Information</h4>
            <div class="text-left">
                <p><strong>Payment Address:</strong> {{$user->usdt_address}} </p>
                <p><strong>Payment Proofs</strong></p>
            </div>
            @if($user->usdt_image!=null && $user->usdt_image!="")
            <div class="img-thumbnail  ">
                 <img onerror="this.src='{{asset('backend/media/no_found.png')}}'" src="{{($user->usdt_image!=null?asset('uploads/withdrawl_request/'.$user->usdt_image):'')}}" width="auto" height="250px" >
            </div>
            @else
            <div class="cus-view-content  text-center">
                No Proofs available
            </div>
            @endif
            </div>
        </div> --}}
        {{-- @endif --}}
    </div>
</div>