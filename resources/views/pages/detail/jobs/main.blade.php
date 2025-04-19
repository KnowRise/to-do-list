@extends('layouts.main')
@section('title', 'Detail Job')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif
    <div class="flex flex-col h-screen overflow-hidden">
        <div class="flex-none">
            @include('templates.navbar.main')
        </div>

        <div class="flex-grow p-[56px] overflow-hidden">
            <div class="flex w-full h-full border-2 rounded-[16px] shadow-2xl">
                <div class="flex flex-col w-1/3 border-r-2 p-[12px] overflow-auto">
                    <div id="task-list">
                        <form action="{{ route('tasks.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-between w-full h-fit p-[8px] border-b-2">
                                <div class="flex">
                                    @if (auth()->user()->role == 'tasker' || (auth()->user()->role == 'worker' && $job->user_id == auth()->user()->id))
                                        <button type="button"
                                            class="btn-new-task py-[4px] px-[32px] border-2 rounded-[8px] cursor-pointer">New
                                            Task</button>
                                    @endif
                                </div>
                                @can('worker')
                                    <div class="flex gap-2">
                                        <button type="submit" class="py-[4px] px-[32px] border-2 rounded-[8px]">Submit
                                            Task</button>
                                    </div>
                                @endcan
                            </div>

                            {{-- Dummy Tasks --}}
                            @foreach ($tasks as $task)
                                <div class="flex w-full h-fit border-b-2">
                                    <div
                                        class="flex flex-grow justify-between overflow-hidden gap-[8px] items-center text-[20px]">
                                        <div class="flex w-full overflow-hidden p-[8px]">
                                            <p class="truncate">{{ $task->title }}</p>
                                        </div>
                                        <div class="flex w-fit p-[8px]">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center w-fit border-l-2 p-[8px] gap-[8px]">
                                        <input type="file" class="hidden">
                                        @can('tasker')
                                            <a href="{{ route('tasks.detail', ['id' => $task->id]) }}">
                                                <img src="{{ asset('icons/info.svg') }}" alt="" width="30px" height="30px">
                                            </a>
                                        @endcan
                                        @can('worker')
                                            <button type="button" class="btn-detail-task" data-task-id="{{ $task->id }}"
                                                data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                                data-comment="{{ $task->userTaskFor(auth()->user()->id)->comment }}"
                                                data-status="{{ $task->userTaskFor(auth()->user()->id)->status }}"
                                                data-completed-at="{{ $task->userTaskFor(auth()->user()->id)->completed_at }}"
                                                data-file-path="{{ $task->userTaskFor(auth()->user()->id)->file_url }}">
                                                <img src="{{ asset('icons/info.svg') }}" alt="" width="30px" height="30px">
                                            </button>
                                            @if ($task->userTaskFor(auth()->user()->id)->status == 'pending')
                                                <input type="file" name="files[{{ $task->id }}]"
                                                    accept=".jpg, .png, .svg, .mp4, .zip, .pdf" id="file-upload-{{ $task->id }}"
                                                    class="hidden">
                                                <label for="file-upload-{{ $task->id }}">
                                                    <img src="{{ asset('icons/upload_file.svg') }}" width="30px" height="30px">
                                                </label>
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
                <div class="flex w-2/3 p-[4px]">
                    <div class="flex flex-col w-full p-[32px] overflow-auto gap-[16px]">
                        <div class="flex justify-between">
                            <a id="btn-back" href="{{ route('dashboard') }}">
                                <img src="{{ asset('icons/arrow_back.svg') }}" alt="" width="30px" height="30px">
                            </a>
                            @if (auth()->user()->role == 'tasker' || (auth()->user()->role == 'worker' && $job->user_id == auth()->user()->id))
                                <div class="flex gap-[16px]">
                                    <button type="button" class="btn-edit-job cursor-pointer">
                                        <img src="{{ asset('icons/edit.svg') }}" alt="" width="30px" height="30px">
                                    </button>
                                    <form id="form-delete-job" action="{{ route('jobs.delete', ['id' => $job->id]) }}"
                                        method="POST" class="flex items-center cursor-pointer">
                                        @csrf
                                        @method('DELETE')
                                        <button id="btn-delete-job" type="button" class="btn-modal-confirm cursor-pointer"
                                            data-title="Delete Job" data-message="This action will delete the job"
                                            data-action="deleteJob">
                                            <img src="{{ asset('icons/delete_red.svg') }}" alt="" width="30px" height="30px">
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <form id="form-edit-job" class="hidden gap-[16px]"
                            action="{{ route('jobs.store', ['id' => $job->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col flex-grow gap-[16px]">
                                <input type="text" name="title" placeholder="Title"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center font-extrabold text-[32px]"
                                    required value="{{ $job->title }}">
                                <textarea rows="5" name="description"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px]"
                                    placeholder="Description" required>{{ $job->description }}</textarea>
                                <div class="flex gap-[8px] items-center">
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg"
                                        class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px] flex-grow">
                                    <div class="flex items-center gap-[8px] w-fit">
                                        <input type="checkbox" id="image-null" name="image_null" value="true">
                                        <label for="image-null">Set Null</label>
                                    </div>
                                </div>
                                <div class="flex gap-[8px] items-center">
                                    <input type="file" name="video" accept=".mp4"
                                        class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px] flex-grow">
                                    <div class="flex items-center gap-[8px] w-fit">
                                        <input type="checkbox" id="video-null" name="video_null" value="true">
                                        <label for="video-null">Set Null</label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col w-fit gap-[16px]">
                                <button type="submit" class="w-[50px] h-[50px] rounded-full cursor-pointer">
                                    <img src="{{ asset('icons/check.svg') }}" alt="">
                                </button>
                                <button type="button" class="btn-edit-job w-[50px] h-[50px] rounded-full cursor-pointer">
                                    <img src="{{ asset('icons/cancel.svg') }}" alt="">
                                </button>
                            </div>
                        </form>
                        <div id="detail-container" class="flex flex-col gap-[16px]">
                            <div class="flex flex-col gap-[16px]"></div>
                            <div class="flex flex-col w-full gap-[16px]">
                                <h1 class="text-center text-[32px] font-extrabold">{{ $job->title }}</h1>
                                <div class="flex flex-col text-[16px]">
                                    <a href="#">Tasker : {{ $job->user->username }}</a>
                                    <p>{{ $job->description }}</p>
                                </div>
                            </div>
                            @if ($job->image || $job->video)
                                <div
                                    class="flex w-full justify-between items-center p-[16px] rounded-[16px] border-2 gap-[16px]">
                                    @if ($job->image)
                                        <a href="{{ asset($job->image) }}" target="_blank"
                                            class="w-full rounded-[16px] overflow-hidden justify-center flex">
                                            <img src="{{ asset($job->image) }}" alt="Job Image">
                                        </a>
                                    @endif
                                    @if ($job->video)
                                        <video controls class="w-full rounded-[16px] overflow-hidden justify-center flex">
                                            <source src="{{ asset($job->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.detail.jobs.modalNewTask')
    @include('pages.detail.jobs.modalDetailTask')
    @include('templates.modalConfirm')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let btnEditJobs = document.querySelectorAll('.btn-edit-job');
            let formEditJob = document.getElementById('form-edit-job');
            let detailContainer = document.getElementById('detail-container');
            let btnDeleteJob = document.getElementById('btn-delete-job');

            btnEditJobs.forEach(btn => {
                btn.addEventListener('click', () => {
                    formEditJob.classList.toggle('hidden');
                    formEditJob.classList.toggle('flex');
                    detailContainer.classList.toggle('hidden');
                    detailContainer.classList.toggle('flex');

                    btnEditJobs[0].classList.toggle('hidden');
                    btnDeleteJob.classList.toggle('hidden');
                });
            });
        });
    </script>
@endsection
