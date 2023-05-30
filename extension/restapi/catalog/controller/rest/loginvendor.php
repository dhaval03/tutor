<?php

/**
 * login.php
 *
 * Login management
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */
 
namespace Opencart\Catalog\Controller\Extension\RestApi\Rest;
require_once(DIR_SYSTEM . 'engine/restcontroller.php');

class Loginvendor extends \RestController
{

    const FACEBOOK_USER_INFORMATION_URL = 'https://graph.facebook.com/me?fields=email,name';
    const GOOGLE_USER_INFORMATION_URL = 'https://www.googleapis.com/userinfo/v2/me';

    public function loginvendor()
    {
		//echo"yesss";exit;

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();

            //$this->language->load('checkout/checkout');
			
			$this->load->language('extension/tmdmultivendor/vendor/vendor');
            if ($this->vendor->isLogged()) {
                $this->json['error'][] = "User is logged.";
                $this->statusCode = 400;
            } else {
				// Check how many login attempts have been made.
				$this->load->model('extension/tmdmultivendor/vendor/vendor');

				// $login_info = $this->model_extension_tmdmultivendor_vendor_vendor->getLoginAttempts($this->request->post['email']);

				// if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
				// 	$json['error']['warning'] = $this->language->get('error_attempts');
				// }

				// Check if vendor has been approved.
				$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($post['email']);

				if ($vendor_info && !$vendor_info['status']) {
					$this->json['error'][] = $this->language->get('error_approved');
				} elseif (!$this->vendor->login($post['email'], html_entity_decode($post['password'], ENT_QUOTES, 'UTF-8'))) {
					$this->json['error'][] = $this->language->get('error_login');

					// $this->model_extension_tmdmultivendor_vendor_vendor->addLoginAttempt($this->request->post['email']);
				}
				
				
               
            }

            if (empty($this->json['error'])) {

                unset($this->session->data['vendor']);
				$this->session->data['vendor'] = [
					'vendor_id'       => $vendor_info['vendor_id'],
					// 'vendor_group_id' => $vendor_info['vendor_group_id'],
					'firstname'         => $vendor_info['firstname'],
					'lastname'          => $vendor_info['lastname'],
					'email'             => $vendor_info['email'],
					'telephone'         => $vendor_info['telephone'],
					// 'custom_field'      => $vendor_info['custom_field']
				];

                

                unset($vendor_info['password']);
                

                
                $this->json['data'] = $vendor_info;
            }

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }
}