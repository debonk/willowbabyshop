<?php
class ControllerModuleCashback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/cashback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cashback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_discount'] = $this->language->get('entry_discount');
		$data['entry_min_total'] = $this->language->get('entry_min_total');
		$data['entry_max_total'] = $this->language->get('entry_max_total');
		$data['entry_valid'] = $this->language->get('entry_valid');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_theme'] = $this->language->get('entry_theme');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['help_min_total'] = $this->language->get('help_min_total');
		$data['help_max_total'] = $this->language->get('help_max_total');
		$data['help_valid'] = $this->language->get('help_valid');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['discount'])) {
			$data['error_discount'] = $this->error['discount'];
		} else {
			$data['error_discount'] = '';
		}

		if (isset($this->error['min_total'])) {
			$data['error_min_total'] = $this->error['min_total'];
		} else {
			$data['error_min_total'] = '';
		}

		if (isset($this->error['max_total'])) {
			$data['error_max_total'] = $this->error['max_total'];
		} else {
			$data['error_max_total'] = '';
		}

		if (isset($this->error['valid'])) {
			$data['error_valid'] = $this->error['valid'];
		} else {
			$data['error_valid'] = '';
		}

		if (isset($this->error['date_start'])) {
			$data['error_date_start'] = $this->error['date_start'];
		} else {
			$data['error_date_start'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/cashback', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('module/cashback', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['cashback_discount'])) {
			$data['discount'] = $this->request->post['cashback_discount'];
		} else {
			$data['discount'] = $this->config->get('cashback_discount');
		}

		if (isset($this->request->post['cashback_min_total'])) {
			$data['min_total'] = $this->request->post['cashback_min_total'];
		} else {
			$data['min_total'] = $this->config->get('cashback_min_total');
		}

		if (isset($this->request->post['cashback_max_total'])) {
			$data['max_total'] = $this->request->post['cashback_max_total'];
		} else {
			$data['max_total'] = $this->config->get('cashback_max_total');
		}

		if (isset($this->request->post['cashback_valid'])) {
			$data['valid'] = $this->request->post['cashback_valid'];
		} else {
			$data['valid'] = $this->config->get('cashback_valid');
		}

		if (isset($this->request->post['cashback_date_start'])) {
			$data['date_start'] = $this->request->post['cashback_date_start'];
		} else {
			$data['date_start'] = $this->config->get('cashback_date_start');
		}

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		if (isset($this->request->post['cashback_voucher_theme_id'])) {
			$data['cashback_voucher_theme_id'] = $this->request->post['cashback_voucher_theme_id'];
		} else {
			$data['cashback_voucher_theme_id'] = $this->config->get('cashback_voucher_theme_id');
		}

		if (isset($this->request->post['cashback_status'])) {
			$data['status'] = $this->request->post['cashback_status'];
		} else {
			$data['status'] = $this->config->get('cashback_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/cashback_form', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/cashback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['cashback_discount'] < 0 || !is_numeric($this->request->post['cashback_discount'])) {
			$this->error['discount'] = $this->language->get('error_discount');
		}
		if (!$this->request->post['cashback_min_total'] == '' && !is_numeric($this->request->post['cashback_min_total'])) {
			$this->error['min_total'] = $this->language->get('error_total');
		}
		if (!$this->request->post['cashback_max_total'] == '' && !is_numeric($this->request->post['cashback_max_total'])) {
			$this->error['max_total'] = $this->language->get('error_total');
		}
		if (!$this->request->post['cashback_valid'] == '' && !is_numeric($this->request->post['cashback_valid'])) {
			$this->error['valid'] = $this->language->get('error_valid');
		}
		
		return !$this->error;
	}
}