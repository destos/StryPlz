<?php $story_route = Route::get('stories');

echo '<li>'.HTML::anchor( $story_route->uri(), __('Stories') ).'</li>';

?>