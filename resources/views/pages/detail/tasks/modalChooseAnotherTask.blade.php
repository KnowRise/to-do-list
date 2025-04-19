<div id="modal-choose-another-task" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] min-w-[50vh] flex flex-col gap-[24px] overflow-hidden z-1">
        <div class="flex justify-end">
            <button type="button" class="btn-modal-choose-another-task text-[32px] font-extrabold">X</button>
        </div>
        <form action="{{ route('tasks.users.store', ['id' => $task->id, 'task_id' => 'taskId']) }}" id="form-store-user-task" class="hidden"
            method="POST">
            @csrf
        </form>

        <!-- Searchable Select Dropdown -->
        <div class="relative max-h-full overflow-hidden flex flex-col gap-[4px]">
            <h1 class="text-[32px] font-extrabold text-center mb-6">Choose Task to copy</h1>
            <input id="search-task" type="text" placeholder="Search task..."
                class="w-full px-[16px] py-[8px] border rounded-[8px]" />
            <ul id="task-dropdown" class="max-h-[40vh] overflow-auto border rounded-[8px]"></ul>
        </div>
    </div>
</div>
<div id="modal-confirm-choose-another-task" class="absolute inset-0 hidden justify-center">
    <div class="absolute top-[10px] border flex flex-col gap-[16px] p-[16px] rounded-[8px] bg-white">
        <h1 class="text-[16px]">Are You Sure? This will replace all user with user on the copied Task</h1>
        <div class="flex justify-end gap-[16px]">
            <button type="button" id="btn-confirm-choose-user-task" class="border py-[8px] px-[16px] rounded-[8px] hover:cursor-pointer hover:text-[#eeeeee] hover:bg-[#211C84]">Ok</button>
            <button type="button" class="btn-modal-confirm-choose-another-task border py-[8px] px-[16px] rounded-[8px] hover:cursor-pointer hover:text-[#eeeeee] hover:bg-[#C80036]">Cancel</button>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let modalChooseAnotherTask = document.getElementById('modal-choose-another-task');
        let btnModalChooseAnotherTask = document.querySelectorAll('.btn-modal-choose-another-task');
        let formStoreUserTask = document.getElementById('form-store-user-task');
        let taskDropdown = document.getElementById('task-dropdown');
        let searchTask = document.getElementById('search-task');
        let modalConfirmChooseAnotherTask = document.getElementById('modal-confirm-choose-another-task');
        let btnConfirmChooseUserTask = document.getElementById('btn-confirm-choose-user-task');
        let btnModalConfirmChooseAnotherTask = document.querySelectorAll('.btn-modal-confirm-choose-another-task');
        let userId = '';

        btnModalChooseAnotherTask.forEach(btn => {
            if (btn.dataset.userId) {
                userId = btn.dataset.userId;
            }
            btn.addEventListener('click', function () {
                modalChooseAnotherTask.classList.toggle('hidden');
                modalChooseAnotherTask.classList.toggle('flex');
            });
        });

        btnModalConfirmChooseAnotherTask.forEach(btn => {
            btn.addEventListener('click', function () {
                modalConfirmChooseAnotherTask.classList.toggle('hidden');
                modalConfirmChooseAnotherTask.classList.toggle('flex');
            });
        });

        btnConfirmChooseUserTask.addEventListener('click', function () {
            formStoreUserTask.submit();
        });

        const loadTasks = async function (search = '') {
            const res = await fetch(`/data/tasks?user_id=${userId}&search=${search}`);
            const data = await res.json();

            taskDropdown.innerHTML = '';
            if (data.length === 0) {
                taskDropdown.innerHTML = '<li class="px-4 py-2 text-gray-400">No task found</li>';
                return;
            }

            data.forEach(task => {
                const li = document.createElement('li');
                li.className = 'btn-modal-choose-another-task cursor-pointer hover:bg-gray-200 px-[16px] py-[8px]';
                li.textContent = task.title;
                li.dataset.taskId = task.id;

                li.addEventListener('click', function () {
                    formStoreUserTask.action = formStoreUserTask.action.replace('taskId', task.id);
                    modalConfirmChooseAnotherTask.classList.toggle('hidden');
                    modalConfirmChooseAnotherTask.classList.toggle('flex');
                });

                taskDropdown.appendChild(li);
            });
        }

        searchTask.addEventListener('input', function () {
            const searchValue = searchTask.value;
            loadTasks(searchValue);
        });

        loadTasks();
    });
</script>
