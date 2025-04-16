@extends('layouts.main')
@section('title', 'Detail Job')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modal-message')
    @endif
    <div class="flex flex-col h-screen overflow-hidden">
        <div class="flex-none">
            @include('templates.navbar')
        </div>

        <div class="flex-grow p-[56px] overflow-hidden">
            <div class="flex w-full h-full border-2 rounded-[16px] shadow-2xl">
                <div class="flex flex-col w-1/3 border-r-2 p-[12px] overflow-auto">
                    <div id="task-list">
                        <form action="">
                            <div class="flex justify-between w-full h-fit p-[8px] border-b-2">
                                <div class="flex">
                                    @if (auth()->user()->role == 'tasker' || (auth()->user()->role == 'worker' && $job->tasks))
                                        <button type="button" class="btn-new-task py-[4px] px-[32px] border-2 rounded-[8px]">New
                                            Task</button>
                                    @endif
                                </div>
                                @can('worker')
                                    <div class="flex gap-2">
                                        <button type="button" class="py-[4px] px-[32px] border-2 rounded-[8px]">Submit
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
                                            <input type="file" name="file" accept=".jpg, .png, .svg, .mp4, .zip, .pdf"
                                                id="file-upload" class="hidden">
                                            <label for="file-upload">
                                                <img src="{{ asset('icons/upload_file.svg') }}" width="30px" height="30px">
                                            </label>
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
                            <div class="flex gap-[16px]">
                                <button type="button" class="btn-edit-job">
                                    <img src="{{ asset('icons/edit.svg') }}" alt="" width="30px" height="30px">
                                </button>
                                <form action="{{ route('jobs.delete', ['id' => $job->id]) }}" method="POST"
                                    class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button id="btn-delete-job" type="submit" onclick="return confirm('Are you sure?')">
                                        <img src="{{ asset('icons/delete_red.svg') }}" alt="" width="30px" height="30px">
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form id="form-edit-job" class="hidden gap-[16px]"
                            action="{{ route('jobs.store', ['id' => $job->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="flex flex-col flex-grow gap-[16px]">
                                <input type="text" name="title" placeholder="Title"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center font-extrabold text-[32px]"
                                    required>
                                <input type="text" name="description" placeholder="Description"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px]" required>
                                <div class="flex gap-[8px] items-center">
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg"
                                        class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px] flex-grow">
                                    <div class="flex items-center gap-[8px] w-fit">
                                        <input type="checkbox" name="image_null" value="true">
                                        <p>Set Null</p>
                                    </div>
                                </div>
                                <div class="flex gap-[8px] items-center">
                                    <input type="file" name="video" accept=".mp4"
                                        class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px] flex-grow">
                                    <div class="flex items-center gap-[8px] w-fit">
                                        <input type="checkbox" name="video_null" value="true">
                                        <p>Set Null</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col w-fit gap-[16px]">
                                <button type="submit" class="w-[50px] h-[50px] rounded-full">
                                    <img src="{{ asset('icons/check.svg') }}" alt="">
                                </button>
                                <button type="button" class="btn-edit-job w-[50px] h-[50px] rounded-full">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let btnEditJobs = document.querySelectorAll('.btn-edit-job');
            let formEditJob = document.getElementById('form-edit-job');
            let detailContainer = document.getElementById('detail-container');
            let btnDeleteJob = document.getElementById('btn-delete-job');
            // console.log(btnEditJobs);

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
