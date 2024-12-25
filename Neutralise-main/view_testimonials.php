<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/f00c73d838.js" crossorigin="anonymous"></script>
  <!-- SIDEBAR -->
  
  <!-- SIDEBAR -->

  <!-- NAVBAR -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  
  <?php include('leftbar.php');?>
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
      </ul><br>

      <div class="col-xl-6 col-lg-12">
    <!-- <a href="insert_testimonials.php" class="btn btn-info btn-min-width mr-1 mb-1">Back to Add Testimonials</a> -->
</div>

 
    <?php include ('connection.php');
?>
<div class="container-sm " >
  <div class="table-responsive">
<table class="table table-bordered" style="background-color:white;">
  <tr>
    <th style="padding: 20px ">Photo</th>
    <th style="padding: 20px ">Candidate Name</th>
    <th style="padding: 20px ">Date</th>
    <th style="padding: 20px ">Message</th>
    <th style="padding: 20px ">Rating</th>
       
 

    <!-- <th style="padding: 20px 60px;">Phone</th> -->
   
    <th colspan="2"style="padding: 20px ">Actions</th>
  </tr>
  <?php
    $query="SELECT * FROM `testimonials`";
    $data=mysqli_query($con, $query);
    $result=mysqli_num_rows($data);

    if($result){
      while ($row=mysqli_fetch_array($data)) {
        ?>
        <tr style="text-align: center;">
          <td><?php echo $row['imgSrc'];?></td>
          <td><?php echo $row['name'];?></td>
          <td><?php echo $row['date'];?></td>
          <td><?php echo $row['message'];?></td>
          <td><?php echo $row['rating'];?></td>

         
          
          <td><a href="update_testimonials.php?id=<?php echo $row['id'];?>"><i class="fa-solid fa-pen-to-square" style="color: #2b6f78;"></i></a> &nbsp;&nbsp;&nbsp; <a href="delete_testimonials.php?id=<?php echo $row['id'];?>"><i class="fa-solid fa-trash" style="color: #cf2317;"></i> </a>
          </td>
        </tr>

        <?php
      }
    }
    else{
      ?>
      <!-- <tr>
        <td>No record found</td>
      </tr> -->
      <?php
    }

  ?>

</table>
  </div>
  
</div>


    </main>
    <!-- MAIN -->
  </section>
  <!-- NAVBAR -->

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="script1.js"></script>
</body>
</html>




