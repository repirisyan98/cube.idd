<div wire:init='loadPosts'>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
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
                            <th>keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="3" class="text-center">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </td>
                            </tr>
                        @else
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->produk->nama_produk }}</td>
                                    <td>
                                        <button wire:click='set_id("{{ $item->id }}","{{ $item->produk->id }}")'
                                            data-bs-toggle="modal" data-bs-target="#modalUlas"
                                            class="btn btn-outline-success"><i class="bx bx-pencil"></i></button>
                                    </td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
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

    <!-- Modal Ulas-->
    <div wire:ignore.self class="modal fade" id="modalUlas" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent='ulasan' enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Ulasan</h5>
                        <button type="button" wire:click='resetFields' class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Rating</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="inlineRadio1" type="radio" value="1"
                                    wire:lazy='rating'>
                                <label class="form-check-label" for="inlineRadio1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="inlineRadio2" type="radio"
                                    wire:model.lazy='rating' value="2">
                                <label class="form-check-label" for="inlineRadio2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="inlineRadio3" type="radio"
                                    wire:model.lazy='rating' value="3">
                                <label class="form-check-label" for="inlineRadio2">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="inlineRadio4" type="radio"
                                    wire:model.lazy='rating' value="4">
                                <label class="form-check-label" for="inlineRadio2">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="inlineRadio5" type="radio"
                                    wire:model.lazy='rating' value="5">
                                <label class="form-check-label" for="inlineRadio2">5</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input required class="form-control @error('foto') is-invalid @enderror" type="file"
                                wire:model.defer='foto' placeholder="foto" aria-label="foto">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea required placeholder="Berikan ulasan" class="form-control @error('keterangan') is-invalid @enderror"
                                wire:model.defer='keterangan' cols="30" rows="10"></textarea>
                            @error('keterangan')
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
