$(document).ready(function (){    $(document).on('change','#selectProduct',function (e){        $.ajax({            url: '../controller/employeeViewController.php',            type: 'post',            dataType: 'json',            data:{productId: e.target.value, action: 'showProductInfo'},            success: function (res){              res.map((item)=>{                  const {unit_price,current_stack,branch} = item                  $('#price').val(unit_price)                  $('#quantity').val(current_stack)              })            }        })    })})