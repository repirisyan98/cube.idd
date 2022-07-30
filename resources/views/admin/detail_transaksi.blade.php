@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('admin.detail-transaksi', ['id' => $id])
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.livewire.on('kirim', () => {
            $('#modalKirim').modal('hide');
        });
    </script>
@endsection
