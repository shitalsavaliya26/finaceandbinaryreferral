<div class="modal fade" id="viewcountdown-Modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <img src="{{ asset($product->image) }}" class="img-fluid rounded-top" alt="">
                    </div>
                    <div class="col-12 col-lg-6 text-white mt-4 mt-lg-0">
                        <h2>{{ $product->name }}</h2>
                        <p class="font-12 w-75 mt-3 cus-lighn-height">{{ $product->description }}</p>
                        <h3 class="my-3">{{trans('custom.Counter_offer_amount')}} - ${{ $nftpurchasehistory->counter_offer_amount }}</h3>
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <form method="POST" autocomplete="off"
                                    action="{{ route('counterofferstatus') }}">
                                    @csrf
                                    <input type="hidden" class="form-control form-control-solid" name="nfthistoryid"
                                        id="historyid" value="{{ $id }}" />
                                    <input type="hidden" class="form-control form-control-solid" name="approverequest"
                                    id="approverequest" value="approve" />
                                    <input type="hidden" class="form-control form-control-solid" name="amount" value="{{ $nftpurchasehistory->counter_offer_amount }}" />
                                    <div class="row justfy-content-between align-items-center mt-4">
                                        <div class="col-12 col-xl-6 mt-4">
                                            <button type="submit"
                                                class="btn bg-success btn-sm text-white rounded-0">{{ trans('custom.APPROVE') }}</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="col-4">
                                    <form method="POST" autocomplete="off"
                                    action="{{ route('counterofferstatus') }}">
                                    @csrf
                                    <input type="hidden" class="form-control form-control-solid" name="nfthistoryid"
                                        id="historyid" value="{{ $id }}" />
                                    <input type="hidden" class="form-control form-control-solid" name="nfthistoryid"
                                    id="historyid" value="{{ $id }}" />
                                    <input type="hidden" class="form-control form-control-solid" name="amount" value="{{ $nftpurchasehistory->counter_offer_amount }}" />
                                    <div class="row justfy-content-between align-items-center mt-4">
                                        <div class="col-12 col-xl-6 mt-4">
                                            <button type="submit"
                                                class="btn bg-danger btn-sm text-white rounded-0">{{ trans('custom.REJECT') }}</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

