<?php

session_start();

if (empty($_COOKIE['auth'])) {
    header("Location: ./login.php");
}

$servername = "localhost";
$username = "root";
$password = "4658GB!rQb7yr_33";
$dbname = "p2pmarking";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    foreach ($_POST as $teamID => $score) {
        $sql = "SELECT * FROM team WHERE $teamID = {$teamID}";
        
        $result = $conn -> query($sql);
        $row = $result->fetch_assoc();
        $newScore = $row['totalScore'] + intval($score);
        $sql = "UPDATE team SET totalScore = {$newScore} WHERE $teamID = '{$teamID}'; ";
        $conn -> query($sql);
        
        $newVote = $row['numberOfVotes'] + 1;
        $sql = "UPDATE team SET numberOfVotes = {$newVote} WHERE $teamID = '{$teamID}' ;";
        $conn -> query($sql);
    
    }
    // set voted
    $email = $_COOKIE['auth'];
    $sql = "UPDATE users SET voted = '1' WHERE email = '{$email}'; ";
    $conn -> query($sql);
    unset($_COOKIE['auth']);
    setcookie('auth', null, -1, '/');
    $_SESSION['success'] = true;
    header("Location: ./login.php");
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
    <script src='script.js'></script>
</head>

<body class="bg-light">
    <form action="#" class="container-sm py-4 my-5 bg-dark text-white rounded-lg" method="POST" onsubmit='return markValidation();'>
        <?php

            $sql = "SELECT teamName, teamID, userID FROM team";
            $result = $conn -> query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  if($_COOKIE['userid'] != $row['userID'])  {
                    echo '<div class="form-group row">' . "\n";
                        echo '<label class="col-md-2 col-form-label text-center">' . $row['teamName'] . '</label>' . "\n";
                        echo '<div class="col-md-10">' . "\n";
                            echo '<input name=' . $row['teamID']. ' type="text" class="form-control" placeholder="Score 1-10"/>' . "\n";
                            echo '<div id=' . $row['teamID'] . '>'.'</div>';
                        echo '</div>' . "\n";
                    echo '</div>' . "\n";
                  }
                }
            }
            $conn -> close();
        ?>
        <div class="form-group row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <button type="submit" class="btn btn-success btn-lg btn-block">
                    Submit your Evaluation
                </button>
            </div>
        </div>
    </form>
</body>

</html>