<?php

namespace App\Http\Livewire\User;

use App\Models\Produk;
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
        return view('livewire.user.katalog', [
            'data' => $this->readyToLoad ? Produk::where('stok', '>', 0)->simplePaginate($this->page_number) : [],
        ]);
    }
}