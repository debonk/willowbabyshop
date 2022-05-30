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
					$json['not_updated'][] = sprintf($this->language->get('error_update'), $this->request->post['model']);
				}
			} else {
				$json['not_updated'][] = sprintf($this->language->get('error_not_found'), $this->request->post['model']);
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
				$json['not_updated'] = [];

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
							$json['not_updated'][] = sprintf($this->language->get('error_update'), $product_data['model']);
						}
					} else {
						$json['not_updated'][] = sprintf($this->language->get('error_not_found'), $product_data['model']);
					}
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
}
