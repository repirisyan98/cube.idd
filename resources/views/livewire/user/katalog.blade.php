<div wire:init='loadPosts'>
    {{-- The whole world belongs to you. --}}
    {{-- <h5>Rekomendasi Produk</h5>
    <hr> --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
        @if (empty($data))
            Tidak ada data
        @else
            @forelse ($data as $item)
                <div class="col">
                    <div class="card">
                        <img src="{{ asset('storage/product/' . $item->gambar) }}" class="card-img-top" alt="...">
                        @if ($item->discount > 0)
                            <div class="">
                                <div class="position-absolute top-0 end-0 m-3 product-discount"><span
                                        class="">-{{ $item->discount }}%</span></div>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title cursor-pointer"><a
                                    href="{{ route('detail.product', $item->id) }}">{{ $item->nama_produk }}</a></h6>
                            <div class="clearfix">
                                {{-- <p class="mb-0 float-start"><strong>{{ $item->terjual }}</strong> Terjual</p> --}}
                                <p class="mb-0 float-end fw-bold">
                                    @if ($item->discount > 0)
                                        <span
                                            class="me-2 text-decoration-line-through text-secondary">Rp.{{ number_format($item->harga, 0, ',', '.') }}</span>
                                    @endif
                                    <span>Rp.{{ number_format($item->harga - ($item->harga * $item->discount) / 100, 0, ',', '.') }}</span>
                                </p>
                            </div>
                            <div class="d-flex align-items-center mt-3 fs-6">
                                <div class="cursor-pointer">
                                    @php
                                        $no = 0;
                                        $rating = 0;
                                    @endphp
                                    @forelse ($item->ulasan as $detail)
                                        @php
                                            $rating += $detail->rating;
                                            $no++;
                                        @endphp
                                    @empty
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class='bx bxs-star text-secondary'></i>
                                        @endfor
                                    @endforelse
                                    @if ($rating != null)
                                        @for ($i = 0; $i < round($rating / $no); $i++)
                                            <i class='bx bxs-star text-warning'></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - round($rating / $no); $i++)
                                            <i class='bx bxs-star text-secondary'></i>
                                        @endfor
                                    @endif
                                </div>
                                <p class="mb-0 ms-auto">
                                    @if ($no != 0)
                                        {{ round($rating / $no) }}
                                    @else
                                        0
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                Tidak ada data
            @endforelse
        @endif
    </div>
</div>
