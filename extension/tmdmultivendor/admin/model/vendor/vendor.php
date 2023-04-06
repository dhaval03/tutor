<?php
namespace Opencart\Admin\Model\Extension\Tmdmultivendor\Vendor;
class Vendor extends \Opencart\System\Engine\Model {
	public function install() {
	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."multivendor` (
	  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
	  `firstname` text NOT NULL,
	  `lastname` text NOT NULL,
	  `display_name` text NOT NULL,
	  `email` text NOT NULL,
	  `image` varchar(200) NOT NULL,
	  `telephone` varchar(12) NOT NULL,
	  `salt` varchar(50) NOT NULL,
	  `password` varchar(100) NOT NULL,
	  `fax` varchar(255) NOT NULL,
	  `about` text NOT NULL,
	  `company` text NOT NULL,
	  `postcode` varchar(20) NOT NULL,
	  `address_1` text NOT NULL,
	  `address_2` text NOT NULL,
	  `country_id` int(100) NOT NULL,
	  `zone_id` int(100) NOT NULL,
	  `city` text NOT NULL,
	  `map_url` text NOT NULL,
	  `facebook_url` text NOT NULL,
	  `google_url` text NOT NULL,
	  `whatsapp_url` text NOT NULL,
	  `instagram_url` text NOT NULL,
	  `twitter_url` text NOT NULL,
	  `snapchat_url` text NOT NULL,
	  `pinterest_url` text NOT NULL,
	  `youtube_url` text NOT NULL,
	  `linkedin_url` text NOT NULL,
	  `tiktok_url` text NOT NULL,
	  `status` int(10) NOT NULL,
	  `product_status` int(11) NOT NULL,
	  `approved` int(10) NOT NULL,
	  `language_id` int(10) NOT NULL,
	  `payment_method` text NOT NULL,
	  `paypal` text NOT NULL,
	  `bank_name` text NOT NULL,
	  `bank_branch_number` text NOT NULL,
	  `bank_swift_code` varchar(100) NOT NULL,
	  `bank_account_name` text NOT NULL,
	  `bank_account_number` varchar(50) NOT NULL,
	  `store_about` text NOT NULL,
	  `bank_detail` text NOT NULL,
	  `tax_number` varchar(100) NOT NULL,
	  `shipping_charge` varchar(100) NOT NULL,
	  `logo` varchar(200) NOT NULL,
	  `banner` varchar(200) NOT NULL,
	  `store_logowidth` varchar(255) NOT NULL,
	  `store_logoheight` varchar(255) NOT NULL,
	  `store_bannerwidth` varchar(255) NOT NULL,
	  `store_bannerheight` varchar(255) NOT NULL,
	  `commission` varchar(100) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`vendor_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendorproduct_wishlist` (
	  `wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
	  `vendor_id` int(11) NOT NULL,
	  `product_id` int(111) NOT NULL,
	  `date_added` datetime NOT NULL,
	  PRIMARY KEY (`wishlist_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_amount_pay` (
	  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
	  `vendor_id` int(11) NOT NULL,
	  `amount` decimal(15,4) NOT NULL,
	  `comment` varchar(250) NOT NULL,
	  `payment_method` text NOT NULL,
	  `date_added` date NOT NULL,
	   PRIMARY KEY (`pay_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_commission` (
	  `commission_id` int(11) NOT NULL AUTO_INCREMENT,
	  `category_id` int(111) NOT NULL,
	  `percentage` int(11) NOT NULL,
	  `fixed` int(11) NOT NULL,
	  `date_added` datetime NOT NULL,
	  `date_modified` datetime NOT NULL,
	  PRIMARY KEY (`commission_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_description` (
	  `vendor_id` int(11) NOT NULL,
	  `language_id` int(11) NOT NULL,
	  `name` varchar(500) NOT NULL,
	  `description` text NOT NULL,
	  `shipping_policy` text NOT NULL,
	  `return_policy` text NOT NULL,
	  `meta_description` text NOT NULL,
	  `meta_keyword` text NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_follow` (
	  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
	  `vendor_id` int(250) NOT NULL,
	  `customer_id` int(250) NOT NULL,
	  `date_added` date NOT NULL,
	  PRIMARY KEY (`follow_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_mail` (
	  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
	  `sellertype` text NOT NULL,
	  `status` int(11) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`mail_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_mail_language` (
	  `mail_id` int(11) NOT NULL,
	  `language_id` int(11) NOT NULL,
	  `name` text NOT NULL,
	  `subject` text NOT NULL,
	  `message` text NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_notification` (
	  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
	  `type` text NOT NULL,
	  `date` varchar(200) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`notification_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_notification_customer` (
	  `notification_id` int(11) NOT NULL,
	  `customer_id` int(100) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_notification_message` (
	  `notification_id` int(11) NOT NULL,
	  `language_id` int(11) NOT NULL,
	  `message` text NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_notification_seller` (
	  `notification_id` int(11) NOT NULL,
	  `vendor_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_order_product` (
	  `order_product_id` int(11) NOT NULL,
	  `vendor_id` int(11) NOT NULL,
	  `order_id` int(11) NOT NULL,
	  `product_id` int(11) NOT NULL,
	  `tmdshippingcost` varchar(255) NOT NULL,
	  `name` varchar(200) NOT NULL,
	  `model` varchar(200) NOT NULL,
	  `quantity` int(4) NOT NULL,
	  `price` decimal(15,4) NOT NULL,
	  `total` decimal(15,4) NOT NULL,
	  `tax` decimal(15,4) NOT NULL,
	  `reward` int(8) NOT NULL,
	  `commissionper` int(11) NOT NULL,
	  `commissionfix` int(11) NOT NULL,
	  `totalcommission` FLOAT(15,4) NOT NULL,
	  `order_status_id` int(11) NOT NULL,
	  `tracking` varchar(200) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_review` (
	  `review_id` int(11) NOT NULL AUTO_INCREMENT,
	  `customer_id` int(11) NOT NULL,
	  `vendor_id` int(11) NOT NULL,
	  `text` text NOT NULL,
	  `status` int(11) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`review_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_review_field` (
	  `rf_id` int(11) NOT NULL AUTO_INCREMENT,
	  `sort_order` int(10) NOT NULL,
	  `status` int(11) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`rf_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_review_field_description` (
	  `rf_id` int(11) NOT NULL,
	  `language_id` int(11) NOT NULL,
	  `field_name` varchar(200) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_review_field_submit` (
	  `fs_id` int(11) NOT NULL AUTO_INCREMENT,
	  `review_id` int(11) NOT NULL,
	  `vendor_id` int(11) NOT NULL,
	  `customer_id` int(11) NOT NULL,
	  `rf_id` int(11) NOT NULL,
	  `value` varchar(200) NOT NULL,
	  PRIMARY KEY (`fs_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_attribute` (
	  `vendor_id` int(11) NOT NULL,
	  `attribute_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_attribute_group` (
	  `vendor_id` int(11) NOT NULL,
	  `attribute_group_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_download` (
	  `vendor_id` int(11) NOT NULL,
	  `download_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_filter` (
	  `vendor_id` int(11) NOT NULL,
	  `filter_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_information` (
	  `vendor_id` int(11) NOT NULL,
	  `information_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_manufacturer` (
	  `vendor_id` int(11) NOT NULL,
	  `manufacturer_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_option` (
	  `vendor_id` int(11) NOT NULL,
	  `option_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_order_product` (
	  `vendor_id` int(11) NOT NULL,
	  `order_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_product` (
	  `vendor_id` int(11) NOT NULL,
	  `product_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_recurring` (
	  `vendor_id` int(11) NOT NULL,
	  `recurring_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_to_review` (
	  `vendor_id` int(11) NOT NULL,
	  `review_id` int(11) NOT NULL
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_inquiry` (
	  `inquiry_id` int(11) NOT NULL AUTO_INCREMENT,
	  `product_id` int(11) NOT NULL,
	  `vendor_id` int(11) NOT NULL,
	  `customer_id` int(11) NOT NULL,
	  `name` varchar(200) NOT NULL,
	  `email` varchar(200) NOT NULL,
	  `description` text NOT NULL,
	  `telephone` varchar(11) NOT NULL,
	  `status` int(11) NOT NULL,
	  `date_added` date NOT NULL,
	  `date_modified` date NOT NULL,
	  PRIMARY KEY (`inquiry_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."shipping` (
	  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
	  `vendor_id` int(11) NOT NULL,
	  `country_id` int(11) NOT NULL,
	  `zip_from` varchar(255) NOT NULL,  
	  `weight_from` decimal(10,2) NOT NULL,
	  `weight_to` decimal(10,2) NOT NULL,
	  `price` int(11) NOT NULL,
	  `date_added` date NOT NULL,
	   PRIMARY KEY (`shipping_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_chatsystem` (
	 `message_id` int(11) NOT NULL AUTO_INCREMENT,
	  `vendor_id` int(11) NOT NULL,
	  `chatstatus` int(11) NOT NULL,
	  `message` varchar(255) NOT NULL,
	  PRIMARY KEY (`message_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."order_vendorhistory` (
	   `order_vendorhistory_id` int(11) NOT NULL AUTO_INCREMENT,
	   `order_id` int(11) NOT NULL,
	   `order_status_id` int(11) NOT NULL,
	   `vendor_id` int(11) NOT NULL DEFAULT '0',
	   `order_product_id` int(11) NOT NULL,
	   `comment` text NOT NULL,
	   `updateby` varchar(255) NOT NULL,
	   `date_added` datetime NOT NULL,
	  PRIMARY KEY (`order_vendorhistory_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."commissionrange` (
	   `commissionrange_id` int(11) NOT NULL AUTO_INCREMENT,
	   `category_id` int(11) NOT NULL,
	   `totalstart` int(11) NOT NULL,
	   `totalend` int(11) NOT NULL DEFAULT '0',
	   `commision` decimal(10,5) NOT NULL, 
	   `date_added` datetime NOT NULL,
	   `date_modified` datetime NOT NULL,
	  PRIMARY KEY (`commissionrange_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
	
	}
	public function uninstall() {
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mutivendor`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendorproduct_wishlist`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_amount_pay`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_commission`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_description`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_follow`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_mail`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_mail_language`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_notification`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_notification_customer`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_notification_message`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_notification_seller`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_order_product`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_review`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_review_field`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_review_field_description`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_review_field_submit`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_attribute`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_attribute_group`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_download`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_filter`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_information`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_manufacturer`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_option`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_order_product`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_product`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_recurring`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_to_review`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_inquiry`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."shipping`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_chatsystem`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."order_vendorhistory`");
	$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."commissionrange`");
	}
	
	public function addVendor($data) {
		/* 05 02 2021 Add  bank_detail */
		$this->db->query("INSERT INTO " . DB_PREFIX . "multivendorvendor set display_name='".$this->db->escape($data['display_name'])."',firstname='".$this->db->escape($data['firstname'])."',lastname='".$this->db->escape($data['lastname'])."',email='".$this->db->escape($data['email'])."',image='".$this->db->escape($data['image'])."',telephone='".$this->db->escape($data['telephone'])."',fax='".$this->db->escape($data['fax'])."',about='".$this->db->escape($data['about'])."',company='".$this->db->escape($data['company'])."',address_1='".$this->db->escape($data['address_1'])."',address_2='".$this->db->escape($data['address_2'])."',status='".(int)$data['status']."',product_status='".(int)$data['product_status']."',city='".$this->db->escape($data['city'])."',postcode='".$this->db->escape($data['postcode'])."',country_id='".$this->db->escape($data['country_id'])."',zone_id='".$this->db->escape($data['zone_id'])."',`password` = '" . $this->db->escape(password_hash(html_entity_decode($data['password'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT)) . "',logo='".$data['logo']."',store_about='".$this->db->escape($data['store_about'])."',bank_detail='".$this->db->escape($data['bank_detail'])."',banner='".$data['banner']."',payment_method='".$this->db->escape($data['payment_method'])."',paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "',tax_number='".$this->db->escape($data['tax_number'])."',shipping_charge='".$this->db->escape($data['shipping_charge'])."',commission='".$this->db->escape($data['commission'])."', facebook_url = '" . $this->db->escape($data['facebook_url']) . "', google_url = '" . $this->db->escape($data['google_url']) . "',  whatsapp_url = '" . $this->db->escape($data['whatsapp_url']) . "', instagram_url = '" . $this->db->escape($data['instagram_url']) . "', twitter_url = '" . $this->db->escape($data['twitter_url']) . "', snapchat_url = '" . $this->db->escape($data['snapchat_url']) . "', pinterest_url = '" . $this->db->escape($data['pinterest_url']) . "',  youtube_url = '" . $this->db->escape($data['youtube_url']) . "', linkedin_url = '" . $this->db->escape($data['linkedin_url']) . "', tiktok_url = '" . $this->db->escape($data['tiktok_url']) . "',date_added=now()");
				
		$vendor_id = $this->db->getLastId();

		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE vendor_id = '" . (int)$vendor_id . "'");
		}
		
		// SEO URL
		if (isset($data['vendor_seo_url'])) {
			foreach ($data['vendor_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'product_id', `value` = '" . (int)$product_id . "', `keyword` = '" . $this->db->escape($keyword) . "'");
				}
			}
		}
			
		if (isset($data['store_description'])) {
			foreach ($data['store_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_description SET vendor_id='".(int)$vendor_id."',language_id = '" . (int)$language_id ."',name='".$this->db->escape($value['name'])."',description='".$this->db->escape($value['description'])."',meta_description='".$this->db->escape($value['meta_description'])."',meta_keyword='".$this->db->escape($value['meta_keyword'])."',shipping_policy='".$this->db->escape($value['shipping_policy'])."',return_policy='".$this->db->escape($value['return_policy'])."'"); 
			}
		}

	
		if (isset($data['chatstatus'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_chatsystem set message = '" . $this->db->escape($data['message']) . "',vendor_id='".(int)$vendor_id."',chatstatus='".$data['chatstatus']."'");
		}

		$this->cache->delete('vendor');

		return $vendor_id;
	}

	public function editVendor($vendor_id, $data) {
		/* 05 02 2021 Add  bank_detail */
		$this->db->query("UPDATE " . DB_PREFIX . "multivendor set display_name='".$this->db->escape($data['display_name'])."', email='".$this->db->escape($data['email'])."',firstname='".$this->db->escape($data['firstname'])."',lastname='".$this->db->escape($data['lastname'])."',image='".$this->db->escape($data['image'])."',postcode='".$this->db->escape($data['postcode'])."',telephone='".$this->db->escape($data['telephone'])."',fax='".$this->db->escape($data['fax'])."',about='".$this->db->escape($data['about'])."',company='".$this->db->escape($data['company'])."',address_1='".$this->db->escape($data['address_1'])."',address_2='".$this->db->escape($data['address_2'])."',status='".(int)$data['status']."',product_status='".(int)$data['product_status']."',city='".$this->db->escape($data['city'])."',country_id='".$this->db->escape($data['country_id'])."',zone_id='".$this->db->escape($data['zone_id'])."',logo='".$data['logo']."',store_about='".$this->db->escape($data['store_about'])."', bank_detail='".$this->db->escape($data['bank_detail'])."',banner='".$data['banner']."',payment_method='".$this->db->escape($data['payment_method'])."',paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "',tax_number='".$this->db->escape($data['tax_number'])."',shipping_charge='".$this->db->escape($data['shipping_charge'])."',commission='".$this->db->escape($data['commission'])."',facebook_url = '" . $this->db->escape($data['facebook_url']) . "',google_url = '" . $this->db->escape($data['google_url']) . "', whatsapp_url = '" . $this->db->escape($data['whatsapp_url']) . "', instagram_url = '" . $this->db->escape($data['instagram_url']) . "', twitter_url = '" . $this->db->escape($data['twitter_url']) . "', snapchat_url = '" . $this->db->escape($data['snapchat_url']) . "', pinterest_url = '" . $this->db->escape($data['pinterest_url']) . "',  youtube_url = '" . $this->db->escape($data['youtube_url']) . "', linkedin_url = '" . $this->db->escape($data['linkedin_url']) . "', tiktok_url = '" . $this->db->escape($data['tiktok_url']) . "', map_url = '" . $this->db->escape($data['map_url']) . "',	date_modified=now() where vendor_id='".(int)$vendor_id."'");

		
		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE vendor_id = '" . (int)$vendor_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_description WHERE vendor_id = '" . (int)$vendor_id . "'");
		
		if (isset($data['store_description'])) {
			foreach ($data['store_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_description SET vendor_id='".(int)$vendor_id."',language_id = '" . (int)$language_id ."',name='".$this->db->escape($value['name'])."',description='".$this->db->escape($value['description'])."',meta_description='".$this->db->escape($value['meta_description'])."',meta_keyword='".$this->db->escape($value['meta_keyword'])."',shipping_policy='".$this->db->escape($value['shipping_policy'])."',return_policy='".$this->db->escape($value['return_policy'])."'"); 
			}
		}
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'vendor_id' AND `value` = '" . (int)$vendor_id . "'");
		if (isset($data['vendor_seo_url'])) {
			foreach ($data['vendor_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'vendor_id', `value` = '" . (int)$vendor_id . "', `keyword` = '" . $this->db->escape($keyword) . "'");
				}
			}
		}	

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_chatsystem WHERE vendor_id = '" . (int)$vendor_id . "'");
		
		if (isset($data['chatstatus'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_chatsystem set message = '" . $this->db->escape($data['message']) . "',vendor_id='".(int)$vendor_id."',chatstatus='".$data['chatstatus']."'");
		}
	
		$this->cache->delete('vendor');
	}

	public function approve($vendor_id){
		
		$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET approved = '1' WHERE vendor_id = '" . (int)$vendor_id . "'");
		
     
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_to_product WHERE vendor_id='".(int)$vendor_id."'");
		foreach ($query->rows as $result) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '1' WHERE product_id = '" . (int)$result['product_id'] . "'");
	 	}
		
		/// Seller Approve To Mail ///
		
		$this->load->model('extension/tmdmultivendor/vendor/mail');
		$sellertype = 'seller_approve_mail';
		
		$mailinfo = $this->model_extension_tmdmultivendor_vendor_mail->getMailInfo($sellertype);
		$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);
		
		/*Status Enabled*/
		if(isset($mailinfo['sellertype'])){
			$find = array(
				'{vendorname}',										
				'{emails}',										
				'{loginlink}'										
			);
			
			if(isset($seller_info['display_name'])) {
				$dname = $seller_info['display_name'];
			} else {
				$dname='';
			}
			
			if(isset($seller_info['email'])) {
				$emails = $seller_info['email'];
			} else {
				$emails='';
			}
			
			$replace = array(
				'vendorname'=> $dname,
				'emails'	=> $emails,
				'loginlink' => HTTP_CATALOG.'index.php?route=extension/tmdmultivendor/vendor/login' . "\n\n"
			);
			

			$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $mailinfo['subject']))));

			$message = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $mailinfo['message']))));
			
			// $mail = new Mail($this->config->get('config_mail_engine'));
			// $mail->parameter = $this->config->get('config_mail_parameter');
			// $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			// $mail->smtp_username = $this->config->get('config_mail_smtp_username');
			// $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			// $mail->smtp_port = $this->config->get('config_mail_smtp_port');
			// $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			// $mail->setTo($emails);
			// $mail->setFrom($this->config->get('config_email'));
			// $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			// $mail->setSubject($subject);
			// $mail->setHtml(html_entity_decode($message));
			// $mail->send();
					
		}
	}
	public function Disapprove($vendor_id){
		
		$this->db->query("UPDATE " . DB_PREFIX . "multivendor SET approved = '0' WHERE vendor_id = '" . (int)$vendor_id . "'");
		
      
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_to_product WHERE vendor_id='".(int)$vendor_id."'");
		foreach ($query->rows as $result) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0' WHERE product_id = '" . (int)$result['product_id'] . "'");
	 	}
		
		/// Seller Approve To Mail ///
		
		$this->load->model('extension/tmdmultivendor/vendor/mail');
		$sellertype = 'seller_disapprove_mail';
		
		$mailinfo = $this->model_extension_tmdmultivendor_vendor_mail->getMailInfo($sellertype);
		$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);
		
		/*Status Enabled*/
		if(isset($mailinfo['sellertype'])){
			$find = array(			
				'{vendorname}',					
				'{email}',											
				'{loginlink}'										
			);
			
			if(isset($seller_info['displa_name'])) {
				$disname = $seller_info['display_name'];
			} else {
				$disname='';
			}
			
			if(isset($seller_info['email'])) {
				$email = $seller_info['email'];
			} else {
				$email='';
			}
			
			$replace = array(
				'vendorname'		=> $disname,
				'email'	=> $email,
				'loginlink' => HTTP_CATALOG.'index.php?route=extension/tmdmultivendor/vendor/login' . "\n\n"
			);
			
			if(!empty($mailinfo['message'])){
				$messages = $mailinfo['message'];
			} else {
				$messages='';
			}
			
			$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $mailinfo['subject']))));

			$message = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $messages))));
			
			// $mail = new Mail($this->config->get('config_mail_engine'));
			// $mail->parameter = $this->config->get('config_mail_parameter');
			// $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			// $mail->smtp_username = $this->config->get('config_mail_smtp_username');
			// $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			// $mail->smtp_port = $this->config->get('config_mail_smtp_port');
			// $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			// $mail->setTo($email);
			// $mail->setFrom($this->config->get('config_email'));
			// $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			// $mail->setSubject($subject);
			// $mail->setHtml(html_entity_decode($message));
			// $mail->send();
					
		}
	}
	
	public function deleteVendor($vendor_id) {
		$this->getVendoproductdelete($vendor_id);
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "multivendor WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_description WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_chatsystem WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_order_product WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_review WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_inquiry WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "shipping WHERE vendor_id = '" . (int)$vendor_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'vendor_id' AND `value` = '" . (int)$vendor_id . "'");
	}
    
    public function getVendoproductdelete($vendor_id) {
		$delproduct_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_to_product WHERE vendor_id='".(int)$vendor_id."'");
		foreach ($query->rows as $result) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0' WHERE product_id = '" . (int)$result['product_id'] . "'");
	 	}
	}

	
	public function getVendor($vendor_id){
		
		$sql = "SELECT DISTINCT *,v.vendor_id as vendor_id, CONCAT(v.firstname, ' ', v.lastname) AS vname FROM " . DB_PREFIX . "multivendor v LEFT JOIN " . DB_PREFIX . "vendor_description vd ON (v.vendor_id = vd.vendor_id) WHERE v.vendor_id='".(int)$vendor_id."' AND vd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query=$this->db->query($sql);
		
		return $query->row;
	}

	
	public function getVendorStoreDescriptions($vendor_id) {
		$store_descriptio_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_description WHERE vendor_id = '" . (int)$vendor_id . "'");
		foreach ($query->rows as $result) {
			$store_descriptio_data[$result['language_id']] = array(
				'name'=> $result['name'],
				'meta_keyword'=> $result['meta_keyword'],
				'description'=> $result['description'],
				'meta_description'=> $result['meta_description'],
				'shipping_policy'=> $result['shipping_policy'],
				'return_policy'=> $result['return_policy'],
			);
	 	}
		return $store_descriptio_data;
	}

	public function getVendors($data) {
		/* 05 02 2020 update query*/
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS vendorname , (SELECT count(*) as total FROM  " . DB_PREFIX . "vendor_to_product where vendor_id=v.vendor_id) AS totalproduct FROM " . DB_PREFIX . "multivendor v where vendor_id<>0";
	
		if (!empty($data['filter_firstname'])){
		 	$sql .=" and CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_firstname'])."%'";
		}
		if (!empty($data['filter_name'])){
		 	$sql .=" and CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name'])."%'";
		}
		
		if (isset($data['filter_approved'])){
		 	$sql .=" and approved like '".$this->db->escape($data['filter_approved'])."%'";
		}
		
		/* 05 02 2020 */
		if (isset($data['filter_status'])){
		 	$sql .=" and status like '".$this->db->escape($data['filter_status'])."%'";
		}
		
		
		if (!empty($data['filter_date'])){
		 	$sql .=" and date_added like '".$this->db->escape($data['filter_date'])."%'";
		}
		
		$sort_data = array(
			/* 05 02 2020 */
			'vendorname',
			'date_added',
			'totalproduct',
			/* 05 02 2020 */
			'firstname',
			'lastname',
			'lastname',			
			'email'			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vendor_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalVendor($data) {
		$sql ="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "multivendor where vendor_id<>0";
		
		/* 05 02 2020 */
		if (!empty($data['filter_firstname'])){
			$sql .=" and CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_firstname'])."%'";
		}
		if (!empty($data['filter_name'])){
		 	$sql .=" and CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name'])."%'";
		}
		
		if (isset($data['filter_approved'])){
		 	$sql .=" and approved like '".$this->db->escape($data['filter_approved'])."%'";
		}
		
		/* 05 02 2020 */
		if (isset($data['filter_status'])){
		 	$sql .=" and status like '".$this->db->escape($data['filter_status'])."%'";
		}
		
		
		if (!empty($data['filter_date'])){
		 	$sql .=" and date_added like '".$this->db->escape($data['filter_date'])."%'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getVendorByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "multivendor WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");
		return $query->row;
	}
	
	
	public function getVendorSeoUrls(int $vendor_id): array {
		$vendor_seo_url_data = [];

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'vendor_id' AND `value` = '" . (int)$vendor_id . "'");

		foreach ($query->rows as $result) {
			$vendor_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $vendor_seo_url_data;
	}
	
	public function getmsg($vendor_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_chatsystem WHERE vendor_id='".(int)$vendor_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}	
	
	/* 03 10 2019 s */
	public function getVendorid($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_to_product WHERE product_id='".(int)$product_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	/* 03 10 2019 e */
	
	
	public function getVendorsStore($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_description where vendor_id<>0 AND language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY name";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	/* 11 02 2020 */
	
		public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}
	public function getProductOptionValue($product_id, $product_option_value_id) {
		$query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	
	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id)";
		
		if (!empty($data['filter_affiliate'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "customer_affiliate ca ON (c.customer_id = ca.customer_id)";
		}		
		
		$sql .= " WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$implode = array();

		if (!empty($data['filter_customer'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
		
	public function getVendorProducts($vendor_id) {
		$sql ="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendor_to_product WHERE vendor_id='".(int)$vendor_id."'";
		
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getVendorsStorename($vendor_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_description WHERE vendor_id='".(int)$vendor_id."' AND language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY name";
		
		$query = $this->db->query($sql);

		return $query->row;
	}
	
	public function getSeoUrls($value): array {
		$product_seo_url_data = [];

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");

		foreach ($query->rows as $result) {
			$product_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $product_seo_url_data;
	}
	
	public function saveSeoUrls($data,$value): void {
		$query = $this->db->query("delete FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");
	
		foreach ($data[$data['urlformat']] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'route', `value` = '" . $this->db->escape($value) . "', `keyword` = '" . $this->db->escape($keyword) . "',sort_order='-1'");
				}
			}
		
	}
}
