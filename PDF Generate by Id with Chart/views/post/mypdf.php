
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF View</title>
    <style>
        /* Style for the PDF */
        .container {
            padding: 20px;
        }
        img {
            max-width: 100%; /* Ensure the image scales with the PDF width */
        }
    </style>
</head>
<body>

    <div class="container">
            <h2 style="text-align: center;">My Pdf Generate By ID:</strong></span> <?= $posts->id ?> </h2>
           

            <!-- Include the image -->
            <img src="<?= $imagePath ?>" alt="Chart Image">

            <span><strong>Title:</strong></span> <?php echo $posts->title ;?> <br><br>
            <span><strong>Description:</strong></span> <?php echo $posts->description ;?><br><br>
            <span><strong>Category:</strong></span> <?php echo $posts->category ;?><br><br>
       
    </div>

</body>
</html>
