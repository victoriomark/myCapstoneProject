<!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Low Stack List</title>    <link rel="stylesheet" href="../../css/bootstrap.min.css">    <link rel="stylesheet" href="../../style.css">    <link rel="stylesheet" href="../../table.css">    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">    <!-- Include jQuery -->    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    <script src="../../js/bootstrap.bundle.min.js"></script>    <!-- Include DataTables JS -->    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>    <!--    ajax cdn-->    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    <!--    cdn sweet alert-->    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <!--    icon-->    <script src="https://kit.fontawesome.com/d4532539ca.js" crossorigin="anonymous"></script></head><body ><header style="background-color: #4361ee" class="container-fluid d-flex justify-content-between align-items-center p-3">    <nav aria-label="breadcrumb">        <ol class="breadcrumb">            <li class="breadcrumb-item"><a class="text-light" href="./Dashboard.php">Dashboard</a></li>            <li class="breadcrumb-item active text-light" aria-current="page">Low Stack List</li>        </ol>    </nav></header><section class="p-4">    <table id="BranchTable" class="table table-hover table-responsive-sm table-striped">        <thead>        <tr>            <th>status</th>            <th>Product Name</th>            <th>Item Color</th>            <th>Branch</th>            <th>Action</th>        </tr>        </thead>        <tbody>        <?php         include_once '../controller/lowStackController.php';         $lowStack = new \controller\lowStackController();         $lowStack->displayLowStacks();        ?>        </tbody>    </table>    <div id="modal_con"></div></section><script>    $(document).ready(function (){        $(document).on('click','#btn_updateStack',function (e){             $.ajax({                 url: '../controller/lowStackController.php',                 type: 'post',                 data:{                     productId: e.target.value,                     action: 'update_'                 },                 success: function (data) {                     if ($('#updateModal').length === 0) {                         $('body').append(data);                     } else {                         $('#updateModal').replaceWith(data)                     }                     $('#updateModal').modal('show')                 }             })        })       $(document).on('submit','#SaveModelForm',function (event){           event.preventDefault()           const formData = new FormData(this)           formData.append('action','Save')           $.ajax({               url: '../controller/lowStackController.php',               type: 'post',               data: formData,               contentType: false,               processData: false,               dataType: 'json',               success: function (res){                  if (res.success == true){                      Swal.fire({                          icon: "success",                          text: res.message,                          showConfirmButton: false,                          timer: 1500                      });                      setTimeout(() =>{window.location.reload()},2000)                  }else {                      Swal.fire({                          icon: "error",                          text: res.message,                          showConfirmButton: false,                          timer: 1500                      });                  }               }           })       })    })</script></body></html>