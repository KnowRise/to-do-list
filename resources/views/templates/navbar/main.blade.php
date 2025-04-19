<div class="flex justify-between items-center p-4 border-b border-gray-300 bg-white">
    <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold cursor-pointer">TaskFlow</a>
    <div class="relative flex items-center gap-4">
        <p class="text-xl font-medium">{{ auth()->user()->username }}</p>
        <button id="btn" class="cursor-pointer">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-300">
                <img src="{{ asset(Storage::url(auth()->user()->profile)) }}" alt="Profile Picture" class="w-full h-full object-cover">
            </div>
        </button>

        <!-- Dropdown -->
        <div id="dropdown"
            class="absolute top-[60px] right-0 hidden flex-col bg-white border border-gray-300 rounded-md shadow-lg min-w-[140px] text-sm text-gray-800">
            <button class="btn-profile px-4 py-2 hover:bg-[#211C84] text-start hover:text-white rounded-t-md transition cursor-pointer">Profile</button>
            <button class="btn-password px-4 py-2 hover:bg-[#211C84] text-start hover:text-white transition cursor-pointer">Password</button>
            <form id="form-logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" id="btn-logout" data-title="Logout"
                    data-message="This action will log you out of your account" data-action="logout"
                    class="btn-modal-confirm w-full text-left px-4 py-2 hover:bg-[#C80036] hover:text-white rounded-b-md transition cursor-pointer">Logout</button>
            </form>
        </div>
    </div>
</div>
@include('templates.modalConfirm')
@include('templates.navbar.modalProfile')
@include('templates.navbar.modalPassword')

<script>
    let btn = document.getElementById("btn");
    let dropdown = document.getElementById("dropdown");
    let btnLogout = document.getElementById("btn-logout");

    btn.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
        dropdown.classList.toggle("flex");
    });

    btnLogout.addEventListener("click", function (event) {
        dropdown.classList.add("hidden");
        dropdown.classList.remove("flex");
    });
</script>
