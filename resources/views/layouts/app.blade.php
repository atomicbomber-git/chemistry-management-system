<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <title>{{ config('app.name', 'Biologi') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('adminLTE/bootstrap/css/bootstrap.min.css' )}}">
        <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/skins/skin-blue.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables/dataTables.bootsrap.css') }}">
        <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datepicker/datepicker3.css') }}">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- header -->
            <header class="main-header">
                <a href="#" class="logo">
                    <span class="logo-mini"><b>BIO</b></span>
                    <span class="logo-lg"><b>Bio</b>Logi</span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image" alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }}
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a class="btn btn-default btn-flat" href="{{ route('user.profil') }}">Edit Profil</a>
                                    </div>
                                   <div class="pull-right">
                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                                </li>

                            </ul>
                        </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--end footer -->

            <!-- Sidebar -->
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header"> Menu Navigasi </li>
                      
                        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

                        @if( Auth::user()->level == 1)

                        <li  data-toggle="collapse" data-target="#masterdata" class="collapsed active">
                        <a href="#"><i class="fa fa-home"></i> MASTER DATA <span class="caret"></span></a>
                        
                        <ul class="sub-menu collapse" id="masterdata">
                            <li><a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i><span>Kategori</span></a></li>
                            <li><a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i><span>Produk</span></a></li>
                            <li><a href="{{ route('member.index') }}"><i class="fa fa-credit-card"></i><span>Member</span></a></li>
                            <li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i><span>User</span></a></li>
                        </ul>
                        </li>
                        <li><a href="{{ route('penerimaan.index') }}"><i class="fa fa-download"></i><span>Penerimaan</span></a></li>                     
                        <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-cart-plus"></i><span>Penjualan</span></a></li>
                        <li><a href="{{ route('pemakaian.index') }}"><i class="fa fa-upload"></i><span>Penggunaan</span></a></li> 
                        <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i><span>Pengeluaran</span></a></li>
                        <li><a href="{{ route('barangrusak.index') }}"><i class="fa fa-warning"></i><span>Bahan Rusak</span></a></li>
                                                
                        <li><a href="{{ route('laporan.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Pendapatan</span></a></li>
                        <li><a href="{{ route('laporanstok.index') }}"><i class="fa fa-calendar-times-o"></i><span>Laporan Stok</span></a></li>
                        <li><a href="{{route('setting.index') }}"><i class="fa fa-gears"></i><span>Setting</span></a></li>

                        @else
                        
                        <li><a href="{{ route('laporan.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Pendapatan</span></a></li>
                        <li><a href="#"><i class="fa fa-file-pdf-o"></i><span>Laporan Persediaan</span></a></li>
                        <li><a href="{{ route('kadaluarsa.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Kadaluarsa</span></a></li>
                        <li><a href="{{ route('laporanpenerimaan.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Penerimaan</span></a></li>
                        <li><a href="{{ route('laporanpenjualan.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Penjualan</span></a></li>
                        <li><a href="{{ route('laporanpemakaian.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Penggunaan</span></a></li>
                        <li><a href="{{ route('laporanrusak.index') }}"><i class="fa fa-file-pdf-o"></i><span>Laporan Bahan Rusak</span></a></li>
                        <li><a href="{{ route('setting.index') }}"><i class="fa fa-gears"></i><span>Setting</span></a></li>
                        
                        @endif
                    </ul>
                </section>
            </aside>
            <!-- End Sidebar -->

            <!-- Content -->
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        @yield('title')
                    </h1>
                    <ol class="breadcrumb">
                        @section('breadcrumb')
                        <li><a href="#"><i class=" fa fa-home"></i>Home</a></li>
                        @show
                    </ol>
                </section>

                <section class="content">
                    @yield('content')
                </section>
            </div>
            <!-- End Content -->

            <!-- Footer -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Laboratorium Biologi MIPA
                </div>
                <strong>Copyright &copy; 2017 <a href="#">Universitas Tanjungpura</a></strong> All rights reserved
            </footer>

            <!-- End Footer -->

            <script src="{{ asset('adminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
            <script src="{{ asset('adminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('adminLTE/dist/js/app.min.js') }}"></script>
            <script src="{{ asset('adminLTE/plugins/chartjs/Chart.min.js') }}"></script>
            <script src="{{ asset('adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
            <script src="{{ asset('adminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
            <script src="{{ asset('adminLTE/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
            <script src="{{ asset('js/validator.min.js') }}"></script>

            @yield('script')
        
    </body>
</html>