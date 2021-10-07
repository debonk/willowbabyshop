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

			if (isset($this->request->post['product_id'])) {
				$product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
			} elseif (isset($this->request->post['model'])) {
				$product_info = $this->model_catalog_product->getProductByModel($this->request->post['model']);
			}

			$product_data = [];

			if (isset($product_info)) {
				if (isset($this->request->post['quantity']) && $this->request->post['quantity'] != $product_info['quantity']) {
					$product_data['quantity'] = $this->request->post['quantity'];
				}

				if (isset($this->request->post['price']) && $this->request->post['price'] != $product_info['price']) {
					$product_data['price'] = $this->request->post['price'];
				}

				if (isset($this->request->post['status']) && $this->request->post['status'] != $product_info['status']) {
					$product_data['status'] = $this->request->post['status'];
				}

				if ($product_data) {
					if (isset($this->request->post['product_id'])) {
						$this->model_catalog_product->editProduct($this->request->post['product_id'], $product_data);
					} elseif (isset($this->request->post['model'])) {
						$this->model_catalog_product->editProductByModel($this->request->post['model'], $product_data);
					}

					$json['success'] = $this->language->get('text_success');
				}
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

				// $column_data = array_intersect($products_data[0], $column_list);
				// $data_key = array_keys($column_data);

				if ($column_data != $products_data[0]) {
					$json['error']['invalid'] = $this->language->get('error_invalid');
					// }elseif ($products_data[0][0] != 'model') {
					// 	$json['error']['model'] = $this->language->get('error_model');
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
				$this->load->model('catalog/product');

				$products_data = array_slice($products_data, 1);

				foreach ($products_data as $product_data) {
					$update_data = [];

					foreach ($column_data as $idx => $column) {
						if ($idx) {
							$update_data[$column] = $product_data[$idx];
						} else {
							$model = $product_data[$idx];
						}
					}

					$this->model_catalog_product->editProductByModel($model, $update_data);
				}

				$json['success'] = $this->language->get('text_success');
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

			$products = $this->model_catalog_product->getProductsModel($status);

			$json['products'] = $products;

			$json['success'] = sprintf($this->language->get('text_success_info'), count($products));
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