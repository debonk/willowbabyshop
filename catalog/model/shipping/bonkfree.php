<?php
class ModelShippingBonkFree extends Model {
	function getQuote($address) {
		$this->load->language('shipping/bonkfree');

		$status = false;
		$reshop	= 0;
		$freezones = explode(',', $this->config->get('bonkfree_multizone'));
		$limit	= $this->config->get('bonkfree_limit');

		foreach ($freezones as $freezone) {
			$submin = explode(':', $freezone);
			
			if($address['country_id']==$submin[0]){
				if(isset($submin[1])){
					$status = true;
					$reshop	= $submin[1] - $this->cart->getSubTotal();
				}
				break;
			}
		}

		$code 	= 'bonkfree.bonkfree';
		$text 	= '';
//		$text 	= $this->currency->format(0.00, $this->session->data['currency']);
		$logo	= $this->language->get('text_logo');
		$title  = $this->language->get('text_description');
		
		if (!$status) {
//			$code 	.= '" disabled="disabled';
			$text 	= $this->language->get('text_geozone_warning');
		} elseif ($reshop > 0) {
//			$code 	.= '" disabled="disabled';
			if (empty($limit)) {
				$text 	= sprintf ($this->language->get('text_more_shop'), $this->currency->format($reshop, $this->session->data['currency']));
			} else {
				$text 	= sprintf ($this->language->get('text_more_shop_limit'), $this->currency->format($limit, $this->session->data['currency']), $this->currency->format($reshop, $this->session->data['currency']));
			}
			
			$logo	= $this->language->get('text_logo_disabled');
		} else {
			$title  = $this->language->get('text_description_active');
			$text 	= !empty($limit) ? sprintf ($this->language->get('text_max'),$this->currency->format($limit, $this->session->data['currency'])) : '';
		}

		$code 	.= '" disabled="disabled" style="display:none;';
		$quote_data = array();
		$method_data = array();

			$quote_data['bonkfree'] = array(
				'code'         => $code,
				'title'        => $title,
//				'cost'         => 0.00,
				'tax_class_id' => 0,
				'text'         => $text
			);
		
			$method_data = array(
				'code'       => 'bonkfree',
        		'logo'       => $logo,
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('bonkfree_sort_order'),
				'error'      => false
			);
		
		return $method_data;
	}
}