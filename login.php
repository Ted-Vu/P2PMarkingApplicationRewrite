<?php 

session_start();
if (isset($_COOKIE['auth'])) {
    header("Location: ./main.php");
}
$servername = "localhost";
$username = "root";
$password = "4658GB!rQb7yr_33";
$dbname = "p2pmarking";
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $sql = "SELECT Password, isAdmin from users;";

// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//       echo "id: " . $row["isAdmin"]. "<br>";
//     }
//  } else {
//    echo "0 results";
//  }
// $conn->close();
$modal = '';
if (isset($_SESSION['success']) && $_SESSION['success'] == true) {
    $modal = <<<EOT
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="modal">
        <h4 class="alert-heading text-center">Submit Successfully</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeModal()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
EOT;
    unset($_SESSION['success']);
} else if (isset($_SESSION['reset']) && $_SESSION['reset'] == true) {
    $modal = <<<EOT
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="modal">
        <h4 class="alert-heading text-center">Reset Successfully</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeModal()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
EOT;
    unset($_SESSION['reset']);
}


$pwdErr = '';
$emailErr = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id']) || empty($_POST['pwd'])) {
        if (empty($_POST['id'])) {
            $emailErr = '<small class="form-text text-danger">Name cannot be empty.</small>';
        }
        if (empty($_POST['pwd'])) {
            $pwdErr = '<small class="form-text text-danger">Password cannot be empty.</small>';
        }
    } else {

        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        
        $sql = "SELECT email, Password, isAdmin from users;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data in each row
            while($row = $result->fetch_assoc()) {
                if($row['email'] == $email && $row['Password'] == $pwd){
                    setcookie('auth', $id, time() + (86400 * 30), "/");
                    if($row['isAdmin'] == 1){
                        echo "Redirect to network admin page";
                        // header("Location: ./networkadmin.php");

                    }else{
                        echo "Redirect to main page";
                        // header("Location: ./main.php");
                    }
                }else if($row['email'] != $email){
                    $emailErr = '<small class="form-text text-danger">You have not registered yet.</small>';
                }else if($row['Password'] != $pwd){
                    $pwdErr = '<small class="form-text text-danger">Password is incorrect.</small>';
                }
            }
        } else {
            $idErr = '<small class="form-text text-danger">User name does not exist</small>';
        }
        $conn->close();
       
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="Peer-to-Peer marking system thats empower teachers.">
    <title>P2P Marking System</title>
    <link rel="shortcut icon" href="favicon.svg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src='script.js'></script>
</head>

<body class="bg-light">
    <?php echo $modal ?>
    <form action="#" class="container-sm py-4 my-5 bg-dark text-white rounded-lg" method="POST">
        <div class="form-group">
            <label for="id">Email</label>
            <input id="email" type="text" class="form-control" placeholder="Enter email" name="email">
            <?php echo $emailErr ?>
        </div>
        <div class="form-group">
            <label for="pwd">Password</label>
            <input id="pwd" type="password" class="form-control" placeholder="Enter Password" name="pwd">
            <?php echo $pwdErr ?>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>  
        <button type="button" onclick='openRegister();' class="btn btn-warning btn-lg btn-block">Sign Up</button>  
    </form>
</body>

</html>
