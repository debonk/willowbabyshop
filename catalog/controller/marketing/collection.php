<?php
class ControllerMarketingCollection extends Controller
{
	private $error = array();
	
	private $field_data = [
		'invoice'		=> 'no_nota',
		'customer_id'	=> 'kode_cust',
		'name'			=> 'nama_cust',
		'total'			=> 'total_nota',
		'token'			=> 'token'
	];
	
	public function index()
	{
		$this->load->language('marketing/collection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/collection');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_marketing_collection->addCollection($this->request->post);	

			$this->response->redirect($this->url->link('marketing/collection/success'));
		}

		$language_items = array(
			'heading_title',
			'text_subtitle',
			'text_confirmation',
			'entry_customer_id',
			'entry_name',
			'entry_invoice',
			'entry_total',
			'entry_account',
			'button_submit',
		);
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['account'])) {
			$data['error_account'] = $this->error['account'];
		} else {
			$data['error_account'] = '';
		}

		$url = '';
		$status = true;

		foreach ($this->field_data as $field) {
			if (isset($this->request->get[$field])) {
				$url .= '&' . $field . '=' . urlencode(html_entity_decode($this->request->get[$field], ENT_QUOTES, 'UTF-8'));
			} else {
				$status = false;
			}
		}

		if (!$status) {
			return new Action('error/not_found');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/collection')
		);
		
		$data['action'] = $this->url->link('marketing/collection', $url, true);
		
		foreach ($this->field_data as $key => $field) {
			$data[$key] = isset($this->request->post[$key]) ? $this->request->post[$key] : $this->request->get[$field];
		}
		
		$data['account'] = isset($this->request->post['account']) ? $this->request->post['account'] : '';

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		$data['text_welcome'] = sprintf($this->language->get('text_welcome'), $data['name']);

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('collection', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('marketing/collection', $data));
	}

	protected function validate()
	{
		if (empty($this->request->post['account'])) {
			$this->error['account'] = $this->language->get('error_account');
		}

		$string = $this->db->escape(urlencode($this->db->escape($this->request->post['invoice'] . $this->request->post['customer_id'] . $this->request->post['name'])) . (int)$this->request->post['total']);

		$string .= 'B,0vXPlTz_0v';

		if (md5($string) != $this->request->get['token']) {
			$this->error['warning'] = $this->language->get('error_collection');
		}

		if (empty($this->request->post['total']) || $this->request->post['total'] < 1500000) {
			$this->error['warning'] = $this->language->get('error_total');
		}

		$collection_count = $this->model_marketing_collection->getCollectionCountByInvoice($this->request->post['invoice']);

		if ($collection_count) {
			$this->error['warning'] = $this->language->get('error_invoice');
		}
		
		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('collection', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}

	public function success()
	{
		$this->load->language('marketing/collection');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/collection')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}
}
