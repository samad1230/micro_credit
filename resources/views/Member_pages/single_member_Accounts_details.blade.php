@extends('layouts.master-layouts')
<style>
    .rightdata{
        float: right;
        color: red;
        font-weight: bold;
    }
    .leftdata{
        color: red;
        font-weight: bold;
    }

</style>
@section('page-css')

@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 o-hidden">
                                    @if($member->avatar_image != null)
                                        <img class="card-img-top" height="180px" src="{{ asset('Media/Member_Avature/'.$member->nidImage->member_image) }}" alt="{{ ucwords('avatar image') }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <span>{{ ucwords($member->name) }}</span>
                                        </h5>
                                        <p class="card-text">{{ $member->status != false ? '('.ucwords('active').')' : '('.ucwords('deactive').')'  }} {{" "."Member No : " .$member->member_no}}
                                            <br> {{"Ledger No : " .@$member->ledgerid}}<br>
                                                @foreach($member->Loans as $data)
                                                {{"Lone No : " .$data->investment_no}}
                                                @endforeach
                                        </p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Loan Amount : </b>ট {{ $investment->investment_return_amount }}</li>
                                        <li class="list-group-item"><b>Paid Money : </b>ট {{ $investpaid }}<span class="rightdata">{{$totalpaid}}</span></li>
                                        <li class="list-group-item"><b>Blanch : </b> ট {{ $investdue }} <span class="rightdata">{{$totaldue}}</span></li>
                                        <li class="list-group-item"><b>Penalty : </b>ট {{ $investpanalti }}<span class="rightdata">{{$totalpnalti}}</span></li>
                                        <li class="list-group-item leftdata"><b>Last Blanch : </b>ট {{ $investdue + $investpanalti }}</li>

                                        <li class="list-group-item"><b>Saving Amount : </b>{{ @$member->memberAccount->saving_amount }}</li>

                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4 o-hidden">
                                    <button type="button" class="btn btn-success btn-md">{{ ucwords('saving withdrawal') }}</button>
                                    <br>
                                        <button type="button" class="btn btn-danger btn-md">{{ ucwords('extra Penalty ') }}</button>
                                    <br>
                                    <button type="button" class="btn btn-info btn-md">{{ ucwords('loan adjustment') }}</button>
                                    <br>


                                </div>
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
            $('.editMemberBtn').on('click',function () {
                $('#memderEditModalCenter').modal('show');
            });

        })
    </script>
@endsection
