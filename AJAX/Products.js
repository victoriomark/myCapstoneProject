$(document).ready(function (){    // Fetch branches and populate the dropdown when the modal is rendered    function loadBranches() {        $.ajax({            url: '../../controller/ProductController.php',            type: 'GET',            data: {action: 'GetBranch'},            dataType: 'json',            success: function (res) {                // Empty the dropdown first                $('#choice_branch').empty();                // Append each branch as an option                res.forEach((branch) => {                    $('#choice_branch').append(`                    <option value="${branch[1]}">${branch[1]}</option>                `);                });            }        });    }// For updating products    $(document).on('click', '#btn_update', function (e) {        // Fetch product details for update        $.ajax({            url: '../../controller/ProductController.php',            type: "POST",            dataType: 'json',            encode: true,            data: {                id: e.target.value,                action: 'updateProduct'            },            success: function (res) {                $('#modal_container').html(`                <!-- Modal for Updating Products -->                <div class="modal fade" id="modal_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">                    <div class="modal-dialog modal-dialog-centered modal-lg">                        <div class="modal-content">                            <div class="modal-header">                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">Update Product Info</h1>                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                            </div>                            <form id="saveForm" action="../src/controller/ProductController.php" method="post" class="modal-body d-flex flex-column gap-2">                                <div class="d-flex gap-5">                                    <div class="input-group mb-3">                                        <span class="input-group-text" id="addon-wrapping">                                            <i class="fa-brands text-muted fa-product-hunt"></i>                                        </span>                                        <input name="productName" value="${res.product_name}" id="ProductName" type="text" class="form-control" placeholder="Product Name" aria-label="ProductName" aria-describedby="addon-wrapping">                                        <div id="product_msg" class="invalid-feedback"></div>                                    </div>                                    <div class="input-group mb-3">                                        <span class="input-group-text">                                            <i class="fa-solid text-muted fa-palette"></i>                                        </span>                                        <input name="itemColor" value="${res.item_color}" id="pick_color" type="text" class="form-control" placeholder="Color" aria-label="Color">                                        <div id="color_msg" class="invalid-feedback"></div>                                    </div>                                </div>                                <div class="d-flex gap-5">                                    <div class="input-group mb-3">                                        <span class="input-group-text text-muted">₱</span>                                        <span class="input-group-text text-muted">0.00</span>                                        <input name="unitPrice" value="${res.unit_price}" id="unit_price" type="number" class="form-control" placeholder="Unit Price">                                        <div id="unit_price_msg" class="invalid-feedback"></div>                                    </div>                                    <input type="hidden" name="id" value="${res.product_id}">                                    <div class="input-group mb-3">                                        <span class="input-group-text" id="addon-wrapping">                                            <i class="fa-solid fa-arrow-trend-up"></i>                                        </span>                                        <input name="currentStack" value="${res.current_stack}" id="stack" type="number" class="form-control" placeholder="Stack" aria-label="Stack" aria-describedby="addon-wrapping">                                        <div id="stack_msg" class="invalid-feedback"></div>                                    </div>                                </div>                                <div class="input-group mb-3">                                    <label class="input-group-text" for="choice_branch">Branch</label>                                    <select name="Branch" class="form-select" id="choice_branch">                                        <option value="${res.branch}" selected>Choose...</option>                                    </select>                                    <div id="branch_msg" class="invalid-feedback"></div>                                </div>                                <div class="modal-footer">                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>                                    <button  style="background-color:  #4361ee" type="submit" class="btn text-light">Save</button>                                </div>                            </form>                        </div>                    </div>                </div>            `);                // Show the modal                $('#modal_update').modal('show');                // Load branch options into the dropdown                loadBranches();            }        });    });    // for saving updated products$(document).on('submit','#saveForm',function (event){    event.preventDefault()    var Data = new FormData(this)    Data.append('action','SaveProduct')    $.ajax({        url: '../../controller/ProductController.php',        type: "POST",        dataType: 'json',        contentType: false,        processData: false,        data: Data,        success: function (res){           if (res.success === true){               Swal.fire({                   text: res.message,                   icon: "success",                   confirmButtonColor: '#4361ee',                   iconColor: '#4361ee'               });               // cloese the modal               $('#modal_update').modal('hide');               setTimeout(()=>{window.location.reload()},2000)           }        }    })})    //for archiving the product    $(document).on('click','#btn_archive',function (product_id){        Swal.fire({            title: "Archive Product Confirmation",            text: "Please note: This change is irreversible!",            icon: "warning",            showCancelButton: true,            confirmButtonColor: "#3085d6",            cancelButtonColor: "#d33",            confirmButtonText: "Yes, Archive it!"        }).then((result) => {            if (result.isConfirmed) {               // ajax                $.ajax({                    url: '../../controller/ProductController.php',                    type: "POST",                    dataType: 'json',                    data: {                        id: product_id.target.value,                        action: 'archiveProduct',                    },                    success:function (res){                        if (res.success === true){                            Swal.fire({                                text: res.message,                                icon: "success",                                confirmButtonColor: '#4361ee',                                iconColor: '#4361ee'                            });                            setTimeout(()=>{window.location.reload()},2000)                        }else {                            Swal.fire({                                text: res.message,                                icon: "error",                                confirmButtonColor: '#4361ee',                                iconColor: '#4361ee'                            });                        }                    }                })            }        });    })    // for adding New Product     $('#form_adding_product').submit(function (event){         event.preventDefault();         var formData = new FormData(this);         formData.append('action','AddProduct')         $.ajax({             url: '../../controller/ProductController.php',             type: 'POST',             data: formData,             dataType: 'json',             processData: false,             contentType: false,             success: function (data) {                 if (data.error) {                     const { ProductName, unitPrice, currentStack, itemColor, Branch } = data.error;                     // Helper function to manage error display                     function handleValidationError(fieldId, errorMsgId, errorMessage) {                         if (errorMessage) {                             $(`#${errorMsgId}`).html(errorMessage);                             $(`#${fieldId}`).addClass('is-invalid');                         } else {                             $(`#${fieldId}`).removeClass('is-invalid');                         }                     }                     // Handle all error fields                     handleValidationError('ProductName', 'product_msg', ProductName);                     handleValidationError('unit_price', 'unit_price_msg', unitPrice);                     handleValidationError('stack', 'stack_msg', currentStack);                     handleValidationError('pick_color', 'color_msg', itemColor);                     handleValidationError('choice_branch', 'branch_msg', Branch);                 }                 if (data.success) {                     Swal.fire({                         text: data.message,                         icon: "success"                     });                     $('#modal_adding_Product').modal('hide');                     setTimeout(() => {                         window.location.reload();                     }, 2000);                 }             }         })     })    loadBranches()})