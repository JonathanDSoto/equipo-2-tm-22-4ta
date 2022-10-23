<?php
	include_once "../../app/config.php";
    include_once '../../app/ClientController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $customerControl = new ClientController();
    $customersData = $customerControl -> getClienteEspecifico($_GET['id']); /* MODIFICAR ESTA VARIABLE GET POR "ID" */
    //var_dump($customersData);

    if(!isset($customersData)) {
        header('location: '.BASE_PATH.'customers');
    }

    $customerTotalOrders = $customerControl -> getTotalOrders($_GET['id']);
    //var_dump($customerTotalOrders);
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Profile</title>
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
                                <h4 class="mb-sm-0">Customer Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a>Ecommerce</a></li>
                                        <li class="breadcrumb-item active">Customer Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div>
                                        <div class="mt-4 text-center">
                                            <h5 class="mb-1"><?php if(isset($customersData->name)) echo $customersData->name; else echo "Name not found."; ?></h5>
                                            <p class="text-muted">Customer</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th><span class="fw-medium">Customer ID</span></th>
                                                        <td><?php if(isset($customersData->id)) echo $customersData->id; else echo "ID not found."; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Email</span></th>
                                                        <td><?php if(isset($customersData->email)) echo $customersData->email; else echo "Email not found."; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Phone Number</span></th>
                                                        <td>
                                                            <?php 
                                                                if(isset($customersData->phone_number)) {
                                                                    if(is_numeric($customersData->phone_number)) {
                                                                        echo $customersData->phone_number; 
                                                                    }else {
                                                                        echo "Invalid phone number, there are characters.";
                                                                    }
                                                                } else {
                                                                    echo "Phone number not found."; 
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Subscribed</span></th>
                                                        <td>
                                                            <?php
                                                                if(isset($customersData->is_suscribed)) {
                                                                    switch ($customersData->is_suscribed) {
                                                                        case '0':
                                                                            echo '<span class="badge bg-danger">No</span>';
                                                                            break;
                                                                        case '1':
                                                                            echo '<span class="badge bg-success">Yes</span>';
                                                                            break;
                                                                        default:
                                                                            echo $customersData->is_suscribed;
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "Suscription information not found.";
                                                                } 
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Percentage discount</span></th>
                                                        <td>
                                                            <?php 
                                                                if(isset($customersData->level_id)&&isset($customersData->level)&&isset($customersData->level->percentage_discount)) {
                                                                    switch ($customersData->level->id) {
                                                                        case '1':
                                                                            echo '<span class="badge bg-dark bg-opacity-50">'.$customersData->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        case '2':
                                                                            echo '<span class="badge bg-secondary bg-opacity-85">'.$customersData->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        case '3':
                                                                            echo '<span class="badge bg-success bg-opacity-85">'.$customersData->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        default:
                                                                            echo $customersData->level->percentage_discount.'% OFF';
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "Percentage discount not found.";
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                        <div class="col-xxl-9">
                            <div class="row">
                                <!-- CUSTOMER LEVEL -->
                                <div class="col-xxl-6">
                                    <!-- card -->
                                    <div class="card card-animate <?php if(isset($customersData->level_id)) switch ($customersData->level->id) { case '1': echo 'bg-success'; break; case '2': echo 'bg-secondary'; break; case '3': echo 'bg-primary'; break; default: echo 'bg-success'; break; }?>">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <p class="text-uppercase fw-medium text-white-50 mb-0">Customer Level</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white">
                                                        <span class="counter-value" data-target="<?php if(isset($customersData->level_id)) echo $customersData->level_id; else echo ''; ?>"></span>
                                                        <?php if(isset($customersData->level->id)&&isset($customersData->level->name)) echo ' - '.$customersData->level->name; else echo ''; ?>
                                                    </h4>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3 shadow">
                                                        <i class="bx bx-user-circle text-white"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                                <!-- CUSTOMER TOTAL ORDERS -->
                                <div class="col-xxl-6">
                                    <!-- card -->
                                    <div class="card card-animate bg-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <p class="text-uppercase fw-medium text-white-50 mb-0">Total Orders</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white">$<span class="counter-value" data-target="<?= $customerTotalOrders ?>"></span></h4>
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
                            </div>

                            <!-- TABLES - MORE INFO -->
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#Address" role="tab">
                                                <i class="fas fa-home"></i> Address
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#Orders" role="tab">
                                                <i class="far fa-user"></i> Orders
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <!-- ADDRESS -->
                                        <div class="tab-pane active" id="Address" role="tabpanel">
                                            <div class="col-sm-auto">
                                                <div class="mb-4">
                                                    <button onclick="addAddress(<?= $customersData->id ?>)" type="button" data-bs-toggle="modal" data-bs-target="#modalAddress" class="btn btn-success btn-sm btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Address</button>
                                                </div>
                                            </div>
                                            <table id="tableCustomerDetailsAddress" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">First Name</th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Street & Number</th>
                                                        <th scope="col">Apartment</th>
                                                        <th scope="col">Postal Code</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col">Province</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Billing Address</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($customersData->addresses as $item): ?>
                                                        <tr>
                                                            <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                            <td><?php if(isset($item->first_name)) echo $item->first_name; else echo "First name not found."; ?></td>
                                                            <td><?php if(isset($item->last_name)) echo $item->last_name; else echo "Last name not found."; ?></td>
                                                            <td><?php if(isset($item->street_and_use_number)) echo $item->street_and_use_number; else echo "Street and number not found."; ?></td>
                                                            <td>
                                                                <?php 
                                                                    if(isset($item->apartment)) {
                                                                        if($item->apartment!=null) {
                                                                            echo $item->apartment;
                                                                        } else {
                                                                            echo 'Not apply.';
                                                                        }
                                                                    } else {
                                                                        echo "Not apply."; 
                                                                    }
                                                                ?>
                                                                </td>
                                                            <td><?php if(isset($item->postal_code)) echo $item->postal_code; else echo "Postal code not found."; ?></td>
                                                            <td><?php if(isset($item->city)) echo $item->city; else echo "City not found."; ?></td>
                                                            <td><?php if(isset($item->province)) echo $item->province; else echo "Province not found."; ?></td>
                                                            <td><?php if(isset($item->phone_number)) echo $item->phone_number; else echo "Phone number not found."; ?></td>
                                                            <td>
                                                                <?php
                                                                    if(isset($item->is_billing_address)) {
                                                                        switch ($item->is_billing_address) {
                                                                            case '0':
                                                                                echo '<span class="badge bg-danger">No</span>';
                                                                                break;
                                                                            case '1':
                                                                                echo '<span class="badge bg-success">Yes</span>';
                                                                                break;
                                                                            default:
                                                                                echo $item->is_billing_address;
                                                                                break;
                                                                        }
                                                                    } else {
                                                                        echo "Billing Address not found.";
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown ms-2">
                                                                    <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="ri-more-2-fill"></i>
                                                                    </a>                
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <li><a class="dropdown-item" data-address='<?php echo json_encode($item)?>' onclick="editAddress(this)"  data-bs-toggle="modal" data-bs-target="#modalAddress" href="#">Edit</a></li>
                                                                        <li><a class="dropdown-item" onclick="removeAddress(<?= $customersData->id.', '.$item->id ?>)">Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end tab-pane-->

                                        <!-- ORDERS -->
                                        <div class="tab-pane" id="Orders" role="tabpanel">
                                            <table id="tableCustomerDetailsOrders" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Folio</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Payment Type</th>
                                                        <th scope="col">Coupon</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Paid out</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($customersData->orders as $item): ?>
                                                        <tr>
                                                            <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                            <td><?php if(isset($item->folio)) echo $item->folio; else echo "Folio not found."; ?></td>
                                                            <td><?php if(isset($item->address_id)) echo $item->address_id; else echo "Address not found."; ?></td>
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
                                                            <td>
                                                                <?php 
                                                                    if(isset($item->coupon)) {
                                                                        if(isset($item->coupon->id)&&isset($item->coupon->name)){
                                                                            echo $item->coupon->name;
                                                                        } else {
                                                                            echo 'ID #'.$item->coupon->id. '- Description not found.';
                                                                        }
                                                                    } else {
                                                                        echo "No coupon.";
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
    <div class="modal fade" id="modalAddress" tabindex="-1" aria-labelledby="addressModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= BASE_PATH ?>address">
                        <div class="row g-3">
                        <div class="col-xxl-6">
                                <div>
                                    <label for="first_name" class="form-label">First Name*</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" onkeypress="return onlyLettersAndSpaces(event)" placeholder="Enter first name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="last_name" class="form-label">Last Name*</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" onkeypress="return onlyLettersAndSpaces(event)" placeholder="Enter last name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="street_and_number" class="form-label">Street and Number*</label>
                                    <input type="text" class="form-control" id="street_and_number" name="street_and_number" onkeypress="return streetAndNumber(event)" placeholder="Enter the street and number" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="postal_code" class="form-label">Postal Code*</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" onkeypress="return onlyNumbers(event)" placeholder="Enter the postal code" maxlength="5" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="province" class="form-label">Province*</label>
                                    <input type="text" class="form-control" id="province" name="province" onkeypress="return onlyLettersAndSpaces(event)" placeholder="Enter the province" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="city" class="form-label">City*</label>
                                    <input type="text" class="form-control" id="city" name="city" onkeypress="return onlyLettersAndSpaces(event)" placeholder="Enter the city" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phone_number" class="form-label">Phone number*</label>
                                    <input type="phone" class="form-control" id="phone_number" name="phone_number" onkeypress="return onlyNumbers(event)" placeholder="Enter a phone number" minlenght="10" maxlength="10" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="is_billing_address" class="form-label">Use as billing address*</label>
                                <div class="input-group">
                                    <select class="form-select" id="is_billing_address" name="is_billing_address" required>
                                        <option value="" selected disabled>Select an option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <input type="checkbox" class="form-check-input" id="checkApartment" name="checkApartment">
                                    <label for="apartment" class="form-label">Apartment</label>
                                    <input type="text" class="form-control" id="apartment" name="apartment" onkeypress="" placeholder="Enter the apartment" hidden=true>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" id="typeAction" name="action" value="">
                                    <input type="hidden" id="costumer_id" name="costumer_id">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
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

<script>
    document.getElementById('checkApartment').addEventListener('click', function handleClick() {
        if (document.getElementById('checkApartment').checked) {
            document.getElementById('apartment').hidden = false;
        } else {
            document.getElementById('apartment').hidden = true;
            document.getElementById("apartment").value = "";
        }
    });

    function removeAddress(client_id, id) {
        swal({
            title: "Are you sure you want to remove this address?",
            text: "You will not be able to recover this address!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The address has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('client_id', client_id);
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>address', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                //console.log(error);
                alert("An error occurred while performing the action.");
            });

        } else {
            swal("This address is safe!");
        }
        });
    }

    function addAddress(costumer_id) {
        document.getElementById("typeAction").value = "create";
        document.getElementById("addressModalLabel").innerHTML = "Add new address";

        document.getElementById("first_name").value = "";
        document.getElementById("last_name").value = "";
        document.getElementById("street_and_number").value = "";
        document.getElementById("postal_code").value = "";
        document.getElementById("province").value = "";
        document.getElementById("city").value = "";
        document.getElementById("phone_number").value = "";
        document.getElementById("is_billing_address").selectedIndex = 0;
        document.getElementById('checkApartment').checked = false;
        document.getElementById("apartment").value = "";
        document.getElementById("costumer_id").value = costumer_id;
        document.getElementById("id").value = "";
    }

    function editAddress(target) {
        let address = JSON.parse(target.getAttribute('data-address'));
        document.getElementById("typeAction").value = "update";
        document.getElementById("addressModalLabel").innerHTML = "Edit address";

        document.getElementById("first_name").value = address.first_name;
        document.getElementById("last_name").value = address.last_name;
        document.getElementById("street_and_number").value = address.street_and_use_number;
        document.getElementById("postal_code").value = address.postal_code;
        document.getElementById("province").value = address.province;
        document.getElementById("city").value = address.city;
        document.getElementById("phone_number").value = address.phone_number;
        if(address.is_billing_address==1) {
            document.getElementById("is_billing_address").selectedIndex = 1;
        } else if(address.is_billing_address==0) {
            document.getElementById("is_billing_address").selectedIndex = 2;
        } else {
            document.getElementById("is_billing_address").selectedIndex = 0;
        }
        if(address.apartment!=null) {
            document.getElementById('checkApartment').checked = true;
            document.getElementById("apartment").value = address.apartment;
            document.getElementById('apartment').hidden = false;
        } else {
            document.getElementById('checkApartment').checked = false;
            document.getElementById("apartment").value = "";
            document.getElementById('apartment').hidden = true;
        }
        document.getElementById("costumer_id").value = address.client_id;
        document.getElementById("id").value = address.id;
    }
</script>

</html>