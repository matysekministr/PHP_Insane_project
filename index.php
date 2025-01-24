<?php
// Inicializace proměnných pro chyby a data
$nameErr = $emailErr = $websiteErr = $drinkErr = "";
$name = $email = $website = $comment = $drink = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form'])) {
    // Ošetření a sanitizace vstupních dat
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Pouze písmena a mezery jsou povoleny!!!";
    }

    $email = test_input($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Neplatný formát e-mailu";
    }

    $website = test_input($_POST["website"]);
    if (!empty($website) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/\\%?=~_|!:,.;]*[-a-z0-9+&@#\/\\%=~_|]/i", $website)) {
        $websiteErr = "Neplatná URL adresa";
    }

    $comment = test_input($_POST['comment']);
    $drink = isset($_POST['drink']) ? $_POST['drink'] : "";
    if (empty($drink)) {
        $drinkErr = "Prosím vyberte nápoj";
    }

    // Pokud nejsou žádné chyby, uložíme údaje do souboru
    if (empty($nameErr) && empty($emailErr) && empty($websiteErr) && empty($drinkErr)) {
        // Vytvoření pole s daty
        $data = array(
            "name" => $name,
            "email" => $email,
            "website" => $website,
            "comment" => $comment,
            "drink" => $drink
        );

        // Získání existujících dat z JSON souboru, pokud existují
        $jsonFile = "data.json";
        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $existingData = json_decode($jsonData, true);
        } else {
            $existingData = array();
        }

        // Přidání nových dat do existujících dat
        $existingData[] = $data;

        // Uložení všech dat zpět do souboru ve formátu JSON
        file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

        // Výstup pro uživatele
        $output = "<h2>Vaše údaje:</h2>";
        $output .= "Name: " . $name . "<br>";
        $output .= "E-mail: " . $email . "<br>";
        $output .= "Website: " . $website . "<br>";
        $output .= "Comment: " . $comment . "<br>";
        $output .= "Your drink choice: " . $drink . "<br>";
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 600px;
            text-align: left;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        input[type="submit"] {
            background-color: #888;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #667;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .button-container button {
            padding: 12px 20px;
            font-size: 1.1em;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #4CAF50;
        }
        .button-container button:hover {
            background-color: #45a049;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="form-container">
    <div class="button-container">
        <button id="signUpBtn">Sign Up</button>
        <button id="signInBtn">Sign In</button>
    </div>

    <form id="signUpForm" class="hidden" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Sign Up</h2>
        <label for="name">Jméno:</label>
        <input type="text" name="name" required><br>

        <label for="email">E-mail:</label>
        <input type="text" name="email" required><br>

        <label for="password">Heslo:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="submit_form" value="Sign Up">
    </form>

    <form id="signInForm" class="hidden" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Sign In</h2>
        <label for="email">E-mail:</label>
        <input type="text" name="email" required><br>

        <label for="password">Heslo:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="submit_form" value="Sign In">
    </form>
</div>

<script>
    const signUpBtn = document.getElementById("signUpBtn");
    const signInBtn = document.getElementById("signInBtn");
    const signUpForm = document.getElementById("signUpForm");
    const signInForm = document.getElementById("signInForm");

    signUpBtn.addEventListener("click", () => {
        signUpForm.classList.remove("hidden");
        signInForm.classList.add("hidden");
    });

    signInBtn.addEventListener("click", () => {
        signInForm.classList.remove("hidden");
        signUpForm.classList.add("hidden");
    });
</script>
</body>
</html>