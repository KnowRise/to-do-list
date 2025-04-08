@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    @include('templates.navbar')
    @if (Session::has('message') || $errors->any())
        @include('templates.modal-message')
    @endif
    <div id="modal-new-job" class="absolute inset-0 justify-center items-center hidden">
        <form action="{{ route('jobs.store') }}" method="POST"
            class="mb-[10vh] w-[80vh] h-[60vh] border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[56px]">
            @csrf
            <div class="w-full flex justify-end">
                <button class="btn-new-job text-[32px]">X</button>
            </div>
            <h1 class="text-[32px]">New Job</h1>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="title">Title:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="title" id="title">
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="description">Description:</label>
                <textarea class="text-[16px] rounded-[8px] border-2 p-[8px]" name="description" id="description"></textarea>
            </div>
            <button type="submit" class="text-[24px] border-2 w-full py-[4px] rounded-[8px]">Submit</button>
        </form>
    </div>

    <div class="flex p-[24px]">
        <div class="flex flex-col gap-[20px]">
            @can('admin')
                <div class="btn-new-user rounded-full w-[50px] h-[50px] border-2">
                </div>
            @endcan
            <button type="button" class="btn-new-job rounded-full w-[50px] h-[50px] border-2">
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 md:mx-[80px] md:my-[60px] gap-[20px] w-full">
            @if (isset($jobs))
                @foreach ($jobs as $job)
                    <a href="{{ route('jobs.detail', ['id' => $job->id]) }}"
                        class="border-2 rounded-[16px] p-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">
                        <div class="flex flex-col gap-[24px] max-h-[300px] overflow-auto p-[24px]">
                            <h1 class="text-center font-extrabold text-[24px]">{{ $job->title }}</h1>
                            <p class="text-[16px] text-justify">{{ $job->description }}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        let btnNewJob = document.getElementById('btn-new-job');
        let modalNewJob = document.getElementById('modal-new-job');

        document.querySelectorAll('.btn-new-job').forEach((btn) => {
            btn.addEventListener('click', () => {
                modalNewJob.classList.toggle('hidden');
                modalNewJob.classList.toggle('flex');
            });
        });
    </script>
@endsection
