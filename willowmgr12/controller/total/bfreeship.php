<?php
class ControllerTotalBfreeship extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/bfreeship');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bfreeship', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_multizone'] = $this->language->get('entry_multizone');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_multizone'] = $this->language->get('help_multizone');
		$data['help_limit'] = $this->language->get('help_limit');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('total/bfreeship', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('total/bfreeship', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['bfreeship_multizone'])) {
			$data['bfreeship_multizone'] = $this->request->post['bfreeship_multizone'];
		} else {
			$data['bfreeship_multizone'] = $this->config->get('bfreeship_multizone');
		}

		if (isset($this->request->post['bfreeship_limit'])) {
			$data['bfreeship_limit'] = $this->request->post['bfreeship_limit'];
		} else {
			$data['bfreeship_limit'] = $this->config->get('bfreeship_limit');
		}

		if (isset($this->request->post['bfreeship_status'])) {
			$data['bfreeship_status'] = $this->request->post['bfreeship_status'];
		} else {
			$data['bfreeship_status'] = $this->config->get('bfreeship_status');
		}

		if (isset($this->request->post['bfreeship_sort_order'])) {
			$data['bfreeship_sort_order'] = $this->request->post['bfreeship_sort_order'];
		} else {
			$data['bfreeship_sort_order'] = $this->config->get('bfreeship_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/bfreeship', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/bfreeship')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->request->post['bfreeship_limit'] = abs($this->request->post['bfreeship_limit']);
		
		return !$this->error;
	}
}