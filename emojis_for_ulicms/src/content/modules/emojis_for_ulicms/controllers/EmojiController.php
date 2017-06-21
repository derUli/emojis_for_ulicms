<?php
class EmojiController extends Controller{
	public function head() {
		echo Template::executeModuleTemplate ( "emojis_for_ulicms", "head" );
	}
	public function contentFilter($text) {
		return emoji_unified_to_html ( $text );
	}
}