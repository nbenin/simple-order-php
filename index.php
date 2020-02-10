<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Set variables we will be checking
    $userEmail = $userStreet = $userStreetNumber = '';
    $userCity = $_POST['city'];
    $userZip = $_POST['zipcode'];

    // Check if valid email format, otherwise send alert
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['email'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid email!</div>";
    } else {
        $userEmail = $_POST['email'];
    }

    // Verify street name is only letters and whitespace
    if (preg_match("/[a-zA-Z0-9 ]\\.*$/", $_POST['street']) || empty($_POST['street'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid street name! (letters, spaces, numbers, periods)!</div>";
    } else {
        $userStreet = $_POST['street'];
    }

    // Verify city name
    if (preg_match("/[a-zA-Z ]*$/", $_POST['city']) || empty($_POST['city'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid city name! (letters, spaces, numbers, periods)!</div>";
    } else {
        $userStreet = $_POST['city'];
    }

    // Verify streetnumber as only numbers and not empty
    if (preg_match("/[0-9]/", $_POST['streetnumber']) || empty($_POST['streetnumber'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid street number! (Only real numbers)</div>";
    } else {
        $userStreetNumber = $_POST['streetnumber'];
    }

    // Verify zip as only numbers and not empty
    if (preg_match("/[0-9]/", $_POST['zipcode']) || empty($_POST['zipcode'])) {
        echo "<div class='alert alert-warning'><strong>Oops! </strong>Please enter valid zip code! (Only real numbers)</div>";
    } else {
        $userStreetNumber = $_POST['zipcode'];
    }
}






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

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

require 'form-view.php';
