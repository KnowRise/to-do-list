<div id="modal-detail-user-task"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div
        class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden flex flex-col gap-[24px]">
        <div class="flex justify-between">
            <div class="flex gap-[16px]">
                <form id="form-approved" action="{{ route('tasks.status', ['id' => 'id']) }}" method="POST">
                    @csrf
                    <input type="text" name="status" value="approved" hidden>
                    <button id="btn-approved" class="hidden flex-col justify-center items-center" type="button">
                        <img src="{{ asset('icons/check.svg') }}" alt="Approve" width="40" height="40">
                        Approve
                    </button>
                </form>
                <form id="form-rejected" action="{{ route('tasks.status', ['id' => 'id']) }}" method="POST">
                    @csrf
                    <input type="text" name="status" value="rejected" hidden>
                    <button id="btn-rejected" class="hidden flex-col justify-center items-center" type="button">
                        <img src="{{ asset('icons/cancel.svg') }}" alt="Reject" width="40" height="40">
                        Reject
                    </button>
                </form>
            </div>
            <button type="button" class="btn-detail-user-task text-[32px] font-extrabold">X</button>
        </div>
        <input type="text" class="text-[20px] py-[8px] px-[16px] border mb-[16px] hidden" placeholder="Comment" name="comment" id="input-comment">
        <div class="flex flex-col min-w-[40vh] rounded-[16px] border p-[16px] gap-[16px]">
            <h1 class="text-[32px] font-extrabold text-center">Detail User</h1>
            <div class="flex flex-col">
                <p id="data-user-task-username" class="text-[20px] py-[4px] px-[8px]">Username</p>
                <p id="data-user-task-status" class="text-[20px] py-[4px] px-[8px]">Status</p>
                <p id="data-user-task-completed-at" class="text-[20px] py-[4px] px-[8px]">Completed At</p>
                <a href="" id="data-user-task-file" class="text-[20px] py-[4px] px-[8px]"></a>
                <p id="data-user-task-comment" class="text-[20px] py-[4px] px-[8px]">Comment</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnDetailUserTask = document.querySelectorAll('.btn-detail-user-task');
        const modalDetailUserTask = document.getElementById('modal-detail-user-task');
        const dataUserTaskUsername = document.getElementById('data-user-task-username');
        const dataUserTaskStatus = document.getElementById('data-user-task-status');
        const dataUserTaskFile = document.getElementById('data-user-task-file');
        const dataUserTaskComment = document.getElementById('data-user-task-comment');
        const dataUserTaskCompletedAt = document.getElementById('data-user-task-completed-at');
        const btnApproved = document.getElementById('btn-approved');
        const btnRejected = document.getElementById('btn-rejected');
        const formApproved = document.getElementById('form-approved');
        const formRejected = document.getElementById('form-rejected');
        const inputComment = document.getElementById('input-comment');

        btnRejected.addEventListener('click', function () {
            if (inputComment.value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'comment';
                input.value = inputComment.value;
                formRejected.appendChild(input);
            }
            formRejected.submit();
        });

        btnApproved.addEventListener('click', function () {
            if (inputComment.value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'comment';
                input.value = inputComment.value;
                formApproved.appendChild(input);
            }
            formApproved.submit();
        });

        btnDetailUserTask.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (btn.dataset) {
                    // Set data
                    dataUserTaskUsername.textContent = `Username: ${btn.dataset.username}`;
                    dataUserTaskStatus.textContent = `Status/Progress: ${btn.dataset.status}`;

                    if (btn.dataset.comment) {
                        dataUserTaskComment.textContent = `Comment: ${btn.dataset.comment}`;
                        dataUserTaskComment.classList.remove('hidden');
                    } else {
                        dataUserTaskComment.classList.add('hidden');
                    }

                    // File
                    if (btn.dataset.file) {
                        dataUserTaskFile.href = btn.dataset.file;
                        dataUserTaskFile.textContent = 'Click to download file attachment';
                        dataUserTaskFile.target = '_blank';
                        dataUserTaskFile.classList.remove('hidden');
                    } else {
                        dataUserTaskFile.classList.add('hidden');
                    }

                    // Status Color
                    dataUserTaskStatus.classList.remove('text-red-500', 'text-green-500');
                    if (btn.dataset.status === 'rejected') {
                        dataUserTaskStatus.classList.add('text-red-500');
                    } else if (btn.dataset.status === 'approved') {
                        dataUserTaskStatus.classList.add('text-green-500');
                    }


                    // Tampilkan tombol atau tidak berdasarkan status
                    if (btn.dataset.status === 'completed') {
                        dataUserTaskCompletedAt.textContent = `Completed At: ${btn.dataset.completed_at}`;
                        formApproved.action = formApproved.action.replace('id', btn.dataset.id);
                        formRejected.action = formRejected.action.replace('id', btn.dataset.id);

                        inputComment.classList.remove('hidden');
                        btnApproved.classList.remove('hidden');
                        btnRejected.classList.remove('hidden');
                        dataUserTaskComment.classList.add('hidden');
                    } else {
                        dataUserTaskCompletedAt.classList.add('hidden');
                        inputComment.classList.add('hidden');
                        btnApproved.classList.add('hidden');
                        btnRejected.classList.add('hidden');
                    }

                    // Show modal
                    modalDetailUserTask.classList.toggle('hidden');
                    modalDetailUserTask.classList.toggle('flex');
                }
            });
        });
    });
</script>

