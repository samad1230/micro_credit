@extends('layouts.master-layouts')

@section('page-css')

@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>{{ ucwords('register') }}</span>
                            <span class="float-right p-3 text-white {{ is_int(strpos($cashAtHand,'-')) != true ? 'bg-success' : 'bg-danger' }}" style="border-radius: 10px;">{!! ucwords('cash at hand: ').number_format($cashAtHand,'2','.',',') !!}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 px-5">
                                <div class="row">
                                    <h5 class="text-muted font-weight-bold">
                                        <span>{{ ucwords('capital introduce') }}</span>
                                        <button type="button" class="btn btn-success btn-sm addCapitalIntroduceFormInputFieldGroupBtn">&plus;</button>
                                    </h5>

                                    <form action="{{ route('admin.capital-introduce') }}" method="post" class="capitalIntroduceForm needs-validation" novalidate="novalidate" autocomplete="on">
                                        @csrf
                                        <div class="form-group formInputFieldGroup">
                                            <div class="row">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>

                                                    <input class="form-control" type="text" name="description[]" placeholder="Description" required autofocus>

                                                    <div class="invalid-tooltip">
                                                        Description Field is Required
                                                    </div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                                                    <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger btn-sm removeCapitalIntroduceFormInputFieldGroupBtn">&times;</button>
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                        BDT Amount Field is Required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>

                                <hr>

                                <div class="row">
                                    <h5 class="text-muted font-weight-bold">
                                        <span>{{ ucwords('cash withdrawal') }}</span>
                                        <button type="button" class="btn btn-success btn-sm addCashWithdrawalFormInputFieldGroupBtn">&plus;</button>
                                    </h5>

                                    <form action="{{ route('admin.capital-withdrawal') }}" method="post" class="cashWithdrawalForm needs-validation" novalidate="novalidate" autocomplete="on">
                                        @csrf
                                        <div class="form-group formInputFieldGroup">
                                            <div class="row">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>

                                                    <input class="form-control" type="text" name="description[]" placeholder="Name" required autofocus>

                                                    <div class="invalid-tooltip">
                                                        Description Field is Required
                                                    </div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                                                    <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger btn-sm removeCashWithdrawalFormInputFieldGroupBtn">&times;</button>
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                        BDT Amount Field is Required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6 px-5">
                                <h5 class="text-muted font-weight-bold">
                                    <span>{{ ucwords('expense register') }}</span>
                                    <button type="button" class="btn btn-success btn-sm addExpenseRegisterFormInputFieldGroupBtn">&plus;</button>
                                </h5>

                                <form action="{{ route('admin.expense-register') }}" method="post" class="expenseRegisterForm needs-validation" novalidate="novalidate" autocomplete="on">
                                    @csrf
                                    <div class="form-group formInputFieldGroup">
                                        <div class="row">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>

                                                <input class="form-control" type="text" name="description[]" placeholder="Description" required autofocus>

                                                <div class="invalid-tooltip">
                                                    Description Field is Required
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                                                <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger btn-sm removeExpenseRegisterFormInputFieldGroupBtn">&times;</button>
                                                </div>
                                                <div class="invalid-tooltip">
                                                    BDT Amount Field is Required
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
    <script !src="">
        $(function () {
            //capital introduce
            $('.addCapitalIntroduceFormInputFieldGroupBtn').on('click',function () {
                $('.capitalIntroduceForm').find('.formInputFieldGroup').append('<div class="row">\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>\n' +
                    '\n' +
                    '        <input class="form-control" type="text" name="description[]" placeholder="Description" required autofocus>\n' +
                    '\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            Description Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text">৳</span></div>\n' +
                    '        <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>\n' +
                    '        <div class="input-group-append">\n' +
                    '            <button type="button" class="btn btn-danger btn-sm removeCapitalIntroduceFormInputFieldGroupBtn">&times;</button></div>\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            BDT Amount Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>');

                $('.removeCapitalIntroduceFormInputFieldGroupBtn').on('click',function (e) {
                    e.preventDefault();
                    $(this).parent().parent().parent().remove();
                });
            });

            $('.removeCapitalIntroduceFormInputFieldGroupBtn').on('click',function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().remove();
            });

            // capital withdrawal
            $('.addCashWithdrawalFormInputFieldGroupBtn').on('click',function () {
                $('.cashWithdrawalForm').find('.formInputFieldGroup').append('<div class="row">\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>\n' +
                    '\n' +
                    '        <input class="form-control" type="text" name="description[]" placeholder="Description" required autofocus>\n' +
                    '\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            Description Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text">৳</span></div>\n' +
                    '        <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>\n' +
                    '        <div class="input-group-append">\n' +
                    '            <button type="button" class="btn btn-danger btn-sm removeCashWithdrawalFormInputFieldGroupBtn">&times;</button></div>\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            BDT Amount Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>');

                $('.removeCashWithdrawalFormInputFieldGroupBtn').on('click',function (e) {
                    e.preventDefault();
                    $(this).parent().parent().parent().remove();
                });
            });

            $('.removeCashWithdrawalFormInputFieldGroupBtn').on('click',function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().remove();
            });

            // expense register
            $('.addExpenseRegisterFormInputFieldGroupBtn').on('click',function () {
                $('.expenseRegisterForm').find('.formInputFieldGroup').append('<div class="row">\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Description</span></div>\n' +
                    '\n' +
                    '        <input class="form-control" type="text" name="description[]" placeholder="Description" required autofocus>\n' +
                    '\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            Description Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="input-group mb-3">\n' +
                    '        <div class="input-group-prepend"><span class="input-group-text">৳</span></div>\n' +
                    '        <input class="form-control" type="number" name="amount[]" step="0.2" placeholder="BDT" required>\n' +
                    '        <div class="input-group-append">\n' +
                    '            <button type="button" class="btn btn-danger btn-sm removeExpenseRegisterFormInputFieldGroupBtn">&times;</button></div>\n' +
                    '        <div class="invalid-tooltip">\n' +
                    '            BDT Amount Field is Required\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>');

                $('.removeExpenseRegisterFormInputFieldGroupBtn').on('click',function (e) {
                    e.preventDefault();
                    $(this).parent().parent().parent().remove();
                });
            });

            $('.removeExpenseRegisterFormInputFieldGroupBtn').on('click',function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().remove();
            });
        })
    </script>
@endsection

