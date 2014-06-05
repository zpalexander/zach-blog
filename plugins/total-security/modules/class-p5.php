<?php
include_once( ABSPATH . WPINC . '/wp-diff.php' );

if ( class_exists( 'Text_Diff_Renderer' ) ) :
class FDX_Text_Diff_Renderer extends Text_Diff_Renderer {
	function FDX_Text_Diff_Renderer() {
		parent::Text_Diff_Renderer();
	}
	function _startBlock( $header ) {
		return "<tr><td colspan='2'>&nbsp;</td></tr><tr><td colspan='2'><code>$header</code></td></tr>\n";
	}
	function _lines( $lines, $prefix, $class ) {
		$r = '';
		foreach ( $lines as $line ) {
			$line = esc_html( $line );
			$r .= "<tr><td><code>{$prefix}</code></td><td class='{$class}'>{$line}</td></tr>\n";
		}
		return $r;
	}
	function _added( $lines ) {
		return $this->_lines( $lines, '+', 'diff-addedline' );
	}
	function _deleted( $lines ) {
		return $this->_lines( $lines, '-', 'diff-deletedline' );
	}
	function _context( $lines ) {
		return $this->_lines( $lines, '', 'diff-context' );
	}
	function _changed( $orig, $final ) {
		return $this->_deleted( $orig ) . $this->_added( $final );
	}
}
endif;