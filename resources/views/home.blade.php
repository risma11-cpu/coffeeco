@extends('layouts.app')

@section('title', 'Coffee & Co. — Jeda kecil. Rasa yang tinggal.')

@section('content')

    {{-- Navbar hamburger: hanya tampil di layar kecil, menempel di atas saat scroll --}}
    <x-mobile-nav :brand="$brand" :nav="$nav" />

    <x-hero :brand="$brand" :nav="$nav" :hero="$hero" />

    <x-menu :menu="$menu" />

    <x-favorite :spotlight="$spotlight" />

    <x-about />

    <x-why />

    <x-contact :contact="$contact" />

    <x-footer />

@endsection