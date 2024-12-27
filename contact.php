<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/contact.css">
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'header.php';?>

    <main class="contact-section">
        <div class="contact-header">
            <h1>Get in Touch</h1>
            <p>We're here to help and answer any question you might have. Let's start a conversation!</p>
        </div>

        <div class="contact-content">
            <div class="contact-info">
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email Us</h3>
                    <p><a href="mailto:auracoolcollection@gmail.com">auracoolcollection@gmail.com</a></p>
                </div>
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Call Us</h3>
                    <p>(+91) 9000088227</p>
                    <p class="small">Mon-Fri: 10AM-7PM IST</p>
                    <p class="small">Sat-Sun: 10AM-5PM IST</p>
                </div>
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp</h3>
                    <p>+91 9014447966</p>
                </div>
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Visit Us</h3>
                    <p>Neutralise Naturals, Hyderabad, India</p>
                </div>
            </div>

<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // SQL query to insert data
    $sql = "INSERT INTO contact_form (name, email, phone, subject, message) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";
    $res = mysqli_query($con, $sql);

   if($res){
       ?>

  <script type="text/javascript">
    // alert("Message submitted successfully!")
  window.location.href = "contact.php";

  </script>
 
  <?php
}

else
{

  ?>
  <script type="text/javascript">
    // alert("Please try again")
  </script>
  <?php
}
}

?>


            <div class="contact-form-wrapper">
                <h2>Send us a message</h2>
                <form id="contactForm" class="contact-form" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="name" name="name" required placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required placeholder="Your Email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" required placeholder="Your Phone">
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" required placeholder="Subject">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" rows="5" required placeholder="Your Message"></textarea>
                    </div>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </main>

   <?php include('footer.php');?>

    <script src="./js/script.js" defer></script>
</body>

</html>