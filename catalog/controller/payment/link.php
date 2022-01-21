<?php
class ControllerPaymentLink extends Controller {
	public function index() {
		$this->load->language('payment/link');

		$language_items = [
			'text_instruction',
			'text_description',
			'text_payment',
			'text_confirm',
			'button_confirm',
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$data['instruction'] = ($this->config->get('link_instruction' . $this->config->get('config_language_id')));
		
		$data['continue'] = $this->url->link('checkout/success');

		return $this->load->view('payment/link', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'link') {
			$this->load->language('payment/link');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_instruction') . "\n\n";
			$comment .= $this->config->get('link_instruction' . $this->config->get('config_language_id')) . "\n\n";
			$comment .= $this->language->get('text_payment');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('link_order_status_id'), $comment, true);
		}
	}
}