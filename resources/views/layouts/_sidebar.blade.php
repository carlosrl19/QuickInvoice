   <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
           <!-- Logo Header -->
           @include('layouts._logo_header')
           <!-- End Logo Header -->
       </div>
       <div class="sidebar-wrapper">
           <div class="sidebar-content">
               <ul class="nav nav-secondary">
                   @can('dashboard_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">MODULO DASHBOARD</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('dashboard.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Route::currentRouteName() === 'dashboard.index',
                           ])>
                           <x-heroicon-o-home style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Dashboard</span>
                       </a>
                   </li>
                   @endcan

                   @can('rrhh_module_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">MODULO RR.HH</h4>
                   </li>
                   @can('clients_permission')
                   <li class="nav-item">
                       <a href="{{ route('clients.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'clients.'),
                           ])>
                           <x-heroicon-o-users style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Clientes</span>
                       </a>
                   </li>
                   @endcan
                   @can('sellers_permission')
                   <li class="nav-item">
                       <a href="{{ route('sellers.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Route::currentRouteName() === 'sellers.index',
                           ])>
                           <x-heroicon-o-rectangle-group style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Vendedores</span>
                       </a>
                   </li>
                   @endcan
                   @can('consignments_permission')
                   <li class="nav-item">
                       <a href="{{ route('consignments.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Route::currentRouteName() === 'consignments.index',
                           ])>
                           <x-heroicon-o-paper-airplane style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Consignaciones</span>
                       </a>
                   </li>
                   @endcan
                   @endcan

                   @can('inventory_module_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">MODULO INVENTARIO</h4>
                   </li>
                   @can('services_permission')
                   <li class="nav-item">
                       <a href="{{ route('services.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Route::currentRouteName() === 'services.index',
                           ])>
                           <x-heroicon-o-bolt style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Servicios</span>
                       </a>
                   </li>
                   @endcan
                   @can('products_permission')
                   <li class="nav-item">
                       <a data-bs-toggle="collapse" href="#products_collapse"
                           @class(['show'=> in_array(Route::currentRouteName(), [
                           'categories.index',
                           'products.index',
                           ])] )>
                           <x-heroicon-o-book-open style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <p>Productos</p>
                           <span class="caret"></span>
                       </a>
                       <div class="collapse @if(in_array(Route::currentRouteName(), [
                                'categories.index',
                                'products.index',
                            ])) show @endif" id="products_collapse">
                           <ul class="nav nav-collapse">
                               @can('categories_permission')
                               <a href="{{ route('categories.index') }}"
                                   @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), needles: 'categories.'),
                                   ])>
                                   <x-heroicon-o-table-cells style="width: 20px; height: 20px; color: gray;" class="me-2" />
                                   <span class="sub-item">Lista categorías</span>
                               </a>
                               @endcan
                               @can('products_permission')
                               <a href="{{ route('products.index') }}"
                                   @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'products.'),
                                   ])>
                                   <x-heroicon-o-rectangle-stack style="width: 20px; height: 20px; color: gray;" class="me-2" />
                                   <span class="sub-item">Lista productos</span>
                               </a>
                               @endcan
                               @can('sales_permission')
                               <a href="{{ route('sales.index') }}"
                                   @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'sales.'),
                                   ])>
                                   <x-heroicon-o-arrow-down-on-square-stack style="width: 20px; height: 20px; color: gray;" class="me-2" />
                                   <span class="sub-item">Salida de inventario</span>
                               </a>
                               @endcan
                           </ul>
                       </div>
                   </li>
                   @endcan
                   @endcan

                   @can('loans_module_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">MODULO CRÉDITOS</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('loans.loans_request') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Route::currentRouteName() === 'loans.loans_request',
                           ])>
                           <x-heroicon-o-banknotes style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Solicitud de créditos</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a data-bs-toggle="collapse" href="#credits_collapse"
                           @class(['show'=> in_array(Route::currentRouteName(), [
                           'loans.index',
                           'loans.loans_paid_index',
                           'loans.loans_rejected_index',
                           'loans.loans_cancelled_index',
                           ])] )>
                           <x-heroicon-o-book-open style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <p>Créditos</p>
                           <span class="caret"></span>
                       </a>
                       <div class="collapse @if(in_array(Route::currentRouteName(), [
                                'loans.index',
                                'loans.loans_paid_index',
                                'loans.loans_rejected_index',
                                'loans.loans_cancelled_index',
                            ])) show @endif" id="credits_collapse">
                           <ul class="nav nav-collapse">
                               <a href="{{ route('loans.index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'loans.index',
                                   ])>
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: lightgreen;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos vigentes</span>
                               </a>
                               <a href="{{ route('loans.loans_paid_index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'loans.loans_paid_index',
                                   ])>
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: lightblue;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos cancelados</span>
                               </a>
                               <a href="{{ route('loans.loans_rejected_index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'loans.loans_rejected_index',
                                   ])>
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: red;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos rechazados</span>
                               </a>
                               <a href="{{ route('loans.loans_cancelled_index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'loans.loans_cancelled_index',
                                   ])>
                                   <x-heroicon-o-book-open style="width: 20px; height: 20px; color: orange;" class="me-2 op-5" />
                                   <span class="sub-item">Créditos anulados</span>
                               </a>
                           </ul>
                       </div>
                   </li>
                   @endcan

                   @can('pos_module_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">MODULO FACTURACIÓN</h4>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('quotes.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'quotes.') || Str::startsWith(Route::currentRouteName(), 'quote_details.'),
                           ])>
                           <x-heroicon-o-square-3-stack-3d style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">Cotizaciones</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('pos.index') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'pos.index') || Str::startsWith(Route::currentRouteName(), 'pos_details.'),
                           ])>
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
                       @elseif($folio_activated->folio_total_invoices_available == 0)
                       <a href="#" title="Sin folios de facturación disponibles." data-bs-toggle="tooltip" data-bs-placement="right">
                           <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @else
                       <a href="{{ route('pos.create') }}"
                           @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'pos.create') || Str::startsWith(Route::currentRouteName(), 'pos.exonerated_sale'),
                           ])>
                           <x-heroicon-o-currency-dollar style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <span class="sub-item">POS</span>
                       </a>
                       @endif
                   </li>

                   @can('settings_permission')
                   <li class="nav-section">
                       <span class="sidebar-mini-icon">
                           <hr>
                       </span>
                       <h4 class="text-section">AJUSTES DEL SISTEMA</h4>
                   </li>
                   <li class="nav-item">
                    @if(!$folio_activated)
                        <a href="{{ route('fiscalfolio.index') }}" style="background-color: rgba(255,0,11,0.5);" title="No hay folio fiscal activo, agregue y active un folio en el módulo Configuración/Folios" data-bs-toggle="tooltip" data-bs-placement="right">
                            <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="mx-2" />
                            <span class="sub-item">Configuración</span>
                        </a>
                    @elseif($folio_activated->folio_total_invoices_available == 0)
                        <a href="{{ route('settings.index') }}" style="background-color: rgba(255,0,11,0.5);" title="Se ha llegado al limite de facturación permitido para el folio actual, agregue un nuevo folio el módulo Configuración/Folios" data-bs-toggle="tooltip" data-bs-placement="right">
                            <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: #ffe000;" class="mx-2" />
                            <span class="sub-item">Configuración</span>
                        </a>
                    @else
                        <a href="{{ route('settings.index') }}"
                            @class([ 'bg-info2 m-2 rounded alert-primary'=> Str::startsWith(Route::currentRouteName(), 'settings.')
                            || Str::startsWith(Route::currentRouteName(), 'fiscalfolio.')
                            || Str::startsWith(Route::currentRouteName(), 'banks.')
                            ])>
                            <x-heroicon-o-cog-6-tooth style="width: 20px; height: 20px; color: gray;" class="me-2" />
                            <span class="sub-item">Configuración</span>
                        </a>
                    @endif   </li>
                   @endcan
                   @endcan

                   @can('sysadmin_permission')
                   <li class="nav-item">
                       <a data-bs-toggle="collapse" href="#admin_collapse"
                           @class(['show'=> in_array(Route::currentRouteName(), [
                           'roles.index',
                           'permissions.index',
                           'users.index',
                           ])] )>
                           <x-heroicon-o-book-open style="width: 20px; height: 20px; color: gray;" class="me-2" />
                           <p>Auth</p>
                           <span class="caret"></span>
                       </a>
                       <div class="collapse @if(in_array(Route::currentRouteName(), [
                                'roles.index',
                                'permissions.index',
                                'users.index',
                            ])) show @endif" id="admin_collapse">
                           <ul class="nav nav-collapse">
                               @can('roles_permission')
                               <a href="{{ route('roles.index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'roles.index',
                                   ])>
                                   <x-heroicon-o-viewfinder-circle style="width: 20px; height: 20px; color: lightblue;" class="me-2 op-5" />
                                   <span class="sub-item">Roles de usuario</span>
                               </a>
                               @endcan
                               @can('permissions_permission')
                               <a href="{{ route('permissions.index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'permissions.index',
                                   ])>
                                   <x-heroicon-o-identification style="width: 20px; height: 20px; color: red;" class="me-2 op-5" />
                                   <span class="sub-item">Permisos</span>
                               </a>
                               @endcan
                               @can('users_permission')
                               <a href="{{ route('users.index') }}"
                                   @class([ 'bg-info2 m-1 rounded alert-primary'=> Route::currentRouteName() === 'users.index',
                                   ])>
                                   <x-heroicon-o-user style="width: 20px; height: 20px; color: orange;" class="me-2 op-5" />
                                   <span class="sub-item">Usuarios</span>
                               </a>
                               @endcan
                           </ul>
                       </div>
                   </li>
                   @endcan
               </ul>
           </div>
       </div>
   </div>