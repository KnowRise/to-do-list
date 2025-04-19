<div id="modal-confirm"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div class="bg-[#eeee] rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] min-w-[40vh] overflow-hidden flex flex-col gap-[16px]
    shadow-[0_15px_20px_5px_rgba(0,0,0,0.7)]">
        <div class="flex flex-col text-center gap-[24px]">
            <h1 id="title-modal" class="font-extrabold text-[32px]"></h1>
            <p id="message-modal" class="text-[20px]"></p>
        </div>
        <div class="grid grid-cols-2 gap-[16px] w-full">
            <button type="button"
                class="btn-modal-confirm border text-[16px] py-[8px] px-[16px] rounded-[8px] hover:bg-[#C80036] hover:text-[#eeeeee]">Cancel</button>
            <button type="button" id="btn-confirm"
                class="border text-[16px] py-[8px] px-[16px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">Confirm</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let modalConfirm = document.getElementById('modal-confirm');
        let btnModalConfirm = document.querySelectorAll('.btn-modal-confirm');
        let btnConfirm = document.getElementById('btn-confirm');
        let titleModal = document.getElementById('title-modal');
        let messageModal = document.getElementById('message-modal');

        btnModalConfirm.forEach(btn => {
            btn.addEventListener('click', function () {
                if (btn.dataset.title && btn.dataset.message && btn.dataset.action) {
                    titleModal.textContent = btn.dataset.title;
                    messageModal.textContent = 'Are you sure? ' + btn.dataset.message;
                    btnConfirm.dataset.action = btn.dataset.action;

                    if (btn.dataset.userId) {
                        btnConfirm.dataset.userId = btn.dataset.userId;
                    }

                    modalConfirm.classList.remove('hidden');
                    modalConfirm.classList.add('flex');
                } else {
                    modalConfirm.classList.add('hidden');
                    modalConfirm.classList.remove('flex');
                }
            });
        });

        btnConfirm.addEventListener('click', function () {
            const action = this.dataset.action;
            switch (action) {
                case 'logout':
                    let formLogout = document.getElementById("form-logout");
                    formLogout.submit();
                    break;
                case 'deleteUser':
                    const userId = this.dataset.userId;
                    let formDeleteUser = document.getElementById(`form-delete-user-${userId}`);
                    formDeleteUser.submit();
                    break;
                case 'deleteJob':
                    let formDeleteJob = document.getElementById('form-delete-job');
                    formDeleteJob.submit();
                    break;
                case 'deleteTask':
                    let formDeleteTask = document.getElementById('form-delete-task');
                    formDeleteTask.submit();
                    break;
                case 'deleteUserTask':
                    let formDeleteUserTask = document.getElementById('form-delete-user-task');
                    formDeleteUserTask.submit();
                    break;
                default:
                    break;
            }
            modalConfirm.classList.add('hidden');
            modalConfirm.classList.remove('flex');
        });
    });
</script>
