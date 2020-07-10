<?php
    session_start();
    require_once "pdo.php";
    if(!isset($_SESSION['rcount'])){
        $_SESSION['rcount']=2;
    }
    if(isset($_GET['show'])){
        $_SESSION['rcount']=$_GET['show'];
    }
    
?>
<html>

<head>
    <title>Kanishka Sutrave's ResumeDB</title>
    <?php require_once "bootstrap.php";?>
</head>

<body>
    <div class="container" style="margin-top:4%">
        
    
        <?php
            if(isset($_SESSION['user_id'])){
                echo "<h1>Hello ".$_SESSION['name']."</h1>";
                echo '<a href="logout.php">Logout</a>';
            }else{
                echo "<h1>Hello Viewer</h1>";
                echo '<a href="login.php">Please log in</a>';
            }
            if(isset($_SESSION['error'])){
                echo "<p><span style='color:red'>".$_SESSION['error']."</span></p>";
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
                echo "<p><span style='color:green'>".$_SESSION['success']."</span></p>";
                unset($_SESSION['success']);
            }
            echo '<form method="get"><label for="query">Search Resume</label><input type="text" name="query" id="query"> <input type="submit" name="search" value="Search"> <input type="submit" name="clear" value="Clear filter"></form>';
            if(isset($_GET['query']) && !empty($_GET['query'])){
                $searchQuery=$_GET['query'];
                $sql="SELECT * FROM profile WHERE first_name LIKE '%$searchQuery%' OR last_name LIKE '%$searchQuery%' ";
                $totalrowcount=$pdo->query("SELECT count(*) FROM profile WHERE first_name LIKE '%$searchQuery%' OR last_name LIKE '%$searchQuery%'")->fetchColumn();
            }else{
                $sql="SELECT * FROM profile";
                $totalrowcount=$pdo->query("SELECT count(*) FROM profile")->fetchColumn();
            }
            $statement=$pdo->prepare($sql);
            $statement->execute();
            echo "<table border='1' class='table'><thead class='thead-dark'><tr><th>Name</th><th>Headline</th>";
            if(isset($_SESSION['user_id'])){
                echo "<th>Action</th>";
            }
            echo "<th>Display Picture</th></tr></thead>";
            $rcount=1;
            while($row=$statement->fetch(PDO::FETCH_ASSOC)){
                echo "<tr><td>";
                echo '<a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'</a>';
                echo "</td><td>";
                echo htmlentities($row['headline']);
                echo "</td>";
                if(isset($_SESSION['user_id'])){
                    if($row['user_id']===$_SESSION['user_id']){
                        echo "<td>".'<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a>';
                        echo ' | <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a></td>';
                    }else{
                        echo "<td></td>";
                    }
                }
                if(@getimagesize($row['url'])){
                    echo '<td><img  height="200" src="'.$row['url'].'" alt="'.htmlentities($row['first_name']).'\'s Profile Image"></td>';
                }else{
                    echo "<td></td>";
                }
                echo "</tr>";
                if($rcount>=$_SESSION['rcount']){
                    break;
                }
                $rcount++;
            }
            echo "</table>";
            if($totalrowcount>$rcount){
                echo "<a href='index.php?show=".($rcount+10)."'>Show More</a> | ";
            }
            echo "<a href='index.php?show=".($rcount-2  )."'>Show Less</a> | ";
            if(isset($_SESSION['user_id'])){
                echo '<a href="add.php">Add New Entry</a>';
            }
            print($rcount);
            print_r($_SESSION);
        ?>
        
    </div>
    
</body>

</html>