@extends('layouts.bkash')

@push('css')
<style type="text/css">
.loader,
.loader:after {
    border-radius: 50%;
    width: 10em;
    height: 10em;
}

.loader {
    margin: 60px auto;
    font-size: 10px;
    position: relative;
    text-indent: -9999em;
    border-top: 1.1em solid rgba(0, 168, 255, 0.2);
    border-right: 1.1em solid rgba(0, 168, 255, 0.2);
    border-bottom: 1.1em solid rgba(0, 168, 255, 0.2);
    border-left: 1.1em solid #00a8ff;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation: load8 1.1s infinite linear;
    animation: load8 1.1s infinite linear;
}

@-webkit-keyframes load8 {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes load8 {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
</style>
@endpush

@section('content')
<div class="min-h-[50vh] md:min-h-screen flex flex-col justify-center items-center">
    <form action="/bkash/create" method="POST" class="w-full max-w-md px-6">
        {!! csrf_field() !!}
        <input type="hidden" id="amount" name="amount" value='{{ $amount }}'>
        <input type="hidden" id="user" name="user" value='{{ $user }}'>
        <input type="hidden" id="car_wise_bill" name="car_wise_bill" value='{{ $car_wise_bill }}'>
        <button id="bKash_button" class="hidden cursor-pointer"></button>
    </form>

    <div class="flex flex-col items-center w-10/12 md:w-1/2 lg:w-1/3 mt-6">
        <div class="gap-2 w-full py-3 border-b border-gray-300 grid grid-cols-12">
            <div class='flex items-center col-span-6 md:col-span-8'> <span class="text-xl text-gray-700 font-medium">Selected Car :</span>
            </div>
            <div class='flex flex-col items-start justify-center col-span-6 md:col-span-4'>
                @foreach ($selected_cars as $car)
                <span class="text-xl text-gray-700 font-medium ">{{ $car }}</span>
                @endforeach
            </div>
        </div>
        <div class="gap-2 w-full py-3 grid grid-cols-12">
            <span class="text-xl text-gray-700 font-medium col-span-6 md:col-span-8">Total Amount : </span>
            <span class="text-xl text-gray-700 font-medium float-right col-span-6 md:col-span-4">{{ number_format($amount) }}
                TK</span>
        </div>
        <img src="/images/bkash.jpg" alt="" class="cursor-pointer w-2/3 mt-6" id="bkash_logo">
    </div>

    {{-- <div class="loader">Loading...</div> --}}
</div>


<script type="text/javascript">
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#bkash_logo').click(function() {
        $('#bKash_button').trigger('click')
    });
})
</script>
@endsection