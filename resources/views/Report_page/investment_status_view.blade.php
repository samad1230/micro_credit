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
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('collection.statussearch')}}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" name="status" id="">
                                                    <option value="">Collection Status</option>
                                                    <option value="due">Due</option>
                                                    <option value="1">Paid</option>
                                                    <option value="2">Penalty</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="From date" type="date" name="startdate" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="To date" type="date" name="enddate" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <button type="submit" class="btn btn-primary btn-md">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allInvestmentsDataTable">
                            <thead class="btn-success">
                            <tr>
                                <th class="text-center">{{ ucwords('sl') }}</th>
                                <th class="text-center">{{ ucwords('voucher no') }}</th>
                                <th class="text-center">{{ ucwords('name') }}</th>
                                <th class="text-center">{{ ucwords('installment date') }}</th>
                                <th class="text-center">{{ ucwords('installment') }}</th>
                                <th class="text-center">{{ ucwords('collection') }}</th>
                                <th class="text-center">{{ ucwords('balance') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl=1;?>
                            @foreach($installments as $installment)
                                <tr>
                                    <th>{{ $sl}}</th>
                                    <td>{{ $installment->voucher_no }}</td>
                                    <td>{{ $installment->investment->member->name }}</td>
                                    <td>{{ date('d-m-Y',strtotime($installment->date)) }}</td>
                                    <td>{{ number_format($installment->installment_amount,'2','.',',') }}</td>
                                    <td>{{ number_format($installment->collection_amount,'2','.',',') }}</td>
                                    <td>{{ number_format($installment->rest_amount,'2','.',',') }}</td>
                                    <td>
                                        @if($installment->status =='1' && $installment->rest_amount=='0' )
                                            {!! '<b class="text-success">'.strtoupper('paid').'</b>' !!}
                                        @elseif($installment->status =='0')
                                            {!! '<b class="text-danger">'.strtoupper('due').'</b>' !!}
                                        @elseif($installment->status =='1' && $installment->rest_amount !='0')
                                            {!! '<b class="text-primary">'.strtoupper('unpaid').'</b>' !!}
                                        @else
                                            {!! '<b class="text-danger">'.strtoupper('penalty add').'</b>' !!}
                                        @endif
                                    </td>
                                </tr>
                                <?php $sl++;?>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $installments->links() }}
                        </div>
                        <?php
                            if (isset($_COOKIE["CollectionStatusSearch"])){
                        ?>
                            <a href="{{route('collection_status.print')}}" class="btn btn-primary btn-md" target="_blank" style="float: right">Print</a>
                        <?php
                            }
                       ?>

                    </div>

                </div>
            </div>
        </div>

    <div class="modal fade" id="Penaltyupdate" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Update Penalty</h4>
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
                    <form action="" class="editsupplier_data" method="POST"  enctype="multipart/form-data">
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
                                    <label class=" " for="">Voucher No</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="voucher" class="form-control" id="voucher_no" placeholder="Voucher No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="Contact">Penalty Amount</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="PenaltyAmount" class="form-control" id="" placeholder="Penalty Amount" required="">
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

@endsection

@section('page-script')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/payment_saving.js') }}"></script>

    <script !src="">
        $(document).on("click", ".penaltyfine", function(e){
            e.preventDefault();
            var voucherNo = $(this).attr('id');
            var voucher = voucherNo.replace('#', '');
            $.ajax({
                type: 'GET',
                url:'/Penalty/Installment/amount/'+voucher,

                success: function (data) {

                    $("#voucher_no").val(data.voucher_no);
                    $("#member_name").val(data.membername);

                    $('.editsupplier_data').attr('action', '/PanaltiInsert/'+voucher);
                }
            });
            $("#Penaltyupdate").modal('show');

        });
    </script>
@endsection
