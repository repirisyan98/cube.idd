<div wire:init='loadPosts'>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @if (empty($data))
        Tidak ada data
    @else
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4 border-end">
                    <img src="{{ asset('storage/product/' . $data->gambar) }}" class="img-fluid" alt="...">
                    {{-- <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3">
                        <div class="col"><img src="assets/images/products/12.png" width="70"
                                class="border rounded cursor-pointer" alt=""></div>
                        <div class="col"><img src="assets/images/products/11.png" width="70"
                                class="border rounded cursor-pointer" alt=""></div>
                        <div class="col"><img src="assets/images/products/14.png" width="70"
                                class="border rounded cursor-pointer" alt=""></div>
                        <div class="col"><img src="assets/images/products/15.png" width="70"
                                class="border rounded cursor-pointer" alt=""></div>
                    </div> --}}
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">{{ $data->nama_produk }}</h4>
                        <div class="d-flex gap-3 py-3">
                            @php
                                $no = 0;
                                $rating = 0;
                            @endphp
                            @forelse ($data->ulasan as $item)
                                @php
                                    $rating += $item->rating;
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
                            <div>{{ $data->ulasan->count() }} Ulasan</div>
                            {{-- <div class="text-success"><i class='bx bxs-cart-alt align-middle'></i> 134 orders</div> --}}
                        </div>
                        <div class="mb-3">
                            <span
                                class="price h4">Rp.{{ number_format($data->harga - ($data->harga * $data->discount) / 100, 0, ',', '.') }}</span>
                            <span class="text-muted">/per pcs</span>
                        </div>
                        <p class="card-text fs-6">{{ $data->keterangan }}</p>
                        {{-- <dl class="row">
                            <dt class="col-sm-3">Model#</dt>
                            <dd class="col-sm-9">Odsy-1000</dd>

                            <dt class="col-sm-3">Color</dt>
                            <dd class="col-sm-9">Brown</dd>

                            <dt class="col-sm-3">Delivery</dt>
                            <dd class="col-sm-9">Russia, USA, and Europe </dd>
                        </dl> --}}
                        <hr>
                        <form wire:submit.prevent='add_to_cart'>
                            <div class="row row-cols-auto row-cols-1 row-cols-md-3 align-items-center">
                                <div class="col">
                                    <label class="form-label">Jumlah</label>
                                    <div class="input-group input-spinner">
                                        <input type="number" class="form-control" min="1"
                                            max="{{ $data->stok }}" wire:model.defer='qty'>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label">Pilih Ukuran</label>
                                    <div>
                                        @php
                                            $ukurans = json_decode($data->ukuran);
                                        @endphp
                                        @foreach ($ukurans as $key => $value)
                                            <label class="form-check form-check-inline">
                                                <input type="radio" id="ukuran{{ $key }}" required
                                                    class="form-check-input" wire:model.lazy='ukuran'
                                                    value="{{ $value }}" class="custom-control-input">
                                                <div class="form-check-label">{{ $value }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-3 mt-3">
                                {{-- <button type="button" class="btn btn-primary">Buy Now</button> --}}
                                <button type="submit" class="btn btn-outline-primary"><span class="text">+
                                        Keranjang</span>
                                    <i class='bx bxs-cart-alt'></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr />
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                            aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title"> Product Description </div>
                            </div>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                            aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-bookmark-alt font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Tags</div>
                            </div>
                        </a>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primarycontact" role="tab"
                            aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Ulasan</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content pt-3">
                    {{-- <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown
                            aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan
                            helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                            mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan
                            aliquip quis cardigan american apparel, butcher voluptate nisi.</p>
                        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown
                            aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan
                            helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                            mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan
                            aliquip quis cardigan american apparel, butcher voluptate nisi.</p>
                    </div> --}}
                    {{-- <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
                            Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan
                            four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft
                            beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda
                            labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit
                            sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean
                            shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown,
                            tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                    </div> --}}
                    <div class="tab-pane fade show active" id="primarycontact" role="tabpanel">
                        @forelse ($data->ulasan as $item)
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/reviews/' . $item->picture) }}" alt=""
                                        srcset="">
                                </div>
                                <div class="col-md-9">
                                    <p>
                                        <b>{{ $item->user->name }}</b>
                                        <br>
                                        {{ $item->keterangan }}
                                    </p>
                                    <p class="text-muted">
                                        {{ $item->tanggal }}
                                        <br>
                                        @for ($i = 0; $i < $item->rating; $i++)
                                            <i class='bx bxs-star text-warning'></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $item->rating; $i++)
                                            <i class='bx bxs-star text-secondary'></i>
                                        @endfor
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Belum ada Ulasan</p>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
