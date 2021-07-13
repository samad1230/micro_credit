@extends('layouts.master-layouts')

@section('page-css')

@endsection
<?php use Illuminate\Support\Facades\Auth;$user_id =Auth::user()->role_id; ?>

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">{{ ucwords('contacts setting') }}</div>
                            </div>
                            <div class="col-md-6">
                                <?php

                                if (count($company)== 0) {
                                ?>
                                <a href="#">
                                    <button class="btn btn-primary btn-md float-right" type="button" data-toggle="modal" data-target="#addprofile"><i class="i-Add text-white mr-2"></i> Add Company Profile</button>
                                </a>
                                <?php
                                }else{
                                ?>
                                <a href="#">
                                    <button class="btn btn-primary btn-md float-right editprofile" type="button" id="{{@$company[0]->id}}"><i class="i-Add text-white mr-2"></i> {{ ucwords('Edit Company Profile') }}</button>
                                </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allAmenitiesData">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('logo') }}</th>
                                <th class="text-center">{{ ucwords('company name') }}</th>
                                <th class="text-center">{{ ucwords('address') }}</th>
                                <th class="text-center">{{ ucwords('contact') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($company as $row)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>
                                        @if($row->image != null)
                                            <img width="60px" src="{{ asset('Media/company_profile/'.$row->image) }}" alt="LOGO">
                                        @endif
                                    </td>
                                    <td>{{ ucwords($row->name) }}</td>
                                    <td>{{ ucwords($row->address) }}</td>
                                    <td>{{ ucwords($row->contact) }}</td>
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


    <div class="modal fade" id="addprofile" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Company Profile </h4>
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
                    <form action="{{route('CompanyProfice.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Company name :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="company" class="form-control" id="" placeholder="Company Name" autocomplete="off" required>
                                    <div class="invalid-tooltip">
                                        {{ ucwords('company name is required.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Contact :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="contact" class="form-control" id="" autocomplete="off" placeholder="Contact">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Address :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="address" class="form-control" id="" autocomplete="off" placeholder="Address">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Owner :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="owner" class="form-control" id="" autocomplete="off" placeholder="Owner">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Vat NO :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="vatno" class="form-control" id="" autocomplete="off" placeholder="Vat NO">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">License :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="license" class="form-control" id="" autocomplete="off" placeholder="License">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Company Logo :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="logo" class="form-control" required>
                                    <div class="invalid-tooltip">
                                        {{ ucwords('logo is required.') }}
                                    </div>
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


    <div class="modal fade" id="companyprofile" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Company Profile Update </h4>
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
                    <form action="" class="update_companyProfile"  method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Company name :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="company" class="form-control" id="company_edit" placeholder="Company Name" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Contact :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="contact" class="form-control" id="contact_edit" autocomplete="off" placeholder="Contact">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Address :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="address" class="form-control" id="address_edit" autocomplete="off" placeholder="Address">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Owner :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="owner" class="form-control" id="owner_edit" autocomplete="off" placeholder="Owner">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Vat NO :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="vatno" class="form-control" id="vatno_edit" autocomplete="off" placeholder="Vat NO">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">License :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="license" class="form-control" id="license_edit" autocomplete="off" placeholder="License">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Company Logo :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="logo" class="form-control">
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
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>

    <script>
        $(function(){
            $('.editprofile').on('click', function(){
                var profileid = $(this).attr("id");
                $.ajax({
                    type: 'GET',
                    url:'/CompanyProfice/'+profileid+'/edit',
                    success: function (data) {
                        //console.log(data);
                        $("#company_edit").val(data.name);
                        $("#contact_edit").val(data.contact);
                        $("#address_edit").val(data.address);
                        $("#owner_edit").val(data.owner);
                        $("#vatno_edit").val(data.vat);
                        $("#license_edit").val(data.license);
                        $('.update_companyProfile').attr('action', '/CompanyProfice/'+profileid);
                    }
                });
                $("#companyprofile").modal('show');

            });

        });
    </script>

@endsection


