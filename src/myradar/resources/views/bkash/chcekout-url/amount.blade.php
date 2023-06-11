@extends('layouts.bkash')

@section('content')
    <div class=" md:h-[70vh] md:flex flex-col items-center justify-center ">
        <br>
        <div class="grid grid-cols-12 w-full ">
            <div class="col-span-4"></div>
            <div class="col-span-4">
                <div class="flex flex-col items-center">
                    <img src="/images/myradar-logo-blue.png" class="img-fluid mb-3 rounded" alt="myradar-logo-blue"
                        style="max-width: 50px;">
                </div>
            </div>
            <div class="col-span-4">
                <div class="toggle-switch flex items-center justify-center">
                    <input type="checkbox" id="languageToggle" class="hidden">
                    <label for="languageToggle" class="toggle-label flex">
                        <span class="toggle-text option-english bg-gray-200 rounded px-4 py-2  cursor-pointer hidden"
                            id="english">English</span>
                        <span class="toggle-text option-bengali bg-gray-200 rounded px-4 py-2  cursor-pointer"
                            id="bangla">বাংলা</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12  w-full">
            <div class="col-span-4"></div>
            <div class="col-span-4">
                <div class="flex flex-col items-center">
                   <h4>myRADAR</h4>
                </div>
            </div>
            <div class="col-span-4">
            </div>
        </div>

        <div class="flex justify-center items-stretch w-full px-2">
            <div class="flex flex-col justify-center items-center gap-2">
                {{-- <h4>myRADAR</h4> --}}
                <form action="/bkash/pay" method="POST" id="bkashForm">
                    {!! csrf_field() !!}
                    <input type="hidden" id="user" name="user" value='{{ $user }}'>
                    <input type="hidden" id="lang" name="lang" value="en">
                    <input type="hidden" id="uId" name="uId" value="{{ $uId }}">

                    <div class='flex flex-col items-center justify-center gap-2'>

                        @if ($total_due_bill > 0)
                            <div class="card-body">
                                <div class="card-text"><span class="text-sm font-normal" id="greetingMsg">Dear Mr.
                                        {{ $user->name }} Sir,
                                        Your total due bill {{ number_format($total_due_bill) }} tk.</span>
                                    <input type="hidden" id="totalBill" name="totalBill" value='{{ $total_due_bill }}'>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="card-text"> <span class="text-sm font-medium" id="greetingMsg">Dear
                                        {{ $user->name }} Sir,
                                        thank you
                                        !! You don't have any due bill.</div>
                                </span>
                            </div>
                        @endif

                        @if ($total_due_bill > 0)
                            <div class=" mb-3">
                                <div class=" border border-slate-200 rounded shadow p-2">
                                    <div class="grid grid-cols-12 items-center pl-2">
                                        <div class="col-span-5 md:col-span-4"><span class="font-semibold text-base"
                                                id="carNoLabel"> Car
                                                No</span></div>
                                        <div class="col-span-3 md:col-span-4"><span class="font-semibold text-base"
                                                id="billNoLabel">Due
                                                Bill</span> </div>
                                        <div class=" col-span-4 pl-2 "><span class="font-semibold text-base"
                                                id="monthNameLabel">Due
                                                Month</span>
                                        </div>
                                    </div>

                                    <?php $i = 0;
                                    $monthName = ''; ?>

                                    @foreach ($cars_bill_details as $car_bill_details)
                                        @if (count($car_bill_details['mon']) < 1)
                                            <?php
                                            $formatted_date = $monthName;
                                            ?>
                                        @elseif(count($car_bill_details['mon']) == 1)
                                            <?php
                                            $date_str = $car_bill_details['mon'][0][0] . '-' . $car_bill_details['mon'][0][1];
                                            $timestamp = strtotime('1-' . $date_str);
                                            $formatted_date = date("M'y", $timestamp);
                                            ?>
                                        @else
                                            <?php
                                            
                                            $length = count($car_bill_details['mon']) - 1;
                                            $date_str1 = $car_bill_details['mon'][0][0] . '-' . $car_bill_details['mon'][0][1];
                                            $timestamp1 = strtotime('1-' . $date_str1);
                                            $formatted_date1 = date("M'y", $timestamp1);
                                            
                                            $date_str2 = $car_bill_details['mon'][$length][0] . '-' . $car_bill_details['mon'][$length][1];
                                            $timestamp2 = strtotime('1-' . $date_str2);
                                            $formatted_date2 = date("M'y", $timestamp2);
                                            
                                            $formatted_date = $formatted_date1 . ' to ' . $formatted_date2;
                                            ?>
                                        @endif
                                        <div class="grid grid-cols-12 items-center">
                                            <div class="form-check col-span-12 gap-2 p-2">
                                                <input type="hidden" id="cars" name="cars[]"
                                                    value="{{ $car_bill_details['reg_no'] }}">
                                                <div class="grid grid-cols-12 gap-2 items-center">
                                                    <div class="col-span-5 md:col-span-4 grid-cols-12">
                        
                                                        <label
                                                            class="col-span-11  form-check-label">{{ $car_bill_details['reg_no'] }}</label>
                                                    </div>
                                            
                                                    <label class="form-control col-span-3 md:col-span-4 px-2 py-1"><span
                                                            class="font-normal text-xs">{{ number_format($car_bill_details['bill']) }}</span>
                                                    </label>
                                                    <label class="form-check-label col-span-4 pl-2"><span
                                                            class="font-normal text-xs">{{ $formatted_date }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach

                                    <div class="grid grid-cols-12 items-center">
                                        <div class="form-check col-span-12 gap-2 p-2">
                                            <input type="hidden" id="cars" name="cars[]"
                                                value="{{ $car_bill_details['reg_no'] }}">
                                            <div class="grid grid-cols-12 gap-2 items-center">
                                                <div class="col-span-5 md:col-span-4 grid-cols-12">
                                                    <label class="col-span-5 font-semibold text-base form-check-label"
                                                        id="payAmountText">Pay
                                                        Amount</label>
                                                </div>
                                                <input type="number" id="total_bill" name="total_bill"
                                                    value="{{ $total_due_bill }}"
                                                    class="form-control col-span-3 md:col-span-4 font-semibold border rounded border-slate-400 px-2 py-1 shadow-md"
                                                    onchange="billCheck(this.value)">
                                                <label class="form-check-label col-span-4 pl-2"><span
                                                        class="font-normal text-xs"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white rounded shadow-md"
                            id="payNowBtn">Pay
                            Now</button>
                    </div>
                    @endif
                </form>
                <br>

                <p id="errorMessageEn" style="color: red; display: none;">Amount must be minimum 1 taka.</p>
                <p id="errorMessageBn" style="color: red; display: none;">সর্বনিম্ন ১ টাকা দিন।</p>

                @if ($errors->any())
                    <div class="text-base font-normal text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li id="error">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <script>
            var selectedLang = 'bn';
            var languageToggle = document.getElementById('languageToggle');

            function languageChecker() {
                if (languageToggle.checked) {
                    selectedLang = 'bn';

                } else {
                    selectedLang = 'en';
                }

                return selectedLang;
            }

            document.addEventListener('DOMContentLoaded', function() {
                var englishOption = document.querySelector('.option-english');
                var bengaliOption = document.querySelector('.option-bengali');


                languageToggle.addEventListener('change', function() {
                    if (languageToggle.checked) {
                        bengaliOption.classList.add('hidden');
                        englishOption.classList.remove('hidden');
                        selectedLang = 'en';

                    } else {
                        englishOption.classList.add('hidden');
                        bengaliOption.classList.remove('hidden');
                        selectedLang = 'bn';
                    }
                });
            });

            var form = document.getElementById('bkashForm');
            form.addEventListener('submit', function(event) {
                let selectedLang = languageChecker();

                var lang = document.getElementById('lang');
                lang.value = selectedLang;
                console.log(lang.value);
            });

            function billCheck(inputValue) {
                let selectedLang = languageChecker();
                if (+inputValue < 1 && selectedLang === 'en') {
                    document.getElementById('errorMessageBn').style.display = 'none';
                    document.getElementById('errorMessageEn').style.display = 'block';
                } else if (+inputValue < 1 && selectedLang === 'bn') {
                    document.getElementById('errorMessageEn').style.display = 'none';
                    document.getElementById('errorMessageBn').style.display = 'block';
                } else {
                    document.getElementById('errorMessageEn').style.display = 'none';
                    document.getElementById('errorMessageBn').style.display = 'none';
                }
            }
            languageToggle.addEventListener('change', function() {
                function formatNumberWithComma(number) {
                    const numberString = number.toString();
                    const digits = numberString.split('.');
                    const integerPart = digits[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    let formattedNumber = integerPart;

                    if (digits.length === 2) {
                        formattedNumber += '.' + digits[1];
                    }

                    return formattedNumber;
                }

                function getDigitBanglaFromEnglish(number) {
                    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                    const numberString = number.toString();
                    let banglaNumber = '';

                    for (let i = 0; i < numberString.length; i++) {
                        const digit = parseInt(numberString[i]);

                        if (isNaN(digit)) {
                            banglaNumber += numberString[i];
                        } else {
                            banglaNumber += bengaliDigits[digit];
                        }
                    }

                    return banglaNumber;
                }

                if (languageToggle.checked) {
                    selectedLang = 'bn';

                } else {
                    selectedLang = 'en';
                }


                var selectedValue = selectedLang;
                var carNoLabel = document.getElementById('carNoLabel');
                var billNoLabel = document.getElementById('billNoLabel');
                var monthNameLabel = document.getElementById('monthNameLabel');
                var payNowBtn = document.getElementById('payNowBtn');
                var payAmountText = document.getElementById('payAmountText');
                var greetingMsg = document.getElementById('greetingMsg');
                var totalBill = document.getElementById('totalBill').value;
                var user = JSON.parse(document.getElementById('user').value);

                if (selectedValue === 'bn') {
                    carNoLabel.textContent = 'গাড়ি নম্বর';
                    billNoLabel.textContent = 'বকেয়া বিল';
                    monthNameLabel.textContent = 'বকেয়া মাস';
                    payNowBtn.textContent = 'বিল দিন';
                    payAmountText.textContent = 'পেমেন্টের পরিমাণ';
                    if (+totalBill > 0) {
                        greetingMsg.textContent =
                            `প্রিয় ${user.name} স্যার, আপনার বকেয়া বিল ${getDigitBanglaFromEnglish(formatNumberWithComma(totalBill))} টাকা।`
                    } else {
                        greetingMsg.textContent = `প্রিয় ${user.name} স্যার, ধন্যবাদ !! আপনার কোন বকেয়া বিল নেই।`
                    }
                } else {
                    carNoLabel.textContent = 'Car No';
                    billNoLabel.textContent = 'Due Bill';
                    monthNameLabel.textContent = 'Due Month';
                    payNowBtn.textContent = 'Pay Now';
                    payAmountText.textContent = 'Pay Amount';

                    if (+totalBill > 0) {
                        console.log(formatNumberWithComma(totalBill));
                        greetingMsg.textContent =
                            `Dear Mr. ${user.name} Sir, Your total due bill ${formatNumberWithComma(totalBill)} tk.`;
                    } else {
                        greetingMsg.textContent = `Dear ${user.name} Sir, thanks !! You don't have any due bill.`;
                    }
                }
            });
        </script>
    </div>
@endsection
