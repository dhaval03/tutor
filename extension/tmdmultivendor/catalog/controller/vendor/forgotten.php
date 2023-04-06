<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class forgotten extends \Opencart\System\Engine\Controller {

	public function index() {
		if ($this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true));
		}

		$this->load->language('extension/tmdmultivendor/vendor/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_forgotten'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/forgotten', '', true)
		);

		

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/forgotten|save', '', true);

		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/login', '', true);

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');



		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/forgotten', $data));
	}

	

    public function save(): void {

    	$this->load->language('extension/tmdmultivendor/vendor/forgotten');
    	$this->load->model('extension/tmdmultivendor/vendor/vendor');


		$json = [];
	

		if (!isset($this->request->post['email'])) {
			$json['error']['warning'] = $this->language->get('error_email');

		} elseif (!$this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($this->request->post['email'])) {
			$json['error']['warning'] = $this->language->get('error_email');
		}
		
		// Check if customer has been approved.
		$vender_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($this->request->post['email']);
		if ($vender_info && !$vender_info['status']) {
			$json['error']['warning'] = $this->language->get('error_approved');
		}


		if (!$json) {

			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			$code = token(40);

			$this->model_extension_tmdmultivendor_vendor_vendor->editPasswordemail($this->request->post['email'], $code);


            $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message  = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
			/* New Code 23-07-2019 */
			$message .=$this->language->get('text_newpassword').":".$code."\n\n";
			$message .= $this->language->get('text_change') . "\n\n";
			/* New Code 23-07-2019 */
			$message .= $this->url->link('extension/tmdmultivendor/vendor/changepassword') . "\n\n";
			/* New Code 23-07-2019 */
			$message .= sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR']) . "\n\n";
			
			// $mail = new Mail($this->config->get('config_mail_engine'));
			// $mail->parameter = $this->config->get('config_mail_parameter');
			// $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			// $mail->smtp_username = $this->config->get('config_mail_smtp_username');
			// $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			// $mail->smtp_port = $this->config->get('config_mail_smtp_port');
			// $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			// $mail->setTo($this->request->post['email']);
			// $mail->setFrom($this->config->get('config_email'));
			// $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			// $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			// $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			// $mail->send();

		    $json['success'] = $this->language->get('text_success');
	
			 $json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language'), true);
		}
            $this->response->addHeader('Content-Type: application/json');
		    $this->response->setOutput(json_encode($json));
			
		} 

	

}
