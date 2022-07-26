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
                            placeholder="Cari Kategori..." aria-label="Search">
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
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="4" class="text-center">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $key }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        <button wire:click='edit("{{ $item->id }}")' data-bs-toggle="modal"
                                            data-bs-target="#modalUbah" class="btn btn-warning"><i
                                                class="bx bx-pencil"></i></button>
                                        <button class="btn btn-danger" wire:loading.attr="disabled"
                                            wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                class="bx bx-x"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
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
            <form wire:submit.prevent='store'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Tambah</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input required class="form-control @error('nama') is-invalid @enderror" type="text"
                                wire:model.defer='nama' placeholder="Nama" aria-label="Nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea required class="form-control @error('nama') is-invalid @enderror" wire:model.defer='deskripsi' cols="30"
                                rows="10"></textarea>
                            @error('deskripsi')
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
            <form wire:submit.prevent='update'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Ubah</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input required class="form-control @error('nama') is-invalid @enderror" type="text"
                                wire:model.defer='nama' placeholder="Nama" aria-label="Nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea required class="form-control @error('deskripsi') is-invalid @enderror" wire:model.defer='deskripsi'
                                cols="30" rows="10"></textarea>
                            @error('deskripsi')
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
