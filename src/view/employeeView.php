<?phpsession_start();if (!$_SESSION['employee']){  header('Location: ./Employee_login.php');}?><!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Employee</title>    <link rel="stylesheet" href="../../css/bootstrap.min.css">    <link rel="stylesheet" href="../../table.css">    <script src="../../js/bootstrap.bundle.min.js"></script>    <!--    icon-->    <script src="https://kit.fontawesome.com/d4532539ca.js" crossorigin="anonymous"></script><!--    ajax-->    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script><!--   sweet alert-->    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <!-- Include DataTables JS -->    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script></head><body><header style="background-color: #2B2B46" class="container-fluid d-flex justify-content-between align-items-center p-3"> <button data-bs-target="#createSaleModal" data-bs-toggle="modal" class="btn btn-outline-light">Create Sales</button>    <!-- Example single danger button -->    <div class="btn-group">        <button type="button"  class="btn text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">            <i class="fa-solid fs-6  fa-user-tie"></i>        </button>        <ul class="dropdown-menu mt-3 shadow-sm">            <li class="m-2">                <button id="logOut" class="btn badge text-muted">Logout</button>            </li>        </ul>    </div></header><section class="mt-4">    <table id="SalesTble" class="table table-hover table-responsive-sm table-bordered">        <thead>        <tr>            <th>#</th>            <th>Employee Name</th>            <th>Quantiry Sold</th>            <th>Sales Amount</th>            <th>Branch</th>            <th>Date</th>        </tr>        </thead>        <tbody>        <?php        include_once '../controller/employeeViewController.php';          $today = date('Y-m-d');          $branch = $_SESSION['branch'];          $sales = new controller\employeeViewController();          $sales->showAllSalesTodayPerBranch($today,$branch);        ?>        </tbody>    </table></section><div class="modal fade" id="createSaleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">    <form id="formSubmitSales" action="#" method="post" class="modal-dialog modal-dialog-centered modal-lg">        <div class="modal-content">            <div style="background-color: #2B2B46" class="modal-header">                <h1 class="modal-title fs-6 text-light" id="exampleModalLabel">Create New Sales</h1>                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            </div>            <div class="modal-body d-flex flex-column gap-3">                <div class="form-floating">                    <select  name="selectProduct" class="form-select" id="selectProduct" aria-label="Floating label select example">                        <?php                        include_once '../controller/ProductController.php';                        controller\ProductController::showProductList();                        // get the Date Today                        $Today = date('Y-m-d');                        ?>                    </select>                    <label for="floatingSelect">Product Name</label>                </div>                <div class="form-floating mb-2">                    <input name="price" type="number" class="form-control" id="price">                    <label for="floatingInput">Price</label>                </div>                <div class="form-floating mb-2">                    <input min="1" name="quantity" type="number" class="form-control" id="quantity">                    <label for="floatingInput">Quantity</label>                </div>                <div class="form-floating mb-2">                    <input name="EmployeeName" type="text" class="form-control" id="floatingInput">                    <label for="floatingInput">Employee Name</label>                </div>                <input type="hidden" name="ProductId" id="ProductId">                <input type="hidden" name="SaleDate" value="<?= $Today ?>">                <input type="hidden" name="branch" value="<?=$_SESSION['branch'] ?>">            </div>            <div class="modal-footer">                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                <button style="background-color: #2B2B46" type="submit" class="btn text-light">create</button>            </div>        </div>    </form></div><script>    let table = new DataTable('#SalesTble',{        scrollCollapse: true,        scrollY: '50vh',        destroy: true,        searching: true,    });</script><script src="../../AJAX/employeeView.js"></script></body></html>