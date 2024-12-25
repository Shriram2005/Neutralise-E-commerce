<?php include('connection.php');?>

<?php
if (isset($_POST['submit'])) {
    // Debugging: Check if form is being submitted
    error_log("Form Submitted!");

    // Rest of the form handling code

$firstName = mysqli_real_escape_string($con, $_POST['first_name']);
$lastName = mysqli_real_escape_string($con, $_POST['last_name']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$applied_before = mysqli_real_escape_string($con, $_POST['applied_before']);
$department = mysqli_real_escape_string($con, $_POST['department']);
$procedure = mysqli_real_escape_string($con, $_POST['procedure1']);
$appointmentDate = mysqli_real_escape_string($con, $_POST['appointment_date']);


    // SQL Query to insert data into the appointments table
$query = "INSERT INTO `appointments`(`first_name`, `last_name`, `dob`, `gender`, `phone`, `email`, `applied_before`, `department`, `procedure1`, `appointment_date`) 
          VALUES ('$firstName', '$lastName', '$dob', '$gender', '$phone', '$email', '$applied_before', '$department', '$procedure', '$appointmentDate')";
// echo $query;


    $data = mysqli_query($con, $query);

if ($data) {
    ?>
    <script type="text/javascript">
        alert("Your appointment has been successfully booked!");
        window.location.href = "index.php"; // Redirect to a confirmation page
    </script>
    <?php
} else {
    // Show SQL error
    echo "Error: " . mysqli_error($con);
}

}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=86400">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals</title>
    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/appointment.css">

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
    <?php include 'header.php';?>

    <div class="appointment-form">
        <h1>Book an Appointment</h1>
        <p>Fill the form below and we will get back soon to you for more updates and plan your appointment.</p>
        <form id="appointmentForm" action="" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Please Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="(000) 000-0000" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="ex: myname@example.com" required>
            </div>
            <div class="form-group">
                <label>Have you ever applied to our facility before?</label>
                <div class="radio-group">
                    <label><input type="radio" name="applied_before" value="yes" required> Yes</label>
                    <label><input type="radio" name="applied_before" value="no" required> No</label>
                </div>
            </div>
            <div class="form-group">
                <label for="department">Which department would you like to get an appointment from?</label>
                <input type="text" id="department" name="department" required>
            </div>
            <div class="form-group">
                <label for="procedure">Which procedure do you want to make an appointment for?</label>
                <select id="procedure" name="procedure1" required>
                    <option value="">Please Select</option>
                    <option value="aromatherapy">Aromatherapy</option>
                    <option value="herbal_consultation">Herbal Consultation</option>
                    <option value="skin_detox_treatment">Skin Detox Treatment</option>
                    <option value="natural_weight_loss_program">Natural Weight Loss Program</option>
                    <option value="stress_management_session">Stress Management Session</option>
                    <option value="organic_facial">Organic Facial</option>
                    <option value="holistic_nutrition_plan">Holistic Nutrition Plan</option>
                    <option value="essential_oil_consultation">Essential Oil Consultation</option>
                    <option value="natural_beauty_treatment">Natural Beauty Treatment</option>
                    <!-- Add more options here -->
                </select>
            </div>
            <div class="form-group">
                <label for="appointmentDate">Preferred Appointment Date</label>
                <input type="date" id="appointmentDate" name="appointment_date" required>
            </div>
            <div class="form-group">
                <button type="submit" id="submit-btn" name="submit">Submit</button>
            </div>
        </form>
        <div id="formErrors" class="error-messages"></div>
    </div>

    <!-- Footer --------------------------------------->


    <?php include('footer.php');?>

    <script src="./js/script.js" defer></script>
    <script src="./js/appointmentValidation.js" defer></script>
</body>

</html>