<html>
<head>
    <title><?=$title?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.theme.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/main.css">
    
    <link rel="canonical" href="<?=$canonical?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <? if (!empty($errors)): ?>
        <? foreach ($errors as $error): ?>
            <script> alert("<?=$error?>")</script>
        <? endforeach ?>
    <? endif ?>

    <div class="container">

    <? if ($userName != ''): ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary mb-2">
	    <a class="navbar-brand" href="<?=BASE_URL?>">Вітаємо, <?=$userName?>!</a>
        <span><a href="<?=BASE_URL?>logout" class="btn btn-primary mt-auto">Вийти</a></span>

        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Актуальні ціни
        </button>

	    <div class="collapse navbar-collapse" id="navbarColor02"></div>

        <div class="text-right" style="color:white">                
                    <h4 id="btn">Контакти:</h4>
                    <p>0671304327 Василь</p>      
        </div>
        <? endif ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Актуальні ціни</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <b>Відстань рахується через Google Maps для автомобіля</b>
                <hr>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            Хороша погода
                        </td>
                        <td width="50%" class="text-right">
                            Дощ/сніг (погодні умови в момент забору замовлення)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            До 2.5км 70
                        </td>
                        <td class="text-right">
                            84 грн
                        </td>
                    </tr>
                    <tr>
                        <td>
                            2.5-4.5 км 80
                        </td>
                        <td class="text-right">
                            96 грн
                        </td>
                    </tr>
                    <tr>
                        <td>
                            4.5-6.5км 90
                        </td>
                        <td class="text-right">
                            108 грн
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Більше 6.5км 110
                        </td>
                        <td class="text-right">
                            132 грн
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Кутківці, Петриків 120
                        </td>
                        <td class="text-right">
                            144 грн
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Великі Гаї, Біла, Березовиця 150
                        </td>
                        <td class="text-right">
                            180 грн
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
            </div>
            </div>
        </div>
        </div>

    </nav>

        <div class="row">
            <?=$content?>
        </div>

</body>
<script src="<?=BASE_URL?>assets/js/orders.js"></script>
</html>