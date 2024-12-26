<?phpsession_start();if (!$_SESSION['admin']){    header('Location: ./Admin_login.php');}?><!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Recycle Bin</title>    <?php    include_once '../../includes/cdn.php';    ?><body class="bg-dark"><header  class="container-fluid sticky-top bg-dark d-flex justify-content-between align-items-center p-3">    <nav aria-label="breadcrumb">        <ol class="breadcrumb">            <li class="breadcrumb-item"><a class="text-light" href="./Dashboard.php">Dashboard</a></li>            <li class="breadcrumb-item active text-light" aria-current="page">Recycle Bin</li>        </ol>    </nav></header><section class="mt-3 p-4"><div class="col-lg-2">    <select id="tables" class="form-select" aria-label="Default select example">        <option value="" selected>Select Table</option>        <option  value="product">product</option>        <option value="brance">branch</option>        <option value="employee">employee</option>    </select></div><div id="tableContainer">   <div style="height: 50vh" class="container-fluid d-flex flex-column justify-content-center align-items-center">       <div class="alert alert-info" role="alert">           <h4 class="alert-heading">Restore Deleted Records</h4>           <p>This page allows you to restore deleted records back to their original state. Select the records you want to recover and click on the "Restore Selected" button.</p>           <hr>           <p class="mb-0">Please ensure you only restore the records that are necessary.</p>       </div>   </div></div></section></body></html><script>    $(document).ready(function (){       $(document).on('change','#tables',function (table){           $.ajax({               url: '../controller/recycleController.php',               type: 'post',               data:{action: table.target.value, table: table.target.value},               success: function (res){                   $('#tableContainer').html(res)               }           })       })        $(document).on('click','#btn_Data',function (id){            let table = $(this).attr('data-table');  // Method 2        //  ajax here            $.ajax({                url: '../controller/recycleController.php',                type: 'post',                data: {id: id.target.value,table:table,action: 'restore'},                dataType: 'json',                success: function (res){                    if (res.success === true){                        Swal.fire({                            text: res.message,                            icon: "success",                            confirmButtonColor: '#000',                            iconColor: '#4361ee'                        });                        setTimeout(()=>{window.location.reload()},2000)                    }                }            })        })    })</script>