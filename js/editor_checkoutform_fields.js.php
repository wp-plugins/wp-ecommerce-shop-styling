<?php
	require_once('../../../../wp-load.php');
	require_once('../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
 
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
 

		global $wpdb;

		$form_sql = "
				SELECT *
				FROM ".WPSC_TABLE_CHECKOUT_FORMS."
				ORDER BY checkout_set,checkout_order;
		";

		$form_fields = $wpdb->get_results( $form_sql );
		$placeholders=array();
																				
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
	tinymce.create('tinymce.plugins.checkoutformfields', {
		init : function(ed, url) {
 			
		},
		createControl : function(n, cm) {
			console.log('createControl'+n);
			if(n=='checkoutformfields'){
						var mlb = cm.createListBox('checkoutformfieldsList', {
							title : '<?php _e('Checkout Fields','haetshopstyling'); ?>',
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
				longname : 'Checkout Form Placeholder Selector',
				author : 'haet',
				authorurl : 'http://haet.at',
				infourl : 'http://haet.at',
				version : "1.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('checkoutformfields', tinymce.plugins.checkoutformfields);
})();