<?php include 'connection.php'; ?>
<?php
if(isset($_POST['Submit']))
{
    $file = $_FILES['imgSrc']['name'];
    $temp = $_FILES['imgSrc']['tmp_name'];

    $folder="contents/products/" .$file;
    $name = $_POST['name'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

     
    
    

    

      $sql ="INSERT INTO `testimonials`( `imgSrc`, `name`, `date`, `message`, `rating`) VALUES ('$file','$name','$date','$message','$rating')";

    $res = mysqli_query($con, $sql);
    move_uploaded_file($temp, $folder);

    if($res){
       ?>

  <script type="text/javascript">
    alert("New product added successfully!")
  window.location.href = "view_testimonials.php";

  </script>
 
  <?php
}

else
{

  ?>
  <script type="text/javascript">
    alert("Please try again")
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
                <li><a href="#">Add Testimonials</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Dashboard</a></li>
            </ul>
           <!--  <div class="info-data">
                <div class="card">
                    <div class="head"> -->


                       

                      
<form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
    <!-- <input type="hidden" name="id" > -->
 

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Photo                   </h5>
   <div class="form-group">

       
        <input type="file" name="imgSrc" ><br><br>
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Candidate Name:                  </h5>
       <div class="form-group">        
            <input type="text" name="name">
                        <!-- </fieldset> -->
                      </div>
                    </div>

       </div>         

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Date:                  </h5>
   <div class="form-group">
          
         <input type="date" name="date" >
          
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">

    <h5>Message:                  </h5>
        <div class="form-group">
             <input type="text" name="message">
  
                      </div>


                    </div>
<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Rating:                  </h5>
   <div class="form-group">
          
         <input type="text" name="rating" >
          
    </div>
<!-- </fieldset> -->
                   
</div>


<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

<div class="row" style="margin-top: 2%">
<div class="col-xl-6 col-lg-12">
<button type="submit" name="Submit" class="btn btn-info btn-min-width mr-1 mb-1">Submit</button>
</div>

<div class="col-xl-6 col-lg-12">
    <a href="view_testimonials.php" class="btn btn-info btn-min-width mr-1 mb-1">View Testimonials</a>
</div>

</div>
</form>


        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
</body>
</html>
