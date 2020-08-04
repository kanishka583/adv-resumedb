<?php
?>
<html>

<head>
<?php
    require_once "bootstrap.php";
?></head>
<body>
    <div class="container">
        <div class="jumbotron">
            <table>
                <tbody id="mytable"></tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script type="text/javascript">
            function htmlentities(str){
                return $('<div/>').text(str).html();
            }
            $.getJSON('chatlist.php',function(data){
            $('#mytable').empty();
            console.log(data);
            found=false;
            for(var i=0;i<data.length;i++){
                entry=data[i];
                found=true;
                $('#mytable').append("<tr><td>"+htmlentites(entry.profile_id)+"</td><td>"+htmlentities(entry.first_name)+"</td><td>"+htmlentities(entry.last_name)+"</td><td></tr>");
            }
            if(found==false){
                $('#mytable').append("No rows found");
            }
        });
        
        
    </script>
</body>
</html>