<?php include('connection.php');

if(isset($_POST['update'])){

    $id = $_GET['id'];
   
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $folder = "contents/products/" . $file;

    }
     $title = mysqli_real_escape_string($con, $_POST['title']);
      $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
      $content = mysqli_real_escape_string($con, $_POST['content']);

      $post_date = mysqli_real_escape_string($con, $_POST['post_date']);
      $author = mysqli_real_escape_string($con, $_POST['author']);
      // $image = mysqli_real_escape_string($con, $_POST['image']);
      $category = mysqli_real_escape_string($con, $_POST['category']);

      $excerpt = mysqli_real_escape_string($con, $_POST['excerpt']);
      $tags = mysqli_real_escape_string($con, $_POST['tags']);





  
   


    if (!empty($_FILES['image']['name'])) {
        $sql1 = "UPDATE `blogs` SET `title`='$title', `subtitle`='$subtitle', `content`='$content', `post_date`='$post_date', `author`='$author', `image`='$image', `category`='$category', `excerpt`='$excerpt', `tags`='$tags' WHERE `id` = '$id'";
    } else {
        $sql1 = "UPDATE `blogs` SET `title`='$title', `subtitle`='$subtitle', `content`='$content', `post_date`='$post_date', `author`='$author', `category`='$category', `excerpt`='$excerpt', `tags`='$tags' WHERE `id` = '$id'";
    }
   
        // $sql1 = "UPDATE `faculty_page` SET `Photo`='$folder_with_img',`Name`='$name',`Qualification`='$quali',`Expertised`='$expertised' WHERE `Id` = '$id'";
       
        $res1 = mysqli_query($con,$sql1);

         // move_uploaded_file($temp, $folder_with_img);

        if($res1){

            if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($temp, $folder);
                 }

             ?>

          <script type="text/javascript">
            alert("Data Updated Successfully");
            window.location.href = "view_blog.php";

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

$sql = "SELECT * FROM `blogs` WHERE `id` = '$id'";

$res = mysqli_query($con, $sql);


$row = mysqli_fetch_array($res);

?>

                      
<form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
 

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Title:                  </h5>
       <div class="form-group">        
            <input type="text" name="title" value="<?php echo $row['title'];?>">
                        <!-- </fieldset> -->
                      </div>
                    </div>


<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Sub Title:                  </h5>
       <div class="form-group">        
            <input type="text" name="subtitle" value="<?php echo $row['subtitle'];?>">
                        <!-- </fieldset> -->
                      </div>
                    </div>

       </div>         

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Content:                  </h5>
   <div class="form-group">
          
         <textarea name="content" rows="2"><?php echo $row['content']; ?></textarea>
          
    </div>
<!-- </fieldset> -->
                   
</div>

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Post_Date:                  </h5>
   <div class="form-group">
          
         <input type="date" name="post_date" value="<?php echo $row['post_date'];?>">
          
    </div>
<!-- </fieldset> -->
                   
</div>



<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

    <div class="row">
        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Author:</h5>
            <div class="form-group">
                <input type="text" name="author" value="<?php echo $row['author']; ?>">
            </div>
        </div>

        <div class="col-xl-6 col-lg-12">

  <h5>Photo                   </h5>
   <div class="form-group">
  
        <input type="file" name="image">
       
        <a href="<?php echo $row['image']; ?>"><?php echo $row['image'];?></a>
        <!-- <img src="images/<?php echo $row['Photo']; ?>"  width="100%"><br><br> -->
    </div>
<!-- </fieldset> -->
                   
</div>

        
    </div>


    <div class="row">
        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Category:</h5>
            <div class="form-group">
                <input type="text" name="category" value="<?php echo $row['category']; ?>">
            </div>
        </div>

        <div class="col-xl-6 col-lg-12">
            <h5>Excerpt:</h5>
            <div class="form-group">
                <input type="text" name="excerpt" value="<?php echo $row['excerpt']; ?>">
            </div>
        </div>

        
    </div>


    <div class="row">
        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Tags:</h5>
            <div class="form-group">
                <input type="text" name="tags" value="<?php echo $row['tags']; ?>">
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










