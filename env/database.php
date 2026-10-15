
<?php 

try{
$connect = mysqli_connect("localhost" , "root", "", "shop");
}catch (Exception $e){
    echo $e->getMessage();
}

?>