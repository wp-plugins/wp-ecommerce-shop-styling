<?php
	require_once('../../../../wp-load.php');
	require_once('../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
 
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
 


		$placeholders=array();
		$placeholders[] = array(
							'fieldvalue' => '#productstable#',
							'fieldname'  => __('products table','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'payment_gateway',
							'fieldname'  => __('Payment gateway','haetshopstyling')
							);		
		$placeholders[] = array(
							'fieldvalue' => 'payment_instructions',
							'fieldname'  => __('Payment instructions','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'date',
							'fieldname'  => __('date','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'base_shipping',
							'fieldname'  => __('Shipping base','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'purchase_id',
							'fieldname'  => __('invoice number','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'total_shipping',
							'fieldname'  => __('Total shipping','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'total_product_price',
							'fieldname'  => __('Total product price','haetshopstyling')
							);  
		$placeholders[] = array(
							'fieldvalue' => 'total_tax',
							'fieldname'  => __('Total tax','haetshopstyling')
							);  
		$placeholders[] = array(
							'fieldvalue' => 'coupon_amount',
							'fieldname'  => __('Discount','haetshopstyling')
							);                                                                                                 
		$placeholders[] = array(
							'fieldvalue' => 'cart_total',
							'fieldname'  => __('Total price','haetshopstyling')
							);      
		$placeholders[] = array(
							'fieldvalue' => 'tracking_id',
							'fieldname'  => __('Tracking ID','haetshopstyling')
							);
		$placeholders[] = array(
							'fieldvalue' => 'total_numeric',
							'fieldname'  => __('Total price numeric','haetshopstyling')
							);


?>
 
(function() {
	tinymce.create('tinymce.plugins.invoicefields', {
		init : function(ed, url) {
 
		},
		createControl : function(n, cm) {
			if(n=='invoicefields'){
						var mlb = cm.createListBox('invoicefieldsList', {
							title : '<?php _e('Invoice Fields','haetshopstyling'); ?>',
							onselect : function(v) {
										tinyMCE.activeEditor.selection.setContent('{' + v + '}');
										return false;
							}
						});
 
				// Add some values to the list box
				<?php foreach($placeholders as $placeholder):?>
					mlb.add('<?php echo $placeholder["fieldname"];?>', '<?php echo $placeholder["fieldvalue"];?>');
				<?php endforeach;?>
 
				// Return the new listbox instance
				return mlb;
			 }
 
			 return null;
		},
 
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Shop Styling Invoice Placeholder Selector',
				author : 'haet',
				authorurl : 'http://haet.at',
				infourl : 'http://haet.at',
				version : "1.2"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('invoicefields', tinymce.plugins.invoicefields);
})();