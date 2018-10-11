<? include_once("./head.php"); ?>
<!-- Start of first page: #one -->



<div data-role="page" id="one">

	<div data-role="header">
		<h1>Multi-page</h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		<h2>One</h2>

		<p>I have an <code>id</code> of "one" on my page container. I'm first in the source order so I'm shown when the page loads.</p>

		<p>This is a multi-page boilerplate template that you can copy to build your first jQuery Mobile page. This template contains multiple "page" containers inside, unlike a single page template that has just one page within it.</p>
		<p>Just view the source and copy the code to get started. All the CSS and JS is linked to the jQuery CDN versions so this is super easy to set up. Remember to include a meta viewport tag in the head to set the zoom level.</p>
		<p>You link to internal pages by referring to the <code>id</code> of the page you want to show. For example, to <a href="#two">link</a> to the page with an <code>id</code> of "two", my link would have a <code>href="#two"</code> in the code.</p>

		<h3>Show internal pages:</h3>
		<!-- <p><a href="#two" class="ui-btn ui-shadow ui-corner-all">Show page "two"</a></p>
		<p><a href="#popup" class="ui-btn ui-shadow ui-corner-all" data-rel="dialog" data-transition="pop">Show page "popup" (as a dialog)</a></p>
	
	 -->
	<a href="notice_list.php" data-rel="back" class="ui-btn ui-shadow ui-corner-all ui-btn-a">Cancel</a>
	
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page one -->



<? 
include_once("./foot.php");

?>
