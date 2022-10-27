<?php
	include_once "../../app/config.php";
    include "../../app/ProdController.php";
    include "../../app/BrandController.php";
    include "../../app/TagController.php";
    include "../../app/CathController.php";

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    if(isset($_GET['slug'])) {
        $action = "update"; 
        $productControl = new ProdController();
        $productsData = $productControl -> getPslug($_GET['slug']);

        if(!isset($productsData)){
            header('location: '.BASE_PATH.'products');
        }

    } else {
        $action = "create";
    }

    $brandControl = new BrandController();
    $brandsData = $brandControl -> getMarcas();

    $tagControl = new TagController();
    $tagsData = $tagControl -> getTags();

    $categoryControl = new CathController();
    $categoriesData = $categoryControl -> getCath();
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title><?php if($action=='create'){ echo "Create Product"; } else if($action=='update') { echo "Edit Product"; } ?></title>
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
                                <h4 class="mb-sm-0"><?php if($action=='create'){ echo "Create Product"; } else if($action=='update') { echo "Edit Product"; } ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a>Ecommerce</a></li>
                                        <li class="breadcrumb-item active"><?php if($action=='create'){ echo "Create Product"; } else { echo "Edit Product"; } ?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!---<form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>-->
                    <form enctype="multipart/form-data" method="post" action="<?= BASE_PATH ?>prod">
                        <div class="row">
                            <!-- MAIN INFO (TITLE, COVER, DESCRIPTION AND FEATURES) -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- TITLE -->
                                        <?php 
                                           if(isset( $_SESSION['errorMessage'])){
                                                echo '<label class="form-label" for="name" style="color:red">'.$_SESSION['errorMessage'].'</label>';
                                            }
                                        ?>
                                        <div class="mb-3">
                                            
                                            <label class="form-label" for="name">Product Title</label>
                                            <input type="text" class="form-control" id="name" name="name" onkeypress="return numbersLettersSpaces(event)"  placeholder="Enter product title" value="<?php if($action=='update'&&isset($productsData->name)) { echo $productsData->name; } ?>" required>
                                        </div>

                                        <!-- COVER -->
                                        <div class="mb-3">
                                            <label class="form-label" for="product-title-input">Product Cover</label>
                                            <div class="input-group">
                                                <input id="cover" name="cover" type="file" class="form-control" accept="image/*" <?php if($action=='update') { echo 'disabled'; } else { echo 'required'; } ?> >
                                            </div>
                                        </div>

                                        <!-- DESCRIPTION -->
                                        <div class="mb-3">
                                            <label class="form-label" for="product-title-input">Product Description</label>
                                            <div class="input-group">
                                                <textarea id="description" name="description" class="form-control" onkeypress="return basicText(event)" placeholder="Add short description for the product" rows="2"><?php if($action=='update'&&isset($productsData->description)) { echo $productsData->description; } ?></textarea>
                                            </div>
                                        </div>

                                        <!-- FEATURES -->
                                        <div>
                                            <label>Product Features</label>
                                            <div class="input-group">
                                                <textarea id="features" name="features" class="form-control" onkeypress="return basicText(event)" placeholder="Add features for the product" rows="3"><?php if($action=='update'&&isset($productsData->features)) { echo $productsData->features; } ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <!-- SUBMIT -->
                                <div class="text-start mb-3">
                                    <input type="hidden" id="action" name="action" value="<?= $action ?>">
                                    <?php
                                        if($action=='update'&&isset($productsData->id)) { 
                                            echo '<input type="hidden" id="id" name="id" value="'.$productsData->id.'">'; 
                                        } 
                                    ?>
                                    <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-4">
                                <!-- SLUG -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Product Slug</h5>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" id="slugProduct" name="slugProduct" onkeypress="return slug(event)" class="form-control" id="product-title-input" value="<?php if($action=='update'&&isset($productsData->slug)) { echo $productsData->slug; } ?>" placeholder="Enter product slug" required>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <!-- BRANDS -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Product Brand</h5>
                                    </div>
                                    <div class="card-body">
                                        <select class="form-select" name="brand" id="brand">
                                            <option value="" selected disabled>Select product brand</option>
                                            <?php foreach($brandsData as $item): ?>      
                                                <option value="<?php if($action=='update'&&isset($productsData->brand->id)&&$item->id==$productsData->brand->id) { echo $productsData->brand->id; } else { echo $item->id; } ?>" 
                                                    <?php if($action=='update'&&isset($productsData->brand->id)&&$item->id==$productsData->brand->id) { echo 'selected="selected"'; }?>>
                                                    <?php if($action=='update'&&isset($productsData->brand->id)&&$item->id==$productsData->brand->id) { echo $productsData->brand->name; } else { echo $item->name; } ?>
                                            </option> 
                                                
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <!-- CATEGORIES -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Product Categories</h5>
                                    </div>
                                    <div class="card-body overflow-scroll" style="height: 100px">
                                        <?php foreach ($categoriesData as $item): ?>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="categories" name="categories[]" 
                                                value="<?php echo $item->id; ?>"
                                                <?php
                                                    if($action=='update'&&isset($productsData->categories)) {
                                                        foreach ($productsData->categories as $itemCategories){
                                                            if($item->id==$itemCategories->id) { 
                                                                echo "checked disabled"; 
                                                            }
                                                        }
                                                    }
                                                ?>>
                                                <label class="form-check-label"><?= $item->name ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <!-- TAGS -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Product Tags</h5>
                                    </div>
                                    <div class="card-body overflow-scroll" style="height: 100px">
                                        <?php foreach ($tagsData as $item): ?>
                                            <div class="form-check form-check-secondary mb-3">
                                                <input class="form-check-input" type="checkbox" id="tags" name="tags[]" value="<?= $item->id ?>"
                                                <?php
                                                    if($action=='update'&&isset($productsData->tags)) {
                                                        foreach ($productsData->tags as $itemTags){
                                                            if($item->id==$itemTags->id) { 
                                                                echo "checked disabled"; 
                                                            }
                                                        }
                                                    }
                                                ?>>
                                                <label class="form-check-label"><?= $item->name ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                    </form>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "../../layout/footer.template.php" ?>
        </div>
        <!-- end main content-->

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