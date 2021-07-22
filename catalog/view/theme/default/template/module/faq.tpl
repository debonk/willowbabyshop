<div class="panel panel-default">
  <div class="panel-heading"><b><?php echo $heading_title; ?></b></div>
  <div class="list-group">
    <?php foreach ($faqs as $faq) { ?>
    <?php if ($faq['faq_id'] == $topic_id) { ?>
    <a href="<?php echo $faq['href']; ?>" class="list-group-item active"><?php echo $faq['title']; ?></a>
    <?php if ($faq['children']) { ?>
    <?php foreach ($faq['children'] as $child) { ?>
    <?php if ($child['faq_id'] == $child_id) { ?>
    <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['title']; ?></a>
    <?php } else { ?>
    <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['title']; ?></a>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <?php } else { ?>
    <a href="<?php echo $faq['href']; ?>" class="list-group-item"><?php echo $faq['title']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
</div>
