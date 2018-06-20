<?php
class EmojiController extends Controller {
	public function head() {
		echo Template::executeModuleTemplate ( "emojis_for_ulicms", "head" );
	}
	public function adminHead() {
		$this->head ();
	}
	public function contentFilter($input) {
		$html = mb_convert_encoding($input, 'HTML-ENTITIES', 'UTF-8');
		// Create a new DOM document
		$dom = new DOMDocument('1.0', 'UTF-8');
		// Parse the HTML. The @ is used to suppress any parsing errors
		// that will be thrown if the $html string isn't valid XHTML.
		@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

		$checkbox = $dom->getElementById(PrivacyCheckbox::CHECKBOX_NAME);
		if($checkbox){
			$oldValue = $checkbox->getAttribute("value");
			$newValue = '##Check##';
			$checkbox->setAttribute("value", $newValue);
		}
		$html = $dom->saveHTML($dom->documentElement);
		
		$html = emoji_unified_to_html($html);
		
		if($checkbox){
			$dom = new DOMDocument('1.0', 'UTF-8');
			@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$checkbox = $dom->getElementById(PrivacyCheckbox::CHECKBOX_NAME);
			$checkbox->setAttribute("value", $oldValue);
			$html = $dom->saveHTML($dom->documentElement);
		}
		return $html;
	}
}
