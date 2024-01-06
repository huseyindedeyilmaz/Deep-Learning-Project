<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $pclass = $_POST["pclass"];
    $sex = $_POST["sex"];
    $age = $_POST["age"];
    $sibsp = $_POST["sibsp"];
    $parch = $_POST["parch"];
    $fare = $_POST["fare"];
    $embarked = $_POST["embarked"];
    // Convert categorical data to numerical values
    $sexValue = ['male' => 0, 'female' => 1][$sex];
    $embarkedValue = ['C' => 0, 'Q' => 1, 'S' => 2][$embarked];
    // Prepare data for TensorFlow.js
    $input_data = "[$pclass, $sexValue, $age, $sibsp, $parch, $fare, $embarkedValue]";
    echo $input_data;
}
?>
