<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="<?= BASE_PATH ?>products" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= BASE_PATH ?>public/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= BASE_PATH ?>public/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="<?= BASE_PATH ?>products" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= BASE_PATH ?>public/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= BASE_PATH ?>public/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH ?>products" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="bx bxs-basket"></i> <span data-key="t-dashboards">Products</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCatalogs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="bx bxs-book-content"></i> <span data-key="t-apps">Catalogs</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarCatalogs">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="dashboard-analytics.html" class="nav-link" data-key="t-analytics"> Brands </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="dashboard-crm.html" class="nav-link" data-key="t-crm"> Categories </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="index.html" class="nav-link" data-key="t-ecommerce"> Tags </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="bx bxs-coupon"></i> <span data-key="t-layouts">Coupons</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH ?>orders" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <i class="ri-bill-fill"></i> <span data-key="t-authentication">Orders</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH ?>customers" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="ri-account-circle-fill"></i> <span data-key="t-pages">Customers</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH ?>users" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                <i class="ri-admin-line"></i> <span data-key="t-landing">Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>