<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
use \Opencart\System\Helper as Helper;
class vendorprofile extends \Opencart\System\Engine\Controller {

	public function index(): void {

		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true)
		];

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$this->load->model('extension/tmdmultivendor/vendor/vendor');

			$vendorproduct_id = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerChat($this->request->get['vendor_id']);

			if(!empty($vendorproduct_id['vendor_id'])){
			$vendor_ids = $vendorproduct_id['vendor_id'];
			} else {
			$vendor_ids = '';
			}

			$vendorchat_ids = $this->model_extension_tmdmultivendor_vendor_vendor->getChatid($vendor_ids);

			if(!empty($vendorchat_ids['message'])){
			$data['vendorchat_id'] = $vendorchat_ids['message'];
			} else {
			$data['vendorchat_id'] = '';
			}


      
		if (!$this->customer->isLogged()) {
			$data['text_loginplz'] 		= $this->language->get('text_loginplz');
				$this->session->data['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/vendor_profile','&vendor_id=' .$this->request->get['vendor_id']);
			} else {
				$data['text_loginplz'] 		='';
		}

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('tool/image');



		if($this->customer->getId()) {
			$customer_info = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomerlog($this->customer->getId());
		}

		if(!empty($customer_info['firstname'])){
			$data['customername'] = $customer_info['firstname']. ' ' .$customer_info['lastname'];
		} else {
			$data['customername'] = '';
		}

		if($this->customer->getId()){
			$data['customer_id'] = $this->customer->getId();
		} else {
			$data['customer_id'] = '';
		}

		if (isset($this->request->get['vendor_id'])) {
			$vendor_id = (int)$this->request->get['vendor_id'];
		} else {
			$vendor_id = 0;
		}
		
		if(isset($vendor_id)) {
			 $vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);
		}

		
		if ($vendor_info) {
		
		if(isset($vendor_info['display_name'])){
			$this->document->setTitle($vendor_info['display_name']);
		}
		

		if(!empty($vendor_info['facebook_url'])){
			$facebookurl = $vendor_info['facebook_url'];
		} else {
			$facebookurl = '';
		}	

		if(!empty($vendor_info['google_url'])){
			$googleurl = $vendor_info['google_url'];
		} else {
			$googleurl = '';
		}

		/* Social icon */
		
		if(!empty($vendor_info['whatsapp_url'])){
			$whatsapp_url = $vendor_info['whatsapp_url'];
		} else {
			$whatsapp_url = '';
		}
		
		if(!empty($vendor_info['instagram_url'])){
			$instagram_url = $vendor_info['instagram_url'];
		} else {
			$instagram_url = '';
		}
		
		if(!empty($vendor_info['twitter_url'])){
			$twitter_url = $vendor_info['twitter_url'];
		} else {
			$twitter_url = '';
		}
		
		if(!empty($vendor_info['snapchat_url'])){
			$snapchat_url = $vendor_info['snapchat_url'];
		} else {
			$snapchat_url = '';
		}
		
		if(!empty($vendor_info['pinterest_url'])){
			$pinterest_url = $vendor_info['pinterest_url'];
		} else {
			$pinterest_url = '';
		}
		
		if(!empty($vendor_info['youtube_url'])){
			$youtube_url = $vendor_info['youtube_url'];
		} else {
			$youtube_url = '';
		}
		
		if(!empty($vendor_info['linkidin_url'])){
			$linkidin_url = $vendor_info['linkidin_url'];
		} else {
			$linkidin_url = '';
		}
		
		if(!empty($vendor_info['tiktok_url'])){
			$tiktok_url = $vendor_info['tiktok_url'];
		} else {
			$tiktok_url = '';
		}
		$data['whatsapp_url'] = $whatsapp_url;
		$data['instagram_url'] = $instagram_url;
		$data['twitter_url'] = $twitter_url;
		$data['snapchat_url'] = $snapchat_url;
		$data['pinterest_url'] = $pinterest_url;
		$data['youtube_url'] = $youtube_url;
		$data['linkidin_url'] = $linkidin_url;
		$data['tiktok_url'] = $tiktok_url;
		/* Social icon */

		$data['facebookurl'] = $facebookurl;
		$data['googleurl'] = $googleurl;
		$data['vendorfindme'] =  $this->url->link('extension/tmdmultivendor/vendor/findme','&vendor_id=' .$vendor_info['vendor_id']);
			 


		//25-3-2019 start
		if($this->customer->getEmail()){
			$data['customer_email'] = $this->customer->getEmail();
		} else {
			$data['customer_email'] = '';
		}


		$data['communication_status'] = $this->config->get('tmdcommunication_status');
		$data['updfiletype'] = $this->config->get('tmdcommunication_imagetype');
		$loginvendor = $this->vendor->isLogged();
			if($loginvendor==$vendor_id){
				$data['showsellermsg']= false;
			}else{
				$data['showsellermsg']= true;
			}

			if (!$this->customer->isLogged()) {
			$data['text_loginsellerplz'] 		= $this->language->get('text_loginsellerplz');
				$this->session->data['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/vendor_profile','&vendor_id=' .$this->request->get['vendor_id']);
			} else {
				$data['text_loginsellerplz'] 		='';
			}
			$data['text_seller_contact'] 	  	= $this->language->get('text_seller_contact');
			$data['entry_from'] 	  	= $this->language->get('entry_from');
			$data['entry_subject'] 	  	= $this->language->get('entry_subject');
			$data['entry_message'] 	  	= $this->language->get('entry_message');
			$data['entry_attach'] 	  	= $this->language->get('entry_attach');
			$data['button_upload'] 	  	= $this->language->get('button_upload');
			//25-3-2019 end

		if(!empty($vendor_info['store_logowidth'])){
			$store_logowidth = $vendor_info['store_logowidth'];
		} else {
			$store_logowidth = 75;
		}

		if(!empty($vendor_info['store_logoheight'])){
			$store_logoheight = $vendor_info['store_logoheight'];
		} else {
			$store_logoheight = 75;
		}

		if(!empty($vendor_info['store_bannerwidth'])){
			$store_bannerwidth = $vendor_info['store_bannerwidth'];
		} else {
			$store_bannerwidth = 1200;
		}

		if(!empty($vendor_info['store_bannerheight'])){
			$store_bannerheight = $vendor_info['store_bannerheight'];
		} else {
			$store_bannerheight = 400;
		}

		if(!empty($vendor_info['image'])){
			$images = $this->model_tool_image->resize($vendor_info['image'],150,150);
		} else {
			$images = $this->model_tool_image->resize('placeholder.png',150,150);
		}

		if(!empty($vendor_info['banner'])){
			$banners = $this->model_tool_image->resize($vendor_info['banner'],$store_bannerwidth,$store_bannerheight);
		} else {
			$banners = $this->model_tool_image->resize('placeholder.png',$store_bannerwidth,$store_bannerheight);
		}

		if(!empty($vendor_info['logo'])){
			$logos = $this->model_tool_image->resize($vendor_info['logo'],$store_logowidth, $store_logoheight);
		} else {
			$logos = $this->model_tool_image->resize('placeholder.png',$store_logowidth,$store_logoheight);
		}

		if(!empty($vendor_info['store_about'])){
			$store_about = $vendor_info['store_about'];
		} else {
			$store_about = '';
		}

		$storedescription = strip_tags(trim(html_entity_decode($vendor_info['description'], ENT_QUOTES, 'UTF-8')));
		if(!empty($storedescription)) {
		$data['storedescription'] = html_entity_decode($vendor_info['description'], ENT_QUOTES, 'UTF-8');
		} else {
		$data['storedescription'] = '';
		}

		$shipping_policy = strip_tags(trim(html_entity_decode($vendor_info['shipping_policy'], ENT_QUOTES, 'UTF-8')));
		if(!empty($shipping_policy)){
			$data['shipping_policy'] =  html_entity_decode($vendor_info['shipping_policy'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['shipping_policy']  = '';
		}


		$return_policy = strip_tags(trim(html_entity_decode($vendor_info['return_policy'], ENT_QUOTES, 'UTF-8')));

		if(!empty($return_policy)){
			$data['return_policy']  =  html_entity_decode($vendor_info['return_policy'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['return_policy']  = '';
		}


		if(!empty($vendor_info['display_name'])){
			$display_name = $vendor_info['display_name'];
		} else {
			$display_name = '';
		}
		if(!empty($vendor_info['vendor_id'])){
			$vendor_id = $vendor_info['vendor_id'];
		} else {
			$vendor_id = '';
		}
     

		if(!empty($vendor_info['telephone'])){
			$vendortelephone = $vendor_info['telephone'];
		} else {
			$vendortelephone = '';
		}
		if(!empty($vendor_info['name'])){
			$vendorname = $vendor_info['name'];
		} else {
			$vendorname = '';
		}
		if(!empty($vendor_info['map_url'])){
			$map_url = $vendor_info['map_url'];
		} else {
			$map_url = '';
		}

		if(!empty($vendor_info['about'])){
			$aboutvendor = $vendor_info['about'];
		} else {
			$aboutvendor = '';
		}



		if(!empty($vendor_info['text'])) {
			$ratingtext = $vendor_info['text'];
		} else {
			$ratingtext='';
		}

		if(!empty($vendor_info['email'])){
			$vendoremail = $vendor_info['email'];
		} else {
			$vendoremail = '';
		}

		$data['banners'] 		= $banners;
		$data['logos'] 		    = $logos;
		$data['store_about'] 	= $store_about;
		$data['name'] 			= $vendorname;
		$data['map_url'] 		= $map_url;

		$data['images'] 		= $images;
		$data['display_name'] 	= $display_name;
		$data['vendor_id'] 	    = $vendor_id;
		$data['catevendor_id'] 	= $vendor_id;
		$data['email'] 			= $vendoremail;

		$data['telephone'] 		= $vendortelephone;
		$data['about'] 			= $aboutvendor;
		$data['ratingtext'] 	= $ratingtext;


// Get Vendor Id More than One Time Insert Start //
		$data['customerloggin'] = $this->customer->isLogged();
		$write_infos = $this->model_extension_tmdmultivendor_vendor_vendor->getWriteReview($this->request->get['vendor_id']);

		if(isset($vendor_info['vendor_id'])){
			$vids = $vendor_info['vendor_id'];
		} else {
			$vids='';
		}

		if(isset($write_infos['customer_id'])){
			$ids = $write_infos['customer_id'];
		} else {
			$ids='';
		}

		if(isset($write_infos['vendor_id'])){
			$vendorids = $write_infos['vendor_id'];
		} else {
			$vendorids='';
		}
		$data['ids'] = $ids;
		$data['vids'] = $vids;
		$data['vendorids'] = $vendorids;

		$data['totals'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalCollections($vendor_id);
		$data['sellertotal'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalSellerReview($vendor_id);
		$data['producttotal'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalProductReview($vendor_id);

		$data['vendorcontact'] = $this->config->get('vendor_hidevendorcontact');
		

		
		$data['loggin'] = $this->vendor->isLogged();
		$data['custloggin'] = $this->customer->isLogged();

		if(isset($this->request->get['vendor_id'])) {
			$data['requets']=$this->model_extension_tmdmultivendor_vendor_vendor->getFollow($this->request->get['vendor_id']);
		} else if(isset($this->request->get['vendor_id'])) {
			$data['requets']=$this->model_extension_tmdmultivendor_vendor_vendor->getDelete($this->request->get['vendor_id']);
		}else {
			$data['requets']='';
		}

	$data['followerstotal'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalFollowers($vendor_id);

	$data['reviewvalue'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorSumValue($vendor_id);
	
	$data['field_infos']=[];


	$field_infos = $this->model_extension_tmdmultivendor_vendor_vendor->getFieldReviews($vendor_id);

		foreach($field_infos as $field_info){

			$ven_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($field_info['vendor_id']);
			if(isset($ven_info['display_name'])) {
				$fnames = $ven_info['display_name'];
			} else {
				$fnames='';
			}

			$cus_info = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomer($field_info['customer_id']);
			if(isset($cus_info['firstname'])) {
				$cnames = $cus_info['firstname']. ' ' .$cus_info['lastname'];
			} else {
				$cnames='';
			}


			if(isset($ven_info['about'])) {
				$abouts = $ven_info['about'];
			} else {
				$abouts='';
			}

			$ratings=[];
			$rating_infos = $this->model_extension_tmdmultivendor_vendor_vendor->getField($field_info['review_id'],$field_info['vendor_id']);

			foreach($rating_infos as $rating_info){
				$ratings[]=[
					'field_name'=> $rating_info['field_name'],
					'value' 	=> $rating_info['value']

				];
			}

			$data['field_infos'][]=[
				'review_id' => $field_info['review_id'],
				'reviewtext' => $field_info['text'],
				//'fnames' 	=> $fnames,
				'cnames' 	=> $cnames,
				'abouts' 	=> $abouts,
				'ratings' 	=> $ratings,
				'date_added' => $field_info['date_added']
			];
		}

		$data['sellerreviews']=[];
		
		if(!empty($vendor_info)){
			$vendor_info= $vendor_info;
		} else{
			$vendor_info='';
		}

		$proreviews = $this->model_extension_tmdmultivendor_vendor_vendor->getProReview($vendor_id);

		foreach($proreviews as $proreview){
			$vendorinfo = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($proreview['vendor_id']);

			if(isset($vendorinfo['date_added'])) {
				$date_added = $vendorinfo['date_added'];
			} else {
				$date_added='';
			}
			$products = $this->model_extension_tmdmultivendor_vendor_vendor->getProduct($proreview['product_id']);

			if(isset($products['name'])) {
				$names = $products['name'];
			} else {
				$names='';
			}
			if(isset($products['product_id'])) {
				$product_ids = $products['product_id'];
			} else {
				$product_ids='';
			}
			$data['sellerreviews'][]=[
				'rating' 		=> $proreview['rating'],
				'text' 			=> $proreview['text'],
				'author' 		=> $proreview['author'],
				'names' 		=> $names,
				'date_added' 	=> $date_added,
				'href'  => $this->url->link('product/product','&product_id=' .$product_ids)
			];
		}


		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$data['review_fields'] = $this->model_extension_tmdmultivendor_vendor_vendor->getReviewFields($data);

		if (isset($this->request->post['reviewfield'])) {
			$data['reviewfield'] = $this->request->post['reviewfield'];
		} elseif (isset($review_info['reviewfield'])) {
			$data['reviewfield'] = $this->model_extension_tmdmultivendor_vendor_vendor->getFieldSubmits($this->request->get['review_id']);
		} else {
			$data['reviewfield'] = [];
		}


		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		if (isset($this->request->get['path'])) {

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}


		$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = [
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					];
				}
			}
		} else {
			$category_id = 0;
		}

		$data['products']= [];
		$filter2=[
			'filter_category_id' => $category_id,	
			'vendor_id'     => $vendor_id,
			'filter_filter' => $filter,
			'sort'          => $sort,
			'order'         => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/store');

		$product_total = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter2);
		$products = $this->model_extension_tmdmultivendor_vendor_store->getProducts($filter2);

		foreach($products as $product) {
			if (is_file(DIR_IMAGE . $product['image'])){
				$pimage = $this->model_tool_image->resize($product['image'],50,50);
			}else{
				$pimage = $this->model_tool_image->resize('no_image.png',50,50);
			}

			$pros_info = $this->model_extension_tmdmultivendor_vendor_vendor->getProRev($product['product_id']);

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product['special']) {
					$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

			if(isset($pros_info['rating'])) {
				$ratings = $pros_info['rating'];
			} else {
				$ratings='';
			}

			$product_data[]= [
				'product_id' 	=> $product['product_id'],
				'name'   		=> $product['name'],
				'description' => Helper\Utf8\substr(trim(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8'))),0,120),
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'thumb' 		=> $pimage,
				'rating' 		=> $ratings,
				'minimum'       => $product['minimum'] > 0 ? $product['minimum'] : 1,
				'href'   		=> $this->url->link('product/product','&product_id=' .$product['product_id'])
			];

			$data['products'][] = $this->load->controller('extension/tmdmultivendor/vendor/vendorthumb', $product_data);
		}	

		$url ='';
		
		$data['sorts'] = [];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_default'),
			// 'value' => 'p.sort_order-ASC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.sort_order&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.sort_order&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_name_asc'),
			// 'value' => 'pd.name-ASC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.name&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=pd.name&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_name_desc'),
			// 'value' => 'pd.name-DESC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.name&order=DESC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=pd.name&order=DESC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_price_asc'),
			// 'value' => 'p.price-ASC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.price&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.price&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_price_desc'),
			// 'value' => 'p.price-DESC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.price&order=DESC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.price&order=DESC' . $url)
		];

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = [
				'text'  => $this->language->get('text_rating_asc'),
				// 'value' => 'rating-ASC',
				'value'  => 'vendor_id=' . $vendor_id .'&sort=rating&order=ASC' . $url,
				'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=rating&order=ASC' . $url)
			];

			$data['sorts'][] = [
				'text'  => $this->language->get('text_rating_desc'),
				// 'value' => 'rating-DESC',
				'value'  => 'vendor_id=' . $vendor_id .'&sort=rating&order=DESC' . $url,
				'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=rating&order=DESC' . $url)
			];
		}

		$data['sorts'][] = [
			'text'  => $this->language->get('text_model_asc'),
			// 'value' => 'p.model-ASC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.model&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.model&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_model_desc'),
			// 'value' => 'p.model-DESC',
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.model&order=DESC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.model&order=DESC' . $url)
		];


		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = [];

			$limits = array_unique([$this->config->get('config_pagination'),10, 25, 50, 75, 100]);


			sort($limits);

			foreach ($limits as $value) {
				$data['limits'][] = [
					'text'  => $value,
					'value'  => 'vendor_id=' . $vendor_id .'&limit=' . $value
				];

			}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}


		 $data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($product_total - $this->config->get('config_pagination_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $product_total, ceil($product_total / $this->config->get('config_pagination_admin')));


		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		/// Collection Product End ///

		/// Product Category Start ///
			if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
			} else {
				$data['category_id'] = 0;
			}

			if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
			} else {
				$data['child_id'] = 0;
			}

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$data['categories']=[];
		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			/* sub cate */

			$children_data = [];

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					
					$filter_productdata = [
						'filter_category_id' => $child['category_id'],
						'vendor_id'     => $vendor_id,
						'filter_sub_category' => true
					];

						/* 29 01 2020 sub3 */
						$children_data1 = [];
						$children1 = $this->model_catalog_category->getCategories($child['category_id']);

						foreach($children1 as $child1) {
							$filter_productdata1 = [
								'filter_category_id' => $child1['category_id'],
								'vendor_id'=> $vendor_id,
								'filter_sub_category' => true
							];
							
							$totalproducts = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata1);
							  
							if($totalproducts!=0){
								$children_data1[] = [
									'category_id' => $child1['category_id'],
									'name' => $child1['name'] . (' (' . $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata1) . ')')

								];
							}
						}
						/* 29 01 2020 sub3 */
					$children_data[] = [
						'category_id' => $child['category_id'],
						'name' => $child['name'] . (' (' . $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata) . ')'),
						/* 29 01 2020 sub3 */
						'children1'    => $children_data1,
						/* 29 01 2020 sub3 */

					];
				}

			/* sub cate */

			$category_infos = $this->model_catalog_category->getCategory($category['category_id']);

			if(isset($category_infos['name'])){
				$categoryname = $category_infos['name'];
			} else {
				$categoryname='';
			}

			$filter_productdata = [
				'filter_category_id'  => $category['category_id'],
				'vendor_id'     => $vendor_id,
				'filter_sub_category' => true
			];

			$vcategorytotal = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata);

			if($vcategorytotal > 0){
				$data['categories'][]=[
					'category_id' => $category['category_id'],
					'categoryname' => $categoryname . (' (' . $vcategorytotal . ')'),
					'children'    => $children_data,

				];

			}
		}

		/* 08 06 2020 */
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
		/*############ 13 02 2021 Start code ############*/		
		
		$show_profiletab_info = $this->config->get('vendor_profile');
		if(isset($show_profiletab_info)){
			$data['show_profiletab'] = $show_profiletab_info;
		} else {
			$data['show_profiletab'] = 1;
		}
		
		$show_aboutstoretab_info = $this->config->get('vendor_aboutstore');
		if(isset($show_aboutstoretab_info)){
			$data['show_aboutstoretab'] = $show_aboutstoretab_info;
		} else {
			$data['show_aboutstoretab'] = 1;
		}
		
		$show_tabproduct_info = $this->config->get('vendor_tabproduct');
		if(isset($show_tabproduct_info)){
			$data['show_tabproduct'] = $show_tabproduct_info;
		} else {
			$data['show_tabproduct'] = 1;
		}
		
		$show_reviewtab_info = $this->config->get('vendor_review');
		if(isset($show_reviewtab_info)){
			$data['show_reviewtab'] = $show_reviewtab_info;
		} else {
			$data['show_reviewtab'] = 1;
		}
		
		$show_productreview_info = $this->config->get('vendor_productreview');
		
		if(isset($show_productreview_info)){
			$data['show_productreview'] = $show_productreview_info;
		} else {
			$data['show_productreview'] = 1;
		}
		
		
		$data['vendor_profilestoresort'] = $this->config->get('vendor_profilestoresort');
		$data['vendor_aboutstoresort'] = $this->config->get('vendor_aboutstoresort');
		$data['vendor_tabproductsort'] = $this->config->get('vendor_tabproductsort');
		$data['vendor_reviewsort'] = $this->config->get('vendor_reviewsort');
		$data['vendor_productreviewsort'] = $this->config->get('vendor_productreviewsort');
		
		/*############ 13 02 2021 End code ############*/
		
		/* 08 06 2020 */
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		/* tmd vendor2 seler condtion start */
			$vendorloged = $this->vendor->isLogged();
			$customer2vendor = $this->config->get('vendor_customer2vendor');
			if($customer2vendor==1 || $vendorloged){

			$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/vendor_profile', $data));

			} else {

			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}


			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('heading_titleseler');
			$data['text_error'] = $this->language->get('text_error1');
			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('commmon/home');
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
		/* tmd vendor2 seler condtion start */


        /* 01-02-2019 */
		} else {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			$data['breadcrumbs'][] = [
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile', $url . '&vendor_id=' . $vendor_id)
			];

			$this->document->setTitle($this->language->get('text_error'));

			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('vendor/allseller');
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
		/* 01-02-2019 */

	}

	public function review(){
		$json = [];
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if(empty($this->request->post['text'])){
				$json['error']='Please add Comment here';
			} else {
			 $this->model_extension_tmdmultivendor_vendor_vendor->addReview($this->request->post,$this->request->get['vendor_id']);

			$json['success'] = $this->language->get('text_success');
			}
		}
		$this->index();
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function loadcategory() {

        $this->load->language('extension/tmdmultivendor/vendor/vendor_profile');

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		/* 01-07-2019 update with 9 */

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = 9;
		}

		if(isset($this->request->get['vendor_id'])) {
			 $vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);

		}

		if(!empty($vendor_info['vendor_id'])){
			$vendor_id = $vendor_info['vendor_id'];
		} else {
			$vendor_id = '';
		}

		 $data['vendor_id'] 	    = $vendor_id;


		/* 01-07-2019 */
		if (isset($this->request->get['category_id'])) {
		/* 01-07-2019 */
		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$path = '';

			$parts = explode('_', (string)$this->request->get['category_id']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = [
						'text' => $category_info['name'],
						'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile ', 'language=' . $this->config->get('config_language') . '&path=' . $path . $url)
					];
				}
			}
		} else {
			$category_id = 0;
		}


		$data['products']= [];

		$filter2=[
			'filter_category_id' => $category_id,
			'vendor_id'     => $vendor_id,
			'filter_filter' => $filter,
			'sort'          => $sort,
			'order'         => $order,
			'start'         => ($page - 1) * $limit,
			'limit'         => $limit
		];

		$this->load->model('extension/tmdmultivendor/vendor/store');

		$product_total = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter2);
		$products = $this->model_extension_tmdmultivendor_vendor_store->getProducts($filter2);

		foreach($products as $product) {
			if (is_file(DIR_IMAGE . $product['image'])){
				$pimage = $this->model_tool_image->resize($product['image'],  100,100);
			}else{
				$pimage = $this->model_tool_image->resize('no_image.png',  100,100);
			}

			$pros_info = $this->model_extension_tmdmultivendor_vendor_vendor->getProRev($product['product_id']);

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product['special']) {
					$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

			 $reviewststatus = $this->model_extension_tmdmultivendor_vendor_store->getProductReviewStatus($product['product_id']);
			
			  if (!empty($reviewststatus['rstatus'])){
				if(isset($pros_info['rating'])) {
					$ratings = $pros_info['rating'];
				} else {
					$ratings=false;
				}
			  } else {
				  $ratings=false;
			  }

			$product_data = [
				'product_id' 	=> $product['product_id'],
				'name'   		=> $product['name'],
				'description'	=>substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, 120),
				'price'         => $price,
				'special'       => $special,
				'tax'           => $tax,
				'thumb' 		=> $pimage,
				'rating' 		=> $ratings,
				'minimum'       => $product['minimum'] > 0 ? $product['minimum'] : 1,
				'href'   		=> $this->url->link('product/product','&product_id=' .$product['product_id'])
			];

			$data['products'][] = $this->load->controller('extension/tmdmultivendor/vendor/vendorthumb', $product_data);
		}
		
		
		$url = '';	

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory','vendor_id=' . $vendor_id .'&category_id=' . $category_id . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($product_total - $this->config->get('config_pagination_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $product_total, ceil($product_total / $this->config->get('config_pagination_admin')));

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		/* 01-07-2019 update with 9 */
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * 9) + 1 : 0, ((($page - 1) * 9) > ($product_total - 9)) ? $product_total : ((($page - 1) * 9) + 9), $product_total, ceil($product_total / 9));
		/* 01-07-2019 update with 9 */
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;


		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/loadcategory', $data));
	}

	function follow(){
		$json = [];
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_extension_tmdmultivendor_vendor_vendor->addFollow($this->request->post['vendor_id'],$this->request->post);
			$json['success'] = $this->language->get('text_success');

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	function delfollow(){
		$json = [];
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_extension_tmdmultivendor_vendor_vendor->getDelete($this->request->get['vendor_id']);
			$json['success'] = $this->language->get('text_success');

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	//25-3-2019 start

	function sendmessage(){
		$json = [];
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if(empty($this->request->post['subject'])) {
				$json['error']= $this->language->get('error_subject');
			}
			else {
			$this->model_extension_tmdmultivendor_vendor_vendor->Addmessage($this->request->post,$this->request->get['vendor_id']);
				$json['success'] = $this->language->get('success_msg');
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	//25-3-2019 end

	/* 01-07-2019 start */
	public function vendorproduct() {
		$this->load->language('extension/tmdmultivendor/vendor/vendor_profile');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		// 
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = (int)$this->config->get('config_pagination');
		}

		if(isset($this->request->get['vendor_id'])) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);
		}

		if(!empty($vendor_info['vendor_id'])){
			$vendor_id = $vendor_info['vendor_id'];
		} else {
			$vendor_id = '';
		}

		 $data['vendor_id'] 	    = $vendor_id;

		if (isset($this->request->get['path'])) {

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = [
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					];
				}
			}
		} else {
			$category_id = 0;
		}

		$data['products']= [];
		 
		$filter2=[
			'filter_category_id' => $category_id,
			'filter_sub_category' => $this->config->get('config_product_category') ? true : false,
			'vendor_id'     => $vendor_id,
			'filter_filter' => $filter,
			'sort'          => $sort,
			'order'         => $order,
			'start'         => ($page - 1) * $limit,
			'limit'         => $limit
		];

		$this->load->model('extension/tmdmultivendor/vendor/store');

		$product_total = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter2);
		
		$products = $this->model_extension_tmdmultivendor_vendor_store->getProducts($filter2);

		foreach($products as $product) {
			if (is_file(DIR_IMAGE . $product['image'])){
				$pimage = $this->model_tool_image->resize($product['image'],  100,100);
			}else{
				$pimage = $this->model_tool_image->resize('no_image.png',  100,100);
			}

			$pros_info = $this->model_extension_tmdmultivendor_vendor_vendor->getProRev($product['product_id']);
			
        	if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$product['special']) {
				$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}
		  
		  $reviewststatus = $this->model_extension_tmdmultivendor_vendor_store->getProductReviewStatus($product['product_id']);
		
		  if (!empty($reviewststatus['rstatus'])){
			if(isset($pros_info['rating'])) {
				$ratings = $pros_info['rating'];
			} else {
				$ratings=false;
			}
		  } else {
			  $ratings=false;
		  }

		$product_data = [
			'product_id' 	=> $product['product_id'],
			'name'   		=> $product['name'],
			'description' => Helper\Utf8\substr(trim(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8'))),0,120),
			'price'       => $price,
			'special'     => $special,
			'tax'         => $tax,
			'thumb' 		=> $pimage,
			'ratings' 		=> $ratings,
			'minimum'       => $product['minimum'] > 0 ? $product['minimum'] : 1,
			'href'        => $this->url->link('product/product', 'language=' . $this->config->get('config_language') .'&product_id=' . $product['product_id'] )
		];

		$data['products'][] = $this->load->controller('extension/tmdmultivendor/vendor/vendorthumb', $product_data);

		}

		$url ='';

		$data['sorts'] = [];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_default'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.sort_order&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.sort_order&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_name_asc'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.name&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=pd.name&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_price_asc'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.price&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.price&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_price_desc'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=pd.price&order=DESC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.price&order=DESC' . $url)
		];

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = [
				'text'  => $this->language->get('text_rating_desc'),
				'value'  => 'vendor_id=' . $vendor_id .'&sort=rating&order=DESC' . $url,
				'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=rating&order=DESC' . $url)
			];

			$data['sorts'][] = [
				'text'  => $this->language->get('text_rating_asc'),
				'value'  => 'vendor_id=' . $vendor_id .'&sort=rating&order=ASC' . $url,
				'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=rating&order=ASC' . $url)
			];
		}

		$data['sorts'][] = [
			'text'  => $this->language->get('text_model_asc'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.model&order=ASC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.model&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'  => $this->language->get('text_model_desc'),
			'value'  => 'vendor_id=' . $vendor_id .'&sort=p.model&order=DESC' . $url,
			'href'  => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&sort=p.model&order=DESC' . $url)
		];

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
		    $this->document->addLink($this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id']), 'canonical');
		} else {
			$this->document->addLink($this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&page=' . $page), 'canonical');
		}

		if ($page > 1) {
			$this->document->addLink($this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . (($page - 2) ? '&page=' . ($page - 1) : '')), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('extension/tmdmultivendor/vendor/vendor_profile|loadcategory', 'language=' . $this->config->get('config_language') . '&vendor_id=' . $this->request->get['vendor_id'] . '&page=' . ($page + 1)), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$data['categories']=[];
		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = [];

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_productdata = array('filter_category_id' => $child['category_id'],'vendor_id'     => $vendor_id,  'filter_sub_category' => true);

					$children_data[] = [
						'category_id' => $child['category_id'],
						'name' => $child['name'] . (' (' . $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata) . ')'),

					];
				}


			$category_infos = $this->model_catalog_category->getCategory($category['category_id']);

			if(isset($category_infos['name'])){
				$categoryname = $category_infos['name'];
			} else {
				$categoryname='';
			}

			$filter_productdata = [
				'filter_category_id'  => $category['category_id'],
				'vendor_id'     => $vendor_id,
				'filter_sub_category' => true
			];

			$vcategorytotal = $this->model_extension_tmdmultivendor_vendor_store->getTotalProducts($filter_productdata);

			if($vcategorytotal > 0){
				$data['categories'][]=[
					'category_id' => $category['category_id'],
					'categoryname' => $categoryname . (' (' . $vcategorytotal . ')'),
					'children'    => $children_data,

				];
			}
		}
		
		/*  */
		$url = '';

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile|list' . $url . '&page={page}')
		]);	

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($product_total - $this->config->get('config_pagination_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $product_total, ceil($product_total / $this->config->get('config_pagination_admin')));

	
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/loadcategory', $data));
	}

	/* 01-07-2019 end */

}
