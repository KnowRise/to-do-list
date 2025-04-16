<div id="modal-detail-user-task"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div
        class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden flex flex-col gap-[24px]">
        <div class="flex justify-end">
            <button type="button" class="btn-detail-user-task text-[32px] font-extrabold">X</button>
        </div>
        <div class="flex flex-col min-w-[40vh] rounded-[16px] border p-[16px] gap-[16px]">
            <div class="flex gap-[16px]">
                <form action="">
                    <button id="btn-approved" class="hidden flex-col justify-center items-center">
                        <img src="{{ asset('icons/check.svg') }}" alt="Approve" width="40" height="40">
                        Approve
                    </button>
                </form>
                <form action="">
                    <button id="btn-rejected" class="hidden flex-col justify-center items-center">
                        <img src="{{ asset('icons/cancel.svg') }}" alt="Reject" width="40" height="40">
                        Reject
                    </button>
                </form>
            </div>
            <div class="flex flex-col flex-grow">
                <p id="data-user-task-username" class="text-[20px] py-[4px] px-[8px]">Username</p>
                <p id="data-user-task-status" class="text-[20px] py-[4px] px-[8px]">Status</p>
                <a href="" id="data-user-task-file" class="text-[20px] py-[4px] px-[8px]"></a>
                <p id="data-user-task-comment" class="text-[20px] py-[4px] px-[8px]">Comment</p>
            </div>
        </div>
    </div>
</div>

<script>
    let btnDetailUserTask = document.querySelectorAll('.btn-detail-user-task');
    let modalDetailUserTask = document.getElementById('modal-detail-user-task');
    let dataUserTaskUsername = document.getElementById('data-user-task-username');
    let dataUserTaskStatus = document.getElementById('data-user-task-status');
    let dataUserTaskFile = document.getElementById('data-user-task-file');
    let dataUserTaskComment = document.getElementById('data-user-task-comment');
    let btnApproved = document.getElementById('btn-approved');
    let btnRejected = document.getElementById('btn-rejected');

    // data-username="{{ $userTask->user->username }}" data-status="{{ $userTask->status }}" data-file="{{ $userTask->file_path ? asset($task->file_path) : null }}" data-comment="{{ $userTask->comment  }}"

    btnDetailUserTask.forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (btn == btnDetailUserTask[0]) {
                dataUserTaskUsername.textContent = `Username: ${btn.dataset.username}`;
                dataUserTaskStatus.textContent = `Status: ${btn.dataset.status}`;

                if (btn.dataset.file) {
                    dataUserTaskFile.href = btn.dataset.file;
                    dataUserTaskFile.classList.remove('hidden');
                    dataUserTaskFile.target = '_blank';
                    dataUserTaskFile.textContent = 'Click to download file attachment';
                } else {
                    dataUserTaskFile.classList.add('hidden');
                }

                if (btn.dataset.status == ('rejected' || 'approved')) {
                    dataUserTaskComment.textContent = btn.dataset.comment;
                } else if (btn.dataset.status == 'completed') {
                    btnApproved.classList.remove('hidden');
                    btnRejected.classList.remove('hidden');
                } else {
                    dataUserTaskComment.classList.add('hidden');
                }
            }

            modalDetailUserTask.classList.toggle('hidden');
            modalDetailUserTask.classList.toggle('flex');

        });
    });
</script>
