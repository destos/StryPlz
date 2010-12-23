<p class="pagination">

	<span class="prev"><?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><?php echo __('Previous') ?></a>
	<?php else: ?>
		<?php echo __('Previous') ?>
	<?php endif ?></span>

	<span class="next"><?php if ($next_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><?php echo __('Next') ?></a>
	<?php else: ?>
		<?php echo __('Next') ?>
	<?php endif ?></span>

</p><!-- .pagination -->