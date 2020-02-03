

/*===============================
/craft_1/media/j2store/js/j2store.js
================================================================================*/;
if(typeof(j2store)=='undefined'){var j2store={};}
if(typeof(j2store.jQuery)=='undefined'){j2store.jQuery=jQuery.noConflict();}
if(typeof(j2storeURL)=='undefined'){var j2storeURL='';}
(function($){$(document).on('click','.j2store_add_to_cart_button',function(e){var $thisbutton=$(this);if(!$thisbutton.attr('data-product_id'))
return true;$thisbutton.removeClass('added');$thisbutton.addClass('loading');var data={option:'com_j2store',view:'carts',task:'addItem',ajax:'1',};$.each($thisbutton.data(),function(key,value){data[key]=value;});$('body').trigger('adding_to_cart',[$thisbutton,data]);var href=$thisbutton.attr('href');if(typeof href!=='undefined'||href==''){href='index.php';}
$.post(href,data,function(response){if(!response)
return;var this_page=window.location.toString();this_page=this_page.replace('add-to-cart','added-to-cart');if(response['error']){window.location=response.product_url;return;}
if(response['redirect']){window.location.href=response['redirect'];return;}
if(response['success']){$thisbutton.removeClass('loading');$thisbutton.addClass('added');$thisbutton.parent().find('.cart-action-complete').show();$('body').trigger('after_adding_to_cart',[$thisbutton,response,'link']);}},'json');return false;return true;});})(j2store.jQuery);(function($){$(document).ready(function(){$('.j2store-addtocart-form').each(function(){$(this).submit(function(e){e.preventDefault();var form=$(this);form.find('input[name=\'ajax\']').val(1);var values=form.find('input[type=\'text\'], input[type=\'number\'], input[type=\'hidden\'], input[type=\'radio\']:checked, input[type=\'checkbox\']:checked, select, textarea');form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-always'));var href=form.attr('action');if(typeof href=='undefined'||href==''){var href='index.php';}
var j2Ajax=$.ajax({url:href,type:'post',data:values,dataType:'json'});j2Ajax.done(function(json){form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();$('.j2store-notification').hide();if(json['error']){form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));if(json['error']['option']){for(i in json['error']['option']){form.find('#option-'+i).after('<span class="j2error">'+json['error']['option'][i]+'</span>');}}
if(json['error']['stock']){form.find('.j2store-notifications').html('<span class="j2error">'+json['error']['stock']+'</span>');}
if(json['error']['general']){form.find('.j2store-notifications').html('<span class="j2error">'+json['error']['general']+'</span>');}
if(json['error']['product']){form.find('.j2store-notifications').after('<span class="j2error">'+json['error']['product']+'</span>');}}
if(json['redirect']){window.location.href=json['redirect'];}
if(json['success']){setTimeout(function(){form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));form.find('.cart-action-complete').fadeIn('slow');},form.find('input[type=\'submit\']').data('cart-action-timeout'));$('body').trigger('after_adding_to_cart',[form,json,'normal']);}}).fail(function(jqXHR,textStatus,errorThrown){form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));console.log(textStatus+errorThrown);}).always(function(jqXHR,textStatus,errorThrown){});});});});})(j2store.jQuery);(function($){$(document).ready(function(){if($('#j2store_shipping_make_same').length>0){if($('#j2store_shipping_make_same').is(':checked')){$('#j2store_shipping_section').css({'visible':'visible','display':'none'});$('#j2store_shipping_section').children(".input-label").removeClass("required");$('#j2store_shipping_section').children(".input-text").removeClass("required");}}});})(j2store.jQuery);function doMiniCart(){(function($){var murl=j2storeURL
+'index.php?option=com_j2store&view=carts&task=ajaxmini';$.ajax({url:murl,type:'get',cache:false,contentType:'application/json; charset=utf-8',dataType:'json',success:function(json){if(json!=null&&json['response']){$.each(json['response'],function(key,value){if($('.j2store_cart_module_'+key).length){$('.j2store_cart_module_'+key).each(function(){$(this).html(value);});}});}}});})(j2store.jQuery);}
function j2storeDoTask(url,container,form,msg,formdata){(function($){container='#'+container;if(url&&form){var str=$(form).serialize();$.ajax({url:url,type:'get',cache:false,contentType:'application/json; charset=utf-8',data:formdata,dataType:'json',beforeSend:function(){$(container).before('<span class="wait"><img src="'+j2storeURL+'media/j2store/images/loader.gif" alt="" /></span>');},complete:function(){$('.wait').remove();},success:function(json){if($(container).length>0){$(container).html(json.msg);}
return true;}});}else if(url&&!form){$.ajax({url:url,type:'get',cache:false,contentType:'application/json; charset=utf-8',data:formdata,dataType:'json',beforeSend:function(){$(container).before('<span class="wait"><img src="'+j2storeURL+'media/j2store/images/loader.gif" alt="" /></span>');},complete:function(){$('.wait').remove();},success:function(json){if($(container).length>0){$(container).html(json.msg);}}});}})(j2store.jQuery);}
function j2storeSetShippingRate(name,price,tax,extra,code,combined)
{(function($){$("input[type='hidden'][name='shipping_name']").val(name);$("input[type='hidden'][name='shipping_code']").val(code);$("input[type='hidden'][name='shipping_price']").val(price);$("input[type='hidden'][name='shipping_tax']").val(tax);$("input[type='hidden'][name='shipping_extra']").val(extra);})(j2store.jQuery);}
function doAjaxFilter(pov_id,product_id,po_id,id){(function($){if(pov_id==''||$('#ChildOptions'+po_id).length!=0){$('#ChildOptions'+po_id).html('');}
var form=$(id).closest('form');if(form.data('product_id')!=product_id)return;var values=form.serializeArray();values.pop({name:"task",value:'addItem'});values.pop({name:"view",value:'carts'});var arrayClean=function(thisArray){"use strict";$.each(thisArray,function(index,item){if(item.name=='task'||item.name=='view'){delete values[index];}});}
arrayClean(values);if(form.data('product_type')=='advancedvariable'){var csv=[];form.find('input[type=\'radio\']:checked, select').each(function(index,el){if(el.value){if($(el).data('is-variant')){csv.push(el.value);}}});var processed_csv=[];processed_csv=csv.sort(function(a,b){return a-b});var $selected_variant=processed_csv.join();var $variants=form.data('product_variants');var $variant_id=get_matching_variant($variants,$selected_variant);form.find('input[name=\'variant_id\']').val($variant_id);values.push({name:"variant_id",value:$variant_id});}
values=jQuery.param(values);$.ajax({url:j2storeURL+'index.php?option=com_j2store&view=products&task=update&po_id='
+po_id
+'&pov_id='
+pov_id
+'&product_id='
+product_id,type:'get',cache:false,data:values,dataType:'json',beforeSend:function(){$('#option-'+po_id).append('<span class="wait">&nbsp;<img src="'+j2storeURL+'/media/j2store/images/loader.gif" alt="" /></span>');},complete:function(){$('.wait').remove();},success:function(response){var $product=$('.product-'+product_id);if($product.length&&typeof response.error=='undefined'){if(response.sku){$product.find('.sku').html(response.sku);}
if(response.pricing.base_price){$product.find('.base-price').html(response.pricing.base_price);}
if(response.pricing.price){$product.find('.sale-price').html(response.pricing.price);}
if(response.afterDisplayPrice){$product.find('.afterDisplayPrice').html(response.afterDisplayPrice);}
if(response.quantity){$product.find('input[name="product_qty"]').val(response.quantity);}
if(response.dimensions){$product.find('.product-dimensions').html(response.dimensions);}
if(response.weight){$product.find('.product-weight').html(response.weight);}
if(typeof response.stock_status!='undefined'){if(response.availability==1){$product.find('.product-stock-container').html('<span class="instock">'+response.stock_status+'</span>');}else{$product.find('.product-stock-container').html('<span class="outofstock">'+response.stock_status+'</span>');}}
if(response.optionhtml){$product.find(' #ChildOptions'+po_id).html(response.optionhtml);}}},error:function(xhr,ajaxOptions,thrownError){console.log(thrownError+"\r\n"+xhr.statusText
+"\r\n"+xhr.responseText);}});})(j2store.jQuery);}
function get_matching_variant(variants,selected){for(var i in variants){if(variants[i]==selected)return i;}}
function doAjaxPrice(product_id,id){(function($){var form=$(id).closest('form');if(form.data('product_id')!=product_id)return;var values=form.serializeArray();values.pop({name:"task",value:'addItem'});values.pop({name:"view",value:'carts'});var arrayClean=function(thisArray){"use strict";$.each(thisArray,function(index,item){if(item.name=='task'||item.name=='view'){delete values[index];}});}
arrayClean(values);if(form.data('product_type')=='variable'||form.data('product_type')=='advancedvariable'){var csv=[];if(form.data('product_type')=='advancedvariable'){form.find('input[type=\'radio\']:checked, select').each(function(index,el){if(el.value){if($(el).data('is-variant')){csv.push(el.value);}}});}else{form.find('input[type=\'radio\']:checked, select').each(function(index,el){csv.push(el.value);});}
var processed_csv=[];processed_csv=csv.sort(function(a,b){return a-b});var $selected_variant=processed_csv.join();var $variants=form.data('product_variants');var $variant_id=get_matching_variant($variants,$selected_variant);form.find('input[name=\'variant_id\']').val($variant_id);values.push({name:"variant_id",value:$variant_id});}
$.ajax({url:j2storeURL+'index.php?option=com_j2store&view=product&task=update',type:'get',data:values,dataType:'json',success:function(response){var $product=$('.product-'+product_id);if($product.length&&typeof response.error=='undefined'){if(response.sku){$product.find('.sku').html(response.sku);}
if(response.pricing.base_price){$product.find('.base-price').html(response.pricing.base_price);}
if(response.pricing.price){$product.find('.sale-price').html(response.pricing.price);}
if(response.afterDisplayPrice){$product.find('.afterDisplayPrice').html(response.afterDisplayPrice);}
if(response.quantity){$product.find('input[name="product_qty"]').val(response.quantity);}
if(typeof response.stock_status!='undefined'){if(response.availability==1){$product.find('.product-stock-container').html('<span class="instock">'+response.stock_status+'</span>');}else{$product.find('.product-stock-container').html('<span class="outofstock">'+response.stock_status+'</span>');}}
if(response.dimensions){$product.find('.product-dimensions').html(response.dimensions);}
if(response.weight){$product.find('.product-weight').html(response.weight);}
console.log(response);$('body').trigger('after_doAjaxFilter',[$product,response]);}},error:function(xhr,ajaxOptions,thrownError){console.log(thrownError+"\r\n"+xhr.statusText+"\r\n"
+xhr.responseText);}});})(j2store.jQuery);}
function setMainPreview(addimagId,product_id,imageZoom,zoom_type){zoom_type=zoom_type||"outer";var src="";(function($){src=$("#"+addimagId).attr('src');$("#j2store-item-main-image-"+product_id+" img").attr('src','');$("#j2store-item-main-image-"+product_id+" img").attr('src',src);if(imageZoom){if(zoom_type=='outer'){$('#j2store-item-main-image-'+product_id).elevateZoom({cursor:"crosshair",zoomWindowFadeIn:500,zoomWindowFadeOut:750,zoomWindowWidth:450,zoomWindowHeight:300});}else if(zoom_type=='inner'){$("#j2store-item-main-image-"+product_id+" .zoomImg").attr('src',src);$("#j2store-item-main-image-"+product_id+" img").attr('src',src);$('#j2store-item-main-image-'+product_id).zoom({cursor:"crosshair",zoomWindowFadeIn:500,zoomWindowFadeOut:750,zoomWindowWidth:450,zoomWindowHeight:300});}}})(j2store.jQuery);}
function removeAdditionalImage(product_id,main_image,imageZoom,zoom_type){zoom_type=zoom_type||"outer";(function($){$("#j2store-item-main-image-"+product_id+" img").attr('src',main_image);setMainPreview('j2store-item-main-image-'+product_id,product_id,imageZoom,zoom_type);})(j2store.jQuery);}
function getJ2storeFiltersSubmit(){jQuery("#j2store-product-loading").show();jQuery("#productsideFilters").submit();}
function resetJ2storeBrandFilter(inputid){if(inputid){jQuery("#productsideFilters").find("#"+inputid).prop('checked',false);}else{jQuery(".j2store-brand-checkboxes").each(function(){this.checked=false;});}}
function resetJ2storeVendorFilter(inputid){if(inputid){jQuery("#productsideFilters").find("#"+inputid).prop('checked',false);}else{jQuery(".j2store-vendor-checkboxes").each(function(){this.checked=false;});}}
function resetJ2storeProductFilter(productfilter_class,inputid){if(productfilter_class){jQuery("."+productfilter_class).each(function(){this.checked=false;});}else if(inputid){jQuery("#productsideFilters").find("#"+inputid).prop('checked',false);}}
function getPriceFilterToggle(){(function($){$('#price-filter-icon-plus').toggle();$('#price-filter-icon-minus').toggle();$('#j2store-slider-range').toggle();$('#j2store-slider-range-box').toggle();})(j2store.jQuery);}
function getCategoryFilterToggle(){(function($){$('#cat-filter-icon-plus').toggle();$('#cat-filter-icon-minus').toggle();$('#j2store_category').toggle();})(j2store.jQuery);}
function getBrandFilterToggle(){(function($){$('#brand-filter-icon-plus').toggle();$('#brand-filter-icon-minus').toggle();$('#j2store-brand-filter-container').toggle();})(j2store.jQuery);}
function getVendorFilterToggle(){(function($){$('#vendor-filter-icon-plus').toggle();$('#vendor-filter-icon-minus').toggle();$('#j2store-vendor-filter-container').toggle();})(j2store.jQuery);}
function getPFFilterToggle(id){(function($){$('#pf-filter-icon-plus-'+id).toggle();$('#pf-filter-icon-minus-'+id).toggle();$('#j2store-pf-filter-'+id).toggle();})(j2store.jQuery);}


/*===============================
http://localhost/craft_1//templates/crafty/html/mod_j2products/Bootstrap3/assets/mod_j2products.js
================================================================================*/;



/*===============================
/craft_1/plugins/j2store/app_productcompare/app_productcompare/assets/js/compare.js
================================================================================*/;
if(typeof(j2store)=='undefined'){var j2store={};}
if(typeof(j2store.jQuery)=='undefined'){j2store.jQuery=jQuery.noConflict();}
if(typeof(j2storeURL)=='undefined'){var j2storeURL='';}
function addToCompare(element){(function($){$('.j2store-compare-notify').remove();var thisElement=$(element);var product_id=$(thisElement).data('compare-product-id');var form=$(element).closest('form');if(form.data('product_type')=='variable'){var variant_id=form.find('input[name=\'variant_id\']').val();}else{var variant_id=$(thisElement).data('compare-variant-id');}
var aid=$(thisElement).data('compare-id');var j2Ajax=jQuery.ajax({url:'index.php',type:'post',data:{'option':'com_j2store','view':'apps','task':'view','appTask':'addcompare','id':aid,'variant_id':variant_id,'product_id':product_id},dataType:'json'});j2Ajax.done(function(json){if(json['success']){$(thisElement).attr('href',$(thisElement).data('compare-link'));var icon=$(thisElement).data('icon-after-add');if(icon!=''){$(thisElement).html('<i class="fa '+icon+'"></i>'+$(thisElement).data('compare-action-done'));}else{$(thisElement).html('<i class="fa fa-retweet"></i>'+$(thisElement).data('compare-action-done'));}
$(thisElement).removeClass('product-compare-link');$(thisElement).addClass('product-view-compare-list');if($(thisElement).data('compare-show-messgage')){$(thisElement).before('<span class="j2store-compare-notify"><a class="text text-success" href="'
+$(thisElement).data('compare-link')+'" >'
+$(thisElement).data('compare-show-messgage-text')
+'</a><br /></span>');}}
if(json['error']){if(json['exists']){$(thisElement).attr('href',$(thisElement).data('compare-link'));$(thisElement).html('<i class="fa fa-list"></i>'+$(thisElement).data('compare-action-done'));}
$(thisElement).before('<span class="j2store-compare-notify"><a class="text text-error" href="'
+$(thisElement).data('compare-link')+'" >'
+json['error']
+'</a><br /></span>');}});})(j2store.jQuery);}
function removeFromCompare(element){(function($){$('.j2store-compare-notify').remove();var aid=$(element).data('compare-id');var thisElement=$(element);var product_id=$(thisElement).data('compare-product-id');var variant_id=$(thisElement).data('compare-variant-id');var j2Ajax=jQuery.ajax({url:'index.php',type:'post',data:{'option':'com_j2store','view':'apps','task':'view','appTask':'removeCompare','id':aid,'variant_id':variant_id,'product_id':product_id},dataType:'json'});j2Ajax.done(function(json){if(json['success']){location.reload();}});})(j2store.jQuery);}
function j2storeClearAllcompare(element){(function($){var thisElement=$(element);$.ajax({type:'post',url:'index.php',dataType:'json',data:{'option':'com_j2store','view':'apps','task':'view','appTask':'clearAlllist','id':$(thisElement).data('compare-id')},success:function(json){if(json['success']){location.reload();}
if(json['error']){$('#system-message-container').append('<p class="text text-error">'+json['error']+'</p>');}}});})(j2store.jQuery);}