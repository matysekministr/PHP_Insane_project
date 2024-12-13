<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Pouze písmena a mezery jsou povoleny!!!";
    }
    $email = htmlspecialchars($_POST['email']);
    $website = test_input($_POST["website"]);
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
        $websiteErr = "Invalid URL";
    };
    $comment = htmlspecialchars($_POST['comment']);
    $gender = htmlspecialchars($_POST['gender']);

    // Output or process the data here
    echo "<h2>Your Input:</h2>";
    echo "Name: " . $name . "<br>";
    echo "E-mail: " . $email . "<br>";
    echo "Website: " . $website . "<br>";
    echo "Comment: " . $comment . "<br>";
    echo "Gender: " . $gender . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Eple</title>
</head>
<body>

<h2>PHP Form</h2>
<p><span class="error">* required field</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name" required><br><br>
    E-mail: <input type="text" name="email" required><br><br>
    Website: <input type="text" name="website"><br><br>
    Comment: <textarea name="comment" rows="5" cols="40"></textarea><br><br>
    Gender:
    <input type="radio" name="gender" value="female">Female
    <input type="radio" name="gender" value="male">Male
    <input type="radio" name="gender" value="other">Other<br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
