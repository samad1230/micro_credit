
@extends('print_layouts.print_master_layout')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/print/fullprint.css')}}">
@endsection
@section('content')

    <div id="product">
        <div class="product overflow-auto">
            <div class="col-md-12 mx-auto">
                <?php
                    $company = \App\Admin_model\CompanyProfile::first();
                ?>
            <div class="shohroomdata">
                <div class="row">
                    <div class="col">
                        <div class="printhead">
                            <h4><img width="80px" src="{{ asset('Media/company_profile/'.@$company->image) }}" alt="Image"></h4>
                            <h6>{{@$company->name}}</h6>
                            <h6>{{@$company->address}}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <main>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-striped table-hover" id="allMembersDataTable">
                                <thead>
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
                                    @php
                                        $todayDate = time();
                                        $today = date('Y-m-d',$todayDate);
                                    @endphp
                                    <tr>
                                        <td>{{ $sl}}</td>
                                        <td>{{ $installment->voucher_no }}</td>
                                        <td>{{ $installment->investment->member->name }}</td>
                                        <td>{{ date('d-m-Y',strtotime($installment->date)) }}</td>
                                        <td>{{ number_format($installment->installment_amount,'2','.',',') }}</td>
                                        <td class="collect">{{ number_format($installment->collection_amount,'2','.',',') }}</td>
                                        <td class="blanch"> {{ number_format($installment->rest_amount,'2','.',',') }}</td>
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

                                <tr>
                                    <td colspan="6" style="font-size: 14px; font-weight: bold; text-align: right;" class="totalcollect"> </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="font-size: 14px; font-weight: bold; text-align: right;" class="totalblanch"> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="signaturre">
                    <h6 style="text-align: right;
    margin-right: 46px; text-decoration: underline; margin-bottom: 10px;"></h6>
                    <hr>
                    <p style="text-align: center">Invoice was created on a computer and is valid without the signature and seal.</p>
                </div>
            </main>
        </div>
    </div>
    </div>


@endsection
@section('pagescript')
    <script type="text/javascript" src="{{ asset('assets/print/ajax.jquery.min.js') }}"></script>
    <script>

        $(function(){
            function tally (selector, columnname, textline="") {
                $(selector).each(function () {
                    var total = 0,
                        column = $(this).siblings(selector).andSelf().index(this);
                    $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                        total += parseFloat($(columnname + column + ')', this).html()) || 0;
                    })
                    $(this).html(textline+total);
                });
            }
            tally('td.totalcollect','td.collect:eq(' , "Total Collection : ");
            tally('td.totalblanch','td.blanch:eq(' , "Last Blanch : ");


        });
    </script>
@endsection
