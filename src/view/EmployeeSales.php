<!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Employee Sales</title>    <link rel="stylesheet" href="../../css/bootstrap.min.css">    <link rel="stylesheet" href="../../style.css">    <link rel="stylesheet" href="../../table.css">    <script src="../../js/bootstrap.bundle.min.js"></script>    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">    <!-- Include jQuery -->    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    <!-- Include DataTables JS -->    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>    <!--    ajax cdn-->    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    <!--    cdn sweet alert-->    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <!--    icon-->    <script src="https://kit.fontawesome.com/d4532539ca.js" crossorigin="anonymous"></script></head><body ><header class="container-fluid bg-dark d-flex justify-content-between align-items-center p-3">    <nav aria-label="breadcrumb">        <ol class="breadcrumb">            <li class="breadcrumb-item"><a class="text-light" href="./Dashboard.php">Dashboard</a></li>            <li class="breadcrumb-item active text-light" aria-current="page">Employee Sales</li>        </ol>    </nav></header><div id="con" class="container-fluid mt-3 d-flex justify-content-between align-items-center">    <form id="EmployeeSaleForm" action="../controller/SalesController.php" method="post" class="d-flex gap-3">        <label for="startDate">            <input type="date" name="startDate" class="form-control" id="startDate">        </label>        <label for="EndDate">            <input type="date"  name="endDate" class="form-control" id="EndDate">        </label>        <button style="background-color: #2B2B46" type="submit" class="btn text-light fw-bold">Filter</button>    </form></div><section class="mt-2">    <table id="BranchTable" class="table table-hover table-responsive-sm table-striped">        <thead class="table-dark">        <tr>            <th>Name</th>            <th>Branch</th>            <th>Product</th>            <th>Quantity Sold</th>        </tr>        </thead>        <tbody>        <?php        include '../controller/EmployeeSaleController.php';        $controller = new \controller\EmployeeSaleController();        $controller->DisplayDefault();        ?>        </tbody>    </table></section><script>    let table = new DataTable('#BranchTable',{        scrollCollapse: true,        scrollY: '50vh',        destroy: true,        paging: true,        searching: true,        ordering: true    });</script><script>    $(document).ready(function (){        $('#EmployeeSaleForm').submit(function (event){            event.preventDefault();            const formData = new FormData(this);            $.ajax({                url:'../controller/EmployeeSaleController.php',                type: 'POST',                data: formData,                processData: false,                contentType: false,                success: function (data){                    $('tbody').html(data)                }            })        })    })</script></body></html>