<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titanic Survival Predictor</title>
</head>
<body>

    <link rel="stylesheet" href="style.css">
      
    
    <audio id="song" controls>
        <source src="../images&videos/titanic_song.mp3" type="audio/mp3">
        Tarayıcınız ses etiketini desteklemiyor.
    </audio>



    <script>
        var audioElement = document.getElementById("song");

        function toggleSound() {
            if (audioElement.paused) {
                audioElement.play();
            } else {
                audioElement.pause();
            }
        }
    </script>



    <video id="videoBackground" autoplay muted loop>
        <source src="../images&videos/titanic.mp4" type="video/mp4">
    </video>


    <form id="predictionForm">
        <label for="Title">Titanic Survival</label>
        <label for="pclass">Pclass:</label>
        <input type="text" name="pclass" required><br>

        <label for="sex">Sex:</label>
        <select name="sex" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>

        <label for="age">Age:</label>
        <input type="text" name="age" required><br>

        <label for="sibsp">SibSp:</label>
        <input type="text" name="sibsp" required><br>

        <label for="parch">Parch:</label>
        <input type="text" name="parch" required><br>

        <label for="fare">Fare:</label>
        <input type="text" name="fare" required><br>

        <label for="embarked">Embarked:</label>
        <input type="text" name="embarked" required><br>

        <button type="button" onclick="prediction()">Predict</button>
        <button type="button"onclick="toggleSound()" id="song_button">Song</button>

    </form>

    <!-- Tahmin sonucunu görüntülemek için bir div ekleyin -->
    <div id="predictionResult"></div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script>
        // Sayfa yüklendiğinde çalışacak işlemler
        document.addEventListener('DOMContentLoaded', function() {
            loadModel();
        });

        // Modeli yükleme fonksiyonu
        async function loadModel() {
            window.model = await tf.loadLayersModel("../Model/model.json");
        }

        // Tahmin fonksiyonu
        function prediction() {
            // TensorFlow.js modeli var mı kontrol et
            if (!window.model) {
                alert("Model yüklenemedi. Lütfen tekrar deneyin.");
                return;
            }

            // Giriş verilerini al
            const pclass = parseInt(document.querySelector('[name="pclass"]').value);
            const sex = document.querySelector('[name="sex"]').value;
            const age = parseInt(document.querySelector('[name="age"]').value);
            const sibsp = parseInt(document.querySelector('[name="sibsp"]').value);
            const parch = parseInt(document.querySelector('[name="parch"]').value);
            const fare = parseFloat(document.querySelector('[name="fare"]').value);
            const embarked = document.querySelector('[name="embarked"]').value;
            
            // Giriş verilerini TensorFlow.js için hazırla
            const sexValue = (sex === 'male') ? 0 : 1;
            const embarkedValue = {'C': 0, 'Q': 1, 'S': 2}[embarked];
            if (embarkedValue === undefined) {
                alert("Geçersiz 'embarked' değeri. Lütfen 'C', 'Q' veya 'S' kullanın.");
                return;
            }
          
            // Giriş verilerini tensor formatına çevir
            const input = tf.tensor3d([pclass, sexValue, age, sibsp, parch, fare, embarkedValue], [1, 7, 1]);
            console.log(input)
            // Scaler bilgilerini yükle
            fetch("../Model/scaler_info.json")
                .then(response => response.json())
                .then(scalerInfo => {
                    const dataScaler = {
                        mean: tf.tensor(scalerInfo.mean).reshape([1, 7, 1]),
                        scale: tf.tensor(scalerInfo.scale).reshape([1, 7, 1]),
                    };

                    // Giriş verilerini ölçekle
                    const scaledInput = input.sub(dataScaler.mean).div(dataScaler.scale);

                    // Tahmin yap
                    const output = window.model.predict(scaledInput);
                    const prediction = Array.from(output.dataSync())[0];

                    // Tahmini bir div içinde görüntüle
                    const predictionResultDiv = document.getElementById('predictionResult');
                    
                    const threshold = 0.5

                    predictionResultDiv.innerHTML = (prediction > threshold) ? "She/He was survived" : "She/He wasn't survived"
                })
                .catch(error => {
                    console.error("Scaler bilgileri yüklenirken hata oluştu:", error);
                    alert("Bir hata oluştu. Lütfen tekrar deneyin.");
                });
        }
    </script>

</body>
</html>
