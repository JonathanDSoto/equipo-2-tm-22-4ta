<?php
	include_once "../../app/config.php";
    include_once '../../app/OrderController.php';
    include_once '../../app/ClientController.php';
    include_once '../../app/ProdController.php';
    include_once '../../app/PresController.php';
    include_once '../../app/AddressController.php';
    include_once '../../app/CuponController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $orderControl = new OrderController();
    $presentationControl = new PresController();
    $addressControl = new AddressController();

    $clientControl = new ClientController();
    $clients = $clientControl -> getClientes();

    $productControl = new ProdController();
    $products = $productControl -> getTodo();

    $cuponControl = new CuponController();
    $coupons = $cuponControl -> getCupons();

    if(isset($_SESSION['ordersByDates'])&&count($_SESSION['ordersByDates'])>0) {
        $orders = $_SESSION['ordersByDates'];
    } else {
        $orders = $orderControl -> getOrders();
    }
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
                        <div class="col-xl-12 col-lg-12">
                            <div>
                                <div class="card">
                                    <div class="card-header border-0">
                                        <div class="row g-3">
                                            <div class="col-xxl-6 col-sm-4">
                                                <div>
                                                    <button onclick="createOrder()" type="button" data-bs-toggle="modal" data-bs-target="#modalOrder" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Order</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <form id="formDates" method="post" action="<?= BASE_PATH ?>order" onsubmit="event.preventDefault();">
                                                <div class="row">
                                                    <!-- START DATE -->
                                                    <div class="col-xxl-5 col-sm-4">
                                                        <input type="date" class="form-control" id="fecha_1" name="fecha_1" onkeydown="return false" required>
                                                    </div>
                                                    <!-- END DATE -->
                                                    <div class="col-xxl-5 col-sm-4">
                                                        <input type="date" class="form-control" id="fecha_2" name="fecha_2" onkeydown="return false" required>
                                                    </div>
                                                    <!-- SUBMIT DATE -->
                                                    <div class="col-xxl-2 col-sm-4">
                                                        <div>
                                                            <input type="hidden" id="typeActionDates" name="action" value="check_date">
                                                            <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                                            <button type="submit" class="btn btn-primary w-100" onclick="searchDataPerDates();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                                                Filter by date
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- TABLA ORDERS -->
                                    <div class="card-body">
                                        <?php
                                            if(isset($_SESSION['ordersByDates'])&&count($_SESSION['ordersByDates'])>0) {
                                                echo '<h3>Showing orders from '.$_SESSION['date_1'].' to '.$_SESSION['date_2'].'</h3>';
                                            }
                                        ?>
                                        <table id="tableOrders" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Folio</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Payment Type</th>
                                                    <th scope="col">Coupon</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Paid out</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $item): ?>
                                                    <tr>
                                                        <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                        <td><?php if(isset($item->folio)) echo $item->folio; else echo "Folio not found."; ?></td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->client)){
                                                                    if(isset($item->client->id)) echo '<span><strong>ID: </strong>'.$item->client->id.'</span><br class="mb-0">'; else echo '<span><strong>ID: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->client->name)) echo '<span><strong>Name: </strong>'.$item->client->name.'</span><br class="mb-0">'; else echo '<span><strong>Name: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->client->email)) echo '<span><strong>Email: </strong>'.$item->client->email.'</span><br class="mb-0">'; else echo '<span><strong>Email: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->client->phone_number)) {
                                                                        if(is_numeric($item->client->phone_number)) {
                                                                            echo '<span><strong>Phone: </strong>'.$item->client->phone_number.'</span>';
                                                                        }else {
                                                                            echo '<span><strong>Phone:</strong> Invalid, there are characters.</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span><strong>Phone:</strong> Not found.</span';
                                                                    }
                                                                } else if(isset($item->client_id)) {
                                                                    echo 'Customer ID #'.$item->client_id.' - Info not found.';
                                                                } else {
                                                                    echo 'Client not found.';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->address)){
                                                                    if(isset($item->address->id)) echo '<span><strong>ID: </strong>'.$item->address->id.'</span><br class="mb-0">'; else echo '<span><strong>ID: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->address->street_and_use_number)) echo '<span><strong>Street and number: </strong>'.$item->address->street_and_use_number.'</span><br class="mb-0">'; else echo '<span><strong>Street and number: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->address->city)) echo '<span><strong>City: </strong>'.$item->address->city.'</span><br class="mb-0">'; else echo '<span><strong>City: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->address->province)) echo '<span><strong>Province: </strong>'.$item->address->province.'</span><br class="mb-0">'; else echo '<span><strong>Province: </strong>Not found.</span><br class="mb-0">';
                                                                    if(isset($item->address->postal_code)) {
                                                                        if(is_numeric($item->address->postal_code)) {
                                                                            echo '<span><strong>Postal code: </strong>'.$item->address->postal_code.'</span><br class="mb-0">'; 
                                                                        }else {
                                                                            echo '<span><strong>Postal code:</strong> Invalid, there are characters.</span><br class="mb-0">';
                                                                        }
                                                                    } else {
                                                                        echo '<span"><strong>Postal code:</strong> Not found.</span><br class="mb-0">';
                                                                    }
                                                                    if(isset($item->address->phone_number)) {
                                                                        if(is_numeric($item->address->phone_number)) {
                                                                            echo '<span><strong>Phone: </strong>'.$item->address->phone_number.'</span>';; 
                                                                        }else {
                                                                            echo '<span><strong>Phone:</strong> Invalid, there are characters.</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span><strong>Phone:</strong> Not found.</span';
                                                                    }
                                                                } else if(isset($item->address_id)) {
                                                                    echo 'Address ID: #'.$item->address_id.' - Info not found.';
                                                                } else {
                                                                    echo 'Address not found.';
                                                                }
                                                            ?>
                                                        </td>
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
                                                        <td><?php if(isset($item->coupon)) echo $item->coupon->name; else echo "It wasn't used."; ?></td>
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
                                                        <td>
                                                            <div class="dropdown ms-2">
                                                                <a class="btn btn-sm btn-light" style="cursor: pointer;" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>                
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item" href="<?= BASE_PATH.'orders/'.$item->folio?>">View</a></li>
                                                                    <li><a class="dropdown-item"  data-order='<?php echo json_encode($item)?>' onclick="editOrder(this)" data-bs-toggle="modal" data-bs-target="#modalOrder" href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item " onclick="remove(<?php echo $item->id ?>)">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    endforeach;
                                                    if(isset($_SESSION['ordersByDates'])&&count($_SESSION['ordersByDates'])>0) {
                                                        $_SESSION['ordersByDates'] = null;
                                                    }
                                                ?>
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

    <!-- Grids in modals -->
    <div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="orderModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ordersForm" method="post" action="<?= BASE_PATH ?>order" onsubmit="event.preventDefault();">
                        <div class="row g-3">
                            <?php 
                                if(isset( $_SESSION['errorMessage'])){
                                    echo '<label class="form-label" for="name" style="color:red">'.$_SESSION['errorMessage'].'</label>';
                                    $_SESSION['errorMessage'] = null;
                                }
                            ?>
                            <div id="divAddProduct" class="col-xxl-12">
                                <a onclick="addProduct()" id="agregar" class="float-end text-decoration-underline" style="cursor: pointer;">Add Product</a>
                            </div>
                            <div id="1" class="row" style="margin: 0;">
                                <div class="col-12" style="padding: 0;">
                                    <label for="productName[]" class="form-label">Product</label>
                                    <select id="productName1" class="form-select" name="productName[]" required>
                                    <option value="" selected disabled>Select a product</option>
                                    <?php 
                                        foreach ($products as $item) {
                                            foreach($item->presentations as $value) {
                                                if(isset($item->presentations)&&count($item->presentations)>0) {
                                                    if(isset($value->id)&&isset($value->description)){
                                                        echo '<option value="'.$value->id.'" >#'.$value->id.' - '.$value->description.'</option>';
                                                    } else if(isset($value->id)&&!isset($value->description)) {
                                                        echo '<option value="'.$value->id.'" >#'.$value->id.' - Presentation without description.</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-12" style="padding: 0;">
                                    <div class="mt-2">
                                        <label for="quantity[]" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="quantity1" name="quantity[]" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter quantity" required>
                                    </div>
                                </div>
                            </div>
                            <div id="dinamic" style="margin: 0;"></div>
                            <hr id="modalSeparator">
                            <div id="divCustomer" class="col-xxl-12">
                                <label for="idClient" class="form-label">Customer</label>
                                <select data-customers='<?php echo json_encode($clients)?>' class="form-select" id="idClient" name="idClient" onchange="changeAddress(this)" required>
                                    <option value="" selected disabled>Select the client</option>
                                    <?php 
                                        foreach($clients as $item) {
                                            if(isset($item->addresses)&&count($item->addresses)>0) {
                                                echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div id="divAddress" class="col-xxl-12">
                                <label for="idAddress" class="form-label">Address</label>
                                <select class="form-select" id="idAddress" name="idAddress" required>
                                    <option value="" selected disabled>Select an address</option>
                                </select>
                            </div><!--end col-->
                            <div id="divPaymentTypeId" class="col-xxl-6">
                                <div>
                                    <label for="payment_type_id" class="form-label">Payment type</label>
                                    <select class="form-select" id="payment_type_id" name="payment_type_id" required>
                                        <option value="" selected disabled>Select payment type</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Card</option>
                                        <option value="3">Transfer</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div id="divFolio" class="col-xxl-6">
                                <div>
                                    <label for="folio" class="form-label">Folio</label>
                                    <input type="text" class="form-control" id="folio" name="folio" onkeypress="return numbersLettersWithoutSpaces(event)" onpaste="return false" placeholder="Enter folio" required>
                                </div>
                            </div><!--end col-->
                            <div id="divCoupon" class="col-xxl-4">
                                <label for="coupon_id" class="coupon_id">Coupon</label>
                                <div class="input-group">
                                    <select class="form-select" id="coupon_id" name="coupon_id" required>
                                    <option value="0" selected>Select a coupon</option>
                                    <?php foreach ($coupons as $item): ?>
                                        <option value="<?php if(isset($item->id)) echo $item->id; ?>"><?php if(isset($item->name)) echo $item->name; ?> (CODE: <?php if(isset($item->code)) echo $item->code; ?>)</option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div id="divPaid" class="col-xxl-4">
                                <label for="paid" class="form-label">Paid Out</label>
                                <div class="input-group">
                                    <select class="form-select" id="paid" name="paid" required>
                                        <option selected disabled>Select an option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div id="divStatus" class="col-xxl-4">
                                <label for="order_status_id" class="form-label">Status</label>
                                <div class="input-group">
                                    <select class="form-select" id="order_status_id" name="order_status_id" required>
                                        <option value="" selected disabled>Select a status</option>
                                        <option value="1">Pendiente de pago</option>
                                        <option value="2">Pagada</option>
                                        <option value="3">Enviada</option>
                                        <option value="4">Abandonada</option>
                                        <option value="5">Pendiente de enviar</option>
                                        <option value="6">Cancelada</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" id="typeAction" name="action" value="">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" onclick="submitForm()" class="btn btn-primary">Submit</button>
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

<script>
    //GENERAR INPUTS DE PRODUCTOS DE FORMA DINÁMICA
    const contenedor = document.querySelector('#dinamic');
    const btnAgregar = document.querySelector('#agregar');
    let total = 1;
    btnAgregar.addEventListener('click', e => {
        let div = document.createElement('div');
        div.innerHTML = `
            <div id="${total++}" class="row" style="margin: 0;">
                <div class="col-12 mt-4" style="padding: 0;">
                    <label for="productName[]" class="form-label">Product</label>
                    <select id="productName[]" class="form-select" name="productName[]" required>
                    <option value="" selected disabled>Select a product</option>
                    <?php 
                        foreach ($products as $item) {
                            foreach($item->presentations as $value) {
                                if(isset($item->presentations)&&count($item->presentations)>0) {
                                    if(isset($value->id)&&isset($value->description)){
                                        echo '<option value="'.$value->id.'" >#'.$value->id.' - '.$value->description.'</option>';
                                    } else if(isset($value->id)&&!isset($value->description)) {
                                        echo '<option value="'.$value->id.'" >#'.$value->id.' - Description not found.</option>';
                                    }
                                }
                            }
                        }
                    ?>
                    </select>
                </div>
                <div class="col-12" style="padding: 0;">
                    <div class="mt-2">
                        <label for="quantity[]" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="quantity[]" name="quantity[]" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter quantity" required>
                    </div>
                </div>
                <button onclick="eliminar(this.parentNode)" class="col-3 mt-2 btn btn-soft-danger d-flex align-items-center justify-content-center"><i class="ri-delete-bin-2-line ri-xl me-1"></i> Eliminar</button>
            </div>
        `;
        contenedor.appendChild(div);
    })
    
    const eliminar = (e) => {
        const divPadre = e.parentNode;
        contenedor.removeChild(divPadre);
        actualizarContador();
    };

    const actualizarContador = () => {
        let divs = contenedor.children;
        for (let i = 0; i < divs.length; i++) {
            divs[i].children[1].innerHTML = `<label for="productName[]" class="form-label">Product</label>`;
        }
    }; 

    //CAMBIAR DE FORMA DINÁMICA LAS OPCIONES DEL SELECT ADDRESS
    function changeAddress(target) {
        let costumer = JSON.parse(target.getAttribute('data-customers'));
        client_id = document.getElementById('idClient').value;

        var targetCostumer = costumer.filter(function (item) {
            return item.id == client_id;
        });

        $("#idAddress").empty();
        $('#idAddress').append(`<option value="" selected disabled>Select an address</option>`);

        addressLength = Object.keys(targetCostumer[0].addresses).length;
        for (let i = 0; i < addressLength; i++) {
            optionText = "Postal Code: #"+targetCostumer[0].addresses[i].postal_code+" - "+targetCostumer[0].addresses[i].street_and_use_number+", "+targetCostumer[0].addresses[i].city+", "+targetCostumer[0].addresses[i].province;
            optionValue = targetCostumer[0].addresses[i].id;
            $('#idAddress').append(`<option value="${optionValue}">${optionText}</option>`);
        }
        document.getElementById('idAddress').selectedIndex = 1;
    }

    //FUNCIÓN SUBMIT DE CONSULTA DE REGISTROS POR FECHAS
    function searchDataPerDates() {
        document.getElementById("formDates").submit();
    }

    //FUNCIÓN SUBMIT DE MODAL CREATE Y EDIT
    function submitForm() {
        document.getElementById("ordersForm").submit();
    }

    //FUNCIÓN REMOVE ORDER
    function remove(id) {
        swal({
            title: "Are you sure you want to remove this order?",
            text: "You will not be able to recover this order!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The order has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'eliminar');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>order', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                alert("An error occurred while performing the action.");
            });
        } else {
            swal("This order is safe!");
        }
        });
    }
    
    //FUNCIÓN CREATE ORDER
    function createOrder() {
        document.getElementById("typeAction").value = "crear";
        document.getElementById("orderModalLabel").innerHTML = "Create a new Order";
        document.getElementById('divStatus').removeAttribute('class');
        document.getElementById('divStatus').setAttribute('class', 'col-xxl-4');

        document.getElementById('productName1').selectedIndex = 0;
        document.getElementById('quantity1').value = "";
        document.getElementById('idClient').selectedIndex = 0;
        document.getElementById('idAddress').selectedIndex = 0;
        document.getElementById('payment_type_id').selectedIndex = 0;
        document.getElementById('folio').value = "";
        document.getElementById('coupon_id').selectedIndex = 0;
        document.getElementById('paid').selectedIndex = 0;
        document.getElementById('order_status_id').selectedIndex = 0;
        document.getElementById('id').value = "";

        document.getElementById('productName1').required = true;
        document.getElementById('quantity1').required = true;
        document.getElementById('idClient').required = true;
        document.getElementById('idAddress').required = true;
        document.getElementById('payment_type_id').required = true;
        document.getElementById('folio').required = true;
        document.getElementById('coupon_id').required = true;
        document.getElementById('paid').required = true;
        document.getElementById('order_status_id').required = true;

        document.getElementById('idClient').hidden = false;
        document.getElementById('idAddress').hidden = false;
        document.getElementById('payment_type_id').hidden = false;
        document.getElementById('folio').hidden = false;
        document.getElementById('coupon_id').hidden = false;
        document.getElementById('paid').hidden = false;
        document.getElementById('order_status_id').hidden = false;

        document.getElementById('1').hidden = false;
        document.getElementById('divAddProduct').hidden = false;
        document.getElementById('dinamic').hidden = false;
        document.getElementById('modalSeparator').hidden = false;
        document.getElementById('divCustomer').hidden = false;
        document.getElementById('divAddress').hidden = false;
        document.getElementById('divPaymentTypeId').hidden = false;
        document.getElementById('divFolio').hidden = false;
        document.getElementById('divCoupon').hidden = false;
        document.getElementById('divPaid').hidden = false;
        document.getElementById('divStatus').hidden = false;
    }
    
    //FUNCIÓN EDIT ORDER (UPDATE STATUS) 
    function editOrder(target) {
        let order = JSON.parse(target.getAttribute('data-order'));
        let productsNode = document.getElementById('dinamic');
        document.getElementById("typeAction").value = "actualizar";
        document.getElementById("orderModalLabel").innerHTML = "Update Order Status - Folio: #"+order.folio;
        document.getElementById('divStatus').removeAttribute('class');
        document.getElementById('divStatus').setAttribute('class', 'col-12');

        while (productsNode.firstChild) {
            productsNode.removeChild(productsNode.lastChild);
        }

        switch (order.order_status_id) {
            case 1:
                document.getElementById('order_status_id').selectedIndex = 1;
                break;
            case 2:
                document.getElementById('order_status_id').selectedIndex = 2;
                break;
            case 3:
                document.getElementById('order_status_id').selectedIndex = 3;
                break;
            case 4:
                document.getElementById('order_status_id').selectedIndex = 4;
                break;
            case 5:
                document.getElementById('order_status_id').selectedIndex = 5;
                break;
            case 6:
                document.getElementById('order_status_id').selectedIndex = 6;
                break;
            default:
                document.getElementById('order_status_id').selectedIndex = 0;
                break;
        }
        document.getElementById('id').value = order.id;

        document.getElementById('productName1').required = false;
        document.getElementById('quantity1').required = false;
        document.getElementById('idClient').required = false;
        document.getElementById('idAddress').required = false;
        document.getElementById('payment_type_id').required = false;
        document.getElementById('folio').required = false;
        document.getElementById('coupon_id').required = false;
        document.getElementById('paid').required = false;
        document.getElementById('order_status_id').required = true;

        document.getElementById('idClient').hidden = true;
        document.getElementById('idAddress').hidden = true;
        document.getElementById('payment_type_id').hidden = true;
        document.getElementById('folio').hidden = true;
        document.getElementById('coupon_id').hidden = true;
        document.getElementById('paid').hidden = true;
        document.getElementById('order_status_id').hidden = false;

        document.getElementById('1').hidden = true;
        document.getElementById('divAddProduct').hidden = true;
        document.getElementById('dinamic').hidden = true;
        document.getElementById('modalSeparator').hidden = true;
        document.getElementById('divCustomer').hidden = true;
        document.getElementById('divAddress').hidden = true;
        document.getElementById('divPaymentTypeId').hidden = true;
        document.getElementById('divFolio').hidden = true;
        document.getElementById('divCoupon').hidden = true;
        document.getElementById('divPaid').hidden = true;
        document.getElementById('divStatus').hidden = false;       
    }
</script>

</html>