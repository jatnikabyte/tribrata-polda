// Google Analytics Init
if (window.GA_ID) {
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', window.GA_ID);
}

const navbar = document.getElementById('navbar');
window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    navbar.classList.add("py-2");
    navbar.classList.remove("py-4");
  } else {
    navbar.classList.add("py-4");
    navbar.classList.remove("py-2");
  }
});

// Hero Swiper Initialization
const heroSwiper = new Swiper(".heroSwiper", {
  slidesPerView: 2,
  spaceBetween: 30,
  centeredSlides: true,
  rewind: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    412: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 50,
    },
    1280: {
      slidesPerView: 4,
      spaceBetween: 50,
    },
  },
});

// Mobile Menu Toggle
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuContent = document.getElementById('mobileMenuContent');

    if (!mobileMenu || !mobileMenuContent) {
        console.error('Mobile menu elements not found');
        return;
    }

    if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');

        setTimeout(() => {
            mobileMenu.classList.remove('opacity-0');
            mobileMenuContent.classList.remove('scale-95');
            mobileMenuContent.classList.add('scale-100');
        }, 10);
    } else {
        mobileMenu.classList.add('opacity-0');
        mobileMenuContent.classList.remove('scale-100');
        mobileMenuContent.classList.add('scale-95');

        setTimeout(() => {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
        }, 300);
    }
}

// Close mobile menu on click outside
document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu && e.target === mobileMenu && !mobileMenu.classList.contains('hidden')) {
        toggleMobileMenu();
    }
});

// Close mobile menu on ESC key
document.addEventListener('keydown', (e) => {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu && !mobileMenu.classList.contains('hidden') && e.key === 'Escape') {
        toggleMobileMenu();
    }
});

// Track flipbook view and open
function trackAndOpenFlipbook(tabloidId) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch(`/tabloid/view/${tabloidId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
    }).catch(() => {});
}

// Attach data-attribute event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    document.querySelectorAll('[data-toggle="mobile-menu"]').forEach((el) => {
        el.addEventListener('click', (e) => {
            toggleMobileMenu();
        });
    });

    // Flipbook tracking
    document.querySelectorAll('[data-track-flipbook]').forEach((el) => {
        el.addEventListener('click', () => {
            trackAndOpenFlipbook(el.dataset.trackFlipbook);
        });
    });

    // Video modal
    document.querySelectorAll('[data-open-video]').forEach((el) => {
        el.addEventListener('click', () => {
            openVideo(el.dataset.openVideo);
        });
    });

    document.querySelectorAll('[data-close-video]').forEach((el) => {
        el.addEventListener('click', () => {
            closeVideo();
        });
    });
});

// ================= VIDEO MODAL =================

function getYouTubeEmbedUrl(url) {
    if (!url) return '';
    if (url.includes('youtube.com/embed/')) return url;
    if (url.includes('youtu.be/')) {
        const videoId = url.split('youtu.be/')[1].split('?')[0];
        return 'https://www.youtube.com/embed/' + videoId;
    }
    if (url.includes('youtube.com/watch')) {
        const videoId = url.split('v=')[1].split('&')[0];
        return 'https://www.youtube.com/embed/' + videoId;
    }
    return url;
}

function openVideo(videoUrl) {
    const videoModal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const videoContent = document.getElementById('videoContent');

    if (!videoModal || !videoFrame || !videoContent) {
        console.error('Video modal elements not found');
        return;
    }

    const embedUrl = getYouTubeEmbedUrl(videoUrl);
    videoFrame.src = embedUrl;
    videoModal.classList.remove('hidden');
    videoModal.classList.add('flex');

    setTimeout(() => {
        videoModal.classList.remove('opacity-0');
        videoContent.classList.remove('scale-95');
        videoContent.classList.add('scale-100');
    }, 10);
}

function closeVideo() {
    const videoModal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const videoContent = document.getElementById('videoContent');

    if (!videoModal || !videoFrame || !videoContent) return;

    videoModal.classList.add('opacity-0');
    videoContent.classList.remove('scale-100');
    videoContent.classList.add('scale-95');

    setTimeout(() => {
        videoModal.classList.add('hidden');
        videoModal.classList.remove('flex');
        videoFrame.src = '';
    }, 300);
}

// Close video modal on click outside
document.addEventListener('click', (e) => {
    const videoModal = document.getElementById('videoModal');
    if (videoModal && e.target === videoModal && !videoModal.classList.contains('hidden')) {
        closeVideo();
    }
});

// Close video modal on ESC key
document.addEventListener('keydown', (e) => {
    const videoModal = document.getElementById('videoModal');
    if (!videoModal || videoModal.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeVideo();
});
