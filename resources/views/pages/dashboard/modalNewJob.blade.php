<div id="modal-new-job" class="absolute inset-0 justify-center items-center hidden bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px]">
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data"
        class="mb-[10vh] w-[80vh] h-fit border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px] z-1">
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
            <textarea class="text-[16px] rounded-[8px] border-2 p-[8px]" name="description" id="description"></textarea>
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
        <button type="submit"
            class="text-[24px] border-2 w-full py-[4px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee] hover:cursor-pointer">Submit</button>
    </form>
</div>

<script>
    let btnNewJob = document.querySelectorAll('.btn-new-job');
    let modalNewJob = document.getElementById('modal-new-job');

    btnNewJob.forEach((btn) => {
        btn.addEventListener('click', () => {
            modalNewJob.classList.toggle('hidden');
            modalNewJob.classList.toggle('flex');
        });
    });
</script>
