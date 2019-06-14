<?php
namespace NiklasTtest;
require "./../vendor/autoload.php";

use Niklas\Page;
use Niklas\Parser;

Page::INIT(new Page("
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
</head>
<body>
{{CONTENT}}
</body>
</html>"));
$page = Page::GET();
$root = $page->parser();
$css = new Parser();
$css->el("link")->properties(["rel" => "stylesheet", "type" => "text/css", "href" => "https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/cerulean/bootstrap.css", "media" => "screen"])
    ->el("link")->properties(["rel" => "stylesheet", "type" => "text/css", "href" => "https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/cerulean/bootstrap.min.css", "media" => "screen"]);
$firstItem = new Parser();
$firstItem->add("a")->properties(["href"=>"#", "class"=>"list-group-item list-group-item-action active"])->text("Cras justo odio");
$secondItem = new Parser();
$secondItem->add("a")->properties(["href"=>"#", "class"=>"list-group-item list-group-item-action"])->text("Dapibus ac facilisis in");
$thirdItem = new Parser();
$thirdItem->add("a")->properties(["href"=>"#", "class"=>"list-group-item list-group-item-action"])->text("Morbi leo risus");
$root->content($css)
    ->add("div")->properties(["class" => "list-group col-lg-4"])
    ->content($firstItem)
    ->content($secondItem)
    ->content($thirdItem);
echo $root->render();
