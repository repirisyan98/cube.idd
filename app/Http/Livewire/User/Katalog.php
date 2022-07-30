<?php

namespace App\Http\Livewire\User;

use App\Models\DetailPemesanan;
use App\Models\Produk;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Katalog extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'canceled',
    ];

    public $readyToLoad, $paginateLimit, $search;

    public function mount()
    {
        $this->readyToLoad = false;
        $this->paginateLimit = 15;
        $this->search = '';
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
        $produk_id = DetailPemesanan::whereHas('pemesanan', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->latest()->value('produk_id');
        $kategori_id = Produk::where('id', $produk_id)->value('kategori_id');
        return view('livewire.user.katalog', [
            'data' => $this->readyToLoad ? Produk::with('detail_pemesanan')->orWhereHas('detail_pemesanan', function (Builder $query) {
                return $query->selectRaw('COUNT(*) as terjual');
            })->when($this->search != null, function ($query) {
                return $query->where('nama_produk', 'like', '%' . $this->search . '%');
            })->where('stok', '>', 0)->simplePaginate($this->paginateLimit) : [],
            'rekomendasi' => $this->readyToLoad ? Produk::with('detail_pemesanan')->where('stok', '>', 0)->where('kategori_id', $kategori_id)->limit(4)->get() : [],
        ]);
    }
}