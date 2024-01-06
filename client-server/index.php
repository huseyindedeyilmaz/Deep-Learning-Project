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
        <script>
        function postData() {
            var formData = $("#form1").serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: "GetPostData.php",
                data: formData,
                success: async function(response) {
                    const predicted = await prediction(response); // Call prediction function from Prediction.js
                    // alert(predicted);
                    // Display prediction result to predictionResult div as "Survived" or "Not Survived if predicted value is more than 0.5"
                    // $("#predictionResult").html(predicted > 0.5 ? "<h1 class='text-success'>This Passenger was Survived from Titanic incident</h1>" 
                    // : "<h1 class='text-danger'>This Passenger was not Survived from Titanic incident</h1>");
                    $("#predictionResult").html(predicted > 0.5 ? '<div class="alert alert-dismissible alert-success" style="width:100%;"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><h3><strong>This Passenger</strong> was <strong>Survived</strong> from Titanic incident.</h3></div>' 
                    : '<div class="alert alert-dismissible alert-danger" style="width:100%;"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><h3><strong>This Passenger</strong> was <strong>not Survived</strong> from Titanic incident.</h3></div>');
                    
                }
            });
        }
        </script>
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
                // check that if the i class is volume-down-fill or volume-mute-fill
                if(document.getElementById("song_button").innerHTML == '<i class="bi bi-volume-down-fill text-primary" style=" font-size: 24px;"></i>'){
                    document.getElementById("song_button").innerHTML = '<i class="bi bi-volume-mute-fill text-primary" style=" font-size: 24px;"></i>';
                }else{
                    document.getElementById("song_button").innerHTML = '<i class="bi bi-volume-down-fill text-primary" style=" font-size: 24px;"></i>';
                }
            }
        </script>
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
                    <div class="col-md-2 ">
                        <br />
                        <div class="row">
                            <button type="button"onclick="toggleSound()" id="song_button"><i class="bi bi-volume-mute-fill text-primary" style=" font-size: 24px;"></i></button>
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <br />
                        <div class="row">
                            <h1 class="d-flex justify-content-center text-white">Titanic Survival Prediction</h1>
                        </div>
                        <div class="row d-flex justify-content-center " style="height: 90vh;">
                            <div class="my-auto d-flex " id="predictionResult" >

                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-2 "></div>
                    
                </div>
                <!-- End Left background -->
                <div class="col d-flex justify-content-center bg-light" style="height: 100vh;">  
                    <div class="my-auto " >
                        <div class="row">
                            <h2><label class="form-label mt-4 text-primary">Titanic Passenger details</label></h2>
                        </div>
                        <!-- form group -->
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <div class="row">
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Pclass</label>
                                            <input type="Number" class="form-control form-text" name="pclass" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Gender</label>
                                            <select name="sex" class="form-control form-text" required>
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" name="pclass" required> -->
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Age</label>
                                            <input type="number" class="form-control form-text" name="age" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">SibSp</label>
                                            <input type="number" class="form-control form-text" name="sibsp" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Parch</label>
                                            <input type="number" class="form-control form-text" name="parch" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Fare</label>
                                            <input type="number" class="form-control form-text" name="fare" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class=" form-group">
                                            <label class="form-label mt-4">Embarked(C,Q,S)</label>
                                            <select name="embarked" class="form-control form-text" required>
                                                <option value="">Select Embarked</option>
                                                <option value="C">C</option>
                                                <option value="Q">Q</option>
                                                <option value="S">S</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class=" d-grid gap-2">
                                    <button type="button" onclick="postData()" id="predict" name="predict" class="btn btn-primary"">Predict</button>
                                </div>  
                                
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>