<?phpnamespace controller;use Cassandra\Value;use model\ProductModel;include'../model/ProductModel.php';class ProductController{    public function DisplayProducts()    {        $model = new ProductModel();        $model->DisplayProducts();       ;    }    public function DisplayBranch()    {        $model = new ProductModel();        $branch = $model->DisplayBranch();        echo json_encode($branch);    }    public function UpdateProduct()    {        // check kung merong id        if (isset($_POST['id'])){            $id = $_POST['id'];            $model = new ProductModel();            $product = $model->UpdateProducts($id);            echo json_encode($product);        }    }    public function SaveUpdatedProduct()    {        if (isset($_POST['id'])){            // Get te product info            $productName = $_POST['productName'];            $unitPrice = $_POST['unitPrice'];            $currentStack = $_POST['currentStack'];            $itemColor = $_POST['itemColor'];            $Branch = $_POST['Branch'];            $id = $_POST['id'];            $model =  new ProductModel();            $model->SaveUpdatedProduct($productName,$unitPrice,$itemColor,$currentStack,$Branch,$id);        }else{            echo json_encode('Id not found');        }    }    // for  adding New Product    public  function AddNewProduct()    {        $ProductName = htmlspecialchars($_POST['ProductName']);        $unitPrice = htmlspecialchars($_POST['unitPrice']);        $currentStack = htmlspecialchars($_POST['CurrentStack']);        $Branch = htmlspecialchars($_POST['Branch']);        $itemColor = htmlspecialchars($_POST['itemColor']);        $data = [];        $error  = [];        // validation        $inputs = [            'ProductName' => $ProductName,            'unitPrice' => $unitPrice,            'currentStack' => $currentStack,            'Branch' => $Branch,            'itemColor' => $itemColor,        ];       $Messages = [            'ProductName' => 'product name is required',            'unitPrice' => 'unit price is required',            'currentStack' =>'stack is required',            'Branch' => 'branch name is required',            'itemColor' => 'color is required',        ];       // for each        foreach ($inputs as $key => $value){            if (empty($value)){                $error[$key] = $Messages[$key];            }        }        //now check if have an error        if (!empty($error)){            $data['error'] = $error;            echo json_encode($data);        }else{            // then call the modal method to insert the product            $model = new ProductModel();            $model->AddProduct($unitPrice,$currentStack,$Branch,$ProductName,$itemColor,'Active');        }    }    // to archive product    public function ArchiveProduct()    {        // from ajax request        if (isset($_POST['id'])){            $id = $_POST['id'];            $model = new ProductModel();            $model->ArchiveProduct($id);        }else{            echo json_encode('No Id');        }    }    public function DisplaySum()    {        $model = new ProductModel();        $model->DisplaySum();    }    public function DisplayLowStack()    {        $model = new ProductModel();        $model->DisplayLowStack();    }    public static function showProductList ()    {      $model = new ProductModel();      $data = $model->showProductName();        $dropdown = '';      if ($data){          foreach ($data as $row){              $dropdown .= '             <option value="'.$row['product_id'].'">'.$row['product_name'].'</option>          ';          }          echo $dropdown;      }else{          echo '<option selected>No Product Available</option>';      }    }}if ($_SERVER['REQUEST_METHOD'] === 'GET'){    $productController = new ProductController();     if (isset($_GET['action'])){         switch ($_GET['action']){             case 'GetBranch':                 $productController->DisplayBranch();                 break;             case 'getAllProductInfo':                 $productController::showProductList();                 break;         }     }}if ($_SERVER['REQUEST_METHOD'] === 'POST'){    $controller = new ProductController();    if (isset($_POST['action'])){        switch ($_POST['action']){            case 'updateProduct':                $controller->UpdateProduct();                break;            case 'SaveProduct':                $controller->SaveUpdatedProduct();                break;            case 'archiveProduct':                $controller->ArchiveProduct();                break;            case 'AddProduct':                $controller->AddNewProduct();                break;        }    }}