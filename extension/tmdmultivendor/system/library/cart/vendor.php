<?php
namespace Opencart\System\Library\Cart;
use \Opencart\System\Helper as Helper;
class Vendor {
	private $vendor_id;
	private $firstname;
	private $email;	
	private $address_1;

	public function __construct(\Opencart\System\Engine\Registry $registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		/* 07-02-2019 update  approved code*/
		if (isset($this->session->data['vendor_id'])) {
			$vendor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "multivendor WHERE vendor_id = '" . (int)$this->session->data['vendor_id'] . "' AND status = '1' AND approved = '1'");

			if ($vendor_query->num_rows) {
				$this->vendor_id = $vendor_query->row['vendor_id'];
				$this->firstname = $vendor_query->row['firstname'];
				$this->email = $vendor_query->row['email'];
				
				$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET language_id = '" . (int)$this->config->get('config_language_id') . "' WHERE vendor_id = '" . (int)$this->vendor_id . "'");
			} else {
				$this->logout();
			}
		}
	}
	
	public function login(string $email, string $password, bool $override = false): bool {
		$vendor_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "multivendor` WHERE LOWER(`email`) = '" . $this->db->escape(Helper\Utf8\strtolower($email)) . "' AND `status` = '1'");

		if ($vendor_query->row) {
			if (!$override) {
				if (password_verify($password, $vendor_query->row['password'])) {
					$rehash = password_needs_rehash($vendor_query->row['password'], PASSWORD_DEFAULT);
				} elseif (isset($vendor_query->row['salt']) && $vendor_query->row['password'] == sha1($vendor_query->row['salt'] . sha1($vendor_query->row['salt'] . sha1($password)))) {
					$rehash = true;
				} elseif ($vendor_query->row['password'] == md5($password)) {
					$rehash = true;
				} else {
					return false;
				}

				if ($rehash) {
					$this->db->query("UPDATE `" . DB_PREFIX . "multivendor` SET `password` = '" . $this->db->escape(password_hash($password, PASSWORD_DEFAULT)) . "' WHERE `vendor_id` = '" . (int)$vendor_query->row['vendor_id'] . "'");
				}
			}

			$this->session->data['vendor_id'] = $vendor_query->row['vendor_id'];

			$this->vendor_id = $vendor_query->row['vendor_id'];
			$this->firstname = $vendor_query->row['firstname'];
			$this->email = $vendor_query->row['email'];

			$this->db->query("UPDATE `" . DB_PREFIX . "multivendor` SET `language_id` = '" . (int)$this->config->get('config_language_id') . "' WHERE `vendor_id` = '" . (int)$this->vendor_id . "'");

			return true;
		} else {
			return false;
		}
	}

	/* public function login(string $email, string $password, bool $override = false): bool {
		if ($override) {
			$vendor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "multivendor WHERE LOWER(email) = '" . $this->db->escape(Helper\Utf8\strtolower($email)) . "' AND status = '1' AND approved = '1'");
		} else {
			$vendor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "multivendor WHERE LOWER(email) = '" . $this->db->escape(Helper\Utf8\strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($vendor_query->num_rows) {
			$this->session->data['vendor_id'] = $vendor_query->row['vendor_id'];

			$this->vendor_id = $vendor_query->row['vendor_id'];
			$this->firstname = $vendor_query->row['firstname'];
			$this->email = $vendor_query->row['email'];
			
			$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET language_id = '" . (int)$this->config->get('config_language_id') . "' WHERE vendor_id = '" . (int)$this->vendor_id . "'");

			return true;
		} else {
			return false;
		}
	} */

	public function logout(): void {
		unset($this->session->data['vendor_id']);

		$this->vendor_id = '';		
		$this->firstname = '';		
		$this->email = '';
	}

	public function isLogged(): bool {
		return $this->vendor_id ? true : false;
	}

	public function getId() {
		return $this->vendor_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}


	public function getEmail(): string {
		return $this->email;
	}

	public function getAddress1(): string {
		return $this->address_1;
	}
	
}
