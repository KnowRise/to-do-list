<div id="modal-new-user" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden">
        <div class="flex justify-end">
            <button type="button" class="btn-new-user text-[32px] font-extrabold">X</button>
        </div>
        <h1 class="text-[32px] font-extrabold text-center p-[16px]">Add New User</h1>
        <div class="flex gap-[16px] max-h-[60vh] overflow-hidden">
            <form action="{{ route('tasks.users.store', ['id' => $task->id]) }}" method="POST" class="flex flex-col gap-[16px] overflow-hidden max-h-[40vh]">
                @csrf
                <div class="flex gap-[16px]">
                    <button type="submit" class="border py-[8px] px-[16px] rounded-[8px] text-[20px]">Submit</button>
                    <button type="button" data-user-id="{{ auth()->user()->id }}" class="btn-modal-choose-another-task border py-[8px] px-[16px] rounded-[8px] text-[20px]">Copy from Another
                        Task</button>
                </div>
                <input type="text" id="search" placeholder="Search"
                    class="border-2 py-[8px] px-[16px] rounded-[8px] text-[20px]">
                <div class="flex flex-col overflow-auto gap-[16px] border p-[16px] max-h-full" id="list-users">
                </div>
            </form>
            <div class="flex flex-col rounded-[8px] border overflow-hidden px-[16px] py-[8px] gap-[16px] max-h-[40vh]">
                <h1 class="text-[20px] border-b">Assigned User</h1>
                <div class="flex flex-col overflow-auto gap-[16px] max-h-full" id="list-selected-users">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let btnNewUsers = document.querySelectorAll('.btn-new-user');
    let modalNewUser = document.getElementById('modal-new-user');
    let listUsers = document.getElementById('list-users');
    let listSelectedUsers = document.getElementById('list-selected-users');
    let search = document.getElementById('search');
    let selectedUsers = new Set();

    btnNewUsers.forEach(btn => {
        btn.addEventListener('click', function () {
            modalNewUser.classList.toggle('hidden');
            modalNewUser.classList.toggle('flex');
        });
    });

    const loadUsers = async function (search = '') {
        const res = await fetch('/data/users?search=' + search);
        const data = await res.json();

        listUsers.innerHTML = '';
        data.forEach(user => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'mr-[8px]';
            checkbox.value = user.id;
            checkbox.name = 'user_ids[]';

            checkbox.checked = selectedUsers.has(user.id);

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    selectedUsers.add(user.id);
                } else {
                    selectedUsers.delete(user.id);
                }
                renderSelectedUsers();
            });

            const label = document.createElement('label');
            label.classList.add('flex', 'items-center', 'text-[20px]');
            label.appendChild(checkbox);
            label.append(user.username, '');

            listUsers.appendChild(label);
        });
    }

    const renderSelectedUsers = async () => {
        listSelectedUsers.innerHTML = '';

        for (let id of selectedUsers) {
            const res = await fetch('/data/users/' + id);
            const user = await res.json();

            const userDiv = document.createElement('div');
            userDiv.className = 'flex justify-between items-center text-[20px] border py-[4px] px-[8px] rounded';

            userDiv.innerHTML = `
            <span>${user.username}</span>
            <button data-id="${user.id}">
                <img src="{{ asset('icons/delete_red.svg') }}" alt="Remove" width="30px" height="30px">
            </button>
        `;

            listSelectedUsers.appendChild(userDiv);

            // Tambahkan event untuk tombol Remove
            userDiv.querySelector('button').addEventListener('click', () => {
                selectedUsers.delete(user.id);
                renderSelectedUsers();  // Refresh list assigned
                loadUsers(search.value); // Refresh list utama
            });
        }
    };

    search.addEventListener('input', function (e) {
        loadUsers(e.target.value);
    });

    loadUsers();
</script>
