@extends('layouts.master-layouts')

@section('page-css')

@endsection

@section('content')
    <div class="main-content pt-4">
            <div class="separator-breadcrumb border-top"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Basic Column chart</div>
                            <div id="basicColumn-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Column with Data Labels</div>
                            <div id="columnDataLabel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

