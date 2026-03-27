<?php

$name = $email = $website = $gender = $phone = "";
$password = $confirmPassword = "";
$nameErr = $emailErr = $websiteErr = $genderErr = $phoneErr = "";
$passwordErr = $confirmPasswordErr = $termsErr = "";
$attempt = 0;


function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $attempt = isset($_POST['attempt']) ? $_POST['attempt'] + 1 : 1;

    
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = clean_input($_POST["name"]);
    }

    
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = clean_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    
    if (!empty($_POST["website"])) {
        $website = clean_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = clean_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    
    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Please confirm your password";
    } else {
        $confirmPassword = $_POST["confirmPassword"];
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

   
    if (empty($_POST["gender"])) {
        $genderErr = "Please select gender";
    } else {
        $gender = clean_input($_POST["gender"]);
    }

    
    if (!isset($_POST["terms"])) {
        $termsErr = "You must agree to the terms";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Form</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>

<h2>PHP Form Validation</h2>
<p>Submission attempt: <?= $attempt ?></p>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    
    <input type="hidden" name="attempt" value="<?= $attempt ?>">

    Name:
    <input type="text" name="name" value="<?= $name ?>">
    <span class="error">* <?= $nameErr ?></span>
    <br><br>

    Email:
    <input type="text" name="email" value="<?= $email ?>">
    <span class="error">* <?= $emailErr ?></span>
    <br><br>

    Website:
    <input type="text" name="website" value="<?= $website ?>">
    <span class="error"><?= $websiteErr ?></span>
    <br><br>

    Phone:
    <input type="text" name="phone" value="<?= $phone ?>">
    <span class="error">* <?= $phoneErr ?></span>
    <br><br>

    Password:
    <input type="password" name="password">
    <span class="error">* <?= $passwordErr ?></span>
    <br><br>

    Confirm Password:
    <input type="password" name="confirmPassword">
    <span class="error">* <?= $confirmPasswordErr ?></span>
    <br><br>

    Gender:
    <input type="radio" name="gender" value="male" <?= ($gender=="male")?'checked':''; ?>>Male
    <input type="radio" name="gender" value="female" <?= ($gender=="female")?'checked':''; ?>>Female
    <span class="error">* <?= $genderErr ?></span>
    <br><br>

    Terms:
    <input type="checkbox" name="terms" <?= isset($_POST['terms']) ? 'checked' : '' ?>>
    I agree to the terms
    <span class="error">* <?= $termsErr ?></span>
    <br><br>

    <input type="submit" value="Submit">

</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    $nameErr == "" && $emailErr == "" && $phoneErr == "" &&
    $passwordErr == "" && $confirmPasswordErr == "" &&
    $genderErr == "" && $termsErr == "") {

    echo "<h3>Submitted Info:</h3>";
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Website: " . $website . "<br>";
    echo "Phone: " . $phone . "<br>";
    echo "Gender: " . $gender . "<br>";
}
?>

</body>
</html>