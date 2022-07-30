<?php

namespace App\Http\Livewire\Admin;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class KelolaProduk extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'canceled',
    ];

    public $readyToLoad, $edit_ukuran, $ukuran, $temp_id, $nama_produk, $kategori_id, $keterangan, $discount, $stok, $harga, $berat, $gambar, $new_pict;
    public $inputs = [];
    public $ukurans = [];
    public $i = -1;
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
        return view('livewire.admin.kelola-produk', [
            'data' => $this->readyToLoad ? Produk::with('kategori')->simplePaginate(15) : [],
            'kategori' => $this->readyToLoad ? Kategori::all() : []
        ]);
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
        array_push($this->ukurans, $this->ukuran);
        $this->reset('ukuran');
    }

    public function store()
    {
        $this->validate([
            'gambar' => 'required|image',
            'ukurans' => 'required'
        ]);
        $extension = $this->gambar->extension();
        $filename = now() . '.' . $extension;
        try {
            Produk::create([
                'nama_produk' => $this->nama_produk,
                'kategori_id' => $this->kategori_id,
                'keterangan' => $this->keterangan,
                'discount' => $this->discount,
                'stok' => $this->stok,
                'harga' => $this->harga,
                'berat' => $this->berat,
                'gambar' => $filename,
                'ukuran' => json_encode($this->ukurans),
            ]);
            $this->gambar->storeAs('public/product', $filename);
            $this->alert(
                'success',
                'Data berhasil disimpan'
            );
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('store');
        $this->emit('store');
        $this->resetFields();
    }

    public function edit($id)
    {
        $data = Produk::where('id', $id)->first();
        $this->temp_id = $id;
        $this->nama_produk = $data->nama_produk;
        $this->kategori_id = $data->kategori_id;
        $this->keterangan = $data->keterangan;
        $this->discount = $data->discount;
        $this->stok = $data->stok;
        $this->harga = $data->harga;
        $this->berat = $data->berat;
        $this->gambar = $data->gambar;
        $this->edit_ukuran = json_decode($data->ukuran);
    }

    public function update()
    {
        $this->validate([
            'new_pict' => 'image|nullable'
        ]);
        try {
            if ($this->new_pict != null) {
                Storage::delete('public/product/' . $this->gambar);
                $extension = $this->new_pict->extension();
                $filename = now() . '.' . $extension;
                $this->new_pict->storeAs('public/product', $filename);
                $this->gambar = $filename;
            }
            Produk::find($this->temp_id)->update([
                'nama_produk' => $this->nama_produk,
                'kategori_id' => $this->kategori_id,
                'keterangan' => $this->keterangan,
                'discount' => $this->discount,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'berat' => $this->berat,
                'gambar' => $this->gambar,
                'ukuran' => json_encode($this->edit_ukuran),
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('update');
        $this->emit('update');
        $this->resetFields();
    }

    public function triggerConfirm($id, $gambar)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
        $this->temp_id = $id;
        $this->gambar = $gambar;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Produk::destroy($this->temp_id);
            Storage::delete('public/product/' . $this->gambar);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}