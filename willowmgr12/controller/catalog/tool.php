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
					$product_option_data = [];

					if (!$sheet_data[$i][$field_data['model']] || !$sheet_data[$i][$field_data['name']] || !$sheet_data[$i][$field_data['main_image']]) {
						continue;
					}

					if ($sheet_data[$i][$field_data['parent_model']]) {
						if (!$sheet_data[$i][$field_data['option_value_id']] || !$sheet_data[$i][$field_data['option_id']]) {
							continue;
						}

						$product_option_value_info = $this->model_catalog_product->getProductOptionValueByModel($sheet_data[$i][$field_data['model']]);

						if ($product_option_value_info) {
							# product option sudah ada
							continue;
						}

						$parent_product_info = $this->model_catalog_product->getProductByModel($sheet_data[$i][$field_data['parent_model']]);

						$product_id = $parent_product_info ? $parent_product_info['product_id'] : 0;

						$product_option_info = $this->model_catalog_product->getProductOption($product_id, $sheet_data[$i][$field_data['option_id']]);

						if (!$product_option_info) {
							$product_option_data['product_option'] = [
								'type'			=> 'select',
								'option_id'		=> $sheet_data[$i][$field_data['option_id']],
								'required'		=> 1
							];
						}

						$product_option_data['product_option_value'] = [
							'product_option_id'	=> $product_option_info ? $product_option_info['product_option_id'] : 0,
							'option_id'			=> $sheet_data[$i][$field_data['option_id']],
							'option_value_id'	=> $sheet_data[$i][$field_data['option_value_id']],
							'model'				=> $sheet_data[$i][$field_data['model']],
							'quantity'			=> $sheet_data[$i][$field_data['quantity']],
							'subtract'			=> 1,
							'price'				=> 0,
							'price_prefix'		=> '+',
							'points'			=> 0,
							'points_prefix'		=> '+',
							'weight'			=> 0,
							'weight_prefix'		=> '+'
						];

						if ($parent_product_info) {
							$parent_product_data['quantity'] = 111;

							$price = $sheet_data[$i][$field_data['price']] - $parent_product_info['price'];

							if ($price < 0) {
								$price_prefix = '-';

								$price = abs($price);
							} else {
								$price_prefix = '+';
							}

							$product_option_data['product_option_value']['price'] = $price;
							$product_option_data['product_option_value']['price_prefix'] = $price_prefix;

							$product_option_weight = $this->weight->convert($sheet_data[$i][$field_data['weight']], $weight_class_id, $parent_product_info['weight_class_id']);

							$weight = $product_option_weight - $parent_product_info['weight'];

							if ($weight < 0) {
								$weight_prefix = '-';

								$weight = abs($weight);
							} else {
								$weight_prefix = '+';
							}

							$product_option_data['product_option_value']['weight'] = $weight;
							$product_option_data['product_option_value']['weight_prefix'] = $weight_prefix;

							$this->model_catalog_product->addProductOption($product_id, $product_option_data);

							# Add option main image to product Image as additional image
							$url_source = $sheet_data[$i][$field_data['main_image']];

							$extension = pathinfo($url_source, PATHINFO_EXTENSION);

							if ($extension == '') {
								$extension = 'png';
							}

							if (in_array(strtolower($extension), $image_types)) {
								$new_image = str_replace('.', '', $sheet_data[$i][$field_data['model']]);

								$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

								$parent_product_data['product_image'][] = [
									'image'			=> $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image . '.' . $extension),
									'sort_order'	=> 99
								];
							}

							$this->model_catalog_product->editProductPartially($product_id, $parent_product_data);
						} else {
							$new_product = true;
						}
					} else {
						$new_product = true;
					}

					if ($new_product) {
						$product_info = $this->model_catalog_product->getProductByModel($sheet_data[$i][$field_data['model']]);

						if ($product_info) {
							# Product sudah ada
							continue;
						}

						$product_data = [
							'model'				=> '',
							'sku'				=> '',
							'upc'				=> '',
							'ean'				=> '',
							'jan'				=> '',
							'isbn'				=> '',
							'mpn'				=> '',
							'location'			=> '',
							'quantity' 			=> 0,
							'minimum' 			=> 1,
							'subtract' 			=> 1,
							'stock_status_id' 	=> 5,
							'date_available' 	=> date('Y-m-d'),
							'manufacturer_id' 	=> 0,
							'shipping' 			=> 1,
							'price'				=> 0,
							'points' 			=> 0,
							'weight' 			=> 0,
							'weight_class_id' 	=> 2,
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
							'product_option' 	=> [],
							'product_image' 	=> [],
							'product_category' 	=> [],
							'keyword' 			=> ''
						];

						$product_data['model'] = $sheet_data[$i][$field_data['model']];
						$product_data['sku'] = $sheet_data[$i][$field_data['model']];
						$product_data['quantity'] = $sheet_data[$i][$field_data['quantity']];
						$product_data['minimum'] = max(1, $sheet_data[$i][$field_data['minimum']]);
						$product_data['manufacturer_id'] = $sheet_data[$i][$field_data['manufacturer_id']];
						$product_data['price'] = $sheet_data[$i][$field_data['price']];
						$product_data['weight'] = $sheet_data[$i][$field_data['weight']];
						$product_data['length'] = $sheet_data[$i][$field_data['length']];
						$product_data['width'] = $sheet_data[$i][$field_data['width']];
						$product_data['height'] = $sheet_data[$i][$field_data['height']];
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

						if (!empty($product_option_data)) {
							$product_data['product_option'][0] = $product_option_data['product_option'];
							$product_data['product_option'][0]['product_option_value'][0] = $product_option_data['product_option_value'];
						}

						$url_source = $sheet_data[$i][$field_data['main_image']];

						$extension = pathinfo($url_source, PATHINFO_EXTENSION);

						if ($extension == '') {
							$extension = 'png';
						}

						if (!in_array(strtolower($extension), $image_types)) {
							# Imagetype tidak sesuai
							continue;
						}

						$new_image = str_replace('.', '', $sheet_data[$i][$field_data['model']]);

						$path_destination = 'catalog/product/' . substr($new_image, 0, 2);

						if (!is_dir(DIR_IMAGE . $path_destination)) {
							@mkdir(DIR_IMAGE . $path_destination, 0777);
						}

						$product_data['image'] = $this->model_tool_image->getImage($url_source, $path_destination . '/' . $new_image . '.' . $extension);

						for ($j = 2; $j < 6; $j++) {
							if (isset($sheet_data[$i][$field_data['image_' . $j]])) {
								$extension = pathinfo($sheet_data[$i][$field_data['image_' . $j]], PATHINFO_EXTENSION);

								if ($extension == '') {
									$extension = 'png';
								}

								if (in_array(strtolower($extension), $image_types)) {
									$product_data['product_image'][] = [
										'image'			=> $this->model_tool_image->getImage($sheet_data[$i][$field_data['image_' . $j]], $path_destination . '/' . $new_image . '_' . $j . '.' . $extension),
										'sort_order'	=> $j
									];
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
