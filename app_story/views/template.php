<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php echo (@$title) ? $title. ' | ' : null ; ?>StryPLz</title>
	
<!-- Styles -->
<?php
if (!empty($styles))
echo asset::stylesheets($styles); ?>
<!-- Scripts -->
<?php
if (!empty($scripts))
echo asset::javascripts($scripts); ?>

	<link rel="shortcut icon" href="<?php echo URL::base()?>favicon.ico" />
<?php if(!empty($feed_link))
echo '<link rel="alternate" type="application/rss+xml" title="'.ucfirst( $type ).' Listing Feed" href="'.$feed_link.'" />'
?>
	
</head>
<body>

<div id="topbar">
	<div class="wrap">
	
		<h1><?php echo HTML::anchor( Route::get('default')
			->uri(array(
				'controller' => null,
				'action'     => null,)
			),
			'StryPlz',
			array('title'=> __('go home') ) );
			
		?></h1>
		
<?php echo View::factory('nav/top'); ?>
			
	</div>
</div>

<div id="main" class="wrap" >
<!-- Content -->
	<div id="content">
	<?php if(!empty($content)) echo $content;?>
	<div class="clear"></div>
	<?php
	// output profiler stats when not in production.
	if( Kohana::$environment == Kohana::DEVELOPMENT )
	echo View::factory('profiler/stats');
	?>
	
		<div class="clear"></div>
	</div><!-- end #content -->
	
	</div>

</div>

</div><!-- end Content -->

<div id="footer">
	<div class="wrap">
		<p class="copyright">&copy; 2010 StryPLz <strong>{memory_usage} used | in {execution_time}</strong></p>
		<p class="powered">Powered by <?php echo HTML::anchor('http://kohanaphp.com/', 'Kohana') ?> v<?php echo Kohana::VERSION.' '.Kohana::CODENAME ?> | App v<?php echo Kohana::APP_VERSION ?></p>
	</div>
</div>

<?php if(  Kohana::$environment !== Kohana::DEVELOPMENT  ): // Load google analytics when on live site. ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20289085-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php endif; ?>

</body>
</html>
