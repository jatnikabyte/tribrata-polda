<!-- Overlay -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.2s ease-out;
    }
</style>
<div id="subscribeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">

    <!-- Modal Box -->
    <div class="bg-white w-[90%] max-w-md rounded-2xl shadow-2xl p-8 relative animate-fadeIn">

        <!-- Close Button -->
        <button onclick="closeSubscribeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition text-xl font-bold">
            &times;
        </button>

        <!-- SVG Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-blue-50 p-5 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.5 4.5 0 10-9 0V10.5m-1.5 0h12a1.5 1.5 0 011.5 1.5v6a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 18v-6A1.5 1.5 0 016 10.5z" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 id="subscribeModalTitle" class="text-2xl font-bold text-center mb-3 text-gray-800">
            Konten Khusus Follower
        </h2>

        <!-- Tabloid Title (dynamic) -->
        <p id="subscribeModalTabloid" class="text-polri-primary font-semibold text-center mb-2 hidden">
        </p>
        <!-- Description -->
        <p class="text-gray-600 text-center text-sm leading-relaxed mb-6">
            Untuk dapat membaca atau mengunduh tabloid ini, silakan melakukan follow terlebih dahulu.
            Dengan menjadi follower, Anda mendapatkan akses penuh ke seluruh konten eksklusif kami.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col gap-3">
            <a id="subscribeBtn" href="{{ route('subscribe') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-center transition duration-300 shadow-md hover:shadow-lg">
                Follow Gratis Sekarang
            </a>

            <button onclick="closeSubscribeModal()" class="text-gray-500 hover:text-gray-700 text-sm transition">
                Nanti saja
            </button>
        </div>

    </div>
</div>


<script>
    function openSubscribeModal(tabloidId = null, tabloidTitle = null) {
        const modal = document.getElementById('subscribeModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Update modal for specific tabloid
        if (tabloidId && tabloidTitle) {
            document.getElementById('subscribeModalTabloid').textContent = tabloidTitle;
            document.getElementById('subscribeModalTabloid').classList.remove('hidden');
            document.getElementById('subscribeBtn').href = `{{ route('subscribe') }}/${tabloidId}`;
        } else {
            document.getElementById('subscribeModalTabloid').classList.add('hidden');
            document.getElementById('subscribeBtn').href = '{{ route('subscribe') }}';
        }
    }

    function closeSubscribeModal() {
        const modal = document.getElementById('subscribeModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Close when clicking outside modal
    document.getElementById('subscribeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSubscribeModal();
        }
    });
</script>
