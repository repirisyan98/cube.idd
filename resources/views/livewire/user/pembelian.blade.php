<div wire:init='loadPosts'>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @if ($pembayaran->count() > 0)
        <button class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalDetail">Pemesanan Belum di bayar
            <i class="bx bx-bell"></i></button>
    @endif
    @if (empty($data))
        <span class="text-center spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    @else
        <div class="row">
            @forelse ($data as $item)
                <hr>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <img style="width: 100px;height: 100px"
                                    src="{{ asset('storage/product/' . $item->produk->gambar) }}" alt=""
                                    srcset="">
                            </div>
                            <div class="col-md-9">
                                @php
                                    $harga = $item->produk->harga - ($item->produk->harga * $item->produk->discount) / 100;
                                @endphp
                                <p>{{ $item->produk->nama_produk }}</p>
                                <p><b>Qty : {{ $item->qty }}</b></p>
                                <p><b>Total Pembayaran : Rp.{{ number_format($harga * $item->qty, 0, ',', '.') }}</b>
                                </p>
                                <p>No Resi : {{ $item->no_resi ?? '-' }}</p>
                                <p>
                                    @switch($item->status)
                                        @case(0)
                                            <span class="badge bg-primary"> Menunggu Konfirmasi</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-info">Di Proses</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-gradient-blues"> Di Kirim</span>
                                            <button wire:click='triggerSelesai("{{ $item->id }}")'
                                                class="btn btn-sm btn-outline-success">Selesaikan
                                                Pesanan</button>
                                        @break

                                        @case(3)
                                            <span class="badge bg-success">Selesai</span>
                                        @break

                                        @case(5)
                                            <span class="badge bg-danger">Gagal</span>
                                        @break

                                        @case(4)
                                            <span class="badge bg-success">Telah diulas</span>
                                        @break

                                        @default
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        @endif

        <!-- Modal Tambah-->
        <div wire:ignore.self class="modal fade" id="modalDetail" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="ModalTambah" aria-hidden="true">
            <div class="modal-dialog">
                <form wire:submit.prevent='store'>
                    <div class="modal-content">
                        <div class="modal-body">
                            <table class="table table-borderless">
                                @foreach ($pembayaran as $item)
                                    <tr>
                                        <td class="align-middle">{{ $item->invoice }}</td>
                                        <td class="align-middle">{{ $item->total_pembayaran }}</td>
                                        <td><a href="{{ route('pembayaran', $item->id) }}"
                                                class="btn btn-outline-success">Bayar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
