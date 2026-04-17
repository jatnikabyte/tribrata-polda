<x-emails.layout 
    title="{{ $action === 'update_password' ? 'Ubah Password' : 'Ubah Profil' }}" 
    :greeting="'Halo, ' . $name . '!'"
    headerTagline="Verifikasi Perubahan"
>
    @if($action === 'update_password')
        <p>Kami menerima permintaan untuk mengubah password akun Anda. Untuk melanjutkan, masukkan kode verifikasi berikut:</p>
    @else
        <p>Kami menerima permintaan untuk mengubah profil akun Anda. Untuk melanjutkan, masukkan kode verifikasi berikut:</p>
    @endif
    
    <div class="highlight-box">
        {{ $token }}
    </div>
    
    <div class="info-box warning">
        <strong>⏰ Penting:</strong> Kode verifikasi ini akan kadaluarsa dalam <strong>15 menit</strong>. 
        Jika Anda tidak melakukan permintaan ini, segera abaikan email ini dan amankan akun Anda.
    </div>
    
    <div class="info-box">
        <strong>🔒 Tips Keamanan:</strong>
        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
            <li>Jangan bagikan kode ini kepada siapapun</li>
            <li>Tim kami tidak akan pernah meminta kode verifikasi</li>
        </ul>
    </div>
    
    <p>Jika Anda mengalami kesulitan, silakan hubungi tim dukungan kami.</p>
</x-emails.layout>
