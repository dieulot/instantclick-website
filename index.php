<?php
$style_rev = 6;
$last_ver = '3.0.1';
$export_folder = '../output';

$pages = array(
  'index',
  'download',
  'click-test',
  'changelog',
  '3.0',
  'license',
  'github-pages-and-apex-domains',
);

$style = file_get_contents('style.css');
$style = preg_replace('#\s*/\*(.+)\*/\s*#', '', $style);
$style = str_replace(array("\r", "\n", "\t"), '', $style);
$style = str_replace(': ', ':', $style);
$style = str_replace(' {', '{', $style);
$style = str_replace(';}', '}', $style);
$style = str_replace(' + ', '+', $style);

$page = isset($_GET['page']) ? substr($_GET['page'], 1) : 'index';
if (strlen($page) == 0) {
  $page = 'index';
}
if (!in_array($page, $pages)) {
  $page = '404';
}

if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/' . $export_folder . '/') !== false) {
  include($page . '.html');
  exit;
}

$titles = array(
  'download' => 'Download InstantClick',
  'click-test' => 'Test your click speed - InstantClick',
  'changelog' => 'Changelog - InstantClick',
  '3.0' => 'InstantClick 3.0 Released',
  'github-pages-and-apex-domains' => 'GitHub Pages is slow with root domains - InstantClick',
  '404' => 'Page not found',
);

$descriptions = array(
  'download' => 'Download and get started with InstantClick.',
  'click-test' => 'Tells you the delay between your hover/mousedown and click.',
  'changelog' => 'InstantClick’s progress across versions, release notes.',
  '3.0' => 'Release announcement for InstantClick 3.0: Preloading for mobile devices, progress bar.',
  'github-pages-and-apex-domains' => 'GitHub Pages with a custom root domain is terribly slow. It will make 35% of your visitors go away.',
);

if ($page == '404') {
  header('HTTP/1.1 404 Not Found');
}

$page_source = $page_content = file_get_contents('pages/' . $page . '.html');

if (preg_match('#^---(.+)---#s', $page_source, $matches)) {
  $params = explode("\n", $matches[1]);
  foreach ($params as $param) {
    $colon_pos = strpos($param, ':');
    if (!$colon_pos) {
      continue;
    }

    $name = substr($param, 0, $colon_pos);
    $value = trim(substr($param, $colon_pos + 1));

    if ($name == 'title') {
      $page_title = $value;
    }
    if ($name == 'description') {
      $page_description = $value;
    }
  }
  $page_content = trim(substr($page_source, strlen($matches[0])));
}
?>
<!doctype html>
<meta charset="utf-8">
<? if (isset($page_title)): ?>
<title><?= $page_title ?></title>
<? endif ?>
<meta name="viewport" content="width=768">
<style><?php echo $style ?></style>
<? if (isset($page_description)): ?>
<meta name="description" content="<?= $page_description ?>">
<? endif ?>
<?php if ($page != '3.0'): ?>
<link rel="canonical" href="http://instantclick.io/<?php if ($page != 'index') { echo $page; } ?>">
<?php endif ?>

<header id="header">
  <h1><a href=".">InstantClick</a></h1>
  <ul>
    <li><a href="/download">Download</a>
    <li><a href="/click-test">Click test</a>
    <li><a href="/blog">Blog</a>
  </ul>
  <div class="border"></div>
</header>
<article class="container">
<?= $page_content ?>
</article>
<div id="footer">InstantClick is released under the <a href="license">MIT License</a>, © 2014 Alexandre Dieulot</div>
<script src="script-<?php echo $style_rev ?>.js" data-no-instant></script>
<?php
if (defined('STDIN')) {
  $contents =  ob_get_contents();
  ob_end_clean();
  file_put_contents($export_folder . '/' . $page . '.html', $contents);
}
?>