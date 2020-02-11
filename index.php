<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

whatIsHappening();
function whatIsHappening() {
    echo '<h2>$_SERVER</h2>';
    var_dump($_SERVER);
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// Set food depending on foodGET
$food = $_GET['food'];

// Our products with their price.
if ($food == null || $food == 1) {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}
$totalValue = 0;

// Handle closing of the tab or changing to other food tabs
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['email'] != '' || $_SESSION['street'] != '' || $_SESSION['streetnumber'] != ''
        || $_SESSION['city'] != '' || $_SESSION['zipcode'] != '' || $_SESSION['totalvalue'] != 0) {

        $totalValue = $_SESSION['totalvalue'];
        $userEmail = $_SESSION['email'];
        $userStreet = $_SESSION['street'];
        $userStreetNumber = $_SESSION['streetnumber'];
        $userCity = $_SESSION['city'];
        $userZip = $_SESSION['zipcode'];

    }
}

// Handle submitting of form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_SESSION['totalvalue'] != 0) {
        $totalValue = $_SESSION['totalvalue'];
    }
    $userEmail = $userStreet = $userStreetNumber = $userCity = $userZip = '';
    $_SESSION['email'] = $_SESSION['street'] = $_SESSION['streetnumber'] = $_SESSION['city'] = $_SESSION['zipcode'] = '';

    // Set variables we will be checking and counter for success
    $successCounter = 0;

    // Check if valid email format, otherwise send alert
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['email'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid email!</div>";
    } else {
        $userEmail = $_SESSION['email'] = test_input($_POST['email']);
        $successCounter++;
    }

    // Verify street name is only letters and whitespace
    if (preg_match("/[a-zA-Z0-9 ]\\./", $_POST['street']) || empty($_POST['street'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid street name! (letters, spaces, numbers, periods)!</div>";
    } else {
        $userStreet = $_SESSION['street'] = test_input($_POST['street']);
        $successCounter++;
    }

    // Verify streetnumber as only numbers and not empty
    if (!is_numeric($_POST['streetnumber']) || empty($_POST['streetnumber'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid street number! (Only real numbers)</div>";
    } else {
        $userStreetNumber = $_SESSION['streetnumber'] = test_input($_POST['streetnumber']);
        $successCounter++;
    }

    // Verify city name
    if (!ctype_alpha($_POST['city']) || empty($_POST['city'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid city name! (letters, spaces, numbers, periods)!</div>";
    } else {
        $userCity = $_SESSION['city'] = test_input($_POST['city']);
        $successCounter++;
    }

    // Verify zip as only numbers and not empty
    if (!is_numeric($_POST['zipcode']) || empty($_POST['zipcode'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid zip code! (Only real numbers)</div>";
    } else {
        $userZip = $_SESSION['zipcode'] = test_input($_POST['zipcode']);
        $successCounter++;
    }

    // Else success
    if ($successCounter == 5) {
        echo "<div class='alert alert-success'><strong>Good Job! </strong> Form submitted succesfully!</div>";
        $userEmail = $_SESSION['email'] = '';
        $successCounter = 0;
        $_SESSION['totalvalue'] = $totalValue = 0;
    }

    // Ordering food total
    $userChoices = $_POST['products'];
    $chosenFoods = [];

    for ($i = 0; $i < count($products); $i++) {
        if (isset($userChoices[$i])) {
            array_push($chosenFoods, $products[$i]);
            $totalValue += $products[$i]{'price'};
            $_SESSION['totalvalue'] = $totalValue;
        }
    }

}

// Function from w3 schools to protect from $_SERVER['PHP_SELF'] hack
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


require 'form-view.php';
