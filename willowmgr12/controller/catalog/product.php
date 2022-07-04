<?php
class ControllerCatalogProduct extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}

	public function add()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$filename = str_replace('.', '', $this->request->post['product_variant']['variant'][0]['model']);

			if (filter_var($this->request->post['image'], FILTER_VALIDATE_URL)) {
				$headers = get_headers($this->request->post['image'], 1);

				if (strpos($headers['Content-Type'], 'image/') !== false) {
					$extension = str_replace('image/', '', $headers['Content-Type']);

					$new_image = 'catalog/product/' . substr($filename, 0, 2) . '/' . $filename . '.' . $extension;

					$this->request->post['image'] = $this->model_tool_image->getImage($this->request->post['image'], $new_image, 800, 800);
				}
			}

			foreach ($this->request->post['product_image'] as $key => $product_image) {
				if (filter_var($product_image['image'], FILTER_VALIDATE_URL)) {
					$headers = get_headers($product_image['image'], 1);

					if (strpos($headers['Content-Type'], 'image/') !== false) {
						$extension = str_replace('image/', '', $headers['Content-Type']);
						$new_image = $filename . '_' . ($key + 2);

						$new_image = 'catalog/product/' . substr($new_image, 0, 2) . '/' . $new_image . '.' . $extension;

						$this->request->post['product_image'][$key]['image'] = $this->model_tool_image->getImage($product_image['image'], $new_image, 800, 800);
					}
				}
			}

			foreach ($this->request->post['product_variant']['variant'] as $key => $product_variant) {
				if (filter_var($product_variant['image'], FILTER_VALIDATE_URL)) {
					$headers = get_headers($product_variant['image'], 1);

					if (strpos($headers['Content-Type'], 'image/') !== false) {
						$extension = str_replace('image/', '', $headers['Content-Type']);
						$filename = str_replace('.', '', $product_variant['model']) . '_v';

						$new_image = 'catalog/product/' . substr($filename, 0, 2) . '/' . $filename . '.' . $extension;

						$this->request->post['product_variant']['variant'][$key]['image'] = $this->model_tool_image->getImage($product_variant['image'], $new_image, 800, 800);
					}
				}
			}

			$this->model_catalog_product->addProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_special'])) {
				$url .= '&filter_special=' . $this->request->get['filter_special'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$filename = str_replace('.', '', $this->request->post['product_variant']['variant'][0]['model']);

			if (filter_var($this->request->post['image'], FILTER_VALIDATE_URL)) {
				$headers = get_headers($this->request->post['image'], 1);

				if (strpos($headers['Content-Type'], 'image/') !== false) {
					$extension = str_replace('image/', '', $headers['Content-Type']);

					$new_image = 'catalog/product/' . substr($filename, 0, 2) . '/' . $filename . '.' . $extension;

					$this->request->post['image'] = $this->model_tool_image->getImage($this->request->post['image'], $new_image, 800, 800);
				}
			}

			foreach ($this->request->post['product_image'] as $key => $product_image) {
				if (filter_var($product_image['image'], FILTER_VALIDATE_URL)) {
					$headers = get_headers($product_image['image'], 1);

					if (strpos($headers['Content-Type'], 'image/') !== false) {
						$extension = str_replace('image/', '', $headers['Content-Type']);
						$new_image = $filename . '_' . ($key + 2);

						$new_image = 'catalog/product/' . substr($new_image, 0, 2) . '/' . $new_image . '.' . $extension;

						$this->request->post['product_image'][$key]['image'] = $this->model_tool_image->getImage($product_image['image'], $new_image, 800, 800);
					}
				}
			}

			foreach ($this->request->post['product_variant']['variant'] as $key => $product_variant) {
				if (filter_var($product_variant['image'], FILTER_VALIDATE_URL)) {
					$headers = get_headers($product_variant['image'], 1);

					if (strpos($headers['Content-Type'], 'image/') !== false) {
						$extension = str_replace('image/', '', $headers['Content-Type']);
						$filename = str_replace('.', '', $product_variant['model']) . '_v';

						$new_image = 'catalog/product/' . substr($filename, 0, 2) . '/' . $filename . '.' . $extension;

						$this->request->post['product_variant']['variant'][$key]['image'] = $this->model_tool_image->getImage($product_variant['image'], $new_image, 800, 800);
					}
				}
			}

			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_special'])) {
				$url .= '&filter_special=' . $this->request->get['filter_special'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach (array_unique($this->request->post['selected']) as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_special'])) {
				$url .= '&filter_special=' . $this->request->get['filter_special'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {

			foreach (array_unique($this->request->post['selected']) as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_special'])) {
				$url .= '&filter_special=' . $this->request->get['filter_special'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList()
	{
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = null;
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
		}

		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} else {
			$filter_tag = null;
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = null;
		}

		if (isset($this->request->get['filter_username'])) {
			$filter_username = $this->request->get['filter_username'];
		} else {
			$filter_username = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_special'])) {
			$filter_special = $this->request->get['filter_special'];
		} else {
			$filter_special = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_username'])) {
			$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_special'])) {
			$url .= '&filter_special=' . $this->request->get['filter_special'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], true)
		);

		$data['add'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  		=> $filter_name,
			'filter_model'	  		=> $filter_model,
			'filter_price'	  		=> $filter_price,
			'filter_quantity' 		=> $filter_quantity,
			'filter_manufacturer' 	=> $filter_manufacturer,
			'filter_category' 		=> $filter_category,
			'filter_tag'	  		=> $filter_tag,
			'filter_product_id'	  	=> $filter_product_id,
			'filter_username'	  	=> $filter_username,
			'filter_status'   		=> $filter_status,
			'filter_special'   		=> $filter_special,
			'sort'            		=> $sort,
			'order'           		=> $order,
			'start'           		=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           		=> $this->config->get('config_limit_admin')
		);

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		# Get unique option_value_id from results
		$option_values_data = [];
		$option_values_ids = [];

		array_map(function ($ids) use (&$option_values_ids) {
			if (is_array(json_decode($ids))) {
				$option_values_ids = array_merge($option_values_ids, json_decode($ids));
			}
		}, array_column($results, 'option_value_id'));

		$option_values_ids = array_unique($option_values_ids);

		if ($option_values_ids) {
			$this->load->model('catalog/option');

			$option_values = $this->model_catalog_option->getOptionValuesDescription($option_values_ids);

			foreach ($option_values as $option_value) {
				$option_values_data[$option_value['option_value_id']] = $option_value['name'];
			}
		}

		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories();

		array_unshift($data['categories'], ['category_id' => 0, 'name' => $this->language->get('text_none')]);

		$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		array_unshift($data['manufacturers'], ['manufacturer_id' => 0, 'name' => $this->language->get('text_none')]);

		$this->load->model('tool/image');

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['variant_image'])) {
				$main_image = $result['variant_image'];
			} else {
				$main_image = $result['main_image'];
			}

			$image = $this->model_tool_image->resize($main_image, 40, 40);

			$category =  $this->model_catalog_product->getProductCategories($result['product_id']);

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) >= strtotime('today'))) {
					$special = $result['price'];
					$special *= (100 - $product_special['discount_percent_1']) / 100;
					$special *= (100 - $product_special['discount_percent_2']) / 100;
					$special = max(0, $special - $product_special['discount_fixed']);

					break;
				}
			}

			$discount = false;

			$product_discounts = $this->model_catalog_product->getProductDiscounts($result['product_id']);

			foreach ($product_discounts  as $product_discount) {
				if (($product_discount['date_start'] == '0000-00-00' || strtotime($product_discount['date_start']) < time()) && ($product_discount['date_end'] == '0000-00-00' || strtotime($product_discount['date_end']) >= strtotime('today'))) {
					$discount = $special ? $special : $result['price'];
					$discount *= (100 - $product_discount['discount_percent_1']) / 100;
					$discount *= (100 - $product_discount['discount_percent_2']) / 100;
					$discount = max(0, $discount - $product_discount['discount_fixed']);

					$discount = sprintf($this->language->get('text_discount'), $product_discount['quantity'], $discount);

					break;
				}
			}

			$variant_name = [];

			$option_value_ids = json_decode($result['option_value_id']);

			if (is_array($option_value_ids)) {
				foreach ($option_value_ids as $option_value_id) {
					$variant_name[] = $option_values_data[$option_value_id];
				}
			}

			$variant_name = implode(', ', $variant_name);

			$data['products'][] = array(
				'product_id' 	=> $result['product_id'],
				'image'      	=> $image,
				'name'       	=> $result['name'],
				'variant_name'	=> $variant_name,
				'model'      	=> $result['model'],
				'price'      	=> $result['price'],
				'manufacturer'  => $result['manufacturer_name'],
				'category'   	=> $category,
				'tag'		 	=> $result['tag'],
				'special'    	=> $special,
				'discount'    	=> $discount,
				'quantity'   	=> $result['quantity'],
				'weight'   	 	=> $result['weight'] . $this->weight->getUnit($result['weight_class_id']),
				'date_modified'	=> $result['date_modified'] != '0000-00-00 00:00:00' ? date($this->language->get('date_format_short'), strtotime($result['date_modified'])) : '-',
				'status'     	=> ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'username'   	=> $result['username'] ? $result['username'] : $this->language->get('text_system'),
				'edit'       	=> $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$language_items = [
			'heading_title',
			'text_all',
			'text_list',
			'text_enabled',
			'text_disabled',
			'text_no_results',
			'text_none',
			'text_confirm',
			'text_has_special',
			'text_has_discount',

			'column_image',
			'column_name',
			'column_model',
			'column_price',
			'column_product_id',
			'column_manufacturer',
			'column_category',
			'column_tag',
			'column_quantity',
			'column_weight',
			'column_option',
			'column_status',
			'column_date_modified',
			'column_username',
			'column_action',

			'entry_name',
			'entry_model',
			'entry_price',
			'entry_product_id',
			'entry_tag',
			'entry_quantity',
			'entry_percentage',
			'entry_has_special',
			'entry_status',
			'entry_username',

			'button_copy',
			'button_add',
			'button_edit',
			'button_delete',
			'button_filter'
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		if (isset($this->error['warning'])) {
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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_username'])) {
			$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_special'])) {
			$url .= '&filter_special=' . $this->request->get['filter_special'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pov.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pov.price' . $url, true);
		$data['sort_id'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.product_id' . $url, true);
		$data['sort_manufacturer'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=manufacturer_name' . $url, true);
		$data['sort_category'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p2c.category_id' . $url, true);
		$data['sort_tag'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.tag' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pov.quantity' . $url, true);
		$data['sort_date_modified'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.date_modified' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_username'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=u.username' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_username'])) {
			$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_special'])) {
			$url .= '&filter_special=' . $this->request->get['filter_special'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['token'] = $this->session->data['token'];

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_manufacturer'] = $filter_manufacturer;
		$data['filter_category'] = $filter_category;
		$data['filter_tag'] = $filter_tag;
		$data['filter_product_id'] = $filter_product_id;
		$data['filter_username'] = $filter_username;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;
		$data['filter_special'] = $filter_special;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_list', $data));
	}

	protected function getForm()
	{
		$language_items = [
			'heading_title',
			'text_amount',
			'text_default',
			'text_disabled',
			'text_enabled',
			'text_minus',
			'text_no',
			'text_none',
			'text_option_value',
			'text_option',
			'text_percent',
			'text_plus',
			'text_select',
			'text_yes',

			'entry_additional_image',
			'entry_attribute',
			'entry_category',
			'entry_customer_group',
			'entry_date_available',
			'entry_date_end',
			'entry_date_start',
			'entry_description',
			'entry_dimension',
			'entry_discount_fixed',
			'entry_discount_percent_1',
			'entry_discount_percent_2',
			'entry_download',
			'entry_ean',
			'entry_filter',
			'entry_height',
			'entry_image',
			'entry_isbn',
			'entry_jan',
			'entry_keyword',
			'entry_layout',
			'entry_length_class',
			'entry_length',
			'entry_location',
			'entry_manufacturer',
			'entry_meta_description',
			'entry_meta_keyword',
			'entry_meta_title',
			'entry_minimum',
			'entry_model',
			'entry_mpn',
			'entry_variant_option',
			'entry_name',
			'entry_option_points',
			'entry_option_value',
			'entry_option',
			'entry_percentage',
			'entry_points',
			'entry_price',
			'entry_priority',
			'entry_quantity',
			'entry_recurring',
			'entry_related',
			'entry_required',
			'entry_reward',
			'entry_shipping',
			'entry_sku',
			'entry_sort_order',
			'entry_status',
			'entry_stock_status',
			'entry_store',
			'entry_subtract',
			'entry_tag',
			'entry_tax_class',
			'entry_text',
			'entry_upc',
			'entry_weight_class',
			'entry_weight',
			'entry_width',

			'help_category',
			'help_download',
			'help_ean',
			'help_filter',
			'help_isbn',
			'help_jan',
			'help_keyword',
			'help_manufacturer',
			'help_minimum',
			'help_mpn',
			'help_points',
			'help_related',
			'help_sku',
			'help_stock_status',
			'help_tag',
			'help_upc',

			'button_attribute_add',
			'button_cancel',
			'button_discount_add',
			'button_image_add',
			'button_option_add',
			'button_option_value_add',
			'button_recurring_add',
			'button_remove',
			'button_save',
			'button_special_add',

			'tab_attribute',
			'tab_data',
			'tab_design',
			'tab_discount',
			'tab_general',
			'tab_image',
			'tab_links',
			'tab_variant',
			'tab_openbay',
			'tab_option',
			'tab_recurring',
			'tab_reward',
			'tab_special'
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['sku'])) {
			$data['error_sku'] = $this->error['sku'];
		} else {
			$data['error_sku'] = '';
		}

		// if (isset($this->error['option_model'])) {
		// 	$data['error_option_model'] = $this->error['option_model'];
		// } else {
		// 	$data['error_option_model'] = '';
		// }

		if (isset($this->error['variant'])) {
			$data['error_variant'] = $this->error['variant'];
		} else {
			$data['error_variant'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_username'])) {
			$url .= '&filter_username=' . urlencode(html_entity_decode($this->request->get['filter_username'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_special'])) {
			$url .= '&filter_special=' . $this->request->get['filter_special'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$data['keyword'] = $product_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['product_recurrings'])) {
			$data['product_recurrings'] = $this->request->post['product_recurrings'];
		} elseif (!empty($product_info)) {
			$data['product_recurrings'] = $this->model_catalog_product->getRecurrings($product_info['product_id']);
		} else {
			$data['product_recurrings'] = array();
		}

		$data['product_recurring_count'] = count($data['product_recurrings']);

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();

		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);

			if ($attribute_info) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		} else {
			$product_options = array();
		}

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			$product_option_value_data = array();

			$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['product_discount'])) {
			$product_discounts = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$product_discounts = array();
		}

		$data['product_discounts'] = array();

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = array(
				'customer_group_id' 	=> $product_discount['customer_group_id'],
				'quantity'          	=> $product_discount['quantity'],
				'priority'          	=> $product_discount['priority'],
				'discount_percent_1'	=> $product_discount['discount_percent_1'],
				'discount_percent_2'	=> $product_discount['discount_percent_2'],
				'discount_fixed'		=> $product_discount['discount_fixed'],
				'date_start'        	=> ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          	=> ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			);
		}

		$data['product_discount_count'] = count($data['product_discounts']);

		if (isset($this->request->post['product_special'])) {
			$product_specials = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_specials = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$product_specials = array();
		}

		$data['product_specials'] = array();

		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = array(
				'customer_group_id' 	=> $product_special['customer_group_id'],
				'priority'          	=> $product_special['priority'],
				'discount_percent_1'	=> $product_special['discount_percent_1'],
				'discount_percent_2'	=> $product_special['discount_percent_2'],
				'discount_fixed'		=> $product_special['discount_fixed'],
				'date_start'        	=> ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          	=> ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			);
		}

		$data['product_special_count'] = count($data['product_specials']);

		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['product_download'])) {
			$product_downloads = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$product_downloads = array();
		}

		$data['product_downloads'] = array();

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['product_reward'])) {
			$data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$data['product_reward'] = array();
		}

		if (isset($this->request->post['product_layout'])) {
			$data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$data['product_layout'] = array();
		}

		$data['form_variant'] = $this->getFormVariant();

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_form', $data));
	}

	protected function getFormVariant()
	{
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$language_items = [
			'heading_title',
			'column_image',
			'column_model',
			'column_quantity',
			'column_price',
			'column_points',
			'column_weight',
			'column_weight_class',
			'column_action',
			'entry_model',
			'entry_quantity',
			'entry_price',
			'entry_points',
			'entry_weight',
			'entry_variant',
			'button_option_value_add',
			'button_remove',
		];
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('catalog/option');

		if (isset($this->request->post['product_variant'])) {
			$product_variant = $this->request->post['product_variant'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_variant = $this->model_catalog_product->getProductVariants($this->request->get['product_id']);
		} else {
			$product_variant = [];
		}

		$data['product_variants'] = [];
		$option_data = [];
		$variant_value_data = [];

		if ($product_variant) {
			if (!empty($product_variant['option'])) {
				foreach ($product_variant['option'] as $idx => $option) {
					$option_value_data = [];

					$option_value_data = $this->model_catalog_option->getOptionValues($option['option_id']);

					$sort_order = array();

					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $option_value_data);

					if (!isset($option['name'])) {
						$option_name = $this->model_catalog_option->getOption($option['option_id'])['name'];
					} else {
						$option_name = $option['name'];
					}

					$option_data[$idx] = [
						'option_id'		=> $option['option_id'],
						'name'			=> $option_name,
						'option_value'	=> $option_value_data
					];
				}
			}

			if (!empty($product_variant['variant'])) {
				foreach ($product_variant['variant'] as $variant) {
					$thumb = (is_file(DIR_IMAGE . $variant['image'])) ? $variant['image'] : '';

					$variant_value_data[] = [
						'thumb'				=> $this->model_tool_image->resize($thumb, 100, 100),
						'image'				=> $variant['image'],
						'option_value_id'   => (isset($variant['option_value_id']) && is_array($variant['option_value_id'])) ? $variant['option_value_id'] : [],
						'model'          	=> $variant['model'],
						'quantity'       	=> $variant['quantity'],
						'price'          	=> $variant['price'],
						'points'         	=> $variant['points'],
						'weight'         	=> $variant['weight'],
						'weight_class_id'	=> $variant['weight_class_id']
					];
				}
			}
		} else {
			$variant_value_data[] = [
				'thumb'				=> $this->model_tool_image->resize('', 100, 100),
				'image'				=> '',
				'option_value_id'   => [],
				'model'          	=> '',
				'quantity'       	=> 0,
				'price'          	=> 0,
				'points'         	=> 0,
				'weight'         	=> 0,
				'weight_class_id'	=> $this->config->get('config_weight_class_id')
			];
		}

		$data['product_variants'] = [
			'option'	=> $option_data,
			'variant'	=> $variant_value_data
		];

		$data['default_value'] = json_encode($variant_value_data[0]);

		$data['option_count'] = count($option_data);
		$data['variant_count'] = count($variant_value_data);

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		return $this->load->view('catalog/product_form_variant', $data);
	}

	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		$product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;

		$product_info = $this->model_catalog_product->getProduct($product_id);

		# validasi sku harus unik
		if (!isset($this->request->get['product_id']) || ($product_info && $product_info['sku'] != $this->request->post['sku'])) {
			$product_check = $this->model_catalog_product->getProductBySku($this->request->post['sku']);

			if ($product_check) {
				$this->error['sku'] = $this->language->get('error_sku_used');
			}
		}

		# check posted product_variant_model must be unique and not in used
		$variant_models = array_column($this->request->post['product_variant']['variant'], 'model');

		if ($variant_models != array_unique($variant_models)) {
			$this->error['variant'] = $this->language->get('error_model_unique');
		} elseif (!isset($this->request->post['product_variant']['option']) && count($variant_models) != 1) {
			$this->error['variant'] = $this->language->get('error_option');
		} else {
			foreach ($variant_models as $model) {
				if ((utf8_strlen($model) < 1) || (utf8_strlen($model) > 32)) {
					$this->error['variant'] = $this->language->get('error_model');

					break;
				}

				$product_model_check =  $this->model_catalog_product->checkProductModel($model, $product_id);

				if ($product_model_check) {
					$this->error['variant'] = $this->language->get('error_model_used');

					break;
				}
			}
		}

		if ($this->request->post['keyword']) {
			$this->request->post['keyword'] = preg_replace('/[\'\"*?+&\s-]+/', '-', utf8_strtolower(($this->request->post['keyword'])));

			if (utf8_strlen($this->request->post['keyword']) > 0) {
				$this->load->model('catalog/url_alias');

				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

				if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}

				if ($url_alias_info && !isset($this->request->get['product_id'])) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy()
	{
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete()
	{
		$json = array();

		if ((isset($this->request->get['filter_name']) && strlen($this->request->get['filter_name']) > 1) || (isset($this->request->get['filter_model']) && strlen($this->request->get['filter_model']) > 1)) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = '10';
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProductsAutoComplete($filter_data);

			foreach ($results as $result) {
				$variant_data = $this->model_catalog_product->getProductVariants($result['product_id']);

				$option_data = [];

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'variant'    => $variant_data,
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
