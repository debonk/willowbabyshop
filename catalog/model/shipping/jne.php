<?php 
class ModelShippingjne extends Model {    
  	public function getQuote($address) {
		$this->load->language('shipping/jne');
		
		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('jne_' . $result['geo_zone_id'] . '_status')) {
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
				$cost = '';
				$weight = $this->cart->getWeight()/1000;
//				$berat = explode('.',($weight/1000));
				
				$rates = explode(',', $this->config->get('jne_' . $result['geo_zone_id'] . '_rate'));
				
/*				if(!isset($berat[1])) {
								$berat[1] = 0;
					}
				else{
					$berat[1]="0.$berat[1]";
				}
				//echo $berat[1];
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
					
					if($address['postcode']==$data[0]){
						if(isset($data[1])){
							if ($berat[0] < 1){
								$cost = $data[1];
								
							}
											
							elseif(($berat[1])<=0.3){
								$cost = $berat[0] * $data[1];
							}
							else{
								$cost = ($berat[0]+1) * $data[1];
							}
							
						}
						break;
					}
					
				}
*/				foreach ($rates as $rate) {
					$data = explode(':', $rate);
					
					if($address['postcode']==$data[0]){
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
					$quote_data['jne_' . $result['geo_zone_id']] = array(
						'code'         => 'jne.jne_' . $result['geo_zone_id'],
						'title'        => $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('jne_tax_class_id'),
					//	'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('jne_tax_class_id'), $this->config->get('config_tax')))
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('jne_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);	
				}
			}
		}
		
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'jne',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('jne_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
}
?>