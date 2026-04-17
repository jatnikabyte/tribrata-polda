@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')

@section('icon')
    <span class="icon-[solar--confounded-square-broken] w-16 h-16"></span>
@endsection

@section('code', '404')

@section('message', 'Oops! Halaman tidak ditemukan.')

@section('description')
    Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin telah dihapus, nama diubah, atau sementara tidak tersedia.
@endsection
