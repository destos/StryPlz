<?php $prep_json = $story->as_array();
//unset current teller so it isn't sent
unset( $prep_json['curr_teller'] );
?>

		<div class="story" id="story-<?php echo $story->id?>" data-info='<?php echo json_encode($prep_json) ?>'>
			
			<div class="info-bar"><?php echo HTML::anchor( Route::get('story')->uri(array( 'slug' => $story->slug )), 'link' ); ?></div>
			
			<p><?php
			
			
			foreach( $story->get_parts() as $part ){
				$prep_json = $part->as_array();
				
				/*
$out = '';
				
				foreach( Date::span( $prep_json['added'], null, 'years,months,weeks,days,hours,minutes,seconds' ) as $ts => $t ){
					if( !empty($t) )
					$out .= $t.' '.$ts.' ';
				}
				
				$prep_json['relative'] = $out;
*/
				
				$prep_json['relative'] = Date::fuzzy_span( $prep_json['added'] );
				
				unset( $prep_json['text'], $prep_json['SmsSid'] );
				
				?><span data-info='<?php echo json_encode($prep_json) ?>' ><?php echo $part ?></span> <?php
			}
			if( !(bool)$story->locked and !(bool)$story->cur_teller ){
				?><strong>( txt <?php echo Kohana::config('twilio.AppNumber') ?> with "join <?php echo $story->id ?>" to add to this story )</strong><?php 
			}else if((bool)$story->cur_teller ){
				?><strong>( Someone is currently adding to this story, please wait. )</strong><?php
			}else{
				?><strong>( The End )</strong><?php
			}
			?></p>
		
		</div>
		