<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<h2 class="sp-header">Chart Detail</h2>
<div class="detail data-detail">
	
	<?php // if (function_exists('the_subheading')) { the_subheading('<h1>', '</h1>'); } ?>

<?php 


$charttitle = get_post_meta($post->ID, '_subheading', true);

$chartsub = get_post_meta($post->ID, '_subheading', true) ? get_the_title() : '';

$charttitle = $charttitle ? $charttitle : get_the_title();



 ?>


<div class="chart">

<!-- <h2><?php the_title(); ?></h2> -->
<!-- <h1><?php echo $charttitle; ?></h1> -->
<!-- <h2><?php echo $chartsub; ?></h2> -->



<?php get_template_part('content', 'chart'); ?>



<?php 


if( true || isset($_GET['shownotes']) || is_user_logged_in() ) {

	$label = get_epi_chart('label');

	// Get the notes file
	$text = file_get_contents( get_template_directory_uri() . "/_notes.txt" );

	// Find this chart's note, based on its label
	$note = preg_match("/<strong>".$label.".*?<strong>/is", $text, $matches);
	$note = $matches[0];
	$note = preg_replace('/<strong>.*<\/strong>/i', "", $note);

	// Replace chart references with shortcodes
	$note = preg_replace('/(Table (\d\.\d+))/i', '[chartlink number="$2"]$1[/chartlink]', $note);
	$note = preg_replace('/(Figure (\d[a-zA-Z]+))/i', '[chartlink number="$2"]$1[/chartlink]', $note);

	if ($note) {
		echo '<h3>Documentation and methodology</h3>';
		echo do_shortcode( wpautop($note) );
	}
}



 ?>


<?php 

	$Chart_URL = get_post_meta($post->ID, 'Chart_URL', true);
	$Cropped_Chart_URL = get_post_meta($post->ID, 'Chart_Cropped_URL', true);
?>


<!-- <a href="<?php echo $Chart_URL; ?>"> -->
<!-- <img src="/m/?src=<?php echo $Cropped_Chart_URL; ?>&w=640" width="640" alt="Chart: <?php the_title_attribute(); ?>" /></a>					 -->
</div>
<div class="source">
	Updated <?php the_date(); ?>
</div>

<?php if ( $sub = get_the_terms( $post->ID, 'indicator', '', ', ', ' ' ) ) { ?>	
	<div class="meta">
		<ul>
			<li>
				This <?php the_terms( $post->ID, 'indicator', '', ', ', ' ' ); ?> chart is an <a href="/economic-indicators/">Economic Indicator</a>, updated when new data are released. Data are current as of <?php echo get_the_date(); ?>.
			</li>
		</ul>
	</div>
<?php } ?>



<?php if ( $sub = get_the_terms( $post->ID, 'subject', '', ', ', ' ' ) ) { ?>	
	<div class="meta">
		<h4>Subject</h4>
		<ul>
			<li>
				<?php the_terms( $post->ID, 'subject', '', ', ', ' ' ); ?>
			</li>
		</ul>
	</div>
<?php } ?>

<?php if ( $dem = get_the_terms( $post->ID, 'demographic', '', ', ', ' ' ) ) { ?>	
	<div class="meta">
		<h4>Demographic</h4>
		<ul>
			<li>
				<?php the_terms( $post->ID, 'demographic', '', ', ', ' ' ); ?>
			</li>
		</ul>
	</div>
<?php } ?>

<?php if ( $feature = get_the_terms( $post->ID, 'feature', '', ', ', ' ' ) ) { ?>	
	<div class="meta">
		<ul>This chart is part of the
		<li><strong><?php the_terms( $post->ID, 'feature', '', ', ', ' ' ); ?></strong></li> feature.</ul>
	</div>
<?php } ?>


</div>
<div class="utilities">
<!-- <div class="print-feature"></div> -->
<div class="download-share">

	<?php if ( has_term( array('wages', 'income', 'wages'), 'subject' ) ): ?>
		<span class="downloads"><a href="/data">Get the data</a></span>
	<?php endif ?>
		

<!-- <ul>  -->
<!--	<li><a href="#" class="pdf">PDF</a></li> -->
<!-- <li><a href="<?php echo get_post_meta($post->ID, "Excel_URL", true); ?>" class="excel">Excel</a></li> -->
<!-- <li><a href="<?php echo get_post_meta($post->ID, "Chart_URL", true); ?>" class="hires">Hi-Res</a></li> -->
<!-- </ul> -->
<!-- </span> -->
<!-- <span class="embed-feature"></span> -->
<span class="share-chart">Share: <a class="addthis_button" href="http://www.addthis.com/bookmark.php"><img src="http://s7.addthis.com/static/btn/sm-plus.gif" width="16" height="16" alt="Share" /></a></span>
</div>
</div>
</div>
<?php endwhile; ?>

<?php get_sidebar() ?>
<?php get_footer(); ?>