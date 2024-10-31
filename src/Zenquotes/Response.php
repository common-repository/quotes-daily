<?php
/**
 * This file is part of the Somebody's Daily Quotes plugin.
 *
 * (c) Somebodymz <somebody.mz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Smz\WpQuotes\Zenquotes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Response {

	/**
	 * Quote text.
	 *
	 * @var string
	 */
	public string $q;

	/**
	 * Author name.
	 *
	 * @var string
	 */
	public string $a;

	/**
	 * Author image (key required).
	 *
	 * @var string
	 */
	public string $i;

	/**
	 * Character count.
	 *
	 * @var string
	 */
	public string $c;

	/**
	 * Pre-formatted HTML quote.
	 *
	 * @var string
	 */
	public string $h;
}
