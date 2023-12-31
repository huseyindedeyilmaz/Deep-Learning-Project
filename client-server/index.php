<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titanic Survival Predictor</title>
</head>
<body>
    <h1>Titanic Survival Predictor</h1>
    <form action="predict.php" method="post">
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

        <input type="submit" value="Predict">
    </form>

    
</body>
</html>