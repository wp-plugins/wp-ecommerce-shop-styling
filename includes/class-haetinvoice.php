<?php
class HaetInvoice {
	
	
	function HaetInvoice($options,$params) { 
		$this->options = $options;
		$this->params = $params;
	}


	public function generate($filename){
		$body=  __(stripslashes(str_replace('\\&quot;','',$this->options['template']))) ;
		$footerleft=  __($this->options['footerleft']);
		$footercenter=  __($this->options['footercenter']);
		$footerright=  __($this->options['footerright']);


		$body = $this->imgUrl2Path($body);
		
		foreach ($this->params AS $param){
			if( is_array($param) && array_key_exists('unique_name', $param) && array_key_exists('value', $param)){
				$body = str_replace('{'.$param["unique_name"].'}', $param['value'], $body);
				$footerleft = str_replace('{'.$param["unique_name"].'}', $param['value'], $footerleft);
				$footercenter = str_replace('{'.$param["unique_name"].'}', $param['value'], $footercenter);
				$footerright = str_replace('{'.$param["unique_name"].'}', $param['value'], $footerright);
			}
		}
		$footerleft = explode("\n",$footerleft,3);
		$footercenter = explode("\n",$footercenter,3);
		$footerright = explode("\n",$footerright,3);
		
		//remove "downloads" column in PDF
		$body = preg_replace('#\<t[d|h] class=\'download\'>.*</t[d|h]>#Uis', '', $body);
		
		$html='<html><head>
				<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
				<style type="text/css">
					'.stripslashes($this->options['css']).'
				</style>
				</head>
				<body> 
					'.$body.'
				</body>
			  </html>';

		//$tmpfile=HAET_INVOICE_PATH."preview.html";
		//file_put_contents($tmpfile,$html);
		require_once(HAET_SHOP_STYLING_PATH.'includes/dompdf/dompdf_config.inc.php');    
		$pdf = new DOMPDF();
		$pdf->set_paper($this->options['paper']);
		$pdf->load_html($html);
		$pdf->render(); 
        //add Footer
        $canvas = $pdf->get_canvas();

        // Letter   612x792
        // A4       595x842
        $footerposition=array(
            'a4'=>array(
                'left'=>array(
                    'x'=>60,
                    'y'=>750
                ),
                'center'=>array(
                    'x'=>292,
                    'y'=>750
                ),
                'right'=>array(
                    'x'=>535,
                    'y'=>750
                )
            ),
            'letter'=>array(
                'left'=>array(
                    'x'=>60,
                    'y'=>700
                ),
                'center'=>array(
                    'x'=>306,
                    'y'=>700
                ),
                'right'=>array(
                    'x'=>552,
                    'y'=>700
                )
            )
        );
        $lineheight=10;
        $tmpstyle = new Style(new Stylesheet($pdf));
        for($i=0; $i<3; $i++){
        	$canvas->page_text(
                    $footerposition[ $this->options['paper'] ]['left']['x'],
                    $footerposition[ $this->options['paper'] ]['left']['y']+($i*$lineheight), 
                    $footerleft[$i], 
                    Font_Metrics::get_font( $this->options['footerleftfont'], $this->options['footerleftstyle']), 
                    $this->options['footerleftsize'], 
                    $tmpstyle->munge_color($this->options['footerleftcolor'])
                );
            $text_width = $canvas->get_text_width (
            		str_replace('{PAGE_NUM}', 'x', str_replace('{PAGE_COUNT}', 'x', $footercenter[$i] )), 
            		Font_Metrics::get_font( $this->options['footercenterfont'], $this->options['footercenterstyle']), 
                    $this->options['footercentersize']
            	); 
            $canvas->page_text(
                    $footerposition[ $this->options['paper'] ]['center']['x']-round($text_width/2),
                    $footerposition[ $this->options['paper'] ]['center']['y']+($i*$lineheight), 
                    $footercenter[$i], 
                    Font_Metrics::get_font( $this->options['footercenterfont'], $this->options['footercenterstyle']), 
                    $this->options['footercentersize'],
                    $tmpstyle->munge_color($this->options['footercentercolor'])
                );
            $text_width = $canvas->get_text_width (
            		str_replace('{PAGE_NUM}', 'x', str_replace('{PAGE_COUNT}', 'x', $footerright[$i] )), 
            		Font_Metrics::get_font( $this->options['footerrightfont'], $this->options['footerrightstyle']), 
                    $this->options['footerrightsize']
                ); 
            $canvas->page_text(
                    $footerposition[ $this->options['paper'] ]['right']['x']-$text_width,
                    $footerposition[ $this->options['paper'] ]['right']['y']+($i*$lineheight), 
                    $footerright[$i], 
                    Font_Metrics::get_font( $this->options['footerrightfont'], $this->options['footerrightstyle']), 
                    $this->options['footerrightsize'], 
                    $tmpstyle->munge_color($this->options['footerrightcolor'])
                );
        }

		file_put_contents(HAET_INVOICE_PATH.$filename, $pdf->output());  
	}	

	/**
	 * replace img urls with img path for servers with disabled url_fopen
	 * @param string $body 
	 */
	private function imgUrl2Path( $body ){
		$url = $_SERVER['HTTP_HOST'];
		$url1 = "http://" . $_SERVER['HTTP_HOST'];
		$url2 = "https://" . $_SERVER['HTTP_HOST'];
		$rel_address = str_replace($url2, '', str_replace($url1, '',HAET_SHOP_STYLING_URL) );
		$base_path = str_replace($rel_address,'',HAET_SHOP_STYLING_PATH);

		$body = preg_replace('#\<img(.*)src=\".*'.$url.'(.*)\"(.*)\>#Uis', '<img$1src="'.$base_path.'$2"$3\>', $body);
		$body = preg_replace('#\<img(.*)src=\'.*'.$url.'(.*)\'(.*)\>#Uis', '<img$1src="'.$base_path.'$2"$3\>', $body);

		return $body;
	}

}
?>