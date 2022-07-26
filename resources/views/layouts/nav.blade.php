<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
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
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
            <ul>
                <li> <a href="{{ url('index') }}"><i class="bx bx-right-arrow-alt"></i>Default</a>
                </li>
                <li> <a href="{{ url('dashboard-alternate') }}"><i class="bx bx-right-arrow-alt"></i>Alternate</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Kelola Akun</div>
            </a>
        </li>
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
            <a href="{{ route('katalog') }}">
                <div class="parent-icon"><i class='bx bx-box'></i>
                </div>
                <div class="menu-title">Katalog</div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Keranjang</div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class='bx bx-edit'></i>
                </div>
                <div class="menu-title">Ulasan</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
