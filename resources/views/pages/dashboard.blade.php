@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    @include('templates.navbar')
    @if (Session::has('message') || $errors->any())
        @include('templates.modal-message')
    @endif
    <div id="modal-new-job" class="absolute inset-0 justify-center items-center hidden">
        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data"
            class="mb-[10vh] w-[80vh] h-fit border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px]">
            @csrf
            <div class="w-full flex justify-end">
                <button type="button" class="btn-new-job text-[32px]">X</button>
            </div>
            <h1 class="text-[32px]">New Job</h1>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="title">Title:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="title" id="title" required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="description">Description:</label>
                <textarea class="text-[16px] rounded-[8px] border-2 p-[8px]" name="description" id="description"
                    required></textarea>
            </div>
            <div class="w-full flex gap-[16px]">
                <label class="text-[24px]" for="image">Image:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px] flex-grow" type="file"
                    accept=".jpg,.png,.svg,.jpeg" name="image">
            </div>
            <div class="w-full flex gap-[16px]">
                <label class="text-[24px]" for="video">Video:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px] flex-grow" type="file" accept=".mp4" name="video">
            </div>
            <button type="submit" class="text-[24px] border-2 w-full py-[4px] rounded-[8px]">Submit</button>
        </form>
    </div>
    <div id="modal-new-user"
        class="absolute inset-0 justify-center items-center bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden">
        <form action="{{ route('users.store') }}" method="POST"
            class="w-[80vh] max-h-[80vh] border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px]">
            @csrf
            <div class="w-full flex justify-end">
                <button type="button" class="btn-new-user text-[32px]">X</button>
            </div>
            <h1 class="text-[32px]">New User</h1>
            <div class="flex flex-col h-full overflow-auto w-full gap-[8px] px-[8px]">
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="name">Name:</label>
                    <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="name" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="username">Username:</label>
                    <input type="text" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="username" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="email">Email:</label>
                    <input type="email" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="email" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="phone_number">Phone Number:</label>
                    <input type="number" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="phone_number" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="password">Password:</label>
                    <input type="password" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="password" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="role">Role:</label>
                    <select name="role" class="text-[16px] rounded-[8px] border-2 p-[8px]">
                        <option value="admin">Admin</option>
                        <option value="worker">Worker</option>
                        <option value="tasker">Tasker</option>
                    </select>
                </div>
                <button type="submit" class="text-[24px] border-2 w-full py-[4px] rounded-[8px]">Submit</button>
            </div>
        </form>
    </div>
    <div id="modal-edit-user"
        class="absolute inset-0 justify-center items-center bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden">
        <form id="form-edit-user" action="" method="POST"
            class="w-[80vh] max-h-[80vh] border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px]">
            @csrf
            <div class="w-full flex justify-end">
                <button type="button" class="btn-edit-user text-[32px]">X</button>
            </div>
            <h1 class="text-[32px]">Edit User</h1>
            <div class="flex flex-col h-full overflow-auto w-full gap-[8px] px-[8px]">
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="name">Name:</label>
                    <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="name" id="edit-input-name" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="username">Username:</label>
                    <input type="text" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="username" id="edit-input-username" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="email">Email:</label>
                    <input type="email" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="email" id="edit-input-email" required>
                </div>
                <div class="w-full flex flex-col gap-[16px]">
                    <label class="text-[24px]" for="phone_number">Phone Number:</label>
                    <input type="number" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="phone_number" id="edit-input-phone-number" required>
                </div>
                <button type="submit" class="text-[24px] border-2 w-full py-[4px] rounded-[8px]">Submit</button>
            </div>
        </form>
    </div>


    <div class="flex p-[24px] gap-[16px]">
        <div class="flex flex-col gap-[20px]">
            @can('admin')
                <div class="btn-new-user rounded-full w-[50px] h-[50px]">
                    <img src="{{ asset('icons/add.svg') }}" alt="">
                </div>
            @endcan
            @can('worker-tasker')
                <button type="button" class="btn-new-job rounded-full w-[50px] h-[50px]">
                    <img src="{{ asset('icons/add.svg') }}" alt="">
                </button>
            @endcan
        </div>
        @if (isset($jobs))
            <div class="grid grid-cols-1 md:grid-cols-3 md:mx-[80px] md:my-[60px] gap-[20px] w-full">
                @foreach ($jobs as $job)
                    <a href="{{ route('jobs.detail', ['id' => $job->id]) }}"
                        class="border-2 rounded-[16px] p-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">
                        <div class="flex flex-col gap-[24px] max-h-[300px] overflow-auto p-[24px]">
                            <h1 class="text-center font-extrabold text-[24px]">{{ $job->title }}</h1>
                            <p class="text-[16px] text-justify">{{ $job->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        @if (isset($users))
            <table class="border-2 w-full shadow-2xl">
                <thead>
                    <tr class="border-2">
                        <td class="text-center p-[4px] text-[24px]">Name</td>
                        <td class="text-center p-[4px] text-[24px]">Email</td>
                        <td class="text-center p-[4px] text-[24px]">Username</td>
                        <td class="text-center p-[4px] text-[24px]">Role</td>
                        <td class="text-center p-[4px] text-[24px]">Phone Number</td>
                        <td class="text-center p-[4px] text-[24px]">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border truncate overflow-hidden">
                            <td class="p-[4px] text-center">{{ $user->name }}</td>
                            <td class="p-[4px] text-center">{{ $user->email }}</td>
                            <td class="p-[4px] text-center">{{ $user->username }}</td>
                            <td class="p-[4px] text-center">{{ $user->role }}</td>
                            <td class="p-[4px] text-center">{{ $user->phone_number }}</td>
                            <td class="flex justify-center gap-[8px] p-[4px]">
                                <button class="btn-edit-user rounded-[8px] border py-[4px] px-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]" data-user-id="{{ $user->id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-phone-number="{{ $user->phone_number }}">Edit</button>
                                <form action="{{ route('users.delete', ['id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="rounded-[8px] border py-[4px] px-[8px] hover:bg-[#C80036] hover:text-[#eeeeee]">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        let btnNewJob = document.querySelectorAll('.btn-new-job');
        let modalNewJob = document.getElementById('modal-new-job');
        let btnNewUser = document.querySelectorAll('.btn-new-user');
        let modalNewUser = document.getElementById('modal-new-user');
        let btnEditUser = document.querySelectorAll('.btn-edit-user');
        let modalEditUser = document.getElementById('modal-edit-user');
        let formEditUser = document.getElementById('form-edit-user');

        btnNewJob.forEach((btn) => {
            btn.addEventListener('click', () => {
                modalNewJob.classList.toggle('hidden');
                modalNewJob.classList.toggle('flex');
            });
        });

        btnNewUser.forEach((btn) => {
            btn.addEventListener('click', () => {
                modalNewUser.classList.toggle('hidden');
                modalNewUser.classList.toggle('flex')
            });
        })

        btnEditUser.forEach((btn) => {
            btn.addEventListener('click', () => {
                const userId = btn.dataset.userId

                modalEditUser.classList.toggle('hidden');
                modalEditUser.classList.toggle('flex');

                formEditUser.action = `/users/${userId}`;

                document.getElementById('edit-input-name').value = btn.dataset.name;
                document.getElementById('edit-input-username').value = btn.dataset.username;
                document.getElementById('edit-input-email').value = btn.dataset.email;
                document.getElementById('edit-input-phone-number').value = btn.dataset.phoneNumber;
            })
        });
    </script>
@endsection
