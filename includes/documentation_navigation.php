<?
require('documentation_order.php');

/* Find previous and next chapter */

if (!isset($documentation_chapters)) {
  $documentation_chapters = [];
  foreach ($documentation_order as $title => $chapters) {
    foreach ($chapters as $chapter) {
      $documentation_chapters[] = $chapter;
    }
  }
}

$prev = false;
$next = false;

for ($i = 0; $i < count($documentation_chapters); $i++) {
  if ($documentation_chapters[$i] == $page) {
    if (isset($documentation_chapters[$i - 1])) {
      $prev = $documentation_chapters[$i - 1];
    }
    if (isset($documentation_chapters[$i + 1])) {
      $next = $documentation_chapters[$i + 1];
    }
    break;
  }
}
?>
<p class="prev-next">
<? if ($next): ?>
  <a class="next" href="/<?= $next ?>"><?= get_page_h1($next) ?></a>
<? endif ?>
<? if ($prev): ?>
  <a class="prev" href="/<?= $prev ?>"><?= get_page_h1($prev) ?></a>
<? else: ?>
  <a class="prev" href="/documentation">Documentation</a>
<? endif ?>

<div class="toc">
  <h3>Documentation table of contents</h3>

<? foreach ($documentation_order as $title => $chapters): ?>
  <h4><?= $title ?></h4>
  <div class="chapters">
<? $i = 0;
foreach ($chapters as $chapter): ?>
    <li>
      <?= ++$i ?>.
<? if ($chapter == $page): ?>
      <?= get_page_h1($chapter) ?>
<? else: ?>
      <a href="/<?= $chapter ?>"><?= get_page_h1($chapter) ?></a>
<? endif ?>
<? endforeach ?>
  </div>
<? endforeach ?>
</div>