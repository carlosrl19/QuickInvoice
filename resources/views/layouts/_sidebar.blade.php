   <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
           <!-- Logo Header -->
           <div class="logo-header" data-background-color="dark">
               <a href="#" class="logo">
                   <img
                       src="{{ Storage::url('assets/img/kaiadmin/logo_light.svg') }}"
                       alt="navbar brand"
                       class="navbar-brand"
                       height="20" />
               </a>
               <div class="nav-toggle">
                   <button class="btn btn-toggle toggle-sidebar">
                       <i class="gg-menu-right"></i>
                   </button>
                   <button class="btn btn-toggle sidenav-toggler">
                       <i class="gg-menu-left"></i>
                   </button>
               </div>
               <button class="topbar-toggler more">
                   <i class="gg-more-vertical-alt"></i>
               </button>
           </div>
           <!-- End Logo Header -->
       </div>
       <div class="sidebar-wrapper">
           <div class="sidebar-content">
               <ul class="nav nav-secondary">
                   <li class="nav-item">
                       <a href="/dashboard">
                           <x-heroicon-o-home style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Dashboard</span>
                       </a>
                   </li>
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <i class="fa fa-ellipsis-h"></i>
                       </span>
                       <h4 class="text-section">MODULO CLIENTES</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('clients.index') }}">
                           <x-heroicon-o-users style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Clientes</span>
                       </a>
                   </li>
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <i class="fa fa-ellipsis-h"></i>
                       </span>
                       <h4 class="text-section">MODULO INVENTARIO</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('services.index') }}">
                           <x-heroicon-o-bolt style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Servicios</span>
                       </a>
                   </li>
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <i class="fa fa-ellipsis-h"></i>
                       </span>
                       <h4 class="text-section">MODULO FACTURACIÓN</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('loans.index') }}">
                           <x-heroicon-o-book-open style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Préstamos</span>
                       </a>
                   </li>
               </ul>
           </div>
       </div>
   </div>