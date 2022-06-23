<?php
class ControllerCatalogTool extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('catalog/tool');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_export1'] = $this->language->get('text_export1');

		$data['entry_new_product'] = $this->language->get('entry_new_product');
		$data['entry_export'] = $this->language->get('entry_export');

		$data['button_export'] = $this->language->get('button_export');
		$data['button_import'] = $this->language->get('button_import');

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

		$data['backup'] = $this->url->link('catalog/tool/backup', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/tool', $data));
	}

	public function import()
	{
		$this->load->language('catalog/tool');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'catalog/tool')) {
			$this->load->model('tool/spreadsheet');

			if (is_uploaded_file($this->request->files['new_product']['tmp_name'])) {
				$sheet_data = $this->model_tool_spreadsheet->getSheetData($this->request->files['new_product']['tmp_name']);
			} else {
				$sheet_data = false;
			}

			if ($sheet_data) {
				$error_import = [];

				if (!is_dir(DIR_IMAGE . 'catalog/product')) {
					@mkdir(DIR_IMAGE . 'catalog/product', 0777);
				}

				$header_data = [
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
				];

				$image_types = [
					'jpg',
					'jpeg',
					'png'
				];

				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				$this->load->model('localisation/weight_class');
				$this->load->model('catalog/url_alias');

				# Used for weight conversion on product options
				$weight_class_id = $this->model_localisation_weight_class->getWeightClassDescriptionByUnit('g')['weight_class_id'];

				$field_data = [];

				foreach ($sheet_data[1] as $column => $header) {
					if (in_array($header, $header_data)) {
						$field_data[$header] = $column;
					}
				}

				for ($i = 3; $i <= count($sheet_data); $i++) {
					$new_product = false;
					$product_variant_data = [];

					if (!$sheet_data[$i][$field_data['model']] || !$sheet_data[$i][$field_data['name']]) {
						# Model dan name harus ada
						$error_import[] = sprintf($this->language->get('error_model_name'), $i);

						continue;
					}

					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($sheet_data[$i][$field_data['model']]);

					if ($product_variant_info) {
						# Product sudah ada
						$error_import[] = sprintf($this->language->get('error_registered'), $sheet_data[$i][$field_data['model']]);

						continue;
					}

					if ($sheet_data[$i][$field_data['parent_model']]) {
						if (!$sheet_data[$i][$field_data['option_value_id']] || !$sheet_data[$i][$field_data['option_id']]) {
							$error_import[] = sprintf($this->language->get('error_option'), $sheet_data[$i][$field_data['model']]);

							continue;
						}

						$parent_product_info = $this->model_catalog_product->getProductByModel($sheet_data[$i][$field_data['parent_model']]);

						if (!$parent_product_info) {
							$new_product = true;
						}
					} else {
						$new_product = true;
					}

					if ($new_product) {
						if (!$sheet_data[$i][$field_data['main_image']]) {
							# Jika New Product, Main image harus ada
							$error_import[] = sprintf($this->language->get('error_image'), $sheet_data[$i][$field_data['model']]);

							continue;
						}
					}

					# Add variant image
					$url_source = $sheet_data[$i][$field_data['variant_image']];

					if ($url_source) {
						$extension = pathinfo($url_source, PATHINFO_EXTENSION);

						if ($extension == '') {
							$extension = 'png';
						}

						if (in_array(strtolower($extension), $image_types)) {
							$new_image = str_replace('.', '', $sheet_data[$i][$field_data['model']]) . '_v';

							$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

							$variant_image = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image . '.' . $extension);
							// $variant_image = $path_destination . '/' . $new_image . '.' . $extension;
						} else {
							$error_import[] = sprintf($this->language->get('error_image_type'), $sheet_data[$i][$field_data['model']]);
						}
					}

					$product_variant_data['variant'][0] = [
						'model'				=> $sheet_data[$i][$field_data['model']],
						'quantity'			=> $sheet_data[$i][$field_data['quantity']],
						'image'				=> $variant_image,
						'price'				=> $sheet_data[$i][$field_data['price']],
						'points'			=> 0,
						'weight'			=> $sheet_data[$i][$field_data['weight']],
						'weight_class_id'	=> $weight_class_id
					];

					$product_variant_data['option'][0]['option_id'] = (int)$sheet_data[$i][$field_data['option_id']];
					$product_variant_data['variant'][0]['option_value_id'][0] = (int)$sheet_data[$i][$field_data['option_value_id']];
					
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

						$product_data['sku'] = $sheet_data[$i][$field_data['model']];
						$product_data['minimum'] = max(1, $sheet_data[$i][$field_data['minimum']]);
						$product_data['manufacturer_id'] = $sheet_data[$i][$field_data['manufacturer_id']];
						$product_data['length'] = $sheet_data[$i][$field_data['length']];
						$product_data['width'] = $sheet_data[$i][$field_data['width']];
						$product_data['height'] = $sheet_data[$i][$field_data['height']];

						$product_data['product_variant'] = $product_variant_data;
						$product_data['keyword'] = preg_replace('/[\'\"*?+&\s-]+/', '-', utf8_strtolower(($sheet_data[$i][$field_data['name']])));

						if ($this->model_catalog_url_alias->getUrlAlias($product_data['keyword'])) {
							$product_data['keyword'] .= '-' . token(3);
						}

						$product_data['product_description'][$this->config->get('config_language_id')] = [
							'name' 				=> utf8_strtoupper($sheet_data[$i][$field_data['name']]),
							'description'		=> nl2br($sheet_data[$i][$field_data['description']]),
							'meta_title'		=> $sheet_data[$i][$field_data['meta_title']] ? $sheet_data[$i][$field_data['meta_title']] : sprintf($this->language->get('text_meta_title'), $sheet_data[$i][$field_data['name']]),
							'meta_description'	=> $sheet_data[$i][$field_data['meta_description']],
							'meta_keyword'		=> '',
							'tag'				=> utf8_strtolower($sheet_data[$i][$field_data['tag']])
						];

						# Add main image
						$url_source = $sheet_data[$i][$field_data['main_image']];

						if ($url_source) {
							$extension = pathinfo($url_source, PATHINFO_EXTENSION);

							if ($extension == '') {
								$extension = 'png';
							}

							if (in_array(strtolower($extension), $image_types)) {
								$new_image = str_replace('.', '', $sheet_data[$i][$field_data['model']]);

								$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

								$product_data['image'] = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image . '.' . $extension);
							}
						}

						for ($j = 2; $j < 6; $j++) {
							if ($sheet_data[$i][$field_data['image_' . $j]]) {
								$extension = pathinfo($sheet_data[$i][$field_data['image_' . $j]], PATHINFO_EXTENSION);

								if ($extension == '') {
									$extension = 'png';
								}

								if (in_array(strtolower($extension), $image_types)) {
									$product_data['product_image'][] = [
										'image'			=> $this->model_tool_image->getImage($sheet_data[$i][$field_data['image_' . $j]], $path_destination . '/' . $new_image . '_' . $j . '.' . $extension),
										'sort_order'	=> $j
									];
								} else {
									$error_import[] = sprintf($this->language->get('error_image_type'), $sheet_data[$i][$field_data['model']]);
								}
							}
						}

						if (isset($sheet_data[$i][$field_data['main_category_id']])) {
							$product_data['product_category'][] = $sheet_data[$i][$field_data['main_category_id']];
						}

						if (isset($sheet_data[$i][$field_data['sub_category_id']])) {
							$product_data['product_category'][] = $sheet_data[$i][$field_data['sub_category_id']];
						}

						$this->model_catalog_product->addProduct($product_data);
					}
				}

				$this->session->data['success'] = $this->language->get('text_success');
				$this->session->data['error'] = implode('<br>', $error_import);

				$this->response->redirect($this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true));
			} else {
				$this->session->data['error'] = $this->language->get('error_empty');
			}
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');
		}

		$this->response->redirect($this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true));
	}
}
