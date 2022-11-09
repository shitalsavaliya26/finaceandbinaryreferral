<div class="block cus-heght-full">
    <div class="ibox-content ibox-border-rad ">
        <div class="row">
            <div class="col-md-12 text-center">
            <h4>Bank Proofs</h4>
            @if($proof->payment_proof!=null)
            <div class="img-thumbnail">
                 <img src="{{asset('uploads/nftwithdrawl_request/'.$proof->payment_proof)}}" width="500" height="500">
            </div>
            @else
            <div class="cus-view-content">
                No Proofs available
            </div>
            @endif
            </div>
        </div>
    </div>
</div>