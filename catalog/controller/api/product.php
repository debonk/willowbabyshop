<?php
class ControllerApiProduct extends Controller
{
	public function index()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			if (isset($this->request->get['product_id'])) {
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
			} elseif (isset($this->request->get['model'])) {
				$product_info = $this->model_catalog_product->getProductByModel($this->request->get['model']);
			}

			if ($product_info) {
				if (!isset($this->session->data['currency'])) {
					$this->session->data['currency'] = $this->config->get('config_currency');
				}

				$json['product'] = [
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'quantity'   => $product_info['quantity'],
					'price'      => $this->currency->format($product_info['price'], $this->session->data['currency']),
					'status'	 => $product_info['status']
				];
			} else {
				$json['error']['product'] = $this->language->get('error_product');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function price()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			if (isset($this->request->get['product_id'])) {
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
			} elseif (isset($this->request->get['model'])) {
				$product_info = $this->model_catalog_product->getProductByModel($this->request->get['model']);
			}

			if (isset($product_info)) {
				if (!isset($this->session->data['currency'])) {
					$this->session->data['currency'] = $this->config->get('config_currency');
				}

				$json['price'] = $this->currency->format($product_info['price'], $this->session->data['currency']);
			} else {
				$json['error']['product'] = $this->language->get('error_product');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function quantity()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			if (isset($this->request->get['product_id'])) {
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
			} elseif (isset($this->request->get['model'])) {
				$product_info = $this->model_catalog_product->getProductByModel($this->request->get['model']);
			}

			if (isset($product_info)) {
				$json['quantity'] = $product_info['quantity'];
			} else {
				$json['error']['product'] = $this->language->get('error_product');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function update()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			if (isset($this->request->post['model'])) {
				$product_variant_info = $this->model_catalog_product->getProductVariantByModel($this->request->post['model']);
			}

			if ($product_variant_info) {
				if ($product_variant_info['quantity'] != $this->request->post['quantity'] || $product_variant_info['price'] != $this->request->post['price']) {
					$this->model_catalog_product->editProductVariant($product_variant_info['product_option_value_id'], $this->request->post);

					$this->model_catalog_product->updateModified($product_variant_info['product_id']);
				} else {
					$failed_data = sprintf($this->language->get('error_update'), $this->request->post['model']);
				}
			} else {
				$failed_data = sprintf($this->language->get('error_not_found'), $this->request->post['model']);
			}

			if (isset($failed_data)) {
				$json['failed_data'] = $failed_data;
			}

			$json['success'] = $this->language->get('text_success');

			$this->cache->delete('product');
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function updates()
	{
		$this->load->language('api/product');

		$json = array();

		// [["model","price","quantity","status"],["06.02.00910",81900,12,1],["06.02.00909",81900,11,1],["05.03.01326",2499900,10,1]]
		// [["model","quantity"],["06.02.00910",12],["06.02.00909",11],["05.03.01326",10]]

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['data'])) {
				$products_data = json_decode(htmlspecialchars_decode($this->request->post['data']));

				$column_data = [
					'model',
					'price',
					'quantity',
					'status'
				];

				if ($column_data != $products_data[0]) {
					$json['error']['invalid'] = $this->language->get('error_invalid');
				} else {
					$field_count = count($column_data);

					foreach ($products_data as $product_data) {
						if (count($product_data) != $field_count) {
							$json['error']['invalid'] = $this->language->get('error_invalid');

							break;
						}
					}
				}
			} else {
				$json['error']['data'] = $this->language->get('error_data');
			}

			if (!$json) {
				$failed_data = [];

				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);

				foreach ($products_data as $product_data) {
					$product_data = array_combine($column_data, $product_data);

					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($product_data['model']);

					if ($product_variant_info) {
						if ($product_variant_info['quantity'] != $product_data['quantity'] || $product_variant_info['price'] != $product_data['price']) {
							$this->model_catalog_product->editProductVariant($product_variant_info['product_option_value_id'], $product_data);

							$this->model_catalog_product->updateModified($product_variant_info['product_id']);
						} else {
							$failed_data[] = sprintf($this->language->get('error_update'), $product_data['model']);
						}
					} else {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);
					}
				}

				if ($failed_data) {
					$json['failed_data'] = $failed_data;
				}

				$json['success'] = $this->language->get('text_success');

				$this->cache->delete('product');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function list()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$status = isset($this->request->get['status']) && !is_null($this->request->get['status']) ? $this->request->get['status'] : 1;

			$this->load->model('catalog/product');

			$json['products'] = $this->model_catalog_product->getProductsModel($status);

			$json['success'] = sprintf($this->language->get('text_success_info'), count($json['products']));
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addSpecials()
	{
		$this->load->language('api/product');

		$json = array();

		// [["model","price","special_price","date_start","date_end"],["06.02.00910",81900,75000,"2022-06-15","2022-07-15"],["06.02.00909",81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2499900,2249910,"2022-06-15","2022-07-15"]]

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['data'])) {
				$products_data = json_decode(htmlspecialchars_decode($this->request->post['data']));

				$column_data = [
					'model',
					'price',
					'special_price',
					'date_start',
					'date_end'
				];

				if ($column_data != $products_data[0]) {
					$json['error']['invalid'] = $this->language->get('error_invalid');
				} else {
					$field_count = count($column_data);

					foreach ($products_data as $product_data) {
						if (count($product_data) != $field_count) {
							$json['error']['not_match'] = $this->language->get('error_not_match');

							break;
						}
					}
				}
			} else {
				$json['error']['data'] = $this->language->get('error_data');
			}

			if (!$json) {
				$failed_data = [];
				$update_data = [];

				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);

				foreach ($products_data as $product_data) {
					$product_data = array_combine($column_data, $product_data);

					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($product_data['model']);

					if (!$product_variant_info) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					if (isset($update_data[$product_variant_info['product_id']])) {
						$failed_data[] = sprintf($this->language->get('error_skipped'), $product_data['model'], 'special');

						continue;
					}

					if ($product_variant_info['price'] != $product_data['price']) {
						$failed_data[] = sprintf($this->language->get('error_price'), $product_data['model']);

						continue;
					}

					$product_check = $this->model_catalog_product->checkProduct($product_variant_info['product_id']);

					if (!$product_check) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					$discount_percent_1 = 100 - ($product_data['special_price'] /  $product_data['price'] * 100);

					if ($discount_percent_1 == (int)$discount_percent_1) {
						$discount_fixed = 0;
					} else {
						$discount_fixed = $product_data['price'] - $product_data['special_price'];
						$discount_percent_1 = 0;
					}

					$special_data = [
						'customer_group_id'		=> $this->config->get('config_customer_group_id'),
						'priority'				=> 0,
						'discount_percent_1'	=> $discount_percent_1,
						'discount_percent_2'	=> 0,
						'discount_fixed'		=> $discount_fixed,
						'date_start'			=> $product_data['date_start'],
						'date_end'				=> $product_data['date_end']
					];

					$update_data[$product_variant_info['product_id']] = $this->model_catalog_product->addProductSpecial($product_variant_info['product_id'], $special_data);

					$this->model_catalog_product->updateModified($product_variant_info['product_id']);
				}

				$json['success'] = $this->language->get('text_success');

				if ($failed_data) {
					$json['failed_data'] = $failed_data;
				}
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function deleteSpecials()
	{
		$this->load->language('api/product');

		$json = array();

		// ["model","06.02.00910","06.02.00909","05.03.01326"]

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['data'])) {
				$products_data = json_decode(htmlspecialchars_decode($this->request->post['data']));

				if ($products_data[0] != 'model') {
					$json['error']['invalid'] = $this->language->get('error_invalid');
				}
			} else {
				$json['error']['data'] = $this->language->get('error_data');
			}

			if (!$json) {
				$failed_data = [];
				$update_data = [];

				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);

				foreach ($products_data as $product_data) {
					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($product_data);

					if (!$product_variant_info) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data);

						continue;
					}

					if (isset($update_data[$product_variant_info['product_id']])) {
						$failed_data[] = sprintf($this->language->get('error_skip_deleted'), $product_data, 'special');

						continue;
					}

					$product_check = $this->model_catalog_product->checkProduct($product_variant_info['product_id']);

					if (!$product_check) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					$update_data[$product_variant_info['product_id']] = $this->model_catalog_product->deleteProductSpecial($product_variant_info['product_id']);

					$this->model_catalog_product->updateModified($product_variant_info['product_id']);
				}

				$json['success'] = $this->language->get('text_success');

				if ($failed_data) {
					$json['failed_data'] = $failed_data;
				}
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function specials()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			$results = $this->model_catalog_product->getSpecials();

			foreach ($results as $result) {
				$special = $result['price'];
				$special *= (100 - $result['discount_percent_1']) / 100;
				$special *= (100 - $result['discount_percent_2']) / 100;
				$special = max(0, $special - $result['discount_fixed']);

				$json['products'][] = [
					'model'			=> $result['model'],
					'price'			=> $result['price'],
					'special'		=> $special,
					'date_start'	=> $result['date_start'],
					'date_end'		=> $result['date_end']
				];
			}

			$json['success'] = sprintf($this->language->get('text_success_info'), count($json['products']));
		}
		
		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addDiscounts()
	{
		$this->load->language('api/product');

		$json = array();

		// [["model","quantity","price","special_price","date_start","date_end"],["06.02.00910",2,81900,75000,"2022-06-15","2022-07-15"],["06.02.009102",3,81900,75000,"2022-06-15","2022-07-15"],["06.02.00909",3,81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2,2499900,2249910,"2022-06-15","2022-07-15"]]

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['data'])) {
				$products_data = json_decode(htmlspecialchars_decode($this->request->post['data']));

				$column_data = [
					'model',
					'quantity',
					'price',
					'special_price',
					'date_start',
					'date_end'
				];

				if ($column_data != $products_data[0]) {
					$json['error']['invalid'] = $this->language->get('error_invalid');
				} else {
					$field_count = count($column_data);

					foreach ($products_data as $product_data) {
						if (count($product_data) != $field_count) {
							$json['error']['not_match'] = $this->language->get('error_not_match');

							break;
						}
					}
				}
			} else {
				$json['error']['data'] = $this->language->get('error_data');
			}

			if (!$json) {
				$failed_data = [];
				$update_data = [];

				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);
				
				foreach ($products_data as $product_data) {
					$product_data = array_combine($column_data, $product_data);

					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($product_data['model']);

					if (!$product_variant_info) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					if (isset($update_data[$product_variant_info['product_id']][$product_data['quantity']])) {
						$failed_data[] = sprintf($this->language->get('error_skipped'), $product_data['model'], 'discount');

						continue;
					}

					if ($product_variant_info['price'] != $product_data['price']) {
						$failed_data[] = sprintf($this->language->get('error_price'), $product_data['model']);

						continue;
					}

					$product_check = $this->model_catalog_product->checkProduct($product_variant_info['product_id']);

					if (!$product_check) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					$discount_percent_1 = 100 - ($product_data['special_price'] /  $product_data['price'] * 100);

					if ($discount_percent_1 == (int)$discount_percent_1) {
						$discount_fixed = 0;
					} else {
						$discount_fixed = $product_data['price'] - $product_data['special_price'];
						$discount_percent_1 = 0;
					}

					$discount_data = [
						'customer_group_id'		=> $this->config->get('config_customer_group_id'),
						'quantity'				=> $product_data['quantity'],
						'priority'				=> 0,
						'discount_percent_1'	=> $discount_percent_1,
						'discount_percent_2'	=> 0,
						'discount_fixed'		=> $discount_fixed,
						'date_start'			=> $product_data['date_start'],
						'date_end'				=> $product_data['date_end']
					];

					if (!isset($update_data[$product_variant_info['product_id']])) {
						$this->model_catalog_product->deleteProductDiscount($product_variant_info['product_id']);
					}

					$update_data[$product_variant_info['product_id']][$product_data['quantity']] = $this->model_catalog_product->addProductDiscount($product_variant_info['product_id'], $discount_data);

					$this->model_catalog_product->updateModified($product_variant_info['product_id']);
				}

				$json['success'] = $this->language->get('text_success');

				if ($failed_data) {
					$json['failed_data'] = $failed_data;
				}
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function deleteDiscounts()
	{
		$this->load->language('api/product');

		$json = array();

		// ["model","06.02.00910","06.02.00909","05.03.01326"]

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['data'])) {
				$products_data = json_decode(htmlspecialchars_decode($this->request->post['data']));

				if ($products_data[0] != 'model') {
					$json['error']['invalid'] = $this->language->get('error_invalid');
				}
			} else {
				$json['error']['data'] = $this->language->get('error_data');
			}

			if (!$json) {
				$failed_data = [];
				$update_data = [];

				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);

				foreach ($products_data as $product_data) {
					$product_variant_info = $this->model_catalog_product->getProductVariantByModel($product_data);

					if (!$product_variant_info) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data);

						continue;
					}

					if (isset($update_data[$product_variant_info['product_id']])) {
						$failed_data[] = sprintf($this->language->get('error_skip_deleted'), $product_data, 'special');

						continue;
					}

					$product_check = $this->model_catalog_product->checkProduct($product_variant_info['product_id']);

					if (!$product_check) {
						$failed_data[] = sprintf($this->language->get('error_not_found'), $product_data['model']);

						continue;
					}

					$update_data[$product_variant_info['product_id']] = $this->model_catalog_product->deleteProductDiscount($product_variant_info['product_id']);

					$this->model_catalog_product->updateModified($product_variant_info['product_id']);
				}

				$json['success'] = $this->language->get('text_success');

				if ($failed_data) {
					$json['failed_data'] = $failed_data;
				}
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function discounts()
	{
		$this->load->language('api/product');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('catalog/product');

			$results = $this->model_catalog_product->getDiscounts();

			foreach ($results as $result) {
				$discount = $result['price'];
				$discount *= (100 - $result['discount_percent_1']) / 100;
				$discount *= (100 - $result['discount_percent_2']) / 100;
				$discount = max(0, $discount - $result['discount_fixed']);

				$json['products'][] = [
					'model'			=> $result['model'],
					'quantity'		=> $result['quantity'],
					'price'			=> $result['price'],
					'special'		=> $discount,
					'date_start'	=> $result['date_start'],
					'date_end'		=> $result['date_end']
				];
			}

			$json['success'] = sprintf($this->language->get('text_success_info'), count($json['products']));
		}
				
		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
