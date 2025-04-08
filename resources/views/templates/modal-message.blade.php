<div id="modal-message" class="absolute inset-0 flex items-center justify-center">
    <div
        class="flex p-[24px] flex-col justify-center items-center w-[50vh] h-[40vh] border-2 bg-[#eeeeee] rounded-[16px]">
        <div class="flex flex-col flex-grow text-center gap-[24px]">
            <h1 class="font-extrabold text-[32px]">{{ Session::has('message') ? 'Message' : 'Error' }}</h1>
            <p>{{ Session('message') }}{{ $errors->first() }}</p>
        </div>
        <button type="button" id="btn-close-modal-message"
            class="w-full p-[6px] border-2 text-[16px] rounded-[8px] {{ Session::has('message') ? 'hover:bg-[#211C84]' : 'hover:bg-[#C80036]'}} hover:text-[#eeeeee]">Ok</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let modalMessage = document.getElementById('modal-message');
        let btnCloseModalMessage = document.getElementById('btn-close-modal-message');

        btnCloseModalMessage.addEventListener('click', function () {
            modalMessage.classList.remove('flex');
            modalMessage.classList.add('hidden');
        });
    });
</script>
