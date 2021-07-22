<?php
class ModelTotalBfreeShip extends Model {
	public function getTotal($total) {
		if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() > 0) && (isset($this->session->data['shipping_method']))) {
			$this->load->language('total/bfreeship');
			
			$value = 0;
			$limit = $this->config->get('bfreeship_limit');
			
			$status = false;
			$reshop	= 0;
			$freezones = explode(',', $this->config->get('bfreeship_multizone'));
			
			$address = $this->session->data['shipping_address'];

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
									
//			if (isset($this->session->data['shipping_method'])) {
/*				if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
					$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

					foreach ($tax_rates as $tax_rate) {
						if ($tax_rate['type'] == 'P') {
							$total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
						}
					}
				}
*/
				if ($reshop > 0) {
					$title 	= sprintf ($this->language->get('text_bfreeship_more'),$this->currency->format($reshop, $this->session->data['currency']));
					$value = 0;
				} else {
					$value = $this->session->data['shipping_method']['cost'];
					$title = $this->language->get('text_bfreeship');
					
					if (($limit > 0) && ($value > $limit)) {
						$value = $limit;
						$title = sprintf ($this->language->get('text_bfreeship_limit'), $this->currency->format($limit, $this->session->data['currency']));
					}
				}

				$value = -$value;

				$total['totals'][] = array(
				'code'       => 'bfreeship',
				'title'      => $title,
				'value'      => $value,
				'sort_order' => $this->config->get('bfreeship_sort_order')
				);
			
				$total['total'] += $value;
//			}
		}
	}
}