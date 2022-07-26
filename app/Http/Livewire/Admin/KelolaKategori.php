<?php

namespace App\Http\Livewire\Admin;

use App\Models\Kategori;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaKategori extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'canceled',
    ];

    public $readyToLoad, $temp_id, $nama, $deskripsi;

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
        return view('livewire.admin.kelola-kategori', [
            'data' => $this->readyToLoad ? Kategori::simplePaginate(15) : [],
        ]);
    }

    public function store()
    {
        try {
            Kategori::create([
                'nama' => $this->nama,
                'deskripsi' => $this->deskripsi
            ]);
            $this->alert(
                'success',
                'Data berhasil disimpan'
            );
        } catch (\Throwable $th) {
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
        $data = Kategori::where('id', $id)->first();
        $this->temp_id = $id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
    }

    public function update()
    {
        try {
            Kategori::find($this->temp_id)->update([
                'nama' => $this->nama,
                'deksripsi' => $this->deskripsi
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

    public function triggerConfirm($id)
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
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Kategori::destroy($this->temp_id);
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