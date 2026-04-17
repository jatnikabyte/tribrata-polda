<!-- ================= VIDEO MODAL ================= -->
<div id="videoModal" class="fixed inset-0 bg-polri-black/95 hidden items-center justify-center z-[1000] backdrop-blur-md opacity-0 transition-opacity duration-300">
    <div class="bg-polri-black rounded-2xl overflow-hidden w-full max-w-4xl relative shadow-2xl border border-polri-gold/30 transform scale-95 transition-transform duration-300" id="videoContent">
        <button data-close-video class="absolute -top-14 right-0 text-white text-3xl font-black hover:text-polri-gold transition focus:outline-none p-2">✕</button>
        <div class="aspect-video w-full">
            <iframe id="videoFrame" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>
