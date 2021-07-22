<?php
/**
 * @package		FAQ - Frequently Asked Questions
 * @copyright	Copyright (C) 2016 Fido-X IT (John Simon). All rights reserved. (fido-x.net)
 * @license		GNU General Public License version 3; see http://www.gnu.org/licenses/gpl-3.0.en.html
 */

class ControllerModuleFaq extends Controller {
	public function index() {
		$this->language->load('module/faq');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['topic'])) {
			$parts = explode('_', (string)$this->request->get['topic']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['topic_id'] = $parts[0];
		} else {
			$data['topic_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('fido/faq');

		$data['faqs'] = array();

		$faqs = $this->model_fido_faq->getTopics(0);

		foreach ($faqs as $faq) {
			$children_data = array();

			if ($faq['faq_id'] == $data['topic_id']) {
				$children = $this->model_fido_faq->getTopics($faq['faq_id']);

				foreach($children as $child) {
					$filter_data = array(
						'filter_faq_id'    => $child['faq_id'],
						'filter_sub_topic' => true
					);

					$children_data[] = array(
						'faq_id' => $child['faq_id'],
						'title'  => $child['title'],
						'href'   => $this->url->link('information/faq', 'topic=' . $faq['faq_id'] . '_' . $child['faq_id'])
					);
				}
			}

			$filter_data = array(
				'filter_faq_id'    => $faq['faq_id'],
				'filter_sub_topic' => true
			);

			$data['faqs'][] = array(
				'faq_id'      => $faq['faq_id'],
				'title'       => $faq['title'],
				'children'    => $children_data,
				'href'        => $this->url->link('information/faq', 'topic=' . $faq['faq_id'])
			);
		}

		if ($data['faqs']) {
			return $this->load->view('module/faq', $data);
		}
  	}
}