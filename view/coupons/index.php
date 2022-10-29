<?php
	include_once "../../app/config.php";
    include_once '../../app/CuponController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $couponControl = new CuponController();
    $coupons = $couponControl -> getCupons();
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Coupons</title>
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
                                <h4 class="mb-sm-0">Coupons</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Coupons</li>
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
                                                    <button onclick="addCoupon()" type="button" data-bs-toggle="modal" data-bs-target="#modalCoupon" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Coupon</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA COUPONS -->
                                    <div class="card-body">
                                        <table id="tableCoupons" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Min. Amount</th>
                                                    <th scope="col">Min. Products</th>
                                                    <th scope="col">Start Date</th>
                                                    <th scope="col">End Date</th>
                                                    <th scope="col">Max Uses</th>
                                                    <th scope="col">Uses</th>
                                                    <th scope="col">First Purchase</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($coupons as $item): ?>
                                                    <tr>
                                                        <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                        <td><?php if(isset($item->name)) echo $item->name; else echo "Name not found."; ?></td>
                                                        <td><?php if(isset($item->code)) echo $item->code; else echo "Code not found."; ?></td>
                                                        <td>
                                                            <?php 
                                                                if(isset($item->couponable_type)) {
                                                                    if($item->couponable_type=="Cupon de descuento fijo") {
                                                                        if(isset($item->amount_discount)) {
                                                                            echo $item->amount_discount.' MXN';
                                                                        } else {
                                                                            echo 'Amount discount not found.';
                                                                        }
                                                                    } else if($item->couponable_type=="Cupon de descuento") {
                                                                        if(isset($item->percentage_discount)) {
                                                                            echo $item->percentage_discount.'%';
                                                                        } else {
                                                                            echo 'Percentage discount not found.';
                                                                        }
                                                                    } else {
                                                                        echo "Discount not found.";
                                                                    }
                                                                } else {
                                                                    if(isset($item->amount_discount)||isset($item->percentage_discount)) {
                                                                        if(isset($item->amount_discount)){
                                                                            echo $item->amount_discount.' MXN';
                                                                        } else if(isset($item->percentage_discount)) {
                                                                            echo $item->percentage_discount.'%';
                                                                        }
                                                                    } else {
                                                                        echo 'Discount not found.';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php if(isset($item->min_amount_required)) echo $item->min_amount_required; else echo "Min. amount not found."; ?></td>
                                                        <td><?php if(isset($item->min_product_required)) echo $item->min_product_required; else echo "Min. products not found."; ?></td>
                                                        <td><?php if(isset($item->start_date)) echo $item->start_date; else echo "Start date not found."; ?></td>
                                                        <td><?php if(isset($item->end_date)) echo $item->end_date; else echo "End date not found."; ?></td>
                                                        <td><?php if(isset($item->max_uses)) echo $item->max_uses; else echo "Max uses not found."; ?></td>
                                                        <td><?php if(isset($item->count_uses)) echo $item->count_uses; else echo "Uses not found."; ?></td>
                                                        <td>
                                                            <?php
                                                                if(isset($item->valid_only_first_purchase)) {
                                                                    switch ($item->valid_only_first_purchase) {
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
                                                        <td>
                                                            <?php
                                                                if(isset($item->status)) {
                                                                    switch ($item->status) {
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
                                                        <td>
                                                            <div class="dropdown ms-2">
                                                                <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                            
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item" href="<?= BASE_PATH.'coupons/'.$item->code?>">View</a></li>
                                                                    <li><a class="dropdown-item" data-coupon='<?php echo json_encode($item)?>' onclick="editCoupon(this)" data-bs-toggle="modal" data-bs-target="#modalCoupon" href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item" onclick="remove(<?php echo $item->id ?>)">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
    <div class="modal fade" id="modalCoupon" tabindex="-1" aria-labelledby="couponModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= BASE_PATH ?>cupon">
                        <div class="row g-3">
                            <?php 
                                    if(isset( $_SESSION['errorMessage'])){
                                        echo '<label class="form-label" for="name" style="color:red">'.$_SESSION['errorMessage'].'</label>';
                                        $_SESSION['errorMessage'] = null;
                                    }
                            ?>
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" onkeypress="" onpaste="return false" placeholder="Enter coupon's name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" class="form-control no-paste" id="code" name="code" onkeypress="return noSpaces(event)" onpaste="return false" placeholder="Enter coupon's code" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="couponable_type" class="form-label">Type coupon</label>
                                    <div class="input-group">
                                        <select class="form-select" id="couponable_type" name="couponable_type" onchange="typeCoupon()" required>
                                            <option value="" selected disabled>Select an option</option>
                                            <option value="Cupon de descuento fijo">Cupon de descuento fijo</option>
                                            <option value="Cupon de descuento">Cupon de descuento</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div id="divPercentageDiscount" hidden=true>
                                    <label for="percentage_discount" class="form-label">Percentage Discount</label>
                                    <input type="text" class="form-control" id="percentage_discount" name="percentage_discount" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter the discount">
                                </div>
                                <div id="divAmountDiscount" hidden=true>
                                    <label for="amount_discount" class="form-label">Amount Discount</label>
                                    <input type="text" class="form-control" id="amount_discount" name="amount_discount" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter minimum amount">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="min_amount_required" class="form-label">Min. Amount</label>
                                    <input type="name" class="form-control" id="min_amount_required" name="min_amount_required" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter minimum amount" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="min_product_required" class="form-label">Min. Products</label>
                                    <input type="text" class="form-control" id="min_product_required" name="min_product_required" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter minimum products" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" oninput="getMinDate()"  required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="max_uses" class="form-label">Max Uses</label>
                                    <input type="text" class="form-control" id="max_uses" name="max_uses" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter the maximum of uses" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="valid_only_first_purchase" class="form-label">First Purchase</label>
                                    <div class="input-group">
                                        <select class="form-select" id="valid_only_first_purchase" name="valid_only_first_purchase" required>
                                            <option value="" selected disabled>Select an option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="statusCoupon" class="form-label">Status</label>
                                    <div class="input-group">
                                        <select class="form-select" id="statusCoupon" name="statusCoupon" required>
                                            <option value="" selected disabled>Select a status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div id="divCountUses" >
                                    <label for="count_uses" class="form-label">Count uses</label>
                                    <input type="text" class="form-control" id="count_uses" name="count_uses" onkeypress="return onlyNumbers(event)" onpaste="return false" placeholder="Enter the count of uses" required>
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

    function typeCoupon() {
        if (document.getElementById("couponable_type").selectedIndex == 0) {
            document.getElementById('divPercentageDiscount').hidden = true;
            document.getElementById('divAmountDiscount').hidden = true;
        } else if(document.getElementById("couponable_type").selectedIndex == 1) {
            document.getElementById('divPercentageDiscount').hidden = true;
            document.getElementById('divAmountDiscount').hidden = false;
            document.getElementById("percentage_discount").value = "";
            document.getElementById("percentage_discount").hidden = true;
            document.getElementById("percentage_discount").required = false;
            document.getElementById("amount_discount").value = "";
            document.getElementById("amount_discount").hidden = false;
            document.getElementById("amount_discount").required = true;
        } else if(document.getElementById("couponable_type").selectedIndex == 2) {
            document.getElementById('divPercentageDiscount').hidden = false;
            document.getElementById('divAmountDiscount').hidden = true;
            document.getElementById("percentage_discount").value = "";
            document.getElementById("percentage_discount").hidden = false;
            document.getElementById("percentage_discount").required = true;
            document.getElementById("amount_discount").value = "";
            document.getElementById("amount_discount").hidden = true;
            document.getElementById("amount_discount").required = false;
        }
    }

    function remove(id) {
        swal({
            title: "Are you sure you want to remove this coupon?",
            text: "You will not be able to recover this coupon!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The coupon has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>cupon', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                alert("An error occurred while performing the action.");
            });
        } else {
            swal("This coupon is safe!");
        }
        });
    }
    
    function addCoupon() {
        document.getElementById("typeAction").value = "create";
        document.getElementById("couponModalLabel").innerHTML = "Add new coupon";
        document.getElementById('divPercentageDiscount').hidden = true;
        document.getElementById('divAmountDiscount').hidden = true;
        document.getElementById("divCountUses").hidden = true;

        document.getElementById("name").value = "";
        document.getElementById("code").value = "";
        document.getElementById("couponable_type").selectedIndex = 0;
        document.getElementById("percentage_discount").value = "";
        document.getElementById("amount_discount").value = "";
        document.getElementById("min_amount_required").value = "";
        document.getElementById("min_product_required").value = "";
        document.getElementById("start_date").value = "";
        document.getElementById("end_date").value = "";
        document.getElementById("max_uses").value = "";
        document.getElementById("valid_only_first_purchase").selectedIndex = 0;
        document.getElementById("statusCoupon").selectedIndex = 0;
        document.getElementById("count_uses").value = 0;
        document.getElementById("count_uses").hidden = true;

        const date = new Date();
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        let currentDate = `${year}-${month}-${day}`;
        document.getElementById("start_date").min = currentDate;
        
    }

    function getMinDate(){
        let minEndDate = document.getElementById("start_date").value;
        document.getElementById('end_date').min = minEndDate;
        document.getElementById('end_date').value = minEndDate;
    }
    
    function editCoupon(target) {
        let coupon = JSON.parse(target.getAttribute('data-coupon'));
        let couponPercentage = false, couponAmount = false;
        document.getElementById("typeAction").value = "update";
        document.getElementById("couponModalLabel").innerHTML = "Edit coupon";
        document.getElementById('divPercentageDiscount').hidden = true;
        document.getElementById('divAmountDiscount').hidden = true;
        document.getElementById("divCountUses").hidden = false;

        document.getElementById("name").value = coupon.name;
        document.getElementById("code").value = coupon.code;

        if(coupon.couponable_type!=null) {
            document.getElementById("couponable_type").value = coupon.couponable_type;
            if(coupon.couponable_type === "Cupon de descuento fijo") {
                couponAmount = true;
            }else if(coupon.couponable_type=="Cupon de descuento") {
                couponPercentage = true;
            }
        } else {
            if(coupon.amount_discount!='0'&&coupon.amount_discount!=null) {
                couponAmount = true;
            } else if(coupon.percentage_discount!='0'&&coupon.percentage_discount!=null) {
                couponPercentage = true;
            }
        }

        if(couponPercentage) {
            document.getElementById("couponable_type").selectedIndex = 2;
            document.getElementById('divPercentageDiscount').hidden = false;
            document.getElementById("percentage_discount").hidden = false;
            document.getElementById("percentage_discount").required = true;
            document.getElementById("percentage_discount").value = coupon.percentage_discount;
            document.getElementById('divAmountDiscount').hidden = true;
            document.getElementById("amount_discount").hidden = true;
            document.getElementById("amount_discount").required = false;
            document.getElementById("amount_discount").value = "";
        } else if(couponAmount) {
            document.getElementById("couponable_type").selectedIndex = 1;
            document.getElementById('divPercentageDiscount').hidden = true;
            document.getElementById("percentage_discount").hidden = true;
            document.getElementById("percentage_discount").required = false;
            document.getElementById("percentage_discount").value = "";
            document.getElementById('divAmountDiscount').hidden = false;
            document.getElementById("amount_discount").hidden = false;
            document.getElementById("amount_discount").required = true;
            document.getElementById("amount_discount").value = coupon.amount_discount;  
        }

        document.getElementById("min_amount_required").value = coupon.min_amount_required;
        document.getElementById("min_product_required").value = coupon.min_product_required;
        document.getElementById("start_date").value = coupon.start_date;
        document.getElementById("end_date").value = coupon.end_date;
        document.getElementById("max_uses").value = coupon.max_uses;
        document.getElementById("valid_only_first_purchase").value = coupon.valid_only_first_purchase;
        document.getElementById("statusCoupon").value = coupon.status;
        document.getElementById("count_uses").value = coupon.count_uses;
        document.getElementById("count_uses").hidden = false;
        document.getElementById("id").value = coupon.id;
    }
</script>

</html>