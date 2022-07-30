<?php

namespace App\Http\Livewire\User;

use App\Models\Keranjang;
use App\Models\Produk;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetailProduct extends Component
{
    use LivewireAlert;


    public $readyToLoad, $temp_id, $qty, $ukuran;

    public function mount($id)
    {
        $this->readyToLoad = false;
        $this->temp_id = $id;
        $this->qty = 1;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.user.detail-product', [
            'data' => $this->readyToLoad ? Produk::with('ulasan')->where('id', $this->temp_id)->first() : [],
        ]);
    }

    public function add_to_cart()
    {
        try {
            Keranjang::updateOrCreate([
                'user_id' => auth()->user()->id,
                'produk_id' => $this->temp_id,
            ], [
                'user_id' => auth()->user()->id,
                'produk_id' => $this->temp_id,
                'qty' => $this->qty,
                'ukuran' => $this->ukuran,
            ]);
            return redirect()->to('/keranjang');
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
    }
}