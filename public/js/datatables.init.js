$(document).ready(function () {
    //TABLE USERS: "view/users/index.php"
    $("#tableUsers").DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Showing 0 to 0 of 0 entries",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Show _MENU_ entries",
            "loadingRecords": "Loading...",
            "processing":     "",
            "search":         "Search:",
            "zeroRecords":    "No matching records found",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Next",
                "previous":   "Previous"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });

    //TABLE PRODUCTS: "view/index.php"
    $("#tableProducts").DataTable();
    $("#tableProducts").removeAttr('width').DataTable();

    //TABLE DETAILS OF A PRODUCT - PRESENTATIONS: "view/products/detail.php" 
    $("#tableProductDetailsPresentations").DataTable();

    //TABLE DETAILS OF A PRODUCT - ORDERS: "view/products/detail.php" 
    $("#tableProductDetailsOrders").DataTable();

    //TABLE BRANDS: "view/catalogs/brands.php"
    $("#tableBrands").DataTable();

    //TABLE CATEGORIES: "view/catalogs/categories.php"
    $("#tableCategories").DataTable();

    //TABLE TAGS: "view/catalogs/tags.php"
    $("#tableTags").DataTable();
    
});