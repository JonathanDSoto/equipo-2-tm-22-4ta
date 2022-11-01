<?php
	include_once "../app/config.php";
    include "../app/ProdController.php";

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    $productControl = new ProdController();
    $productsData = $productControl -> getTodo();
    //var_dump($productsData);
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Products</title>
    <?php include "../layout/head.template.php" ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php include "../layout/navbar.template.php" ?>
        <?php include "../layout/sidebar.template.php" ?>

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
                                <h4 class="mb-sm-0">Products</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Products</li>
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
                                                    <a href="<?= BASE_PATH ?>products/create/" class="btn btn-success waves-effect waves-light rounded-pill" id="addproduct-btn"><i class="ri-add-line align-bottom me-1"></i> Add Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA PRODUCTOS -->
                                    <div class="card-body">
                                        <table id="tableProducts" class="table table-bordered dt-responsive table-striped align-middle " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Cover</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Slug</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Features</th>
                                                    <th scope="col">Brand</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($productsData as $item): ?>
                                                    <tr>
                                                        <td class="text-center"><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                        <td>
                                                            <div class="">
                                                                <img src="<?php if(isset($item->cover)) echo $item->cover; else echo "Cover not found."; ?>" alt="Cover not found." class="img-fluid rounded">
                                                            </div>
                                                        </td>
                                                        <td><?php if(isset($item->name)) echo $item->name; else echo "Name not found."; ?></td>
                                                        <td><?php if(isset($item->slug)) echo $item->slug; else echo "Slug not found."; ?></td>
                                                        <td style="text-align: justify;"><?php if(isset($item->description)) echo $item->description; else echo "Description not found."; ?></td>
                                                        <td style="text-align: justify;"><?php if(isset($item->features)) echo $item->features; else echo "Features not found."; ?></td>
                                                        <td><?php if(isset($item->brand->name)) echo $item->brand->name; else echo "Brand not found."; ?></td>
                                                        <td>
                                                            <div class="dropdown ms-2">
                                                                <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item" href="<?= BASE_PATH.'products/'.$item->slug?>">View</a></li>
                                                                    <li><a class="dropdown-item" href="<?= BASE_PATH.'products/edit/'.$item->slug?>">Edit</a></li>
                                                                    <li><a class="dropdown-item " onclick="remove(<?php echo $item->id ?>)">Delete</a></li>
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

            <?php include "../layout/footer.template.php" ?>
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

    <?php include "../layout/scripts.template.php" ?>
</body>

<script>
    function remove(id) {
        swal({
            title: "Are you sure you want to remove this product?",
            text: "You will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The product has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>prod', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                //console.log(error);
                alert("An error occurred while performing the action.");
            });
        } else {
            swal("This product is safe!");
        }
        });
    }
</script>

</html>