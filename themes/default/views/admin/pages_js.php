<?php
/**
 * Pages js file.
 *
 * Handles javascript stuff related to pages function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Pages Javascript
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
// Pages JS
function fillFields(id, page_title, page_tab,
 page_description )
{
	$("#page_id").attr("value", unescape(id));
	page_title = decodeURIComponent(escape($.base64.decode(page_title)));
	$("#page_title").attr("value", unescape(page_title));
	page_tab = decodeURIComponent(escape($.base64.decode(page_tab)));
	$("#page_tab").attr("value", unescape(page_tab));
	page_description = decodeURIComponent(escape($.base64.decode(page_description)));
	$("#page_description").attr("value", unescape(page_description));
	tinyMCE.getInstanceById("page_description").setContent(unescape(page_description));
}

// Ajax Submission
function pageAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('ui_admin.are_you_sure_you_want_to'); ?> ' + confirmAction + '?')
	if (answer){
		// Set Category ID
		$("#page_id_action").attr("value", id);
		// Set Submit Type
		$("#action").attr("value", action);		
		// Submit Form
		$("#pageListing").submit();
	}
}




		// Initialize tinyMCE Wysiwyg Editor
		tinyMCE.init({
		convert_urls : false,
		relative_urls : false,
		mode : "exact",
		height: "400px",
		width: "875px",
		elements : "page_description",
		theme : "advanced",
		plugins : "pagebreak,advhr,advimage,advlink,iespell,inlinepopups,contextmenu,paste,directionality,noneditable,advlist",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "cut,copy,paste,pastetext,pasteword,|,hr,removeformat,visualaid,|,sub,sup,|,advhr,|,ltr,rtl",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		file_browser_callback : "ajaxfilemanager"
		});
		
		
	function ajaxfilemanager(field_name, url, type, win) {
		var ajaxfilemanagerurl = "<?php echo url::site(); ?>media/js/tinymce/plugins/ajaxfilemanager/ajaxfilemanager.php?editor=tinymce";
		switch (type) {
			case "image":
			break;
			case "media":
			break;
			case "flash":
			break;
			case "file":
			break;
			default:
			return false;
		}
		var fileBrowserWindow = new Array();
		fileBrowserWindow["file"] = ajaxfilemanagerurl;
		fileBrowserWindow["title"] = "Ajax File Manager";
		fileBrowserWindow["width"] = "782";
		fileBrowserWindow["height"] = "440";
		fileBrowserWindow["close_previous"] = "no";
		/*
		tinyMCE.openWindow(fileBrowserWindow, {
			window : win,
			input : field_name,
			resizable : "yes",
			inline : "yes",
			editor_id : tinyMCE.getWindowArg("editor_id")
		});
		*/
		
		
		tinyMCE.activeEditor.windowManager.open({
			file : ajaxfilemanagerurl,
			title : 'File Browser',
			width : 782,  // Your dimensions may differ - toy around with them!
			height : 440,
			resizable : "yes",
			inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
			close_previous : "no"
		}, {
			window : win,
			input : field_name
		});

		return false;
	}