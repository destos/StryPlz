<?php

foreach( $stories as $story ): 
?>

<?php echo HTML::anchor( Route::get('story')->uri(array( 'slug' => $story->slug )), 'Story Link' );?>
<p><?php echo $story;?></p>

<?php 
endforeach;

echo $pagination;