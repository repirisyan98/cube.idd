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

    public $readyToLoad, $page_number;

    public function mount()
    {
        $this->readyToLoad = false;
        $this->page_number = 15;
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
        // $kategori_id = null;
        // $produk_id = DetailPemesanan::with(['pemesanan', 'produk'])->whereIn('status', ["3", "4"])->whereHas('pemesanan', function ($query) {
        //     $query->where('user_id', auth()->user()->id);
        // })->whereHas('produk', function ($query) {
        //     $query->select('id')->groupBy('kategori_id');
        // })->get();

        // dd($produk_id);
        return view('livewire.user.katalog', [
            'data' => $this->readyToLoad ? Produk::with('detail_pemesanan')->orWhereHas('detail_pemesanan', function (Builder $query) {
                return $query->selectRaw('COUNT(*) as terjual');
            })->where('stok', '>', 0)->simplePaginate($this->page_number) : [],
        ]);
    }
}