@extends('layouts.app')
@section('title', 'Kelola Produk')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('admin.kelola-produk')
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.livewire.on('store', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('update', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@endsection
