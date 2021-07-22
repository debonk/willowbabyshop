<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		//Bonk02:Markup Data - Site Name & Sitelink Searchbox
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$target = $this->url->link('product/search', '&search=');
		$mark_up_website = '{"@context": "http://schema.org", "@type": "WebSite",
			"url": "' . $server . '",
			"name": "' . $this->config->get('config_name') . '",
			"alternateName": "Willow Baby Shop",
			"potentialAction": {
				"@type": "SearchAction",
				"target": "' . $target . '{search_term_string}",
				"query-input": "required name=search_term_string"
			}
		}';
		$data['mark_up_website'] = $mark_up_website;
		
		//Bonk02:Markup Data - Contact, Logo, & Social
		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$logo = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$logo = '';
		}

		$mark_up_organization = '{"@context": "http://schema.org", "@type": "Organization",
			"url": "' . $server . '",
			"logo": "' . $logo . '",
			"contactPoint": [{
				"@type": "ContactPoint",
				"telephone": "+62-31-5925777",
				"contactType": "customer service"
			}],
			"sameAs":["https://www.facebook.com/willowbabyshop/","https://twitter.com/willowbabyshop","https://www.instagram.com/willowbabyshop/"]
		}';
//		"telephone": "' . $this->config->get('config_telephone') . '",
		$data['mark_up_organization'] = $mark_up_organization;
//		$data['data_mark_up'] = '[' . $mark_up_website . ', ' . $mark_up_organization . ']';
		//Bonk02:End

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}