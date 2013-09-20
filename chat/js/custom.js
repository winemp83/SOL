/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Overriding client side functionality:

/*
// Example - Overriding the replaceCustomCommands method:
ajaxChat.replaceCustomCommands = function(text, textParts) {
	return text;
}
 */

ajaxChat.replaceCustomCommands = function(text, textParts) {
	switch(textParts[0]) {
		case '/takeover':
		text=text.replace('/takeover', ' ');
		return '<span class="chatBotMessage">' + text + '</span>';
		default:
		return text;
	}
}