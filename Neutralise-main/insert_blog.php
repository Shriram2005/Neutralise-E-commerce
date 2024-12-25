<?php include 'connection.php'; ?>
<?php
if(isset($_POST['Submit'])) {
    $file = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];
    $folder = "contents/products/" . $file;
    
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $post_date = $_POST['post_date'];
    $author = $_POST['author'];
    // $image = $_POST['image'];
    $category = $_POST['category'];
    $excerpt = $_POST['excerpt'];
    $tags = $_POST['tags'];



     
    
    

    

      $sql ="INSERT INTO `blogs`( `title`, `subtitle`, `content`, `post_date`, `author`, `image`, `category`, `excerpt`, `tags`) VALUES ('$title','$subtitle','$content','$post_date','$author','$file','$category','$excerpt','$tags')";

    $res = mysqli_query($con, $sql);
    move_uploaded_file($temp, $folder);

    if($res){
       ?>

  <script type="text/javascript">
    alert("New blogs added successfully!")
  window.location.href = "view_blog.php";

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
                <!-- Title -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Blog Title: </h5>
                    <div class="form-group">        
                        <input type="text" name="title">
                        <!-- </fieldset> -->
                    </div>
                </div>

                <!-- Subtitle -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Blog SubTitle: </h5>
                    <div class="form-group">        
                        <input type="text" name="subtitle">
                        <!-- </fieldset> -->
                    </div>
                </div>
               
            </div>

            <div class="row">
                <!-- Content -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Content: </h5>
                    <div class="form-group">        
                        <textarea name="content"></textarea>
                        <!-- </fieldset> -->
                    </div>
                </div>
                
            
                <!-- Post Date -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Post Date: </h5>
                    <div class="form-group">        
                        <input type="date" name="post_date">
                        <!-- </fieldset> -->
                    </div>
                </div>
               
            </div>
            <div class="row">
                <!-- Author -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Author: </h5>
                    <div class="form-group">        
                        <input type="text" name="author">
                        <!-- </fieldset> -->
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-12">
                    <h5>Image: </h5>
                    <div class="form-group">        
                        <input type="file" name="image">
                        <!-- </fieldset> -->
                    </div>
                </div>
               
            </div>
            <div class="row">                
                <!-- Category -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Category: </h5>
                    <div class="form-group">        
                        <input type="text" name="category">
                        <!-- </fieldset> -->
                    </div>
                </div>
                
                <!-- Excerpt -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Excerpt: </h5>
                    <div class="form-group">        
                        <textarea name="excerpt"></textarea>
                        <!-- </fieldset> -->
                    </div>
                </div>
                
            </div>
            <div class="row">                
                <!-- Tags -->
                <div class="col-xl-6 col-lg-12">
                    <h5>Tags: </h5>
                    <div class="form-group">        
                        <input type="text" name="tags">
                        <!-- </fieldset> -->
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 2%">
                <div class="col-xl-6 col-lg-12">
                    <button type="submit" name="Submit" class="btn btn-info btn-min-width mr-1 mb-1">Submit</button>
                </div>

                <div class="col-xl-6 col-lg-12">
                    <a href="view_blog.php" class="btn btn-info btn-min-width mr-1 mb-1">View Blogs</a>
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
