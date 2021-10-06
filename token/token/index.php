<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Token</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout($('#token').load('token.php'), 1000);
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="col-xl-12">
            <div class="col-md-8 mx-auto mt-4">
                <div id="token"></div>
                <p class="mt-4 text-center">Jika Ada Kendala Mohon Hubungi Asisten Laboratorium</p>
            </div>
        </div>
    </div>
</body>

</html>