<?php

if($front_page)
	echo View::factory('directions');

foreach( $stories as $story ): 
	echo View::factory('story/single')->set('story', $story);
endforeach;

echo $pagination;