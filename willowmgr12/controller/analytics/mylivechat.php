<?php
class ControllerAnalyticsMylivechat extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('analytics/mylivechat');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('mylivechat', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/analytics', 'token=' . $this->session->data['token'], true));
		}
		
		$language_items = [
			'heading_title',
			'text_edit',
			'text_enabled',
			'text_disabled',
			'text_signup',
			'text_header',
			'text_footer',
			'entry_code',
			'entry_position',
			'entry_status',
			'button_save',
			'button_cancel'
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_analytics'),
			'href' => $this->url->link('extension/analytics', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('analytics/mylivechat', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('analytics/mylivechat', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['cancel'] = $this->url->link('extension/analytics', 'token=' . $this->session->data['token'], true);
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('mylivechat', $this->request->get['store_id']);
		}

		if (isset($this->request->post['mylivechat_code'])) {
			$data['mylivechat_code'] = $this->request->post['mylivechat_code'];
		} elseif(isset($setting_info['mylivechat_code'])) {
			$data['mylivechat_code'] = $setting_info['mylivechat_code'];
		} else {
			$data['mylivechat_code'] = '';
		}
		
		if (isset($this->request->post['mylivechat_position'])) {
			$data['mylivechat_position'] = $this->request->post['mylivechat_position'];
		} elseif(isset($setting_info['mylivechat_position'])) {
			$data['mylivechat_position'] = $setting_info['mylivechat_position'];
		} else {
			$data['mylivechat_position'] = 'header';
		}
		
		if (isset($this->request->post['mylivechat_status'])) {
			$data['mylivechat_status'] = $this->request->post['mylivechat_status'];
		} elseif(isset($setting_info['mylivechat_status'])) {
			$data['mylivechat_status'] = $setting_info['mylivechat_status'];
		} else {
			$data['mylivechat_status'] = 0;
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('analytics/mylivechat', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'analytics/mylivechat')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['mylivechat_code']) {
			$this->error['code'] = $this->language->get('error_code');
		}			

		return !$this->error;
	}
}
