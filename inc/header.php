<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= BASE_URL ?>cdn/jquery.mobile-1.4.5.min.css">
        <script src="<?= BASE_URL ?>cdn/jquery-1.11.3.min.js"></script>
        <script src="<?= BASE_URL ?>cdn/jquery.mobile-1.4.5.min.js"></script>
        <script src="<?= BASE_URL ?>cdn/jquery.validate.min.js"></script>
        <script>
            var site = "<?= BASE_URL ?>";
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
        </script>
        <style>
            .error {color:red}
        </style>
    </head>
    <body>
