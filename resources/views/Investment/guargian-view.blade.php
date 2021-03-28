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
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span style="font-size: 16px; color: blue; font-weight: bold">{{ ucwords($guardians->name) }}</span>
                                            <span class="float-right">
                                                <a class="text-success mr-2 editguardianBtn" href="javascript: void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            </span>
                                        </h4>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Father Name : </b>{{ ucwords($guardians->father_name) }}</li>
                                        <li class="list-group-item"><b>Phone : </b>{{ $guardians->phone }}</li>
                                        <li class="list-group-item"><b>NUID No : </b>{{ ucwords($guardians->nid_no) }}</li>
                                        <li class="list-group-item"><b>Relation : </b>{{ ucwords($guardians->relational_status) }}</li>
                                        <li class="list-group-item"><b>Present Address : </b>{{ $guardians->present_address }}</li>
                                        <li class="list-group-item"><b>Permanent Address : </b>{{ $guardians->permanent_address }}</li>
                                        <li class="list-group-item"><b>For Member No : </b>{{ $guardians->investment_for }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-dark text-white o-hidden mb-4">
                                    <img class="card-img" src="{{ asset('Media/Guardian_NUID/'.$guardians->guardianimages->image) }}" alt="Card image">
                                    <div class="card-img-overlay">
                                        <div class="text-center pt-4">
                                            <h5 class="card-title mb-2 text-white">{{ strtoupper('nid') }}</h5>
                                            <div class="separator border-top mb-2"></div>
                                            <p class="text-small font-italic">{{ $guardians->nid_no }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal-->
    <div class="modal fade" id="guardianEditModalCenter" tabindex="-1" role="dialog" aria-labelledby="memderEditModalCenterTitle" aria-hidden="true">
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

                            <form action="{{ route('guardian.update',$guardians->id) }}" method="post" class="needs-validation membarEditForm" novalidate="novalidate" autocomplete="on" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="memberName">{{ ucwords('guardian name*') }}</label>
                                        <input class="form-control" name="name" id="memberName" type="text" placeholder="{{ ucwords('name') }}" value="{{ $guardians->name }}" required="required" autofocus>
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member name is required.') }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fatherName">{{ ucwords('father name*') }}</label>
                                        <input class="form-control" name="father_name" id="fatherName" type="text" placeholder="{{ ucwords('father name') }}" value="{{ $guardians->father_name }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member father name is required.') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="memberPhone">{{ ucwords('phone number*') }}</label>
                                        <input class="form-control" name="phone" id="memberPhone" type="tel" placeholder="{{ ucwords('phone number') }}" value="{{ $guardians->phone }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member phone number is required.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nidNo">{{ ucwords('nid no*') }}</label>
                                        <input class="form-control" name="nid_no" id="nidNo" type="text" placeholder="{{ ucwords('national id card number') }}" value="{{ $guardians->nid_no }}" required="required">
                                        <div class="invalid-tooltip">
                                            {{ ucwords('member national ID card number is required.') }}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nidImage">{{ ucwords('Relation*') }}</label>
                                        <input class="form-control" name="relation" value="{{$guardians->relational_status}}" type="text">
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="nidImage">{{ ucwords('nid image*') }}</label>
                                        <input class="form-control" name="nid_image" id="nidImage" type="file" accept="image/*">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="presentAddress">{{ ucwords('present address') }}</label>
                                        <input class="form-control" name="present_address" id="presentAddress" type="text" value="{{ $guardians->present_address }}" placeholder="Present Address" required="required">
                                        <div class="invalid-tooltip">
                                            {{ 'present address is required' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="permanentAddress">{{ ucwords('permanent address') }}</label>
                                        <input class="form-control" name="permanent_address" id="permanentAddress" type="text" value="{{ $guardians->permanent_address }}" placeholder="Permanent Address" required="required">
                                        <div class="invalid-tooltip">
                                            {{ 'permanent address is required' }}
                                        </div>
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

@endsection

@section('page-script')
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
    <script !src="">
        $(function () {
            $('.editguardianBtn').on('click',function () {
                $('#guardianEditModalCenter').modal('show');
            });
        })
    </script>
@endsection
