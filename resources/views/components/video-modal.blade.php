<!-- ================= VIDEO MODAL ================= -->
<div id="videoModal" class="fixed inset-0 bg-polri-black/95 hidden items-center justify-center z-[1000] backdrop-blur-md opacity-0 transition-opacity duration-300">
    <div class="bg-polri-black rounded-2xl overflow-hidden w-full max-w-4xl relative shadow-2xl border border-polri-gold/30 transform scale-95 transition-transform duration-300" id="videoContent">
        <button onclick="closeVideo()" class="absolute -top-14 right-0 text-white text-3xl font-black hover:text-polri-gold transition focus:outline-none p-2">✕</button>
        <div class="aspect-video w-full">
            <iframe id="videoFrame" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>

<!-- ================= VIDEO MODAL SCRIPTS ================= -->
<script>
    // Helper function to convert YouTube URL to embed format
    function getYouTubeEmbedUrl(url) {
        if (!url) return '';

        // If already embed URL, return as is
        if (url.includes('youtube.com/embed/')) {
            return url;
        }

        // If short URL (youtu.be), convert to embed
        if (url.includes('youtu.be/')) {
            var videoId = url.split('youtu.be/')[1].split('?')[0];
            return 'https://www.youtube.com/embed/' + videoId;
        }

        // If watch URL, convert to embed
        if (url.includes('youtube.com/watch')) {
            var videoId = url.split('v=')[1].split('&')[0];
            return 'https://www.youtube.com/embed/' + videoId;
        }

        // If not YouTube, return original URL
        return url;
    }

    // Video Modal Functionality
    function openVideo(videoUrl) {
        var videoModal = document.getElementById('videoModal');
        var videoFrame = document.getElementById('videoFrame');
        var videoContent = document.getElementById('videoContent');

        if (!videoModal || !videoFrame || !videoContent) {
            console.error('Video modal elements not found');
            return;
        }

        var embedUrl = getYouTubeEmbedUrl(videoUrl);
        videoFrame.src = embedUrl;
        videoModal.classList.remove('hidden');
        videoModal.classList.add('flex');

        setTimeout(function() {
            videoModal.classList.remove('opacity-0');
            videoContent.classList.remove('scale-95');
            videoContent.classList.add('scale-100');
        }, 10);
    }

    function closeVideo() {
        var videoModal = document.getElementById('videoModal');
        var videoFrame = document.getElementById('videoFrame');
        var videoContent = document.getElementById('videoContent');

        if (!videoModal || !videoFrame || !videoContent) {
            return;
        }

        videoModal.classList.add('opacity-0');
        videoContent.classList.remove('scale-100');
        videoContent.classList.add('scale-95');

        setTimeout(function() {
            videoModal.classList.add('hidden');
            videoModal.classList.remove('flex');
            videoFrame.src = '';
        }, 300);
    }

    // Global functions for onclick handlers
    window.openVideo = openVideo;
    window.closeVideo = closeVideo;

    // Close video modal on click outside
    document.addEventListener('click', function(e) {
        var videoModal = document.getElementById('videoModal');
        if (videoModal && e.target === videoModal && !videoModal.classList.contains('hidden')) {
            closeVideo();
        }
    });

    // Keyboard navigation for video modal
    document.addEventListener('keydown', function(e) {
        var videoModal = document.getElementById('videoModal');
        if (!videoModal || videoModal.classList.contains('hidden')) return;

        if (e.key === 'Escape') {
            closeVideo();
        }
    });
</script>
