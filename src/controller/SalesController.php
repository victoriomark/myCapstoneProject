<?phpnamespace controller;use model\SalesModel;include_once '../model/SalesModel.php';class SalesController{ public function DisplaySumSales() {     $modal = new SalesModel();     $modal->SumSales(); } public function DisplayBranch() {     $modal = new SalesModel();     $modal->DisplayBranchList(); } public function DisplayMonthlyYearlySales() {     if (isset($_POST['branchName'])){         $branch = $_POST['branchName'];         $modal = new SalesModel();         $modal->DisplayMonthYearSales($branch);     }else{         echo 'No Branch Provided';     } } public function DefaultDisplay() {     $modal = new SalesModel();     $modal->DisplayMonthYearSales('Calasiao'); }    public function GenerateMonthlySalesChart()    {        $model = new SalesModel();         $model->GenerateMonthlySalesChart();    }    public function DisplaySales()    {        $model = new SalesModel();        $model->DisplaySales();    }    public function CreateSaleReport()    {        $startDate = $_POST['startDate'];        $EndDate = $_POST['EndDate'];        echo $EndDate;      if (empty($startDate) && empty($EndDate)){          echo "            <script>           Swal.fire({               text: 'Please Select Dates',                 confirmButtonColor: '#4361ee',                 iconColor: '#ff6347',                  icon: 'warning',                 toast: true,                 target: 'body',                position: 'top-end',                showConfirmButton: false,                timer: 2000,  // The alert will auto-close after 5 seconds              timerProgressBar: true,  // Show the progress bar for the timer              })            </script>            ";          }else{          $model = new SalesModel();          $model->CreateSalesReport($startDate,$EndDate);      }    }    public function GeneratePDF()    {        // Ensure that startDate and endDate are passed as GET parameters        if (isset($_GET['startDate']) && isset($_GET['endDate'])) {            $startDate = $_GET['startDate'];            $EndDate = $_GET['endDate'];            // Ensure startDate and endDate are valid            if (!empty($startDate) && !empty($EndDate)) {                $model = new \model\SalesModel();                $model->ConvertPDF($startDate, $EndDate);            } else {                echo "Please provide valid dates.";            }        }    }}if ($_SERVER['REQUEST_METHOD'] === 'GET'){    $controller = new SalesController();    $controller->GeneratePDF();}if ($_SERVER['REQUEST_METHOD'] === 'POST'){    if (isset($_POST['action'])){        $controller = new SalesController();        switch ($_POST['action']){            case 'GetMonthlyYearSale':                $controller->DisplayMonthlyYearlySales();                break;            case 'GetMonthlySalesChart':                $controller->GenerateMonthlySalesChart();                break;            case 'CreateSaleReport':                $controller->CreateSaleReport();                break;        }    }}