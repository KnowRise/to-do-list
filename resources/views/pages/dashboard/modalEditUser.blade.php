<div id="modal-edit-user"
    class="absolute inset-0 justify-center items-center bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden z-1">
    <form id="form-edit-user" action="{{ route('users.store', ['id' => 'id']) }}" method="POST"
        class="w-[80vh] max-h-[80vh] border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px]">
        @csrf
        <div class="w-full flex justify-end">
            <button type="button" class="btn-edit-user text-[32px]">X</button>
        </div>
        <h1 class="text-[32px]">Edit User</h1>
        <div class="flex flex-col h-full overflow-auto w-full gap-[8px] px-[8px]">
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="name">Name:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="name" id="edit-input-name"
                    required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="username">Username:</label>
                <input type="text" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="username"
                    id="edit-input-username" required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="phone_number">Phone Number:</label>
                <input type="number" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="phone_number"
                    id="edit-input-phone-number" required>
            </div>
            <button type="submit"
                class="text-[24px] border-2 w-full py-[4px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee] hover:cursor-pointer">Submit</button>
        </div>
    </form>
</div>

<script>

    let btnEditUser = document.querySelectorAll('.btn-edit-user');
    let modalEditUser = document.getElementById('modal-edit-user');
    let formEditUser = document.getElementById('form-edit-user');

    btnEditUser.forEach((btn) => {
        btn.addEventListener('click', () => {
            const userId = btn.dataset.userId

            modalEditUser.classList.toggle('hidden');
            modalEditUser.classList.toggle('flex');

            formEditUser.action = formEditUser.action.replace('id', userId);

            document.getElementById('edit-input-name').value = btn.dataset.name;
            document.getElementById('edit-input-username').value = btn.dataset.username;
            document.getElementById('edit-input-phone-number').value = btn.dataset.phoneNumber;
        })
    });
</script>
