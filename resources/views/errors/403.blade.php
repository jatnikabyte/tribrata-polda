@extends('errors.layout')

@section('title', 'Akses Ditolak')

@section('icon')
    <span class="icon-[solar--shield-warning-broken] w-16 h-16"></span>
@endsection

@section('code', '403')

@section('message', 'Akses Ditolak')

@section('description')
    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah sebuah kesalahan.
@endsection
