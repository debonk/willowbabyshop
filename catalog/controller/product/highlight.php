<?php
class ControllerProductHighlight extends Controller
{
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

		$this->load->language('product/highlight');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		//Bonk
		if (isset($this->request->get['highlight'])) {
			$highlight = $this->request->get['highlight'];
			$title = $this->language->get('heading_title_' . $highlight);
		} else {
			$highlight = '';
			$title = $this->language->get('heading_title');
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = '';
		}

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$this->document->setTitle($title);
		//		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['highlight'])) {
			$url .= '&highlight=' . urlencode(html_entity_decode($this->request->get['highlight'], ENT_QUOTES, 'UTF-8'));
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
			'text' => $title,
			//			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/highlight', $url)
		);

		$data['heading_title'] = $title;

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['compare'] = $this->url->link('product/compare');

		$data['products'] = array();

		/*		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
*/
		//echo $sort . " - " . $order;
		switch ($highlight) {
			case "popular":
				$product_total = 100;
				$results = $this->model_catalog_product->getPopularProducts($product_total);
				break;
			case "bestseller":
				$product_total = 100;
				$results = $this->model_catalog_product->getBestSellerProducts($product_total);
				break;
			default: //latest
				$product_total = 100;
				$results = $this->model_catalog_product->getLatestProducts($product_total);
		}

		$sort_col = (array_column($results, $sort));

		// $a = $this->model_catalog_product->getProduct(2870);
		// var_dump($results);
		// die('---breakpoint---');
		
		if (isset($this->request->get['sort'])) {
			if ($order == 'DESC') {
				array_multisort($sort_col, SORT_DESC, $results);
			} else {
				array_multisort($sort_col, SORT_ASC, $results);
			}
		}

		$start = ($page - 1) * $limit;

		if (isset($this->request->get['limit']) || isset($this->request->get['start'])) {
			if ($start < 0) {
				$start = 0;
			}

			if ($limit < 1) {
				$limit = 20;
			}
		}

		$results = array_slice($results, $start, $limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
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
				'product_id' 	=> $result['product_id'],
				'thumb'      	=> $image,
				'name'       	=> $result['name'],
				'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'      	=> $price,
				'special'    	=> $special,
				'special_text'	=> $result['special_text'],
				'tax'    		=> $tax,
				'minimum'		=> $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating' 		=> $rating,
				'href'   		=> $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['highlight'])) {
			$url .= '&highlight=' . urlencode(html_entity_decode($this->request->get['highlight'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'sort_order-ASC',
			'href'  => $this->url->link('product/highlight', 'sort=sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'name-ASC',
			'href'  => $this->url->link('product/highlight', 'sort=name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'name-DESC',
			'href'  => $this->url->link('product/highlight', 'sort=name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'price-ASC',
			'href'  => $this->url->link('product/highlight', 'sort=price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'price-DESC',
			'href'  => $this->url->link('product/highlight', 'sort=price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/highlight', 'sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/highlight', 'sort=rating&order=ASC' . $url)
			);
		}

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_asc'),
			'value' => 'model-ASC',
			'href'  => $this->url->link('product/highlight', 'sort=model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'model-DESC',
			'href'  => $this->url->link('product/highlight', 'sort=model&order=DESC' . $url)
		);

		$url = '';

		if (isset($this->request->get['highlight'])) {
			$url .= '&highlight=' . urlencode(html_entity_decode($this->request->get['highlight'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach ($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('product/highlight', $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['highlight'])) {
			$url .= '&highlight=' . urlencode(html_entity_decode($this->request->get['highlight'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/highlight', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
			$this->document->addLink($this->url->link('product/highlight', '', true), 'canonical');
		} elseif ($page == 2) {
			$this->document->addLink($this->url->link('product/highlight', '', true), 'prev');
		} else {
			$this->document->addLink($this->url->link('product/highlight', 'page=' . ($page - 1), true), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('product/highlight', 'page=' . ($page + 1), true), 'next');
		}

		//		$data['highlight'] = $highlight;

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/highlight', $data));
	}
}
