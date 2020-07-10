<?php
    session_start();
    require_once "pdo.php";


    if(!isset($_GET['profile_id'])){
        $_SESSION['error']="Please select one of the following profiles to view!";
        header("Location:index.php");
        return;
    }
    $sql="SELECT * FROM profile WHERE profile_id=:profile_id";
    $statement=$pdo->prepare($sql);
    $statement->execute(array(
        ":profile_id"=>$_GET['profile_id']
    ));
    $row=$statement->fetch(PDO::FETCH_ASSOC);
    if($row===false){
        $_SESSION['error']="Please select one of the following profiles to view!";
        header("Location:index.php");
        return;
    }
?>
<html>

<head>
    <title>Kanishka Sutrave's Profile View</title>
    <?php require_once "bootstrap.php";?>
</head>

<body>
    <div class="container">
        <h1>Profile Information</h1>
        <?php
            echo "First Name: ".$row['first_name']."<br>";
            echo "Last Name: ".$row['last_name']."<br>";
            echo "Email: ".$row['email']."<br>";
            echo "Headline:<br>".$row['headline']."<br>";
            echo "Summary:<br>".$row['summary']."<br>";
            echo "<a href='index.php'>Done</a>";
        ?>
    </div>
</body>

</html>