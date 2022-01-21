<?php
class ControllerPaymentLink extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/link');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('link', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
		}

		$language_items = array(
			'heading_title',
			'text_edit',
			'text_enabled',
			'text_disabled',
			'text_all_zones',
			'text_all_zones',
			'entry_instruction',
			'entry_total',
			'entry_order_status',
			'entry_geo_zone',
			'entry_status',
			'entry_sort_order',
			'help_total',
			'button_save',
			'button_cancel',
		);
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->error['instruction' . $language['language_id']])) {
				$data['error_instruction' . $language['language_id']] = $this->error['instruction' . $language['language_id']];
			} else {
				$data['error_instruction' . $language['language_id']] = '';
			}
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/link', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('payment/link', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);

		$this->load->model('localisation/language');

		foreach ($languages as $language) {
			if (isset($this->request->post['link_instruction' . $language['language_id']])) {
				$data['link_instruction' . $language['language_id']] = $this->request->post['link_instruction' . $language['language_id']];
			} else {
				$data['link_instruction' . $language['language_id']] = $this->config->get('link_instruction' . $language['language_id']);
			}
		}

		$data['languages'] = $languages;

		if (isset($this->request->post['link_total'])) {
			$data['link_total'] = $this->request->post['link_total'];
		} else {
			$data['link_total'] = $this->config->get('link_total');
		}

		if (isset($this->request->post['link_order_status_id'])) {
			$data['link_order_status_id'] = $this->request->post['link_order_status_id'];
		} else {
			$data['link_order_status_id'] = $this->config->get('link_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['link_geo_zone_id'])) {
			$data['link_geo_zone_id'] = $this->request->post['link_geo_zone_id'];
		} else {
			$data['link_geo_zone_id'] = $this->config->get('link_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['link_status'])) {
			$data['link_status'] = $this->request->post['link_status'];
		} else {
			$data['link_status'] = $this->config->get('link_status');
		}

		if (isset($this->request->post['link_sort_order'])) {
			$data['link_sort_order'] = $this->request->post['link_sort_order'];
		} else {
			$data['link_sort_order'] = $this->config->get('link_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/link.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/link')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (empty($this->request->post['link_instruction' . $language['language_id']])) {
				$this->error['instruction' .  $language['language_id']] = $this->language->get('error_instruction');
			}
		}

		return !$this->error;
	}
}