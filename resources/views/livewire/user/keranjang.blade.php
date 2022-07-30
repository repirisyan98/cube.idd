<div wire:init='loadPosts'>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if (empty($data))
        <span class="text-center spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    @else
        @php
            $berat1 = 0;
            $no = 0;
            $total_barang = 0;
            $total_harga1 = 0;
        @endphp
        <h5><b>Keranjang</b></h5>
        <div class="row">
            <div class="col-md-{{ $data->count() > 0 ? '8' : '12' }}">
                @forelse ($data as $item)
                    @if ($item->produk->stok > 0)
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
                                        <p><b>Rp.{{ number_format($harga, 0, ',', '.') }}</b>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <button
                                                    wire:click="triggerConfirm('{{ $item->id }}','{{ $no }}')"
                                                    href="#" class="btn"><i class="bx bx-trash"></i></button>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-spinner">
                                                    <button
                                                        wire:click='increment_qty("{{ $item->id }}","{{ $item->produk->stok }}","{{ $item->qty }}")'
                                                        class="btn btn-white" type="button" id="button-plus"> +
                                                    </button>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->qty }}" min="1"
                                                        max="{{ $item->produk->stok }}">
                                                    <button
                                                        wire:click='decrement_qty("{{ $item->id }}","{{ $item->qty }}")'
                                                        class="btn btn-white" type="button" id="button-minus"> −
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @php
                        $this->ids[$no] = $item->produk_id;
                        $this->qty[$no] = $item->qty;
                        $berat1 += $item->qty * $item->produk->berat;
                        $total_barang += $item->qty;
                        $total_harga1 += $item->qty * $harga;
                        $no++;
                    @endphp
                @empty
                    <div class="text-center">
                        <h5>Wah, Keranjang belanjaanmu kosong</h5>
                        <br>
                        <p class="text-muted">Yuk, isi dengan barang-barang impianmu!</p>
                        <a href="{{ route('katalog') }}" class="btn btn-primary">Mulai Belanja</a>
                    </div>
                @endforelse
                @php
                    $this->berat = $berat1;
                    $this->total_harga = $total_harga1;
                @endphp
            </div>
            @if ($data->count() > 0)
                <div class="col-md-4 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <p><b>Ringkasan Belanja</b></p>
                            <p>Total Harga ({{ $total_barang }} Barang) :
                                Rp. <b>{{ number_format($total_harga, 0, ',', '.') }}</b>
                            </p>
                            @if ($ongkir != null)
                                <p>Total Ongkir JNE :
                                    Rp. <b>{{ number_format($ongkir, 0, ',', '.') }}</b>
                                </p>
                                <hr>
                                <p>Total Pembayaran :
                                    Rp.
                                    <b>{{ number_format($ongkir + $total_harga, 0, ',', '.') }}</b>
                                </p>
                            @endif
                            <div class="d-grid gap-2">
                                <button wire:click='get_ongkir()' class="btn btn-block btn-outline-success">Cek
                                    Ongkir</button>
                                <button wire:click='triggerConfirmPay()'
                                    class="btn btn-block btn-outline-success">Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
