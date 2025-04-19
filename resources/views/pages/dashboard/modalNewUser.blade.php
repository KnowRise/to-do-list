<div id="modal-new-user"
    class="absolute inset-0 justify-center items-center bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden z-1">
    <form action="{{ route('users.store') }}" method="POST"
        class="w-[80vh] max-h-[80vh] border-2 bg-[#eeeeee] rounded-[16px] flex flex-col justify-center items-center gap-[24px] p-[24px]">
        @csrf
        <div class="w-full flex justify-end">
            <button type="button" class="btn-new-user text-[32px]">X</button>
        </div>
        <h1 class="text-[32px]">New User</h1>
        <div class="flex flex-col h-full overflow-auto w-full gap-[8px] px-[8px]">
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="name">Name:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="name" required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="username">Username:</label>
                <input type="text" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="username" required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="phone_number">Phone Number:</label>
                <input type="number" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="phone_number" required>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="password">Password:</label>
                <input id="password" type="password" class="text-[16px] rounded-[8px] border-2 p-[8px]" name="password" required>
            </div>
            <div class="flex">
                <input type="checkbox" id="show-password-checkbox">
                <label for="show-password-checkbox" class="text-[16px] ml-[8px]">Show Password</label>
            </div>
            <div class="w-full flex flex-col gap-[16px]">
                <label class="text-[24px]" for="role">Role:</label>
                <select name="role" class="text-[16px] rounded-[8px] border-2 p-[8px]">
                    <option value="admin">Admin</option>
                    <option value="worker">Worker</option>
                    <option value="tasker">Tasker</option>
                </select>
            </div>
            <button type="submit"
                class="text-[24px] border-2 w-full py-[4px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee] hover:cursor-pointer">Submit</button>
        </div>
    </form>
</div>

<script>
    let btnNewUser = document.querySelectorAll('.btn-new-user');
    let modalNewUser = document.getElementById('modal-new-user');
    let showPasswordCheckbox = document.getElementById('show-password-checkbox');
    let passwordInput = document.getElementById('password');

    btnNewUser.forEach((btn) => {
        btn.addEventListener('click', () => {
            modalNewUser.classList.toggle('hidden');
            modalNewUser.classList.toggle('flex')
        });
    })

    showPasswordCheckbox.addEventListener('change', () => {
        if (showPasswordCheckbox.checked) {
            passwordInput.setAttribute('type', 'text');
        } else {
            passwordInput.setAttribute('type', 'password');
        }
    });
</script>
