async function prediction(input_data) {
  const model = await tf.loadLayersModel("../Model/model.json");
  const inputDataArray = JSON.parse(input_data).map(Number);
  console.log(inputDataArray);
  const input = tf.tensor3d(inputDataArray, [1, 7, 1]);

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
  return prediction;
  // Display the prediction in a popup
  //   alert("Survival Rate: " + prediction * 100 + "%");
}
