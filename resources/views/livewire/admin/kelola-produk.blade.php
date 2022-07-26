<div wire:init='loadPosts'>
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah <i
                            class="bx bx-plus"></i></button>
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
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="6" class="text-center">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $key }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->kategori->nama }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td></td>
                                    <td>
                                        <button wire:click='edit("{{ $item->id }}")' data-bs-toggle="modal"
                                            data-bs-target="#modalUbah" class="btn btn-warning"><i
                                                class="bx bx-pencil"></i></button>
                                        <button class="btn btn-danger" wire:loading.attr="disabled"
                                            wire:click="triggerConfirm('{{ $item->id }}','{{ $item->gambar }}')"><i
                                                class="bx bx-x"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
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
    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent='store' enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Tambah</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input required class="form-control @error('nama_produk') is-invalid @enderror"
                                type="text" wire:model.defer='nama_produk' placeholder="Nama Produk"
                                aria-label="nama_produk">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select @error('kategori_id') is-invalid @enderror"
                                wire:model.defer='kategori_id' required>
                                <option value="" selected>-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" cols="30" rows="10" required
                                wire:model.defer='keterangan'></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('discount') is-invalid @enderror" type="number"
                                wire:model.defer='discount' placeholder="Diskon" aria-label="discount">
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('stok') is-invalid @enderror" type="number"
                                wire:model.defer='stok' placeholder="Stok" aria-label="stok">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('harga') is-invalid @enderror" type="number"
                                wire:model.defer='harga' placeholder="Harga" aria-label="harga">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('berat') is-invalid @enderror" type="number"
                                wire:model.defer='berat' placeholder="Berat" aria-label="berat">
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('gambar') is-invalid @enderror" type="file"
                                wire:model.defer='gambar'aria-label="gambar">
                            @error('gambar')
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

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modalUbah" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent='update' enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Ubah</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input required class="form-control @error('nama_produk') is-invalid @enderror"
                                type="text" wire:model.defer='nama_produk' placeholder="Nama Produk"
                                aria-label="nama_produk">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select @error('kategori_id') is-invalid @enderror"
                                wire:model.defer='kategori_id' required>
                                <option value="" selected>-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" cols="30" rows="10" required
                                wire:model.defer='keterangan'></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('discount') is-invalid @enderror"
                                type="number" wire:model.defer='discount' placeholder="Diskon"
                                aria-label="discount">
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('stok') is-invalid @enderror" type="number"
                                wire:model.defer='stok' placeholder="Stok" aria-label="stok">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('harga') is-invalid @enderror" type="number"
                                wire:model.defer='harga' placeholder="Harga" aria-label="harga">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('berat') is-invalid @enderror" type="number"
                                wire:model.defer='berat' placeholder="Berat" aria-label="berat">
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('new_pict') is-invalid @enderror"
                                type="file" wire:model.defer='new_pict'aria-label="new_pict">
                            @error('new_pict')
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
