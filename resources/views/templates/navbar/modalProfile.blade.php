<div id="modal-profile"
    class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center z-1">
    <div class="bg-[#eeeeee] rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] min-w-[50vh] overflow-auto flex flex-col gap-[16px]
    shadow-[0_15px_20px_5px_rgba(0,0,0,0.7)]">
        <div class="flex justify-end">
            <button class="btn-profile text-[32px] font-extrabold">X</button>
        </div>
        <h1 class="text-center text-[32px] font-extrabold">Update User</h1>
        <form id="form-profile" action="{{ route('users.store', ['id' => auth()->user()->id]) }}" method="POST"
            class="flex flex-col gap-[16px]" enctype="multipart/form-data">
            @csrf
            <div class="w-full flex flex-col">
                <label class="text-[24px]" for="username">Username:</label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="username"
                    value="{{ auth()->user()->username }}" required>
            </div>
            @if (auth()->user()->role == 'worker' || auth()->user()->role == 'tasker')
                <div class="w-full flex flex-col">
                    <label class="text-[24px]" for="phone_number">Phone Number:</label>
                    <input class="text-[16px] rounded-[8px] border-2 p-[8px]" type="text" name="phone_number"
                        value="{{ auth()->user()->phone_number }}" required>
                    <p class="pt-[8px] text-center font-extrabold text-[#C80036]">(If Phone Number changed, re-verification
                        is required)</p>
                </div>
            @endif
            <div class="w-full flex flex-col">
                <label class="text-[24px]" for="profile">Profile:</label>
                <label for="profile" class="flex items-center py-[4px] px-[8px] rounded-[8px] border cursor-pointer">
                    <img src="{{ asset('icons/upload_file.svg') }}" alt="Profile" width="40" height="40">
                    <p class="text-[20px]">Choose File</p>
                </label>
                <input class="text-[16px] rounded-[8px] border-2 p-[8px] hidden" type="file"
                    accept=".jpg, .jpeg, .png, .svg" name="profile" id="profile" required>
            </div>
            <button id="btn-submit" type="button"
                class="text-[24px] border-2 w-full py-[4px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee] hover:cursor-pointer">Submit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let btnProfile = document.querySelectorAll(".btn-profile");
        let modalProfile = document.getElementById("modal-profile");
        let btnSubmit = document.getElementById("btn-submit");
        let formProfile = document.getElementById("form-profile");

        btnProfile.forEach(btn => {
            btn.addEventListener("click", function () {
                modalProfile.classList.toggle("hidden");
                modalProfile.classList.toggle("flex");
            });
        });

        btnSubmit.addEventListener("click", function () {
            formProfile.submit();
        });
    });
</script>
