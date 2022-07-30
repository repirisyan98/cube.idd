<div wire:init='loadPosts'>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <a href="{{ route('kelola.transaksi') }}"><i class="bx bx-arrow-from-right"></i> Kembali</a>
                </div>
                <div class="col">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" wire:model.lazy='search' type="search"
                            placeholder="Cari Produk..." aria-label="Search">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="5" class="text-center">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </td>
                            </tr>
                        @else
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->produk->nama_produk }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->keterangna ?? 'Tidak ada keterangan' }}</td>
                                    <td>
                                        @switch($item->status)
                                            @case(0)
                                                <button wire:click='triggerProses("{{ $item->id }}")'
                                                    class="btn btn-success btn-sm">Proses</button>
                                            @break

                                            @case(1)
                                                <button wire:click='$set("temp_id","{{ $item->id }}")'
                                                    data-bs-toggle="modal" data-bs-target="#modalKirim"
                                                    class="btn btn-success btn-sm">Kirim</button>
                                            @break

                                            @default
                                                Tidak ada Aksi
                                        @endswitch
                                    </td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Tidak Ada Data
                                        </td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Kirim Barang-->
        <div wire:ignore.self class="modal fade" id="modalKirim" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalKirim" aria-hidden="true">
            <div class="modal-dialog">
                <form wire:submit.prevent='kirim_barang'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modal Kirim Barang</h5>
                            <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input required class="form-control @error('resi') is-invalid @enderror" type="text"
                                    wire:model.defer='resi' placeholder="resi" aria-label="resi">
                                @error('resi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click='resetFields' class="btn btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
