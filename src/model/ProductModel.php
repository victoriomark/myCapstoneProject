<?phpnamespace model;use config\DbConnection;include_once '../config/DbConnection.php';class ProductModel extends DbConnection{    private $productStatus = 'Active';   // method to display the product    public function DisplayProducts()    {          $STATUS_ACTIVE = 'Active';         $query = "SELECT * FROM product WHERE status = ?";         $stmt = $this->Connect()->prepare($query);         $stmt->bind_param('s',$STATUS_ACTIVE);         $stmt->execute();         $result = $stmt->get_result();        $tr = '';        if ($result->num_rows > 0) {            while ($product = $result->fetch_assoc()) {                $tr .= '                <tr>                    <th scope="row">' . $product['id'].'</th>                    <td>' . $product['product_name'].'</td>                    <td>' . $product['unit_price'].'</td>                    <td>' . $product['current_stack'].'</td>                    <td>' . $product['item_color'].'</td>                    <td>' . $product['branch'].'</td>                    <td>                        <button value="'.$product['id'] . '" id="btn_update" type="button" class="btn badge btn-primary">                            Update                        </button>                        <button value="' . $product['id'] . '" id="btn_archive" class="btn badge btn-danger">                            Archive                        </button>                    </td>                </tr>            ';            }        }        echo $tr;    }    // method for updating the products    public function UpdateProducts($id)    {        $query = "select * from product where id = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('i',$id);        $stmt->execute();// wag kalimutan        $result = $stmt->get_result();        return $result->fetch_assoc();    }    public function SaveUpdatedProduct($productName,$unitPrice,$itemColor,$currentStack,$Branch,$id)    {          $query =  "update product set product_name = ? ,unit_price = ? ,item_color = ? , current_stack = ? ,branch = ? where id = ?";          $stmt = $this->Connect()->prepare($query);          $stmt->bind_param('sdsisi',$productName,$unitPrice,$itemColor,$currentStack,$Branch,$id);          if ($stmt->execute()){             echo json_encode(['success' => true, 'message' => 'product is successfully updated']);          }else{              echo json_encode(['success' => false, 'message' => 'Failed to Update']);          }    }    // to archive the product     public function ArchiveProduct($id)     {         $query = "update product set status = 'is_deleted' where id = ?";         $stmt = $this->Connect()->prepare($query);         $stmt->bind_param('i',$id);         if ($stmt->execute()){             echo json_encode(['success' => true, 'message' => 'product is successfully deleted']);         }else{             echo json_encode(['success' => false, 'message' => 'failed to delete product']);         }     }     // add Product    public  function AddProduct($unitPrice,$currentStack,$Branch,$productName,$itemColor,$Status)    {         $query = "insert into product(unit_price, current_stack, branch, product_name, item_color, status)values (?,?,?,?,?,?)";         $stmt = $this->Connect()->prepare($query);         $stmt->bind_param('dissss',$unitPrice,$currentStack,$Branch,$productName,$itemColor,$Status);         if ($stmt->execute()){             echo json_encode(['success' => true, 'message' => 'New Product is Successfully Added']);         }else{             echo json_encode(['success' => false, 'message' => 'Failed to add Product' , 'error' => $stmt->error]);         }    }    public function DisplaySum()    {        $result = $this->Connect()->query("SELECT COUNT(*) AS TotalProduct From product");        $con = '';        while ($Product = $result->fetch_assoc()){          $con .= '            <h4  style="color:#ffffff;">'.number_format($Product['TotalProduct']).'</h4>          ';        }        echo $con;    }    // display the stack alert    public function DisplayLowStack()    {        $result = $this->Connect()->query("SELECT COUNT(*) AS lowStack From product where current_stack <= 3");        while ($lowStack = $result->fetch_assoc()){            ?>            <h4 style="color:#ffffff;"><?= number_format($lowStack['lowStack']) ?></h4>            <?php        }    }    // display the branches    public function DisplayBranch()    {       $result = $this->Connect()->query("select * from brance where status = 'Active'");       return $result->fetch_all();    }    public function showProductName()    {        $query = "SELECT product_name,id from product where status = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$this->productStatus);        $stmt->execute();        $result = $stmt->get_result();        if ($result->num_rows > 0){            $dataRow = [];            while ($row = $result->fetch_assoc()){                $dataRow[] = $row;            }            return $dataRow;        }        return  null;    }}