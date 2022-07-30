<div>
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <form wire:submit.prevent='update_profile'>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input required wire:model.defer='name' type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <select class="form-control" wire:model.defer='rajaongkir_citie_id'>
                                <option value="">-- Pilih Kota --</option>
                                @foreach ($kota as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" wire:model.defer="alamat" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" wire:model.defer='new_pict' class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success float-end">Ubah Profile</button>
                    </form>
                </div>
                <div class="col">
                    <form wire:submit.prevent="change_password">
                        <div class="row g-3">
                            <div class=" col-12">
                                <label for="inputChoosePassword" class="form-label">Password Baru</label>
                                <div class="input-group" id="show_hide_password">
                                    <input id="password" placeholder="Password Baru" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        wire:model.defer='password' required>
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                            class='bx bx-hide'></i></a>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputChoosePassword" class="form-label">Konfirmasi
                                    Password</label>
                                <div class="input-group" id="show_hide_password2">
                                    <input id="password" placeholder="Konfirmasi Password" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        wire:model.defer="password_confirmation" required>
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                            class='bx bx-hide'></i></a>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-inline">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-edit"></i>
                                        Ubah Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
