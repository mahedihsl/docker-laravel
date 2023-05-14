@extends('layouts.base')

@section('body')

    <div class="tw-w-full tw-min-h-screen tw-bg-gray-100 tw-flex tw-flex-col tw-justify-center tw-items-center">
        <div class="tw-w-2/3 md:tw-w-1/2 lg:tw-w-1/3 tw-bg-white tw-shadow-lg tw-rounded-lg tw-p-12 tw-flex tw-flex-col">
            @yield('title')
            @yield('content')
        </div>
    </div>

@endsection