<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		
		// Pavo 2.2 fix
		require_once( DIR_SYSTEM . 'pavothemes/loader.php' );

		$this->load->language('module/themecontrol');
		$data['objlang'] = $this->language;

		$config = $this->registry->get('config');
		$data['sconfig'] = $config;

		$helper = ThemeControlHelper::getInstance( $this->registry, $config->get('theme_default_directory') );
		$helper->triggerUserParams( array('header_layout','productlayout') );
		$data['helper'] = $helper;

		$themeConfig = (array)$config->get('themecontrol');
		// Pavo 2.2 end fix

		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = [];

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				if ($this->config->get($analytic['code'] . '_position') == 'footer') {
					$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
				}
			}
		}

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_blogs'] = $this->language->get('text_blogs');//Bonk
		// $data['text_career'] = $this->language->get('text_career');//Bonk

		$media_list = ['instagram', 'tokopedia', 'shopee', 'blibli', 'jdid'];

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['media_list'] = [];

		foreach ($media_list as $media) {
			if (is_file(DIR_IMAGE . 'icon/' . $media . '.png')) {
				$data['media_list'][] = [
					'image'	=> $server . 'image/icon/' . $media . '.png',
					'link'	=> $this->language->get('link_' . $media),
					'alt'	=> 'icon_' . $media
				];
			}
		}	

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact', '', true);
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap', '', true);
		$data['manufacturer'] = $this->url->link('product/manufacturer', '', true);
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special', '', true);
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['blogs'] = $this->url->link('pavblog/blogs', '', true);//Bonk
		// $data['career'] = $this->url->link('information/career');//Bonk

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer', $data);
	}
}
