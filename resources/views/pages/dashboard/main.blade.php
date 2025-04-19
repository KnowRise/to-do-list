@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col h-screen overflow-hidden">
        @include('templates.navbar.main')
        @if (Session::has('message') || $errors->any())
            @include('templates.modalMessage')
        @endif

        <div class="flex p-[24px] gap-[32px] flex-grow overflow-auto">
            <div class="flex flex-col">
                @can('admin')
                    <button type="button" class="btn-new-user rounded-full w-[50px] h-[50px] cursor-pointer">
                        <img src="{{ asset('icons/add.svg') }}" alt="">
                    </button>
                @endcan
                @can('worker-tasker')
                    <button type="button" class="btn-new-job rounded-full w-[50px] h-[50px] cursor-pointer">
                        <img src="{{ asset('icons/add.svg') }}" alt="">
                    </button>
                @endcan
            </div>
            @if (isset($jobs))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-[32px] w-full h-fit">
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
                <div class="flex flex-col justify-center w-full gap-[16px]">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="flex gap-[16px]">
                            <input type="text" name="search"
                                class="rounded-[8px] border text-[20px] py-[8px] px-[16px] flex-grow"
                                placeholder="Search User..." value="{{ request('search') }}">
                            <button type="submit" class="border py-[8px] px-[16px] text-[20px] rounded-[8px]">Search</button>
                        </div>
                    </form>
                    <table class="w-full border-2 border-gray-300 shadow-2xl rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-center p-2 text-lg border border-gray-300">Name</th>
                                <th class="text-center p-2 text-lg border border-gray-300">Username</th>
                                <th class="text-center p-2 text-lg border border-gray-300">Role</th>
                                <th class="text-center p-2 text-lg border border-gray-300">Phone Number</th>
                                <th class="text-center p-2 text-lg border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="text-center p-2 border border-gray-300">{{ $user->name }}</td>
                                    <td class="text-center p-2 border border-gray-300">{{ $user->username }}</td>
                                    <td class="text-center p-2 border border-gray-300">{{ $user->role }}</td>
                                    <td class="text-center p-2 border border-gray-300">{{ $user->phone_number }}</td>
                                    <td class="p-2 border border-gray-300">
                                        <div class="flex justify-center gap-2">
                                            <button
                                                class="btn-edit-user rounded-md border py-1 px-3 hover:bg-[#211C84] hover:text-white transition"
                                                data-user-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}" data-phone-number="{{ $user->phone_number }}">
                                                Edit
                                            </button>
                                            <form id="form-delete-user-{{ $user->id }}" action="{{ route('users.delete', ['id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-modal-confirm rounded-md border py-1 px-3 hover:bg-[#C80036] hover:text-white transition" data-user-id="{{ $user->id }}" data-title="Delete User" data-message="This action will delete the user {{ $user->name }}." data-action="deleteUser">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($users->hasPages())
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>

                    @endif
                </div>
            @endif
        </div>
    </div>
    @include('pages.dashboard.modalNewUser')
    @include('pages.dashboard.modalEditUser')
    @include('pages.dashboard.modalNewJob')
    @include('templates.modalConfirm')
@endsection
