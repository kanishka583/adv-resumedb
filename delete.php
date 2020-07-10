<?php
    session_start();
    require_once "pdo.php";
    if(!isset($_GET['profile_id'])){
        $_SESSION['error']="Please enter valid profile_id";
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
        $_SESSION['error']="Please enter valid profile_id";
        header("Location:index.php");
        return;
    }
    if(isset($_POST['Delete'])){
        $sql="DELETE FROM profile WHERE profile_id=:profile_id";
        $statement=$pdo->prepare($sql);
        $statement->execute(array(
            ":profile_id"=>$_GET['profile_id']
        ));
        $_SESSION['success']="Deletion Success";
        header("Location:index.php");
        return;
    }

?>
<html>

<head>
    <title>Kanishka Sutrave's Delete Page</title>
    <?php require_once "bootstrap.php";?>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1>Deleteing Profile</h1>
            <p>First Name: <?= $row['first_name']?></p>
            <p>Last Name: <?= $row['last_name']?></p>
            <form method="post">
                <input type="submit" value="Delete" name="Delete">
                <input type="button" value="Cancel" onclick="location.href='index.php'">
            </form>            
        </div>
    </div>
</body>

</html>