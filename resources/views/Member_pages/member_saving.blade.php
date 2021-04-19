@extends('layouts.master-layouts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ ucwords('member saving') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allMembersDataTable">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('member') }}</th>
                                <th class="text-center">{{ ucwords('saving no') }}</th>
                                <th class="text-center">{{ ucwords('saving') }}</th>
                                <th class="text-center">{{ ucwords('profit') }}</th>
                                <th class="text-center">{{ ucwords('total') }}</th>
                                <th class="text-center">{{ ucwords('withdraw') }}</th>
                                <th class="text-center">{{ ucwords('blanch') }}</th>
                                <th class="text-center"><i class="i-Eye font-weight-bold"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($saving as $member)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>{{ ucwords($member->member->name) }}</td>
                                    <td>{{ $member->savings_no }}</td>
                                    <td>{{ $member->savings_amount }}</td>
                                    <td>{{ $member->savings_profit }}</td>
                                    <td>{{ $member->total_amount }}</td>
                                    <td>{{ $member->savings_windrow }}</td>
                                    <td>{{ $member->savings_blanch }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm savingcollectionBtn" id="{{ $member->id }}">Saving</button>

                                        <a href="#">
                                            <button type="button" class="btn btn-warning btn-sm savingwithrwal" id="{{$member->id}}">{{ ucwords('withdraw') }}</button>
                                        </a>
                                        <a href="{{ route('saving.show',$member->id) }}">
                                            <button type="button" class="btn btn-info btn-sm">{{ ucwords('view') }}</button>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="SavingCollection" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Saving Collection</h4>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="" class="saving_collection_data" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_name" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class=" " for="">Savings No</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="saving" class="form-control" id="voucher_no" placeholder="Voucher No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="Contact">Savings Amount</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="savingAmount" class="form-control" id="" placeholder="Savings Amount" required="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="SavingCollectionwithrwal" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Saving Withdrawal</h4>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="" class="saving_Withdrawal_data" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_namesaving" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Savings No</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="saving" class="form-control" id="Savings_no" placeholder="Savings No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Savings Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="SavingsAmount" class="form-control" id="SavingsAmount" placeholder="Savings Amount" onkeyup="checkFunction()" readonly="" >
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Withdrawal Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="SavingsWithdrawalAmount" class="form-control" id="WithdrawalAmount" placeholder="Withdrawal Amount" onchange="checkFunction()" required="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveidbtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-script')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allMembersDataTable').DataTable();
        })
    </script>
    <script !src="">
        $(document).on("click", ".savingcollectionBtn", function(e){
            e.preventDefault();
            var savingid = $(this).attr('id');
            //var voucher = voucherNo.replace('#', '');
            $.ajax({
                type: 'GET',
                url:'/SavingIdData/'+savingid,

                success: function (data) {

                    $("#voucher_no").val(data.savingno);
                    $("#member_name").val(data.membername);

                    $('.saving_collection_data').attr('action', '/SavingCollectionSave/'+savingid);
                }
            });
            $("#SavingCollection").modal('show');

        });
        $(function () {
            $('.savingwithrwal').on('click', function () {
                var savingid = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: '/SavingIdData/' + savingid,
                    success: function (data) {
                        $("#Savings_no").val(data.savingno);
                        $("#member_namesaving").val(data.membername);
                        $("#SavingsAmount").val(data.savingamount);
                        $('.saving_Withdrawal_data').attr('action', '/SavingWithdrawalAmount/' + savingid);
                    }
                });
                $("#SavingCollectionwithrwal").modal('show');
            });
        });
    </script>
@endsection


