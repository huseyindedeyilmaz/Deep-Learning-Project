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

    // Prepare data for TensorFlow.js
    $input_data = "[$pclass, '$sex', $age, $sibsp, $parch, $fare, '$embarked']";

    // Use JavaScript to call TensorFlow.js for prediction
    echo '<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>';
    echo '<script>
            async function predict() {
                const model = await tf.loadLayersModel("model.json");
                const input = tf.tensor(' . $input_data . ');
                const output = model.predict(input);
                const prediction = output.dataSync()[0];
                alert("Survival Probability: " + prediction);
            }
            predict();
          </script>';
    echo $embarked;

} 
else {
    // Redirect if accessed without form submission
    header("Location: index.php");
    exit();
}
?>