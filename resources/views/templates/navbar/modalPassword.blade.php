<div id="modal-password"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div class="bg-[#eeeeee] rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] min-w-[50vh] overflow-auto flex flex-col gap-[16px]
    shadow-[0_15px_20px_5px_rgba(0,0,0,0.7)]">
        <div class="flex justify-end">
            <button class="btn-password text-[32px] font-extrabold">X</button>
        </div>
        <h1 class="text-center text-[32px] font-extrabold">Change Password</h1>
        <form action="{{ route('users.password', ['id' => auth()->user()->id]) }}" method="POST" class="flex flex-col gap-[16px]">
            @csrf
            <div class="flex flex-col gap-[8px]">
                <label class="text-[20px]">Old Password:</label>
                <input type="password" name="old_password" class="input-password text-[16px] rounded-[8px] border-2 p-[8px]" required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label class="text-[20px]">New Password:</label>
                <input type="password" name="new_password" class="input-password text-[16px] rounded-[8px] border-2 p-[8px]" required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label class="text-[20px]">New Password Confirmation:</label>
                <input type="password" name="new_password_confirmation" class="input-password text-[16px] rounded-[8px] border-2 p-[8px]" required>
            </div>
            <div class="flex gap-[8px]">
                <input type="checkbox" id="show-password">
                <label for="show-password" class="text-[20px]">Show Password</label>
            </div>
            <button type="submit" class="border py-[8px] px-[16px] text-[20px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">Submit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let btnPassword = document.querySelectorAll(".btn-password");
        let modalPassword = document.getElementById("modal-password");
        let inputPassword = document.querySelectorAll(".input-password");
        let showPassword = document.getElementById("show-password");

        btnPassword.forEach(btn => {
            btn.addEventListener("click", function () {
                modalPassword.classList.toggle("hidden");
                modalPassword.classList.toggle("flex");
            });
        });

        showPassword.addEventListener("change", function () {
            inputPassword.forEach(input => {
                if (showPassword.checked) {
                    input.setAttribute("type", "text");
                } else {
                    input.setAttribute("type", "password");
                }
            });
        });
    });
</script>
