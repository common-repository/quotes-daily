<?php
/**
 * @var string $quote
 * @var string $author
 * @var bool $showAuthor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="quotes-daily qd-daily">
	<blockquote><?php echo esc_html( $quote ); ?></blockquote>
	<?php if ( $showAuthor ): ?>
		<small><?php echo esc_html( $author ); ?></small>
	<?php endif; ?>
</div>
