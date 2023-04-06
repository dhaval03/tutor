<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Module;
class Latestseller extends \Opencart\System\Engine\Controller {
	public function index(array $setting): string {

		$this->load->language('extension/tmdmultivendor/module/latest_seller');
		
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}
	
		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		
		$vendor_hidevnames =  $this->config->get('vendor_hidevendorname');

		$vendor_hidevemails =  $this->config->get('vendor_hidevemail');
		$vendor_hidevponenos =  $this->config->get('vendor_hidevponeno');
		$vendor_hidevsocialicons =  $this->config->get('vendor_hidevsocialicon');
		
		
		if(isset($vendor_hidevnames)){
			$data['vendor_hidevname'] = $vendor_hidevnames;
		} else {
			$data['vendor_hidevname'] = '';
		}
		
		if(isset($vendor_hidevemails)){
			$data['vendor_hidevemail'] = $vendor_hidevemails;
		} else {
			$data['vendor_hidevemail'] = '';
		}
		
		if(isset($vendor_hidevponenos)){
			$data['vendor_hidevponeno'] = $vendor_hidevponenos;
		} else {
			$data['vendor_hidevponeno'] = '';
		}
		
		if(isset($vendor_hidevsocialicons)){
			$data['vendor_hidevsocialicon'] = $vendor_hidevsocialicons;
		} else {
			$data['vendor_hidevsocialicon'] = '';
		}



		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['vendors'] = array();

		$filter_data = array(
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5,
			// 'limit' => $setting['limit']
		);
		
		$this->load->model('extension/tmdmultivendor/vendor/allseller');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$results = $this->model_extension_tmdmultivendor_vendor_vendor->getVendors($filter_data);
		if ($results) {
			foreach ($results as $result) {
				
				if (is_file(DIR_IMAGE . $result['banner'])) {
				$image = $this->model_tool_image->resize($result['banner'], 600, 200);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 600, 200);
				}
				
				if (is_file(DIR_IMAGE . $result['image'])) {
					$smallimage = $this->model_tool_image->resize($result['image'], 70, 70);
				} else {
					$smallimage = $this->model_tool_image->resize('no_image.png', 70, 70);
				}				
				
				$abouts = strlen($result['about']);
				
				if ($abouts > 150) {
					$about = substr(strip_tags(html_entity_decode($result['about'], ENT_QUOTES, 'UTF-8')), 0, 150) . '<a href='.$this->url->link('extension/tmdmultivendor/vendor/vendor_profile', 'vendor_id=' . $result['vendor_id']).'> <br/>Read More </a>';
				} else {
					$about =$result['about'];
				}
				
				$store_info = $this->model_extension_tmdmultivendor_vendor_allseller->getVendordescription($result['vendor_id']);
				if(isset($store_info['name'])){
					$storename = $store_info['name'];
				} else {
					$storename = '';
				}
				if(isset($result['vendor_id'])){
				$totalproduct = $this->model_extension_tmdmultivendor_vendor_allseller->getTotalProduct($result['vendor_id']);
				}
				
				$data['vendors'][] = array(
					'vendor_id'   => $result['vendor_id'],
					'thumb'       => $image,
					'smallthumb'  => $smallimage,
					'totalproduct'=> $totalproduct ,
					'firstname'   => $result['firstname'].' '.$result['lastname'],
					'email'   	  => $result['email'],
					'telephone'   => $result['telephone'],
					'facebookurl'   	  => $result['facebook_url'],
					'googleurl'   	  => $result['google_url'],
					/* Social icon */
					'whatsapp_url' => $result['whatsapp_url'],
					'instagram_url' => $result['instagram_url'],
					'twitter_url' => $result['twitter_url'],
					'snapchat_url' => $result['snapchat_url'],
					'pinterest_url' => $result['pinterest_url'],
					'youtube_url' => $result['youtube_url'],
					'linkedin_url' => $result['linkedin_url'],
					'tiktok_url' => $result['tiktok_url'],
					'vendorfindme' 		=> $this->url->link('extension/tmdmultivendor/vendor/findme','&vendor_id=' .$result['vendor_id']),					
					/* Social icon */
					'storename'   => $storename,
					'href'        => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $result['vendor_id'])
				);
			}

			$customer2vendor = $this->config->get('vendor_customer2vendor');

			if($customer2vendor==1){
			return $this->load->view('extension/tmdmultivendor/module/latest_seller', $data);
			}
		}
	}
}