<?php
include('connection.php');
$id = $_GET['id'];
// echo $id;
$sql = "DELETE FROM `products` WHERE `id` = '$id'";
$res = mysqli_query($con, $sql);
if($res){
     ?>

  <script type="text/javascript">
    alert("Data Deleted Successfully");
    window.location.href = "view_products.php";

  </script>
 
  <?php
}
else{
    ?>
      <script type="text/javascript">
    alert("try again");

  </script>
  <?php
}
?>
<!-- if($res)
{
    echo "deleted";
    // header('location:r1.php');
}
else {
    echo "fail";
} -->

