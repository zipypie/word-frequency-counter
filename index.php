<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Word Frequency Counter</h1>
    
<?php

function tokenizeText($text)
{

    $words = preg_split('/[\s,.-]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    return $words;
}

function calculateWordFrequency($text, $stopWords, $sortOrder, $limit)
{
    $text = strtolower($text);
    $words = tokenizeText($text);
    $filteredWords = array_diff($words, $stopWords);
    $totalWords = count($filteredWords);
    $wordFrequency = array_count_values($filteredWords);

    if ($sortOrder == 'asc') {
        asort($wordFrequency);
    } else {
        arsort($wordFrequency);
    }

    $wordFrequency = array_slice($wordFrequency, 0, $limit);


    $htmlContent = "";


    if (empty($wordFrequency)) {
        $htmlContent .= "<p>No words to display.</p>";
    } else {
        $htmlContent .= "<p>Total number of unique words: " . count($wordFrequency) . "</p>";
        $htmlContent .= "<table>";
        $htmlContent .= "<tr><th>Word</th><th>Frequency</th></tr>";
        foreach ($wordFrequency as $word => $frequency) {
            $htmlContent .= "<tr><td>$word</td><td>$frequency</td></tr>";
        }
        $htmlContent .= "</table>";
    }


    return $htmlContent;
}


$stopWords = array("the", "and", "in", "to", "of", "a", "is", "it", "that");


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["text"])) {
    $text = $_POST["text"];
    $sortOrder = $_POST["sort"];
    $limit = $_POST["limit"];


    if ($sortOrder != 'asc' && $sortOrder != 'desc') {
        echo "<p>Invalid sort order selected.</p>";
        exit();
    }


    if (!is_numeric($limit) || $limit < 1) {
        echo "<p>Invalid limit value.</p>";
        exit();
    }


    $wordFrequencyHTML = calculateWordFrequency($text, $stopWords, $sortOrder, $limit);
} else {
    echo "<p>Please paste some text in the textarea.</p>";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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

<div class="display_text">
    <?php
    if (isset($wordFrequencyHTML)) {
        echo $wordFrequencyHTML;
    }
    ?>
</div>

</body>
</html>
