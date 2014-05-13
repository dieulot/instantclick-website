<?php
$style_rev = 6;
$last_ver = '3.0.1';
$export_folder = '../output';

$pages = array(
  'welcome',
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

if (defined('STDIN')) {
  if (isset($page)) {
    ob_start();
  }
  else {
    if (file_exists($export_folder)) {
      function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
      }
      delTree($export_folder);
    }
    mkdir($export_folder);
    chmod($export_folder, 0777);

    foreach ($pages as $page) {
      include(__FILE__);
    }

    //file_put_contents($export_folder . '/style.css', $style);

    copy('script-' . $style_rev . '.js', $export_folder . '/script-' . $style_rev . '.js');
    if (!file_exists($export_folder . '/v' . $last_ver)) {
      mkdir($export_folder . '/v' . $last_ver);
    }
    copy('v' . $last_ver . '/instantclick.js', $export_folder . '/v' . $last_ver . '/instantclick.js');
    copy('v' . $last_ver . '/instantclick.min.js', $export_folder . '/v' . $last_ver . '/instantclick.min.js');
    copy('twitter.svg', $export_folder . '/twitter.svg');
    copy('github.png', $export_folder . '/github.png');
    copy('logo.png', $export_folder . '/logo.png');
    copy('favicon.ico', $export_folder . '/favicon.ico');
    copy('scary-analytics.png', $export_folder . '/scary-analytics.png');
    copy('pages_per_visit_falloff_by_landing_page_speed.jpg', $export_folder . '/pages_per_visit_falloff_by_landing_page_speed.jpg');
    copy('change_in_bounce_rate_by_landing_page_speed.jpg', $export_folder . '/change_in_bounce_rate_by_landing_page_speed.jpg');
    copy('302-spam.png', $export_folder . '/302-spam.png');

    $files = array(
      'index.html',
      'click-test.html',
      'download.html',
      'changelog.html',
      '3.0.html',
      'license.html',
      'github-pages-and-apex-domains.html',
      'script-' . $style_rev . '.js',
      'v' . $last_ver . '/instantclick.js',
      'v' . $last_ver . '/instantclick.min.js',
      'twitter.svg',
      'github.png',
      'logo.png',
      'favicon.ico',
      'README.md'
    );

    exit;
  }
}
else {
  $page = isset($_GET['page']) ? $_GET['page'] : 'welcome';
}

if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/' . $export_folder . '/') !== false) {
  include($page . '.html');
  exit;
}

$titles = array(
  'welcome' => 'InstantClick — JS library to make your website instant',
  'download' => 'Download InstantClick',
  'click-test' => 'Test your click speed - InstantClick',
  'changelog' => 'Changelog - InstantClick',
  '3.0' => 'InstantClick 3.0 Released',
  'license' => 'MIT License - InstantClick',
  'github-pages-and-apex-domains' => 'GitHub Pages is slow - InstantClick'
);

$descriptions = array(
  'welcome' => 'InstantClick makes following links in your website instant.',
  'download' => 'Download and get started with InstantClick.',
  'click-test' => 'Tells you the delay between your hover/mousedown and click.',
  'changelog' => 'InstantClick’s progress across versions, release notes.',
  '3.0' => 'Release announcement for InstantClick 3.0: Preloading for mobile devices, progress bar.',
  'license' => 'InstantClick is released under the MIT License.',
  'github-pages-and-apex-domains' => 'GitHub Pages with a custom root domain is terribly slow. It will make 35% of your visitors go away.'
);
?>
<!doctype html>
<meta charset="utf-8">
<title><?php echo $titles[$page] ?></title>
<meta name="viewport" content="width=750">
<style><?php echo $style ?></style>
<meta name="description" content="<?php echo $descriptions[$page] ?>">
<?php if ($page != '3.0'): ?>
<link rel="canonical" href="http://instantclick.io/<?php if ($page != 'welcome') { echo $page; } ?>">
<?php endif ?>

<div id="header">
  <h1><a href=".">InstantClick</a></h1>
  <ul>
    <li class="github"><a href="https://github.com/dieulot/instantclick" title="GitHub">Github</a>
    <li class="twitter"><a href="https://twitter.com/instantclickjs" title="Twitter">Twitter</a>
<?php
$menu_items = array(
  array('welcome', 'Home'),
  array('download', 'Download'),
  array('click-test', 'Click test'),
  array('changelog', 'Changelog')
);
foreach ($menu_items as $item): ?>
    <li<?php if ($item[0] == $page || ($page == '3.0' && $item[0] == 'changelog')) { echo ' class="on"'; } ?>><a href="<?php echo $item[0] == 'welcome' ? '.' : $item[0]; ?>"><?php echo $item[1] ?></a>
<?php endforeach ?>
  </ul>
</div>
<?php include($page . '.html') ?>
<div id="footer">InstantClick is released under the <a href="license">MIT License</a>, © 2014 Alexandre Dieulot</div>
<script src="script-<?php echo $style_rev ?>.js" data-no-instant></script>
<?php
if (defined('STDIN')) {
  if ($page == 'welcome') $page = 'index';
  $contents =  ob_get_contents();
  ob_end_clean();
  file_put_contents($export_folder . '/' . $page . '.html', $contents);
}
?>