<?phpnamespace model;use config\DbConnection;include '../config/DbConnection.php';class branchModel extends DbConnection{   public $Status_Active = 'Active';   public $Status_IsDeleted = 'is_deleted';    // Display Branch list    public function DisplayBranchList()    {        $query = 'select * from brance where status = ?';        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('s',$this->Status_Active);        $stmt->execute();        $result = $stmt->get_result();        $tr = '';        while ($row = $result->fetch_assoc()){       $tr .= '       <tr>           <th scope="row">'.$row['id'].'</th>         <td>'.$row['Branch_Name'].'</td>         <td>         <button  value="'.$row['id'].'" id="update_branch" class="btn badge btn-primary">update</button>          <button value="'.$row['id'].'" id="delete_branch" class="btn badge btn-danger">archive</button>       </td>      </tr>       ';        }        echo $tr;    }    // for adding new Branch    public  function CreateBranch($BranchName)    {        $query = "insert into brance(Branch_Name,status) VALUES (?,?)";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('ss',$BranchName,$this->Status_Active);        if ($stmt->execute()){            echo json_encode(['success' => true,'message' => 'New Product is Successfully added']);        }else{            echo json_encode(['success' => false,'message' => 'Failed to add branch' ,'error' => $stmt->error]);        }    }    // archive the branch    public function ArchiveBranch($id)    {        $query = "Update brance set status = ? where id = ?";        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('si',$this->Status_IsDeleted,$id);        if ($stmt->execute()){            echo  json_encode(['success' => true, 'message' => 'successfully deleted']);        }else{            echo  json_encode(['success' => false, 'message' => 'Failed to delete','error' => $stmt->error]);        }    }    // update branch    public  function UpdateBranch($id)    {      $query = "select * from brance where id = ?";      $stmt = $this->Connect()->prepare($query);      $stmt->bind_param('i',$id);      $stmt->execute();      $result = $stmt->get_result();      $modal = '';      while ($row = $result->fetch_assoc()){          $modal .= '          <div class="modal fade" id="modal_update_branch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">    <div class="modal-dialog modal-dialog-centered modal-md">        <div class="modal-content">            <div class="modal-header">                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">UPDATE BRANCHS</h1>                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            </div>            <form id="form_f_update" action="../controller/branchController.php" method="post" class="modal-body d-flex flex-column gap-2">                <div class="d-flex gap-5">                    <div class="input-group mb-3">                                <span class="input-group-text" id="addon-wrapping">                                   <i class="fa-solid text-muted fa-location-dot"></i>                                </span>                        <input id="BranchName" value="'.$row['Branch_Name'].'" name="BranchNameSave" type="text" class="form-control" placeholder="Branch Name" aria-label="BranchName" aria-describedby="addon-wrapping">                        <input  name="id" value="'.$row['id'].'" type="hidden">                        <div id="branch_msg" class="invalid-feedback"></div>                    </div>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>                    <button  style="background-color: #4361ee" type="submit" class="btn text-light">                         Save                    </button>                </div>            </form>        </div>    </div>          ';      }      echo $modal;    }    public function SaveUpdateBranch($BranchName,$id)    {        $query = 'update brance set Branch_Name = ? where id = ?';        $stmt = $this->Connect()->prepare($query);        $stmt->bind_param('si',$BranchName,$id);        if ($stmt->execute()){            echo json_encode(['success' => true, 'message' => 'Branch is Successfully Updated']);        }else{            echo json_encode(['success' => false,'message' => 'Failed to update', 'error' => $stmt->error]);        }    }}