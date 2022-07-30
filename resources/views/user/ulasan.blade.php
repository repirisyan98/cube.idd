@extends('layouts.app')
@section('title', 'Ulasan Produk')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('user.ulasan')
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.livewire.on('ulas', () => {
            $('#modalUlas').modal('hide');
        });
    </script>
@endsection
