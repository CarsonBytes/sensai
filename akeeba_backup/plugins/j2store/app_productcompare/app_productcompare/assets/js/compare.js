/**
 * Setup (required for Joomla! 3)
 */
if(typeof(j2store) == 'undefined') {
	var j2store = {};
}
if(typeof(j2store.jQuery) == 'undefined') {
	j2store.jQuery = jQuery.noConflict();
}

if(typeof(j2storeURL) == 'undefined') {
	var j2storeURL = '';
}


function addToCompare(element) {
	(function($) {
		$('.j2store-compare-notify').remove();
		var thisElement = $(element);
		var product_id = $(thisElement).data('compare-product-id');
		
		var form = $(element).closest('form');		
		//sanity check
		//if(form.data('product_id') != product_id) return;
		if(form.data('product_type') == 'variable') {
			var variant_id = form.find('input[name=\'variant_id\']').val();			
		}else {
			var variant_id = $(thisElement).data('compare-variant-id');
		}
		var aid = $(thisElement).data('compare-id');		
		
		var j2Ajax = jQuery.ajax({
			url : 'index.php',
			type : 'post',
			data : {
				'option' : 'com_j2store',
				'view' : 'apps',
				'task' : 'view',
				'appTask' : 'addcompare',
				'id' : aid,				
				'variant_id' : variant_id,
				'product_id' : product_id
			},
			dataType : 'json'
		});

		j2Ajax.done(function(json) {
			//on success will change the current element's class , link, text
			if (json['success']) {				
				$(thisElement).attr('href',$(thisElement).data('compare-link'));				
				var icon = $(thisElement).data('icon-after-add');
				if(icon !=''){
						$(thisElement).html('<i class="fa '+ icon +'"></i>'+$(thisElement).data('compare-action-done'));		
					}else{
						$(thisElement).html('<i class="fa fa-retweet"></i>'+$(thisElement).data('compare-action-done'));
					}
				
				$(thisElement).removeClass('product-compare-link');
				$(thisElement).addClass('product-view-compare-list');
					
				if($(thisElement).data('compare-show-messgage')){
					$(thisElement).before(
							'<span class="j2store-compare-notify"><a class="text text-success" href="'
									+ $(thisElement).data('compare-link') + '" >'
									+ $(thisElement).data('compare-show-messgage-text')
									+ '</a><br /></span>');		
				}
			}
			
			//incase any error will notice the customer
			if (json['error']) {
				
				//if exists 
				if(json['exists']){
						$(thisElement).attr('href',$(thisElement).data('compare-link'));				
						$(thisElement).html('<i class="fa fa-list"></i>'+$(thisElement).data('compare-action-done'));
				}
				
				$(thisElement).before(
								'<span class="j2store-compare-notify"><a class="text text-error" href="'
										+ $(thisElement).data('compare-link') + '" >'
										+ json['error']
										+ '</a><br /></span>');
				
			}
		});

	})(j2store.jQuery);

}


function removeFromCompare(element) {
	(function($) {
		$('.j2store-compare-notify').remove();
		var aid = $(element).data('compare-id');	
		var thisElement = $(element);
		var product_id = $(thisElement).data('compare-product-id');
		var variant_id = $(thisElement).data('compare-variant-id');			
		var j2Ajax = jQuery.ajax({
			url : 'index.php',
			type : 'post',
			data : {
				'option' : 'com_j2store',
				'view' : 'apps',
				'task' : 'view',						
				'appTask' : 'removeCompare',
				'id' : aid,
				'variant_id' : variant_id,
				'product_id' : product_id
			},
			dataType : 'json'

		});

		j2Ajax.done(function(json) {
			if (json['success']) {
				location.reload();
			}
			// $('#j2store-product-compare-'+product_id).remove();
		});

	})(j2store.jQuery);

}

/*
 * Method to clear all compare list
 *
 */
function j2storeClearAllcompare(element){
	(function($){
		var thisElement = $(element);
		$.ajax({
				type : 'post',
				url :'index.php',
				dataType:'json',
				data :{'option':'com_j2store' ,'view':'apps' ,'task':'view' ,'appTask':'clearAlllist','id' :$(thisElement).data('compare-id') },
				success:function(json){
					if(json['success']){
						location.reload();
					}
					
					if(json['error']){
						$('#system-message-container').append('<p class="text text-error">'+json['error'] +'</p>');
					}
				}
		});
	})(j2store.jQuery);
}
