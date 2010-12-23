<div id="directions">

	<div id="start" class="direction">
		<h2>to Start a Story</h2>
		<ol>
			<li>txt <strong>"start 20 The start of your story here"</strong> to <em><?php echo Kohana::config('twilio.AppNumber'); ?></em>. This will start a new story with 20 turns and add "The start of your story here" as the first part.</li>
			<li>To have your friends continue the story or add to it on your own <a href="#join">continue onto the next step &rarr;</a></li>
		</ol>
	</div>
	
	<div id="join" class="direction">
		<h2>to Add to a Story</h2>
		<ol>
			<li>txt <strong>"join (story number)"</strong> to <em><?php echo Kohana::config('twilio.AppNumber'); ?></em></li>
			<li>Read the most recent additions.</li>
			<li>Reply with your addition to the story.</li>
		</ol>
	</div>
	
	<div id="newsletter">
		<h2>Keep in Contact</h2>
		<ul>
			<li><a href="http://eepurl.com/b4I3j" target="_blank">Signup for the newsletter to receive updates on new features!</a></li>
			<li><a href="mailto:patrick+stryplz@forringer.com?subject=StryPlz">Send me an email if you have any suggestions or problems.</a></li>
		</ul>
	</div>
	
</div>