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
    $fname=$row['first_name'];
    $lname=$row['last_name'];
    $email=$row['email'];
    $headline=$row['headline'];
    $summary=$row['summary'];
    if(isset($_POST['Save'])){
        if(empty($_POST['first_name'])|| empty($_POST['last_name'])||empty($_POST['email'])||empty($_POST['headline'])||empty($_POST['summary'])){
            $_SESSION['error']="All fields are required";
            header("Location:edit.php".$_SERVER['REQUEST_URI']);
            return;
        }
        if(strpos($_POST['email'],"@")===false){
            $_SESSION['error']="Email address must contain @";
            header("Location:edit.php".$_SERVER['REQUEST_URI']);
            return;
        }
        $sql="UPDATE profile SET first_name=:first_name,last_name=:last_name,email=:email,headline=:headline,summary=:summary WHERE profile_id=:profile_id";
        $statement=$pdo->prepare($sql);
        $statement->execute(array(
            ":first_name"=>$_POST['first_name'],
            ":last_name"=>$_POST['last_name'],
            ":email"=>$_POST['email'],
            ":headline"=>$_POST['headline'],
            ":summary"=>$_POST['summary'],
            ":profile_id"=>$_GET['profile_id']
        ));
        $_SESSION['success']="Updation Success";
        header("Location:index.php");
        return;
    }
    
?>
<html>

<head>
    <title>Kanishka Sutrave's Edit page</title>
    <?php require_once "bootstrap.php";?>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
        <h1>Editing Profile for <?= $_SESSION['name']?></h1>
            <?php
                if(isset($_SESSION['error'])){
                    echo "<p><span style='color:red'>".$_SESSION['error']."</span></p>";
                    unset($_SESSION['error']);
                }
            ?>
            <form method="post">
                First Name: <input type="text" name="first_name" id="first_name" size="60" value="<?= $fname ?>"><br>
                Last Name: <input type="text" name="last_name" id="last_name" size="60" value="<?= $lname ?>"><br>
                Email: <input type="text" name="email" id="email" size="30" value="<?= $email ?>"><br>
                Headline:<br>
                <input type="text" name="headline" id="headline" size="80" value="<?= $headline ?>"><br>
                Summary:<br>
                <textarea name="summary" id="summary" cols="80" rows="8"><?= $summary ?></textarea><br>
                <input type="submit" value="Save" name="Save">
                <input type="submit" value="Cancel" name="Cancel" onclick="location.replace('index.php');return false">
            </form>
        </div>
    </div>
</body>

</html>