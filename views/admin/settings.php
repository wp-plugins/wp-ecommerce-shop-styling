
    <style>
        .wp-editor-wrap{
            max-width:800px;
        }
        
        #products-table{
            width:100%;
            border-collapse:collapse;
            padding-bottom:1px;
            border-bottom:0.1pt solid #606060;
        }
        #products-table th{
            text-align:right;
            border-bottom:0.2pt solid #606060;
        }
        #products-table td{
            text-align:right;
            border-bottom:0.1pt solid #606060;
        }

        #products-table .product_name{
            text-align:left;
        }
        
        .upgrademessage{
                margin: 5px 0 15px;
                background-color: #FFFFE0;
                border: 1px solid #E6DB55;
                padding: 0 0.6em;
        }
    </style>
<div class=wrap>
    <h2><img src="<?php echo HAET_SHOP_STYLING_URL;?>images/icon.png"><?php _e('Style your store','haetshopstyling'); ?></h2>
    
    <h2 class="nav-tab-wrapper">
    <?php
        foreach( $tabs as $el => $name ){
            $class = ( $el == $tab ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=wp-e-commerce-shop-styling.php&tab=$el'>$name</a>";
        }
    ?>
    </h2>
    
        

<?php 
        switch ( $tab ){
            case 'invoicetemplate' :
                if(!$this->isAllowed('invoice')){
                    ?>
                    <div class="upgrademessage">
                        <div style="float:left">
                            <h4><?php _e('You have not unlocked this feature yet','haetshopstyling'); ?></h4>
                            <p><?php _e('You can edit and even preview the invoice but it will not be published to your customers.','haetshopstyling'); ?></p>
                            <p><a href="?page=wp-e-commerce-shop-styling.php&tab=upgrade"><?php _e('Enter your serial number','haetshopstyling'); ?></a></p>
                        </div>
                        <div style="margin-left:50px; float:left">
                            <h4><?php _e('Get your licence key!','haetshopstyling'); ?></h4>
                            <p><?php _e('Valid for all plugin updates.','haetshopstyling'); ?></p>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="LJJ5TL4GGZATY">
                            <table>
                            <tr><td><input type="hidden" name="on0" value="feature selection">feature selection:</td></tr><tr><td><select name="os0">
                                    <option value="results pages">results pages $5,00 USD</option>
                                    <option value="PDF invoices">PDF invoices $20,00 USD</option>
                                    <option value="all together">all together $22,00 USD</option>
                            </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                        
                        <div style="clear:both"> </div>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <?php
                global $wpdb;
                $sql = "SELECT id
                        FROM `".$wpdb->prefix."wpsc_purchase_logs` 
                        ORDER BY id DESC
                        LIMIT 1";                    
                $latest_purchase_id = $wpdb->get_var($sql);
                if($latest_purchase_id){
                    ?>
                    <h2><?php _e('preview invoice','haetshopstyling'); ?></h2>
                    <p>
                    <?php _e("This preview shows the invoice layout. It uses data from the latest purchase, but shipping or sum values may be incorrect or empty.",'haetshopstyling'); ?>
                    </p>
                    <?php
                    echo '<a class="button" id="invoice-preview-link" href="?page=wp-e-commerce-shop-styling.php&tab=previewinvoice"> '.__("preview invoice",'haetshopstyling').'</a><br/><br/>';
                }
                ?>
                 
                <h2><?php _e('Invoice Template','haetshopstyling'); ?></h2>
                                
                 <?php 
                 if(ini_get('allow_url_fopen')==0){
                     _e('The PHP setting "allow_url_fopen" is disabled so you can\'t include external images. You can use images from this webserver or contact your hosting provider to change the setting.','haetshopstyling');
                     echo "<br/><br/>";
                 }
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['template'])),'haetshopstylingtemplate',array(
                        'media_buttons'=>true,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                            )
                        )
                     );
                 ?>
                 <br/><h2><?php _e('Invoice Footer','haetshopstyling'); ?></h2>
                                
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['footer'])),'haetshopstylingfooter',array(
                        'media_buttons'=>true,
                        'textarea_rows'=>3,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                                'remove_linebreaks' => false
                            )
                        )
                     );
                 ?>
                 
         <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="haetshopstylingpaper"><?php _e('Paper','haetshopstyling'); ?></label></th>
                    <td>
                        <select  id="haetshopstylingpaper" name="haetshopstylingpaper">
                          <option value="a4" <?php echo ($options['paper']=="a4"?"selected":""); ?>>a4</option>
                          <option value="letter" <?php echo ($options['paper']=="letter"?"selected":""); ?>>letter</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="haetshopstylingfilename"><?php _e('Filename','haetshopstyling'); ?></label></th>
                    <td>
                        <input type="text" class="regular-text" id="haetshopstylingpaper" name="haetshopstylingfilename" value="<?php echo $options['filename']; ?>">
                        <span class="description"><?php _e('&lt;filename&gt;&lt;invoicenumber&gt;.pdf','haetshopstyling'); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
                 
<?php 
            break;
            case 'products':
?>

            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

    <h2><?php _e('Products table','haetshopstyling'); ?></h2>   
    <p><?php _e('Customize the fields and headlines for your products table. This table will show up on your invoice and your mails instead of the according placeholder.','haetshopstyling'); ?></p>
    <p><?php _e('At the moment your table content will look like this, but the formatting will be different because of your stylesheets.','haetshopstyling'); ?></p>
    <?php
            $products_table = '<table id="products-table" style="width:600px">';
            $products_table .= '<tr>';

            for ($col=1;$col < count($options["columnfield"]); $col++){
                if($options["columnfield"][$col]!='')
                    $products_table .= "<th  class='".$options["columnfield"][$col]."'>".$options["columntitle"][$col]."</th>";
            }
            $products_table .= '</tr>';
            $row=0;


            $items=array();
            $items[0]=array(
                'item_number'       => '1',
                'product_name'      => 'beautiful red apple',
                'product_quantity'  => '3',
                'product_price'     => '$ 2.20',
                'product_pnp'       => '$ 1.00',
                'price_without_tax' => '$ 2.00',
                'price_sum'         => '$ 6.60',
                'price_sum_without_tax' => '$ 6.00',
                'product_gst'       => '10 %',
                'product_tax_charged'=>'$ 0.60',
                'download'          => '<img src="'.HAET_SHOP_STYLING_URL.'images/download.png" style="margin-bottom: -5px;" alt="download">'
            ); 
            $items[1]=array(
                'item_number'       => '2',
                'product_name'      => 'banana',
                'product_quantity'  => '2',
                'product_price'     => '$ 1.10',
                'product_pnp'       => '$ 0.50',
                'price_without_tax' => '$ 1.00',
                'price_sum'         => '$ 2.20',
                'price_sum_without_tax' => '$ 2.00',
                'product_gst'       => '10 %',
                'product_tax_charged'=>'$ 0.20',
                'download'          => '<img src="'.HAET_SHOP_STYLING_URL.'images/download.png" style="margin-bottom: -5px;" alt="download">'
            ); 
            foreach ($items AS $item){
                foreach ($options["columnfield"] AS $field){
                    if($field!='')
                        $products_table .= "<td class='$field'>".$item[$field]."</td>";
                }
                $products_table .= '</tr>';     
            }
            $products_table .= '</table><p>&nbsp;</p>';
            echo $products_table; 
?>
    
    <table style="border:1px solid #ccc; border-collapse: collapse">
            <tbody>
                <tr valign="top">
                    <th></th>
                    <th><?php _e('Title','haetshopstyling'); ?></th>
                    <th><?php _e('Field','haetshopstyling'); ?></th>
                </tr>
                <?php for($col=1;$col<=10;$col++): ?>
                <tr valign="top">
                     <th><?php echo __('Column','haetshopstyling')." ".$col; ?></th>
                     <td><input type="text" class="" name="columntitle[<?php echo $col; ?>]" id="title_col1" value="<?php echo $options["columntitle"][$col];?>"></td>
                     <td><?php echo $this->productsFieldSelect('columnfield['.$col.']',$options["columnfield"][$col]); ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
 
<?php 
            break;
            case 'mailcontent' :
?>

            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

                <h2><?php _e('Email Content - Payment Successful','haetshopstyling'); ?></h2>
                <table class="form-table">
                  <tbody>
                      <tr valign="top">
                          <th scope="row"><label for="haetshopstylingsubject_payment_successful"><?php _e('Email subject','haetshopstyling'); ?></label></th>
                          <td>
                              <input type="text" class="regular-text" id="haetshopstylingsubject_payment_successful" name="haetshopstylingsubject_payment_successful" value="<?php echo $options['subject_payment_successful']; ?>">
                          </td>
                      </tr>
                  </tbody>
                </table>               
                <?php 

                wp_editor(stripslashes(str_replace('\\&quot;','',$options['body_payment_successful'])),'haetshopstylingbody_payment_successful',array(
                    'media_buttons'=>false,
                    'tinymce' => array(
                            'theme_advanced_buttons3' => 'invoicefields',
                            'remove_linebreaks' => false
                        )
                    )
                    );
                ?>
                
                <hr/>
                
                <h2><?php _e('Email Content - Payment Incomplete (or manual payment)','haetshopstyling'); ?></h2>
                <table class="form-table">
                  <tbody>
                      <tr valign="top">
                          <th scope="row"><label for="haetshopstylingsubject_payment_incomplete"><?php _e('Email subject','haetshopstyling'); ?></label></th>
                          <td>
                              <input type="text" class="regular-text" id="haetshopstylingsubject_payment_incomplete" name="haetshopstylingsubject_payment_incomplete" value="<?php echo $options['subject_payment_incomplete']; ?>">
                          </td>
                      </tr>
                  </tbody>
                </table>               
                <?php 

                wp_editor(stripslashes(str_replace('\\&quot;','',$options['body_payment_incomplete'])),'haetshopstylingbody_payment_incomplete',array(
                    'media_buttons'=>false,
                    'tinymce' => array(
                            'theme_advanced_buttons3' => 'invoicefields',
                            'remove_linebreaks' => false
                        )
                    )
                    );
                ?>
              
                <hr/>
                
                <h2><?php _e('Email Content - Payment failed','haetshopstyling'); ?></h2>
                <table class="form-table">
                  <tbody>
                      <tr valign="top">
                          <th scope="row"><label for="haetshopstylingsubject_payment_failed"><?php _e('Email subject','haetshopstyling'); ?></label></th>
                          <td>
                              <input type="text" class="regular-text" id="haetshopstylingsubject_payment_failed" name="haetshopstylingsubject_payment_failed" value="<?php echo $options['subject_payment_failed']; ?>">
                          </td>
                      </tr>
                  </tbody>
                </table>               
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['body_payment_failed'])),'haetshopstylingbody_payment_failed',array(
                        'media_buttons'=>false,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                                'remove_linebreaks' => false
                            )
                        )
                     );
                 ?>  
                
                <hr/>
                
                <h2><?php _e('Email Content - Track and Trace Email','haetshopstyling'); ?></h2>
                <table class="form-table">
                  <tbody>
                      <tr valign="top">
                          <th scope="row"><label for="haetshopstylingsubject_tracking"><?php _e('Email subject','haetshopstyling'); ?></label></th>
                          <td>
                              <input type="text" class="regular-text" id="haetshopstylingsubject_tracking" name="haetshopstylingsubject_tracking" value="<?php echo $options['subject_tracking']; ?>">
                          </td>
                      </tr>
                  </tbody>
                </table>               
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['body_tracking'])),'haetshopstylingbody_tracking',array(
                        'media_buttons'=>false,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                                'remove_linebreaks' => false
                            )
                        )
                     );
                 ?>  
                 
<?php 
            break;
            case 'invoicecss':
                if(!$this->isAllowed('invoice')){
                    ?>
                    <div class="upgrademessage">
                        <div style="float:left">
                            <h4><?php _e('You have not unlocked this feature yet','haetshopstyling'); ?></h4>
                            <p><?php _e('You can edit and even preview the invoice but it will not be published to your customers.','haetshopstyling'); ?></p>
                            <p><a href="?page=wp-e-commerce-shop-styling.php&tab=upgrade"><?php _e('Enter your serial number','haetshopstyling'); ?></a></p>
                        </div>
                        <div style="margin-left:50px; float:left">
                            <h4><?php _e('Get your licence key!','haetshopstyling'); ?></h4>
                            <p><?php _e('Valid for all plugin updates.','haetshopstyling'); ?></p>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="LJJ5TL4GGZATY">
                            <table>
                            <tr><td><input type="hidden" name="on0" value="feature selection">feature selection:</td></tr><tr><td><select name="os0">
                                    <option value="results pages">results pages $5,00 USD</option>
                                    <option value="PDF invoices">PDF invoices $20,00 USD</option>
                                    <option value="all together">all together $22,00 USD</option>
                            </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                        
                        <div style="clear:both"> </div>
                    </div>
                    <?php
                }
?>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                
    <h2><?php _e('Style your invoice','haetshopstyling'); ?></h2>
    <textarea rows="30" cols="40" class="widefat" id="haetshopstylingcss" name="haetshopstylingcss" style="font-family:'Courier New'"><?php echo stripslashes(str_replace('\\&quot;','',$options['css'])); ?></textarea>

<?php 
            break;
            case 'previewinvoice':
?>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">


    <h3><?php _e('generating pdf invoice...','haetshopstyling'); ?></h3>
    <a href="#" onclick="window.history.back()"><?php _e('back','haetshopstyling'); ?></a>
    <?php 
        $this->previewInvoice(); 
        echo '<script>window.location.href="'.HAET_SHOP_STYLING_URL.'includes/download.php?filename=preview.pdf";</script>';
    ?>
    

<?php 
            break;            
            case 'mailtemplate':
?>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">


    <h2><?php _e('Global HTML Mail Template','haetshopstyling'); ?></h2>
    <textarea rows="30" cols="40" class="widefat" id="haetshopstylingmailtemplate" name="haetshopstylingmailtemplate" style="font-family:'Courier New'"><?php echo stripslashes(str_replace('\\&quot;','',$options['mailtemplate'])); ?></textarea>
    <br/><br/><a id="previewmail" class="button" href='#' ><?php _e('preview Email template','haetshopstyling'); ?></a><br/><br/>
    <iframe id="mailtemplatepreview" style="width:800px; height:480px; border:1px solid #ccc;" ></iframe>
    <p>
        <?php _e('you can find a few more templates here:','haetshopstyling'); ?>
        <a href="http://haet.at/wp-e-commerce-shop-styling/wp-shop-styling-mail-templates/" target="_blank">http://haet.at/wp-e-commerce-shop-styling/wp-shop-styling-mail-templates/</a>
    </p>
    <script>
        jQuery("#previewmail").click(function(){
            jQuery("#mailtemplatepreview").contents().find("html").html(jQuery("#haetshopstylingmailtemplate").val()); 
            return false;    
        });
    </script>
<?php 
            break;        
            case 'resultspage' :
                if(!$this->isAllowed('resultspage')){
                    ?>
                    <div class="upgrademessage">
                        <div style="float:left">
                            <h4><?php _e('You have not unlocked this feature yet','haetshopstyling'); ?></h4>
                            <p><?php _e('You can edit the settings but it will not be published to your customers.','haetshopstyling'); ?></p>
                            <p><a href="?page=wp-e-commerce-shop-styling.php&tab=upgrade"><?php _e('Enter your serial number','haetshopstyling'); ?></a></p>
                        </div>
                        <div style="margin-left:50px; float:left">
                            <h4><?php _e('Get your licence key!','haetshopstyling'); ?></h4>
                            <p><?php _e('Valid for all plugin updates.','haetshopstyling'); ?></p>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="LJJ5TL4GGZATY">
                            <table>
                            <tr><td><input type="hidden" name="on0" value="feature selection">feature selection</td></tr><tr><td><select name="os0">
                                    <option value="results pages">results pages $5,00 USD</option>
                                    <option value="PDF invoices">PDF invoices $20,00 USD</option>
                                    <option value="all together">all together $22,00 USD</option>
                            </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                        
                        <div style="clear:both"> </div>
                    </div>
                    <?php
                }
?>
            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <h2><?php _e('Results Page - payment successful','haetshopstyling'); ?></h2>
                                
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['resultspage_successful'])),'resultspage_successful',array(
                        'media_buttons'=>true,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                            )
                        )
                     );
                 ?>
                 <h2><?php _e('Results Page - payment incomplete (or manual payment)','haetshopstyling'); ?></h2>
                                
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['resultspage_incomplete'])),'resultspage_incomplete',array(
                        'media_buttons'=>true,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                            )
                        )
                     );
                 ?>
                 <h2><?php _e('Results Page - payment failed','haetshopstyling'); ?></h2>
                                
                 <?php 
                 
                 wp_editor(stripslashes(str_replace('\\&quot;','',$options['resultspage_failed'])),'resultspage_failed',array(
                        'media_buttons'=>true,
                        'tinymce' => array(
                                'theme_advanced_buttons3' => 'invoicefields',
                            )
                        )
                     );
                 ?>
<?php 
            break;        
            case 'upgrade' :
                if(!$this->isAllowed('invoice') || !$this->isAllowed('resultspage')){
                    ?>
                    <div class="upgrademessage">
                        <div style="float:left">
                            <h4><?php _e('You have not unlocked all features','haetshopstyling'); ?></h4>
                        </div>
                        <div style="margin-left:50px; float:left">
                            <h4><?php _e('Get your licence key!','haetshopstyling'); ?></h4>
                            <p><?php _e('Valid for all plugin updates.','haetshopstyling'); ?></p>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="LJJ5TL4GGZATY">
                            <table>
                            <tr><td><input type="hidden" name="on0" value="feature selection">feature selection:</td></tr><tr><td><select name="os0">
                                    <option value="results pages">results pages $5,00 USD</option>
                                    <option value="PDF invoices">PDF invoices $20,00 USD</option>
                                    <option value="all together">all together $22,00 USD</option>
                            </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                        <div style="clear:both"> </div>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
               
                 
                <h2><?php _e('Upgrade','haetshopstyling'); ?></h2>
                                
                <?php
                    $keys = get_option('haetshopstyling_keys');
                ?>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="haetresultspageserial"><?php _e('Serial for transaction results','haetshopstyling'); ?></label></th>
                            <td>
                                <?php if($this->isAllowed('resultspage')): ?>
                                    <input type="text" disabled="disabled" class="regular-text" id="haetresultspageserial" name="haetresultspageserial" value="<?php echo 'XXXX-XXXX-XXXX-XXXX'.substr($keys['resultspage'],-5); ?>">
                                <?php else: ?>
                                    <input type="text" class="regular-text" id="haetresultspageserial" name="haetresultspageserial" value="">
                                <?php endif ?>    
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="haetinvoiceserial"><?php _e('Serial for PDF invoices','haetshopstyling'); ?></label></th>
                            <td>
                                <?php if($this->isAllowed('invoice')): ?>
                                    <input type="text" disabled="disabled" class="regular-text" id="haetinvoiceserial" name="haetinvoiceserial" value="<?php echo 'XXXX-XXXX-XXXX-XXXX'.substr($keys['invoice'],-5); ?>">
                                <?php else: ?>
                                    <input type="text" class="regular-text" id="haetinvoiceserial" name="haetinvoiceserial" value="">
                                <?php endif ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                 
<?php 
            break;
}//switch
            
?>
        <div class="submit">
            <input type="submit" name="update_haetshopstylingSettings" class="button-primary" value="<?php _e('Update Settings', 'haetshopstyling') ?>" />
        </div>
    </form>
</div>

