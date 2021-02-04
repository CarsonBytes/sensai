/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */
jQuery(document).ready(function ($) {
	jQuery.migrateMute = true;
	
	function reposition() {
		var modal = $(this),
			dialog = modal.find('.modal-dialog');
		modal.css('display', 'block');

		// Dividing by two centers the modal exactly, but dividing by three 
		// or four works better for larger screens.
		dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
	}

	// Reposition when a modal is shown
	$(document).on('show.bs.modal', '.modal', reposition)
	// Reposition when the window is resized
	$(window).on('resize', function() {
		$('.modal:visible').each(reposition);
	});

	/* // site preloader -- also uncomment the div in the header and the css style for #preloader
	$(window).load(function () {
		//$('#preloader').fadeOut('slow',function(){$(this).remove();});
	});*/

	$("div").filter(function () {
		return ($(this).text() === "FaLang translation system by Faboba" /* || $(this).text() === "Powered by BreezingForms" */);
	}).remove();

	$('.carousel_1').on('lazyloaded', function () {
		$('.carousel .carousel-indicators').show();
		$('.carousel').css('padding-top', 0);
	});
});
