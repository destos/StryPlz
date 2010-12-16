<?php
//$default_route = Route::get('default');
$account_route = Route::get('default');

/*
if( Auth::instance()->logged_in() ){

	$my_profile = Auth::instance()->get_user();
	
	// #TODO get real message count
	$number_of_messages = rand(1,40);
	
	$my_profile_route = Route::get('profile')->uri(array( 'slug' => $my_profile->slug )); //'id'=> $my_profile->id,
	
	echo '<li>'.HTML::anchor( $my_profile_route, __('my profile') ).'</li>';
	
	echo '<li>'.HTML::anchor( $account_route->uri( array( 'action' => null ) ), __('manage account') ).'</li>';
	
	echo '<li>'.HTML::anchor( $account_route->uri( array( 'action' => 'inbox' ) ), '<span class="num">'.$number_of_messages.'</span> '.__('messages') ).'</li>';
	
	echo '<li class="signout">'.HTML::anchor( $account_route->uri( array( 'action'=>'signout') ), __('sign out') ).'</li>';
	// show number of messages.
	
}else{
*/
	echo '<li>'.HTML::anchor( $account_route->uri( array( 'action' => 'signin' ) ), __('sign in') ).'</li>';
	
	echo '<li>'.HTML::anchor( $account_route->uri( array( 'action' => 'register' ) ), __('register') ).'</li>';
/* } */
?>