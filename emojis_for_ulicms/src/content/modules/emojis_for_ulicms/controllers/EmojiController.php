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
		@$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

		$checkbox = $dom->getElementById(PrivacyCheckbox::CHECKBOX_NAME);
		if($checkbox){
			$oldValue = $checkbox->getAttribute("value");
			$newValue = '##Check##';
			$checkbox->setAttribute("value", $newValue);
		}
		$html = str_replace('<?xml encoding="UTF-8">', '', $dom->saveHTML($dom->documentElement));
		
		$html = emoji_unified_to_html($html);
		
		if($checkbox){
			$dom = new DOMDocument();
			@$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$checkbox = $dom->getElementById(PrivacyCheckbox::CHECKBOX_NAME);
			$checkbox->setAttribute("value", $oldValue);
			$html = $dom->saveHTML($dom->documentElement);
		}
		$outputHtml = str_replace('<?xml encoding="UTF-8">', '', $html);
		return $outputHtml;
	}
}
