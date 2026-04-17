<x-emails.layout 
    title="Verifikasi Email" 
    :greeting="'Halo, ' . $name . '!'"
    headerTagline="Verifikasi Akun"
>
    <p>Terima kasih telah mendaftar. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan memasukkan kode berikut:</p>
    
    <div class="highlight-box">
        {{ $token }}
    </div>
    
    <div class="info-box warning">
        <strong>⏰ Penting:</strong> Kode verifikasi ini akan kadaluarsa dalam <strong>15 menit</strong>. 
        Jika Anda tidak melakukan pendaftaran ini, abaikan email ini.
    </div>
    
    <p>Jika Anda mengalami kesulitan, silakan hubungi tim dukungan kami.</p>
</x-emails.layout>
