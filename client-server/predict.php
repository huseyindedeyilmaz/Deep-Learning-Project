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
    $sexValue = ($sex == 'male') ? 0 : 1;
    $embarkedValue = ['C' => 0, 'Q' => 1, 'S' => 2][$embarked];

    // Check if embarked is valid
    if ($embarkedValue === null) {
        echo "Invalid 'embarked' value. Please use 'C', 'Q', or 'S'.";
        exit();
    }

    // Prepare data for TensorFlow.js
    $input_data = "[$pclass, $sexValue, $age, $sibsp, $parch, $fare, $embarkedValue]";
    // Display the input data (optional)
    echo "<p>Input Data: $input_data</p>";
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
            prediction();
        });

        async function prediction() {
            const model = await tf.loadLayersModel("../Model/model.json");

            //input = input.reshape([1, 7,1]);
            const inputDataString = "<?php echo $input_data; ?>";
            const inputDataArray = JSON.parse(inputDataString).map(Number);
            const input = tf.tensor3d(inputDataArray, [1, 7, 1]);
            console.log(input);

             // Load the scaler information
            const scalerInfoResponse = await fetch("../Model/scaler_info.json");
            const scalerInfo = await scalerInfoResponse.json();
            // Create a scaler using the information
            const dataScaler = {
                mean: tf.tensor(scalerInfo.mean).reshape([1, 7, 1]),
                scale: tf.tensor(scalerInfo.scale).reshape([1, 7, 1]),
            };
            //scale the passenger data using the same scaler used during training
            const scaledInput = input.sub(dataScaler.mean).div(dataScaler.scale);
            // reshape scaled input to 3D with shape [1, 7, 1]
            console.log(scaledInput);
            // Make a prediction
            const output = model.predict(scaledInput);
            const prediction = Array.from(output.dataSync())[0];

            // Display the prediction in a popup
            alert("Survival Rate: " + prediction*100+"%");
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