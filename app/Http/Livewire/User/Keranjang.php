<?php

namespace App\Http\Livewire\User;

use App\Models\DetailPemesanan;
use App\Models\Keranjang as ModelsKeranjang;
use App\Models\Pemesanan;
use App\Models\Produk;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Dipantry\Rajaongkir\Models\RajaongkirCourier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Keranjang extends Component
{
    use LivewireAlert;

    public $readyToLoad, $temp_id, $berat, $ids, $qty, $i, $ongkir, $total_harga, $id_pemesanan;


    protected $listeners = [
        'confirmed',
        'canceled',
        'pay',
        'getOngkir' => 'get_ongkir',
    ];

    public function mount()
    {
        $this->berat = 0;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.user.keranjang', [
            'data' => $this->readyToLoad ? ModelsKeranjang::with('produk')->where('user_id', auth()->user()->id)->get() : [],
        ]);
    }

    public function increment_qty($id, $stok, $qty)
    {
        try {
            if ($stok > $qty) {
                ModelsKeranjang::find($id)->increment('qty');
            } else {
                $this->alert(
                    'warning',
                    'Jumlah melebihi batas'
                );
            }
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan mohon maaf'
            );
        }
    }

    public function get_ongkir()
    {
        try {
            $data = \Rajaongkir::getOngkirCost(
                $origin = 1,
                $destination = auth()->user()->rajaongkir_citie_id,
                $weight = $this->berat,
                $courier = RajaongkirCourier::JNE
            );
            $this->ongkir = $data[0]['costs'][0]['cost'][0]['value'];
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Harap isi data dengan benar'
            );
        }
    }

    public function decrement_qty($id, $qty)
    {
        try {
            if ($qty > 1) {
                ModelsKeranjang::find($id)->decrement('qty');
            } else {
                $this->alert(
                    'warning',
                    'Jumlah melebihi batas'
                );
            }
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan mohon maaf'
            );
        }
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }

    public function triggerConfirm($id, $no)
    {
        $this->confirm('Hapus produk dari keranjang ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
        $this->temp_id = $id;
        $this->i = $no;
    }

    public function triggerConfirmPay()
    {
        $this->confirm('Lakukan Pembayaran ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'pay',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            unset($this->ids[$this->i]);
            unset($this->qty[$this->i]);
            ModelsKeranjang::destroy($this->temp_id);
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

    public function pay()
    {
        try {
            $this->get_ongkir();
            DB::transaction(function () {
                $invoice = "INV" . auth()->user()->id . rand();
                Pemesanan::create([
                    'invoice' => $invoice,
                    'user_id' => auth()->user()->id,
                    'tanggal' => date('Y-m-d'),
                    'alamat' => auth()->user()->alamat,
                    'ongkir' => $this->ongkir,
                    'kurir' => 'JNE',
                    'status' => "0",
                    'total_pembayaran' => $this->total_harga
                ]);
                $this->id_pemesanan = Pemesanan::where('invoice', $invoice)->value('id');
                foreach ($this->ids as $key => $value) {
                    DetailPemesanan::create([
                        'produk_id' => $this->ids[$key],
                        'pemesanan_id' => $this->id_pemesanan,
                        'qty' => $this->qty[$key],
                        'status' => "0",
                    ]);
                    Produk::find($this->ids[$key])->decrement('stok', $this->qty[$key]);
                }
                ModelsKeranjang::where('user_id', auth()->user()->id)->delete();
            });
            return redirect()->to('/pembayaran/' . $this->id_pemesanan);
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan mohon maaf'
            );
        }
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}