<div id="modal-new-task" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden">
        <div class="flex justify-end">
            <button type="button" class="btn-new-task text-[32px] font-extrabold px-[4px]">X</button>
        </div>
        <div class="flex flex-col gap-[24px] p-[16px]">
            <h1 class="text-center text-[32px] font-extrabold">New Task</h1>
            <form action="{{ route('tasks.store') }}" class="flex flex-col gap-[16px]" method="POST">
                @csrf
                <div class="flex flex-col">
                    <label for="" class="text-[24px]">Title:</label>
                    <input type="text" class="border-2 py-[4px] px-[8px] rounded-[8px]" name="title" required>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-[24px]">Description:</label>
                    <input type="text" class="border-2 py-[4px] px-[8px] rounded-[8px]" name="description">
                </div>
                <input type="text" name="job_id" value="{{ $job->id }}" class="hidden">
                <button type="submit"
                    class="border-2 text-[24px] py-[4px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee] hover:cursor-pointer">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    let btnNewTasks = document.querySelectorAll('.btn-new-task');
    let modalNewTask = document.getElementById('modal-new-task');

    btnNewTasks.forEach(btn => {
        btn.addEventListener('click', () => {
            modalNewTask.classList.toggle('hidden');
            modalNewTask.classList.toggle('flex');
        });
    });
</script>
