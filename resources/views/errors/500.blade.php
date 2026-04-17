@extends('errors.layout')

@section('title', 'Server Error')

@section('icon')
    <span class="icon-[solar--server-square-cloud-broken] w-16 h-16"></span>
@endsection

@section('code', '500')

@section('message', 'Terjadi Kesalahan Server')

@section('description')
    Maaf, terjadi kesalahan internal pada server kami. Mohon coba beberapa saat lagi atau hubungi administrator jika masalah berlanjut.
@endsection
