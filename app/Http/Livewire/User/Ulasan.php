<?php

namespace App\Http\Livewire\User;

use App\Models\DetailPemesanan;
use App\Models\Ulasan as ModelsUlasan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Ulasan extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $readyToLoad, $temp_id, $rating, $produk_id, $foto, $keterangan;

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.user.ulasan', [
            'data' => $this->readyToLoad ? DetailPemesanan::with('produk', 'pemesanan')->whereHas('pemesanan', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->where('status', "3")->get() : []
        ]);
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }

    public function set_id($id, $produk_id)
    {
        $this->temp_id = $id;
        $this->produk_id = $produk_id;
    }

    public function ulasan()
    {
        try {
            $this->validate([
                'foto' => 'required|image',
            ]);
            $extension = $this->foto->extension();
            $filename = date('Y-m-d-H_i_s') . '.' . $extension;
            ModelsUlasan::create([
                'produk_id' => $this->produk_id,
                'user_id' => auth()->user()->id,
                'tanggal' => date('Y-m-d'),
                'rating' => $this->rating,
                'keterangan' => $this->keterangan,
                'picture' => $filename,
            ]);
            DetailPemesanan::find($this->temp_id)->update([
                'status' => "4",
            ]);
            $this->foto->storeAs('public/reviews', $filename);
            $this->alert(
                'success',
                'Produk berhasil diulas'
            );
        } catch (\Throwable $th) {
            dd($th);
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('ulas');
        $this->emit('ulas');
        $this->resetFields();
    }
}