<?php
    sleep(2);
    header("Content-Type:application/json;charset-utf8");
    $me=array('name'=>"Kanishka Sutrave",'email'=>"kanishkasutrave@gmail.com");
    echo json_encode($me);