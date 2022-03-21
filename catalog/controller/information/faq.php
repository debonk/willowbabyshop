<?php
/**
 * @package		FAQ - Frequently Asked Questions
 * @copyright	Copyright (C) 2016 Fido-X IT (John Simon). All rights reserved. (fido-x.net)
 * @license		GNU General Public License version 3; see http://www.gnu.org/licenses/gpl-3.0.en.html
 */

class ControllerInformationFaq extends Controller {
	public function index() {
		$this->load->language('information/faq');
		$this->load->model('fido/faq');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('information/faq'),
			'text' => $this->language->get('heading_title')
		);

		if (isset($this->request->get['topic'])) {
			$topic = '';

			$parts = explode('_', $this->request->get['topic']);

			$faq_id = (int)array_pop($parts);

			foreach ($parts as $topic_id) {
				if (!$topic) {
					$topic = (int)$topic_id;
				} else {
					$topic .= '_' . (int)$topic_id;
				}

				$topic_info = $this->model_fido_faq->getTopic($topic_id);

				if ($topic_info) {
					$data['breadcrumbs'][] = array(
						'text' => $topic_info['title'],
						'href' => $this->url->link('information/faq', 'topic=' . $topic)
					);
				}
			}
		} else {
			$faq_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');

		$topic_info = $this->model_fido_faq->getTopic($faq_id);

		if ($topic_info) {
	  		$this->document->setTitle($topic_info['title']);

			$this->document->setDescription($topic_info['meta_description']);

			$data['breadcrumbs'][] = array(
				'href' => $this->url->link('information/faq', 'topic=' . $faq_id),
				'text' => $topic_info['title']
			);

			$data['heading_title'] = $topic_info['title'];

			$data['description'] = html_entity_decode($topic_info['description']);

			$data['button_continue'] = $this->language->get('button_faq');

			$data['continue'] = $this->url->link('information/faq');

			$data['topics'] = array();

			$topic_total = $this->model_fido_faq->getTotalFaqsByTopicId($faq_id);

			$filter_data = array(
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);

			$results = $this->model_fido_faq->getTopics($faq_id, $filter_data);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_faq_id'    => $result['faq_id'],
					'filter_sub_topic' => true
				);

				$data['topics'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/faq', 'topic=' . $this->request->get['topic'] . '_' . $result['faq_id'])
				);
			}

			$pagination = new Pagination();
			$pagination->total = $topic_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/faq', 'topic=' . $this->request->get['topic'] . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($topic_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($topic_total - $limit)) ? $topic_total : ((($page - 1) * $limit) + $limit), $topic_total, ceil($topic_total / $limit));

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/faq', $data));
		} else {
			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['topics'] = array();

			$topic_total = $this->model_fido_faq->getTotalFaqsByTopicId(0);

			$filter_data = array(
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);

			$results = $this->model_fido_faq->getTopics(0, $filter_data);

			if ($results) {
				$data['description'] = $this->language->get('text_description');
			} else {
				$data['description'] = $this->language->get('text_no_faq');
			}

			foreach ($results as $result) {
				$filter_data = array(
					'filter_faq_id'    => $result['faq_id'],
					'filter_sub_topic' => true
				);

				$data['topics'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/faq', 'topic=' . $result['faq_id'])
				);
			}

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$pagination = new Pagination();
			$pagination->total = $topic_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/faq', 'page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($topic_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($topic_total - $limit)) ? $topic_total : ((($page - 1) * $limit) + $limit), $topic_total, ceil($topic_total / $limit));

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/faq', $data));
		}
	}
}