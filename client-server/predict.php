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
?>

<!-- Your existing HTML code -->
<body>
    <h1>Titanic Survival Predictor</h1>
    <form id="predictionForm">
        <!-- Your form fields -->

        <input type="submit" value="Predict">
    </form>

    <!-- Add a div for displaying the prediction result -->
    <div id="predictionResult"></div>

    <!-- Your existing HTML code -->

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script>
        document.getElementById('predictionForm').addEventListener('submit', function(event) {
            event.preventDefault();
            predict();
        });

        async function predict() {
            const model = await tf.loadLayersModel("../Model/model.json");
            const input = tf.tensor(<?php echo $input_data; ?>);
            const output = model.predict(input);
            const prediction = output.dataSync()[0];

            // Update HTML element with the prediction result
            document.getElementById("predictionResult").innerText = "Survival Probability: " + prediction;
        }
    </script>
</body>
</html>
<?php
} else {
    // Redirect if accessed without form submission
    header("Location: index.php");
    exit();
}
?>