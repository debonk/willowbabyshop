<?php 
class ModelShippingJneReg extends Model {    
  	public function getQuote($address) {
		$this->load->language('shipping/jnereg');
		
		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('jnereg_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}
			
			if ($status) {
				$weight_value = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = " . $this->config->get('config_weight_class_id'));
				$const = $weight_value->row['value'];
				
				$cost = '';
				$weight = $this->cart->getWeight()/$const;
				
				$rates = explode(',', $this->config->get('jnereg_' . $result['geo_zone_id'] . '_rate'));
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
					
					if($address['city']==$data[0]){
						if(isset($data[1])){
							if ($weight <= 1.3){
								$cost = $data[1];
							} else {
								$cost = ceil($weight - 0.3) * $data[1];
							}
						}
						break;
					}
				}
				
				if ((string)$cost != '') {
					$quote_data['jnereg_' . $result['geo_zone_id']] = array(
						'code'         => 'jnereg.jnereg_' . $result['geo_zone_id'],
						'title'        => $this->language->get('text_jnereg') .' - '. $result['name'],
						'cost'         => $cost *= 1000,
						'tax_class_id' => $this->config->get('jnereg_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('jnereg_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);	
				}
			}
		}
		
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'jnereg',
        		'logo'      => $this->language->get('text_jnereg_logo'),
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('jnereg_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
}