<?php

namespace App\Http\Livewire\User;

use App\Models\Pemesanan;
use Livewire\Component;
use App\Services\Midtrans\CreateSnapTokenService;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Pembayaran extends Component
{
    use LivewireAlert;

    public $id_pemesanan, $snapToken;

    public function mount($id)
    {
        $this->id_pemesanan = $id;
    }
    public function render()
    {
        $this->snapToken = Pemesanan::where('id', $this->id_pemesanan)->value('snap_token');
        if (is_null($this->snapToken)) {
            // If snap token is still NULL, generate snap token and save it to database
            $data = Pemesanan::with('detail_pemesanan')->where('id', $this->id_pemesanan)->first();
            $items['item_details'] = [];
            foreach ($data->detail_pemesanan as $item) {
                array_push($items['item_details'], array(
                    'id' => $item->id,
                    'price' => $item->produk->harga - (($item->produk->harga * $item->produk->discount) / 100),
                    'quantity' => $item->qty,
                    'name' => $item->produk->nama_produk
                ));
            }
            $params = [
                'transaction_details' => [
                    'order_id' => $data->invoice,
                    'gross_amount' => $data->total_pembayaran,
                ],
                $items
            ];
            $midtrans = new CreateSnapTokenService();
            $snapToken = $midtrans->getSnapToken($params);

            Pemesanan::find($this->id_pemesanan)->update([
                'snap_token' => $snapToken
            ]);
            $this->snapToken = $snapToken;
        }
        return view('livewire.user.pembayaran');
    }

    public function berhasil()
    {
        try {
            Pemesanan::find($this->id_pemesanan)->update([
                'status' => '1'
            ]);
            return redirect()->to('/pembelian');
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Harap ulangi kembali'
            );
        }
    }
}