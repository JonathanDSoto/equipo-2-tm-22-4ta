<?php
	include_once "../../app/config.php";
    include_once '../../app/OrderController.php';
    include_once '../../app/ProdController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    $orderControl = new OrderController();
    $ordersAll = $orderControl -> getOrders();
    foreach ($ordersAll as $order) {
        if($order->folio==$_GET['folio']) {
            $ordersData = $orderControl -> getSpecificOrder($order->id);
            break;
        }
    }

    if(!isset($ordersData)) {
        header('location: '.BASE_PATH.'orders');
    }

    $productControl = new ProdController();
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Order Detail</title>
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
                                <h4 class="mb-sm-0">Order detail</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Order detail</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Content -->

                    <div class="row">
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title flex-grow-1 mb-0">Folio #VL2667</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-nowrap align-middle table-borderless mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col">Product Details</th>
                                                    <th scope="col">Presentation</th>
                                                    <th scope="col">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ordersData->presentations as $item): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 bg-light rounded p-1">
                                                                    <img src="<?php if(isset($item->cover)) echo 'https://crud.jonathansoto.mx/storage/products/'.$item->cover; else echo ""; ?>" alt="Cover not found" class="avatar-md d-block">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <?php 
                                                                        if(isset($item->product)) {
                                                                            if(isset($item->product->slug)) {
                                                                                $productSlug = $item->product->slug;
                                                                            }
                                                                        } else {
                                                                            $productSlug = "non-existent-product";
                                                                        }
                                                                    ?>
                                                                    <h5 class="fs-15"><a href="<?= BASE_PATH.'products/'.$productSlug ?>" class="link-primary"><?= $item->description ?></a></h5>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?php if(isset($item->code)) echo $item->code; else echo "Code not found."; ?></td>
                                                        <td><?php if(isset($item->pivot->quantity)) echo $item->pivot->quantity; else echo "Quantity not found."; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr class="border-top border-top-dashed">
                                                    <td colspan="2"></td>
                                                    <td colspan="1" class="fw-medium p-0">
                                                        <table class="table table-borderless mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Discount <span class="text-muted text-uppercase"><?php if(isset($ordersData->coupon)&&isset($ordersData->coupon->code)) echo '('.$ordersData->coupon->code.')'; else echo "(No coupon)"; ?></span> :</td>
                                                                    <td class="text-end">
                                                                        <?php 
                                                                            if(isset($ordersData->coupon->couponable_type)) {
                                                                                if($ordersData->coupon->couponable_type=="Cupon de descuento fijo") {
                                                                                    if(isset($ordersData->coupon->amount_discount)) {
                                                                                        echo $ordersData->coupon->amount_discount.' MXN';
                                                                                    } else {
                                                                                        echo 'Amount discount not found.';
                                                                                    }
                                                                                } else if($ordersData->coupon->couponable_type=="Cupon de descuento") {
                                                                                    if(isset($ordersData->coupon->percentage_discount)) {
                                                                                        echo $ordersData->coupon->percentage_discount.'%';
                                                                                    } else {
                                                                                        echo 'Percentage discount not found.';
                                                                                    }
                                                                                } else {
                                                                                    echo "Not apply.";
                                                                                }
                                                                            } else {
                                                                                if(isset($ordersData->coupon->amount_discount)||isset($ordersData->coupon->percentage_discount)) {
                                                                                    if(isset($ordersData->coupon->amount_discount)&&$coupon->amount_discount!='0'){
                                                                                        echo $ordersData->coupon->amount_discount.' MXN';
                                                                                    } else if(isset($ordersData->coupon->percentage_discount)&&$coupon->percentage_discount!='0') {
                                                                                        echo $ordersData->coupon->percentage_discount.'%';
                                                                                    }
                                                                                } else {
                                                                                    echo "Not apply.";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr class="border-top border-top-dashed">
                                                                    <th scope="row">Total :</th>
                                                                    <th class="text-end"><?php if(isset($ordersData->total)) echo '$'.$ordersData->total; else echo "Total not found."; ?></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-sm-flex align-items-center">
                                        <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                                            <?php
                                                if(isset($ordersData->order_status->id)) {
                                                    switch ($ordersData->order_status->id) {
                                                        case '1':
                                                            echo '<a class="btn btn-warning btn-sm mt-2 mt-sm-0 shadow-none">Pendiente de pago</a>';
                                                            break;
                                                        case '2':
                                                            echo '<a class="btn btn-success btn-sm mt-2 mt-sm-0 shadow-none">Pagada</a>';
                                                            break;
                                                        case '3':
                                                            echo '<a class="btn btn-info btn-sm mt-2 mt-sm-0 shadow-none">Enviada</a>';
                                                            break;
                                                        case '4':
                                                            echo '<a class="btn btn-soft-dark btn-sm mt-2 mt-sm-0 shadow-none">Abandonada</a>';
                                                            break;
                                                        case '5':
                                                            echo '<a class="btn btn-secondary btn-sm mt-2 mt-sm-0 shadow-none">Pendiente de enviar</a>';
                                                            break;
                                                        case '6':
                                                            echo '<a class="btn btn-danger btn-sm mt-2 mt-sm-0 shadow-none">Cancelada</a>';
                                                            break;
                                                        default:
                                                            echo $ordersData->order_status->id;
                                                        break;
                                                    }
                                                } else {
                                                    echo "Status not found.";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                                        <div class="flex-shrink-0">
                                            <a href="<?= BASE_PATH.'customers/'.$ordersData->client_id?>" class="link-secondary">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0 vstack gap-3">
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-16 mb-1"><?php if(isset($ordersData->client->name)) echo $ordersData->client->name; else echo "Name not found."; ?></h6>
                                                    <p class="text-muted mb-0">Customer</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i><?php if(isset($ordersData->client->email)) echo $ordersData->client->email; else echo "Email not found."; ?></li>
                                        <li>
                                            <i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>
                                            <?php 
                                                if(isset($ordersData->client->phone_number)) {
                                                    if(is_numeric($ordersData->client->phone_number)) {
                                                        echo $ordersData->client->phone_number;
                                                    }else {
                                                        echo 'Invalid phone, there are characters.';
                                                    }
                                                } else {
                                                    echo 'Phone not found.';
                                                }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                        <li class="fw-medium fs-14"><?php if(isset($ordersData->address->first_name)) echo $ordersData->address->first_name; else echo "First name not found."; ?> <?php if(isset($ordersData->address->last_name)) echo $ordersData->address->last_name; else echo "Last name not found."; ?></li>
                                        <li>
                                            <?php 
                                                if(isset($ordersData->address->phone_number)) {
                                                    if(is_numeric($ordersData->address->phone_number)) {
                                                        echo $ordersData->address->phone_number;
                                                    }else {
                                                        echo 'Invalid phone, there are characters.';
                                                    }
                                                } else {
                                                    echo 'Phone not found.';
                                                }
                                            ?>
                                        </li>
                                        <li><?php if(isset($ordersData->address->street_and_use_number)) echo $ordersData->address->street_and_use_number; else echo "Street and number not found."; ?></li>
                                        <li><?php if(isset($ordersData->address->city)) echo $ordersData->address->city; else echo "City not found."; ?> - <?php if(isset($ordersData->address->postal_code)) echo $ordersData->address->postal_code; else echo "Postal code not found."; ?></li>
                                        <li><?php if(isset($ordersData->address->province)) echo $ordersData->address->province; else echo "Province not found."; ?></li>
                                    </ul>
                                </div>
                            </div>
                            <!--end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <p class="text-muted mb-0">Paid Out:</p>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <?php
                                                if(isset($ordersData->is_paid)) {
                                                    switch ($ordersData->is_paid) {
                                                        case '0':
                                                            echo '<span class="badge bg-danger">Unpaid</span>';
                                                            break;
                                                        case '1':
                                                            echo '<span class="badge bg-success">Paid</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge bg-dark bg-opacity-50">Unknown</span>';
                                                            break;
                                                    }
                                                } else {
                                                    echo "Paid info not found.";
                                                } 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <p class="text-muted mb-0">Payment Type:</p>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">
                                                <?php 
                                                    if(isset($ordersData->payment_type_id)) {
                                                        switch ($ordersData->payment_type_id) {
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
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <p class="text-muted mb-0">Total Amount:</p>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0"><?php if(isset($ordersData->total)) echo '$'.$ordersData->total; else echo "Total not found."; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "../../layout/footer.template.php" ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

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