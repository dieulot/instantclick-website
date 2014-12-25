<?php

$got = file_get_contents('https://gist.github.com/dieulot/'.$_GET['x'].'.js');
preg_match('#document.write\(\'(<div id.+)\'\)#', $got, $matches);

header('Content-Type: text/plain; charset=utf-8');

$str = $matches[1];
$str = preg_replace('#\\\\n\s*#', "\n", $str);
$str = str_replace('\\', '', $str);
$str = preg_replace('#<div class="gist-meta".+</div>#s', "</div>\n</div>", $str);
$str = preg_replace('/\\n+/', "\n", $str);
$str = preg_replace('/ id="[^"]+"/', '', $str);
$str = str_replace('<span class="pl-', '<span class="', $str); // doesn’t work that well, they changed classes’ names
echo $str;
