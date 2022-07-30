<?php

namespace App\Http\Livewire\User;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Pembelian extends Component
{
    use LivewireAlert;

    public $readyToLoad, $page_limit, $temp_id;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function mount()
    {
        $this->page_limit = 15;
        $this->readyToLoad = false;
    }

    protected $listeners = [
        'selesai',
        'canceled',
    ];


    public function render()
    {
        return view('livewire.user.pembelian', [
            'pembayaran' => Pemesanan::where('status', "0")->get(),
            'data' => $this->readyToLoad ? DetailPemesanan::with('produk')->whereHas('pemesanan', function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })->orderBy('status', 'asc')->simplePaginate($this->page_limit) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetExcept('page_limit', 'readyToLoad');
    }

    public function triggerSelesai($id)
    {
        $this->confirm('Selesaikan pesanan ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Selesai',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'selesai',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
        $this->temp_id = $id;
    }

    public function selesai()
    {
        // Example code inside confirmed callback
        try {
            DetailPemesanan::find($this->temp_id)->update([
                'status' => "3",
            ]);
            $this->alert(
                'success',
                'Pesanan berhasil diselesaikan'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat memproses data'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}