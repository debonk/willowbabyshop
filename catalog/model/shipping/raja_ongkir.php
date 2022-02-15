<?php
class ModelShippingRajaOngkir extends Model
{
	private $account = [
		'starter'	=> [
			'value'		=> 'starter',
			'base_url'	=> 'https://api.rajaongkir.com/starter'
		],
		'basic'	=> [
			'value'		=> 'basic',
			'base_url'	=> 'https://api.rajaongkir.com/basic'
		],
		'pro'	=> [
			'value'		=> 'pro',
			'base_url'	=> 'https://pro.rajaongkir.com/api'
		]
	];

	function getQuote($address)
	{
		$this->load->language('shipping/raja_ongkir');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('raja_ongkir_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('raja_ongkir_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->config->get('raja_ongkir_weight_class_id'));

			$account_type = $this->config->get('raja_ongkir_account_type');

			# Check Province
			$provinces = $this->getProvinces();

			foreach ($provinces as $province) {
				if (strcasecmp($province['province'], $address['country']) == 0) {
					$destination_province_id = $province['province_id'];

					break;
				}
			}

			# Check City
			$cities = $this->getCities($destination_province_id);

			foreach ($cities as $city) {
				if (strcasecmp(stristr($address['zone'], $city['city_name']), $city['city_name']) == 0) {
					$destination = $city['city_id'];

					break;
				}
			}

			$couriers = $this->config->get('raja_ongkir_courier');
			$services = $this->config->get('raja_ongkir_service');

			$server = $this->request->server['HTTPS'] ? $this->config->get('config_ssl') : $this->config->get('config_url');
	
			if ($account_type == 'pro') {
				$origin = !empty($this->config->get('raja_ongkir_subdistrict_id')) ? $this->config->get('raja_ongkir_subdistrict_id') : $this->config->get('raja_ongkir_city_id');
				$origin_type = !empty($this->config->get('raja_ongkir_subdistrict_id')) ? 'subdistrict' : 'city';

				$destination_type = 'city';

				# Check Subdistrict
				$subdistricts = $this->getSubdistricts($destination);

				foreach ($subdistricts as $subdistrict) {
					if (strcasecmp($address['city_name'], $subdistrict['subdistrict_name']) == 0) {
						$destination = $subdistrict['subdistrict_id'];
						$destination_type = 'subdistrict';

						break;
					}
				}

				$courier = implode(':', $couriers);

				$cost_data = [
					'origin'			=> $origin,
					'origin_type'		=> $origin_type,
					'destination'		=> $destination,
					'destination_type'	=> $destination_type,
					'weight'			=> $weight,
					'courier'			=> $courier
				];

				$results = $this->getCost($cost_data);

				# sample data agar tidak call API ke server raja ongkir
				// $results = '{"rajaongkir":{"query":{"origin":"6145","originType":"subdistrict","destination":"6138","destinationType":"subdistrict","weight":50000,"courier":"jne:tiki:pos"},"status":{"code":200,"description":"OK"},"origin_details":{"subdistrict_id":"6145","province_id":"11","province":"Jawa Timur","city_id":"444","city":"Surabaya","type":"Kota","subdistrict_name":"Mulyorejo"},"destination_details":{"subdistrict_id":"6138","province_id":"11","province":"Jawa Timur","city_id":"444","city":"Surabaya","type":"Kota","subdistrict_name":"Gubeng"},"results":[{"code":"jne","name":"Jalur Nugraha Ekakurir (JNE)","costs":[{"service":"CTC","description":"JNE City Courier","cost":[{"value":350000,"etd":"2-3","note":""}]},{"service":"CTCYES","description":"JNE City Courier","cost":[{"value":500000,"etd":"1-1","note":""}]}]},{"code":"tiki","name":"Citra Van Titipan Kilat (TIKI)","costs":[{"service":"ECO","description":"Economy Service","cost":[{"value":200000,"etd":"2","note":""}]},{"service":"REG","description":"Regular Service","cost":[{"value":350000,"etd":"2","note":""}]},{"service":"ONS","description":"Over Night Service","cost":[{"value":450000,"etd":"1","note":""}]}]},{"code":"pos","name":"POS Indonesia (POS)","costs":[{"service":"Paket Kilat Khusus","description":"Paket Kilat Khusus","cost":[{"value":350000,"etd":"2 HARI","note":""}]}]}]}}';

				// $results = json_decode($results, true)['rajaongkir'];

				// if ($results['status']['code'] == 200) {
				// 	$results = $results['results'];
				// }
				# End of sample data

				foreach ($results as $result) {
					$error = '';
					$quote_data = [];
					
					foreach ($result['costs'] as $costs) {
						$code = $result['code'] . '.' . $costs['service'];
						$cost = $costs['cost'][0]['value'];

						# Check service yg aktif
						if ((!in_array($result['code'] . '.--- All Services ---', $services) && !in_array($code, $services)) || !$cost) {
							continue;
						}

						$quote_data[$costs['service']] = [
							'code'         => 'raja_ongkir_' . $code,
							'title'        => $this->language->get('text_' . $result['code']) . ' (' . $costs['description'] . ')',
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('raja_ongkir_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('raja_ongkir_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
						];
					}

					$title = $result['name'];

					if (is_file(DIR_IMAGE . 'shipping/' . $result['code'] . '.png')) {
						$logo = $server . 'image/' . 'shipping/' . $result['code'] . '.png';
					} else {
						$logo = '';
					}

					if ($quote_data || $error) {
						$method_data['multi_shipping'][$result['code']] = array(
							'code'       => 'raja_ongkir_' . $result['code'],
							'logo'       => $logo,
							'title'      => $title,
							'quote'      => $quote_data,
							'sort_order' => $this->config->get('raja_ongkir_sort_order'),
							'error'      => $error
						);
					}
				}

			} else {
				$origin = $this->config->get('raja_ongkir_city_id');

				foreach ($couriers as $courier) {
					$error = '';
					$quote_data = [];

					$cost_data = [
						'origin'		=> $origin,
						'destination'	=> $destination,
						'weight'		=> $weight,
						'courier'		=> $courier
					];

					$results = $this->getCost($cost_data);

					# sample data agar tidak call API ke server raja ongkir
					// if ($courier == 'pos') {
					// 	$results = '{"rajaongkir":{"query":{"origin":"444","destination":"444","weight":950,"courier":"pos"},"status":{"code":200,"description":"OK"},"origin_details":{"city_id":"444","province_id":"11","province":"Jawa Timur","type":"Kota","city_name":"Surabaya","postal_code":"60119"},"destination_details":{"city_id":"444","province_id":"11","province":"Jawa Timur","type":"Kota","city_name":"Surabaya","postal_code":"60119"},"results":[{"code":"pos","name":"POS Indonesia (POS)","costs":[{"service":"Paket Kilat Khusus","description":"Paket Kilat Khusus","cost":[{"value":7000,"etd":"2 HARI","note":""}]},{"service":"Pos Instan Barang","description":"Pos Instan Barang","cost":[{"value":12000,"etd":"0 HARI","note":""}]},{"service":"Express Next Day Barang","description":"Express Next Day Barang","cost":[{"value":10000,"etd":"1 HARI","note":""}]}]}]}}';
					// } elseif ($courier == 'tiki') {
					// 	$results = '{"rajaongkir":{"query":{"origin":"444","destination":"444","weight":2120,"courier":"tiki"},"status":{"code":200,"description":"OK"},"origin_details":{"city_id":"444","province_id":"11","province":"Jawa Timur","type":"Kota","city_name":"Surabaya","postal_code":"60119"},"destination_details":{"city_id":"444","province_id":"11","province":"Jawa Timur","type":"Kota","city_name":"Surabaya","postal_code":"60119"},"results":[{"code":"tiki","name":"Citra Van Titipan Kilat (TIKI)","costs":[{"service":"ECO","description":"Economy Service","cost":[{"value":8000,"etd":"2","note":""}]},{"service":"REG","description":"Regular Service","cost":[{"value":14000,"etd":"2","note":""}]},{"service":"ONS","description":"Over Night Service","cost":[{"value":18000,"etd":"1","note":""}]}]}]}}';
					// } else {
					// 	$results = '{"rajaongkir":{"query":{"origin":"444","destination":"386","weight":950,"courier":"jne"},"status":{"code":200,"description":"OK"},"origin_details":{"city_id":"444","province_id":"11","province":"Jawa Timur","type":"Kota","city_name":"Surabaya","postal_code":"60119"},"destination_details":{"city_id":"386","province_id":"10","province":"Jawa Tengah","type":"Kota","city_name":"Salatiga","postal_code":"50711"},"results":[{"code":"jne","name":"Jalur Nugraha Ekakurir (JNE)","costs":[{"service":"OKE","description":"Ongkos Kirim Ekonomis","cost":[{"value":16000,"etd":"3-6","note":""}]},{"service":"REG","description":"Layanan Reguler","cost":[{"value":19000,"etd":"2-3","note":""}]},{"service":"YES","description":"Yakin Esok Sampai","cost":[{"value":29000,"etd":"1-1","note":""}]}]}]}}';
					// }

					// $results = json_decode($results, true)['rajaongkir'];

					// if ($results['status']['code'] == 200) {
					// 	$results = $results['results'];
					// }
					# End of sample data

					foreach ($results as $result) {
						foreach ($result['costs'] as $costs) {
							$code = $result['code'] . '.' . $costs['service'];
							$cost = $costs['cost'][0]['value'];

							# Check service yg aktif
							if ((!in_array($result['code'] . '.--- All Services ---', $services) && !in_array($code, $services)) || !$cost) {
								continue;
							}

							$quote_data[$costs['service']] = [
								'code'         => 'raja_ongkir_' . $code,
								'title'        => $this->language->get('text_' . $result['code']) . ' (' . $costs['service'] . ')',
								'cost'         => $cost,
								'tax_class_id' => $this->config->get('raja_ongkir_tax_class_id'),
								'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('raja_ongkir_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
							];
						}

						$title = $result['name'];

						if (is_file(DIR_IMAGE . 'shipping/' . $result['code'] . '.png')) {
							$logo = $server . 'image/' . 'shipping/' . $result['code'] . '.png';
						} else {
							$logo = '';
						}

						if ($quote_data || $error) {
							$method_data['multi_shipping'][$result['code']] = array(
								'code'       => 'raja_ongkir_' . $result['code'],
								'logo'       => $logo,
								'title'      => $title,
								'quote'      => $quote_data,
								'sort_order' => $this->config->get('raja_ongkir_sort_order'),
								'error'      => $error
							);
						}
					}
				}
			}
		}

		return $method_data;
	}

	public function getCost($data)
	{
		$api_key = $this->config->get('raja_ongkir_api_key');
		$account_type = $this->config->has('raja_ongkir_account_type') ? $this->config->get('raja_ongkir_account_type') : 'starter';

		$url = $this->db->escape($this->account[$account_type]['base_url']) . '/cost';

		if ($account_type == 'pro') {
			$post_fields = 'origin=' . (int)$data['origin'] . '&originType=' . $this->db->escape($data['origin_type']) . '&destination=' . (int)$data['destination'] . '&destinationType=' . $this->db->escape($data['destination_type']) . '&weight=' . (int)$data['weight'] . '&courier=' . $this->db->escape($data['courier']);
		} else {
			$post_fields = 'origin=' . (int)$data['origin'] . '&destination=' . (int)$data['destination'] . '&weight=' . (int)$data['weight'] . '&courier=' . $this->db->escape($data['courier']);
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $post_fields,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: " . $this->db->escape($api_key)
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response = json_decode($response, true)['rajaongkir'];

		if ($response['status']['code'] == 200) {
			$request_data = $response['results'];
		}

		return $request_data;
	}

	public function getProvinces()
	{
		$request_data = $this->cache->get('raja_ongkir.province');

		if (!$request_data) {
			$api_key = $this->config->get('raja_ongkir_api_key');
			$account_type = $this->config->has('raja_ongkir_account_type') ? $this->config->get('raja_ongkir_account_type') : 'starter';

			$url = $this->db->escape($this->account[$account_type]['base_url']) . '/province';

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"key: " . $this->db->escape($api_key)
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response, true)['rajaongkir'];

			if ($response['status']['code'] == 200) {
				$request_data = $response['results'];
			}

			$this->cache->set('raja_ongkir.province', $request_data);
		}

		return $request_data;
	}

	public function getCities($province_id = 0)
	{
		$request_data = $this->cache->get('raja_ongkir.city');

		if (!$request_data) {
			$api_key = $this->config->get('raja_ongkir_api_key');
			$account_type = $this->config->has('raja_ongkir_account_type') ? $this->config->get('raja_ongkir_account_type') : 'starter';

			$url = $this->db->escape($this->account[$account_type]['base_url']) . '/city';

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"key: " . $this->db->escape($api_key)
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response, true)['rajaongkir'];

			if ($response['status']['code'] == 200) {
				$request_data = [];

				foreach ($response['results'] as $value) {
					$request_data[$value['province_id']][] = $value;
				}

				$this->cache->set('raja_ongkir.city', $request_data);
			}
		}

		if ((int)$province_id) {
			$request_data = $request_data[(int)$province_id];
		}

		return $request_data;
	}

	public function getSubdistricts($city_id)
	{
		$api_key = $this->config->get('raja_ongkir_api_key');
		$account_type = $this->config->has('raja_ongkir_account_type') ? $this->config->get('raja_ongkir_account_type') : 'starter';

		$url = $this->db->escape($this->account[$account_type]['base_url']) . '/subdistrict?city=' . (int)$city_id;

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: " . $this->db->escape($api_key)
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response = json_decode($response, true)['rajaongkir'];

		if ($response['status']['code'] == 200) {
			$request_data = $response['results'];
		} else {
			$request_data = [];
		}

		return $request_data;
	}
}
