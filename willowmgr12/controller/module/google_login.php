<?php
class ControllerModuleGoogleLogin extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('module/google_login');

		$this->load->model('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('google_login', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$language_items = array(
			'heading_title',
			'text_edit',
			'text_disabled',
			'text_enabled',
			'text_yes',
			'text_no',
			'entry_client_id',
			'entry_secret',
			'entry_redirect_uri',
			'entry_button_image',
			'entry_status',
			'help_redirect_uri',
			'button_save',
			'button_cancel'
		);
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$error_items = array(
			'warning',
			'client_id',
			'secret',
			'redirect_uri'
		);
		foreach ($error_items as $error_item) {
			if (isset($this->error[$error_item])) {
				$data['error_' . $error_item] = $this->error[$error_item];
			} else {
				$data['error_' . $error_item] = '';
			}
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
			'href' => $this->url->link('module/google_login', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('module/google_login', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['google_login_client_id'])) {
			$data['google_login_client_id'] = $this->request->post['google_login_client_id'];
		} else {
			$data['google_login_client_id'] = $this->config->get('google_login_client_id');
		}

		if (isset($this->request->post['google_login_secret'])) {
			$data['google_login_secret'] = $this->request->post['google_login_secret'];
		} else {
			$data['google_login_secret'] = $this->config->get('google_login_secret');
		}

		if (isset($this->request->post['google_login_redirect_uri'])) {
			$data['google_login_redirect_uri'] = filter_var($this->request->post['google_login_redirect_uri'], FILTER_SANITIZE_URL);
		} else {
			$data['google_login_redirect_uri'] = $this->config->get('google_login_redirect_uri');
		}

		if (isset($this->request->post['google_login_button_image'])) {
			$data['google_login_button_image'] = $this->request->post['google_login_button_image'];
		} elseif ($this->config->get('google_login_button_image')) {
			$data['google_login_button_image'] = $this->config->get('google_login_button_image');
		} else {
			$data['google_login_button_image'] = '';
		}

		$this->load->model('tool/image');

		if (!empty($data['google_login_button_image']) && is_file(DIR_IMAGE . $data['google_login_button_image'])) {
			$data['thumb'] = $this->model_tool_image->resize($data['google_login_button_image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['google_login_status'])) {
			$data['google_login_status'] = $this->request->post['google_login_status'];
		} else {
			$data['google_login_status'] = $this->config->get('google_login_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/google_login', $data));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'module/google_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['google_login_client_id']) {
			$this->error['client_id'] = $this->language->get('error_client_id');
		}

		if (!$this->request->post['google_login_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}

		if (!$this->request->post['google_login_redirect_uri']) {
			$this->error['redirect_uri'] = $this->language->get('error_redirect_uri');
		}

		return !$this->error;
	}
}
