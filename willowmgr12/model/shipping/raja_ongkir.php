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

	public function getAccount($account_type = '')
	{
		if (in_array($account_type, array_keys($this->account))) {
			return $this->account[$account_type];
		} else {
			return $this->account;
		}
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
			// $err = curl_error($curl);

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
