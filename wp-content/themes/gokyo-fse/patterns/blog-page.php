<?php
 /**
  * Title: Blog Page
  * Slug: gokyo-fse/blog-page
  * Categories: gokyo-fse
  */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"blockGap":"0px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:pattern {"slug":"gokyo-fse/cover-with-post-title"} /-->

<!-- wp:group {"tagName":"main","align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"30px","right":"30px"}}},"backgroundColor":"background","className":"no-margin no-padding","layout":{"inherit":true,"type":"constrained"}} -->
<main class="wp-block-group alignfull no-margin no-padding has-background-background-color has-background" style="padding-top:80px;padding-right:30px;padding-bottom:80px;padding-left:30px"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"60px"}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"","style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<div class="wp-block-column" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:query {"queryId":1,"query":{"perPage":"8","pages":"","offset":"","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"tagName":"main","displayLayout":{"type":"list","columns":3},"align":"wide","layout":{"inherit":false}} -->
<main class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"className":"has-no-hover-box-shadow ","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group has-no-hover-box-shadow" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"align":"wide","className":"no-padding image-zoom-hover"} /-->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"40px","right":"40px","bottom":"40px","left":"40px"},"margin":{"top":"0px"},"blockGap":"10px"}},"backgroundColor":"background-secondary"} -->
<div class="wp-block-group alignwide has-background-secondary-background-color has-background" style="margin-top:0px;padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px"><!-- wp:post-title {"level":3,"isLink":true,"align":"wide","style":{"typography":{"fontStyle":"normal","fontWeight":"600","lineHeight":"1.4","fontSize":"1.3rem"}}} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->


<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","align":"center","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous {"fontSize":"small"} /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next {"fontSize":"small"} /-->
<!-- /wp:query-pagination --></main>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:template-part {"slug":"sidebar","theme":"gokyo-fse","tagName":"div"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></main>
<!-- /wp:group --></div>
<!-- /wp:group -->