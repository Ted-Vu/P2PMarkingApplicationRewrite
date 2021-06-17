<?php

$servername = "localhost";
$username = "root";
$password = "4658GB!rQb7yr_33";
$dbname = "p2pmarking";
$conn = new mysqli($servername, $username, $password, $dbname);

$idErr = '';
$nameRegex= "/^[A-Za-z .\-']{1,50}$/";
$nameErr='';
$emailErr = '';
$modal = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['pwd'])||empty($_POST['firstname'])||empty($_POST['lastname'])) {
        if (empty($_POST['pwd'])) {
            $pwdErr = '<small class="form-text text-danger">Password cannot be empty.</small>';
        }
        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            $nameErr = '<small class="form-text text-danger">Name cannot be empty.</small>';
        }
    } else {
        $FName=$_POST['firstname'];
        $LName = $_POST['lastname'];
        $email = $_POST['email'];
        if (preg_match($nameRegex,$FName) && preg_match($nameRegex, $LName) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $pwd = $_POST['pwd'];
            $email = $_POST['email'];
            $sql = "INSERT INTO users (email, LastName, FirstName, Password, isAdmin, voted)
            VALUES ('{$email}','{$LName}', '{$FName}', '{$pwd}',0, 0); ";            
            $conn->query($sql);

            $sql = "SELECT AUTO_INCREMENT as UserID
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = 'p2pmarking'
            AND TABLE_NAME = 'users';";
            $result = $conn -> query($sql);
            $row = $result -> fetch_assoc();
            $userID = $row['UserID'];
            if(!empty($_POST['teamname'])){
                $sql = "INSERT INTO team (teamName, , numberOfVotes, totalScore) VALUES('{$_POST['teamname']}', ,0,0)";
            }
            $conn -> close();
            
            $modal = <<<EOT
             <div class="alert alert-success alert-dismissible fade show" role="alert" id="modal">
                <h4 class="alert-heading text-center">Register Successfully</h4>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeModal()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOT;
            unset($_POST);
        }else {
            if(!preg_match($nameRegex,$FName) || !preg_match($nameRegex, $LName)){
                $nameErr='<small class="form-text text-danger">Incorrect name format</small>';
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = '<small class="form-text text-danger">Incorrect email format</small>';
            }
        }
    }
}
?>

<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="Peer-to-Peer marking system thats empower teachers.">
    <title>P2P Marking System</title>
    <link rel="shortcut icon" href="favicon.svg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='script.js'></script>
</head>

<body class="bg-light">
    <?php echo $modal ?>
    <form action="#" class="container-sm py-4 my-5 bg-dark text-white rounded-lg" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="text" class="form-control" placeholder="Enter your email" name="email">
            <?php echo $emailErr ?>
        </div>
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input id="firstname" type="text" class="form-control" placeholder="Enter your First Name" name="firstname">
            <?php echo $nameErr ?>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input id="lastname" type="text" class="form-control" placeholder="Enter your Last Name" name="lastname">
            <?php echo $nameErr ?>
        </div>
        <div class="form-group">
            <label for="pwd">Password</label>
            <input id="pwd" type="password" class="form-control" placeholder="Enter Password" name="pwd">
        </div>
        <div class="form-group">
            <label for="teamname">Team Name</label>
            <input id="teamname" type="teamname" class="form-control" placeholder="Enter Team Name - Leave blank if you register individually" name="teamname">
        </div> 
        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign Up</button>  
    </form>

    
</body>

</html>
