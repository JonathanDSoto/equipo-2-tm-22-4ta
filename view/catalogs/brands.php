<?php
	include_once "../../app/config.php";
    include_once "../../app/BrandController.php";

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $brandControl = new BrandController();
    $brands = $brandControl -> getMarcas();
    //var_dump($brands);
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Brands</title>
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
                                <h4 class="mb-sm-0">Brands</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Brands</li>
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
                                                    <button onclick="addBrand()" type="button" data-bs-toggle="modal" data-bs-target="#modalBrand" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add Brand</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA BRANDS -->
                                    <div class="card-body">
                                        <table id="tableBrands" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Slug</th>
                                                    <th scope="col">Quantity of products</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($brands as $item): ?>
                                                    <tr>
                                                        <td><?php if(isset($item->id)) echo $item->id; else echo "ID not found."; ?></td>
                                                        <td><?php if(isset($item->name)) echo $item->name; else echo "Name not found."; ?></td>
                                                        <td><?php if(isset($item->description)) echo $item->description; else echo "Description not found."; ?></td>
                                                        <td><?php if(isset($item->slug)) echo $item->slug; else echo "Slug not found."; ?></td>
                                                        <td>
                                                            <?php
                                                                if(isset($item->products)) {
                                                                   echo count($item->products);
                                                                }else {
                                                                    echo "Quantity not found.";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown ms-2">
                                                                <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item" data-brand='<?php echo json_encode($item)?>' onclick="editBrand(this)" data-bs-toggle="modal" data-bs-target="#modalBrand" href="#">Edit</a></li>
                                                                    <li><a class="dropdown-item" onclick="remove(<?php echo $item->id ?>)" href="#">Delete</a></li>
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
    <div class="modal fade" id="modalBrand" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= BASE_PATH ?>brand">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" onkeypress="return numbersLettersSpaces(event)" placeholder="Enter brand's name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="slugBrand" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slugBrand" name="slugBrand" onkeypress="return slug(event)" placeholder="Enter brand's slug" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-12">
                                <div>
                                    <label for="description" class="form-label">Description</label>          
                                    <textarea id="description" name="description" class="form-control" onkeypress="return basicText(event)" placeholder="Enter a description" rows="3" style="resize:none" maxlength="200" required></textarea>
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
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this brand?</p>
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

<script>
    function remove (id) {
        swal({
            title: "Are you sure you want to remove this brand?",
            text: "You will not be able to recover this brand!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The brand has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>brand', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                //console.log(error);
                alert("An error occurred while performing the action.");
            });

        } else {
            swal("This brand is safe!");
        }
        });
    }

    function addBrand() {
        document.getElementById("typeAction").value = "create";
        document.getElementById("exampleModalgridLabel").innerHTML = "Add new brand";

        document.getElementById("name").value = "";
        document.getElementById("slugBrand").value = "";
        document.getElementById("description").value = "";
        document.getElementById("id").value = "";
    }

    function editBrand(target) {
        let brand = JSON.parse(target.getAttribute('data-brand'));
        document.getElementById("typeAction").value = "update";
        document.getElementById("exampleModalgridLabel").innerHTML = "Edit brand";

        document.getElementById("name").value = brand.name;
        document.getElementById("slugBrand").value = brand.slug;
        document.getElementById("description").value = brand.description;
        document.getElementById("id").value = brand.id;
    }
</script>

</html>