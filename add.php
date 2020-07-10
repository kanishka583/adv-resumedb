<?php
    session_start();
    require_once "pdo.php";
    if(!isset($_SESSION['user_id'])){
        $_SESSION['error']="Please Log In to add Profiles";
        header("Location:index.php");
        return;
    }
    if(isset($_POST['Add'])){
        if(empty($_POST['first_name'])|| empty($_POST['last_name'])||empty($_POST['email'])||empty($_POST['headline'])||empty($_POST['summary'])){
            $_SESSION['error']="All fields are required";
            header("Location:add.php");
            return;
        }
        if(strpos($_POST['email'],"@")===false){
            $_SESSION['error']="Email address must contain @";
            header("Location:add.php");
            return;
        }
        $url=parse_url($_POST['url']);
        if(isset($url)){
            if(!empty($url) && @getimagesize($url)){
                $_SESSION['error']="Please enter valid Profile Image URL";
                header("Location:add.php");
                return;
            }
        }

        $sql="INSERT INTO profile (user_id,first_name,last_name,email,headline,summary,url) VALUES (:user_id,:first_name,:last_name,:email,:headline,:summary,:url);";
        $statement=$pdo->prepare($sql);
        $statement->execute(array(
            ":user_id"=>$_SESSION['user_id'],
            ":first_name"=>$_POST['first_name'],
            ":last_name"=>$_POST['last_name'],
            ":email"=>$_POST['email'],
            ":headline"=>$_POST['headline'],
            ":summary"=>$_POST['summary'],
            ":url"=>$_POST['url']
        ));
        $_SESSION['success']="Record added";
        header("Location:index.php");
        return;
    }
?>
<html>

<head>
    <title>Kanishka Sutrave's Add page</title>
    <?php require_once "bootstrap.php";?>
</head>

<body>
    <div class="container" style="margin-top:4%">
        <div class="jumbotron">
            <h1>Adding Profile for <?= $_SESSION['name']?></h1>
            <?php
                if(isset($_SESSION['error'])){
                    echo "<p><span style='color:red'>".$_SESSION['error']."</span></p>";
                    unset($_SESSION['error']);
                }
            ?>
            <form method="post">
            <div class="form-group">
            First Name: <input type="text" name="first_name" class="form-control" id="first_name" size="60">
            </div>
            <div class="form-group">
            Last Name: <input type="text" name="last_name" class="form-control" id="last_name" size="60">
            </div>
            <div class="form-group">
            Email: <input type="text" name="email" id="email" class="form-control" size="30">
            </div>
            <div class="form-group">
            Headline: <input type="text" name="headline" id="headline" class="form-control" size="80">
            </div>
            <div class="form-group">
            Summary:<br> <textarea name="summary" id="summary" cols="80" class="form-control" rows="8"></textarea>
            </div>
            <div class="form-group">
            Profile Image URL: <input type="url" name="url" class="form-control" id="url">
            </div>
                <input type="submit" value="Add" name="Add">
                <input type="submit" value="Cancel" name="Cancel" onclick="location.href='index.php';return false">
            </form>
        </div>
    </div>

</body>

</html>