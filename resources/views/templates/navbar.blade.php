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
                <button id="btn-logout" class="hover:bg-[#C80036] hover:text-[#eeeeee] w-full">Logout</button>
            </div>
            <p class="text-[24px]">{{ auth()->user()->username }}</p>
            <button id="btn">
                <div class="w-[50px] h-[50px] rounded-full">
                    <img src="{{ asset(auth()->user()->profile) }}" alt="Profile Picture"
                        class="w-full h-full rounded-full">
                </div>
            </button>
        </div>
    </div>
</div>
<div id="modal-logout" class="absolute inset-0 items-center justify-center hidden">
    <div
        class="flex p-[24px] flex-col justify-center items-center w-[50vh] h-[40vh] border-2 bg-[#eeeeee] rounded-[16px] gap-[24px]">
        <div class="flex flex-col text-center gap-[24px]">
            <h1 class="font-extrabold text-[32px]">Logout</h1>
            <p class="text-[16px]">Are you sure?</p>
        </div>
        <div class="grid grid-cols-2 gap-[24px] w-full">
            <button type="button" id="btn-cancel-modal-logout"
                class="w-full p-[6px] border-2 text-[16px] rounded-[8px] hover:bg-[#211C84] hover:text-[#eeeeee]">Cancel</button>
            <button type="button" id="btn-confirm-modal-logout"
                class="w-full p-[6px] border-2 text-[16px] rounded-[8px] hover:bg-[#C80036] hover:text-[#eeeeee]">Confirm</button>
        </div>
    </div>
</div>

<script>
    let modalMessage = document.getElementById('modal-message');
    let btnCloseModalMessage = document.getElementById('btn-close-modal-message');

    btnCloseModalMessage.addEventListener('click', function () {
        modalMessage.classList.remove('flex');
        modalMessage.classList.add('hidden');
    });
</script>


<script>
    let btn = document.getElementById("btn");
    let dropdown = document.getElementById("dropdown");
    let btnLogout = document.getElementById("btn-logout");
    let modalLogout = document.getElementById("modal-logout");
    let btnCancelModalLogout = document.getElementById("btn-cancel-modal-logout");
    let btnConfirmModalLogout = document.getElementById("btn-confirm-modal-logout");

    btn.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
        dropdown.classList.toggle("flex");
    });

    btnLogout.addEventListener("click", function () {
        modalLogout.classList.remove("hidden");
        modalLogout.classList.add("flex");
    });

    btnCancelModalLogout.addEventListener("click", function () {
        modalLogout.classList.add("hidden");
        modalLogout.classList.remove("flex");
        dropdown.classList.add("hidden");
    });

    btnConfirmModalLogout.addEventListener("click", function () {
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
