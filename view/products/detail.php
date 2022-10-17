<?php
	include_once "../../app/config.php"
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Product Detail</title>
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
                                <h4 class="mb-sm-0">Product Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a>Ecommerce</a></li>
                                        <li class="breadcrumb-item active">Product Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row gx-lg-5">
                                        <div class="col-xl-4 col-md-8 mx-auto">
                                            <div class="product-img-slider sticky-side-div">
                                                <div class="product-thumbnail-slider p-2 rounded bg-light">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="<?= BASE_PATH ?>public/images/products/img-8.png" alt="" class="img-fluid d-block" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end swiper thumbnail slide -->
                                                
                                                <!-- end swiper nav slide -->
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-xl-8">
                                            <div class="mt-xl-0 mt-5">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h4>Full Sleeve Sweatshirt for Men (Pink)</h4>
                                                        <div class="hstack gap-1 flex-wrap">
                                                            <div><a href="#" class="badge rounded-pill text-bg-primary">Category</a></div>
                                                            <div><a href="#" class="badge rounded-pill text-bg-primary">Category</a></div>
                                                            <div class="vr mx-2"></div>
                                                            <div><a href="#" class="badge rounded-pill text-bg-secondary">Tag</a></div>
                                                            <div><a href="#" class="badge rounded-pill text-bg-secondary">Tag</a></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-muted">
                                                    <h5 class="fs-14">Description :</h5>
                                                    <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton. Material composition is 100% organic cotton. This is one of the world’s leading designer lifestyle brands and is internationally recognized for celebrating the essence of classic American cool style, featuring preppy with a twist designs.</p>
                                                </div>

                                                <!-- <div class="row mt-4">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-file-copy-2-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">No. of Orders :</p>
                                                                    <h5 class="mb-0">2,234</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-stack-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Available Stocks :</p>
                                                                    <h5 class="mb-0">1,230</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            
                                                <div class="product-content mt-2">
                                                    <h5 class="fs-14 mb-3">Product Description :</h5>
                                                    <nav>
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Specification</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Presentations</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-detail" aria-selected="false">Orders</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <tbody>
                                                                    <tr>
                                                                            <th scope="row" style="width: 200px;">Features</th>
                                                                            <td>La lavadora cuenta con capacidad de lavado de 18 kg, diseño exterior de color gris, su funcionamiento integra tecnología air bubble 4d, sistema de lavado por pulsador, 5 ciclos de lavado mas ciclo ariel , tina de acero inoxidable, 9 niveles de agua y 3 niveles de temperatura. Ofrece llenado con cascada de agua waterrfall, timer para inicio retardado y manija de apertura ez soft</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Brand</th>
                                                                            <td>Tommy Hilfiger</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Slug</th>
                                                                            <td>Blue</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                <div>
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalPresentation" class="btn btn-success btn-sm btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Presentation</button>
                                                                </div>
                                                                <table class="table table-nowrap">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Code</th>
                                                                            <th scope="col">Description</th>
                                                                            <th scope="col">Weight</th>
                                                                            <th scope="col">Minimums Stock</th>
                                                                            <th scope="col">Maximum Stock</th>
                                                                            <th scope="col">Stock</th>
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
                                                                            <td><span class="badge bg-success">active</span></td>
                                                                            <td>
                                                                                <div class="dropdown ms-2">
                                                                                    <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                        <i class="ri-more-2-fill"></i>
                                                                                    </a>
                                                                                
                                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                        <li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modalPresentation" href="#">Edit</a></li>
                                                                                        <li><a class="dropdown-item " data-bs-toggle="modal" data-bs-target="#removeItemModal" href="#">Delete</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                <table class="table table-nowrap">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Folio</th>
                                                                            <th scope="col">Customer</th>
                                                                            <th scope="col">Address</th>
                                                                            <th scope="col">Payment Type</th>
                                                                            <th scope="col">Presentation</th>
                                                                            <th scope="col">Quantity</th>
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
                                                                            <td>$2,300</td>
                                                                            <td>$2,300</td>
                                                                            <td><span class="badge bg-success">active</span></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product-content -->
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
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

    <!-- Grids in modals -->
    <div class="modal fade" id="modalPresentation" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Presentation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="firstName" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter description">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="lastName" class="form-label">Weight</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter weight">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="emailInput" class="form-label">Minimum Stock</label>
                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter min stock">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Maximum Stock</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter max stock">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phoneInput" class="form-label">Stock</label>
                                    <input type="text" class="form-control" id="phoneInput" placeholder="Enter stock avaliable">
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
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove it?</p>
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