<?php
class ModelTotalBonkUnique extends Model {
	public function getTotal($total) {
		if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() > 0)) {
			$this->load->language('total/bonkunique');

			if (isset($this->session->data['unique_number'])) {
				$value = $this->session->data['unique_number'];
			} else {
				$value = rand($this->config->get('bonkunique_min'), $this->config->get('bonkunique_max'));
				$this->session->data['unique_number'] = $value;
			}
			
			if ($this->config->get('bonkunique_operation') == 0) {
		      $value = -$value;
			}
		   
			  $total['totals'][] = array(
				'code'       => 'bonkunique',
				'title'      => $this->language->get('text_bonkunique'),
				'value'      => $value,
				'sort_order' => $this->config->get('bonkunique_sort_order')
			);
			
              $total['total'] += $value;
		} else {
			unset($this->session->data['unique_number']);
		}
	}
}