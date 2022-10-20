<?php
	include_once "../../app/config.php";
    include_once '../../app/UserController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
    
    $userControl = new UserController();
    $users = $userControl -> getUsers();
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Users</title>
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
                                <h4 class="mb-sm-0">Users</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">Ecommerce</li>
                                        <li class="breadcrumb-item active">Users</li>
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
                                                    <!-- <a href="apps-ecommerce-add-product.html" class="btn btn-success" id="addproduct-btn"><i class="ri-add-line align-bottom me-1"></i> Add Product</a> -->
                                                    <button onclick="addUser()" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgrid" class="btn btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line align-bottom me-1 label-icon align-middle rounded-pill fs-16 me-2"></i> Add User</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TABLA USERS -->
                                    <div class="card-body">
                                    <table id="tableUsers" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Avatar</th>
                                                <th scope="col">First name</th>
                                                <th scope="col">Last name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="avatar-group">
                                                            <img src="<?= $item->avatar ?>" alt="Profile pic" class="rounded-circle avatar-xxs">
                                                        </div>
                                                    </td>
                                                    <td><?php if(isset($item->name)) echo $item->name; else echo "Name not found."; ?></td>
                                                    <td><?php if(isset($item->lastname)) echo $item->lastname; else echo "Lastname not found."; ?></td>
                                                    <td><?php if(isset($item->email)) echo $item->email; else echo "Email not found."; ?></td>
                                                    <td><?php if(isset($item->phone_number)) echo $item->phone_number; else echo "Phone number not found."; ?></td>
                                                    <td><?php if(isset($item->role)) echo $item->role; else echo "Role not found."; ?></td>
                                                    <td>
                                                        <div class="dropdown ms-2">
                                                            <a class="btn btn-sm btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <li><a class="dropdown-item" href="<?= BASE_PATH.'users/'.$item->id?>">View</a></li>
                                                                <li><a class="dropdown-item" data-user='<?php echo json_encode($item)?>' onclick="editUser(this)" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">Edit</a></li>
                                                                <li><a class="dropdown-item " onclick="remove(<?php echo $item->id ?>)">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!--</table>-->
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
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="<?= BASE_PATH ?>users" >
                        <div class="row g-3">
                            <!-- NAME INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter firstname" required>
                                </div>
                            </div>
                            <!-- LASTNAME INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="lastname" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname" required>
                                </div>
                            </div>
                            <!-- EMAIL INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" pattern="(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}" required>
                                </div>
                            </div>
                            <!-- PHONE NUMBER INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="phone_number" class="form-label">Phone number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <!-- ROLE INPUT -->
                            <div class="col-xxl-6">
                                <label for="role" class="form-label">Role</label>
                                <div class="input-group">
                                    <select class="form-select" id="role" name="role" required>
                                        <option selected disabled>Select a role</option>
                                        <option value="Administrador">Administrador</option>
                                    </select>
                                </div>
                            </div>
                            <!-- PROFILE PHOTO (AVATAR) INPUT -->
                            <div id="divAvatar" class="col-xxl-6">
                                <label for="avatar" class="form-label">Profile photo</label>
                                <div class="input-group">
                                    <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*" required>
                                </div>
                            </div>                   
                            <!-- PASSWORD INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" onkeypress="return noSpaces(event)" required>
                                </div>
                            </div>
                            <!-- CONFIRM PASSWORD INPUT -->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="confirmPassword" class="form-label">Confirm password</label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Repeat your password" onkeypress="return noSpaces(event)" required>
                                </div>
                            </div>
                            <!-- CREATED_BY INPUT -->
                            <div id="divCreatedBy" class="col-xxl-6">
                                <label for="created_by" class="form-label">Created by</label>
                                <select name="created_by" id="created_by" name="created_by" class="form-select" required>
                                    <option value="" selected disabled>Select someone</option>
                                    <?php foreach($users as $item): ?>
                                        <option value="<?php echo $item->name.' '.$item->lastname; ?>"><?php echo $item->name.' '.$item->lastname; ?></option> 
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- INPUTS HIDDEN AND BUTTONS -->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" id="typeAction" name="action" value="update">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
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
    function remove (id) {
        swal({
            title: "Are you sure you want to remove this user?",
            text: "You will not be able to recover this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal("The user has been deleted!", {
            icon: "success",
            });

            var bodyFormData = new FormData();
            bodyFormData.append('id', id);
            bodyFormData.append('action', 'remove');
            bodyFormData.append('global_token', '<?= $_SESSION['global_token'] ?>');

            axios.post('<?= BASE_PATH ?>userc', bodyFormData)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                //console.log(error);
                alert("An error occurred while performing the action.");
            });

        } else {
            swal("This user is safe!");
        }
        });
    }

    function addUser() {
        document.getElementById("typeAction").value = "create";
        document.getElementById("exampleModalgridLabel").innerHTML = "Add new user";
        document.getElementById("divCreatedBy").hidden = true;
        document.getElementById("divAvatar").hidden = false;

        document.getElementById("name").value = "";
        document.getElementById("lastname").value = "";
        document.getElementById("email").value = "";
        document.getElementById("phone_number").value = "";
        document.getElementById("role").selectedIndex = 0;
        document.getElementById("created_by").disabled = true;
        document.getElementById("avatar").disabled = false;
        document.getElementById("password").value = "";
        document.getElementById("confirmPassword").value = "";
        document.getElementById("id").value = "";
    }

    function editUser(target) {
        document.getElementById("typeAction").value = "update";
        document.getElementById("exampleModalgridLabel").innerHTML = "Edit user";
        document.getElementById("divCreatedBy").hidden = false;
        document.getElementById("divAvatar").hidden = true;

        let user = JSON.parse(target.getAttribute('data-user'));

        document.getElementById("name").value = user.name;
        document.getElementById("lastname").value = user.lastname;
        document.getElementById("email").value = user.email;
        document.getElementById("phone_number").value = user.phone_number;
        document.getElementById("role").value = user.role;
        document.getElementById("created_by").disabled = false;
        document.getElementById("created_by").value = user.created_by;
        document.getElementById("avatar").disabled = true;
        document.getElementById("password").value = "";
        document.getElementById("confirmPassword").value = "";
        document.getElementById("id").value = user.id;
    }
</script>

</html>