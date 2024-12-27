<?php include('connection.php');

if(isset($_POST['update'])){

    $id = $_GET['id'];
   
    if (!empty($_FILES['imgSrc']['name'])) {
         $file = $_FILES['imgSrc']['name'];
        $temp = $_FILES['imgSrc']['tmp_name'];

        $folder="contents/products/" .$file;

    }
     $name = mysqli_real_escape_string($con, $_POST['name']);
      $date = mysqli_real_escape_string($con, $_POST['date']);
      $message = mysqli_real_escape_string($con, $_POST['message']);

      $rating = mysqli_real_escape_string($con, $_POST['rating']);



  
   


    if (!empty($_FILES['imgSrc']['name'])) {
        $sql1 = "UPDATE `testimonials` SET `imgSrc`='$folder', `name`='$name', `date`='$date', `message`='$message', `rating`='$rating' WHERE `id` = '$id'";
    } else {
        $sql1 = "UPDATE `testimonials` SET `name`='$name', `date`='$date', `message`='$message', `rating`='$rating' WHERE `id` = '$id'";
    }
   
        // $sql1 = "UPDATE `faculty_page` SET `Photo`='$folder_with_img',`Name`='$name',`Qualification`='$quali',`Expertised`='$expertised' WHERE `Id` = '$id'";
       
        $res1 = mysqli_query($con,$sql1);

         // move_uploaded_file($temp, $folder_with_img);

        if($res1){

            if (!empty($_FILES['imgSrc']['name'])) {
            move_uploaded_file($temp, $folder);
                 }

             ?>

          <script type="text/javascript">
            alert("Data Updated Successfully");
            window.location.href = "view_testimonials.php";

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
    }
?>
 






<style type="text/css">
  .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .form-group input {
      width: 100%;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }
    .form-group textarea {
      width: 100%;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }
    
    .form-group input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }
</style>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style1.css">
    <link rel="icon" href="photos/logo.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://kit.fontawesome.com/be5622a212.js" crossorigin="anonymous"></script>
  <!-- <link rel="stylesheet" href="style.css"> -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- <script src="script.js"></script> -->
    <title>AdminSite</title>
</head>
<body>

    <!-- SIDEBAR -->
    
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <?php include ('leftbar.php');?>
    <!-- <section id="content"> -->
        <!-- NAVBAR -->
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Dashboard</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Manage Product</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Dashboard</a></li>
            </ul>
           <!--  <div class="info-data">
                <div class="card">
                    <div class="head"> -->


                        <?php 
                        $id = $_GET['id'];

$sql = "SELECT * FROM `testimonials` WHERE `id` = '$id'";

$res = mysqli_query($con, $sql);


$row = mysqli_fetch_array($res);

?>

                      
<form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
 

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Photo                   </h5>
   <div class="form-group">
  
        <input type="file" name="imgSrc">
       
        <a href="<?php echo $row['imgSrc']; ?>"><?php echo $row['imgSrc'];?></a>
        <!-- <img src="images/<?php echo $row['Photo']; ?>"  width="100%"><br><br> -->
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Candidate Name:                  </h5>
       <div class="form-group">        
            <input type="text" name="name" value="<?php echo $row['name'];?>">
                        <!-- </fieldset> -->
                      </div>
                    </div>

       </div>         

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Date:                  </h5>
   <div class="form-group">
          
         <input type="date" name="date" value="<?php echo $row['date'];?>">
          
    </div>
<!-- </fieldset> -->
                   
</div>

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Message:                  </h5>
   <div class="form-group">
          
         <input type="text" name="message" value="<?php echo $row['message'];?>">
          
    </div>
<!-- </fieldset> -->
                   
</div>



<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

    <div class="row">
        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Rating:</h5>
            <div class="form-group">
                <input type="number" step="0.1" name="rating" value="<?php echo $row['rating']; ?>">
            </div>
        </div>

        
    </div>

    



<div class="row" style="margin-top: 2%">
<div class="col-xl-6 col-lg-12">
<button type="submit" name="update" class="btn btn-info btn-min-width mr-1 mb-1">Update</button>
</div>
</div>
</form>


        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script1.js"></script>
</body>
</html>










