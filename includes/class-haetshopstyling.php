<?php
class HaetShopStyling {
    
    
    function HaetShopStyling() { }
    
    function init() {
        $this->getOptions();

        wp_mkdir_p( HAET_INVOICE_PATH );
        @ chmod( HAET_INVOICE_PATH, 0775 );
        if ( !is_file( HAET_INVOICE_PATH . ".htaccess" ) ) {
            $htaccess = "order deny,allow\n\r";
            $htaccess .= "deny from all\n\r";
            $htaccess .= "allow from none\n\r";
            $filename = HAET_INVOICE_PATH . ".htaccess";
            $file_handle = @ fopen( $filename, 'w+' );
            @ fwrite( $file_handle, $htaccess );
            @ fclose( $file_handle );
            @ chmod( $file_handle, 0665 );
        }
    }
    
    function getOptions() {
	 $options = array(
            'template' => stripslashes("<p>&nbsp;</p><p><img class=\"alignnone size-full wp-image-68\" title=\"logo\" src=\"".HAET_SHOP_STYLING_URL."images/logo.jpg\" alt=\"\" width=\"250\" height=\"49\" style=\"border: 0px none;\"/></p><p style=\"text-align: right;\">Companyname </p><p style=\"text-align: right;\">adressline 1</p><p style=\"text-align: right;\">12345 city</p><p style=\"text-align: right;\"> </p><p style=\"text-align: left;\">{billingfirstname} {billinglastname}</p><p style=\"text-align: left;\">{billingaddress}</p><p style=\"text-align: left;\">{billingpostcode} {billingcity}</p><p style=\"text-align: left;\"> </p><p style=\"text-align: right;\">Invoice: {purchase_id}</p><p style=\"text-align: right;\">Date: {date}</p><p style=\"text-align: right;\"> </p><h1 style=\"text-align: left;\">Invoice</h1><p style=\"text-align: left;\">{#productstable#}</p><p style=\"text-align: left;\"> </p><p style=\"text-align: right;\">Products total: {total_product_price}</p><p style=\"text-align: right;\">Shipping total: {total_shipping}</p><p style=\"text-align: right;\">Tax: {total_tax}</p><p style=\"text-align: right;\">Discount: {coupon_amount}</p><p style=\"text-align: right;\"><strong>Total: {cart_total}</strong></p><p style=\"text-align: right;\"> </p><p style=\"text-align: right;\"> </p><p style=\"text-align: center;\">Thank you for your purchase</p><p>&nbsp;</p>"),
            'footer' => stripslashes("<p style=\"text-align: center;\">your company | adressline 1 | 12345 city | office@yourcompany.net</p><p style=\"text-align: center;\">Bank account no.: 0000000000000000000000</p>"),
            'css' => "body {\nmargin: 30px;\n}\n/* included unicode fonts:\n*  serif: 'dejavu serif'\n*  sans: 'devavu sans'\n* add your own fonts: http://code.google.com/p/dompdf/wiki/CPDFUnicode#Load_a_font_supporting_your_characters_into_DOMPDF\n*/\nbody, td, th {\nfont-family: 'dejavu serif';\nfont-size: 10px;\n}\np{\nheight:1em;\n}\n\n#products-table{\nwidth:100%;\nborder-collapse:collapse;\npadding-bottom:1px;\nborder-bottom:0.1pt solid #606060;\n}\n#products-table th{\ntext-align:right;\nborder-bottom:0.2pt solid #606060;\n}\n#products-table td{\ntext-align:right;\nborder-bottom:0.1pt solid #606060;\n}\n\n#products-table .product_name{\ntext-align:left;\n}\n/* keeps the footer on its place because dompdf has problems with absolute and fixed positioning*/\n#content-table{\nwidth:100%;\nmargin-top:0;\n}\n#invoice-content{\nheight:230mm;\nvertical-align:top;\n}\n#invoice-footer{\ncolor:#444;\n}\n/* fix for displaying prices with EURO sign */\n.pricedisplay{\nmargin-right:5px;\n}",
            'paper' => 'a4',
            'filename' => __('invoice','haetshopstyling'),
            'subject_payment_successful' => __('Your purchase at ','haetshopstyling').get_bloginfo('name'),
            'body_payment_successful' =>  "<p>Thank you for your purchase</p><p>We received your payment. Your order {purchase_id} will be processed immediately by our team.</p><p><strong> Your Products</strong></p><p>{#productstable#}</p>",
            'subject_payment_incomplete' => __('Your purchase at ','haetshopstyling').get_bloginfo('name'),
            'body_payment_incomplete' =>  "<p>Thank you for your purchase.</p><p>Please transfer the <strong>amount of</strong> {cart_total} to the following account and please mention your <strong>order number {purchase_id} </strong>in the field as reason:</p><p>Account owner<br />Bank<br />IBAN: XX 000000000000000000000<br />BIC/SWIFT: XX00XX00</p><p>Your articles will be delivered immediately after your payment.</p><p>&nbsp;</p>",
            'subject_payment_failed' => __('Your purchase at ','haetshopstyling').get_bloginfo('name'),
            'body_payment_failed' =>  "<p><strong>Your payment could not be processed.</strong></p><p>Please transfer the <strong>amount of</strong> {cart_total} to the following account and please mention your <strong>order number {purchase_id} </strong>in the field as reason:</p><p>Account owner<br />Bank<br />IBAN: XX 000000000000000000000<br />BIC/SWIFT: XX00XX00</p><p>Your articles will be delivered immediately after your payment.</p><p>&nbsp;</p>",
            'subject_tracking' =>  __('Product Tracking Email','haetshopstyling'),
            'body_tracking' => "<p>Track &amp; Trace means you may track the progress of your parcel with our online parcel tracker, just login to our website and enter the following Tracking ID to view the status of your order.<br /><br /><strong>Tracking ID: {tracking_id}</strong><br /><br /></p>",
            'columntitle' => array(
                                '',
                                '#',
                                __('Product','haetshopstyling'),
                                __('Quantity','haetshopstyling'),
                                __('Price single','haetshopstyling'),
                                __('Tax %','haetshopstyling'),
                                __('Tax','haetshopstyling'),
                                __('Price','haetshopstyling'),
                                __('Download','haetshopstyling'),
                                "",
                                ""
                            ),
            'columnfield' => array(
                                '',
                                'item_number',
                                "product_name",
                                "product_quantity",
                                "product_price",
                                "product_gst",
                                "product_tax_charged",
                                "price_sum",
                                "download",
                                "",
                                ""
                            ),
             'mailtemplate' => "<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html><head><title></title><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><style type='text/css'>\n/* Mobile-specific Styles */\n@media only screen and (max-device-width: 480px) {\ntable[class=w0], td[class=w0] { width: 0 !important; }\ntable[class=w10], td[class=w10], img[class=w10] { width:10px !important; }\ntable[class=w15], td[class=w15], img[class=w15] { width:5px !important; }\ntable[class=w30], td[class=w30], img[class=w30] { width:10px !important; }\ntable[class=w60], td[class=w60], img[class=w60] { width:10px !important; }\ntable[class=w125], td[class=w125], img[class=w125] { width:80px !important; }\ntable[class=w130], td[class=w130], img[class=w130] { width:55px !important; }\ntable[class=w140], td[class=w140], img[class=w140] { width:90px !important; }\ntable[class=w160], td[class=w160], img[class=w160] { width:180px !important; }\ntable[class=w170], td[class=w170], img[class=w170] { width:100px !important; }\ntable[class=w180], td[class=w180], img[class=w180] { width:80px !important; }\ntable[class=w195], td[class=w195], img[class=w195] { width:80px !important; }\ntable[class=w220], td[class=w220], img[class=w220] { width:80px !important; }\ntable[class=w240], td[class=w240], img[class=w240] { width:180px !important; }\ntable[class=w255], td[class=w255], img[class=w255] { width:185px !important; }\ntable[class=w275], td[class=w275], img[class=w275] { width:135px !important; }\ntable[class=w280], td[class=w280], img[class=w280] { width:135px !important; }\ntable[class=w300], td[class=w300], img[class=w300] { width:140px !important; }\ntable[class=w325], td[class=w325], img[class=w325] { width:95px !important; }\ntable[class=w360], td[class=w360], img[class=w360] { width:140px !important; }\ntable[class=w410], td[class=w410], img[class=w410] { width:180px !important; }\ntable[class=w470], td[class=w470], img[class=w470] { width:200px !important; }\ntable[class=w580], td[class=w580], img[class=w580] { width:280px !important; }\ntable[class=w640], td[class=w640], img[class=w640] { width:300px !important; }\ntable[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }\ntable[class=h0], td[class=h0] { height: 0 !important; }\np[class=footer-content-left] { text-align: center !important; }\n#headline p { font-size: 30px !important; }\n.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }\n.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}\nimg { height: auto; line-height: 100%;}\n}\n/* Client-specific Styles */\n#outlook a { padding: 0; }	/* Force Outlook to provide a 'view in browser' button. */\nbody { width: 100% !important; }\n.ReadMsgBody { width: 100%; }\n.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */\n/* Reset Styles */\n/* Add 100px so mobile switch bar doesn't cover street address. */\nbody { background-color: #dedede; margin: 0; padding: 0; }\nimg { outline: none; text-decoration: none; display: block;}\nbr, strong br, b br, em br, i br { line-height:100%; }\nh1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }\nh1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }\nh1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }\n/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */\nh1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }\n/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */\ntable td, table tr { border-collapse: collapse; }\n.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {\ncolor: black; text-decoration: none !important; border-bottom: none !important; background: none !important;\n}	/* Body text color for the New Yahoo.  This example sets the font of Yahoo's Shortcuts to black. */\n/* This most probably won't work in all email clients. Don't include <code _tmplitem='269' > blocks in email. */\ncode {\nwhite-space: normal;\nword-break: break-all;\n}\n#background-table { background-color: #dedede; }\n/* Webkit Elements */\n#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #c7c7c7; color: #ededed; }\n#top-bar a { font-weight: bold; color: #ffffff; text-decoration: none;}\n#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }\n/* Fonts and Content */\nbody, td { font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; }\n.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }\n/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */\n.header-content { font-size: 12px; color: #ededed; }\n.header-content a { font-weight: bold; color: #ffffff; text-decoration: none; }\n#headline p { color: #444444; font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:30px; }\n#headline p a { color: #444444; text-decoration: none; }\n.article-title { font-size: 18px; line-height:24px; color: #b0b0b0; font-weight:bold; margin-top:0px; margin-bottom:18px; font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; }\n.article-title a { color: #b0b0b0; text-decoration: none; }\n.article-title.with-meta {margin-bottom: 0;}\n.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}\n.article-content { font-size: 13px; line-height: 18px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; }\n.article-content a { color: #2f82de; font-weight:bold; text-decoration:none; }\n.article-content img { max-width: 100% }\n.article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }\n.article-content li { font-size: 13px; line-height: 18px; color: #444444; }\n.article-content li a { color: #2f82de; text-decoration:underline; }\n.article-content p {margin-bottom: 15px;}\n.footer-content-left { font-size: 12px; line-height: 15px; color: #ededed; margin-top: 0px; margin-bottom: 15px; }\n.footer-content-left a { color: #ffffff; font-weight: bold; text-decoration: none; }\n.footer-content-right { font-size: 11px; line-height: 16px; color: #ededed; margin-top: 0px; margin-bottom: 15px; }\n.footer-content-right a { color: #ffffff; font-weight: bold; text-decoration: none; }\n#footer { background-color: #c7c7c7; color: #ededed; }\n#footer a { color: #ffffff; text-decoration: none; font-weight: bold; }\n#permission-reminder { white-space: normal; }\n#street-address { color: #b0b0b0; white-space: normal; }\n#products-table{\n width:100%;\n border-collapse:collapse;\n padding-bottom:1px;\n border-bottom:0.1pt solid #606060;\n }\n #products-table th{\n text-align:right;\n border-bottom:0.2pt solid #606060;\n }\n #products-table td{\n text-align:right;\n border-bottom:0.1pt solid #606060;\n }\n #products-table .product_name{\n text-align:left;\n }</style>\n<!--[if gte mso 9]>\n<style _tmplitem='269' >\n.article-content ol, .article-content ul {\nmargin: 0 0 0 24px;\npadding: 0;\nlist-style-position: inside;\n}\n</style>\n<![endif]--></head><body><table id='background-table' border='0' cellpadding='0' cellspacing='0' width='100%'>\n<tbody><tr>\n<td align='center' bgcolor='#dedede'>\n<table class='w640' style='margin:0 10px;' border='0' cellpadding='0' cellspacing='0' width='640'>\n<tbody><tr><td class='w640' height='20' width='640'></td></tr>\n\n<tr>\n<td class='w640' width='640'>\n<table id='top-bar' class='w640' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0' width='640'>\n<tbody><tr>\n<td class='w15' width='15'></td>\n<td class='w325' align='left' valign='middle' width='350'>\n<table class='w325' border='0' cellpadding='0' cellspacing='0' width='350'>\n<tbody><tr><td class='w325' height='8' width='350'></td></tr>\n</tbody></table>\n<div class='header-content'></div>\n<table class='w325' border='0' cellpadding='0' cellspacing='0' width='350'>\n<tbody><tr><td class='w325' height='8' width='350'></td></tr>\n</tbody></table>\n</td>\n<td class='w30' width='30'></td>\n<td class='w255' align='right' valign='middle' width='255'>\n<table class='w255' border='0' cellpadding='0' cellspacing='0' width='255'>\n<tbody><tr><td class='w255' height='8' width='255'></td></tr>\n</tbody></table>\n<table border='0' cellpadding='0' cellspacing='0'>\n<tbody><tr>\n\n\n\n</tr>\n</tbody></table>\n<table class='w255' border='0' cellpadding='0' cellspacing='0' width='255'>\n<tbody><tr><td class='w255' height='8' width='255'></td></tr>\n</tbody></table>\n</td>\n<td class='w15' width='15'></td>\n</tr>\n</tbody></table>\n\n</td>\n</tr>\n<tr>\n<td id='header' class='w640' align='center' bgcolor='#ffffff' width='640'>\n\n<table class='w640' border='0' cellpadding='0' cellspacing='0' width='640'>\n<tbody><tr><td class='w30' width='30'></td><td class='w580' height='30' width='580'></td><td class='w30' width='30'></td></tr>\n<tr>\n<td class='w30' width='30'></td>\n<td class='w580' width='580'>\n<div id='headline' align='center'>\n<!--- HERE COMES THE HEADER -->\n<p>\n<strong><a href='".home_url()."'><singleline label='Title'>".get_bloginfo('name')."</singleline></a></strong>\n</p>\n<!--- HERE WAS THE HEADER -->\n</div>\n</td>\n<td class='w30' width='30'></td>\n</tr>\n</tbody></table>\n\n\n</td>\n</tr>\n\n<tr><td class='w640' height='30' bgcolor='#ffffff' width='640'></td></tr>\n<tr id='simple-content-row'><td class='w640' bgcolor='#ffffff' width='640'>\n<table class='w640' border='0' cellpadding='0' cellspacing='0' width='640'>\n<tbody><tr>\n<td class='w30' width='30'></td>\n<td class='w580' width='580'>\n<!--- HERE COMES THE CONTENT -->\n{#mailcontent#}\n<!--- HERE WAS THE CONTENT -->\n</td>\n<td class='w30' width='30'></td>\n</tr>\n</tbody></table>\n</td></tr>\n<tr><td class='w640' height='15' bgcolor='#ffffff' width='640'></td></tr>\n\n<tr>\n<td class='w640' width='640'>\n<table id='footer' class='w640' bgcolor='#c7c7c7' border='0' cellpadding='0' cellspacing='0' width='640'>\n<tbody><tr><td class='w30' width='30'></td><td class='w580 h0' height='30' width='360'></td><td class='w0' width='60'></td><td class='w0' width='160'></td><td class='w30' width='30'></td></tr>\n<tr>\n<td class='w30' width='30'></td>\n<td class='w580' valign='top' width='360'>\n<span class='hide'><p id='permission-reminder' class='footer-content-left' align='left'></p></span>\n<p class='footer-content-left' align='left'>".get_bloginfo('name')."<br/>".get_bloginfo('admin_email')."</p>\n</td>\n<td class='hide w0' width='60'></td>\n<td class='hide w0' valign='top' width='160'>\n<p id='street-address' class='footer-content-right' align='right'></p>\n</td>\n<td class='w30' width='30'></td>\n</tr>\n<tr><td class='w30' width='30'></td><td class='w580 h0' height='15' width='360'></td><td class='w0' width='60'></td><td class='w0' width='160'></td><td class='w30' width='30'></td></tr>\n</tbody></table>\n</td>\n</tr>\n<tr><td class='w640' height='60' width='640'></td></tr>\n</tbody></table>\n</td>\n</tr>\n</tbody></table></body></html>",
             'resultspage_successful' => "<p>Thank you for your purchase</p><p>We received your payment. Your order {purchase_id} will be processed immediately by our team.</p><p><strong> Your Products</strong></p><p>{#productstable#}</p>",
             'resultspage_incomplete' => "<p>Thank you for your purchase.</p><p>Please transfer the <strong>amount of</strong> {cart_total} to the following account and please mention your <strong>order number {purchase_id} </strong>in the field as reason:</p><p>Account owner<br />Bank<br />IBAN: XX 000000000000000000000<br />BIC/SWIFT: XX00XX00</p><p>Your articles will be delivered immediately after your payment.</p><p>&nbsp;</p>",
             'resultspage_failed' => "<p><strong>Your payment could not be processed.</strong></p><p>Please transfer the <strong>amount of</strong> {cart_total} to the following account and please mention your <strong>order number {purchase_id} </strong>in the field as reason:</p><p>Account owner<br />Bank<br />IBAN: XX 000000000000000000000<br />BIC/SWIFT: XX00XX00</p><p>Your articles will be delivered immediately after your payment.</p><p>&nbsp;</p>"
        );
         
        $haetshopstyling_options = get_option('haetshopstyling_options');
        if (!empty($haetshopstyling_options)) {
            foreach ($haetshopstyling_options as $key => $option)
                $options[$key] = $option;
        }				
        update_option('haetshopstyling_options', $options);
        return $options;
    }
    
    function sendInvoiceMail($invoice_params){
        //$invoice_params  Array containing (int)purchase_id, (object)cart_item and (object)purchase_log
        if(!$this->isAllowed('invoice'))
            return false;
        
        $purchase_id=$invoice_params['purchase_id'];
        $sessionid = $invoice_params['purchase_log']['sessionid']; 
        //global $purchase_log;
        //$sessionid = $purchase_log['sessionid']; 
        $options = $this->getOptions();
        
        set_transient( "{$sessionid}_pending_email_sent", true, 60 * 60 * 24 * 30);
 
        $filename = $options['filename'].'-'.$purchase_id.'.pdf';
        $params = $this->getBillingData($purchase_id,$options);
        if( count($params) >0 ){
            include HAET_SHOP_STYLING_PATH.'views/admin/invoice.php';
            $html = $this->fixCharacters($html);
            //$tmpfile=HAET_INVOICE_PATH.uniqid();
            //file_put_contents($tmpfile,$html);
            require_once(HAET_SHOP_STYLING_PATH.'includes/dompdf/dompdf_config.inc.php');    
            $pdf = new DOMPDF();
            $pdf->set_paper($options['paper']);
            $pdf->load_html($html);
            $pdf->render();
            file_put_contents(HAET_INVOICE_PATH.$filename, $pdf->output());  
        }
        error_reporting(E_ERROR); //avoid "is_a(): Deprecated" warning in PHP-Versions between 5.0 and 5.3
        
        if ( !version_compare( WPSC_VERSION, '3.8.9', '>=' ) ){
            $email = wpsc_get_buyers_email($invoice_params['purchase_log']['id']);
            if ( !empty($email) && !get_transient( "{$purchase_id}_invoice_email_sent") ) {
                add_filter( 'wp_mail_from', 'wpsc_replace_reply_address', 0 );
                add_filter( 'wp_mail_from_name', 'wpsc_replace_reply_name', 0 );
                add_filter( 'wp_mail_content_type', create_function('', 'return "text/html";'));
                $attachments=array(HAET_INVOICE_PATH.$filename);

                if($invoice_params['purchase_log']['processed']==2){ // payment incomplete or manual payment
                    $body =  stripslashes(str_replace('\\&quot;','',$options['body_payment_incomplete'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_payment_incomplete'])) ;
                }else if($invoice_params['purchase_log']['processed']==1){ // payment failed
                    $body =  stripslashes(str_replace('\\&quot;','',$options['body_payment_failed'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_payment_failed'])) ;
                }else if($invoice_params['purchase_log']['processed']==3){ // payment successful
                    $body =  stripslashes(str_replace('\\&quot;','',$options['body_payment_successful'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_payment_successful'])) ;
                }

                foreach ($params AS $param){
                    $body = str_replace('{'.$param["unique_name"].'}', $param['value'], $body);
                }
                //$body = stripslashes(str_replace('\\&quot;','',$options['emailbody']));

                wp_mail( $email, $subject, $body,'',$attachments);
                wp_mail( get_bloginfo('admin_email'), $subject, $body,'',$attachments);
                set_transient( "{$purchase_id}_invoice_email_sent", true, 60 * 60 * 24 * 30 );

                add_filter('wp_mail_content_type',create_function('', 'return "text";'));        
            } 
        
            if($this->isAllowed('resultspage'))
                $this->transactionResultsPage($options,$params);
        }
    }
    
    /**
     * You found the heart of the "licence management"! ;-)
     * Be fair and don't "hack" it, you'd feel guilty for the rest of your life!
     * @param string $action
     * @return boolean 
     */
    function isAllowed($action){
        if( in_array($action,array('resultspage','invoice'))){
            $keys = get_option('haetshopstyling_keys');
            if(isset($keys[$action])){
                if($action=='resultspage' && md5($keys[$action])=='569b0149663dfa296da905ed6f1a5faf')
                    return true;
                if($action=='invoice' && md5($keys[$action])=='49cd08f4b9675b3d99c6dd53022cd29e')
                    return true;
            }        
        }
        return false;
    }
    
    function printAdminPage(){    
        if ( isset ( $_GET['tab'] ) ) 
            $tab=$_GET['tab']; 
        else 
            $tab='mailcontent'; 

        $options = $this->getOptions();

        if (isset($_POST['update_haetshopstylingSettings'])) { 
            if ($tab=='invoicetemplate'){
                            if (isset($_POST['haetshopstylingtemplate'])) {
                                    $options['template'] = $_POST['haetshopstylingtemplate'];
                                    $options['footer'] = $_POST['haetshopstylingfooter'];
                            }	
                            if (isset($_POST['haetshopstylingpaper'])) {
                                    $options['paper'] = $_POST['haetshopstylingpaper'];
                            }
                            if (isset($_POST['haetshopstylingfilename'])) {
                                    $options['filename'] = $_POST['haetshopstylingfilename'];
                            }

            }else if ($tab=='products'){
                            if (isset($_POST['columntitle'])) {
                                    $options['columntitle'] = $_POST['columntitle'];
                                    for($i=1; $i<=count($options['columntitle']); $i++){
                                        if (!isset($options['columntitle'][$i]) || $options['columntitle'][$i]=='')
                                            $options['columntitle'][$i]=' ';
                                        
                                    }
                                    $options['columnfield'] = $_POST['columnfield'];
                            }	
            }else if ($tab=='mailcontent'){
                            if (isset($_POST['haetshopstylingsubject_payment_successful'])) {
                                    $options['subject_payment_successful'] = $_POST['haetshopstylingsubject_payment_successful'];
                            }	
                            if (isset($_POST['haetshopstylingbody_payment_successful'])) {
                                    $options['body_payment_successful'] = $_POST['haetshopstylingbody_payment_successful'];
                            }
                            if (isset($_POST['haetshopstylingsubject_payment_incomplete'])) {
                                    $options['subject_payment_incomplete'] = $_POST['haetshopstylingsubject_payment_incomplete'];
                            }	
                            if (isset($_POST['haetshopstylingbody_payment_incomplete'])) {
                                    $options['body_payment_incomplete'] = $_POST['haetshopstylingbody_payment_incomplete'];
                            }
                            if (isset($_POST['haetshopstylingsubject_payment_failed'])) {
                                    $options['subject_payment_failed'] = $_POST['haetshopstylingsubject_payment_failed'];
                            }	
                            if (isset($_POST['haetshopstylingbody_payment_failed'])) {
                                    $options['body_payment_failed'] = $_POST['haetshopstylingbody_payment_failed'];
                            }
                            if (isset($_POST['haetshopstylingsubject_tracking'])) {
                                    $options['subject_tracking'] = $_POST['haetshopstylingsubject_tracking'];
                            }	
                            if (isset($_POST['haetshopstylingbody_tracking'])) {
                                    $options['body_tracking'] = $_POST['haetshopstylingbody_tracking'];
                            }
            }else if ($tab=='invoicecss'){
                            if (isset($_POST['haetshopstylingcss'])) {
                                    $options['css'] = $_POST['haetshopstylingcss'];
                            }	
            }else if ($tab=='mailtemplate'){
                            if (isset($_POST['haetshopstylingmailtemplate'])) {
                                    $options['mailtemplate'] = $_POST['haetshopstylingmailtemplate'];
                            }
            }else if ($tab=='resultspage'){
                            if (isset($_POST['resultspage_incomplete'])) {
                                    $options['resultspage_incomplete'] = $_POST['resultspage_incomplete'];
                            }	
                            if (isset($_POST['resultspage_successful'])) {
                                    $options['resultspage_successful'] = $_POST['resultspage_successful'];
                            }
                            if (isset($_POST['resultspage_failed'])) {
                                    $options['resultspage_failed'] = $_POST['resultspage_failed'];
                            }
            }else if ($tab=='upgrade'){
                            $keys = get_option('haetshopstyling_keys');
                            if (!$this->isAllowed('resultspage') && isset($_POST['haetresultspageserial'])) {
                                    $keys['resultspage'] = $_POST['haetresultspageserial'];
                                    update_option('haetshopstyling_keys',$keys);
                                    if ($this->isAllowed('resultspage')){
                                        echo '<div class="updated"><p><strong>';
                                                _e("Your serial was accepted!", "haetshopstyling");
                                        echo '</strong></p></div>';	
                                    }
                            }	
                            if (isset($_POST['haetinvoiceserial'])) {
                                    $keys['invoice'] = $_POST['haetinvoiceserial'];
                                    update_option('haetshopstyling_keys',$keys);
                                    if ($this->isAllowed('invoice')){
                                        echo '<div class="updated"><p><strong>';
                                                _e("Your serial was accepted!", "haetshopstyling");
                                        echo '</strong></p></div>';	
                                    }
                            }
                            
                            
            }
            update_option('haetshopstyling_options', $options);
            

            echo '<div class="updated"><p><strong>';
                    _e("Settings Updated.", "haetshopstyling");
            echo '</strong></p></div>';	
        } 
        
       
            
            
        add_filter('mce_external_plugins', array(&$this,'customizeEditorPlugins'));
        add_filter('tiny_mce_before_init', array(&$this,'customizeEditor'));
        
        $tabs = array( 
                    'mailcontent' => __('Email Content','haetshopstyling'),
                    'mailtemplate' => __('Email Template','haetshopstyling'),
                    'products' => __('Products Table','haetshopstyling'), 
                    'invoicetemplate' => __('Invoice Template','haetshopstyling'), 
                    'invoicecss' => __('Invoice CSS','haetshopstyling'),
                    'resultspage' => __('Transaction Results Page','haetshopstyling')
            );
        include HAET_SHOP_STYLING_PATH.'views/admin/settings.php';
    
    }

    function productsFieldSelect($id,$active){
        $fields = array(
                    array('item_number',      __('item number','haetshopstyling')),
                    array('product_name',      __('product name','haetshopstyling')),
                    array('product_quantity',      __('quantity','haetshopstyling')),
                    array('product_price',      __('single price','haetshopstyling')),
                    array('product_pnp',      __('product shipping','haetshopstyling')),
                    array('price_without_tax',      __('single price without tax','haetshopstyling')),
                    array('price_sum',      __('price','haetshopstyling')),
                    array('price_sum_without_tax',      __('price without tax','haetshopstyling')),
                    array('product_gst',      __('tax rate','haetshopstyling')),
                    array('product_tax_charged',      __('tax charged','haetshopstyling')),
                    array('download',      __('download link','haetshopstyling'))
            );
        $select = '<select class="products-field-select" id="'.$id.'" name="'.$id.'">';
        $select .= '<option value="" >'.__('hide column','haetshopstyling').'</option>';
        foreach( $fields AS $field){
            $select .= '<option value="'.$field[0].'" '.($field[0]==$active?'selected':'').'>'.$field[1].'</option>';
        }
        $select .= '</select>';
        return $select;
    }
    
    function customizeEditor($in) {
        $in['remove_linebreaks']=false;
        $in['remove_redundant_brs'] = false;
        $in['wpautop']=false;
        return $in;
    }
    
    function customizeEditorPlugins($plugin_array) {
        $plugin_array['invoicefields'] = HAET_SHOP_STYLING_URL . 'js/editor.js.php';
        return $plugin_array;
    }

  

    function showLogInvoiceLink(){
        $options = $this->getOptions();
        
        $purchase_id=$_GET['id'];
        if ( file_exists(HAET_INVOICE_PATH.$options['filename'].'-'.$purchase_id.'.pdf') )
            echo '
                <img src="'.HAET_SHOP_STYLING_URL.'../wp-e-commerce/wpsc-core/images/download.gif'.'">&nbsp;
                <a href="'.HAET_SHOP_STYLING_URL.'includes/download.php?filename='.$options['filename'].'-'.$purchase_id.'.pdf"> '.__("Show Invoice",'haetshopstyling').'</a><br><br class="small">
                ';
    }
    
    function currencyDisplay($number){
        return wpsc_currency_display( $number );
    }
    
    function fixCharacters($str){
        return $str;
    }
    
    function getBillingData($purchase_id,$options,$preview=false){
        if(wpsc_cart_item_count()>0 || $preview){
            global $wpdb;

            $form_sql = "SELECT IF (unique_name = '',CONCAT('field_',CAST(form_id AS CHAR(2))),unique_name) as unique_name,value
                            FROM `".$wpdb->prefix."wpsc_submited_form_data` 
                            LEFT JOIN `".$wpdb->prefix."wpsc_checkout_forms` ON ".$wpdb->prefix."wpsc_submited_form_data.form_id = ".$wpdb->prefix."wpsc_checkout_forms.id 
                            WHERE  `log_id` = '".(int)$purchase_id."' AND `active` = '1'
                            ORDER BY checkout_order";
            $params = $wpdb->get_results($form_sql,ARRAY_A);

            $params[]= array('unique_name'=>'purchase_id','value'=>$purchase_id);

            $sql = "SELECT date,base_shipping
                            FROM `".$wpdb->prefix."wpsc_purchase_logs` 
                            WHERE  `id` = ".(int)$purchase_id;
            $params2 = $wpdb->get_results($sql,ARRAY_A);
            
            $params[]= array('unique_name'=>'date','value'=>date_i18n(get_option('date_format'),$params2[0]['date']));
            $params[]= array('unique_name'=>'base_shipping','value'=>$params2[0]['base_shipping']);
            $params[]= array('unique_name'=>'total_shipping','value'=>wpsc_cart_shipping());
            $params[]= array('unique_name'=>'total_product_price','value'=>wpsc_cart_total_widget(false,false,false));
            $params[]= array('unique_name'=>'total_tax','value'=>wpsc_cart_tax());
            $params[]= array('unique_name'=>'coupon_amount','value'=>wpsc_coupon_amount());
            $params[]= array('unique_name'=>'cart_total','value'=>wpsc_cart_total());
            $trackingid = $wpdb->get_var("SELECT `track_id` FROM ".WPSC_TABLE_PURCHASE_LOGS." WHERE `id`={$purchase_id} LIMIT 1");
            $params[]= array('unique_name'=>'tracking_id','value'=>$trackingid);
            
            $i=0;
            while( $i<count($params) ){
                $params[$i]['value'] = $params[$i]['value'];
                $i++;
            }


            
            $params[]= array('unique_name'=>'payment_instructions','value'=>strip_tags( stripslashes( get_option( 'payment_instructions' ) ) ));
            set_transient( "haet_cart_params_{$purchase_id}", $params, 60 * 60 * 24 * 30 );
        }else{ // no products in cart -> page not current
            $params=get_transient("haet_cart_params_{$purchase_id}");
        }

        

        //GENERATE PRODUCTS TABLE outside the if statement
        // this cannot be cached in a transient because of the download links
        $items = $this->getCartItems($purchase_id);
        $products_table = '<table id="products-table">';
        $products_table .= '<tr>';
        for ($col=1;$col < count($options["columnfield"]); $col++){
            if($options["columnfield"][$col]!='' && !($options["columnfield"][$col]=='download' && $this->getProcessedState($purchase_id)!=3))
                $products_table .= "<th class='".$options["columnfield"][$col]."'>".$options["columntitle"][$col]."</th>";
        }
        $products_table .= '</tr>';
        $row=0;

        foreach ($items AS $item){
            $item['item_number']=$row+1;
            $item['price_without_tax']= $this->currencyDisplay( $item['product_price']*$item['product_quantity']-$item['product_tax_charged']/$item['product_quantity'] );
            $item['price_sum']= $this->currencyDisplay( $item['product_price']*$item['product_quantity'] ) ;
            $item['price_sum_without_tax']= $this->currencyDisplay( $item['price_sum']-$item['product_tax_charged'] );
            $item['product_price']= $this->currencyDisplay( $item['product_price'] ) ;

            $products_table .= '<tr>';
            for ($col=1;$col < count($options["columnfield"]); $col++){
                if($options["columnfield"][$col]=='download' ){
                    if($this->getProcessedState($purchase_id)==3 && isset($item['download'])){
                        $products_table .= "<td class='".$options["columnfield"][$col]."'>";
                        foreach($item['download'] AS $download)
                            $products_table .= '<a href="'.$download.'"><img src="'.HAET_SHOP_STYLING_URL.'images/download.png" style="margin-bottom: -5px;" alt="download"></a><br/>';
                        $products_table .= "</td>";
                    }
                }else if($options["columnfield"][$col]!='')
                    $products_table .= "<td class='".$options["columnfield"][$col]."'>".$item[$options["columnfield"][$col]]."</td>";
            }
            $products_table .= '</tr>';     
            $row++;
        }
        $products_table .= '</table>';
        $params[]= array('unique_name'=>'#productstable#','value'=>$products_table);
        return $params;
    }
    
    function getCartItems($purchase_id){
        global $wpdb;

        $form_sql = "SELECT id,
                            prodid,
                            name AS product_name,
                            price AS product_price,
                            pnp AS product_pnp,
                            no_shipping,
                            tax_charged AS product_tax_charged,
                            gst AS product_gst,
                            quantity AS product_quantity
                        FROM `".$wpdb->prefix."wpsc_cart_contents` 
                        WHERE  `purchaseid` = ".(int)$purchase_id;
        $cartitems = $wpdb->get_results($form_sql,ARRAY_A);
        if($this->getProcessedState($purchase_id)==3){
            for($i=0;$i<count($cartitems);$i++){
                $cartitems[$i]['download']=$this->getDownloadLinks($purchase_id,$cartitems[$i]['prodid']);
            }
        }

        return $cartitems;
    }
    
    function getProcessedState($purchase_id){
        global $wpdb;
        return $wpdb->get_var("SELECT `processed` FROM ".WPSC_TABLE_PURCHASE_LOGS." WHERE id=".$purchase_id);
    }
    
    function getDownloadLinks($purchase_id,$product_id){
        global $wpdb;
        $sql = "SELECT * FROM `" . WPSC_TABLE_DOWNLOAD_STATUS . "` WHERE `purchid` = ".$purchase_id." AND product_id = " . $product_id . " AND `active` IN ('1') ORDER BY `datetime` DESC";
        $products = $wpdb->get_results( $sql, ARRAY_A );
        $products = apply_filters( 'wpsc_has_downloads_products', $products );

        $downloads=array();
        foreach ( (array)$products as $key => $product ) {
            if( empty( $product['uniqueid'] ) ) { // if the uniqueid is not equal to null, its "valid", regardless of what it is
                        $downloads[] = site_url() . "/?downloadid=" . $product['id'];
                } else {
                        $downloads[] = site_url() . "/?downloadid=" . $product['uniqueid'];
                }
        }
        return $downloads;
    }
    
    /* use this function up to wpsc 3.8.5 */ 
    function transactionResultsPage($options, $params){
        global $message_html;
        global $purchase_log;
        
        if($purchase_log['processed']==2) // payment incomplete or manual payment
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_incomplete'])) ;
        else if($purchase_log['processed']==1) // payment failed
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_failed'])) ;
        else if($purchase_log['processed']==3) // payment successful
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_successful'])) ;
        
        foreach ($params AS $param){
            $message_html = str_replace('{'.$param["unique_name"].'}', $param['value'], $message_html);
        }

        // TODO den StandardText aus Zeile 362 wpsc-transaction-result-functions.php entfernen
    }
    
    /* use this function for wpsc 3.8.9 */
    function transactionResultsFilter($output){
        $purchase_log = new WPSC_Purchase_Log( $_GET['sessionid'], 'sessionid' );
        $options = $this->getOptions();
        $params = $this->getBillingData($purchase_log->get('id'),$options);
        
//        WPSC_Purchase_Log::INCOMPLETE_SALE  //= 1;
//	const ORDER_RECEIVED   = 2;
//	const ACCEPTED_PAYMENT = 3;
//	const JOB_DISPATCHED   = 4;
//	const CLOSED_ORDER     = 5;
//	const PAYMENT_DECLINED = 6;
//	const REFUNDED         = 7;
//	const REFUND_PENDING   = 8;
        if($purchase_log->get('processed')==2) // payment incomplete or manual payment
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_incomplete'])) ;
        else if($purchase_log->get('processed')==1) // payment failed
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_failed'])) ;
        else if($purchase_log->get('processed')==3) // payment successful
            $message_html = stripslashes(str_replace('\\&quot;','',$options['resultspage_successful'])) ;
        
        foreach ($params AS $param){
            $message_html = str_replace('{'.$param["unique_name"].'}', $param['value'], $message_html);
        }
        return $message_html;
    }
    
    
    
    function styleMail($vars){
        $options = $this->getOptions();
        extract($vars);

        if(isset($_POST['id'])){ //if state is changed on sales log overview page
            $purchase_id=$_POST['id'];
        } else if(isset($_GET['id'])){ 
            $purchase_id=$_GET['id'];  
        }else if(isset($_POST['log_id'])){ //tracking mail
            $purchase_id=$_POST['log_id'];
        }else if ( version_compare( WPSC_VERSION, '3.8.9', '>=' ) && isset($_GET['sessionid'])){ //transaction results 
            $purchase_log = new WPSC_Purchase_Log( $_GET['sessionid'], 'sessionid' );
            $purchase_id=$purchase_log->get('id');
        }else {
            global $haet_purchase_id; //custom global for transaction result mail
            $purchase_id = $haet_purchase_id;
        }
         
	
        
        if($purchase_id){
            $params = $this->getBillingData($purchase_id,$options);
            if(isset($_GET['email_buyer_id']) || !get_transient( "{$purchase_id}_invoice_email_sent") ){ //if "resend receipt to buyer"
                $filename = $options['filename'].'-'.$purchase_id.'.pdf';
                if ( $this->isAllowed('invoice') && file_exists(HAET_INVOICE_PATH.$filename) ){
                    $attachments=array(HAET_INVOICE_PATH.$filename);
                    set_transient( "{$purchase_id}_invoice_email_sent", true, 60 * 60 * 24 * 30 );
                }
            }
        }
        /*
         * the idea of the following switch statement is taken from http://schwambell.com/wp-e-commerce-style-email-plugin/ by Jakob Schwartz
         */
        switch($subject) {
		//case __( 'Purchase Report', 'wpsc' ): //not used -> Admin mail is unformatted
		case __( 'Purchase Receipt', 'wpsc' ): //sent when changing state to "accepted payment"
                    $message =  stripslashes(str_replace('\\&quot;','',$options['body_payment_successful'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_payment_successful'])) ;
                    break;
		//case __( 'Order Pending', 'wpsc' ): // when is this message sent!?
		case __( 'Order Pending: Payment Required', 'wpsc' ):
                    $message =  stripslashes(str_replace('\\&quot;','',$options['body_payment_incomplete'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_payment_incomplete']));
                    break;
		case get_option( 'wpsc_trackingid_subject' ): 
                    $message =  stripslashes(str_replace('\\&quot;','',$options['body_tracking'])) ;
                    $subject = stripslashes(str_replace('\\&quot;','',$options['subject_tracking']));
                    break;
		//case __( 'The administrator has unlocked your file', 'wpsc' ):		
	}
        
        if($purchase_id){
            foreach ($params AS $param){
                $message = str_replace('{'.$param["unique_name"].'}', $param['value'], $message);
                $subject = str_replace('{'.$param["unique_name"].'}', $param['value'], $subject);
            }
        }
        $message = str_replace('{#mailcontent#}',nl2br($message),$options['mailtemplate']);
        $message = stripslashes(str_replace('\\&quot;','',$message));
        
        add_filter( 'wp_mail_content_type', create_function('', 'return "text/html";'));
        add_filter( 'wp_mail_from', 'wpsc_replace_reply_address', 0 );
        add_filter( 'wp_mail_from_name', 'wpsc_replace_reply_name', 0 );
        return compact( 'to', 'subject', 'message', 'headers', 'attachments' );
    }
    

    /**
     * preview the invoice
     * @global type $wpdb
     * @param type $purchase_id 
     */
    function previewInvoice($purchase_id=null){
        global $wpdb;
        //$purchase_id=17;
        if($purchase_id)
            $sql = "SELECT id,sessionid
                        FROM `".$wpdb->prefix."wpsc_purchase_logs` 
                        WHERE  `id` = ".(int)$purchase_id;
        else
            $sql = "SELECT id,sessionid
                    FROM `".$wpdb->prefix."wpsc_purchase_logs` 
                    ORDER BY id DESC
                    LIMIT 1";                    
        $result = $wpdb->get_row($sql);
        
        $purchase_id = $result->id; 
        $sessionid = $result->sessionid; 
        $options = $this->getOptions();
        
        $filename = 'preview.pdf';
        $params = $this->getBillingData($purchase_id,$options,true);
        include HAET_SHOP_STYLING_PATH.'views/admin/invoice.php';
        $html = $this->fixCharacters($html);
        $tmpfile=HAET_INVOICE_PATH."preview.html";
        file_put_contents($tmpfile,$html);
        require_once(HAET_SHOP_STYLING_PATH.'includes/dompdf/dompdf_config.inc.php');    
        $pdf = new DOMPDF();
        $pdf->set_paper($options['paper']);
        $pdf->load_html($html);
        $pdf->render();
        file_put_contents(HAET_INVOICE_PATH.$filename, $pdf->output());  
    }
    
    /**
     * define a global variable for the transation result mail
     * @global type $haet_purchase_id
     * @param type $id
     * @param type $status
     * @param type $old_status
     * @param type $purchase_log 
     */
    function setGlobalPurchaseId( $id, $status, $old_status, $purchase_log ) {
        global $haet_purchase_id; 
        $haet_purchase_id = $id;
    }
}

?>