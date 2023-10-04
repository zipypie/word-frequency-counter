<!DOCTYPE html>
<html>
<head>
    <title>Word Frequency Counter</title>
</head>
<body>
    <h1>Word Frequency Counter</h1>
    <form method="post" action="">
        <label for="inputText">Enter Text:</label>
        <textarea name="inputText" id="inputText" rows="5" cols="40"></textarea>
        <br>
        <input type="submit" name="submit" value="Count Words">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $inputText = $_POST["inputText"];

     
        $inputText = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $inputText));

    
        $words = str_word_count($inputText, 1);

     
        $wordFrequency = array_count_values($words);

    
        arsort($wordFrequency);

    
        echo "<h2>Word Frequencies:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Word</th><th>Frequency</th></tr>";
        foreach ($wordFrequency as $word => $frequency) {
            echo "<tr><td>$word</td><td>$frequency</td></tr>";
        }
        echo "</table>";
    }
    ?>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form action="process.php" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="10" min="1"><br><br>
        
        <input type="submit" value="Calculate Word Frequency">
    </form>
</body>
</html>
