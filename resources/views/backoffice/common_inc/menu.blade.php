<!-- Menu -->

@php
$currentPath = request()->path(); // for active state
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="javascript:void(0)" class="app-brand-link">
        <span class="app-brand-logo demo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#3d78f0" height="800px" width="25" version="1.1" id="Capa_1" viewBox="0 0 23.63 23.63" xml:space="preserve" stroke="#3d78f0">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                
                <g id="SVGRepo_iconCarrier"> <g> <g> <polygon points="0,0.663 9.401,0.663 15.882,7.146 15.882,14.127 5.307,3.608 5.274,22.969 0,22.969 "/> <polygon points="23.631,22.969 14.232,22.969 7.752,16.485 7.752,9.501 18.327,20.018 18.359,0.662 23.631,0.662 "/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </g> </g>
                  
                </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">Naive Panel</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-smile"></i>
          <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
          
        </a>
        
      </li>

      @if (Auth::check() && Auth::user()->isDeveloper())
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">System</span>
      </li>
      <li class="menu-item {{ request()->routeIs('menus.create') || request()->routeIs('menus.manage') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-sitemap"></i>
          <div class="text-truncate" data-i18n="Menu Builder">Menu Builder</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('menus.create') ? 'active' : '' }}">
            <a href="{{ route('menus.create') }}" class="menu-link">
              <div class="text-truncate" data-i18n="Add Menu">Add Menu</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('menus.manage') ? 'active' : '' }}">
            <a href="{{ route('menus.manage') }}" class="menu-link">
              <div class="text-truncate" data-i18n="Manage Menus">Manage Menus</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.editUser') ? 'active' : '' }}">
        <a href="{{ route('permissions.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-lock-alt"></i>
          <div class="text-truncate" data-i18n="Permissions">Permissions</div>
        </a>
      </li>
      @endif

      @if (Auth::check() && Auth::user()->isAdmin())
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Store Management</span>
      </li>
      <li class="menu-item {{ request()->routeIs('homepage.index') ? 'active' : '' }}">
        <a href="{{ route('homepage.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div class="text-truncate" data-i18n="Homepage Manager">Homepage Manager</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <a href="{{ route('categories.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-category"></i>
          <div class="text-truncate" data-i18n="Categories">Categories</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('products.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-package"></i>
          <div class="text-truncate" data-i18n="Products">Products</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('products.create') ? 'active' : '' }}">
            <a href="{{ route('products.create') }}" class="menu-link">
              <div class="text-truncate" data-i18n="Add Product">Add Product</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
            <a href="{{ route('products.index') }}" class="menu-link">
              <div class="text-truncate" data-i18n="Manage Products">Manage Products</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <a href="{{ route('orders.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cart"></i>
          <div class="text-truncate" data-i18n="Orders">Orders</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('stock.*') ? 'active' : '' }}">
        <a href="{{ route('stock.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
          <div class="text-truncate" data-i18n="Stock Management">Stock Management</div>
        </a>
      </li>

      <!-- Content Management Section -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Content Management</span>
      </li>
      <li class="menu-item {{ request()->routeIs('pages.*') ? 'active' : '' }}">
        <a href="{{ route('pages.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div class="text-truncate" data-i18n="Pages">Pages</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('posts.*') ? 'active' : '' }}">
        <a href="{{ route('posts.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-news"></i>
          <div class="text-truncate" data-i18n="Blog Posts">Blog Posts</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('promo_banners.*') ? 'active' : '' }}">
        <a href="{{ route('promo_banners.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-image"></i>
          <div class="text-truncate" data-i18n="Promo Banners">Promo Banners</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('testimonials.*') ? 'active' : '' }}">
        <a href="{{ route('testimonials.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-message-rounded-dots"></i>
          <div class="text-truncate" data-i18n="Testimonials">Testimonials</div>
        </a>
      </li>
      @endif

      <!-- Layouts -->
     
      @foreach ($categories as $category)
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ $category->category}}</span>
      </li>
      @foreach ($parent_menus->where('category', $category->category) as $parent)
      @php
          $isActiveMenu = Str::contains($currentPath, $parent->path) ? 'active open' : '';
      @endphp
      <li class="menu-item {{ $isActiveMenu }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx  {{ $parent->icon }}"></i>
          <div class="text-truncate" data-i18n="{{ $parent->menu_name }}">{{ $parent->menu_name }}</div>
        </a>

        <ul class="menu-sub">
          @foreach ($sub_menus->where('parent_id', $parent->id) as $sub)
                    @php
                        $isActiveSub = Str::contains($currentPath, $sub->path) ? 'active' : '';
                    @endphp
          <li class="menu-item {{ $isActiveSub }}">
            <a href="{{ url($sub->path) }}" class="menu-link">
              <div class="text-truncate" data-i18n="{{ $sub->menu_name }}">{{ $sub->menu_name }}</div>
            </a>
          </li>
          @endforeach
          
        </ul>
      </li>
      @endforeach
      @endforeach
     

    </ul>
  </aside>
  <!-- / Menu -->