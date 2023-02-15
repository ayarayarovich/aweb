<?php
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}

function get_page_title(string $url): string
{
    $title = '';
    $dom = new DOMDocument();

    if($dom->loadHTMLFile($url)) {
        $list = $dom->getElementsByTagName("title");
        if ($list->length > 0) {
            $title = $list->item(0)->textContent;
        }
    }

    return $title;
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

$files = scandir('.');

$renderedList = '';
foreach ($files as $file) {
    if (is_aweb($file)) {
        $index = aweb_extract_index($file);
        $title = get_page_title("./$file/index.html");
        $renderedList .= render_list_link($index, $title, $file);
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

    <link rel="iacon" type="image/x-icon" href="static/favicon.png">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5/dist/css/bootstrap-grid.min.css,npm/bootstrap@5/dist/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="style.css">
    <title>A-WEB: Главная</title>
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


</body>
</html>