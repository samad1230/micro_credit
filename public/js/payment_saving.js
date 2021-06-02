$(function () {
    $('#allInstallmentsTable').DataTable();

    $(document).on('click', '.collectionBtn', function() {
    //$('.collectionBtn').on('click',function () {
        var voucherNo = $(this).attr('id');
        swal({
            content: {
                element: "input",
                attributes: {
                    placeholder: "Collection BTD",
                    type: "number",
                },
            },
            buttons: {
                cancel: 'Not Now',
                confirm: 'Pay Now'
            },
        })
            .then((value) => {
                if (value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '/Investment/Return-Collection',
                        data: {
                            "collection":value,
                            "voucher_no":voucherNo,
                        },
                        success:function (data) {

                            if(data == 'success'){
                                swal("Payment has been taken!",{
                                    icon: "success",
                                });
                                location.reload();
                            }else {
                                swal("Invalid Entry!",{
                                    icon: "error",
                                });
                            }

                        }
                    })
                } else {
                    swal("Please make payment as early you can!");
                }
            });
    });

    $(document).on('click', '.savingcollectionBtn', function() {
    //$('.savingcollectionBtn').on('click',function () {
        var voucherNo = $(this).attr('id');
        swal({
            content: {
                element: "input",
                attributes: {
                    placeholder: "Saving BTD",
                    type: "number",
                },
            },
            buttons: {
                cancel: 'Not Now',
                confirm: 'Pay Now'
            },
        })
            .then((value) => {
                if (value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '/Member-saving_deposit',
                        data: {
                            "collection":value,
                            "voucher_no":voucherNo,
                        },
                        success:function (data) {

                            if(data == 'success'){
                                swal("Saving has been taken!",{
                                    icon: "success",
                                });
                                location.reload();
                            }else {
                                swal("Invalid Entry!",{
                                    icon: "error",
                                });
                            }

                        }
                    })
                } else {
                    swal("Please make payment as early you can!");
                }
            });
    });

});
