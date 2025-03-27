   <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
           <!-- Logo Header -->
           @include('layouts._logo_header')
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
                       <h4 class="text-section">MODULO RR.HH</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('clients.index') }}">
                           <x-heroicon-o-users style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Clientes</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('sellers.index') }}">
                           <x-heroicon-o-rectangle-group style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Vendedores</span>
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
                       <h4 class="text-section">MODULO CRÉDITOS</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('loans.loans_request') }}">
                           <x-heroicon-o-banknotes style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Solicitud de créditos</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a data-bs-toggle="collapse" href="#credits_collapse">
                           <x-heroicon-o-book-open style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <p>Créditos</p>
                           <span class="caret"></span>
                       </a>
                       <div class="collapse" id="credits_collapse">
                           <ul class="nav nav-collapse">
                               <a href="{{ route('loans.index') }}">
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: lightgreen;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos vigentes</span>
                               </a>
                               <a href="{{ route('loans.loans_paid_index') }}">
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: lightblue;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos cancelados</span>
                               </a>
                               <a href="{{ route('loans.loans_rejected_index') }}">
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: red;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos rechazados</span>
                               </a>
                               <a href="{{ route('loans.loans_cancelled_index') }}">
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: orange;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos anulados</span>
                               </a>
                           </ul>
                       </div>
                   </li>
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <i class="fa fa-ellipsis-h"></i>
                       </span>
                       <h4 class="text-section">MODULO FACTURACIÓN</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('pos.index') }}">
                           <x-heroicon-o-computer-desktop style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Registro de ventas</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       @php
                       $settings = App\Models\Settings::exists();
                       $folio = App\Models\FiscalFolio::exists();
                       $folio_activated = App\Models\FiscalFolio::where('folio_status', 1)->first();
                       $folio_no_activated = App\Models\FiscalFolio::where('folio_status', 1)->count() == 0;
                       @endphp

                       @if(!$settings)
                       <a href="{{ route('settings.index') }}" style="background-color: rgba(255,0,11,0.5);" title="Para realizar ventas, primero agregue los datos de la empresa en el módulo Configuración" data-bs-toggle="tooltip" data-bs-placement="right">
                           <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @elseif(!$folio)
                       <a href="{{ route('fiscalfolio.index') }}" style="background-color: rgba(255,0,11,0.5);" title="Para realizar ventas, primero agregue un folio fiscal en el módulo Folios" data-bs-toggle="tooltip" data-bs-placement="right">
                           <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @elseif($folio_no_activated)
                       <a href="{{ route('fiscalfolio.index') }}" style="background-color: rgba(255,0,11,0.5);" title="Para realizar ventas, primero active el uso del folio fiscal en el módulo Folios" data-bs-toggle="tooltip" data-bs-placement="right">
                           <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @else
                       <a href="{{ route('pos.create') }}">
                           <x-heroicon-o-currency-dollar style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @endif
                   </li>
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <i class="fa fa-ellipsis-h"></i>
                       </span>
                       <h4 class="text-section">AJUSTES DEL SISTEMA</h4>
                   </li>
                   <li class="nav-item">
                       @if($folio_activated->folio_total_invoices_available == 0)
                       <a href="{{ route('settings.index') }}" title="Se ha llegado al limite de facturación permitido para el folio actual, agregue un nuevo folio el módulo Configuración/Folios" data-bs-toggle="tooltip" data-bs-placement="right">
                           <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="mx-2" />
                           <span class="sub-item">Configuración</span>
                       </a>
                       @else
                       <a href="{{ route('settings.index') }}">
                           <x-heroicon-o-cog-6-tooth style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Configuración</span>
                       </a>
                       @endif
                   </li>
               </ul>
           </div>
       </div>
   </div>