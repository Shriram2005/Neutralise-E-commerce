<?php include 'connection.php'; ?>
<?php
if(isset($_POST['submit']))
{
    $file = $_FILES['imgSrc']['name'];
    $temp = $_FILES['imgSrc']['tmp_name'];

    $folder="contents/products/" .$file;
    $name = $_POST['name'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

     
    
    

    

      $sql ="INSERT INTO `testimonials`( `imgSrc`, `name`, `date`, `message`, `rating`) VALUES ('$file', '$name', '$date', '$message', '$rating')";



    $res = mysqli_query($con, $sql);
    move_uploaded_file($temp, $folder);

    if($res){
       ?>

  <script type="text/javascript">
    alert("Testimonial submitted successfully!")
  window.location.href = "index.php";

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


<style type="">
    /* Testimonials Form Styling */
.testimonial-form {
    background-color: var(--white-bg-color);
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    max-width: 700px;
    margin: 2rem auto;
}

.testimonial-form h1 {
    font-size: 1.8rem;
    text-align: center;
    font-family: var(--font-heading);
    color: var(--text-color);
    margin-bottom: 1rem;
}

.testimonial-form p {
    text-align: center;
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 2rem;
}

.testimonial-form .form-group {
    margin-bottom: 1rem;
}

.testimonial-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-color);
}

.testimonial-form input[type="text"],
.testimonial-form input[type="date"],
.testimonial-form select,
.testimonial-form textarea,
.testimonial-form input[type="file"] {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.testimonial-form input:focus,
.testimonial-form textarea:focus,
.testimonial-form select:focus {
    outline: none;
    border-color: var(--hover-color);
    box-shadow: 0 0 5px rgba(171, 190, 71, 0.5);
}

.testimonial-form textarea {
    resize: vertical;
    min-height: 120px;
}

.testimonial-form input[type="file"] {
    padding: 0.5rem;
    font-size: 0.9rem;
    cursor: pointer;
    background-color: #fafafa;
    border-radius: 4px;
}

.testimonial-form .rating-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.testimonial-form .rating-group label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 1rem;
    color: #34495e;
}

.testimonial-form .rating-group select {
    width: auto;
}

.testimonial-form button[type="submit"] {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 0.75rem;
    background-color: var(--green-bg-color);
    color: var(--white-bg-color);
    border: none;
    border-radius: 40px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.testimonial-form button[type="submit"]:hover {
    background-color: var(--hover-color);
}

/* Responsive Styling */
@media (max-width: 768px) {
    .testimonial-form {
        padding: 1.5rem;
    }

    .testimonial-form h1 {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .testimonial-form input,
    .testimonial-form textarea,
    .testimonial-form select {
        font-size: 0.9rem;
        padding: 0.5rem;
    }

    .testimonial-form button[type="submit"] {
        width: 100%;
    }
}



</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=86400">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals</title>
    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <!-- <link rel="stylesheet" href="./css/appointment.css"> -->

    <!-- tailwind css  -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jacques+Francois&display=swap"
        rel="stylesheet">
</head>


<body>
    <!-------- Navbar --------->


<?php include('header.php');?>



<div class="testimonial-form">
    <h1>Submit Your Testimonial</h1>
    <p>Share your experience with us by filling out the form below.</p>
    <form id="testimonialForm" action="" method="POST" enctype="multipart/form-data">

        <!-- Image Upload -->
        <div class="form-group">
            <label for="imgSrc">Upload Image</label>
            <input type="file" id="imgSrc" name="imgSrc" required>
        </div>

        <!-- Name -->
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" placeholder="Your Full Name" required>
        </div>
        
        <!-- Date -->
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>

        <!-- Message -->
        <div class="form-group">
            <label for="message">Your Testimonial</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your feedback here..." required></textarea>
        </div>

        <!-- Rating -->
        <div class="form-group">
            <label for="rating">Your Rating</label>
            <select id="rating" name="rating" required>
                <option value="">Select Rating</option>
                <option value="5">★★★★★ - Excellent</option>
                <option value="4">★★★★ - Very Good</option>
                <option value="3">★★★ - Good</option>
                <option value="2">★★ - Fair</option>
                <option value="1">★ - Poor</option>
            </select>
        </div>

        

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" id="submit-btn" name="submit">Submit Testimonial</button>
        </div>
    </form>
</div>

<?php include('footer.php');?>

    <script src="./js/script.js" defer></script>

</body>
</html>
