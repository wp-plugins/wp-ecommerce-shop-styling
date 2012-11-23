<?php
	require_once('../../../../wp-load.php');
	require_once('../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
 
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
 

        global $wpdb;

        $form_sql = $wpdb->prepare( "
                SELECT *
                FROM " . WPSC_TABLE_CHECKOUT_FORMS . "
                ORDER BY checkout_set,checkout_order
        " );
        $form_fields = $wpdb->get_results( $form_sql );
        $placeholders=array();
        $placeholders[] = array(
                            'fieldvalue' => '#productstable#',
                            'fieldname'  => '&gt; '.__('products table','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'payment_instructions',
                            'fieldname'  => '&gt; '.__('Payment instructions','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'date',
                            'fieldname'  => '&gt; '.__('date','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'base_shipping',
                            'fieldname'  => '&gt; '.__('Shipping base','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'purchase_id',
                            'fieldname'  => '&gt; '.__('invoice number','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'total_shipping',
                            'fieldname'  => '&gt; '.__('Total shipping','haetshopstyling')
                            );
        $placeholders[] = array(
                            'fieldvalue' => 'total_product_price',
                            'fieldname'  => '&gt; '.__('Total product price','haetshopstyling')
                            );  
        $placeholders[] = array(
                            'fieldvalue' => 'total_tax',
                            'fieldname'  => '&gt; '.__('Total tax','haetshopstyling')
                            );  
        $placeholders[] = array(
                            'fieldvalue' => 'coupon_amount',
                            'fieldname'  => '&gt; '.__('Discount','haetshopstyling')
                            );                                                                                                 
        $placeholders[] = array(
                            'fieldvalue' => 'cart_total',
                            'fieldname'  => '&gt; '.__('Total price','haetshopstyling')
                            );      
        $placeholders[] = array(
                            'fieldvalue' => 'tracking_id',
                            'fieldname'  => '&gt; '.__('Tracking ID','haetshopstyling')
                            );
                            
                                                        
	foreach ( $form_fields as $form_field ){
            if ( $form_field->type != 'heading' ){
                if(empty( $form_field->unique_name ))
                    $form_field->unique_name = 'field_'.$form_field->id;
                $placeholder=array();
                $placeholder['fieldvalue'] = esc_html( $form_field->unique_name );
                $placeholder['fieldname']  = $form_field->name .' ('.$form_field->unique_name.')';
                $placeholders[] = $placeholder;
            }
        }
	
?>
 
(function() {
	tinymce.create('tinymce.plugins.invoicefields', {
		init : function(ed, url) {
 
		},
		createControl : function(n, cm) {
			if(n=='invoicefields'){
                        var mlb = cm.createListBox('invoicefieldsList', {
                            title : '<?php _e('Placeholders','haetshopstyling'); ?>',
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
				longname : 'PDF Invoice Placeholder Selector',
				author : 'haet',
				authorurl : 'http://haet.at',
				infourl : 'http://haet.at',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('invoicefields', tinymce.plugins.invoicefields);
})();