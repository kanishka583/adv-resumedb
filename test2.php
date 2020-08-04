<?php
    session_start();
    if(isset($_POST['Reset'])){
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <div class="container">
        <div class="jumbotron" id="mychat">
            <h1>Chat</h1>
            <form method="post">
                <p>
                    <input type="text" name="message" id="">
                    <input type="submit" value="Chat" />
                    <input type="submit" name="Reset" value="Reset">
                </p>
            </form>
            <div id="chatcontent">
                <img id="myimage" src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif" alt="Loading..">
            </div>

        </div>
    </div>
    <script type="text/javascript">
    function updateMessage(){
        $.ajax({
            url:"chatlist.php",
            cache:false,
            success:function(data){
                $('#chatcontent').empty();
                for(var i=0;i<data.length;i++){
                    entry=data[i];
                    $('#chatcontent').append("<p>"+entry[0]+"<br/>&nbsp;&nbsp;"+entry[1]+"</p>\n");
                }
                setTimeout('updateMessage()', 4000);
            }
        });
    }
    updateMessage();

    $(document).ready(function() {
        $('#myimage').hide();
        $.getJSON('json.php', function(data) {

        })
    })
    </script>
</body>

</html>