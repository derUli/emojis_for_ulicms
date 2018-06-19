<?php
class EmojiController extends Controller {
	public function head() {
		echo Template::executeModuleTemplate ( "emojis_for_ulicms", "head" );
	}
	public function adminHead() {
		$this->head ();
	}
	public function contentFilter($input) {
		$html = trim($input);
		// Create a new DOM document
		$dom = new DOMDocument();
			// Parse the HTML. The @ is used to suppress any parsing errors
			// that will be thrown if the $html string isn't valid XHTML.
		@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

		$xpath = new DOMXPath($dom);
		$textnodes = $xpath->query('//text()');
		foreach($textnodes as $node) {
			$node->textContent = emoji_unified_to_html($node->textContent);
		}

		return emoji_unified_to_html ( $dom->saveHTML() );
	}
}