@extends('layouts.main')
@section('title', 'Detail Task')

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
                        <div class="flex justify-between w-full h-fit p-[8px] border-b-2">
                            <div class="flex">
                                <button type="button" class="btn-new-user py-[4px] px-[32px] border-2 rounded-[8px]">New User</button>
                            </div>
                        </div>

                        {{-- Dummy Tasks --}}
                        @foreach ($task->userTasks as $userTask)
                            {{-- @dd($userTask) --}}
                            <div class="flex w-full h-fit border-b-2">
                                <div class="flex flex-grow justify-between overflow-hidden gap-[8px] items-center text-[20px]">
                                    <div class="flex w-full overflow-hidden p-[8px]">
                                        <p class="truncate">{{ $userTask->user->username }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center w-fit border-l-2 p-[8px] gap-[8px]">
                                    <button type="button" class="btn-detail-user-task" data-username="{{ $userTask->user->username }}" data-status="{{ $userTask->status }}" data-file="{{ $userTask->file_url }}" data-comment="{{ $userTask->comment  }}">
                                        <img src="{{ asset('icons/info.svg') }}" alt="Detail" width="30px" height="30px"
                                            onclick="showDetailUserTask({{ $userTask->id }})">
                                    </button>
                                    <form action="{{ route('tasks.users.delete', ['id' => $userTask->id]) }}" method="post"
                                        class="flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <img src="{{ asset('icons/delete_red.svg') }}" width="30px" height="30px" alt=""
                                                onclick="return confirm('Are you sure?')">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex w-2/3 p-[4px]">
                    <div class="flex flex-col w-full p-[32px] overflow-auto gap-[16px]">
                        <div class="flex justify-between">
                            <a id="btn-back" href="{{ route('jobs.detail', ['id' => $task->job_id]) }}">
                                <img src="{{ asset('icons/arrow_back.svg') }}" alt="" width="30px" height="30px">
                            </a>
                            <div class="flex gap-[16px]">
                                <button type="button" id="btn-edit-task">
                                    <img src="{{ asset('icons/edit.svg') }}" alt="" width="30px" height="30px">
                                </button>
                                <form action="{{ route('tasks.delete', ['id' => $task->id]) }}" method="POST"
                                    class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button id="btn-delete-task" type="submit" onclick="return confirm('Are you sure?')">
                                        <img src="{{ asset('icons/delete_red.svg') }}" alt="" width="30px" height="30px">
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form id="form-edit-task" class="hidden gap-[16px]"
                            action="{{ route('tasks.store', ['id' => $task->id]) }}" method="POST">
                            @csrf
                            <div class="flex flex-col flex-grow gap-[16px]">
                                <input type="text" name="title" placeholder="Title"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center font-extrabold text-[32px]"
                                    required>
                                <input type="text" name="description" placeholder="Description"
                                    class="py-[4px] px-[8px] border-2 rounded-[8px] text-center text-[16px]" required>
                                <input type="text" name="job_id" value="{{ $task->job_id }}" class="hidden">
                            </div>
                            <div class="flex flex-col w-fit gap-[16px]">
                                <button type="submit" class="w-[50px] h-[50px] rounded-full">
                                    <img src="{{ asset('icons/check.svg') }}" alt="">
                                </button>
                                <button id="btn-cancel-edit-task" type="button" class="w-[50px] h-[50px] rounded-full">
                                    <img src="{{ asset('icons/cancel.svg') }}" alt="">
                                </button>
                            </div>
                        </form>

                        <div id="detail-container" class="flex flex-col gap-[16px]">
                            <div class="flex flex-col gap-[16px]"></div>
                            <div class="flex flex-col w-full gap-[16px]">
                                <h1 class="text-center text-[32px] font-extrabold">{{ $task->title }}</h1>
                                <div class="flex flex-col text-[16px]">
                                    <p>{{ $task->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.detail.tasks.modalNewUser')
    @include('pages.detail.tasks.modalChooseAnotherTask')
    @include('pages.detail.tasks.modalDetailUserTask')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let btnEditTask = document.getElementById('btn-edit-task');
            let formEditTask = document.getElementById('form-edit-task');
            let detailContainer = document.getElementById('detail-container');
            let btnCancelEditTask = document.getElementById('btn-cancel-edit-task');
            let btnDeleteTask = document.getElementById('btn-delete-task');


            btnEditTask.addEventListener('click', function () {
                formEditTask.classList.remove('hidden');
                formEditTask.classList.add('flex');

                detailContainer.classList.remove('flex');
                detailContainer.classList.add('hidden');

                btnEditTask.classList.add('hidden');
                btnDeleteTask.classList.add('hidden');
            });

            btnCancelEditTask.addEventListener('click', function () {
                formEditTask.classList.remove('flex');
                formEditTask.classList.add('hidden');

                detailContainer.classList.remove('hidden');
                detailContainer.classList.add('flex');

                btnEditTask.classList.remove('hidden');
                btnDeleteTask.classList.remove('hidden');
            });
        });
    </script>
@endsection
