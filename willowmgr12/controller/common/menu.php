<?php
class ControllerCommonMenu extends Controller {
	public function index()
	{
		$this->load->language('common/menu');

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);

		$data['menu_groups'] = [];
		$data['child_groups'] = [];
		$data['menu_title'] = [];

		$fa_icon_class = ['fa-tags', 'fa-puzzle-piece', 'fa-television', 'fa-shopping-cart', 'fa-user', 'fa-share-alt', 'fa-rocket', 'fa-globe', 'fa-cog', 'fa-bar-chart-o', 'fa-info', '', ''];

		$menu_groups = [
			'catalog'		=> [
				'catalog/category',
				'catalog/product',
				'catalog/recurring',
				'catalog/filter',
				'attribute'		=> ['catalog/attribute', 'catalog/attribute_group'],
				'catalog/option',
				'catalog/manufacturer',
				'catalog/download',
				'catalog/review',
				'catalog/information',
				'catalog/tool'
			],
			'extension'		=> ['extension/installer', 'extension/modification', 'extension/theme', 'extension/analytics', 'extension/captcha', 'extension/feed', 'extension/fraud', 'extension/module', 'extension/payment', 'extension/shipping', 'extension/total'],
			'design'		=> ['design/layout', 'design/banner'],
			'sale'		=> [
				'sale/order',
				'sale/recurring',
				'sale/return',
				'voucher'		=> ['sale/voucher', 'sale/voucher_theme'],
				'paypal'		=> ['payment/pp_express']
			],
			'customer'		=> ['customer/customer', 'customer/customer_group', 'customer/custom_field'],
			'marketing'		=> ['marketing/marketing', 'marketing/affiliate', 'marketing/coupon', 'marketing/contact', 'marketing/collection'],
			'themecontrol'	=> ['module/themecontrol', 'module/pavmegamenu', 'module/pavblog', 'module/pavnewsletter'],
			'localisation'	=> [
				'localisation/location',
				'localisation/language',
				'localisation/currency',
				'localisation/stock_status',
				'localisation/order_status',
				'return' => ['localisation/return_status', 'localisation/return_action', 'localisation/return_reason'],
				'localisation/country',
				'localisation/zone',
				'localisation/city',
				'localisation/geo_zone',
				'tax' => ['localisation/tax_class', 'localisation/tax_rate'],
				'localisation/length_class',
				'localisation/weight_class'
			],
			'system'		=> [
				'setting/store',
				'user'			=> ['user/user', 'user/user_permission', 'user/api'],
				'tool'			=> ['tool/sysinfo', 'tool/upload', 'tool/backup', 'tool/error_log']
			],
			'report'		=> [
				'sale'			=> ['report/sale_order', 'report/sale_tax', 'report/sale_shipping', 'report/sale_return', 'report/sale_coupon', 'report/sale_cashback'],
				'product'		=> ['report/product_viewed', 'report/product_purchased', 'report/payroll_tax'],
				'customer'		=> ['report/customer_online', 'report/customer_activity', 'report/customer_order', 'report/customer_reward', 'report/customer_credit'],
				'marketing'		=> ['report/marketing', 'report/affiliate', 'report/affiliate_activity'],
			]
		];

		$permission_data = [];

		$permissions = $this->user->getPermission();

		foreach ($permissions as $authority => $permission) {
			foreach ($permission as $value) {
				$permission_data[$value] = [
					'url'	=> $this->url->link($value, 'token=' . $this->session->data['token'], 'true'),
					'text'	=> $this->language->get('text_' . explode('/', $value)[1]),
					'class'	=> $authority
				];
			}
		}

		#custom menu if not default
		if (isset($permission_data['setting/store'])) {
			$permission_data['setting/store']['text'] = $this->language->get('text_setting');
		}

		if (isset($permission_data['sale/recurring'])) {
			$permission_data['sale/recurring']['text'] = $this->language->get('text_order_recurring');
		}

		if (isset($permission_data['payment/pp_express'])) {
			$permission_data['payment/pp_express']['url'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], 'true');
			$permission_data['payment/pp_express']['text'] = $this->language->get('text_paypal_search');
		}

		$menu_titles = array_keys($menu_groups);
		foreach ($menu_titles as $idx => $title) {
			$data['menu_titles'][$title] = [
				'text'	=> $this->language->get('text_' . $title),
				'icon'	=> $fa_icon_class[$idx]
			];
		}

		foreach ($menu_groups as $menu_group => $menu_items) {
			foreach ($menu_items as $child_group => $menu_item) {
				if (is_array($menu_item)) {
					foreach ($menu_item as $child_item) {
						if (array_key_exists($child_item, $permission_data)) {
							$data['child_groups'][$menu_group][$child_group][] = $permission_data[$child_item];
						}
					}

					if (!empty($data['child_groups'][$menu_group][$child_group])) {
						$data['menu_groups'][$menu_group][$child_group] = [
							'text'	=> $this->language->get('text_' . $child_group)
						];
					}
				} else {
					if (array_key_exists($menu_item, $permission_data)) {
						$data['menu_groups'][$menu_group][$menu_item] = $permission_data[$menu_item];
					}
				}
			}
		}

		return $this->load->view('common/menu', $data);
	}

	public function index2() {
		$this->load->language('common/menu');
		// pavo 2.2 edit
		$data['pavo_link'] = $this->url->link('module/themecontrol', 'token=' . $this->session->data['token'], 'true');
		$data['megamenu_link'] = $this->url->link('module/pavmegamenu', 'token=' . $this->session->data['token'], 'true');
		$data['pavblog_link'] = $this->url->link('module/pavblog', 'token=' . $this->session->data['token'], 'true');
		$data['pavnewsletter_link'] = $this->url->link('module/pavnewsletter', 'token=' . $this->session->data['token'], 'true');
		// pavo 2.2 end edit
	
		$data['text_analytics'] = $this->language->get('text_analytics');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_api'] = $this->language->get('text_api');
		$data['text_attribute'] = $this->language->get('text_attribute');
		$data['text_attribute_group'] = $this->language->get('text_attribute_group');
		$data['text_backup'] = $this->language->get('text_backup');
		$data['text_banner'] = $this->language->get('text_banner');
		$data['text_captcha'] = $this->language->get('text_captcha');
		$data['text_catalog'] = $this->language->get('text_catalog');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_coupon'] = $this->language->get('text_coupon');
//		$data['text_cashback'] = $this->language->get('text_cashback');//Bonk04
		$data['text_currency'] = $this->language->get('text_currency');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_customer_group'] = $this->language->get('text_customer_group');
		$data['text_customer_field'] = $this->language->get('text_customer_field');
		$data['text_custom_field'] = $this->language->get('text_custom_field');
		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_paypal'] = $this->language->get('text_paypal');
		$data['text_paypal_search'] = $this->language->get('text_paypal_search');
		$data['text_design'] = $this->language->get('text_design');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_error_log'] = $this->language->get('text_error_log');
		$data['text_extension'] = $this->language->get('text_extension');
		$data['text_feed'] = $this->language->get('text_feed');
		$data['text_fraud'] = $this->language->get('text_fraud');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_installer'] = $this->language->get('text_installer');
		$data['text_language'] = $this->language->get('text_language');
		$data['text_layout'] = $this->language->get('text_layout');
		$data['text_localisation'] = $this->language->get('text_localisation');
		$data['text_location'] = $this->language->get('text_location');
		$data['text_marketing'] = $this->language->get('text_marketing');
		$data['text_modification'] = $this->language->get('text_modification');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_module'] = $this->language->get('text_module');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_opencart'] = $this->language->get('text_opencart');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_reports'] = $this->language->get('text_reports');
		$data['text_report_sale_order'] = $this->language->get('text_report_sale_order');
		$data['text_report_sale_tax'] = $this->language->get('text_report_sale_tax');
		$data['text_report_sale_shipping'] = $this->language->get('text_report_sale_shipping');
		$data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$data['text_report_sale_coupon'] = $this->language->get('text_report_sale_coupon');
		$data['text_report_sale_cashback'] = $this->language->get('text_report_sale_cashback');//Bonk04
		$data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$data['text_report_product_purchased'] = $this->language->get('text_report_product_purchased');
		$data['text_report_customer_activity'] = $this->language->get('text_report_customer_activity');
		$data['text_report_customer_online'] = $this->language->get('text_report_customer_online');
		$data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$data['text_report_customer_reward'] = $this->language->get('text_report_customer_reward');
		$data['text_report_customer_credit'] = $this->language->get('text_report_customer_credit');
		$data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$data['text_report_affiliate'] = $this->language->get('text_report_affiliate');
		$data['text_report_affiliate_activity'] = $this->language->get('text_report_affiliate_activity');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_return_action'] = $this->language->get('text_return_action');
		$data['text_return_reason'] = $this->language->get('text_return_reason');
		$data['text_return_status'] = $this->language->get('text_return_status');
		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_stock_status'] = $this->language->get('text_stock_status');
		$data['text_system'] = $this->language->get('text_system');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_tax_class'] = $this->language->get('text_tax_class');
		$data['text_tax_rate'] = $this->language->get('text_tax_rate');
		$data['text_theme'] = $this->language->get('text_theme');
		$data['text_tools'] = $this->language->get('text_tools');
		$data['text_total'] = $this->language->get('text_total');
		$data['text_upload'] = $this->language->get('text_upload');
		$data['text_tracking'] = $this->language->get('text_tracking');
		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');
		$data['text_users'] = $this->language->get('text_users');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_voucher_theme'] = $this->language->get('text_voucher_theme');
		$data['text_weight_class'] = $this->language->get('text_weight_class');
		$data['text_length_class'] = $this->language->get('text_length_class');
		$data['text_zone'] = $this->language->get('text_zone');
		$data['text_city'] = $this->language->get('text_city'); //Bonk
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_order_recurring'] = $this->language->get('text_order_recurring');
		$data['text_openbay_extension'] = $this->language->get('text_openbay_extension');
		$data['text_openbay_dashboard'] = $this->language->get('text_openbay_dashboard');
		$data['text_openbay_orders'] = $this->language->get('text_openbay_orders');
		$data['text_openbay_items'] = $this->language->get('text_openbay_items');
		$data['text_openbay_ebay'] = $this->language->get('text_openbay_ebay');
		$data['text_openbay_etsy'] = $this->language->get('text_openbay_etsy');
		$data['text_openbay_amazon'] = $this->language->get('text_openbay_amazon');
		$data['text_openbay_amazonus'] = $this->language->get('text_openbay_amazonus');
		$data['text_openbay_settings'] = $this->language->get('text_openbay_settings');
		$data['text_openbay_links'] = $this->language->get('text_openbay_links');
		$data['text_openbay_report_price'] = $this->language->get('text_openbay_report_price');
		$data['text_openbay_order_import'] = $this->language->get('text_openbay_order_import');

		$data['analytics'] = $this->url->link('extension/analytics', 'token=' . $this->session->data['token'], true);
		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
		$data['affiliate'] = $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'], true);
		$data['api'] = $this->url->link('user/api', 'token=' . $this->session->data['token'], true);
		$data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], true);
		$data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], true);
		$data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], true);
		$data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], true);
		$data['captcha'] = $this->url->link('extension/captcha', 'token=' . $this->session->data['token'], true);
		$data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], true);
		$data['country'] = $this->url->link('localisation/country', 'token=' . $this->session->data['token'], true);
		$data['contact'] = $this->url->link('marketing/contact', 'token=' . $this->session->data['token'], true);
		$data['coupon'] = $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], true);
//		$data['cashback'] = $this->url->link('marketing/cashback', 'token=' . $this->session->data['token'], true);//Bonk04
		$data['currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], true);
		$data['customer'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'], true);
		$data['customer_fields'] = $this->url->link('customer/customer_field', 'token=' . $this->session->data['token'], true);
		$data['customer_group'] = $this->url->link('customer/customer_group', 'token=' . $this->session->data['token'], true);
		$data['custom_field'] = $this->url->link('customer/custom_field', 'token=' . $this->session->data['token'], true);
		$data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], true);
		$data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], true);
		$data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], true);
		$data['filter'] = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], true);
		$data['fraud'] = $this->url->link('extension/fraud', 'token=' . $this->session->data['token'], true);
		$data['geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], true);
		$data['information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], true);
		$data['tool'] = $this->url->link('catalog/tool', 'token=' . $this->session->data['token'], true);
		$data['installer'] = $this->url->link('extension/installer', 'token=' . $this->session->data['token'], true);
		$data['language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], true);
		$data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], true);
		$data['location'] = $this->url->link('localisation/location', 'token=' . $this->session->data['token'], true);
		$data['modification'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], true);
		$data['manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], true);
		$data['marketing'] = $this->url->link('marketing/marketing', 'token=' . $this->session->data['token'], true);
		$data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		$data['option'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], true);
		$data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], true);
		$data['order_status'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], true);
		$data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);
		$data['paypal_search'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], true);
		$data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], true);
		$data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], true);
		$data['report_sale_tax'] = $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], true);
		$data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], true);
		$data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], true);
		$data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], true);
		$data['report_sale_cashback'] = $this->url->link('report/sale_cashback', 'token=' . $this->session->data['token'], true);//Bonk04
		$data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], true);
		$data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], true);
		$data['report_customer_activity'] = $this->url->link('report/customer_activity', 'token=' . $this->session->data['token'], true);
		$data['report_customer_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], true);
		$data['report_customer_order'] = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], true);
		$data['report_customer_reward'] = $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], true);
		$data['report_customer_credit'] = $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], true);
		$data['report_marketing'] = $this->url->link('report/marketing', 'token=' . $this->session->data['token'], true);
		$data['report_affiliate'] = $this->url->link('report/affiliate', 'token=' . $this->session->data['token'], true);
		$data['report_affiliate_activity'] = $this->url->link('report/affiliate_activity', 'token=' . $this->session->data['token'], true);
		$data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], true);
		$data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], true);
		$data['return_action'] = $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], true);
		$data['return_reason'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], true);
		$data['return_status'] = $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], true);
		$data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true);
		$data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], true);
		$data['stock_status'] = $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], true);
		$data['tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], true);
		$data['tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], true);
		$data['theme'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], true);
		$data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], true);
		$data['upload'] = $this->url->link('tool/upload', 'token=' . $this->session->data['token'], true);
		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], true);
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true);
		$data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], true);
		$data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], true);
		$data['weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], true);
		$data['length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], true);
		$data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], true);
		$data['city'] = $this->url->link('localisation/city', 'token=' . $this->session->data['token'], true);//Bonk
		$data['recurring'] = $this->url->link('catalog/recurring', 'token=' . $this->session->data['token'], true);
		$data['order_recurring'] = $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], true);

		$data['openbay_show_menu'] = $this->config->get('openbaypro_menu');
		$data['openbay_link_extension'] = $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_orders'] = $this->url->link('extension/openbay/orderlist', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_items'] = $this->url->link('extension/openbay/items', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_ebay'] = $this->url->link('openbay/ebay', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_ebay_settings'] = $this->url->link('openbay/ebay/settings', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_ebay_links'] = $this->url->link('openbay/ebay/viewitemlinks', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_etsy'] = $this->url->link('openbay/etsy', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_etsy_settings'] = $this->url->link('openbay/etsy/settings', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_etsy_links'] = $this->url->link('openbay/etsy_product/links', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_ebay_orderimport'] = $this->url->link('openbay/ebay/vieworderimport', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazon'] = $this->url->link('openbay/amazon', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazon_settings'] = $this->url->link('openbay/amazon/settings', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazon_links'] = $this->url->link('openbay/amazon/itemlinks', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazonus'] = $this->url->link('openbay/amazonus', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazonus_settings'] = $this->url->link('openbay/amazonus/settings', 'token=' . $this->session->data['token'], true);
		$data['openbay_link_amazonus_links'] = $this->url->link('openbay/amazonus/itemlinks', 'token=' . $this->session->data['token'], true);
		$data['openbay_markets'] = array(
			'ebay' => $this->config->get('ebay_status'),
			'amazon' => $this->config->get('openbay_amazon_status'),
			'amazonus' => $this->config->get('openbay_amazonus_status'),
			'etsy' => $this->config->get('etsy_status'),
		);

		return $this->load->view('common/menu', $data);
	}
}
