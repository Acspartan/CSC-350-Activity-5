
<?php
include 'data.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fine Art Meme Maker</title>

    <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800"
            rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
    <script src="js/severactivity.js" defer></script>
</head>

<body>

<h1>Fine Art Meme Maker</h1>

<!-- Painting thumbnails -->
<section class="grid-container">

    <?php foreach ($paintings as $painting): ?>

        <?php
        $filename = $painting['filename'];
        $title = $painting['title'];

        $imageURL = 'result.php?' . http_build_query([
                        'file' => $filename,
                        'width' => 100
                ]);
        ?>

        <img
                src="<?= htmlspecialchars($imageURL, ENT_QUOTES, 'UTF-8') ?>"
                data-value="<?= htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') ?>"
                alt="Thumbnail of <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
        >

    <?php endforeach; ?>

</section>

<!-- Meme generation form -->
<form action="result.php" method="get">

    <label for="whichPainting">
        Select Base Painting:
    </label>

    <select name="file" id="whichPainting">

        <?php foreach ($paintings as $painting): ?>

            <option
                    value="<?= htmlspecialchars($painting['filename'], ENT_QUOTES, 'UTF-8') ?>"
            >
                <?= htmlspecialchars($painting['title'], ENT_QUOTES, 'UTF-8') ?>
            </option>

        <?php endforeach; ?>

    </select>

    <label for="text1">Meme 1 Text:</label>

    <input
            type="text"
            id="text1"
            name="text1"
            size="50"
            value="Default text"
    >

    <label for="size1">Meme 1 Font Size:</label>

    12
    <input
            type="range"
            id="size1"
            name="size1"
            min="12"
            max="64"
            value="24"
    >
    64

    <label for="text2">Meme 2 Text:</label>

    <input
            type="text"
            id="text2"
            name="text2"
            size="50"
            value="More text"
    >

    <label for="size2">Meme 2 Font Size:</label>

    12
    <input
            type="range"
            id="size2"
            name="size2"
            min="12"
            max="48"
            value="48"
    >
    48

    <label for="width">Image Width:</label>

    500
    <input
            type="range"
            id="width"
            name="width"
            min="500"
            max="1000"
            value="500"
    >
    1000

    <input
            type="submit"
            value="Click To See Meme"
    >

</form>

</body>
</html>
