<?= $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?= $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?= $class; ?>"><?= $content_top; ?>
      <!-- <h1><?= $heading_title; ?></h1> -->
      <?= $content_bottom; ?></div>
    <?= $column_right; ?></div>
</div>
<?= $footer; ?>