@extends('layouts.master-layouts')

@section('page-css')

@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ ucwords('add new member') }}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('Member.store')}}" method="post" class="needs-validation" novalidate="novalidate" autocomplete="on" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="memberName">{{ ucwords('member name ') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="name" id="memberName" type="text" placeholder="{{ ucwords('name') }}" value="" required="required" autofocus>
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member name is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="ledgerID">{{ ucwords('ledger id ') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="ledgerid" id="ledgerID" type="text" placeholder="{{ ucwords('ledger id') }}" value="" required="required" autofocus>
                                    <div class="invalid-tooltip">
                                        {{ ucwords('ledger id is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="memberPhone">{{ ucwords('phone number ') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="phone" id="memberPhone" type="tel" placeholder="{{ ucwords('phone number') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member phone number is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="fatherName">{{ ucwords('father name ') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="father_name" id="fatherName" type="text" placeholder="{{ ucwords('father name') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member father name is required.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="fatherName">{{ ucwords('husband name ') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="husband_name" id="husbandName" type="text" placeholder="{{ ucwords('husband name') }}" value="" >
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="memberMotherName">{{ ucwords('mother name *') }}</label>
                                    <input class="form-control" name="mothername" id="memberMotherName" type="text" placeholder="Mother Name" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member mother name is required.') }}
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="memberincomeSource">{{ ucwords('source of income ') }}<span class="tx-danger">* </span></label>
                                    <select class="form-control" name="income_source" id="memberIncomeSource" required="required">
                                        <option value="">Select Occupation</option>
                                        <option value="Business">Business</option>
                                        <option value="Service">Service</option>
                                        <option value="Driver">Driver</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member source of income is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nidNo">{{ ucwords('nid no ') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="nid_no" id="nidNo" type="text" placeholder="{{ ucwords('national id card number') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member national ID card number is required.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="memberAge">{{ ucwords('Member Age ') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="memberage" id="memberAge" type="text" placeholder="Age" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member Age is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="memberGender">{{ ucwords('Member Gender ') }}<span class="tx-danger"> * </span></label>
                                    <select class="form-control" name="gender" id="memberGender" required="required">
                                        <option value="">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Common</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        {{ ucwords(' Member Gender is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="MaritalStatus">{{ ucwords('Marital Status ') }}<span class="tx-danger"> * </span></label>
                                    <select class="form-control" name="Maritalstatus" id="MaritalStatus" required="required">
                                        <option value="">Marital Status</option>
                                        <option value="1">Married</option>
                                        <option value="2">UN Married</option>
                                        <option value="3">Divorced</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        {{ ucwords(' Member Marital Status is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="memberReligion">{{ ucwords('Member Religion ') }}<span class="tx-danger"> * </span></label>
                                    <select class="form-control" name="religion" id="memberReligion" required="required">
                                        <option value="">Select Religion</option>
                                        <option value="Muslim">Muslim</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddhists">Buddhists</option>
                                        <option value="Christians">Christians</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        {{ ucwords(' Member Religion is required.') }}
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="avatarImage">{{ ucwords('Image (optional)') }}</label>
                                    <input class="form-control" name="avatar_image" id="avatarImage" type="file" accept="image/*">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nidImage">{{ ucwords('nid image ') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="nid_image" id="nidImage" type="file"required="required" accept="image/*">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('member national id card image is required.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="presentAddress">{{ ucwords('present address ') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="present_address" id="presentAddress" type="text" placeholder="Present Address" required="required">
                                    <div class="invalid-tooltip">
                                        {{ 'present address is required' }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="permanentAddress">{{ ucwords('permanent address ') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="permanent_address" id="permanentAddress" type="text" placeholder="Permanent Address" required="required">
                                    <div class="invalid-tooltip">
                                        {{ 'permanent address is required' }}
                                    </div>
                                </div>
                            </div>
                            <div class="separator"> <span class="tx-danger"> * </span> Nominee section <span class="tx-danger"> * </span></div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="nomineeName">{{ ucwords('nominee name') }}<span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="nominee" id="nomineeName" type="text" placeholder="{{ ucwords('nominee name') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('nominee name is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="FatherName">{{ ucwords('nominee father name ') }} <span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="nomineefather" id="FatherName" type="text" placeholder="{{ ucwords('nominee father name ') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('nominee father name is required.') }}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="nomineeAge">{{ ucwords('nominee Age') }}<span class="tx-danger">* </span></label>
                                    <input class="form-control" name="nomineeage" id="nomineeAge" type="text" placeholder="Age" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('nominee Age is required.') }}
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="nomineeRelation">{{ ucwords('nominee relation ') }} <span class="tx-danger"> * </span></label>
                                    <input class="form-control" name="nomineerelation" id="nomineeRelation" type="text" placeholder=" {{ ucwords('nominee relation.') }}" value="" required="required">
                                    <div class="invalid-tooltip">
                                        {{ ucwords('nominee relation is required.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
@endsection

