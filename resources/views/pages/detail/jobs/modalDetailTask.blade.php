<div id="modal-detail-task"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div class="flex flex-col border rounded-[16px] bg-[#eeeeee] max-w-[75vh] max-h-[60vh] min-w-[50vh] p-[32px]">
        <div class="flex justify-end">
            <button type="button" class="btn-detail-task text-[32px] font-extrabold">X</button>
        </div>
        <div class="flex flex-col gap-[16px]">
            <h1 id="task-title" class="text-center text-[32px] font-extrabold">Title</h1>
            <div class="flex flex-col gap-[8px]">
                <p class="text-[20px]" id="task-status">Status</p>
                <p class="text-[20px]" id="task-comment">Comment</p>
                <p class="text-[20px]" id="task-completed-at">Completed At</p>
                <a class="text-[20px] border py-[4px] px-[8px] rounded-[8px]" id="task-file" href="">Clik here to download the file</a>
                <p class="text-[20px]" id="task-description">Description</p>
            </div>
            <form id="form-input-file" action="{{ route('tasks.submit') }}" method="POST" class="flex flex-col gap-[16px]" enctype="multipart/form-data">
                @csrf
                <label for="input-file" class="flex items-center cursor-pointer">
                    <img src="{{ asset('icons/upload_file.svg') }}" alt="Upload File" width="40px" height="40px">
                    <p class="text-[20px]">Upload Revised File</p>
                </label>
                <input id="input-file" type="file" name="files-taskId" id="input-file" class="hidden">
                <button type="submit" class="border w-full py-[8px] px-[16px] rounded-[8px]">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    let btnDetailTasks = document.querySelectorAll('.btn-detail-task');
    let modalDetailTask = document.getElementById('modal-detail-task');
    let formInputFile = document.getElementById('form-input-file');
    let inputFile = document.getElementById('input-file');
    let taskId = null;


    btnDetailTasks.forEach(btn => {
        btn.addEventListener('click', function () {
            if (btn.dataset) {
                let taskTitle = document.getElementById('task-title');
                let taskComment = document.getElementById('task-comment');
                let taskStatus = document.getElementById('task-status');
                let taskCompletedAt = document.getElementById('task-completed-at');
                let taskFile = document.getElementById('task-file');
                let taskDescription = document.getElementById('task-description');

                taskId = btn.dataset.taskId;
                inputFile.name = inputFile.name.replace('-taskId', `[${taskId}]`);
                taskTitle.textContent = btn.dataset.title;
                taskStatus.textContent = 'Status : ' + btn.dataset.status;

                taskDescription.classList.add('hidden')
                taskComment.classList.add('hidden');
                taskCompletedAt.classList.add('hidden');
                taskFile.classList.add('hidden');
                taskStatus.classList.remove('text-green-500', 'text-red-500');
                formInputFile.classList.add('hidden');

                switch (btn.dataset.status) {
                    case 'completed':
                        formInputFile.classList.remove('hidden');
                        break;
                    case 'approved':
                        taskComment.textContent = btn.dataset.comment ? 'Comment : ' + btn.dataset.comment : '';
                        taskStatus.classList.add('text-green-500');
                        formInputFile.classList.add('hidden');
                        break;
                    case 'rejected':
                        taskComment.textContent = btn.dataset.comment ? 'Comment : ' + btn.dataset.comment : '';
                        taskStatus.classList.add('text-red-500');
                        formInputFile.classList.remove('hidden');
                        break;
                    default:
                        break;
                }

                if (btn.dataset.completedAt) {
                    taskCompletedAt.textContent = 'Completed At : ' + btn.dataset.completedAt;
                    taskCompletedAt.classList.remove('hidden');
                }

                if (btn.dataset.filePath) {
                    taskFile.href = btn.dataset.filePath;
                    taskFile.target = '_blank';
                    taskFile.classList.remove('hidden');
                }

                if (btn.dataset.description) {
                    taskDescription.textContent = 'Description : ' + btn.dataset.description;
                    taskDescription.classList.remove('hidden');
                }


            }

            modalDetailTask.classList.toggle('hidden');
            modalDetailTask.classList.toggle('flex');
        })
    })
</script>
