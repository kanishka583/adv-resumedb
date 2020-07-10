<?php
    require_once "pdo.php";
    session_start();

    $salt="XyZzy12*_";

    if(isset($_POST['login'])){
        if(empty($_POST['email'])||empty($_POST['pass'])){
            $_SESSION['error']="Both fields must be filled out";
            header("Location:login.php");
            return;
        }

        $check=hash('md5',$salt.$_POST['pass']);
        $sql="SELECT * FROM users WHERE email=:email AND password=:password";
        $statement=$pdo->prepare($sql);
        $statement->execute(array(
            ":email"=>$_POST['email'],
            ":password"=>$check
        ));
        $row=$statement->fetch(PDO::FETCH_ASSOC);
        if($row===false){
            $_SESSION['error']="Incorrect Email or Password";
            header("Location:login.php");
            return;
        }else{
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['name']=$row['name'];
            header("Location:index.php");
            return;
        }
    }
?>
<html>

<head>
    <title>Kanishka Sutrave's Login Page</title>
    <?php require_once "bootstrap.php";?>
    <script>
    function doValidate() {
        console.log('Validating...');
        try {
            pw = document.getElementById('id_1723').value;
            em = document.getElementById('email').value;
            console.log("Validating em=" + em);
            console.log("Validating pw=" + pw);
            if (pw == null || pw == "" || em == null || em == "") {
                alert("Both fields must be filled out");
                return false;
            }
            return true;
        } catch (e) {
            return false;
        }
        return false;
    }
    </script>
</head>

<body>
    <div class="container" style="margin-top:4%">
        <div class="jumbotron">
            <h1>Please Log In</h1>
            <?php
            if(isset($_SESSION['error'])){
                echo "<p><span style='color:red'>".$_SESSION['error']."</span></p>";
                unset($_SESSION['error']);
            }
        ?>
            <form method="post" class="form">
                <div class="form-group"> Email <input type="text" name="email" class="form-control" id="email"></div>
                <div class="form-group">Password <input type="text" name="pass" class="form-control" id="id_1723"></div>


                <input type="submit" class="btn btn-primary" onclick="return doValidate();" name="login" value="Log In">
                <input type="button" class="btn btn-default" value="Cancel" onclick="location.replace('index.php');return false;">
            </form>
        </div>
    </div>
</body>

</html>