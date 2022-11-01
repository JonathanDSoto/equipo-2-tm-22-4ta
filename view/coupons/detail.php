<?php
	include_once "../../app/config.php";
    include_once '../../app/CuponController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    $couponControl = new CuponController();
    $couponsAll = $couponControl -> getCupons();
    foreach ($couponsAll as $coupon) {
        if($coupon->code==$_GET['code']) {
            $couponsData = $couponControl -> getEspecificCoupon($coupon->id);
            break;
        }
    }

    if(!isset($couponsData)) {
        header('location: '.BASE_PATH.'coupons');
    }

    $couponDiscount = $couponControl->getTotalDiscount($couponsData->id);
    $couponCountUses = $couponControl->getCountUses($couponsData->id);
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
                                                                <td><?php if(isset($couponsData->name)) echo $couponsData->name; else echo "Name not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Code</span></th>
                                                                <td><?php if(isset($couponsData->code)) echo $couponsData->code; else echo "Code not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Discount</span></th>
                                                                <td>
                                                                    <?php 
                                                                        if(isset($couponsData->couponable_type)) {
                                                                            if($couponsData->couponable_type=="Cupon de descuento fijo") {
                                                                                if(isset($couponsData->amount_discount)) {
                                                                                    echo $couponsData->amount_discount.' MXN';
                                                                                } else {
                                                                                    echo 'Amount discount not found.';
                                                                                }
                                                                            } else if($couponsData->couponable_type=="Cupon de descuento") {
                                                                                if(isset($couponsData->percentage_discount)) {
                                                                                    echo $couponsData->percentage_discount.'%';
                                                                                } else {
                                                                                    echo 'Percentage discount not found.';
                                                                                }
                                                                            } else {
                                                                                echo "Discount not found.";
                                                                            }
                                                                        } else {
                                                                            if(isset($couponsData->amount_discount)||isset($couponsData->percentage_discount)) {
                                                                                if(isset($couponsData->amount_discount)&&$coupon->amount_discount!='0'){
                                                                                    echo $couponsData->amount_discount.' MXN';
                                                                                } else if(isset($couponsData->percentage_discount)&&$coupon->percentage_discount!='0') {
                                                                                    echo $couponsData->percentage_discount.'%';
                                                                                }
                                                                            } else {
                                                                                echo 'Discount not found.';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Minimum Amount</span></th>
                                                                <td><?php if(isset($couponsData->min_amount_required)) echo $couponsData->min_amount_required; else echo "Minimum amount not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Minimum Products</span></th>
                                                                <td><?php if(isset($couponsData->min_product_required)) echo $couponsData->min_product_required; else echo "Minimum products not found."; ?></td>
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
                                                                <td><?php if(isset($couponsData->start_date)) echo $couponsData->start_date; else echo "Start date not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">End Date</span></th>
                                                                <td><?php if(isset($couponsData->end_date)) echo $couponsData->end_date; else echo "End date not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Maximum Uses</span></th>
                                                                <td><?php if(isset($couponsData->max_uses)) echo $couponsData->max_uses; else echo "Max uses not found."; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Only Firtst Purchase</span></th>
                                                                <td>
                                                                    <?php
                                                                        if(isset($couponsData->valid_only_first_purchase)) {
                                                                            switch ($couponsData->valid_only_first_purchase) {
                                                                                case '0':
                                                                                    echo '<span class="badge bg-danger">No</span>';
                                                                                    break;
                                                                                case '1':
                                                                                    echo '<span class="badge bg-success">Yes</span>';
                                                                                    break;
                                                                                default:
                                                                                    echo '<span class="badge bg-dark bg-opacity-50">Unknown</span>';
                                                                                    break;
                                                                            }
                                                                        } else {
                                                                            echo "First purchase info not found.";
                                                                        } 
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-medium">Status</span></th>
                                                                <td>
                                                                    <?php
                                                                        if(isset($couponsData->status)) {
                                                                            switch ($couponsData->status) {
                                                                                case '0':
                                                                                    echo '<span class="badge bg-danger">Inactive</span>';
                                                                                    break;
                                                                                case '1':
                                                                                    echo '<span class="badge bg-success">Active</span>';
                                                                                    break;
                                                                                default:
                                                                                    echo '<span class="badge bg-dark bg-opacity-50">Unknown</span>';
                                                                                    break;
                                                                            }
                                                                        } else {
                                                                            echo "Status not found.";
                                                                        } 
                                                                    ?>
                                                                </td>
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
                                            <table id="tableCouponsDetailsOrders" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Folio</th>
                                                        <th scope="col">Customer ID</th>
                                                        <th scope="col">Address ID</th>
                                                        <th scope="col">Payment Type</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Paid out</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($couponsData->orders as $item): ?>
                                                        <tr>
                                                            <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                            <td><?php if(isset($item->folio)) echo $item->folio; else echo "Folio not found."; ?></td>
                                                            <td><?php if(isset($item->client_id)) echo $item->client_id; else echo "Customer ID not found."; ?></td>
                                                            <td><?php if(isset($item->address_id)) echo $item->address_id; else echo "Address ID not found."; ?></td>
                                                            <td>
                                                                <?php 
                                                                    if(isset($item->payment_type_id)) {
                                                                        switch ($item->payment_type_id) {
                                                                            case '1':
                                                                                echo "Cash";
                                                                                break;
                                                                            case '2':
                                                                                echo "Card";
                                                                                break;
                                                                            case '3':
                                                                                echo "Transfer";
                                                                                break;
                                                                            default:
                                                                                echo $item->payment_type_id;
                                                                                break;
                                                                        }
                                                                    } else {
                                                                        echo "Payment type not found.";
                                                                    }  
                                                                ?>
                                                            </td>
                                                            <td><?php if(isset($item->total)) echo '$'.$item->total; else echo "Total not found."; ?></td>
                                                            <td>
                                                                <?php 
                                                                    if(isset($item->is_paid)){
                                                                        switch ($item->is_paid) {
                                                                            case '0':
                                                                                echo "Unpaid";
                                                                                break;
                                                                            case '1':
                                                                                echo "Paid";
                                                                                break;
                                                                            default:
                                                                                echo $item->is_paid;
                                                                                break;
                                                                        }
                                                                    }else {
                                                                        echo "Paid info not found.";
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if(isset($item->order_status_id)) {
                                                                        switch ($item->order_status_id) {
                                                                            case '1':
                                                                                echo '<span class="badge bg-warning">Pendiente de pago</span>';
                                                                                break;
                                                                            case '2':
                                                                                echo '<span class="badge bg-success">Pagada</span>';
                                                                                break;
                                                                            case '3':
                                                                                echo '<span class="badge bg-info">Enviada</span>';
                                                                                break;
                                                                            case '4':
                                                                                echo '<span class="badge bg-soft-dark">Abandonada</span>';
                                                                                break;
                                                                            case '5':
                                                                                echo '<span class="badge bg-secondary">Pendiente de enviar</span>';
                                                                                break;
                                                                            case '6':
                                                                                echo '<span class="badge bg-danger">Cancelada</span>';
                                                                                break;
                                                                            default:
                                                                                echo $item->order_status_id;
                                                                            break;
                                                                        }
                                                                    } else {
                                                                        echo "Status not found.";
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
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
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="<?php if(isset($couponCountUses)) echo number_format((float)$couponCountUses, 2, '.', ''); else echo 0; ?>"></span></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-light rounded fs-3 shadow">
                                                <i class="bx bx-shopping-bag text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                            <div class="card card-animate bg-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-white-50 mb-0">Discounted Totals</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white">$<span class="counter-value" data-target="<?php if(isset($couponDiscount)) echo number_format((float)$couponDiscount, 2, '.', ''); else echo 0; ?>"></span></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-light rounded fs-3 shadow">
                                                <i class="bx bx-wallet text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
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