<div class="flex w-full">
    <div class="hidden md:grid grid-cols-3 w-full p-[25px] text-[#1D1D1D]">
        <h1 class="text-[32px] font-extrabold">TaskFlow</h1>
        <div class="flex justify-center items-center text-center">
            <div
                class="border-2 border-[#1D1D1D] rounded-full h-[50px] w-1/2 flex items-center justify-center p-[10px]">
                <p class="text-[24px]">Search</p>
            </div>
        </div>
        <div class="flex items-center gap-[25px] justify-end relative">
            <div id="dropdown"
                class="absolute right-[75px] border-2 bg-[#eeeeee] flex-col text-center rounded-[8px] w-[100px] gap-[4px] hidden">
                <a href="" class="hover:bg-[#211C84] hover:text-[#eeeeee]">Profile</a>
                <a href="" class="hover:bg-[#211C84] hover:text-[#eeeeee]">Password</a>
                <button id="logout-btn" class="hover:bg-[#C80036] hover:text-[#eeeeee] w-full">Logout</button>
            </div>
            <p class="text-[24px]">{{ $user->username }}</p>
            <button id="btn">
                <div class="w-[50px] h-[50px] rounded-full">
                    <img src="{{ asset($user->profile) }}" alt="Profile Picture" class="w-full h-full rounded-full">
                </div>
            </button>
        </div>
    </div>
</div>
<div id="modal-logout" class="hidden fixed inset-0 items-center justify-center mb-[10%]">
    <div class="bg-[#eeeeee] p-[25px] rounded-[8px] w-[300px] text-center">
        <h1 class="text-[32px] font-extrabold">Logout</h1>
        <p class="text-[24px]">Apakah anda yakin ingin logout?</p>
        <div class="flex justify-center gap-[10px] mt-[10px]">
            <button id="cancel-btn" class="hover:bg-[#C80036] border-2 hover:text-[#eeeeee] px-[10px] py-[5px] rounded-[8px] text-[16px]">Cancel</button>
            <button id="confirm-btn"
                class="hover:bg-[#211C84] border-2 hover:text-[#eeeeee] px-[10px] py-[5px] rounded-[8px] text-[16px]">Confirm</button>
        </div>
    </div>
</div>

<script>
    let btn = document.getElementById("btn");
    let dropdown = document.getElementById("dropdown");
    let logoutBtn = document.getElementById("logout-btn");
    let modalLogout = document.getElementById("modal-logout");
    let cancelBtn = document.getElementById("cancel-btn");
    let confirmBtn = document.getElementById("confirm-btn");

    btn.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
        dropdown.classList.toggle("flex");
    });

    logoutBtn.addEventListener("click", function () {
        modalLogout.classList.remove("hidden");
        modalLogout.classList.add("flex");
    });

    cancelBtn.addEventListener("click", function () {
        modalLogout.classList.add("hidden");
        modalLogout.classList.remove("flex");
        dropdown.classList.add("hidden");
    });

    confirmBtn.addEventListener("click", function () {
        fetch("{{ route('backend.logout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({})
        })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url; // Redirect setelah logout
                } else {
                    alert("Logout gagal! Coba lagi.");
                }
            })
            .catch(error => console.error("Error:", error));
    });
</script>
