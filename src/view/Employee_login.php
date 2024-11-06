<?phpsession_start();if (isset($_SESSION['employee'])){    header('Location: ./employeeView.php');}?><!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <link rel="stylesheet" href="../../css/bootstrap.min.css">    <script src="../../js/bootstrap.bundle.min.js"></script>    <link href="https://fonts.cdnfonts.com/css/ninja-naruto" rel="stylesheet">    <!--    ajax cdn-->    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <title>login</title>    <style>        h1{            font-family: 'Ninja Naruto', sans-serif;        }    </style></head><body ><main style="width: 100%; height: 100vh;" class="d-flex flex-column justify-content-center align-items-center">    <form id="employeeLoginForm" method="post" action="../controller/authController.php" class="d-flex flex-column gap-3 col-lg-3">        <h1 style="color: #0B2F9F" class="fw-bold">SIGN IN</h1>        <div>            <label for="username">                UserName            </label>            <input type="text" class="form-control" name="username" id="username" placeholder="Enter UserName">            <div id="usernameMSG" class="invalid-feedback"></div>        </div>        <div>            <label for="password">                Password            </label>            <input autocomplete="pasword" type="password" class="form-control" name="password" id="password" placeholder="Enter password">            <div id="passwordMSG" class="invalid-feedback"></div>        </div>        <button style="background-color: #0B2F9F" type="submit" class="btn text-light">Login</button>    </form></main></body></html><script>$(document).ready(function (){    $(document).on('submit','#employeeLoginForm',function (event){        event.preventDefault()        const formData = new FormData(this)        formData.append('action','employeeLogin')        $.ajax({            url: '../controller/authController.php',            type: 'post',            data: formData,            processData: false,            contentType: false,            dataType: 'json',            success: function (res){                if (res.success === true){                    const Toast = Swal.mixin({                        toast: true,                        position: "top-end",                        showConfirmButton: false,                        timer: 2000,                        timerProgressBar: true,                        didOpen: (toast) => {                            toast.onmouseenter = Swal.stopTimer;                            toast.onmouseleave = Swal.resumeTimer;                        }                    });                    Toast.fire({                        icon: "success",                        text: res.message                    });                    setTimeout(() => {window.location.href = './employeeView.php'},2000)                }                if (res.success === false ) {                    const Toast = Swal.mixin({                        toast: true,                        position: "top-end",                        showConfirmButton: false,                        timer: 2000,                        timerProgressBar: true,                        didOpen: (toast) => {                            toast.onmouseenter = Swal.stopTimer;                            toast.onmouseleave = Swal.resumeTimer;                        }                    });                    Toast.fire({                        icon: "error",                        text: res.message                    });                }            }        })    })})</script>