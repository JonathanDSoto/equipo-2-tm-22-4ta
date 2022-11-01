<?php
	include_once "../../app/config.php";
    include_once '../../app/ClientController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $customerControl = new ClientController();
    $customers = $customerControl -> getClientes();
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Customers</title>
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
                                <h4 class="mb-sm-0">Customers</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Customers</li>
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
                                        <div class="row g-4">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <button onclick="addCostumer()" type="button" data-bs-toggle="modal" data-bs-target="#modalCustomer" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Customer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA CUSTOMERS -->
                                    <div class="card-body">
                                        <table id="tableCustomers" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">Subscription</th>
                                                    <th scope="col">Level</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($customers as $item): ?>
                                                    <tr>
                                                        <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                        <td><?php if(isset($item->name)) echo $item->name; else echo "Name not found."; ?></td>
                                                        <td><?php if(isset($item->email)) echo $item->email; else echo "Email not found."; ?></td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->phone_number)) {
                                                                    if(is_numeric($item->phone_number)) {
                                                                        echo $item->phone_number; 
                                                                    }else {
                                                                        echo "Invalid phone number, there are characters.";
                                                                    }
                                                                } else {
                                                                    echo "Phone number not found."; 
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if(isset($item->is_suscribed)) {
                                                                    switch ($item->is_suscribed) {
                                                                        case '0':
                                                                            echo '<span class="badge bg-danger">No</span>';
                                                                            break;
                                                                        case '1':
                                                                            echo '<span class="badge bg-success">Yes</span>';
                                                                            break;
                                                                        default:
                                                                            echo $item->is_suscribed;
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "Suscription information not found.";
                                                                } 
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->level_id)) {
                                                                    if(isset($item->level->id)&&isset($item->level->name)) {
                                                                        switch ($item->level->id) {
                                                                            case '1':
                                                                                echo '<span class="badge bg-info">'.$item->level->id.' - '.$item->level->name.'</span>';
                                                                                break;
                                                                            case '2':
                                                                                echo '<span class="badge bg-secondary">'.$item->level->id.' - '.$item->level->name.'</span>';
                                                                                break;
                                                                            case '3':
                                                                                echo '<span class="badge bg-primary">'.$item->level->id.' - '.$item->level->name.'</span>';
                                                                                break;
                                                                            default:
                                                                                echo $item->level->id.' - '.$item->level->name;
                                                                                break;
                                                                        }
                                                                    } else {
                                                                        echo $item->level_id;
                                                                    }
                                                                } else {
                                                                    echo "Level not found.";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->level_id)&&isset($item->level)&&isset($item->level->percentage_discount)) {
                                                                    switch ($item->level->id) {
                                                                        case '1':
                                                                            echo '<span class="badge bg-dark bg-opacity-50">'.$item->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        case '2':
                                                                            echo '<span class="badge bg-secondary bg-opacity-85">'.$item->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        case '3':
                                                                            echo '<span class="badge bg-success bg-opacity-85">'.$item->level->percentage_discount.'% OFF </span>';
                                                                            break;
                                                                        default:
                                                                            echo $item->level->percentage_discount.'% OFF';
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "Percentage discount not found.";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown ms-2">
                                                                <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item" href="<?= BASE_PATH.'customers/'.$item->id?>">View</a></li>
                                                                    <li><a class="dropdown-item" data-costumer='<?php echo json_encode($item)?>' onclick="editCostumer(this)" data-bs-toggle="modal" data-bs-target="#modalCustomer" href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item" onclick="remove(<?php echo $item->id ?>)">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!--</table>-->
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
    <div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="costumerModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="costumerModalLabel">Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= BASE_PATH ?>client">
                        <div class="row g-3">
                            <?php 
                                if(isset( $_SESSION['errorMessage'])){
                                    echo '<label class="form-label" for="name" style="color:red">'.$_SESSION['errorMessage'].'</label>';
                                    $_SESSION['errorMessage'] = null;
                                }
                            ?>
                            <div class="col-xxl-12">
                                <div>
                                    <label for="name" class="form-label">Name*</label>
                                    <input type="name" class="form-control" id="name" name="name" onpaste="return false" onkeypress="return onlyLettersAndSpaces(event)" placeholder="Enter customer's name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter an email address" onpaste="return false" pattern="(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phone_number" class="form-label">Phone*</label>
                                    <input type="phone" class="form-control" id="phone_number" name="phone_number" onpaste="return false" onkeypress="return onlyNumbers(event)" placeholder="Enter a phone number" minlenght="10" maxlength="10" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="suscribed" class="form-label">Subscribed*</label>
                                <div class="input-group">
                                    <select class="form-select" id="suscribed" name="suscribed" required>
                                        <option value="" selected disabled>Select an option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div id="divLevel" class="col-xxl-6">
                                <label for="level" class="form-label">Level*</label>
                                <div class="input-group">
                                    <select class="form-select" id="level" name="level" required>
                                        <option selected disabled>Select a level</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Premium</option>
                                        <option value="3">VIP</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" id="typeAction" name="action" value="">
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
    function remove(id) {
        swal({
            title: "Are you sure you want to remove this costumer?",
            text: "You will not be able to recover this costumer!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The costumer has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>client', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                alert("An error occurred while performing the action.");
            });

        } else {
            swal("This costumer is safe!");
        }
        });
    }
    
    function addCostumer() {
        document.getElementById("typeAction").value = "create";
        document.getElementById("costumerModalLabel").innerHTML = "Add new costumer";
        document.getElementById("divLevel").hidden = true;
        document.getElementById("level").disabled = true;

        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("phone_number").value = "";
        document.getElementById("suscribed").selectedIndex = 0;
        document.getElementById("level").selectedIndex = 0;
        document.getElementById("id").value = "";
    }
    
    function editCostumer(target) {
        let costumer = JSON.parse(target.getAttribute('data-costumer'));
        document.getElementById("typeAction").value = "update";
        document.getElementById("costumerModalLabel").innerHTML = "Edit costumer";
        document.getElementById("divLevel").hidden = false;
        document.getElementById("level").disabled = false;

        document.getElementById("name").value = costumer.name;
        document.getElementById("email").value = costumer.email;
        document.getElementById("phone_number").value = costumer.phone_number;
        document.getElementById("suscribed").value = costumer.is_suscribed;
        document.getElementById("level").value = costumer.level_id;
        document.getElementById("id").value = costumer.id;
    }
</script>

</html>