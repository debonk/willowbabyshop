<?php
class ControllerTotalReward extends Controller {
	public function index() {
		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		//Bonk
		if ($this->config->get('reward_sub_calc')) {
			$points_total = $this->cart->getSubTotal();
		} else {
			foreach ($this->cart->getProducts() as $product) {
				if ($product['points']) {
					$points_total += $product['points'];
				}
			}
		}
			
		//Bonk
		$interval = $this->config->get('reward_interval');
		$i = min(ceil($points_total * $this->config->get('reward_max_subtotal') / (100 * $interval)),floor($points/$interval));
		$points_total = $i * $interval;
		
		$data['set_rewards'] = array ();
			for ($x = 0; $x <= $i; $x++) {
			$data['set_rewards'][$x] = $x * $interval;
		}
		
		if ($points && $points_total && $this->config->get('reward_status')) {
			$this->load->language('total/reward');

			$data['heading_title'] = sprintf($this->language->get('heading_title'), $points);

			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_reward'] = sprintf($this->language->get('entry_reward'), $points_total);

			$data['button_reward'] = $this->language->get('button_reward');

			if (isset($this->session->data['reward'])) {
				$data['reward'] = $this->session->data['reward'];
			} else {
				$data['reward'] = '';
			}

			return $this->load->view('total/reward', $data);
		}
	}

	public function reward() {
		$this->load->language('total/reward');

		$json = array();

		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		//Bonk
		if ($this->config->get('reward_sub_calc')) {
			$points_total = $this->cart->getSubTotal();
		} else {
			foreach ($this->cart->getProducts() as $product) {
				if ($product['points']) {
					$points_total += $product['points'];
				}
			}
		}

		//Bonk
		$interval = $this->config->get('reward_interval');
		$i = min(ceil($points_total * $this->config->get('reward_max_subtotal') / (100 * $interval)),floor($points/$interval));
		$points_total = $i * $interval;

/*		if (empty($this->request->post['reward'])) {
			$json['error'] = $this->language->get('error_reward');
		}
*/

		if ($this->request->post['reward'] > $points) {
			$json['error'] = sprintf($this->language->get('error_points'), $this->request->post['reward']);
		}

		if ($this->request->post['reward'] > $points_total) {
			$json['error'] = sprintf($this->language->get('error_maximum'), $points_total);
		}

		if (!$json) {
			$this->session->data['reward'] = abs($this->request->post['reward']);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['redirect'])) {
				$json['redirect'] = $this->url->link($this->request->post['redirect']);
			} else {
				$json['redirect'] = $this->url->link('checkout/cart');	
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
