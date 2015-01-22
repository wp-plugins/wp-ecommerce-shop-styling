<?php
    require_once('../../../../wp-load.php');
    require_once('../../../../wp-admin/includes/admin.php');
    do_action('admin_init');
 
    if ( ! is_user_logged_in() )
        die('You must be logged in to access this script.');
 


        $invoice_placeholders=array();
        $invoice_placeholders[] = array(
                            'fieldvalue' => '#productstable#',
                            'fieldname'  => __('products table','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'payment_gateway',
                            'fieldname'  => __('Payment gateway','haetshopstyling')
                            );      
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'payment_instructions',
                            'fieldname'  => __('Payment instructions','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'order_status',
                            'fieldname'  => __('Order Status','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'date',
                            'fieldname'  => __('date','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'base_shipping',
                            'fieldname'  => __('Shipping base','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'purchase_id',
                            'fieldname'  => __('invoice number','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'total_shipping',
                            'fieldname'  => __('Total shipping','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'shipping_option',
                            'fieldname'  => __('Shipping option','haetshopstyling')
                            );          
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'total_product_price',
                            'fieldname'  => __('Total product price','haetshopstyling')
                            );  
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'total_tax',
                            'fieldname'  => __('Total tax','haetshopstyling')
                            );  
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'coupon_amount',
                            'fieldname'  => __('Discount','haetshopstyling')
                            );                                                                                                 
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'cart_total',
                            'fieldname'  => __('Total price','haetshopstyling')
                            );      
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'tracking_id',
                            'fieldname'  => __('Tracking ID','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'total_numeric',
                            'fieldname'  => __('Total price numeric','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'total_numeric_without_tax',
                            'fieldname'  => __('Total numeric without tax','haetshopstyling')
                            );
        $invoice_placeholders[] = array(
                            'fieldvalue' => 'tax_numeric',
                            'fieldname'  => __('Total tax numeric','haetshopstyling')
                            );

        $form_sql = "
                SELECT *
                FROM ".WPSC_TABLE_CHECKOUT_FORMS."
                ORDER BY checkout_set,checkout_order;
        ";

        $form_fields = $wpdb->get_results( $form_sql );
        $checkout_placeholders=array();
                                                                                
        foreach ( $form_fields as $form_field ){
            if ( $form_field->type != 'heading' ){
                if(empty( $form_field->unique_name ))
                    $form_field->unique_name = 'field_'.$form_field->id;
                $placeholder=array();
                $placeholder['fieldvalue'] = esc_html( $form_field->unique_name );
                $placeholder['fieldname']  = $form_field->name .' ('.$form_field->unique_name.')';
                $checkout_placeholders[] = $placeholder;
            }
        }

?>

(function() {
    tinymce.PluginManager.add('haet_shopstyling_placeholder', function( editor, url ) {
        editor.addButton( 'haet_shopstyling_placeholder', {
            text: 'Placeholders',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Invoice',
                    menu: [
                        <?php foreach($invoice_placeholders as $placeholder):?>
                            {
                                text: '<?php echo $placeholder["fieldname"];?>',
                                onclick: function() {
                                    editor.insertContent('{<?php echo $placeholder["fieldvalue"];?>}');
                                }
                            },
                        <?php endforeach;?>
                    ]
                },
                {
                    text: 'Checkout',
                    menu: [
                        <?php foreach($checkout_placeholders as $placeholder):?>
                            {
                                text: '<?php echo $placeholder["fieldname"];?>',
                                onclick: function() {
                                    editor.insertContent('{<?php echo $placeholder["fieldvalue"];?>}');
                                }
                            },
                        <?php endforeach;?>
                    ]
                }
            ]
        });
    });
})();