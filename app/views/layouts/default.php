<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<head>
    <title> <?= $this->getSiteTitle(); ?> </title>
    <link rel="icon" href="<?= PROOT ?>public/uploads/<?= "" //$this->image_name ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500" rel="stylesheet">

    <!-- Font Icons -->
    <link rel="stylesheet" href="<?= PROOT ?>public/fonts/ionicons.css">
    <link rel="stylesheet" type="text/css" href="<?= PROOT ?>public/css/styles.css" />
</head>

<body>
    <?= $this->component('header') ?>
    
    <div class="main-container">
        <?= $this->component('sidebar') ?>
        

        <div class="main-content">
            <?= $this->content('body') ?>
        </div>
    </div>

    <?= $this->component('php-footer') ?>
</body>

</html>