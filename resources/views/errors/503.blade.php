@extends('errors.layout')

@section('title', 'Layanan Tidak Tersedia')

@section('icon')
    <span class="icon-[solar--clock-circle-broken] w-16 h-16"></span>
@endsection

@section('code', '503')

@section('message', 'Sedang Dalam Pemeliharaan')

@section('description')
    Maaf, layanan kami sedang dalam pemeliharaan rutin. Kami akan segera kembali beroperasi normal. Terima kasih atas pengertiannya.
@endsection
