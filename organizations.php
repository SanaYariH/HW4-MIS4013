<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organizations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      
<?php
$servername = "localhost";
$username = "sanaoucr_syuser";
$password = "zxvf=zsw;*iY";
$dbname = "sanaoucr_homework3-MIS4013";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into organizations (organization_name) values (?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("s", $_POST['iName']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New organization is added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update organizations set organization_name=? where organization_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("si", $_POST['iName'], $_POST['iid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Organization is edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from organizations where organization_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['iid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Organization is deleted.</div>';
      break;
  }
}
?>
    
      <h1 style="background-color:powderblue; text-align:center;">ORGANIZATIONS</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT organization_id, organization_name from organizations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["organization_id"]?></td>
            <td><?=$row['organization_name']?></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editorganizations<?=$row["organization_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editorganizations<?=$row["organization_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editorganizations<?=$row["organization_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editorganizations<?=$row["organization_id"]?>Label">Edit Organizations</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="">
                        <div class="mb-3">
                          <label for="editorganizations<?=$row["organization_id"]?>Name" class="form-label">Organization</label>
                          <input type="text" class="form-control" id="editorganizations<?=$row["organization_id"]?>Name" aria-describedby="editorganizations<?=$row["organization_id"]?>Help" name="iName" value="<?=$row['organization_name']?>">
                          <div id="editorganizations<?=$row["organization_id"]?>Help" class="form-text">Enter the Organization's name.</div>
                        </div>
                        <input type="hidden" name="iid" value="<?=$row['organization_id']?>">
                        <input type="hidden" name="saveType" value="Edit">
                        <input type="submit" class="btn btn-primary" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="iid" value="<?=$row["organization_id"]?>" />
                <input type="hidden" name="saveType" value="Delete">
                <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
              </form>
            </td>
          </tr>
          
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
          
        </tbody>
      </table>
      <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addorganizations">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addorganizations" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addorganizationsLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addorganizationsLabel">Add Organization</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="organization_name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="organizationName" aria-describedby="nameHelp" name="iName">
                  <div id="nameHelp" class="form-text">Enter the organization's name.</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
