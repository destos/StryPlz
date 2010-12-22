<div class="story" id="story-<?php echo $story->id?>" data-id="<?php echo $story->id?>" data-slug="<?php echo $story->slug?>" data-time="<?php echo $story->started?>" >
<?php echo HTML::anchor( Route::get('story')->uri(array( 'slug' => $story->slug )), 'Story Link' );?>
<div class="info-bar">
	<span><?php echo $story->parts->count_all();?> Contributions</span>
</div>
<p><?php// echo $story;?>
<?php
$parts = $story->get_parts();
foreach( $parts as $part ){
	?><span class="part" data-time="<?php echo $part->added ?>" ><?php echo $part ?></span> <?php
}
?></p>
</div>