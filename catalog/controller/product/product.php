<?php
class ControllerProductProduct extends Controller
{
	private $error = array();

	public function index()
	{

		// pavo version 2.2
		$this->load->language('module/themecontrol');
		$data['objlang'] = $this->registry->get('language');
		$data['ourl'] = $this->registry->get('url');

		$config = $this->registry->get("config");
		$data['sconfig'] = $config;
		$data['themename'] = $config->get("theme_default_directory");
		// end edit

		$this->load->language('product/product');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('catalog/category');

		if (isset($this->request->get['path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
				);
			}
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->get['manufacturer_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_brand'),
				'href' => $this->url->link('product/manufacturer')
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

			if ($manufacturer_info) {
				$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
				);
			}
		}

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('product/search', $url)
			);
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $product_id), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			$language_items = [
				'text_discount',
				'text_loading',
				'text_login',
				'text_manufacturer',
				'text_minimum',
				'text_model',
				'text_note',
				'text_option',
				'text_payment_recurring',
				'text_points',
				'text_related',
				'text_reward',
				'text_select',
				'text_stock',
				'text_tags',
				'text_tax',
				'text_variant',
				'text_write',
				'entry_qty',
				'entry_name',
				'entry_review',
				'entry_rating',
				'entry_good',
				'entry_bad',
				'button_cart',
				'button_wishlist',
				'button_compare',
				'button_upload',
				'button_continue',
				'tab_description',
				'tab_attribute'
			];
			foreach ($language_items as $language_item) {
				$data[$language_item] = $this->language->get($language_item);
			}

			$this->load->model('catalog/review');

			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$product_id;

			$data['heading_title'] = $product_info['name'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['reward'] = $product_info['reward'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

			$data['description'] .= '<br><br><p><a href="' . $this->url->link('common/home') . '">willowbabyshop</a><br></p>'; //Bonk13

			$this->load->model('tool/image');

			if (is_file(DIR_IMAGE . $product_info['manufacturer_image'])) {
				$data['manufacturers_img'] = $this->model_tool_image->resize($product_info['manufacturer_image'], 200, 100);
			} else {
				$data['manufacturers_img'] = false;
			}

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['popup'] = '';
				$data['thumb'] = '';
			}

			$data['images'] = [];

			$product_images = $this->model_catalog_product->getProductImages($product_id);
			$images = array_column($product_images, 'image');

			$product_variants = $this->model_catalog_product->getProductVariants($product_id);

			foreach ($product_variants['variant'] as $variant) {
				if ($variant['image']) {
					$images['v' . $variant['product_option_value_id']] = $variant['image'];
				}
			}

			foreach ($images as $idx => $image) {
				$data['images'][$idx] = array(
					'popup' => $this->model_tool_image->resize($image, $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($image, $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
				);
			}

			$product_info['model'] = $product_variants['variant'][0]['model'];
			$product_info['price'] = $product_variants['variant'][0]['price'];
			$product_info['points'] = $product_variants['variant'][0]['points'];

			$data['model'] = $product_info['model'];
			$data['points'] = $product_info['points'];

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}

			$specials = $this->model_catalog_product->getProductSpecial($product_id);

			if ($specials) {
				$product_info['special'] = $product_info['price'];
				$data['special_text'] = [];

				if ($specials['discount_percent_1']) {
					$product_info['special'] *= (100 - $specials['discount_percent_1']) / 100;
					$data['special_text'][] = $specials['discount_percent_1'] . '%';
				}

				if ($specials['discount_percent_2']) {
					$product_info['special'] *= (100 - $specials['discount_percent_2']) / 100;
					$data['special_text'][] = $specials['discount_percent_2'] . '%';
				}

				if ($specials['discount_fixed']) {
					$product_info['special'] = max(0, $product_info['special'] - $specials['discount_fixed']);
					$data['special_text'][] = round($specials['discount_fixed'] / 1000, 0) . 'K';
				}

				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$data['special_text'] = implode(' + ', $data['special_text']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format($product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($product_id);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$discount_price = isset($product_info['special']) ? $product_info['special'] : $product_info['price'];
				$discount_text = [];

				if ($discount['discount_percent_1']) {
					$discount_price *= (100 - $discount['discount_percent_1']) / 100;
					$discount_text[] = $discount['discount_percent_1'] . '%';
				}

				if ($discount['discount_percent_2']) {
					$discount_price *= (100 - $discount['discount_percent_2']) / 100;
					$discount_text[] = $discount['discount_percent_2'] . '%';
				}

				if ($discount['discount_fixed']) {
					$discount_price = max(0, $discount_price - $discount['discount_fixed']);
					$discount_text[] = round($discount['discount_fixed'] / 1000, 0) . 'K';
				}

				$data['discounts'][] = array(
					'quantity' 		=> $discount['quantity'],
					'price'    		=> $this->currency->format($this->tax->calculate($discount_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
					'text' 			=> implode(' + ', $discount_text)
					// 'discount_text'	=> sprintf($this->language->get('text_discount'), $discount['quantity'], $this->currency->format($this->tax->calculate($discount_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), implode(' + ', $discount_text))
				);
			}

			$data['variant_option'] = $product_variants['option'];

			$data['options'] = $this->model_catalog_product->getProductOptions($product_id);

			$product_quantity = array_sum(array_column($product_variants['variant'], 'quantity'));

			if ($product_quantity <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_quantity;
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviews'] = $product_info['reviews'] ? sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']) : '';
			$data['rating'] = (int)$product_info['rating'];

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('product/product', 'product_id=' . (int)$product_id);

			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($product_id);

			$data['products'] = array();

			$results = $this->model_catalog_product->getProductRelated($product_id);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['recurrings'] = $this->model_catalog_product->getProfiles($product_id);

			$this->model_catalog_product->updateViewed($product_id);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			//Bonk02:Markup Data - Breadcrumb
			$mark_up_breadcrumb = '{"@context": "http://schema.org", "@type": "BreadcrumbList", "itemListElement": [';
			$i = 1;
			foreach ($data['breadcrumbs'] as $breadcrumb) {
				if ($i == 1) {
					$mark_up_breadcrumb_text = $this->config->get('config_name');
				} else {
					$mark_up_breadcrumb_text = $breadcrumb['text'];
				}

				$mark_up_breadcrumb .= '
				{
					"@type": "ListItem",
					"position": ' . $i . ',
					"item": {
						"@id": "' . $breadcrumb['href'] . '",
						"name": "' . htmlspecialchars_decode($mark_up_breadcrumb_text) . '"
					}
				}';
				if ($i < count($data['breadcrumbs'])) {
					$mark_up_breadcrumb .= ',';
				} else {
					$mark_up_breadcrumb .= ']}';
				}
				$i++;
			}

			$data['mark_up_breadcrumb'] = $mark_up_breadcrumb;

			//Bonk02:Markup Data - Product //should be: "price": "' . $mark_up_product_price . '",
			if ($specials) {
				$mark_up_product_price = $product_info['special'];
			} else {
				$mark_up_product_price = $product_info['price'];
			}

			if ($this->request->server['HTTPS']) {
				$server = $this->config->get('config_ssl');
			} else {
				$server = $this->config->get('config_url');
			}

			$mark_up_product = '{"@context": "http://schema.org", "@type": "Product",
			"name": "' . $product_info['name'] . '",
			"image": "' . $server . $product_info['image'] . '",
			"description": "' . $product_info['description'] . '",
			"model": "' . $product_info['model'] . '",
			"brand": {
				"@type": "Thing",
				"name": "' . $product_info['manufacturer'] . '"
			},';
			if ($product_info['rating']) {
				$mark_up_product .= '"aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": "' . $product_info['rating'] . '",
					"reviewCount": "' . $product_info['reviews'] . '"
				},';
			}
			$mark_up_product .= '"offers": {
				"@type": "Offer",
				"priceCurrency": "' . $this->session->data['currency'] . '",
				"price": "' . $mark_up_product_price . '",
				"itemCondition": "http://schema.org/NewCondition",';
			if ($product_quantity) {
				$mark_up_product .= '"availability": "http://schema.org/InStock",';
			} else {
				$mark_up_product .= '"availability": "http://schema.org/OutOfStock",';
			}
			$mark_up_product .= '"seller": {
					"@type": "Organization",
					"name": "' . $this->config->get('config_name') . '"
				}
			}
			}';

			$data['mark_up_product'] = $mark_up_product;
			//Bonk02:End

			$this->response->setOutput($this->load->view('product/product', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function variant()
	{
		$this->load->language('product/product');

		$json = array();

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['variant'])) {
				$variant = array_filter($this->request->post['variant']);
			} else {
				$variant = array();
			}

			$product_variants = $this->model_catalog_product->getProductVariants($product_id);

			$product_detail = [];

			foreach ($product_variants['variant'] as $variant_value) {
				if ($variant_value['option_value_id'] == $variant['variant_id']) {
					$product_model = $variant_value['model'];

					if ($variant_value['quantity'] <= 0) {
						$product_stock = $product_info['stock_status'];
					} elseif ($this->config->get('config_stock_display')) {
						$product_stock = $product_info['quantity'];
					} else {
						$product_stock = $this->language->get('text_instock');
					}

					$specials = $this->model_catalog_product->getProductSpecial($product_id);

					if ($specials) {
						$special = $variant_value['price'];

						$special *= (100 - $specials['discount_percent_1']) / 100;
						$special *= (100 - $specials['discount_percent_2']) / 100;
						$special = max(0, $special - $specials['discount_fixed']);
					}

					$discounts = $this->model_catalog_product->getProductDiscounts($product_id);

					$discount_data = [];

					foreach ($discounts as $discount) {
						$discount_price = isset($special) ? $special :  $variant_value['price'];
		
						$discount_price *= (100 - $discount['discount_percent_1']) / 100;
						$discount_price *= (100 - $discount['discount_percent_2']) / 100;
						$discount_price = max(0, $discount_price - $discount['discount_fixed']);

						$discount_data[] = [
							'quantity' 		=> $discount['quantity'],
							'price'    		=> $this->currency->format($this->tax->calculate($discount_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
						];
					}	
	
					$product_detail = [
						'model'		=> $product_model,
						'name'		=> $product_info['name'] . ' - ' . $this->model_catalog_product->getProductVariantName($variant_value['option_value_id']),
						'price'		=> $this->currency->format($this->tax->calculate($variant_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
						'special'	=> $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
						'discount'	=> $discount_data,
						'points'	=> $variant_value['points'],
						'idx'		=> $variant_value['product_option_value_id'],
						'stock'		=> $product_stock
					];

					break;
				}
			}

			if ($variant) {
				$json['detail'] = $product_detail;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function review()
	{
		$this->load->language('product/product');

		$this->load->model('catalog/review');

		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		$data['reviews'] = array();

		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviews'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

		$this->response->setOutput($this->load->view('product/review', $data));
	}

	public function write()
	{
		$this->load->language('product/product');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error']['name'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error']['review'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error']['rating'] = $this->language->get('error_rating');
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getRecurringDescription()
	{
		$this->load->language('product/product');
		$this->load->model('catalog/product');

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}

		if (isset($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		$product_info = $this->model_catalog_product->getProduct($product_id);
		$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

		$json = array();

		if ($product_info && $recurring_info) {
			if (!$json) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}

				$json['success'] = $text;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
