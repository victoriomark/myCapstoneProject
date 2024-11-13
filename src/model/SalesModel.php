<?phpnamespace model;use config\DbConnection;include_once '../config/DbConnection.php';class SalesModel extends DbConnection{    public $Status_Active = 'Active';public function SumSales(){     $connSale = '';      $result = $this->Connect()->query('SELECT SUM(sales.sale_amount) AS Total_sales FROM sales');      while ($sales = $result->fetch_assoc()){      $connSale .= ' <h4 style="color:#ffffff;">'. number_format($sales['Total_sales']).' PHP'.'</h4>'; } echo $connSale;}    public function DisplayBranchList()    {        $query = 'select * from brance where status = ?';        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$this->Status_Active);        $stmt->execute();        $result = $stmt->get_result();        $btn = '';        while ($row = $result->fetch_assoc()){           $btn .= '              <button style="background-color #2B2B46"  id="Branch_btn" value="'.$row['Branch_Name'].'" type="button"  class="btn text-light badge col-lg-5">              '.$row['Branch_Name'].'               <span class="badge">            <i class="fa-regular  text-light fa-map"></i>             </span>          </button>           ';        }        echo $btn;    }public function DisplayMonthYearSales($branchName){    $Query = "SELECT    branch,    SUM(CASE            WHEN YEAR(Sales_date) = YEAR(CURDATE())                AND MONTH(Sales_date) = MONTH(CURDATE())                THEN sale_amount            ELSE 0        END) AS sales_this_month,    SUM(CASE            WHEN YEAR(Sales_date) = YEAR(CURDATE())                AND MONTH(Sales_date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))                THEN sale_amount            ELSE 0        END) AS sales_last_month,    SUM(CASE            WHEN YEAR(Sales_date) = YEAR(CURDATE())                THEN sale_amount            ELSE 0        END) AS sales_this_yearFROM salesWHERE branch = ?GROUP BY branch;";    $stmt = $this->Connect()->prepare($Query);    $stmt->bind_param('s',$branchName);    $stmt->execute();    $result = $stmt->get_result();    $con = '';    // check if we have result    if ($result->num_rows > 0){        // then loop the result        while ($row = $result->fetch_assoc()){            $con .= '           <!-- card -->        <div class="card bg-transparent border-0 text-light">            <div class="card-body text-light">                <div>                    <h5 class="card-title">Sales this Month</h5>                    <h3>₱'.$row['sales_this_month'].'</h3>                </div>            </div>        </div>          <div class="card bg-transparent border-0 text-light">            <div class="card-body">                <div>                    <h5 class="card-title text-light">Sales Last Month</h5>                     <h3>₱'.$row['sales_last_month'].'</h3>                </div>            </div>        </div>        <!-- card -->        <div class="card bg-transparent border-0  text-light">            <div class="card-body">                <div>                    <h5 class="card-title">Sales this Year</h5>                  <h3>₱'.number_format($row['sales_this_year']).'</h3>                </div>            </div>        </div>       ';        }        echo $con;    }}public function GenerateMonthlySalesChart(){    $result = $this->Connect()->query("SELECT    months.month AS sale_month,    COALESCE(SUM(s.sale_amount), 0) AS total_salesFROM    (SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL     SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL     SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL     SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) AS months        LEFT JOIN    sales s ON months.month = MONTH(s.Sales_date)        AND s.Sales_date IS NOT NULL        AND s.sale_amount > 0GROUP BY    months.monthORDER BY    months.month;");    $data = [];    while ($row = $result->fetch_assoc()){        $data[] = $row;    }    header('Content-Type: application/json');  echo json_encode($data);}public function DisplaySales(){  $result = $this->Connect()->query(" SELECT         p.product_name,        s.sale_amount,        s.quantity_sold,        s.branch    FROM        product p        JOIN        sales s ON p.product_id = s.product_id");  $tr = '';  while ($row = $result->fetch_assoc()){      $tr .= '        <tr>          <td>'.$row['product_name'].'</td>            <td>'.$row['quantity_sold'].'</td>               <td>'.$row['branch'].'</td>             <td>₱'.number_format($row['sale_amount'],2).'</td>       </tr>      ';  }  echo $tr;}public function CreateSalesReport($startDate,$EndDate){    $query = "    SELECT    p.product_name,    s.sale_amount,    s.quantity_sold,    s.branchFROM    product p        JOIN    sales s ON p.product_id = s.product_idWHERE    s.Sales_date BETWEEN ? AND ?;    ";    $stmt = $this->Connect()->prepare($query);    $stmt->bind_param('ss',$startDate,$EndDate);    $stmt->execute();    $result = $stmt->get_result();    $tr = '';    if ($result->num_rows > 0){        while ($row = $result->fetch_assoc()){            $tr .= '        <tr>          <td>'.$row['product_name'].'</td>            <td>'.$row['quantity_sold'].'</td>               <td>'.$row['branch'].'</td>            <td>₱'.number_format($row['sale_amount'],2).'</td>       </tr>      ';        }    }else{        $tr .= "          <td><strong>No Result Please Select Another Date</strong></td>        ";    }    echo $tr;}    public function ConvertPDF($startDate, $EndDate)    {        // Ensure that the correct path to fpdf.php is set        require '../../Vendors/fpdf186/fpdf.php';        if (isset($_GET['startDate']) && isset($_GET['endDate'])) {            $total = 0;            $Query = "        SELECT            p.product_name,            s.sale_amount,            s.quantity_sold,            s.branch        FROM            product p            JOIN            sales s ON p.product_id = s.product_id        WHERE            s.Sales_date BETWEEN ? AND ?;        ";            $stmt = $this->Connect()->prepare($Query);            $stmt->bind_param('ss', $startDate, $EndDate);            $stmt->execute();            $result = $stmt->get_result();            // Create a new PDF instance (ensure it uses the global FPDF class)            $pdf = new \FPDF();            $pdf->AddPage();            // Set title            $pdf->SetFont('Arial', 'B', 16);            $pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');            // Date range            $pdf->SetFont('Arial', '', 12);            $pdf->Cell(0, 10, 'From: ' . $startDate . ' To: ' . $EndDate, 0, 1, 'C');            // Table header            $pdf->SetFont('Arial', 'B', 12);            $pdf->Cell(50, 10, 'Product Name', 1);            $pdf->Cell(30, 10, 'Branch', 1);            $pdf->Cell(30, 10, 'Quantity Sold', 1);            $pdf->Cell(40, 10, 'Sales Amount', 1);            $pdf->Ln();            // Loop through data and display in PDF            if ($result->num_rows > 0) {                $pdf->SetFont('Arial', '', 12);                while ($row = $result->fetch_assoc()) {                    $total += $row['sale_amount'];                    $pdf->Cell(50, 10, $row['product_name'], 1);                    $pdf->Cell(30, 10, $row['branch'], 1);                    $pdf->Cell(30, 10, $row['quantity_sold'], 1);                    $pdf->Cell(40, 10, 'PHP: ' . number_format($row['sale_amount'], 2), 1);                    $pdf->Ln();                }                $pdf->SetFont('Arial', 'B', 12);                $pdf->Cell(110, 10, 'Total', 1);                $pdf->Cell(40, 10, 'PHP: ' . number_format($total, 2), 1);                $pdf->Ln();            } else {                $pdf->Cell(0, 10, 'No sales data found for the selected date range.', 0, 1, 'C');            }            // Output the PDF            $pdf->Output('D', 'sales_report.pdf');        }    }}