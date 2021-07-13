@extends('layouts.master-layouts')

@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>{{ ucwords('add new investment') }}</span>
                            <span class="float-right p-3 text-white {{ is_int(strpos($cashAtHand,'-')) != true ? 'bg-success' : 'bg-danger' }}" style="border-radius: 10px;">{!! ucwords('investable amount: ').number_format($cashAtHand,'2','.',',') !!}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add.investment') }}" method="post" class="needs-validation" novalidate="novalidate" autocomplete="on" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="investtypestore">
                            <input type="hidden" id="memberdata">
                            <div class="row selectMember">
                                <div class="form-row col-md-12">
                                    <div class="col-md-8 mb-3">
                                        <label for="memberSelection">Member*</label>
                                        <select class="selectMember form-control" id="memberSelection" name="selected_member" required autofocus>
                                            <option disabled selected>Select Member</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->slag }}">{{ 'ID: '.$member->member_no.', Name: '.$member->name.', NID: '.$member->nidImage->nuid_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="investmentType">Investment Type</label>
                                        <select name="investment_type" class="form-control investment_type" id="investmentType" required>
                                            <option disabled selected>Select One</option>
                                            <option value="cash">Cash</option>
                                            <option value="product">Product</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Investment type is required.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row px-2">
                                <h5>
                                    <span>Add Guardian</span>
                                    <button type="button" class="btn btn-success btn-sm addGuardianBtn">&plus;</button>
                                </h5>

                                <div class="col-md-12 addGuardianContent">

                                </div>
                            </div>

                            <hr>

                            <div class="row">

                                <div class="form-row col-md-12">
                                    <div class="col-md-12 investmentOption">

                                    </div>
                                </div>

                                <div class="form-row col-md-12">
                                    <div class="col-md-4 mb-3">
                                        <label for="investmentBehaviour">Investment Behaviour</label>
                                        <select name="investment_behaviour" class="form-control" id="investmentBehaviour" required>
                                            <option disabled selected>Select One</option>
                                            <option value="1">Daily</option>
                                            <option value="7">Weekly</option>
                                            <option value="30">Monthly</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Investment behaviour is required.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="cashInHand">Cash in Hand</label>
                                        <input class="form-control" id="cashInHand" type="text" value="{{ number_format($cashAtHand,'2','.',',') }}" readonly>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="investmentAmount">Investment Amount</label>
                                        <input class="form-control" name="investment_amount" id="investmentAmount" type="number" placeholder="BDT" value="" required="required" onkeyup="checkFunction()">
                                        <div class="invalid-tooltip">
                                            Investment amount is required.
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row col-md-12">
                                    <div class="col-md-4 mb-3">
                                        <label for="installmentCount">Installment Count</label>
                                        <input class="form-control" name="installment_count" id="installmentCount" type="number" placeholder="Number of Installment" value="" required="required" onkeyup="checkFunction()">
                                        <div class="invalid-tooltip">
                                            Installment count is required.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="investmentRate">Installment Rate</label>
                                        <input class="form-control" name="interest_rate" id="investmentRate" type="tel" placeholder="Investment rate at (%)" value="" required="required" onkeyup="checkFunction()">
                                        <div class="invalid-tooltip">
                                            Installment rate is required.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="investmentReturnAmount">Investment Return</label>
                                        <input class="form-control" id="investmentReturnAmount" type="tel" readonly>
                                    </div>
                                </div>

                                <div class="form-row col-md-12">

                                    <div class="col-md-4 mb-3">
                                        <label for="sanctionDate">Sanction Date</label>
                                        <input class="form-control" name="sanction_date" id="sanctionDate" type="date" value="" required="required">
                                        <div class="invalid-tooltip">
                                            Sanction date is required.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="disburseDate">disburse Date</label>
                                        <input class="form-control" name="disburse_date" id="disburseDate" type="date" value="" required="required">
                                        <div class="invalid-tooltip">
                                            disburse date is required.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="installmentAmount">Per/Installment Amount</label>
                                        <input class="form-control" id="installmentAmount" onkeyup="checkFunction()" readonly>
                                    </div>
                                </div>
                            </div>



                            <div class="form-row text-center">
                                <button class="btn btn-primary savebtn" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
    <script !src="">
        $(function () {
            $('select.selectMember').select2();

            $('.addGuardianBtn').on('click',function () {
                $('.addGuardianContent').append('<div class="row border py-2 mb-3">\n' +
                    '    <div class="form-row col-md-12">\n' +
                    '        <div class="col-md-12">\n' +
                    '            <button type="button" class="btn btn-danger btn-sm float-right removeGuardianContentBtn">&times;</button>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="form-row col-md-12">\n' +
                    '        <div class="col-md-4 mb-3">\n' +
                    '            <label for="guardianName">Guardian Name*</label>\n' +
                    '            <input class="form-control" name="guardian_name[]" id="guardianName" type="text" placeholder="Name" value="" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian name is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '\n' +
                    '        <div class="col-md-4 mb-3">\n' +
                    '            <label for="guardianPhone">Phone Number*</label>\n' +
                    '            <input class="form-control" name="guardian_phone[]" id="guardianPhone" type="tel" placeholder="Phone Number" value="" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian phone number is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '\n' +
                    '        <div class="col-md-4 mb-3">\n' +
                    '            <label for="fatherName">Father Name*</label>\n' +
                    '            <input class="form-control" name="father_name[]" id="fatherName" type="text" placeholder="Father Name" value="" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian Relation is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="form-row col-md-12">\n' +
                    '        <div class="col-md-3 mb-3">\n' +
                    '            <label for="guardianRelationShip">Guardian Relation*</label>\n' +
                    '            <input class="form-control" name="guardian_relation[]" id="guardianRelationShip" type="text" placeholder="Guardian Relation" value="" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian Relation is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-5 mb-3">\n' +
                    '            <label for="guardianNidNo">NID No*</label>\n' +
                    '            <input class="form-control" name="guardian_nid_no[]" id="guardianNidNo" type="text" placeholder="National ID Card Number" value="" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian national ID card number is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '\n' +
                    // '        <div class="col-md-3 mb-3">\n' +
                    // '            <label for="guardianAvatarImage">Image (Optional)</label>\n' +
                    // '            <input class="form-control-file" name="guardian_avatar_image[]" id="guardianAvatarImage" type="file" accept="image/*">\n' +
                    // '        </div>\n' +
                    // '\n' +
                    '        <div class="col-md-4 mb-3">\n' +
                    '            <label for="guardianNidImage">NID Image*</label>\n' +
                    '            <input class="form-control-file" name="guardian_nid_image[]" id="guardianNidImage" type="file" required="required" accept="image/*">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian national id card image is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="form-row col-md-12">\n' +
                    '        <div class="col-md-12 mb-3">\n' +
                    '            <label for="guardianPresentAddress">Present Address</label>\n' +
                    '            <input class="form-control" name="guardian_present_address[]" id="guardianPresentAddress" type="text" placeholder="Present Address" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian present address is required\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '\n' +
                    '    <div class="form-row col-md-12">\n' +
                    '        <div class="col-md-12 mb-3">\n' +
                    '            <label for="guardianPermanentAddress">Permanent Address</label>\n' +
                    '            <input class="form-control" name="guardian_permanent_address[]" id="guardianPermanentAddress" type="text" placeholder="Permanent Address" required="required">\n' +
                    '            <div class="invalid-tooltip">\n' +
                    '                Guardian permanent address is required.\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '<hr>\n'+
                    '</div>');

                $('.removeGuardianContentBtn').on('click',function (e) {
                    e.preventDefault();
                    $(this).parent().parent().parent().remove();
                });
            });

            // cashInHand investmentAmount
            $('select.investment_type').on('change',function (){
                var selected = $(this).children("option:selected").val();
                $(".savebtn").attr('disabled', false);
                $('#investtypestore').val(selected);
                if(selected == 'cash'){
                    $('.investmentOption').empty();

                }else if(selected == 'product'){
                    $.ajax({
                        type: 'GET',
                        url:'/Product/Data',
                        success: function (data) {
                            var select="";
                            select += '<option value="">Select Product</option>';
                            $.each(data, function (idx, obj) {
                                select += ('<option value="'+ obj.id +'">' + obj.product_name + '</option>');
                            });
                            $("#product_id_add").html(select);

                        }
                    });

                    $('.investmentOption').empty().append(
                        '   <div class="form-row col-md-12">\n' +
                        '       <div class="col-md-4 mb-4">\n' +
                        '           <label for="downPayment">Product Name</label>\n' +
                        '           <select class="form-control select2" name="product_id" id="product_id_add" >\n' +

                        '           </select>\n' +
                        '       </div>\n' +
                        '        <div class="col-md-4 mb-4">\n' +
                        '              <label for="downPayment">Product Details</label>\n' +
                        '              <input class="form-control" name="productdetails" id="product_details" type="text" placeholder="Product Details" value="" onkeyup="checkFunction()">\n' +
                        '        </div>\n' +
                        '       <div class="col-md-4 mb-4">\n' +
                        '           <label for="downPayment">Down-payment</label>\n' +
                        '           <input class="form-control downPaymentAmount" name="downpayment" id="downPayment" type="number" placeholder="If have any down-patment" value="" onkeyup="checkFunction()">\n' +
                        '       </div>\n' +
                        '   </div>'
                    );

                    $('#product_id_add').on('change',function (){
                        var productid = $(this).val();
                        $.ajax({
                            type: 'GET',
                            url:'/Product/Data/'+productid,
                            success: function (data) {
                                $('#product_details').val(data.product_details);
                                $('#investmentAmount').val(data.sell_price);
                            }
                        });
                    });

                }else{
                    location.reload();
                }
            });

            // date validation
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            // var sanctionMaxDate = year + '-' + month + '-' + day;
            // var disburseMaxDate = year + '-' + month + '-' + (day+1);
            // $('#sanctionDate').attr('min', sanctionMaxDate);
            // $('#disburseDate').attr('min', disburseMaxDate);


            var countp = 0;
            $(".savebtn").click(function (event){
                countp++;
                if (countp >1){
                    $('.savebtn').attr('disabled','disabled');
                    $(this).prop("disabled",true);
                    $(this).attr("disabled","disabled");
                }
            });

            $('#memberSelection').on('change',function () {
                var selected = $("#memberSelection").val();
                $('#memberdata').val(selected);
                $(".savebtn").attr('disabled', false);
            });

            $('#investmentRate').on('change',function () {
                var investtypestore = $("#investtypestore").val();
                var memberdata = $("#memberdata").val();
                if (investtypestore =="" || memberdata ==""){
                    alert("Check Member And Investment Type");
                    $('.savebtn').attr('disabled','disabled');
                }else{
                    $(".savebtn").attr('disabled', false);
                }
            });


        });

        function checkFunction() {
           // var casInHand = parseInt(document.getElementById('cashInHand').value.replace(',','') - 500);
            var investmentAmount = document.getElementById('investmentAmount').value;
            // if(investmentAmount > casInHand){
            //     alert("Check Cash In Hand");
            //     $('#investmentAmount').val('0');
            //     document.getElementById('installmentCount').setAttribute('readonly', 'true');
            //     document.getElementById('investmentRate').setAttribute('readonly', 'true');
            //     $('.savebtn').attr('disabled','disabled');
            // }

            var installmentCount = document.getElementById('installmentCount').value || 1;
            if(installmentCount > 120){
                document.getElementById('installmentCount').setAttribute('readonly', 'true');
                document.getElementById('installmentCount').value = parseInt(120);
                installmentCount = 120;
            }

            var downpayment = document.getElementsByClassName('downPaymentAmount');
            if(downpayment.length > 0){
                downpayment = downpayment[0].value;
                investmentAmount = Math.round(document.getElementById('investmentAmount').value) - Math.round(downpayment);
            }

            // investmentRate investmentReturnAmount
            var investmentRate = document.getElementById('investmentRate').value.replace('%','');

            if(investmentRate != ' ' || investmentRate != undefined) {

                var interestRate = investmentRate || 0;
                var interest = (parseFloat(investmentAmount) * parseFloat(interestRate)) / 100;
                var investmentReturnAmount = parseFloat(investmentAmount) + parseFloat(interest)
                document.getElementById('investmentReturnAmount').value = '৳' + investmentReturnAmount;
                var installmentAmount = investmentReturnAmount / installmentCount;
                installmentAmount = installmentAmount.toFixed(2);
                var savingPerInstallment = document.getElementsByClassName('savingPerInstallment');
                if(savingPerInstallment.length > 0){
                    savingPerInstallment = document.getElementsByClassName('savingPerInstallment')[0].value;
                    installmentAmount = Math.round(installmentAmount) + Math.round(savingPerInstallment);
                }
                document.getElementById('installmentAmount').value = '৳' + Math.round(installmentAmount);
            }
        }
    </script>
@endsection
