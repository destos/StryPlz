<ul class="<?=(isset($navclass))? $navclass : 'nav'?>">
<? if( !empty($nav) ):

	foreach( $nav as $link => $text ):
				
		$class = ( strstr( $cur $link ) ) ? ' class="cur"' : '';
		$extra = '';
		
		if( is_array($text) ){
			list( $text , $extra ) = $text;
		}
		echo "\t<li$class>", is_int($link) ? $text : HTML::anchor($link, $text),"$extra</li>\n";
		
	endforeach;
	
else:

	echo "\t<li>no nav items</li>\n";
	
endif;
?>
</ul>