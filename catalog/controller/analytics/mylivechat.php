<?php
class ControllerAnalyticsMylivechat extends Controller {
    public function index() {
		return html_entity_decode($this->config->get('mylivechat_code'), ENT_QUOTES, 'UTF-8');
	}
}
