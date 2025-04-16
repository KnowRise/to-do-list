<div class="flex justify-between items-center p-4 border-b border-gray-300 bg-white">
    <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold cursor-pointer">TaskFlow</a>
    <div class="relative flex items-center gap-4">
        <p class="text-xl font-medium">{{ auth()->user()->username }}</p>
        <button id="btn">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-300">
                <img src="{{ asset(Storage::url(auth()->user()->profile)) }}" alt="Profile Picture" class="w-full h-full object-cover">
            </div>
        </button>

        <!-- Dropdown -->
        <div id="dropdown"
            class="absolute top-[60px] right-0 hidden flex-col bg-white border border-gray-300 rounded-md shadow-lg min-w-[140px] text-sm text-gray-800">
            <a href="#" class="px-4 py-2 hover:bg-[#211C84] hover:text-white rounded-t-md transition">Profile</a>
            <a href="#" class="px-4 py-2 hover:bg-[#211C84] hover:text-white transition">Password</a>
            <button id="btn-logout"
                class="w-full text-left px-4 py-2 hover:bg-[#C80036] hover:text-white rounded-b-md transition">Logout</button>
        </div>
    </div>
</div>
<div id="modal-logout" class="absolute inset-0 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div class="bg-white shadow-lg rounded-[16px] p-[32px] border max-w-[75vh] max-h-[60vh] overflow-hidden">
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
        fetch("{{ route('logout') }}", {
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
