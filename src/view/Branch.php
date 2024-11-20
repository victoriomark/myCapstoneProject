<?phpsession_start();if (!$_SESSION['admin']){    header('Location: ./Admin_login.php');}?><!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Branch</title>    <link rel="stylesheet" href="../../css/bootstrap.min.css">    <link rel="stylesheet" href="../../style.css">    <link rel="stylesheet" href="../../table.css">    <script src="../../js/bootstrap.bundle.min.js"></script>    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">    <!-- Include jQuery -->    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    <!-- Include DataTables JS -->    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>    <!--    ajax cdn-->    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    <!--    cdn sweet alert-->    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <!--    icon-->    <script src="https://kit.fontawesome.com/d4532539ca.js" crossorigin="anonymous"></script></head><style>    .swal2-timer-progress-bar {        background-color: #ff6347; /* Change the color to your desired value, e.g., tomato red */    }</style><body ><header style="background-color: #2B2B46" class="container-fluid d-flex justify-content-between align-items-center p-3">    <nav aria-label="breadcrumb">        <ol class="breadcrumb">            <li class="breadcrumb-item"><a class="text-light" href="./Dashboard.php">Dashboard</a></li>            <li class="breadcrumb-item active text-light" aria-current="page">Branch</li>        </ol>    </nav>    <button type="button" data-bs-toggle="modal" data-bs-target="#modal_create_branch" class="btn btn-outline-light">        Create Branch<span class="badge text-bg-secondary"></span>    </button></header><section class="mt-5 p-4">    <table id="BranchTable" class="table table-hover table-responsive-sm table-striped">        <thead>        <tr>            <th>#</th>            <th>Branch Name</th>            <th>Action</th>        </tr>        </thead>        <tbody>        <?php        include '../controller/branchController.php';        $controller = new \controller\branchController();        $controller->DisplayBranch();        ?>        </tbody>    </table></section><div id="modal_container"></div><!-- Modal for Adding Branch --><div class="modal fade" id="modal_create_branch"  data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">    <div class="modal-dialog modal-dialog-centered modal-md">        <div class="modal-content">            <div style="background-color: #2B2B46" class="modal-header">                <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Create Branch</h1>                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            </div>            <form id="form_f_creating_B" action="../controller/branchController.php" method="post" class="modal-body d-flex flex-column gap-2">                <div class="d-flex gap-5">                    <div class="input-group mb-3">                                <span class="input-group-text" id="addon-wrapping">                                   <i class="fa-solid text-muted fa-location-dot"></i>                                </span>                        <input id="BranchName" name="BranchName" type="text" class="form-control" placeholder="Branch Name" aria-label="BranchName" aria-describedby="addon-wrapping">                        <div id="branch_msg" class="invalid-feedback"></div>                    </div>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>                    <button style="background-color: #2B2B46" type="submit" class="btn text-light">                        <i class="fa-solid fa-plus"></i>                        Create                    </button>                </div>            </form>        </div>    </div><script>    let table = new DataTable('#BranchTable',{        scrollCollapse: true,        scrollY: '50vh',        destroy: true,        paging: true,        searching: true,        ordering: true    });</script><script src="../../AJAX/Branch.js"></script></body></html>