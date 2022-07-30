<div wire:init='loadPosts'>
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-header">
            <div class="row float-end">
                <div class="col">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" wire:model.lazy='search' type="search"
                            placeholder="Cari Invoice..." aria-label="Search">
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
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Total Pembayaran</th>
                            <th>Detail Pembeli</th>
                            <th>Detail Item</th>
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
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $key }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->invoice }}</td>
                                    <td>Rp.{{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                                    <td>
                                        <a wire:click='detail_pembeli("{{ $item->user_id }}")' href="#"
                                            data-bs-toggle="modal" data-bs-target="#modalDetailPembeli">Lihat</a>
                                    </td>
                                    <td><a href="{{ route('detail.transaksi', $item->id) }}">Lihat</a></td>
                                </tr>
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
            @if ($readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Pembeli-->
    <div wire:ignore.self class="modal fade" id="modalDetailPembeli" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modalDetailPembeli" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent='store'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Detail Pembeli</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless text-center">
                            @if ($pembeli != null)
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $pembeli->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $pembeli->email }}</td>
                                </tr>
                                <tr>
                                    <td>Telefon</td>
                                    <td>:</td>
                                    <td>{{ $pembeli->telefon }}</td>
                                </tr>
                                <tr>
                                    <td>Kota</td>
                                    <td>:</td>
                                    <td>{{ $pembeli->rajaongkir_citie->name }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $pembeli->alamat }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <img style="width: 100px;height: 100px"
                                            src="{{ asset('storage/users/' . $pembeli->foto) }}" alt="">
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='resetFields' class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
