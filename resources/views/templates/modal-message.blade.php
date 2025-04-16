<div id="modal-message" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden">
        <div class="flex flex-col gap-[16px]">
            <div class="flex flex-col flex-grow text-center gap-[24px]">
                <h1 class="font-extrabold text-[40px]">{{ Session::has('message') ? 'Message' : 'Error' }}</h1>
            <p class="text-[20px]">{{ Session('message') }}{{ $errors->first() }}</p>
        </div>
        <button type="button" id="btn-close-modal-message" class="w-full p-[6px] border-2 text-[20px] rounded-[8px] {{ Session::has('message') ? 'hover:bg-[#211C84]' : 'hover:bg-[#C80036]'}} hover:text-[#eeeeee]">Ok</button>
    </div>
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
