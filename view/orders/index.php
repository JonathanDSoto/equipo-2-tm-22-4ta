<?php
	include_once "../../app/config.php";
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Orders</title>
    <?php include "../../layout/head.template.php" ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php include "../../layout/navbar.template.php" ?>
        <?php include "../../layout/sidebar.template.php" ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Orders</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Orders</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Content -->
                        <div class="col-xl-12 col-lg-10">
                            <div>
                                <div class="card">
                                    <div class="card-header border-0">
                                        <div class="row g-4">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <!-- <a href="apps-ecommerce-add-product.html" class="btn btn-success" id="addproduct-btn"><i class="ri-add-line align-bottom me-1"></i> Add Product</a> -->
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalOrder" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Order</button>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="d-flex justify-content-sm-end">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control" id="searchProductList" placeholder="Search User...">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA PRODUCTOS -->
                                    <div class="card-body">
                                        <table class="table table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Folio</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Payment Type</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Coupon</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Paid</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Bobby</td>
                                                    <td>Davis</td>
                                                    <td>October</td>
                                                    <td>$2,300</td>
                                                    <td>$2,300</td>
                                                    <td>$2,300</td>
                                                    <td>$2,300</td>
                                                    <td>$2,300</td>
                                                    <td><span class="badge bg-success">active</span></td>
                                                    <td>
                                                        <div class="dropdown ms-2">
                                                            <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill"></i>
                                                            </a>                
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li><a class="dropdown-item" href="#">View</a></li>
                                                                <li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modalOrder" href="#">Edit</a></li>
                                                                <li><a class="dropdown-item " data-bs-toggle="modal" data-bs-target="#removeItemModal" href="#">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "../../layout/footer.template.php" ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- removeItemModal -->
    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this order?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger " id="delete-product">Yes, Delete It!</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Grids in modals -->
    <div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter client's first name">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter client's last name">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">Payment type</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter payment type">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Presentation</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select a presentation</option>
                                        <option value="1">blue</option>
                                        <option value="2">pink</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter quantity">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Coupon</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select a coupon</option>
                                        <option value="1">25OFF</option>
                                        <option value="2">None</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Paid</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select an option</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Status</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select a status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <h5 class="modal-title" id="exampleModalgridLabel">Address</h5>
                            </div>
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Street and number</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter the street and number">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Postal code</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter the postal code">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">City</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter the city">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter the province">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter the phone number">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Use as billing address</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select an option</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-secondary btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <?php include "../../layout/scripts.template.php" ?>
</body>


</html>