<?php
class ControllerCatalogTool extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('catalog/tool');

		$this->document->setTitle($this->language->get('heading_title'));

		$language_items = [
			'heading_title',
			'text_confirm',
			'entry_new_product',
			'button_export',
			'button_import',
			'button_clear'
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true)
		);

		$data['import'] = $this->url->link('catalog/tool/import', 'token=' . $this->session->data['token'], true);
		$data['clear'] = $this->url->link('catalog/tool/clear', 'token=' . $this->session->data['token'], true);

		$data['log'] = '';

		$file = DIR_LOGS . 'catalog_tool.log';

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/tool', $data));
	}

	public function import()
	{
		$this->load->language('catalog/tool');

		unset($this->session->data['product_data']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'catalog/tool')) {
			$this->load->model('tool/spreadsheet');

			if (is_uploaded_file($this->request->files['new_product']['tmp_name'])) {
				$sheet_data = $this->model_tool_spreadsheet->getSheetData($this->request->files['new_product']['tmp_name']);
			} else {
				$sheet_data = false;
			}

			if ($sheet_data) {
				if (!is_dir(DIR_IMAGE . 'catalog/product')) {
					@mkdir(DIR_IMAGE . 'catalog/product', 0777);
				}

				$header_data = [
					'status',
					'model',
					'name',
					'description',
					'meta_title',
					'meta_description',
					'tag',
					'price',
					'quantity',
					'minimum',
					'length',
					'width',
					'height',
					'weight',
					'manufacturer_id',
					'main_category_id',
					'sub_category_id',
					'main_image',
					'image_2',
					'image_3',
					'image_4',
					'image_5',
					'variant_image',
					'parent_model',
					'option_id',
					'option_value_id'
					// 'brand',
					// 'main_category_idx',
					// 'sub_category_idx',
					// 'main_category',
					// 'sub_category',
					// 'option_idx',
					// 'option_value',
					// 'option'
				];

				$field_data = [];

				foreach ($sheet_data[2] as $column => $header) {
					if (in_array($header, $header_data)) {
						$field_data[$header] = $column;
					}
				}

				if (count($header_data) != count($field_data)) {
					$this->session->data['error'] = $this->language->get('error_header');
				} else {
					$sheet_data = array_slice($sheet_data, 2);

					$this->session->data['product_data']['field'] = $field_data;
					$this->session->data['product_data']['products'] = $sheet_data;

					$this->log($this->language->get('text_importing'));

					$this->loopProcess();
				}
			} else {
				$this->session->data['error'] = $this->language->get('error_empty');
			}
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');
		}

		$this->response->redirect($this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true));
	}

	public function loopProcess()
	{
		$this->load->language('catalog/tool');

		$limit = 40;

		$field = $this->session->data['product_data']['field'];
		$products = $this->session->data['product_data']['products'];
		$product_count = count($products);

		$pages = ceil(($product_count) / $limit);
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 0;

		$start_row = $product_count ? $limit * ($page) : 0;
		$end_row = min($limit * ($page + 1), $product_count) - 1;

		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('localisation/weight_class');
		$this->load->model('catalog/url_alias');

		if ($page < $pages) {
			sleep(3);

			$page++;

			$this->log(sprintf($this->language->get('text_process_part'), $start_row + 1, $end_row + 1, $product_count));

			for ($i = $start_row; $i <= $end_row; $i++) {
				$product_data = $products[$i];

				$this->db->transaction(function () use ($field, $product_data) {
					$this->uploadData($field, $product_data);
				});
			}

			$loop = true;
		} else {
			unset($this->session->data['product_data']);

			$loop = false;

			$this->log($this->language->get('text_success'));
			$this->log('-------------------------' . "\n");

			$this->session->data['success'] = $this->language->get('text_success');
		}

		if ($loop) {
			$this->response->redirect($this->url->link('catalog/tool/loopProcess', 'token=' . $this->session->data['token'] . '&page=' . $page, true));
		} else {
			$this->response->redirect($this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true));
		}
	}

	private function uploadData($field, $products)
	{
		$new_product = false;
		$product_variant_data = [];

		# Used for weight conversion on product options
		$weight_class_id = $this->model_localisation_weight_class->getWeightClassDescriptionByUnit('g')['weight_class_id'];

		# Model dan name harus ada
		$required_fields = [
			'model',
			'name',
			'weight',
			'manufacturer_id',
			'main_category_id',
			'sub_category_id'
		];
		foreach ($required_fields as $required_field) {
			if (!$products[$field[$required_field]]) {
				$this->log($this->language->get('error_required'));

				return;
			}
		}

		$product_variant_info = $this->model_catalog_product->getProductVariantByModel($products[$field['model']]);

		# Product sudah ada
		if ($product_variant_info) {
			$this->log(sprintf($this->language->get('error_registered'), $products[$field['model']]));

			return;
		}

		if ($products[$field['parent_model']]) {
			if (!$products[$field['option_value_id']] || !$products[$field['option_id']]) {
				$this->log(sprintf($this->language->get('error_option'), $products[$field['model']]));

				return;
			}

			$parent_product_info = $this->model_catalog_product->getProductByModel($products[$field['parent_model']]);

			if (!$parent_product_info) {
				$new_product = true;
			}
		} else {
			$new_product = true;
		}

		if ($new_product) {
			if (!$products[$field['main_image']]) {
				# Jika New Product, Main image harus ada
				$this->log(sprintf($this->language->get('error_image'), $products[$field['model']]));

				return;
			}
		}

		# Add variant image
		$url_source = $products[$field['variant_image']];
		$variant_image = '';

		if ($products[$field['main_image']] !== $url_source && filter_var($url_source, FILTER_VALIDATE_URL)) {
			$new_image = str_replace('.', '', $products[$field['model']]) . '_v';

			$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

			$variant_image = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image, 800, 800);
		}

		$product_variant_data['variant'][0] = [
			'model'				=> $products[$field['model']],
			'quantity'			=> $products[$field['quantity']],
			'image'				=> $variant_image,
			'price'				=> $products[$field['price']],
			'points'			=> 0,
			'weight'			=> $products[$field['weight']],
			'weight_class_id'	=> $weight_class_id
		];

		if ((int)$products[$field['option_value_id']]) {
			$product_variant_data['option'][0]['option_id'] = (int)$products[$field['option_id']];
			$product_variant_data['variant'][0]['option_value_id'][0] = (int)$products[$field['option_value_id']];
		}

		if (!$new_product) { //has parent model
			$this->model_catalog_product->addProductVariant($parent_product_info['product_id'], $product_variant_data);
		} else {
			$product_data = [
				'sku'				=> '',
				'upc'				=> '',
				'ean'				=> '',
				'jan'				=> '',
				'isbn'				=> '',
				'mpn'				=> '',
				'location'			=> '',
				'minimum' 			=> 1,
				'subtract' 			=> 1,
				'stock_status_id' 	=> 5,
				'date_available' 	=> date('Y-m-d'),
				'manufacturer_id' 	=> 0,
				'shipping' 			=> 1,
				'length' 			=> 0,
				'width' 			=> 0,
				'height'			=> 0,
				'length_class_id' 	=> 1,
				'status'			=> 1,
				'tax_class_id' 		=> 0,
				'sort_order' 		=> 0,
				'image' 			=> '',
				'product_description' => [
					$this->config->get('config_language_id') => [
						'name'				=> '',
						'description'		=> '',
						'tag'				=> '',
						'meta_title'		=> '',
						'meta_description'	=> '',
						'meta_keyword'		=> ''
					]
				],
				'product_store' 	=> [0],
				'product_variant' 	=> [],
				'product_option' 	=> [],
				'product_image' 	=> [],
				'product_category' 	=> [],
				'keyword' 			=> ''
			];

			$product_data['sku'] = $products[$field['model']];
			$product_data['minimum'] = max(1, $products[$field['minimum']]);
			$product_data['manufacturer_id'] = $products[$field['manufacturer_id']];
			$product_data['length'] = $products[$field['length']];
			$product_data['width'] = $products[$field['width']];
			$product_data['height'] = $products[$field['height']];

			$product_data['product_variant'] = $product_variant_data;
			$product_data['keyword'] = preg_replace('/[\'\"*?+&\s-]+/', '-', utf8_strtolower(($products[$field['name']])));

			if ($this->model_catalog_url_alias->getUrlAlias($product_data['keyword'])) {
				$product_data['keyword'] .= '-' . token(3);
			}

			$product_data['product_description'][$this->config->get('config_language_id')] = [
				'name' 				=> utf8_strtoupper($products[$field['name']]),
				'description'		=> nl2br($products[$field['description']]),
				'meta_title'		=> $products[$field['meta_title']] ? $products[$field['meta_title']] : sprintf($this->language->get('text_meta_title'), $products[$field['name']]),
				'meta_description'	=> $products[$field['meta_description']],
				'meta_keyword'		=> '',
				'tag'				=> $products[$field['tag']] ? utf8_strtolower($products[$field['tag']]) : ''
			];

			# Add main image
			$url_source = $products[$field['main_image']];

			if (filter_var($url_source, FILTER_VALIDATE_URL)) {
				$new_image = str_replace('.', '', $products[$field['model']]);

				$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

				$product_data['image'] = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image, 800, 800);

				if (!$product_data['image']) {
					$this->log(sprintf($this->language->get('error_image_type'), $products[$field['model']]));

					return;
				}
			}
	
			for ($j = 2; $j < 6; $j++) {
				$product_image = '';

				$url_source = $products[$field['image_' . $j]];

				if (filter_var($url_source, FILTER_VALIDATE_URL)) {
					$product_image = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image . '_' . $j, 800, 800);

					if ($product_image) {
						$product_data['product_image'][] = [
							'image'			=> $product_image,
							'sort_order'	=> $j
						];
					} else {
						$this->log(sprintf($this->language->get('error_image_type'), $products[$field['model']]));
					}
				}
			}

			if (isset($products[$field['main_category_id']])) {
				$product_data['product_category'][] = $products[$field['main_category_id']];
			}

			if (isset($products[$field['sub_category_id']])) {
				$product_data['product_category'][] = $products[$field['sub_category_id']];
			}

			$this->model_catalog_product->addProduct($product_data);
		}

		$this->log(sprintf($this->language->get('text_success_product'), $products[$field['model']]));
	}

	public function log($message)
	{
		$log = new Log('catalog_tool.log');
		$log->write($message);
	}

	public function clear()
	{
		$this->load->language('catalog/tool');

		if (!$this->user->hasPermission('modify', 'catalog/tool')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS . 'catalog_tool.log';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true));
	}
}
