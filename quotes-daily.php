<?php
/*
Plugin Name:       Somebody's Daily Quotes
Plugin URI:        https://github.com/Somebodymz/wp-quotes
Description:       Provides famous quotes, quote of the day, and more for WordPress.
Version:           1.0
Requires at least: 6.0
Requires PHP:      8.2
Author:            Somebodymz
Author URI:        https://github.com/Somebodymz
License:           MIT
License URI:       https://opensource.org/licenses/MIT
*/

/**
 * This file is part of the Somebody's Daily Quotes plugin.
 *
 * (c) Somebodymz <somebody.mz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Smz\WpQuotes;

use Smz\WpQuotes\Zenquotes\Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';

add_shortcode( 'quote_daily', function ( $atts ) {
	$atts = shortcode_atts(
		[
			'show_author' => false,
		],
		$atts
	);

	/** @var Response[]|false $quote */
	$quote = get_transient( 'quote_daily' );

	if ( false === $quote ) {
		$quoteJson = wp_remote_get( 'https://zenquotes.io/api/today' );
		$quote = json_decode( $quoteJson['body'] );

		$currTime = time();
		$endOfDayTimestamp = strtotime( 'tomorrow', $currTime );
		$endOfDayInSeconds = $endOfDayTimestamp - $currTime;

		set_transient( 'quote_daily', $quote, $endOfDayInSeconds );
	}

	return renderTemplate( 'templates/quote.php', [
		'quote' => $quote[0]->q,
		'author' => $quote[0]->a,
		'showAuthor' => $atts['show_author'],
	] );
} );

add_shortcode( 'quote_random', function ( $atts ) {
	$atts = shortcode_atts(
		[
			'show_author' => false,
		],
		$atts
	);

	$quoteJson = wp_remote_get( 'https://zenquotes.io/api/random' );
	/** @var Response[]|false $quote */
	$quote = json_decode( $quoteJson['body'] );

	return renderTemplate( 'templates/quote.php', [
		'quote' => $quote[0]->q,
		'author' => $quote[0]->a,
		'showAuthor' => $atts['show_author'],
	] );
} );

/**
 * Renders templates.
 *
 * @param string $template Path to the template file.
 * @param array $vars Variables to be passed to the template file.
 *
 * @return string
 */
function renderTemplate( string $template, array $vars = [] ): string {
	$templateAbsPath = __DIR__ . '/' . ltrim( $template, '/' );

	$renderer = function (): void {
		extract( func_get_arg( 1 ) );
		require func_get_arg( 0 );
	};

	ob_start();

	if ( file_exists( $templateAbsPath ) ) {
		$renderer( $templateAbsPath, $vars );
	} else {
		echo esc_html( "Template $template not found." );
	}

	return ob_get_clean();
}
