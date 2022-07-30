@extends('layouts.app')
@section('title', 'Pembayaran')
@section('style')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            @livewire('user.pembayaran', ['id' => $id])
        </div>
    </div>
@endsection
@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    @stack('scripts')
@endsection
