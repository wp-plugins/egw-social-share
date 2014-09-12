<!DOCTYPE html>

<html>
<head>
	<title>
		<?php
		global $wpdb, $page;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		?>
	</title>
	<meta name="robots" content="noindex,nofollow">
	
	<link rel="stylesheet" id="print-css" href='<?php echo plugins_url( '/css/print.css', __FILE__ ); ?>' type="text/css" media="all">
<script language="javascript">
	function printdiv(printpage)
	{
		var headstr = "<html><head><title><?php the_title(); ?></title></head><body>";
		var footstr = "</body>";
		var newstr = document.all.item(printpage).innerHTML;
		var oldstr = document.body.innerHTML;
		document.body.innerHTML = headstr+newstr+footstr;
		window.print();
		document.body.innerHTML = oldstr;
		return false;
	}
	
</script>

</head>

<body>
<div id="print"><a href="#" onClick="printdiv('content');">print</a></div><br>
<br>

<div id="content" class="clearfix">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) : the_post();
			?>
			<div id="article">
            <div class="clearfix"></div>
				<h1 class="article-title"><?php the_title(); ?></h1>
				<div class="article-content"><?php the_content(); ?></div>
			</div>
            
		<?php
		endwhile;
	}
	?>
    <div id="footer" class="clearfix">Copyright &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></div>
</div>
<br>


<div id="print"><a  href="#" onClick="printdiv('content');">print</a></div>
</body>
</html>