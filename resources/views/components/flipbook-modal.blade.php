<!-- ================= FLIPBOOK MODAL ================= -->
<div id="flipbookModal" class="fixed inset-0 bg bg-polri-black/95 hidden items-center justify-center z-[1000] backdrop-blur-md opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl overflow-hidden w-full max-w-6xl h-[90vh] relative shadow-2xl border-4 border-polri-gold transform scale-95 transition-transform duration-300 flex flex-col" id="flipbookContent">
        <!-- PDF Viewer -->
        <div class="flex-1 relative overflow-hidden bg-gray-100">
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

        // option DearFlip harus global
        window.option_my_flipbook = {
            source: "http://127.0.0.1:8000/assets/dflip/cv.pdf",
            webgl: true,
            height: 500
        };

        if (window.DEARFLIP) {
            DEARFLIP.parseBooks();
        }
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

            document.body.style.overflow = 'auto';
        }, 300);
    }

    function trackAndOpenFlipbook(tabloidId, pdfUrl, title) {
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
