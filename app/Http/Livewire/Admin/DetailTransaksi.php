<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetailPemesanan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetailTransaksi extends Component
{
    use LivewireAlert;

    public $readyToLoad, $pemesanan_id, $temp_id, $resi;

    protected $listeners = [
        'procced',
        'canceled',
    ];

    public function mount($id)
    {
        $this->readyToLoad = false;
        $this->pemesanan_id = $id;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad', 'pemesanan_id');
    }

    public function render()
    {
        return view('livewire.admin.detail-transaksi', [
            'data' => $this->readyToLoad ? DetailPemesanan::with('produk')->where('pemesanan_id', $this->pemesanan_id)->get() : [],
        ]);
    }

    public function kirim_barang()
    {
        try {
            DetailPemesanan::where('id', $this->temp_id)->update([
                'status' => "2",
                'no_resi' => $this->resi,
            ]);
            $this->alert(
                'success',
                'No resi telah di update'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat memproses data'
            );
        }
        $this->dispatchBrowserEvent('kirim');
        $this->emit('kirim');
        $this->resetFields();
    }

    public function triggerProses($id)
    {
        $this->confirm('Proses item ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'procced',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
        $this->temp_id = $id;
    }

    public function procced()
    {
        // Example code inside confirmed callback
        try {
            DetailPemesanan::where('id', $this->temp_id)->update([
                'status' => "1",
            ]);
            $this->alert(
                'success',
                'Data berhasil diproses'
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