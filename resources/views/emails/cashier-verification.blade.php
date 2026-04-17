<x-emails.layout 
    title="Verifikasi Email Kasir" 
    :greeting="'Halo, ' . $name . '!'"
    headerTagline="Akun Kasir Baru"
>
    <p>Selamat! Akun kasir Anda telah Dibuat pemilik outlet.</p>
    
    <p>Untuk mulai menggunakan aplikasi, silakan verifikasi email Anda dengan memasukkan kode berikut:</p>
    
    <div class="highlight-box">
        {{ $token }}
    </div>
    
    <div class="info-box warning">
        <strong>⏰ Penting:</strong> Kode verifikasi ini akan kadaluarsa dalam <strong>15 menit</strong>.
    </div>
    
    <p><strong>Langkah selanjutnya:</strong></p>
    <ol style="margin-left: 20px; color: #4B5563;">
        <li>Buka aplikasi di perangkat Anda</li>
        <li>Login dengan email dan password yang diberikan</li>
        <li>Masukkan kode verifikasi di atas</li>
        <li>Mulai bekerja!</li>
    </ol>
    
    <div class="divider"></div>
    
    <p style="font-size: 13px; color: #9CA3AF;">
        Jika Anda tidak merasa didaftarkan sebagai kasir, abaikan email ini atau hubungi pemilik outlet.
    </p>
</x-emails.layout>
