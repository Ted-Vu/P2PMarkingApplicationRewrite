<?php
if (empty($_COOKIE['auth'])) {
    header("Location: ./login.php");
}

$servername = "localhost";
$username = "root";
$password = "4658GB!rQb7yr_33";
$dbname = "p2pmarking";
$conn = new mysqli($servername, $username, $password, $dbname);

$email = $_COOKIE['auth'];


$sql = "SELECT LastName, FirstName, isAdmin, voted from users WHERE email = '{$email}';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$name = $row['FirstName'] .' '. $row['LastName'];
$isAdmin = $row['isAdmin'];
$voted = $row['voted'];

if ($isAdmin == true) {
    header("Location: ./networkadmin.php");
}

if ($voted == false) {
    $noti = "<hr class='my-4'><p class='font-weight-bold'>Please vote now</p>";
    $disabled = "";
} else {
    $noti = "<hr class='my-4'><p class='font-weight-bold'>Your vote has been recorded. Please come back later.</p>";
    $disabled = "disabled";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'])) {
        header("Location: ./name.php");
    } else if (isset($_POST['pwd'])) {
        header("Location: ./password.php");
    } else if (isset($_POST['back'])) {
        unset($_COOKIE['auth']);
        setcookie('auth', null, -1, '/');
        header("Location: ./login.php");
    } else if (isset($_POST['mark'])) {
        header("Location: ./marking.php");
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
    <link rel="shortcut icon" href="/favicon.svg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container-sm py-4 my-5 bg-dark text-white rounded-lg">
        <div class="jumbotron text-dark">
            <h1 class="display-4">Welcome back <?php echo $name ?> !</h1>
            <?php echo $noti ?>
        </div>
        <form action="#" method="POST">
            <input type="submit" name="mark" class="btn btn-info btn-lg btn-block" value="Marking" <?php echo $disabled ?>>
            <input type="submit" name="name" class="btn btn-warning btn-lg btn-block" value="Change Name">
            <input type="submit" name="pwd" class="btn btn-warning btn-lg btn-block" value="Change Password">
            <input type="submit" name="back" class="btn btn-danger btn-lg btn-block" value="Log out">
        </form>
    </div>
</body>

</html>