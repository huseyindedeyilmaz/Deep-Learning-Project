<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilgi Girişi Formu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <?php

        include("model.php");
    ?>
    <form>
        <label for="pclass">Pclass:</label>
        <input type="text" id="pclass" name="pclass" required>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="age">Age:</label>
        <input type="text" id="age" name="age" required>

        <label for="sibsp">SibSp:</label>
        <input type="text" id="sibsp" name="sibsp" required>

        <label for="parch">Parch:</label>
        <input type="text" id="parch" name="parch" required>

        <label for="fare">Fare:</label>
        <input type="text" id="fare" name="fare" required>

        <label for="embarked">Embarked:</label>
        <input type="text" id="embarked" name="embarked" required>

        <button type="submit">Send</button>
    </form>



</body>
</html>
