
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Rocker</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>

			<ul class="metismenu" id="menu">

                <li>
					<a href="{{route('admin.dashboard')}}">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li class="menu-label">Home</li>
                <li>
					<a href="{{route('admin.homeBanner')}}">
                        <div class="parent-icon"><i class='fadeIn animated bx bx-image'></i>
						</div>
                        <div class="menu-title">All Banners</div>
					</a>
				</li>
                <li>
					<a href="{{route('admin.sizes.index')}}">
                        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize-2 text-primary"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
						</div>
                        <div class="menu-title">All Sizes</div>
					</a>
				</li>
                <li>
                    <a href="{{route('admin.colors.index')}}">
                        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hexagon text-primary"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <div class="menu-title">All Colors</div>
                    </a>
                </li>
				<li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Attributes</div>
					</a>
					<ul>
                        <li> <a href="{{route('admin.attributes.index')}}"><i class="bx bx-right-arrow-alt"></i>All Attribute</a>
						</li>
						<li> <a href="{{route('admin.attributeValues.index')}}"><i class="bx bx-right-arrow-alt"></i>All Attribute Values</a>
						</li>
					</ul>
				</li>
				<li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Categories</div>
					</a>
					<ul>
                        <li> <a href="{{route('admin.categories.index')}}"><i class="bx bx-right-arrow-alt"></i>All Categories</a>
						</li>
						<li> <a href="{{route('admin.categoryAttributes.index')}}"><i class="bx bx-right-arrow-alt"></i>Category Attributes</a>
						</li>
					</ul>
				</li>
                <li>
                    <a href="{{route('admin.brands.index')}}">
                        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hexagon text-primary"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <div class="menu-title">Brands</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.taxes.index')}}">
                        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hexagon text-primary"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <div class="menu-title">Tax</div>
                    </a>
                </li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">eCommerce</div>
					</a>
					<ul>
						<li> <a href="{{route('admin.products.index')}}"><i class="bx bx-right-arrow-alt"></i>Products</a>
						</li>
						<li> <a href="{{route('admin.products.create')}}"><i class="bx bx-right-arrow-alt"></i>Add New Products</a>
						</li>
						<li> <a href="ecommerce-orders.html"><i class="bx bx-right-arrow-alt"></i>Orders</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="{{route('admin.userProfile')}}">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">User Profile</div>
					</a>
				</li>

			</ul>

		</div>
