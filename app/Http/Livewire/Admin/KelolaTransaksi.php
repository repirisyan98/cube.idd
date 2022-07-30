<?php

namespace App\Http\Livewire\Admin;

use App\Models\Pemesanan;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaTransaksi extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $readyToLoad, $pembeli, $search;

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }
    public function render()
    {
        return view('livewire.admin.kelola-transaksi', [
            'data' => $this->readyToLoad ? Pemesanan::when($this->search != null, function ($query) {
                return $query->where('invoice', 'like', '%' . $this->search . '%');
            })->where('status', "1")->simplePaginate(15) : []
        ]);
    }

    public function detail_pembeli($id)
    {
        $this->pembeli = User::with('rajaongkir_citie')->where('id', $id)->first();
    }
}