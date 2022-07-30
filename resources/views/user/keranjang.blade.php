@extends('layouts.app')
@section('title', 'Keranjang')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('user.keranjang')
        </div>
    </div>
@endsection
@section('script')
    @stack('scripts')
    {{-- <script>
        window.livewire.on('store', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('update', () => {
            $('#modalUbah').modal('hide');
        });
    </script> --}}
@endsection
