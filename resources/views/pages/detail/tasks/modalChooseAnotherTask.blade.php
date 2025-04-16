<div id="modal-choose-another-task" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden">
        <form action="{{ route('tasks.users.store', ['id' => $task->id]) }}" id="form-store-user-task" class="hidden"
            method="POST">
            @csrf
        </form>
        <h1 class="text-[32px] font-extrabold text-center mb-6">Choose Task to copy</h1>

        <!-- Searchable Select Dropdown -->
        <div class="relative max-h-full overflow-hidden flex flex-col gap-[4px]">
            <input id="search-task" type="text" placeholder="Search task..."
                class="w-full px-[16px] py-[8px] border rounded-[8px]" />
            <ul id="task-dropdown" class="max-h-[40vh] overflow-auto border rounded-[8px]">

            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let modalChooseAnotherTask = document.getElementById('modal-choose-another-task');
        let btnChooseAnotherTask = document.querySelectorAll('.btn-choose-another-task');
        let formStoreUserTask = document.getElementById('form-store-user-task');
        let taskDropdown = document.getElementById('task-dropdown');
        let searchTask = document.getElementById('search-task');

        btnChooseAnotherTask.forEach(btn => {
            btn.addEventListener('click', function () {
                modalChooseAnotherTask.classList.toggle('hidden');
                modalChooseAnotherTask.classList.toggle('flex');
            });
        });

        const loadTasks = async function (search = '') {
            const res = await fetch('/data/tasks?search=' + search);
            const data = await res.json();

            taskDropdown.innerHTML = '';
            if (data.length === 0) {
                taskDropdown.innerHTML = '<li class="px-4 py-2 text-gray-400">No task found</li>';
                return;
            }

            data.forEach(task => {
                const li = document.createElement('li');
                li.className = 'cursor-pointer hover:bg-gray-200 px-[16px] py-[8px]';
                li.textContent = task.title;
                li.dataset.taskId = task.id;

                li.addEventListener('click', () => {
                    formStoreUserTask.action += '?task_id=' + task.id;
                    formStoreUserTask.submit();
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
