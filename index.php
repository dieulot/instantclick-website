<?php
/* This minifies CSS surprisingly well. */
$style = file_get_contents('style.css');
$style = preg_replace('#\s*/\*(.+)\*/\s*#', '', $style);
$style = str_replace(array("\r", "\n", "\t"), '', $style);
$style = str_replace(': ', ':', $style);
$style = str_replace(' {', '{', $style);
$style = str_replace(';}', '}', $style);
$style = str_replace(' + ', '+', $style);

if (!function_exists('find_page_path')) {
  function find_page_path($page, $dir = 'pages') {
    $handle = opendir($dir);
    while (($entry = readdir($handle)) !== false) {
      if ($entry[0] != '.' && is_dir($dir . '/' . $entry)) {
        $recursive_search = find_page_path($page, $dir . '/' . $entry);
        if ($recursive_search) {
          return $recursive_search;
        }
      }
      elseif ($entry == $page . '.html') {
        return $dir . '/' . $page . '.html';
      }
    }
    return false;
  }
}

if (!function_exists('parse_page')) {
  function parse_page($page_path) {
    $page_source = file_get_contents($page_path);
    $return = [
      'page_content' => $page_source,
    ];

    if (preg_match('#^---(.+)---#s', $page_source, $matches)) {
      $params = explode("\n", $matches[1]);
      foreach ($params as $param) {
        $colon_pos = strpos($param, ':');
        if (!$colon_pos) {
          continue;
        }

        $name = substr($param, 0, $colon_pos);
        $value = trim(substr($param, $colon_pos + 1));

        $return['page_' . $name] = $value;
      }
      $return['page_content'] = trim(substr($page_source, strlen($matches[0])));
    }

    if (preg_match('#<h1>(.*)</h1>#i', $page_source, $matches)) {
      $return['page_h1'] = $matches[1];
    }

    return $return;
  }
}

if (!function_exists('get_page_h1')) {
  $page_h1s = [];

  function get_page_h1($page) {
    global $page_h1s;

    if (isset($page_h1s[$page])) {
      return $page_h1s[$page];
    }

    $page_path = find_page_path($page);

    if (!$page_path) {
      return $page_h1s[$page] = '(no page)';
    }

    extract(parse_page($page_path));

    if (!isset($page_h1)) {
      return $page_h1s[$page] = '(no title)';
    }

    return $page_h1s[$page] = $page_h1;
  }
}

$page = 'index';

if (isset($_GET['page']) && strlen($_GET['page']) > 1) {
  $page = substr($_GET['page'], 1); // Starting at offset 1 because 0 is a slash.
}

/* When included by generate_static_files.php */
if (isset($static_filename)) {
  $page = substr($static_filename, 0, -strlen('.html'));
}

$page_path = find_page_path($page);

if (!$page_path) {
  $page = '404';
  $page_path = 'pages/404.html';
  header('HTTP/1.1 404 Not Found');
}

extract(parse_page($page_path));
?>
<!doctype html>
<meta charset="utf-8">
<?php if (isset($page_title)): ?>
<title><?= $page_title ?></title>
<?php endif ?>
<meta name="viewport" content="width=768">
<style><?= $style ?></style>
<?php if (isset($page_description)): ?>
<meta name="description" content="<?= $page_description ?>">
<?php endif ?>
<?php if ($page != '404'): ?>
<link rel="canonical" href="http://instantclick.io/<?php if ($page != 'index') { echo $page; } ?>">
<?php endif ?>

<header id="header">
  <div class="logo"><a href="/">InstantClick</a></div>
  <ul>
    <li><a href="/documentation">Documentation</a>
    <li><a href="/click-test">Click test</a>
  </ul>
</header>
<article class="container">
<?php eval('?>' . $page_content) ?>
</article>
<div id="footer">
  <p>InstantClick is released under the <a href="/license">MIT License</a> © 2014–<?= date('Y') ?> Alexandre Dieulot
  <p>You can <a href="https://github.com/dieulot/instantclick-website">contribute to this site</a> on GitHub.
</div>
<script src="script-7.js" data-no-instant></script>
