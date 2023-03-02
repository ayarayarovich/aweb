<?php
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}

function is_aweb(string $string): bool
{
    return str_starts_with($string, 'aweb');
}
function aweb_extract_index(string $string): string
{
    return substr($string, strlen('aweb'));
}

function render_list_link(string $index, string $title, string $href): string
{
    return "<li><a class='list__item' href='$href'>Задание $index: $title</a></li>";
}

function get_page_title($url) {
    $fp = file_get_contents("$url/index.html");
    if (!$fp)
        $fp = file_get_contents("$url/index.php");
    if (!$fp)
        return "Без имени";

    $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
    if (!$res)
        return null;

    // Clean up title: remove EOL's and excessive whitespace.
    $title = preg_replace('/\s+/', ' ', $title_matches[1]);
    $title = trim($title);
    return $title;
}

$dirs = scandir('.');

$renderedList = '';
foreach ($dirs as $dir) {
    if (is_aweb($dir)) {
        $index = aweb_extract_index($dir);
        $title = get_page_title("$dir");
        $renderedList .= render_list_link($index, $title, $dir);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/x-icon" href="static/favicon.png">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5/dist/css/bootstrap-grid.min.css,npm/bootstrap@5/dist/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="style.css">
    <title>AWEB: Главная</title>
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <h2 class="heading">Аппаратно-програмные средства WEB</h2>
            <ul class="list">
                <?php echo $renderedList ?>
            </ul>
        </div>
    </div>

    <a class="shawarma" href="https://web6.ayarayarovich.tech" target="_blank">
        <img class="shawarma__image" src="static/giros.png" alt="shawarma">
        <span class="shawarma__text">Может <br> по шаве?</span>
    </a>

</body>
</html>