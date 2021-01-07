<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/styles.css">
    
    <script src="<?=PROOT?>js/jQuery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="<?=PROOT?>js/bootstrap.min.js"></script>
    <?= $this->content('head');?>

    <title><?= $this->setTitle()?></title>
</head>

<body>

    <?= $this->content('body');?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
</body>

</html>