<?php
class ControllerTotalBonkUnique extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/bonkunique');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bonkunique', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_min'] = $this->language->get('entry_min');
		$data['entry_max'] = $this->language->get('entry_max');
		$data['entry_operation'] = $this->language->get('entry_operation');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['value_add'] = $this->language->get('value_add');
		$data['value_substract'] = $this->language->get('value_substract');

		$data['help_max'] = $this->language->get('help_max');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['bonkunique_min'])) {
			$data['error_bonkunique_min'] = $this->error['bonkunique_min'];
		} else {
			$data['error_bonkunique_min'] = '';
		}

		if (isset($this->error['bonkunique_max'])) {
			$data['error_bonkunique_max'] = $this->error['bonkunique_max'];
		} else {
			$data['error_bonkunique_max'] = '';
		}

		if (isset($this->error['bonkunique_max'])) {
			$data['error_bonkunique_low'] = $this->error['bonkunique_max'];
		} else {
			$data['error_bonkunique_low'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('total/bonkunique', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('total/bonkunique', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['bonkunique_min'])) {
			$data['bonkunique_min'] = $this->request->post['bonkunique_min'];
		} else {
			$data['bonkunique_min'] = $this->config->get('bonkunique_min');
		}

		if (isset($this->request->post['bonkunique_max'])) {
			$data['bonkunique_max'] = $this->request->post['bonkunique_max'];
		} else {
			$data['bonkunique_max'] = $this->config->get('bonkunique_max');
		}

		if (isset($this->request->post['bonkunique_operation'])) {
			$data['bonkunique_operation'] = $this->request->post['bonkunique_operation'];
		} else {
			$data['bonkunique_operation'] = $this->config->get('bonkunique_operation');
		}

		if (isset($this->request->post['bonkunique_status'])) {
			$data['bonkunique_status'] = $this->request->post['bonkunique_status'];
		} else {
			$data['bonkunique_status'] = $this->config->get('bonkunique_status');
		}

		if (isset($this->request->post['bonkunique_sort_order'])) {
			$data['bonkunique_sort_order'] = $this->request->post['bonkunique_sort_order'];
		} else {
			$data['bonkunique_sort_order'] = $this->config->get('bonkunique_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/bonkunique', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/bonkunique')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['bonkunique_min'] == '' || !is_numeric($this->request->post['bonkunique_min'])) {
			$this->error['bonkunique_min'] = $this->language->get('error_bonkunique_min');
		} else if ($this->request->post['bonkunique_max'] == '' || !is_numeric($this->request->post['bonkunique_max'])) {
			$this->error['bonkunique_max'] = $this->language->get('error_bonkunique_max');
		} else if ($this->request->post['bonkunique_min'] >= $this->request->post['bonkunique_max']) {
			$this->error['bonkunique_max'] = $this->language->get('error_bonkunique_low');
		}

		return !$this->error;
	}
}