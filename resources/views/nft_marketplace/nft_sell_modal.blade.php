<div class="modal fade" id="bullKongModal{{ $product->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <img src="{{ asset($product->image) }}" class="img-fluid rounded-top" alt="">
                    </div>
                    <div class="col-12 col-lg-6 text-white mt-4 mt-lg-0">
                        <h2>{{ $product->name }} </h2>
                        <p class="font-12 w-75 mt-3 cus-lighn-height">{{ $product->description }}</p>
                        @if ($nftpurchasehistory->type == 1)
                        <h5 class="text-warning">{{trans('custom.listingperiod')}}</h5>
                        @else
                        <form id="salenftproduct" method="POST" autocomplete="off"
                        action="{{ route('saleproduct') }}">
                        @csrf
                        <input type="hidden" name="name" id="name" value="{{ $product->name }}">
                        <input type="hidden" class="form-control form-control-solid" name="nftpurchaseid"
                        id="nftpurchaseid" value="{{ $id }}" />
                        <div class="row justfy-content-between align-items-center mt-4">
                            <div class="col-12 col-xl-6 pr-xl-0">
                                <input type="number" class="py-3 form-control grey-ph h-auto py-4"
                                placeholder="{{ trans('custom.amount') }}" name="sale_amount"
                                id="sale_amount" value="0">
                                <span class="error-text" id="sale_amount_err" style="color: red;"></span>
                            </div>
                            <div class="col-12 col-xl-6 mt-4 mt-xl-0">
                                <input type="password" class="py-3 form-control grey-ph h-auto py-4"
                                placeholder="{{ trans('custom.security_password') }}" name="secure_password"
                                id="secure_password">
                                <span class="error-text" id="secure_password_err"
                                style="color: red;"></span>
                            </div>
                            <div class="col-12 col-xl-6 mt-4">
                                <button type="submit"
                                class="btn bg-warning text-white p-4 px-5 rounded-0">{{ trans('custom.SELL_NOW') }}</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $.validator.addMethod(
        "positiveNumber",
        function(value) {
            return Number(value) > 0;
        },
        '{{ trans('custom.value_must_be_greater_than_0') }}'
        );
    if ($("#salenftproduct").length > 0) {
        $("#salenftproduct").validate({
            rules: {
                sale_amount: {
                    required: true,
                    positiveNumber: true,
                },
                secure_password: {
                    required: true,
                },
            },
            messages: {
                sale_amount: {
                    required: "{{ trans('custom.amount_required_field') }}",
                },
                secure_password: {
                    required: "{{ trans('custom.securepassword_required_field') }}",
                },
            },
            submitHandler: function(form) {
                swal({
                    title: "Are you sure? ",
                    text: "You want to sell "+$('#name').val()+" !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4B49AC",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) form.submit();
                });
            }
        })
    }
</script>
