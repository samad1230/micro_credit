@extends('layouts.master-layouts')

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
                                            <span class="float-right">
                                                <a class="text-success mr-2 editMemberBtn" href="javascript: void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
{{--                                        <a class="text-danger mr-2 deleteMemberBtn" href="javascript: void(0)"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}
                                            </span>
                                        </h5>
                                        <p class="card-text">{{ $member->status != false ? '('.ucwords('active').')' : '('.ucwords('deactive').')'  }} {{" "."Member No : " .$member->member_no}}
                                            <br> {{"Ledger No : " .@$member->ledgerid}}</p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Father Name : </b>{{ ucwords($member->father_name) }}</li>
                                        <li class="list-group-item"><b>Phone : </b>{{ $member->mobile }}</li>
                                        <li class="list-group-item"><b>Source of Income : </b>{{ ucwords($member->occupation) }}</li>
                                        <li class="list-group-item"><b>Join Date : </b>{{ $member->join_date }}</li>
                                        <li class="list-group-item"><b>Present Address : </b>{{ $member->present_address }}</li>
                                        <li class="list-group-item"><b>Permanent Address : </b>{{ $member->permanent_address }}</li>
                                        <li class="list-group-item"><b>DPS No : </b>{{ null }}</li>
                                        <li class="list-group-item"><b>Savings No : </b>{{ $member->saveingmem->savings_no }}</li>
                                        <li class="list-group-item"><b>Lone No : </b>
                                            @foreach($member->Loans as $data)
                                            {{$data->investment_no}}
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-dark text-white o-hidden mb-4">
                                    <img class="card-img" src="{{ asset('Media/Member_NUID/'.$member->nidImage->nuid_image) }}" alt="Card image">
                                    <div class="card-img-overlay">
                                        <div class="text-center pt-4">
                                            <h5 class="card-title mb-2 text-white">{{ strtoupper('nid') }}</h5>
                                            <div class="separator border-top mb-2"></div>
                                            <p class="text-small font-italic">{{ $member->nidImage->nuid_no }}</p>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>Nominee Name : </b>{{ @$member->nominee->name }}</li>
                                    <li class="list-group-item"><b>Nominee Father : </b>{{ @$member->nominee->father_name }}</li>
                                    <li class="list-group-item"><b>Relation : </b>{{ @$member->nominee->relation }}</li>
                                    <li class="list-group-item"><b>Nominee Age : </b>{{ @$member->nominee->age }}</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal-->
    <div class="modal fade" id="memderEditModalCenter" tabindex="-1" role="dialog" aria-labelledby="memderEditModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memderEditModalLongTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            <form action="{{ route('Member.update',$member->slag) }}" method="post" class="needs-validation membarEditForm" novalidate="novalidate" autocomplete="on" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-5 mb-3">
                                        <label for="memberName">{{ ucwords('member name*') }}</label>
                                        <input class="form-control" name="name" id="memberName" type="text" placeholder="{{ ucwords('name') }}" value="{{ $member->name }}" required="required" autofocus>
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member name is required.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="memberPhone">{{ ucwords('phone number*') }}</label>
                                        <input class="form-control" name="phone" id="memberPhone" type="tel" placeholder="{{ ucwords('phone number') }}" value="{{ $member->mobile }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member phone number is required.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="fatherName">{{ ucwords('father name*') }}</label>
                                        <input class="form-control" name="father_name" id="fatherName" type="text" placeholder="{{ ucwords('father name') }}" value="{{ $member->father_name }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member father name is required.') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="memberIncomeSource">{{ ucwords('source of income*') }}</label>
                                        <select class="form-control" name="income_source" id="memberIncomeSource" required="required">
                                            <option value="{{ $member->occupation }}">{{ $member->occupation }}</option>
                                            <option value="Business">Business</option>
                                            <option value="Service">Service</option>
                                            <option value="Driver">Driver</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member source of income is required.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ledgerId">{{ ucwords('ledger id *') }}</label>
                                        <input class="form-control" name="ledgerid" id="ledgerId" type="text" placeholder="{{ ucwords('ledger id') }}" value="{{ $member->ledgerid }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member ledger id is required.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="nidNo">{{ ucwords('nid no*') }}</label>
                                        <input class="form-control" name="nid_no" id="nidNo" type="text" placeholder="{{ ucwords('national id card number') }}" value="{{ $member->nidImage->nuid_no }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member national ID card number is required.') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="avatarImage">{{ ucwords('Image (optional)') }}</label>
                                        <input class="form-control" name="avatar_image" id="avatarImage" type="file" accept="image/*">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nidImage">{{ ucwords('nid image*') }}</label>
                                        <input class="form-control" name="nid_image" id="nidImage" type="file" accept="image/*">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="presentAddress">{{ ucwords('present address') }}</label>
                                        <input class="form-control" name="present_address" id="presentAddress" type="text" value="{{ $member->present_address }}" placeholder="Present Address" required="required">
                                        <div class="invalid-tooltip">
                                            {{ 'present address is required' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="permanentAddress">{{ ucwords('permanent address') }}</label>
                                        <input class="form-control" name="permanent_address" id="permanentAddress" type="text" value="{{ $member->permanent_address }}" placeholder="Permanent Address" required="required">
                                        <div class="invalid-tooltip">
                                            {{ 'permanent address is required' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nomineeName">{{ ucwords('nominee name') }}<span class="tx-danger"> * </span></label>
                                        <input class="form-control" name="nominee" id="nomineeName" type="text" placeholder="{{ ucwords('nominee name') }}" value="{{@$member->nominee->name}}" required="required">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="FatherName">{{ ucwords('nominee father name ') }} <span class="tx-danger"> * </span></label>
                                        <input class="form-control" name="nomineefather" id="FatherName" type="text" placeholder="{{ ucwords('nominee father name ') }}" value="{{@$member->nominee->father_name}}" required="required">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nomineeAge">{{ ucwords('nominee Age') }}<span class="tx-danger">* </span></label>
                                        <input class="form-control" name="nomineeage" id="nomineeAge" type="text" placeholder="Age" value="{{@$member->nominee->age}}" required="required">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nomineeRelation">{{ ucwords('nominee relation ') }} <span class="tx-danger"> * </span></label>
                                        <input class="form-control" name="nomineerelation" id="nomineeRelation" type="text" placeholder=" {{ ucwords('nominee relation.') }}" value="{{@$member->nominee->relation}}" required="required">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <button class="btn btn-primary m-2" type="submit">Submit form</button>
                                    <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    {{ route('admin.destroy-member',$member->slag) }}--}}
    <form action="#" method="get" class="memberDeleteForm">
        @csrf
    </form>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
    <script !src="">
        $(function () {
            $('.editMemberBtn').on('click',function () {
                $('#memderEditModalCenter').modal('show');
            });
            $('.deleteMemberBtn').on('click',function () {
                $('.memberDeleteForm').submit();
            });
        })
    </script>
@endsection
