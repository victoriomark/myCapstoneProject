<?phpnamespace model;use config\DbConnection;use controller\authController;include_once '../config/DbConnection.php';class authModel extends DbConnection{    public  function adminLogin($userName,$password)    {        $query = "SELECT * FROM admin where username = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$userName);        $stmt->execute();        $result = $stmt->get_result();        if ($result->num_rows > 0){            $admin = $result->fetch_assoc();            if (password_verify($password,$admin['password'])){                session_start();                echo json_encode(['success' => true ,'message' => 'successfully logged']);                $_SESSION['admin'] = $userName;            }else{                echo json_encode(['success' => false, 'message' => 'invalid password or username']);            }        }else{            echo json_encode(['success' => false, 'message' => 'Account Not Found']);        }    }    // login for employee per branch    public function employeeLogin($password,$username)    {        $query = "SELECT * FROM employee WHERE username = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$username);        $stmt->execute();        $result = $stmt->get_result();        if ($result->num_rows > 0){            $employee = $result->fetch_assoc();            if (password_verify($password,$employee['password'])){                echo json_encode(['success' => true ,'message' => 'successfully logged']);                $_SESSION['employee'] = $username;                $_SESSION['branch'] = $employee['Branch'];             }else{                echo json_encode(['success' => false, 'message' => 'invalid password or username']);            }        }else{            echo json_encode(['success' => false, 'message' => 'Account Not Found']);        }    }    public function storeAdminCredential($fullname,$username,$password)    {        $password_Hashed = password_hash($password,PASSWORD_BCRYPT);        $query = "INSERT INTO admin(fullname, username, password) VALUES (?,?,?)";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('sss',$fullname,$username,$password_Hashed);        if (!$stmt->execute()){            echo json_encode(['success' => false, 'message' => 'Failed To Prepared Statement']);            return;        }        if ($stmt->execute()){            echo json_encode(['success' => true, 'message' => 'New Account Is Successfully Created']);        }else{            echo json_encode(['success' => false, 'error' => $stmt->error]);        }    }    public function showAdminCredential($username)    {        $query = "SELECT * FROM admin WHERE username = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$username);        $stmt->execute();        $result = $stmt->get_result();        if ($result->num_rows > 0)        {            $dataRow = [];            while ($row = $result->fetch_assoc()){                $dataRow[] = $row;            }            return $dataRow;        }      return [];    }    public function SaveUpdateCredential($updateUsername,$password,$adminId)    {       $query = "UPDATE admin SET username = ?, password = ? WHERE adminId = ?";       $stmt = $this->Connect()->prepare($query);       $stmt->bind_param('ssi',$updateUsername,$password,$adminId);       if (!$stmt->execute()){           echo json_encode(['success' => false, 'message' => 'Error In Prepared Statement: '. $stmt->error]);           return;       }       echo json_encode(['success' => true, 'message' => 'Successfully Updated']);       $stmt->close();    }}