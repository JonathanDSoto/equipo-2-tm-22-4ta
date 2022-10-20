<?php
	include_once "../../app/config.php";
    include "../../app/ProdController.php";
    include "../../app/PresController.php";

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    $productControl = new ProdController();
    $productsData = $productControl -> getPslug($_GET['slug']);
    $presentationControl = new PresController();

    if(!isset($productsData)) {
        header('location: '.BASE_PATH.'products');
    }
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
                                                            <img src="<?php if(isset($productsData->cover)) echo $productsData->cover; else echo "Cover not found."; ?>" alt="Cover not found." class="img-fluid d-block" />
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
                                                <!-- MAIN INFO -->
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h4><?php if(isset($productsData->name)) echo $productsData->name; else echo "Name not found."; ?></h4>
                                                        <div class="hstack gap-1 flex-wrap">
                                                            <?php 
                                                                if(!empty($productsData->categories)&&isset($productsData->categories)) {
                                                                    foreach ($productsData->categories as $item) {
                                                                        echo '<div><a class="badge rounded-pill text-bg-primary">'.$item->name.'</a></div>';
                                                                    }
                                                                } else {
                                                                    echo '<div>No categories.</div>';
                                                                }
                                                            ?>
                                                            <div class="vr mx-2"></div>
                                                            <?php 
                                                                if(!empty($productsData->tags)&&isset($productsData->tags)) {
                                                                    foreach ($productsData->tags as $item) {
                                                                        echo '<div><a class="badge rounded-pill text-bg-secondary">'.$item->name.'</a></div>';
                                                                    }
                                                                } else {
                                                                    echo '<div>No tags.</div>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 text-muted">
                                                    <h5 class="fs-14">Description :</h5>
                                                    <p><?php if(isset($productsData->description)) echo $productsData->description; else echo "Description not found."; ?></p>
                                                </div>
                                            
                                                <!-- TABS -->
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
                                                        <!-- MORE INFO -->
                                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px;">ID</th>
                                                                            <td><?php if(isset($productsData->id)) echo $productsData->id; else echo "ID not found."; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px;">Features</th>
                                                                            <td><?php if(isset($productsData->features)) echo $productsData->features; else echo "Features not found."; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Brand</th>
                                                                            <td><?php if(isset($productsData->brand->name)) echo $productsData->brand->name; else echo "Brand not found."; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Slug</th>
                                                                            <td><?php if(isset($productsData->slug)) echo $productsData->slug; else echo "Slug not found."; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <!-- PRESENTATIONS -->
                                                        <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                <div class="mb-4">
                                                                    <button onclick="addPresentation(<?= $productsData->id ?>)" type="button" data-bs-toggle="modal" data-bs-target="#modalPresentation" class="btn btn-success btn-sm btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Presentation</button>
                                                                </div>
                                                                <table id="tableProductDetailsPresentations" class="table table-bordered dt-responsive table-striped align-middle " style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID</th>
                                                                            <th scope="col">Code</th>
                                                                            <th scope="col">Description</th>
                                                                            <th scope="col">Weight</th>
                                                                            <th scope="col">Minimum Stock</th>
                                                                            <th scope="col">Maximum Stock</th>
                                                                            <th scope="col">Stock</th>
                                                                            <th scope="col">Price</th>
                                                                            <th scope="col">Status</th>
                                                                            <th scope="col">Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($productsData->presentations as $item): ?>
                                                                            <tr>
                                                                                <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                                                <td><?php if(isset($item->code)) echo $item->code; else echo "Code not found."; ?></td>
                                                                                <td><?php if(isset($item->description)) echo $item->description; else echo "Description not found."; ?></td>
                                                                                <td><?php if(isset($item->weight_in_grams)) echo $item->weight_in_grams." gr"; else echo "Weight not found."; ?></td>
                                                                                <td><?php if(isset($item->stock_min)) echo $item->stock_min; else echo "Minimum stock not found."; ?></td>
                                                                                <td><?php if(isset($item->stock_max)) echo $item->stock_max; else echo "Maximum stock not found."; ?></td>
                                                                                <td><?php if(isset($item->stock)) echo $item->stock; else echo "Stock not found."; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        if(isset($item->price)){
                                                                                            foreach ($item->price as $itemPrice) {
                                                                                                $lastPrice = $itemPrice->amount;
                                                                                            }
                                                                                            echo "$".$lastPrice;
                                                                                        } else {
                                                                                            echo "Price not found.";
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php 
                                                                                        if(isset($item->status)) {
                                                                                            if($item->status == "active"||$item->status == "activo") {
                                                                                                echo '<span class="badge bg-success">'.$item->status.'</span>';
                                                                                            } else if($item->status == "inactive"||$item->status == "inactivo") {
                                                                                                echo '<span class="badge bg-danger">'.$item->status.'</span>';
                                                                                            } else {
                                                                                                echo "Status not found.";
                                                                                            }
                                                                                        } else {
                                                                                            echo "Status not found.";
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="dropdown ms-2">
                                                                                        <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                            <i class="ri-more-2-fill"></i>
                                                                                        </a>
                                                                                    
                                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                        <li><a class="dropdown-item" data-presentation='<?php echo json_encode($item)?>' onclick="editPresentation(this)" data-bs-toggle="modal" data-bs-target="#modalPresentation" href="#">Edit</a></li>
                                                                                        <li><a class="dropdown-item" onclick="removePresentation(<?php echo $item->id ?>)">Delete</a></li>
                                                                                    </ul>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <!-- ORDERS -->
                                                        <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                <table id="tableProductDetailsOrders" class="table table-bordered dt-responsive table-striped align-middle " style="width:100%">
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
                                                                            <th scope="col">Paid</th>
                                                                            <th scope="col">Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($productsData->presentations as $itemPresentations): ?>
                                                                            <?php foreach ($itemPresentations->orders as $item): ?>
                                                                                <tr>
                                                                                    <td><?php if(isset($item->folio)) echo $item->folio; else echo "Folio not found."; ?></td>
                                                                                    <td><?php if(isset($item->client_id)) echo $item->client_id; else echo "Customer not found."; ?></td>
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
                                                                                            if(isset($item->pivot->presentation_id)){
                                                                                               $itemPresentation = $presentationControl -> getEspP($item->pivot->presentation_id);
                                                                                               echo $item->pivot->presentation_id." - ".$itemPresentation->code;
                                                                                            } else {
                                                                                                echo "Presentation not found."; 
                                                                                            }      
                                                                                        ?>
                                                                                    </td>
                                                                                    <td><?php if(isset($item->pivot->quantity)) echo $item->pivot->quantity; else echo "Quantity not found."; ?></td>
                                                                                    <td><?php if(isset($item->coupon_id)) echo $item->coupon_id; else echo "Coupon not found."; ?></td>
                                                                                    <td><?php if(isset($item->total)) echo "$".$item->total; else echo "Total not found."; ?></td>
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
                                                                        <?php endforeach; ?>
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

    <!-- MODAL CREATE PRESENTATION -->
    <!-- Grids in modals -->
    <div class="modal fade" id="modalPresentation" tabindex="-1" aria-labelledby="titleModalPresentation" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalPresentation">Presentation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="<?= BASE_PATH ?>pres">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" onkeypress="return basicText(event)" placeholder="Enter description" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="weight_in_grams" class="form-label">Weight</label>
                                    <input type="text" class="form-control" id="weight_in_grams" name="weight_in_grams" onkeypress="return onlyNumbers(event)" placeholder="Enter weight" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" onkeypress="return numbersLettersWithoutSpaces(event)" placeholder="Enter code" required>
                                </div>
                            </div><!--end col-->
                            <div id="divCoverPresentation" class="col-xxl-6">
                                    <label for="coverPresentation" class="form-label">Cover</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="coverPresentation" name="coverPresentation" accept="image/*" required>
                                    </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="stock_min" class="form-label">Minimum Stock</label>
                                    <input type="text" class="form-control" id="stock_min" name="stock_min" onkeypress="return onlyNumbers(event)" placeholder="Enter min stock" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="stock_max" class="form-label">Maximum Stock</label>
                                    <input type="text" class="form-control" id="stock_max" name="stock_max" onkeypress="return onlyNumbers(event)" placeholder="Enter max stock" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="text" class="form-control" id="stock" name="stock" onkeypress="return onlyNumbers(event)" placeholder="Enter stock avaliable" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="statusPresentation" class="form-label">Status</label>
                                <div class="input-group">
                                    <select class="form-select" id="statusPresentation" name="statusPresentation" required>
                                        <option selected disabled>Select a status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="amount" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="amount" name="amount" onkeypress="return onlyNumbers(event)" placeholder="Enter price" required>
                                </div>
                            </div><!--end col-->

                            <div  class="col-xxl-6 mb-3">
                                <div">
                                    <label id="productIdLabel" for="product_id" class="form-label">Product ID</label>
                                    <input type="text" class="form-control" id="product_id" name="product_id" onkeypress="return onlyNumbers(event)" placeholder="Enter product ID" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" id="typeAction" name="action" value="">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
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
    function removePresentation(id) {
        swal({
            title: "Are you sure you want to remove this presentation?",
            text: "You will not be able to recover this presentation!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The presentation has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>pres', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                //console.log(error);
                alert("An error occurred while performing the action.");
            });

        } else {
            swal("This presentation is safe!");
        }
        });
    }

    function addPresentation(product_id) {
        document.getElementById("typeAction").value = "create";
        document.getElementById("titleModalPresentation").innerHTML = "Add new presentation";
        document.getElementById("divCoverPresentation").hidden = false;

        document.getElementById("description").value = "";
        document.getElementById("weight_in_grams").value = "";
        document.getElementById("code").value = "";
        document.getElementById("coverPresentation").disabled = false;
        document.getElementById("stock_min").value = "";
        document.getElementById("stock_max").value = "";
        document.getElementById("stock").value = "";
        document.getElementById("statusPresentation").selectedIndex = 0;
        document.getElementById("product_id").value = product_id;
        document.getElementById("product_id").setAttribute("type", "hidden");
        document.getElementById("productIdLabel").hidden = true;
        document.getElementById("amount").value = "";
        
        document.getElementById("id").value = product_id;
    }

    function editPresentation(target) {
        document.getElementById("typeAction").value = "update";
        document.getElementById("titleModalPresentation").innerHTML = "Edit presentation";
        document.getElementById("divCoverPresentation").hidden = true;

        let presentation = JSON.parse(target.getAttribute('data-presentation'));

        //console.log(presentation);

        document.getElementById("description").value = presentation.description;
        document.getElementById("weight_in_grams").value = presentation.weight_in_grams;
        document.getElementById("code").value = presentation.code;
        document.getElementById("stock_min").value = presentation.stock_min;
        document.getElementById("stock_max").value = presentation.stock_max;
        document.getElementById("stock").value = presentation.stock;
        if(presentation.status=='Active'||presentation.status=='Activo'||presentation.status=='Activa'||presentation.status=='active'||presentation.status=='activo'||presentation.status=='activa') {
            document.getElementById("statusPresentation").selectedIndex = 1;
        }else if(presentation.status=='Inactive'||presentation.status=='Inactivo'||presentation.status=='Inactiva'||presentation.status=='inactive'||presentation.status=='inactivo'||presentation.status=='inactiva') {
            document.getElementById("statusPresentation").selectedIndex = 2;
        }
        //console.log(presentation.status);

        document.getElementById("product_id").setAttribute("type", "text");
        document.getElementById("product_id").value = presentation.product_id;
        document.getElementById("id").value = presentation.id;
        document.getElementById("coverPresentation").disabled = true;
        document.getElementById("productIdLabel").hidden = false;
        if(presentation.price!=null) {
            precio = presentation.price.pop();
            document.getElementById("amount").value = precio.amount;
        }else{
            document.getElementById("amount").value = "";
        } 
    }
</script>

</html>