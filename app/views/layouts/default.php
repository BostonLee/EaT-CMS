<?php global $isAdmin; global $titlePage;?>
<?php header('Content-Type:text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

<title><?php echo $titlePage ; ?></title>

</head>
<body>
    <?php
    View::get_content($layout);
    ?>
</body>

</html>
