<!-- ================= FLIPBOOK MODAL ================= -->
<div id="flipbookModal" class="fixed inset-0 bg bg-polri-black/95 hidden items-center justify-center z-[1000] backdrop-blur-md opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl overflow-hidden w-full max-w-6xl h-[90vh] relative shadow-2xl border-4 border-polri-gold transform scale-95 transition-transform duration-300 flex flex-col" id="flipbookContent">
        <!-- Header -->
        <div class="bg-polri-secondary px-6 py-4 flex items-center justify-between border-b-2 border-polri-gold">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-polri-gold rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-polri-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332-.477 4.5-1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"></path>
                    </svg>
                </div>
                <h3 class="text-white font-black text-lg tracking-wide" id="flipbookTitle">Majalah Digital</h3>
            </div>
            <button onclick="closeFlipbook()" class="text-white hover:text-polri-gold transition focus:outline-none p-2 rounded-lg hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- PDF Viewer -->
        <div class="flex-1 relative overflow-hidden bg-gray-100">
            <!-- Loading State -->
            {{-- <div id="flipbookLoading" class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10">
                <div class="text-center">
                    <div class="w-16 h-16 border-4 border-polri-primary border-t-polri-gold rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-polri-primary font-semibold">Memuat majalah...</p>
                </div>
            </div> --}}

            <!-- DFlip Flipbook -->
            {{-- f/fm/filecontent/13/0-tabloid-digital-tribratanews-banten-ok.pdf --}}
            {{-- <div id="my_flipbook" class="_df_book w-full h-full" webgl="true" backgroundcolor="white"></div> --}}
            <div id="flipContainer"></div>
        </div>
    </div>
</div>
<script>
    var flipbookModal = null;
    var flipbookContent = null;
    var flipbookTitle = null;
    var flipbookLoading = null;
    var flipbookInstance = null;

    function initFlipbookModal() {
        flipbookModal = document.getElementById('flipbookModal');
        flipbookContent = document.getElementById('flipbookContent');
        flipbookTitle = document.getElementById('flipbookTitle');
        // flipbookLoading = document.getElementById('flipbookLoading');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFlipbookModal);
    } else {
        initFlipbookModal();
    }

    function openFlipbook(pdfUrl, title) {
        console.log('Opening flipbook:', pdfUrl);

        // if (!flipbookModal || !flipbookContent || !flipbookTitle || !flipbookLoading) {
        //     console.error('Modal elements not found');
        //     return;
        // }

        flipbookTitle.textContent = title;
        flipbookModal.classList.remove('hidden');

        void flipbookModal.offsetWidth.offsetWidth;

        flipbookModal.classList.remove('opacity-0');
        flipbookModal.classList.add('flex');
        flipbookContent.classList.remove('scale-95');
        flipbookContent.classList.add('scale-100');
        document.body.style.overflow = 'hidden';
        // flipbookLoading.classList.remove('hidden');

        setTimeout(function() {
            loadFlipbook(pdfUrl);
        }, 350);
    }

    function loadFlipbook(pdfUrl) {
        //     document.getElementById("flipContainer").innerHTML = `
        //     <div id="my_flipbook"
        //          class="_df_book w-full h-full"
        //          webgl="true"
        //          backgroundcolor="white">
        //     </div>
        // `;

        // option DearFlip harus global
        window.option_my_flipbook = {
            source: "http://127.0.0.1:8000/assets/dflip/cv.pdf",
            webgl: true,
            height: 500
        };

        if (window.DEARFLIP) {
            DEARFLIP.parseBooks();
        }
        // var flipbookEl = document.getElementById('flipbook');
        // if (!flipbookEl) {
        //     console.error('Flipbook element not found');
        //     return;
        // }

        // if (flipbookInstance) {
        //     try {
        //         flipbookInstance.destroy();
        //     } catch (e) {}
        //     flipbookInstance = null;
        // }

        // flipbookEl.innerHTML = '';

        // var cacheBuster = '?t=' + new Date().getTime();
        // var pdfUrlWithCache = pdfUrl + cacheBuster;

        // flipbookEl.setAttribute('source', 'http://127.0.0.1:8000/assets/dflip/tb.pdf');

        // var option_my_flipbook = {
        //     source: "http://127.0.0.1:8000/assets/dflip/tb.pdf",
        //     webgl: true,
        //     height: 500
        // };

        // flipbookInstance = jQuery(flipbookEl).flipBook({
        //     webgl: true,
        //     height: '100%',
        //     duration: 800,
        //     soundEnable: false,
        //     autoFlip: false,
        //     allPages: true,
        //     zoomRatio: 1.5,
        //     maxZoom: 3,
        //     minZoom: 0.5,
        //     onReady: function() {
        //         if (flipbookLoading) {
        //             flipbookLoading.classList.add('hidden');
        //         }
        //     },
        //     onError: function(err) {
        //         console.error('Flipbook error:', err);
        //         alert('Gagal memuat PDF. Silakan coba lagi.');
        //         closeFlipbook();
        //     }
        // });
    }

    function closeFlipbook() {
        var flipbookModalEl = document.getElementById('flipbookModal');
        var flipbookContentEl = document.getElementById('flipbookContent');

        if (!flipbookModalEl || !flipbookContentEl) return;

        flipbookModalEl.classList.add('opacity-0');
        flipbookContentEl.classList.remove('scale-100');
        flipbookContentEl.classList.add('scale-95');

        setTimeout(function() {
            flipbookModalEl.classList.add('hidden');
            flipbookModalEl.classList.remove('flex');

            if (flipbookInstance) {
                try {
                    flipbookInstance.destroy();
                } catch (e) {}
                flipbookInstance = null;
            }

            var flipbookContainer = document.getElementById('flipbook');
            // if (flipbookContainer) {
            //     flipbookContainer.innerHTML = '';
            //     flipbookContainer.removeAttribute('source');
            // }

            document.body.style.overflow = 'auto';
        }, 300);
    }

    function trackAndOpenFlipbook(tabloidId, pdfUrl, title) {
        // fetch(`/tabloid/${tabloidId}/view`, {
        //     method: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //         'Accept': 'application/json',
        //     },
        // }).catch(() => {});

        openFlipbook(pdfUrl, title);
    }

    window.openFlipbook = openFlipbook;
    window.closeFlipbook = closeFlipbook;

    document.addEventListener('click', function(e) {
        var flipbookModalEl = document.getElementById('flipbookModal');
        if (flipbookModalEl && e.target === flipbookModalEl && !flipbookModalEl.classList.contains('hidden')) {
            closeFlipbook();
        }
    });

    document.addEventListener('keydown', function(e) {
        var flipbookModalEl = document.getElementById('flipbookModal');
        if (!flipbookModalEl || flipbookModalEl.classList.contains('hidden')) return;

        if (e.key === 'Escape') {
            closeFlipbook();
        }
    });
</script>
