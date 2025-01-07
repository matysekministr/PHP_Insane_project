<?php
// Initialize error variables
$nameErr = $emailErr = $websiteErr = $drinkErr = "";
$name = $email = $website = $comment = $drink = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Pouze písmena a mezery jsou povoleny!!!";
    }

    $email = test_input($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Neplatný formát e-mailu";
    }

    $website = test_input($_POST["website"]);
    if (!empty($website) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
        $websiteErr = "Neplatná URL adresa";
    }

    $comment = test_input($_POST['comment']);
    $drink = isset($_POST['drink']) ? $_POST['drink'] : "";
    if (empty($drink)) {
        $drinkErr = "Prosím vyberte nápoj";
    }

    // Pokud nejsou žádné chyby, zobrazíme zadané údaje
    if (empty($nameErr) && empty($emailErr) && empty($websiteErr) && empty($drinkErr)) {
        echo "<h2>Your Input:</h2>";
        echo "Name: " . $name . "<br>";
        echo "E-mail: " . $email . "<br>";
        echo "Website: " . $website . "<br>";
        echo "Comment: " . $comment . "<br>";
        echo "Your drink choice: " . $drink . "<br>";
    }
}

// Funkce pro ošetření vstupních dat
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Example</title>
    <style>
        /* Vaše styly pro formulář */
    </style>
</head>
<body>

<!-- Dark/Light Mode Switch -->
<div class="switch">
    <label class="switch">
        <input type="checkbox" id="modeSwitch">
        <span class="slider"></span>
    </label>
</div>

<div class="form-container">
    <h2>PHP Form</h2>
    <p><span class="error">* required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name: <span class="required">*</span></label>
        <input type="text" name="name" value="<?php echo $name;?>" required><br>
        <span class="error"><?php echo $nameErr; ?></span><br>

        <label for="email">E-mail: <span class="required">*</span></label>
        <input type="text" name="email" value="<?php echo $email;?>" required><br>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label for="website">Website:</label>
        <input type="text" name="website" value="<?php echo $website;?>"><br>
        <span class="error"><?php echo $websiteErr; ?></span><br>

        <label for="comment">Comment:</label>
        <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea><br>

        <div class="radio-group">
            <label>Choose your drink:</label><br>
            <input type="radio" name="drink" value="coffee" <?php if ($drink == "coffee") echo "checked"; ?>> Coffee
            <input type="radio" name="drink" value="tea" <?php if ($drink == "tea") echo "checked"; ?>> Tea<br>
            <span class="error"><?php echo $drinkErr; ?></span><br>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<script>
    // Dark/Light mode přepínač
    const modeSwitch = document.getElementById("modeSwitch");
    const body = document.body;

    if (localStorage.getItem("mode") === "dark") {
        body.classList.add("dark-mode");
        modeSwitch.checked = true;
    }

    modeSwitch.addEventListener("change", function() {
        if (modeSwitch.checked) {
            body.classList.add("dark-mode");
            localStorage.setItem("mode", "dark");
        } else {
            body.classList.remove("dark-mode");
            localStorage.setItem("mode", "light");
        }
    });
</script>

</body>
</html>
