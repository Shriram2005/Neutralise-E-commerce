<?php include 'connection.php'; ?>
<?php include 'connection.php'; ?>

<?php
if(isset($_POST['Submit'])) {
    $file = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];
    $folder = "contents/products/" . $file;

    // Get all form data
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

    // SQL query to insert data
    $sql = "INSERT INTO products (image, name, category, price, tags, sku, rating, reviews_count, description, full_description, size_options, ingredients, usage_instructions)
            VALUES ('$file', '$name', '$category', '$price', '$tags', '$sku', '$rating', '$reviews_count', '$description', '$full_description', '$size_options', '$ingredients', '$usage_instructions')";

    // Execute the query
    $res = mysqli_query($con, $sql);

    // Move uploaded file to the folder
    move_uploaded_file($temp, $folder);

    if ($res) {
        ?>
        <script type="text/javascript">
            alert("New product added successfully!");
            window.location.href = "view_products.php";
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Please try again");
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
                <li><a href="#">Add Product</a></li>
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

       
        <input type="file" name="image" ><br><br>
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
   <h5>Product Name:                  </h5>
       <div class="form-group">        
            <input type="text" name="name">
                        <!-- </fieldset> -->
                      </div>
                    </div>

       </div>         

<div class="row">

<div class="col-xl-6 col-lg-12">
 <!-- <fieldset> -->
  <h5>Category:                  </h5>
   <div class="form-group">
          
         <input type="text" name="category" >
          
    </div>
<!-- </fieldset> -->
                   
</div>


<div class="col-xl-6 col-lg-12">

    <h5>Price:                  </h5>
        <div class="form-group">
             <input type="text" name="price">
  
                      </div>


                    </div>
<!-- <button class="btn btn-info "> <input type="submit" name="update"></button> -->
  
</div>

    <div class="row">

        <!-- Tags -->
        <div class="col-xl-6 col-lg-12">
            <h5>Tags:</h5>
            <div class="form-group">
                <input type="text" name="tags">
            </div>
        </div>

        <!-- SKU -->
        <div class="col-xl-6 col-lg-12">
            <h5>SKU:</h5>
            <div class="form-group">
                <input type="text" name="sku">
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Rating -->
        <div class="col-xl-6 col-lg-12">
            <h5>Rating:</h5>
            <div class="form-group">
                <input type="number" name="rating" min="1" max="5" step="0.1">
            </div>
        </div>

        <!-- Reviews Count -->
        <div class="col-xl-6 col-lg-12">
            <h5>Reviews Count:</h5>
            <div class="form-group">
                <input type="number" name="reviews_count" min="0">
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Description -->
        <div class="col-xl-6 col-lg-12">
            <h5>Description:</h5>
            <div class="form-group">
                <textarea name="description"></textarea>
            </div>
        </div>

        <!-- Full Description -->
        <div class="col-xl-6 col-lg-12">
            <h5>Full Description:</h5>
            <div class="form-group">
                <textarea name="full_description"></textarea>
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Size Options -->
        <div class="col-xl-6 col-lg-12">
            <h5>Size Options:</h5>
            <div class="form-group">
                <input type="text" name="size_options">
            </div>
        </div>

        <!-- Ingredients -->
        <div class="col-xl-6 col-lg-12">
            <h5>Ingredients:</h5>
            <div class="form-group">
                <textarea name="ingredients"></textarea>
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Usage Instructions -->
        <div class="col-xl-6 col-lg-12">
            <h5>Usage Instructions:</h5>
            <div class="form-group">
                <textarea name="usage_instructions"></textarea>
            </div>
        </div>

    </div>

        <!-- Submit Button -->
        <div class="row" style="margin-top: 2%">
            <div class="col-xl-6 col-lg-12">
                <button type="submit" name="Submit" class="btn btn-info btn-min-width mr-1 mb-1">Submit</button>
            </div>

            <div class="col-xl-6 col-lg-12">
                <a href="view_products.php" class="btn btn-info btn-min-width mr-1 mb-1">View Products</a>
            </div>
        </div>
    <!-- </div> -->

<!-- <div class="row" style="margin-top: 2%">
<div class="col-xl-6 col-lg-12">
<button type="submit" name="Submit" class="btn btn-info btn-min-width mr-1 mb-1">Submit</button>
</div>

<div class="col-xl-6 col-lg-12">
    <a href="view_products.php" class="btn btn-info btn-min-width mr-1 mb-1">View Products</a>
</div>

</div> -->
</form>


        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
</body>
</html>
