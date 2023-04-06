<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Login extends \Opencart\System\Engine\Controller {
	public function index(): void {

		$this->load->language('extension/tmdmultivendor/vendor/login');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language'))
		];

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} elseif (isset($this->request->get['redirect'])) {
			$data['redirect'] = urldecode($this->request->get['redirect']);
		} else {
			$data['redirect'] = '';
		}

		$this->session->data['login_token'] = substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26);

		$data['login'] = $this->url->link('extension/tmdmultivendor/vendor/login|login', 'language=' . $this->config->get('config_language') . '&login_token=' . $this->session->data['login_token']);

		$data['register'] = $this->url->link('extension/tmdmultivendor/vendor/vendor', 'language=' . $this->config->get('config_language'));
		
		$data['forgotten'] = $this->url->link('extension/tmdmultivendor/vendor/forgotten', 'language=' . $this->config->get('config_language'));

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/login', $data));
	}

	public function login(): void {
		$this->load->language('extension/tmdmultivendor/vendor/login');

		$json = [];

		if (!isset($this->request->get['login_token']) || !isset($this->session->data['login_token']) || ($this->request->get['login_token'] != $this->session->data['login_token'])) {
			$json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language'), true);
		}

		if ($this->vendor->isLogged()) {
			$json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/dashboard', 'language=' . $this->config->get('config_language'), true);
		}

		if (!$json) {
			$keys = [
				'email',
				'password',
				'redirect'
			];

			foreach ($keys as $key) {
				if (!isset($this->request->post[$key])) {
					$this->request->post[$key] = '';
				}
			}

			// Check how many login attempts have been made.
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			// $login_info = $this->model_extension_tmdmultivendor_vendor_vendor->getLoginAttempts($this->request->post['email']);

			// if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			// 	$json['error']['warning'] = $this->language->get('error_attempts');
			// }

			// Check if vendor has been approved.
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($this->request->post['email']);

			if ($vendor_info && !$vendor_info['status']) {
				$json['error']['warning'] = $this->language->get('error_approved');
			} elseif (!$this->vendor->login($this->request->post['email'], html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8'))) {
				$json['error']['warning'] = $this->language->get('error_login');

				// $this->model_extension_tmdmultivendor_vendor_vendor->addLoginAttempt($this->request->post['email']);
			}
		}

		if (!$json) {
			// Add vendor details into session
			$this->session->data['vendor'] = [
				'vendor_id'       => $vendor_info['vendor_id'],
				// 'vendor_group_id' => $vendor_info['vendor_group_id'],
				'firstname'         => $vendor_info['firstname'],
				'lastname'          => $vendor_info['lastname'],
				'email'             => $vendor_info['email'],
				'telephone'         => $vendor_info['telephone'],
				// 'custom_field'      => $vendor_info['custom_field']
			];

			// Default address
			// $this->load->model('extension/tmdmultivendor/vendor/address');

			// $address_info = $this->model_extension_tmdmultivendor_vendor_address->getAddress($this->vendor->getAddressId());

			// if ($address_info) {
			// 	$this->session->data['shipping_address'] = $address_info;
			// }

			// Wishlist
			// if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
			// 	$this->load->model('extension/tmdmultivendor/vendor/wishlist');

			// 	foreach ($this->session->data['wishlist'] as $key => $product_id) {
			// 		// $this->model_extension_tmdmultivendor_vendor_wishlist->addWishlist($product_id);

			// 		unset($this->session->data['wishlist'][$key]);
			// 	}
			// }

			// Log the IP info
			// $this->model_extension_tmdmultivendor_vendor_vendor->addLogin($this->vendor->getId(), $this->request->server['REMOTE_ADDR']);

			// Create vendor token
			// $this->session->data['customer_token'] = token(26);

			// $this->model_extension_tmdmultivendor_vendor_vendor->deleteLoginAttempts($this->request->post['email']);

			// // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false)) {
				$json['redirect'] = str_replace('&amp;', '&', $this->request->post['redirect']);
			} else {
				$json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/dashboard', 'language=' . $this->config->get('config_language'));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function token(): void {
		$this->load->language('extension/tmdmultivendor/vendor/login');

		if (isset($this->request->get['email'])) {
			$email = $this->request->get['email'];
		} else {
			$email = '';
		}

		if (isset($this->request->get['login_token'])) {
			$token = $this->request->get['login_token'];
		} else {
			$token = '';
		}

		// Login override for admin users
		$this->vendor->logout();
		$this->cart->clear();

		unset($this->session->data['order_id']);
		unset($this->session->data['payment_address']);
		unset($this->session->data['payment_method']);
		unset($this->session->data['payment_methods']);
		unset($this->session->data['shipping_address']);
		unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['comment']);
		unset($this->session->data['coupon']);
		unset($this->session->data['reward']);
		unset($this->session->data['voucher']);
		unset($this->session->data['vouchers']);
		// unset($this->session->data['customer_token']);

		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($email);

		if ($vendor_info && $vendor_info['token'] && $vendor_info['token'] == $token && $this->vendor->login($vendor_info['email'], '', true)) {
			// Default Addresses
			$this->load->model('extension/tmdmultivendor/vendor/address');

			$address_info = $this->model_extension_tmdmultivendor_vendor_address->getAddress($vendor_info['address_id']);

			if ($this->config->get('config_tax_vendor') && $address_info) {
				$this->session->data[$this->config->get('config_tax_vendor') . '_address'] = $address_info;
			}

			$this->model_extension_tmdmultivendor_vendor_vendor->editToken($email, '');

			// Create vendor token
			 $this->session->data['customer_token'] = token(26);

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/dashboard', 'language=' . $this->config->get('config_language')));
		} else {
			$this->session->data['error'] = $this->language->get('error_login');

			$this->model_extension_tmdmultivendor_vendor_vendor->editToken($email, '');

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language')));
		}
	}
}
