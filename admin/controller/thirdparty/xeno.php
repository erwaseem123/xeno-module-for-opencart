<?php 

class ControllerThirdpartyXeno extends Controller { 

	private $error = array(); 



	public function index() { 

		$this->language->load('thirdparty/xeno');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('setting/setting');



		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('xeno', $this->request->post);



			$this->session->data['success'] = $this->language->get('text_success');



			$this->redirect($this->url->link('extension/thirdparty', 'token=' . $this->session->data['token'], 'SSL'));

		}



		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['entry_apikey'] 	= $this->language->get('entry_apikey');
		$this->data['entry_baseurl'] 	= $this->language->get('entry_baseurl');



		if (isset($this->error['warning'])) {

			$this->data['error_warning'] = $this->error['warning'];

		} else {

			$this->data['error_warning'] = '';

		}


		if (isset($this->error['xeno_baseurl'])) {

			$this->data['error_xeno_baseurl'] = $this->error['xeno_baseurl'];

		} else {

			$this->data['error_xeno_baseurl'] = '';

		}

		if (isset($this->error['xeno_apikey'])) {

			$this->data['error_xeno_apikey'] = $this->error['xeno_apikey'];

		} else {

			$this->data['error_xeno_apikey'] = '';

		}



		$this->data['breadcrumbs'] = array();



		$this->data['breadcrumbs'][] = array(

			'text'      => $this->language->get('text_home'),

			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),

			'separator' => false

		);



		$this->data['breadcrumbs'][] = array(

			'text'      => $this->language->get('text_thirdparty'),

			'href'      => $this->url->link('extension/thirdparty', 'token=' . $this->session->data['token'], 'SSL'),      		

			'separator' => ' :: '

		);



		$this->data['breadcrumbs'][] = array(

			'text'      => $this->language->get('heading_title'),

			'href'      => $this->url->link('thirdparty/xeno', 'token=' . $this->session->data['token'], 'SSL'),

			'separator' => ' :: '

		);



		$this->data['action'] = $this->url->link('thirdparty/xeno', 'token=' . $this->session->data['token'], 'SSL');



		$this->data['cancel'] = $this->url->link('extension/thirdparty', 'token=' . $this->session->data['token'], 'SSL');



		if (isset($this->request->post['xeno_status'])) {

			$this->data['xeno_status'] = $this->request->post['xeno_status'];

		} else {

			$this->data['xeno_status'] = $this->config->get('xeno_status');

		}

		if (isset($this->request->post['xeno_baseurl'])) {

			$this->data['xeno_baseurl'] = $this->request->post['xeno_baseurl'];

		} else {

			$this->data['xeno_baseurl'] = $this->config->get('xeno_baseurl');

		}

		if (isset($this->request->post['xeno_apikey'])) {

			$this->data['xeno_apikey'] = $this->request->post['xeno_apikey'];

		} else {

			$this->data['xeno_apikey'] = $this->config->get('xeno_apikey');

		}



		if (isset($this->request->post['xeno_sort_order'])) {

			$this->data['xeno_sort_order'] = $this->request->post['xeno_sort_order'];

		} else {

			$this->data['xeno_sort_order'] = $this->config->get('xeno_sort_order');

		}



		$this->template = 'thirdparty/xeno.tpl';

		$this->children = array(

			'common/header',

			'common/footer'

		);



		$this->response->setOutput($this->render());

	}



	protected function validate() {

		if (!$this->user->hasPermission('modify', 'thirdparty/xeno')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}

		if ((utf8_strlen($this->request->post['xeno_apikey']) < 1) || (utf8_strlen($this->request->post['xeno_apikey']) > 250) || trim($this->request->post['xeno_apikey']) == "") {

			$this->error['xeno_apikey'] = $this->language->get('error_xeno_apikey');

		}

		if ((utf8_strlen($this->request->post['xeno_baseurl']) < 1) || (utf8_strlen($this->request->post['xeno_baseurl']) > 250) || trim($this->request->post['xeno_baseurl']) == "") {

			$this->error['xeno_baseurl'] = $this->language->get('error_xeno_baseurl');

		}



		if (!$this->error) {

			return true;

		} else {

			return false;

		}	

	}

}

?>