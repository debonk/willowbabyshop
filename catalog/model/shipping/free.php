<?php
class ModelShippingFree extends Model {
	function getQuote($address) {
		$this->load->language('shipping/free');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('free_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('free_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$reshop	= $this->config->get('free_total') - $this->cart->getSubTotal();
		$code 	= 'free.free';
		$text 	= $this->currency->format(0.00, $this->session->data['currency']);

		if (!$status) {
			$code 	.= '" disabled="disabled';
			$text 	.= $this->language->get('text_geozone_warning');
		} elseif ($reshop > 0) {
			$code 	.= '" disabled="disabled';
			$text 	.= sprintf ($this->language->get('text_more_shop'),$this->currency->format($reshop, $this->session->data['currency']));
		}

		$quote_data = array();
		$method_data = array();

			$quote_data['free'] = array(
				'code'         => $code,
				'title'        => $this->language->get('text_description'),
				'cost'         => 0.00,
				'tax_class_id' => 0,
				'text'         => $text
			);
		
			$method_data = array(
				'code'       => 'free',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('free_sort_order'),
				'error'      => false
			);
		
		return $method_data;
	}
}