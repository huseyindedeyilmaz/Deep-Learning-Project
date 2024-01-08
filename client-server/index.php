<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Titanic Survival Predictor</title>
        <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.2.3/dist/flatly/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Post data -->
        <script>
        function postData() {
            var formData = $("#form1").serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: "GetPostData.php",
                data: formData,
                success: async function(response) {
                    const predicted = await prediction(response); // Call prediction function from Prediction.js
                    // Set threshold to 0.453
                    $threshold = 0.453
                    // Display result
                    $("#predictionResult").html(predicted > $threshold ? '<div class="alert alert-dismissible alert-success" style="width:100%;"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><h3><strong>This Passenger</strong> was <strong>Survived</strong> from Titanic incident.</h3></div>' 
                    : '<div class="alert alert-dismissible alert-danger" style="width:100%;"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><h3><strong>This Passenger</strong> was <strong>not Survived</strong> from Titanic incident.</h3></div>');
                    
                }
            });
        }
        </script>
        <!-- Background video -->
        <audio id="song" controls>
            <source src="../images&videos/titanic_song.mp3" type="audio/mp3">
            Tarayıcınız ses etiketini desteklemiyor.
        </audio>
        <!-- toggleSound -->
        <script>
            var audioElement = document.getElementById("song");

            function toggleSound() {
                if (audioElement.paused) {
                    audioElement.play();
                } else {
                    audioElement.pause();
                }
                // check that if the i class is volume-down-fill or volume-mute-fill
                if(document.getElementById("song_button").innerHTML == '<i class="bi bi-volume-down-fill text-primary" style=" font-size: 24px;"></i>'){
                    document.getElementById("song_button").innerHTML = '<i class="bi bi-volume-mute-fill text-primary" style=" font-size: 24px;"></i>';
                }else{
                    document.getElementById("song_button").innerHTML = '<i class="bi bi-volume-down-fill text-primary" style=" font-size: 24px;"></i>';
                }
            }
        </script>
        <!-- TensorFlow.js -->
        <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
        <!-- Include Prediction.js -->
        <script src="Prediction.js"></script>

    </head>
    <body style="font-family: cursive;">
        <link rel="stylesheet" href="style.css">
        <form id="form1" name="predictionForm" method="post" style="height:100%; width:100%;" >
            <div class="row">
                <!-- <-- Left background -->
                <div class="col-md-8 d-flex justify-content-center " >
                    <video id="videoBackground" autoplay muted loop>
                        <source src="../images&videos/titanic.mp4" type="video/mp4">
                    </video>
                    <!-- Sound mute unmute button -->
                    <div class="col-md-2 ">
                        <br />
                        <div class="row">
                            <button type="button"onclick="toggleSound()" id="song_button"><i class="bi bi-volume-mute-fill text-primary" style=" font-size: 24px;"></i></button>
                        </div>
                    </div>
                    <!-- End Sound mute unmute button -->
                    <!-- Header Part -->
                    <div class="col-md-8 ">
                        <br />
                        <!-- Title -->
                        <div class="row">
                            <h1 class="d-flex justify-content-center text-white">Titanic Survival Prediction</h1>
                        </div>
                        <!-- End Title -->
                        <!-- Result -->
                        <div class="row d-flex justify-content-center " style="height: 90vh;">
                            <div class="my-auto d-flex " id="predictionResult" >
                                <!-- Result Will Show here -->
                            </div>
                        </div>
                        <!-- End Result -->
                    </div>
                    <!-- End Header Part -->
                    <div class="col-md-2 "></div>
                </div>
                <!-- End Left background -->
                <!-- User Form Part  -->
                <div class="col d-flex justify-content-center bg-light" style="height: 100vh;">  
                    <div class="my-auto " >
                        <!-- Header -->
                        <div class="row">
                            <h2><label class="form-label mt-4 text-primary">Titanic Passenger details</label></h2>
                        </div>
                        <!-- End Header -->
                        <!-- form group -->
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <!-- 1st row -->
                                <div class="row">
                                    <!-- Ticket Class -->
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Ticket Class</label>
                                            <select name="pclass" class="form-control form-text" required>
                                                <option value="">Select</option>
                                                <option value="1">1st Class</option>
                                                <option value="2">2nd Class</option>
                                                <option value="3">3rd Class</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Ticket Class -->
                                    <!-- Gender -->
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Gender</label>
                                            <select name="sex" class="form-control form-text" required>
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Gender -->
                                    <!-- Age -->
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Age</label>
                                            <input type="number" class="form-control form-text" name="age" required>
                                        </div>
                                    </div>
                                    <!-- End Age -->
                                </div>
                                <!-- End 1st row -->
                                <!-- 2nd row -->
                                <div class="row">
                                    <!-- sibsp -->
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Number of Sibling/Spouse</label>
                                            <input type="number" class="form-control form-text" name="sibsp" required>
                                        </div>
                                    </div>
                                    <!-- End sibsp -->
                                    <!-- parch -->
                                    <div class="col">
                                        <div class=" form-group">    
                                            <label class="form-label mt-4">Number of Parents/Child</label>
                                            <input type="number" class="form-control form-text" name="parch" required>
                                        </div>
                                    </div>
                                    <!-- End parch -->
                                    <!-- fare -->
                                    <div class="col">
                                    <br />
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Passenger fare</label>
                                            <input type="number" class="form-control form-text" name="fare" required>
                                        </div>
                                    </div>
                                    <!-- End fare -->
                                </div>
                                <!-- End 2nd row -->
                                <!-- 3rd row -->
                                <div class="row">
                                    <!-- embarked -->
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Port of Embarkation</label>
                                            <select name="embarked" class="form-control form-text" required>
                                                <option value="">Select</option>
                                                <option value="C">Cherbourg</option>
                                                <option value="Q">Queenstown</option>
                                                <option value="S">Southampton</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End embarked -->
                                </div>
                                <!-- End 3rd row -->
                                <br />
                                <!-- Predict button -->
                                <div class=" d-grid gap-2">
                                    <button type="button" onclick="postData()" id="predict" name="predict" class="btn btn-primary"">Predict</button>
                                </div>  
                                <!-- End Predict button -->
                            </div>
                        </div> 
                        <!-- End form group -->
                    </div>
                </div>
                <!-- End User Form Part  -->
            </div>
        </form>
    </body>
</html>