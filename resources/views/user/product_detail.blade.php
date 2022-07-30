@extends('layouts.app')
@section('title', 'Detail Produk')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('user.detail-product', ['id' => $id])
        </div>
    </div>
@endsection
@section('script')
    {{-- <script>
        window.livewire.on('store', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('update', () => {
            $('#modalUbah').modal('hide');
        });
    </script> --}}
@endsection
