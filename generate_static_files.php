<?php
function generate($dir) {
  $handle = opendir($dir);
  while ($file = readdir($handle)) {
    if ($file[0] == '.') {
      continue;
    }
    if (is_dir($dir . '/' . $file)) {
      generate($dir . '/' . $file);
      continue;
    }
    $path = $dir . '/' . $file;

    $path_exploded = explode('/', $path);
    $static_filename = $path_exploded[count($path_exploded) - 1];
    $output_path = 'output/' . $static_filename;

    echo ' Generate ' . $static_filename . PHP_EOL;
    ob_start();
    include('index.php');
    $contents =  ob_get_contents();
    ob_end_clean();
    file_put_contents($output_path, $contents);
  }
  return false;
}

generate('pages');
