/**
 * Flipbook Module
 * Uses pdfjs-dist + page-flip (npm) with progressive/lazy page loading
 * and page-turn sound effect.
 */
import * as pdfjsLib from 'pdfjs-dist';
import { PageFlip } from 'page-flip';

// Configure PDF.js worker from the npm package
pdfjsLib.GlobalWorkerOptions.workerSrc = new URL(
    'pdfjs-dist/build/pdf.worker.min.mjs',
    import.meta.url
).toString();

// ─── State ───────────────────────────────────────────────────────────
let pageFlip = null;
let pageImages = [];
let currentPdfDoc = null;
let pdfLoadingTask = null;
let soundEnabled = true;

// Page-turn sound effect
const pageTurnSound = new Audio('/audio/page-flip.mp3');
pageTurnSound.volume = 0.5;

// ─── Helpers ─────────────────────────────────────────────────────────

/**
 * Create a placeholder canvas (loading spinner) for pages not yet rendered.
 */
function createPlaceholderDataUrl(width, height) {
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const ctx = canvas.getContext('2d');

    // White background
    ctx.fillStyle = '#f3f4f6';
    ctx.fillRect(0, 0, width, height);

    // Spinner circle
    const cx = width / 2;
    const cy = height / 2;
    const radius = Math.min(width, height) * 0.06;

    ctx.strokeStyle = '#d1d5db';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.arc(cx, cy, radius, 0, Math.PI * 2);
    ctx.stroke();

    ctx.strokeStyle = '#6b7280';
    ctx.lineWidth = 4;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.arc(cx, cy, radius, -Math.PI / 2, Math.PI / 4);
    ctx.stroke();

    // "Memuat..." text
    ctx.fillStyle = '#9ca3af';
    ctx.font = `${Math.round(width * 0.03)}px sans-serif`;
    ctx.textAlign = 'center';
    ctx.fillText('Memuat...', cx, cy + radius + 30);

    return canvas.toDataURL('image/jpeg', 0.8);
}

/**
 * Render a single PDF page to a JPEG data URL.
 */
async function renderPage(pdf, pageNum, scale) {
    const page = await pdf.getPage(pageNum);
    const viewport = page.getViewport({ scale });
    const canvas = document.createElement('canvas');
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    const ctx = canvas.getContext('2d');
    await page.render({ canvasContext: ctx, viewport }).promise;
    const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
    // Clean up
    page.cleanup();
    return dataUrl;
}

/**
 * Play page-turn sound if enabled.
 */
function playPageTurnSound() {
    if (!soundEnabled) return;
    pageTurnSound.currentTime = 0;
    pageTurnSound.play().catch(() => {});
}

// ─── Flipbook Init ───────────────────────────────────────────────────

function initFlipbookElements() {
    // No-op — elements accessed via getElementById on demand
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFlipbookElements);
} else {
    initFlipbookElements();
}

// ─── Open Flipbook ───────────────────────────────────────────────────

function openFlipbook(pdfUrl, title) {
    const flipbookModal = document.getElementById('flipbookModal');
    const flipbookContent = document.getElementById('flipbookContent');
    const flipbookTitle = document.getElementById('flipbookTitle');
    const flipbookLoading = document.getElementById('flipbookLoading');

    if (!flipbookModal || !flipbookContent || !flipbookTitle || !flipbookLoading) {
        console.error('Modal elements not found');
        return;
    }

    flipbookTitle.textContent = title;
    flipbookModal.classList.remove('hidden');
    void flipbookModal.offsetWidth;
    flipbookModal.classList.remove('opacity-0');
    flipbookModal.classList.add('flex');
    flipbookContent.classList.remove('scale-95');
    flipbookContent.classList.add('scale-100');
    document.body.style.overflow = 'hidden';
    flipbookLoading.classList.remove('hidden');

    setTimeout(() => {
        cleanupAndLoadPdf(pdfUrl);
    }, 350);
}

// ─── Cleanup & Load ──────────────────────────────────────────────────

function cleanupAndLoadPdf(pdfUrl) {
    if (pdfLoadingTask) {
        try { pdfLoadingTask.destroy(); } catch (e) {}
        pdfLoadingTask = null;
    }

    if (currentPdfDoc) {
        try { currentPdfDoc.destroy(); } catch (e) {}
        currentPdfDoc = null;
    }

    if (pageFlip) {
        try { pageFlip.destroy(); } catch (e) {}
        pageFlip = null;
        pageImages = [];
    }

    const flipbookContainer = document.getElementById('flipbook');
    if (!flipbookContainer) {
        console.error('Flipbook container not found');
        return;
    }
    flipbookContainer.innerHTML = '';

    loadPdfProgressively(pdfUrl);
}

// ─── Progressive PDF Loading ─────────────────────────────────────────

const INITIAL_PAGES = 4;  // Render these first for instant display
const BATCH_SIZE = 4;     // Then render remaining pages in batches
const RENDER_SCALE = 1.5;

async function loadPdfProgressively(pdfUrl) {
    try {
        const cacheBuster = '?t=' + Date.now();
        pdfLoadingTask = pdfjsLib.getDocument({
            url: pdfUrl + cacheBuster,
            cMapPacked: true,
            verbosity: 0,
        });

        const pdf = await pdfLoadingTask.promise;

        const container = document.getElementById('flipbook');
        const loadingEl = document.getElementById('flipbookLoading');
        if (!container || !loadingEl) return;

        currentPdfDoc = pdf;
        const totalPages = pdf.numPages;
        document.getElementById('totalPages').textContent = totalPages;

        container.innerHTML = '';

        // Step 1: Get first page dimensions for placeholders
        const firstPage = await pdf.getPage(1);
        const vp = firstPage.getViewport({ scale: RENDER_SCALE });
        const pageW = vp.width;
        const pageH = vp.height;
        firstPage.cleanup();

        // Step 2: Create placeholder array
        const placeholderUrl = createPlaceholderDataUrl(pageW, pageH);
        pageImages = new Array(totalPages).fill(placeholderUrl);

        // Step 3: Render initial pages (first N)
        const initialCount = Math.min(INITIAL_PAGES, totalPages);
        const initialPromises = [];
        for (let i = 1; i <= initialCount; i++) {
            initialPromises.push(
                renderPage(pdf, i, RENDER_SCALE).then(dataUrl => {
                    pageImages[i - 1] = dataUrl;
                })
            );
        }
        await Promise.all(initialPromises);

        // Step 4: Initialize flipbook immediately with available + placeholder pages
        if (!document.getElementById('flipbook')) return;

        pageFlip = new PageFlip(container, {
            width: 600,
            height: 800,
            size: 'stretch',
            drawShadow: true,
            flippingTime: 800,
            usePortrait: true,
            startPage: 0,
            autoSize: true,
            maxShadowOpacity: 0.7,
            showCover: true,
            mobileScrollSupport: true,
        });

        pageFlip.loadFromImages([...pageImages]);

        pageFlip.on('flip', (e) => {
            document.getElementById('currentPage').textContent = e.data + 1;
            playPageTurnSound();
        });

        loadingEl.classList.add('hidden');

        // Step 5: Render remaining pages in background batches
        if (totalPages > initialCount) {
            renderRemainingPages(pdf, initialCount + 1, totalPages);
        }

    } catch (error) {
        console.error('Error loading PDF:', error);
        alert('Gagal memuat PDF. Silakan coba lagi.');
        closeFlipbook();
    }
}

/**
 * Background rendering of remaining pages in batches.
 * Updates the flipbook images as each batch completes.
 */
async function renderRemainingPages(pdf, startPage, totalPages) {
    for (let batchStart = startPage; batchStart <= totalPages; batchStart += BATCH_SIZE) {
        const batchEnd = Math.min(batchStart + BATCH_SIZE - 1, totalPages);
        const batchPromises = [];

        for (let i = batchStart; i <= batchEnd; i++) {
            batchPromises.push(
                renderPage(pdf, i, RENDER_SCALE).then(dataUrl => {
                    pageImages[i - 1] = dataUrl;
                })
            );
        }

        await Promise.all(batchPromises);

        // Update flipbook with newly rendered pages
        if (pageFlip) {
            try {
                pageFlip.loadFromImages([...pageImages]);
            } catch (e) {
                // flipbook may have been destroyed
            }
        } else {
            break; // Flipbook was closed, stop rendering
        }
    }
}

// ─── Close Flipbook ──────────────────────────────────────────────────

function closeFlipbook() {
    const flipbookModalEl = document.getElementById('flipbookModal');
    const flipbookContentEl = document.getElementById('flipbookContent');

    if (flipbookModalEl) {
        flipbookModalEl.classList.add('opacity-0');
    }
    if (flipbookContentEl) {
        flipbookContentEl.classList.remove('scale-100');
        flipbookContentEl.classList.add('scale-95');
    }

    setTimeout(() => {
        if (flipbookModalEl) {
            flipbookModalEl.classList.add('hidden');
            flipbookModalEl.classList.remove('flex');
        }

        if (pdfLoadingTask) {
            try { pdfLoadingTask.destroy(); } catch (e) {}
            pdfLoadingTask = null;
        }

        if (pageFlip) {
            try { pageFlip.destroy(); } catch (e) {}
            pageFlip = null;
        }
        pageImages = [];

        if (currentPdfDoc) {
            try { currentPdfDoc.destroy(); } catch (e) {}
            currentPdfDoc = null;
        }

        const flipbookContainer = document.getElementById('flipbook');
        if (flipbookContainer) {
            flipbookContainer.innerHTML = '';
        }

        document.body.style.overflow = 'auto';
    }, 300);
}

// ─── Navigation ──────────────────────────────────────────────────────

function turnPage(direction) {
    if (!pageFlip) return;
    if (direction === 'next') {
        pageFlip.flipNext('bottom');
    } else if (direction === 'prev') {
        pageFlip.flipPrev('bottom');
    }
}

function nextPage() {
    if (!pageFlip) return;
    pageFlip.flipNext('bottom');
}

function prevPage() {
    if (!pageFlip) return;
    pageFlip.flipPrev('bottom');
}

// ─── Zoom ────────────────────────────────────────────────────────────

function zoomIn() {
    const el = document.getElementById('flipbook');
    if (!el) return;
    const match = el.style.transform.match(/scale\(([^)]+)\)/);
    const scale = match ? parseFloat(match[1]) : 1;
    el.style.transform = `scale(${scale * 1.1})`;
}

function zoomOut() {
    const el = document.getElementById('flipbook');
    if (!el) return;
    const match = el.style.transform.match(/scale\(([^)]+)\)/);
    const scale = match ? parseFloat(match[1]) : 1;
    el.style.transform = `scale(${scale * 0.9})`;
}

function resetZoom() {
    const el = document.getElementById('flipbook');
    if (el) el.style.transform = 'scale(1)';
}

// ─── Sound Toggle ────────────────────────────────────────────────────

function toggleSound() {
    soundEnabled = !soundEnabled;
    const icon = document.getElementById('soundToggleIcon');
    if (icon) {
        icon.innerHTML = soundEnabled
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>';
    }
}

// ─── Track View & Open ──────────────────────────────────────────────

function trackAndOpenFlipbook(tabloidId, pdfUrl, title) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('input[name="_token"]')?.value
        || '';

    // fetch(`/tabloid/${tabloidId}/view`, {
    //     method: 'POST',
    //     headers: {
    //         'X-CSRF-TOKEN': csrfToken,
    //         'Accept': 'application/json',
    //     },
    // }).catch(() => {});

    openFlipbook(pdfUrl, title);
}

// ─── Expose to Window ───────────────────────────────────────────────

window.turnPage = turnPage;
window.nextPage = nextPage;
window.prevPage = prevPage;
window.zoomIn = zoomIn;
window.zoomOut = zoomOut;
window.resetZoom = resetZoom;
window.openFlipbook = openFlipbook;
window.closeFlipbook = closeFlipbook;
window.trackAndOpenFlipbook = trackAndOpenFlipbook;
window.toggleSound = toggleSound;

// ─── Global Event Listeners ─────────────────────────────────────────

// Close on click outside
document.addEventListener('click', (e) => {
    const flipbookModal = document.getElementById('flipbookModal');
    if (flipbookModal && e.target === flipbookModal && !flipbookModal.classList.contains('hidden')) {
        closeFlipbook();
    }
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    const flipbookModal = document.getElementById('flipbookModal');
    if (!flipbookModal || flipbookModal.classList.contains('hidden')) return;

    if (e.key === 'Escape') {
        closeFlipbook();
    } else if (e.key === 'ArrowLeft') {
        turnPage('prev');
    } else if (e.key === 'ArrowRight') {
        turnPage('next');
    } else if (e.key === '+' || e.key === '=') {
        zoomIn();
    } else if (e.key === '-' || e.key === '_') {
        zoomOut();
    }
});
