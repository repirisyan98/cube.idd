<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Dipantry\Rajaongkir\Models\ROCity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;

    public $name, $foto, $rajaongkir_citie_id, $alamat, $new_pict, $password, $password_confirmation;
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->foto = auth()->user()->foto;
        $this->rajaongkir_citie_id = auth()->user()->rajaongkir_citie_id;
        $this->alamat = auth()->user()->alamat;
    }
    public function render()
    {
        return view('livewire.profile', [
            'kota' => ROCity::all(),
        ]);
    }

    public function update_profile()
    {
        $this->validate([
            'new_pict' => 'image|nullable'
        ]);

        try {
            if ($this->new_pict != null) {
                if ($this->foto != "default.png") {
                    Storage::delete('public/users/' . $this->foto);
                }
                $extension = $this->new_pict->extension();
                $filename = date('Y-m-d-H_i_s') . '.' . $extension;
                $this->new_pict->storeAs('public/users', $filename);
                $this->foto = $filename;
            }
            User::where('id', auth()->user()->id)->update([
                'name' => $this->name,
                'alamat' => $this->alamat,
                'rajaongkir_citie_id' => $this->rajaongkir_citie_id,
                'foto' => $this->foto
            ]);
            $this->alert(
                'success',
                "Foto Profile berhasil diubah"
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat mengubah data"
            );
        }
    }

    public function change_password()
    {
        $this->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        try {
            User::find(auth()->user()->id)->update([
                'password' => Hash::make($this->password),
                'updated_at' => now()
            ]);
            $this->alert(
                'success',
                "Password berhasil diubah"
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat mengubah data"
            );
        }
        $this->reset('password', 'password_confirmation');
    }
}