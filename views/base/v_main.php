<html>
<head>
    <title><?=$title?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.theme.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/main.css">
    
    <link rel="canonical" href="<?=$canonical?>">
</head>
<body>
    
    <? if (!empty($errors)): ?>
        <? foreach ($errors as $error): ?>
            <script> alert("<?=$error?>")</script>
        <? endforeach ?>
    <? endif ?>

    <div class="container">

    <? if ($username != ''): ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary mb-2">
	    <a class="navbar-brand" href="<?=BASE_URL?>">Вітаємо, <?=$username?>!</a>
        <span><a href="<?=BASE_URL?>logout" class="btn btn-primary mt-auto">Вийти</a></span>


	    <div class="collapse navbar-collapse" id="navbarColor02"></div>

        <div class="text-right" style="color:white">                
                    <h4>Контакти:</h2>                
                    <p>0509684567 Сергій</p>      
        </div>
        <? endif ?>

    </nav>

        <div class="row">
            <?=$content?>
        </div>

</body>
</html>