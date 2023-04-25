@extends('layouts.bkash')

@section('content')
<div class=" md:h-[70vh] md:flex flex-col items-center justify-center ">
    <br>
    <div style="display: flex; justify-content: center; align-items: center;">
        <img src="/images/myradar-logo-blue.png" class="img-fluid mb-3" alt="myradar-logo-blue"
            style="max-width: 50px;">
    </div>


    <div class="flex justify-center items-stretch w-full">
        <div class="flex flex-col justify-center items-center gap-2">
            <h4>myRADAR Bill Pay</h4>
            <form action="/bkash/pay" method="POST" id="bkashForm">
                {!! csrf_field() !!}
                <input type="hidden" id="user" name="user" value='{{ $user }}'>

                <div class='flex flex-col items-center justify-center gap-2'>

                @if($total_due_bill > 0)
               
                    <div class="card-body">
                        <div class="card-text"><span class="text-sm font-normal">Dear Mr. {{ $user->name }} Sir, Your
                                total due bill
                                {{ number_format($total_due_bill) }} TK.</span> </div>
                    </div>

                    @else
                    <div class="card-body">
                        <div class="card-text"> <span class="text-sm font-medium">Dear {{ $user->name }} Sir, thank you
                                !! You don't have any due bill.</div>
                        </span>
                    </div>
                    @endif

                    @if($total_due_bill > 0)
                    <div class=" mb-3">
                        <div class=" border border-slate-200 rounded shadow p-2">
                            <div class="grid grid-cols-12 items-center pl-2">
                                <div class="col-span-5 md:col-span-4"><span class="font-semibold text-base"> Car
                                        No</span></div>
                                <div class="col-span-3 md:col-span-4"><span
                                        class="font-semibold text-base">Amount</span> </div>
                                <div class=" col-span-4 pl-2 "><span class="font-semibold text-base">Due Month</span>
                                </div>
                            </div>

                            <?php $i=0;$monthName = '';?>

                            @foreach ($cars_bill_details as $car_bill_details)


                            @if(count($car_bill_details['mon']) < 1) <?php     
                               $formatted_date = $monthName;                    
                            ?> @elseif(count($car_bill_details['mon'])==1) <?php 
                        $date_str = $car_bill_details['mon'][0][0].'-' .$car_bill_details['mon'][0][1];
                        $timestamp = strtotime('1-'.$date_str); 
                        $formatted_date = date("M'y", $timestamp); 
                            ?> @else <?php 

                        $length = count($car_bill_details['mon'])-1;
                        $date_str1 = $car_bill_details['mon'][0][0].'-' .$car_bill_details['mon'][0][1];
                        $timestamp1 = strtotime('1-'.$date_str1); 
                        $formatted_date1 = date("M'y", $timestamp1); 

                        $date_str2 = $car_bill_details['mon'][$length][0].'-' .$car_bill_details['mon'][$length][1];
                        $timestamp2 = strtotime('1-'.$date_str2); 
                        $formatted_date2 = date("M'y", $timestamp2);

                        $formatted_date = $formatted_date1. ' to '.$formatted_date2;
                            ?> @endif <div class="grid grid-cols-12 items-center">
                                <div class="form-check col-span-12 gap-2 p-2">
                                    <input type="hidden" id="cars" name="cars[]"
                                        value="{{ $car_bill_details['reg_no'] }}">
                                    <div class="grid grid-cols-12 gap-2 items-center">
                                        <div class="col-span-5 md:col-span-4 grid-cols-12">
                                            <input class="col-span-1 form-check-input" type="checkbox"
                                                name="car_index[]" value="{{ $i }}" checked>
                                            <label
                                                class="col-span-11  form-check-label">{{ $car_bill_details['reg_no'] }}</label>
                                        </div>
                                        <input type="number" name="{{ $i }}" value="{{ $car_bill_details['bill'] }}"
                                            class="form-control col-span-3 md:col-span-4  border rounded border-slate-400 px-2 py-1 shadow-md">
                                        <label class="form-check-label col-span-4 pl-2"><span
                                                class="font-normal text-xs">{{ $formatted_date }}</span> </label>
                                    </div>
                                </div>
                        </div>
                        <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
        </div>
        <div class="text-center">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white rounded shadow-md">Pay
                Now</button>
        </div>
        @endif
        </form>
        <br>

        @if($errors->any())
        <div class="text-base font-normal text-red-500">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
</div>
@endsection