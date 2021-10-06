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
        function ajax() {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("hasil").innerHTML = xmlhttp.responseText;
                }
            }

            xmlhttp.open("GET", "token.php", true);
            xmlhttp.send();

            setTimeout("ajax()", 1000);
        }
    </script>
</head>

<body onload="ajax()">
    <div class="container">
        <div class="col-xl-12">
            <div class="col-md-8 mx-auto mt-4">
                <div id="hasil"></div>
                <p class="mt-4 text-center">Jika Ada Kendala Mohon Hubungi Asisten Laboratorium</p>
            </div>
        </div>
    </div>
</body>

</html>