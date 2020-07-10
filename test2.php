<?php
    session_start();
    if(isset($_POST['reset'])){
        $_SESSION['chats']=array();
        header("Location:test2.php");
        return;
    }
    if(isset($_POST['message'])){
        if(!isset($_SESSION['chats']))
        {
            $_SESSION['chats']=array();
        }
        $_SESSION['chats'][]=array($_POST['message'],date(DATE_RFC2822));
        header("Location:test2.php");
        return;    
    }
?>
<html>

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <div class="container">
        <div class="jumbotron" id="mychat">
            <img id="myimage" src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif" alt="Loading..">
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#myimage').hide();
            $.getJSON('json.php',function(data){

            })
        })
    </script>
</body>

</html>