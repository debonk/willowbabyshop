<?php
class ControllerModuleCarousel extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

//		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css'); //Bonk: uploaded on head.tpl
//		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js'); //Bonk: uploaded on head.tpl

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
					'dim'	=> 'width:' . $setting['width'] . 'px; height: ' . $setting['height'] . 'px;'
				);
			}
		}

		$data['module'] = $module++;
//echo $data['banners']['dim'];
		return $this->load->view('module/carousel', $data);
	}
}