<?php
class ControllerShippingRajaOngkir extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('shipping/raja_ongkir');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('shipping/raja_ongkir');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!$this->request->post['raja_ongkir_base_url']) {
				$this->request->post['raja_ongkir_province_id'] = 0;
				$this->request->post['raja_ongkir_city_id'] = 0;
				$this->request->post['raja_ongkir_subdistrict_id'] = 0;
			}

			$this->model_setting_setting->editSetting('raja_ongkir', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (!$this->request->post['raja_ongkir_base_url']) {
				$this->cache->delete('raja_ongkir');

				$this->response->redirect($this->url->link('shipping/raja_ongkir', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true));
			}
		}

		$language_items = array(
			'heading_title',
			'text_all_zones',
			'text_credential',
			'text_disabled',
			'text_edit',
			'text_enabled',
			'text_general',
			'text_no',
			'text_none',
			'text_origin',
			'text_select',
			'text_select_all',
			'text_unselect_all',
			'text_yes',
			'entry_account_type',
			'entry_api_key',
			'entry_base_url',
			'entry_city',
			'entry_geo_zone',
			'entry_province',
			'entry_courier',
			'entry_service',
			'entry_sort_order',
			'entry_status',
			'entry_subdistrict',
			'entry_tax_class',
			'entry_weight_class',
			'help_api_key',
			'help_base_url',
			'help_courier',
			'help_service',
			'button_account',
			'button_cache_delete',
			'button_save',
			'button_cancel',
		);
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$error_items = array(
			'warning',
			'api_key',
			'base_url',
			'province',
			'city',
			'weight_class'
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
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/raja_ongkir', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('shipping/raja_ongkir', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['raja_ongkir_account_type'])) {
			$data['raja_ongkir_account_type'] = $this->request->post['raja_ongkir_account_type'];
		} elseif ($this->config->has('raja_ongkir_account_type')) {
			$data['raja_ongkir_account_type'] = $this->config->get('raja_ongkir_account_type');
		} else {
			$data['raja_ongkir_account_type'] = 'starter';
		}

		$data['accounts'] = $this->model_shipping_raja_ongkir->getAccount();
		foreach (array_keys($data['accounts']) as $type) {
			$data['accounts'][$type]['text'] = $this->language->get('text_' . $type);
		}

		if (isset($this->request->post['raja_ongkir_api_key'])) {
			$data['raja_ongkir_api_key'] = $this->request->post['raja_ongkir_api_key'];
		} else {
			$data['raja_ongkir_api_key'] = $this->config->get('raja_ongkir_api_key');
		}

		$data['raja_ongkir_base_url'] = $data['accounts'][$data['raja_ongkir_account_type']]['base_url'];

		if (isset($this->request->post['raja_ongkir_province_id'])) {
			$data['raja_ongkir_province_id'] = $this->request->post['raja_ongkir_province_id'];
		} else {
			$data['raja_ongkir_province_id'] = $this->config->get('raja_ongkir_province_id');
		}

		if (isset($this->request->post['raja_ongkir_city_id'])) {
			$data['raja_ongkir_city_id'] = $this->request->post['raja_ongkir_city_id'];
		} else {
			$data['raja_ongkir_city_id'] = $this->config->get('raja_ongkir_city_id');
		}

		if (isset($this->request->post['raja_ongkir_subdistrict_id'])) {
			$data['raja_ongkir_subdistrict_id'] = $this->request->post['raja_ongkir_subdistrict_id'];
		} else {
			$data['raja_ongkir_subdistrict_id'] = $this->config->get('raja_ongkir_subdistrict_id');
		}

		$data['provinces'] = [];
		$data['cities'] = [];

		if ($data['raja_ongkir_api_key']) {
			$data['provinces'] = $this->model_shipping_raja_ongkir->getProvinces();
			$data['cities'] = $this->model_shipping_raja_ongkir->getCities();

			if ($data['provinces']) {
				$data['information'] = $this->language->get('text_status_active');
			} else {
				$data['error_warning'] = $this->language->get('text_status_not_active');
			}
		}

		if (isset($this->request->post['raja_ongkir_courier'])) {
			$data['raja_ongkir_courier'] = $this->request->post['raja_ongkir_courier'];
		} elseif ($this->config->has('raja_ongkir_courier')) {
			$data['raja_ongkir_courier'] = $this->config->get('raja_ongkir_courier');
		} else {
			$data['raja_ongkir_courier'] = array();
		}

		if (isset($this->request->post['raja_ongkir_service'])) {
			$data['raja_ongkir_service'] = $this->request->post['raja_ongkir_service'];
		} elseif ($this->config->has('raja_ongkir_service')) {
			$data['raja_ongkir_service'] = $this->config->get('raja_ongkir_service');
		} else {
			$data['raja_ongkir_service'] = array();
		}

		$data['couriers'] = [];

		$couriers = [
			'jne'		=> ['--- All Services ---', 'CTC', 'CTCYES', 'OKE', 'REG', 'YES', 'SPS'],
			'tiki'		=> ['--- All Services ---', 'ECO', 'REG', 'ONS'],
			'pos'		=> ['--- All Services ---', 'Paket Kilat Khusus', 'Pos Instan Barang', 'Express Next Day Barang'],
			'jnt'		=> ['--- All Services ---', 'service'],
			'sicepat'	=> ['--- All Services ---', 'service']
		];
		foreach ($couriers as $courier => $services) {
			$service_data = [];

			foreach ($services as $service) {
				$service_data[] = [
					'code'	=> $courier . '.' . $service,
					'text'	=> $service
				];
			}

			$data['couriers'][] = [
				'code'		=> $courier,
				'text'		=> $this->language->get('text_' . $courier),
				'services' => $service_data
			];
		}

		if (isset($this->request->post['raja_ongkir_weight_class_id'])) {
			$data['raja_ongkir_weight_class_id'] = $this->request->post['raja_ongkir_weight_class_id'];
		} else {
			$data['raja_ongkir_weight_class_id'] = $this->config->get('raja_ongkir_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['raja_ongkir_length_code'])) {
			$data['raja_ongkir_length_code'] = $this->request->post['raja_ongkir_length_code'];
		} else {
			$data['raja_ongkir_length_code'] = $this->config->get('raja_ongkir_length_code');
		}

		if (isset($this->request->post['raja_ongkir_tax_class_id'])) {
			$data['raja_ongkir_tax_class_id'] = $this->request->post['raja_ongkir_tax_class_id'];
		} else {
			$data['raja_ongkir_tax_class_id'] = $this->config->get('raja_ongkir_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['raja_ongkir_geo_zone_id'])) {
			$data['raja_ongkir_geo_zone_id'] = $this->request->post['raja_ongkir_geo_zone_id'];
		} else {
			$data['raja_ongkir_geo_zone_id'] = $this->config->get('raja_ongkir_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['raja_ongkir_status'])) {
			$data['raja_ongkir_status'] = $this->request->post['raja_ongkir_status'];
		} else {
			$data['raja_ongkir_status'] = $this->config->get('raja_ongkir_status');
		}

		if (isset($this->request->post['raja_ongkir_sort_order'])) {
			$data['raja_ongkir_sort_order'] = $this->request->post['raja_ongkir_sort_order'];
		} else {
			$data['raja_ongkir_sort_order'] = $this->config->get('raja_ongkir_sort_order');
		}


		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/raja_ongkir', $data));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'shipping/raja_ongkir')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['raja_ongkir_api_key']) {
			$this->error['api_key'] = $this->language->get('error_api_key');
		}

		if ($this->request->post['raja_ongkir_base_url']) {
			if (empty($this->request->post['raja_ongkir_province_id'])) {
				$this->error['province'] = $this->language->get('error_province');
			}

			if (empty($this->request->post['raja_ongkir_city_id'])) {
				$this->error['city'] = $this->language->get('error_city');
			}

			$this->load->model('localisation/weight_class');
			$weight_class_info = $this->model_localisation_weight_class->getWeightClassDescriptionByUnit('g');

			if ($this->request->post['raja_ongkir_weight_class_id'] != $weight_class_info['weight_class_id']) {
				$this->error['weight_class'] = $this->language->get('error_weight_class');
			}
		}

		return !$this->error;
	}

	public function city()
	{
		$this->load->language('shipping/raja_ongkir');

		$json = array();

		if (!$this->user->hasPermission('modify', 'shipping/raja_ongkir')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if ($this->request->get['province_id']) {
				$this->load->model('shipping/raja_ongkir');

				$cities = $this->model_shipping_raja_ongkir->getCities($this->request->get['province_id']);

				if ($cities) {
					$html = '<option value="0">' . $this->language->get('text_select') . '</option>';

					foreach ($cities as $city) {
						$html .= '<option value="' . $city['city_id'] . '"';

						if ($city['city_id'] == $this->config->get('raja_ongkir_city_id')) {
							$html .= ' selected="selected"';
						}

						$html .= '>' . $city['type'] . ' ' . $city['city_name'] . '</option>';
					}
				} else {
					$html = '<option value="0">' . $this->language->get('text_none') . '</option>';
				}
			} else {
				$html = '<option value="0">' . $this->language->get('text_none') . '</option>';
			}

			$json['html'] = $html;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function subdistrict()
	{
		$this->load->language('shipping/raja_ongkir');

		$json = array();

		if (!$this->user->hasPermission('modify', 'shipping/raja_ongkir')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if ($this->request->get['city_id']) {
				$this->load->model('shipping/raja_ongkir');

				$subdistricts = $this->model_shipping_raja_ongkir->getSubdistricts($this->request->get['city_id']);

				if ($subdistricts) {
					$html = '<option value="0">' . $this->language->get('text_select') . '</option>';

					foreach ($subdistricts as $subdistrict) {
						$html .= '<option value="' . $subdistrict['subdistrict_id'] . '"';

						if ($subdistrict['subdistrict_id'] == $this->config->get('raja_ongkir_subdistrict_id')) {
							$html .= ' selected="selected"';
						}

						$html .= '>' . $subdistrict['type'] . ' ' . $subdistrict['city_name'] . '</option>';
					}
				} else {
					$html = '<option value="0">' . $this->language->get('text_none') . '</option>';
				}
			} else {
				$html = '<option value="0">' . $this->language->get('text_none') . '</option>';
			}

			$json['html'] = $html;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function deleteCache()
	{
		$this->load->language('shipping/raja_ongkir');

		$json = array();

		if (!$this->user->hasPermission('modify', 'shipping/raja_ongkir')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->cache->delete('raja_ongkir');

			$json['cache_deleted'] = $this->language->get('text_cache_deleted');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
