<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/Cube.idd.jpg') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Cube.idd</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('home') }}">
                <div class="parent-icon"><i class='bx bxs-dashboard'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if (auth()->user()->role == '1')
            <li>
                <a href="{{ route('kelola.kategori') }}">
                    <div class="parent-icon"><i class='bx bx-category'></i>
                    </div>
                    <div class="menu-title">Kelola Kategori</div>
                </a>
            </li>
            <li>
                <a href="{{ route('kelola.produk') }}">
                    <div class="parent-icon"><i class='bx bx-box'></i>
                    </div>
                    <div class="menu-title">Kelola Produk</div>
                </a>
            </li>
            <li>
                <a href="{{ route('kelola.transaksi') }}">
                    <div class="parent-icon"><i class='bx bx-list-check'></i>
                    </div>
                    <div class="menu-title">Kelola Transaksi</div>
                </a>
            </li>
        @elseif(auth()->user()->role == '2')
            <li>
                <a href="{{ route('katalog') }}">
                    <div class="parent-icon"><i class='bx bx-box'></i>
                    </div>
                    <div class="menu-title">Katalog</div>
                </a>
            </li>
            <li>
                <a href="{{ route('keranjang') }}">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Keranjang</div>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian') }}">
                    <div class="parent-icon"><i class='bx bx-list-check'></i>
                    </div>
                    <div class="menu-title">Pembelian</div>
                </a>
            </li>
            <li>
                <a href="{{ route('ulasan') }}">
                    <div class="parent-icon"><i class='bx bx-edit'></i>
                    </div>
                    <div class="menu-title">Ulasan</div>
                </a>
            </li>
        @endif
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
