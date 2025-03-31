@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    @include('templates.navbar')
    @if (isset($jobs))
        <div class="grid grid-cols-1 m-[24px] md:grid-cols-3 md:mx-[80px] md:my-[60px] gap-[20px]">
            @foreach ($jobs as $job)
                <a href="" class="border-2 rounded-[16px] p-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">
                    <div class="flex flex-col gap-[24px] max-h-[300px] overflow-auto p-[24px]">
                        <h1 class="text-center font-extrabold text-[24px]">{{ $job->title }}</h1>
                        <p class="text-[16px] text-justify">{{ $job->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
