<?php
/*
Plugin Name: G11 AutoP
Plugin URI: https://github.com/gear11/G11Plugins
Description: Replaces WP's default auto-P behavior with a less aggressive one.
Version: 1.0.1
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 2
*/

const INLINE_TAGS = '(?:span|img|a)';

/**
 * Replaces 'intentional' newlines with breaks.  A newline is intentional if
 * it is preceded by a non <>, or a non-block tag (<a>, <img>...)
 *
 * @param $content
 * @param $br
 * @return mixed
 */
function g11_autop($content, $br=true) {
    if (!$br) {
        return $content;
    }
    // Cross-platform newlines
    $content = str_replace(array("\r\n", "\r"), "\n", $content);

    // TODO: Should join single tag that spans lines

    // Blank lines still get <p>
    $content = preg_replace('!\n\s*\n!', "<p></p>\n", $content);

    # Replace (nontag-or-<inline>)\n(nontag-or-<inline>) with (char-or-<inline>)<br>(char-or-<inline>)\n
    $pattern = '!([^<>]|<' . INLINE_TAGS . '[^>]*>)\n([^<>]|<' . INLINE_TAGS . ')!';
    $replacement = "$1<br>\n$2";
    $content =  preg_replace($pattern, $replacement, $content);
    return $content;
}

// Remove the default WP filter so it no longer runs
remove_filter( 'the_content', 'wpautop' );

// Run ours instead
add_filter( 'the_content', 'g11_autop' );