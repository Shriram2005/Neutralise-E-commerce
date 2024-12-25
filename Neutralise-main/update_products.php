<?php include('connection.php');

if(isset($_POST['update'])){

    $id = $_GET['id'];
   
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $folder_with_img = "images/" . $file;
    }


    // $name = mysqli_real_escape_string($con, $_POST['Name']); // Escape special characters
    //  $content = mysqli_real_escape_string($con, $_POST['Content']); // Escape special characters
    //   $benefit = mysqli_real_escape_string($con, $_POST['Benefit']); // Escape special characters
    //    $timing = mysqli_real_escape_string($con, $_POST['Timing']); // Escape special characters

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $tags = $_POST['tags'];
    $sku = $_POST['sku'];
    $rating = $_POST['rating'];
    $reviews_count = $_POST['reviews_count'];
    $description = $_POST['description'];
    $full_description = $_POST['full_description'];
    $size_options = $_POST['size_options'];
    $ingredients = $_POST['ingredients'];
    $usage_instructions = $_POST['usage_instructions'];
   


    if (!empty($_FILES['Photo']['name'])) {
        $sql1 = "UPDATE `products` SET `image`='$folder_with_img', `name`='$name', `category`='$category', `price`='$price', `tags`='$tags', `sku`='$sku', `rating`='$rating', `reviews_count`='$reviews_count', `description`='$description', `full_description`='$full_description', `size_options`=NULLIF('$size_options', ''), `ingredients`='$ingredients', `usage_instructions`='$usage_instructions' WHERE `id` = '$id'";
    } else {
        $sql1 = "UPDATE `products` SET `name`='$name', `category`='$category', `price`='$price', `tags`='$tags', `sku`='$sku', `rating`='$rating', `reviews_count`='$reviews_count', `description`='$description', `full_description`='$full_description', `size_options`=NULLIF('$size_options', ''), `ingredients`='$ingredients', `usage_instructions`='$usage_instructions' WHERE `id` = '$id'";
    }
   
        // $sql1 = "UPDATE `faculty_page` SET `Photo`='$folder_with_img',`Name`='$name',`Qualification`='$quali',`Expertised`='$expertised' WHERE `Id` = '$id'";
       
        $res1 = mysqli_query($con,$sql1);

         // move_uploaded_file($temp, $folder_with_img);

        if($res1){

            if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($temp, $folder_with_img);
                 }

             ?>

          <script type="text/javascript">
            alert("Data Updated Successfully");
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

$sql = "SELECT * FROM `products` WHERE `id` = '$id'";

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
  
        <input type="file" name="image">
       
        <a href="<?php echo $row['image']; ?>"><?php echo $row['image'];?></a>
        <!-- <img src="images/<?php echo $row['Photo']; ?>"  width="100%"><br><br> -->
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Product Name:                  </h5>
       <div class="form-group">        
            <input type="text" name="name" value="<?php echo $row['name'];?>">
                        <!-- </fieldset> -->
                      </div>
                    </div>

       </div>         

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Category:                  </h5>
   <div class="form-group">
          
         <input type="text" name="category" value="<?php echo $row['category'];?>">
          
    </div>
<!-- </fieldset> -->
                   
</div>

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Price:                  </h5>
   <div class="form-group">
          
         <input type="text" name="price" value="<?php echo $row['price'];?>">
          
    </div>
<!-- </fieldset> -->
                   
</div>



<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

    <div class="row">
        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Tags:</h5>
            <div class="form-group">
                <input type="text" name="tags" value="<?php echo $row['tags']; ?>">
            </div>
        </div>

        <!-- SKU -->
        <div class="col-xl-6 col-lg-12">
            <h5>SKU:</h5>
            <div class="form-group">
                <input type="text" name="sku" value="<?php echo $row['sku']; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Rating -->
        <div class="col-xl-6 col-lg-12">
            <h5>Rating:</h5>
            <div class="form-group">
                <input type="number" step="0.1" name="rating" value="<?php echo $row['rating']; ?>">
            </div>
        </div>

        <!-- Reviews Count -->
        <div class="col-xl-6 col-lg-12">
            <h5>Reviews Count:</h5>
            <div class="form-group">
                <input type="number" name="reviews_count" value="<?php echo $row['reviews_count']; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Description -->
        <div class="col-xl-12 col-lg-12">
            <h5>Description:</h5>
            <div class="form-group">
                <textarea name="description" rows="3"><?php echo $row['description']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Full Description -->
        <div class="col-xl-12 col-lg-12">
            <h5>Full Description:</h5>
            <div class="form-group">
                <textarea name="full_description" rows="5"><?php echo $row['full_description']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Size Options -->
        <div class="col-xl-6 col-lg-12">
            <h5>Size Options:</h5>
            <div class="form-group">
                <input type="text" name="size_options" value="<?php echo $row['size_options']; ?>">
            </div>
        </div>

        <!-- Ingredients -->
        <div class="col-xl-6 col-lg-12">
            <h5>Ingredients:</h5>
            <div class="form-group">
                <textarea name="ingredients" rows="3"><?php echo $row['ingredients']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Usage Instructions -->
        <div class="col-xl-12 col-lg-12">
            <h5>Usage Instructions:</h5>
            <div class="form-group">
                <textarea name="usage_instructions" rows="4"><?php echo $row['usage_instructions']; ?></textarea>
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










