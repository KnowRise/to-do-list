@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col bg-[#EEEEEE] min-h-screen w-screen text-[#eeeeee] dark:bg-[#1d1d1d] dark:text-[#1d1d1d] md:flex-row">
        @if ($errors->any())
            <div id="error-modal" class="absolute flex mt-[75%] md:mt-40 justify-center w-full">
                <div class="bg-[#C80036] rounded-lg p-2 flex flex-row gap-4">
                    <p class="text-[24px] font-extrabold dark:text-[#EEEEEE]">{{ $errors->first() }}</p>
                    <button type="button" id="btn-close" class="font-extrabold text-[24px] dark:text-[#EEEEEE]">X</button>
                </div>
            </div>
        @endif
        <div class="hidden md:flex w-full h-min-[40%] flex-col text-center items-center justify-center bg-[#4D55CC] md:w-1/3 p-[56px] md:p-[24px] gap-[24px] dark:bg-[#6EACDA] ">
            <h1 class="font-bold text-[32px]">Selamat Datang di Taskflow</h1>
            <p class="text-[20px]">Aplikasi manajemen tugas yang dirancang untuk membantu tim bekerja lebih efektif. Buat
                job, bagi tugas ke anggota tim, dan pantau progres mereka dengan mudah. Kolaborasi jadi lebih terstruktur
                dan efisien!</p>
        </div>
        <div class="flex w-full items-center justify-center md:w-2/3 p-[64px] md:p-0 min-h-screen md:min-h-0">
            <div class="w-full md:w-1/2 text-[#1d1d1d] flex flex-col gap-4 dark:text-[#EEEEEE]">
                <h1 class="text-center text-[32px] font-extrabold">Login</h1>
                <form class="flex flex-col text-[20px]" action="{{ route('backend.login') }}" method="POST">
                    @csrf
                    <label for="login">Username/Email:</label>
                    <input class="mb-4 border-2 p-2 dark:border-0 dark:bg-[#EEEEEE] dark:text-[#1d1d1d]" type="text" name="login" placeholder="Enter Username or Email"
                        required value="{{ old('login') }}">
                    <label for="password">Password:</label>
                    <input class="mb-4 border-2 p-2 dark:border-0 dark:bg-[#EEEEEE] dark:text-[#1d1d1d]" type="password" name="password" placeholder="Enter Password" required>
                    <button type="submit" class="bg-[#4D55CC] hover:bg-[#211C84] dark:hover:bg-[#03346E] hover:text-[#EEEEEE] p-2 font-extrabold text-[#EEEEEE] dark:bg-[#6EACDA] dark:text-[#1d1d1d]">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const errorModal = document.getElementById('error-modal');
        const closeButton = document.getElementById('btn-close');

        if (errorModal) {
            errorModal.classList.remove('hidden');

            closeButton.addEventListener('click', () => {
                errorModal.classList.add('hidden');
            });
        }
    </script>
@endsection
