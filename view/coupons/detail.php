<?php
	include_once "../../app/config.php"
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Coupon Details</title>
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
                                <h4 class="mb-sm-0">Coupon Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a>Ecommerce</a></li>
                                        <li class="breadcrumb-item active">Coupon Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div>
                                        <div class="row mx-auto">
                                            <div class="col-xxl-6">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th><span class="fw-medium">Name</span></th>
                                                                <td>cupon OP 20%</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Code</span></th>
                                                                <td>20PERCEN22</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Discount</span></th>
                                                                <td>20%</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Minimum Amount</span></th>
                                                                <td>100</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Minimum Products</span></th>
                                                                <td>1</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th><span class="fw-medium">Start Date</span></th>
                                                                <td>2022-10-04</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">End Date</span></th>
                                                                <td>2022-10-14</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Maximum Uses</span></th>
                                                                <td>100</td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Only Firtst Purchase</span></th>
                                                                <td><span class="badge bg-success">Yes</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Status</span></th>
                                                                <td><span class="badge bg-success">Active</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" role="tab">
                                                <i class="far fa-user"></i> Orders
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="Orders" role="tabpanel">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Folio</th>
                                                        <th scope="col">Customer</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Payment Type</th>
                                                        <th scope="col">Coupon</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Paid out</th>
                                                        <th scope="col">Status</th>
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
                                                        <td><span class="badge bg-success">Active</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end tab-pane-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3">
                            <!-- card -->
                            <div class="card card-animate bg-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-white-50 mb-0">Count Uses</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="0">0</span></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-light rounded fs-3 shadow">
                                                <i class="bx bx-shopping-bag text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            </div><!-- End Page-content -->

            <?php include "../../layout/footer.template.php" ?>
        </div><!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Grids in modals -->
    <div class="modal fade" id="modalAddress" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                        <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">First Name</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter first name">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">Last Name</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter last name">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">Street and Number</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter the street and number">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">Postal Code</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter the postal code">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">Province</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select a province</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="roleInput" class="form-label">City</label>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected disabled>Select a city</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Phone</label>
                                    <input type="phone" class="form-control" id="phoneInput" placeholder="Enter a phone number">
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
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this address?</p>
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

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
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