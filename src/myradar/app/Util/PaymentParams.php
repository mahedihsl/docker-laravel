<?php

namespace App\Util;

use Exception;
use Illuminate\Support\Collection;

class PaymentParams
{
	const MONTHLY_BILL_INTENT = 'monthly_bill';

	/**
	 * @var Collection
	 */
	private $params;

	public function __construct() {
		$this->params = collect();
	}

	public function setAmount($amount) {
		$this->params->put('amount', $amount);
		return $this;
	}

	public function setTransactionId($tranId) {
		$this->params->put('tran_id', $tranId);
		return $this;
	}

	public function setUser($user) {
		$this->params->put('user_id', $user['id']);
		$this->params->put('user_name', $user['name']);
		$this->params->put('email', 'hs@hypersystems.com.bd');

		$defaultPhone = '+8801907888839';
        $phoneNumber = $defaultPhone;
//		$phoneNumber = strlen($user->phone) ? $user->phone : $defaultPhone;
		$this->params->put('phone', $phoneNumber); // Important: Payment redirection will not work if the address is empty

		$this->params->put('address', 'Customer Address'); // Important: Payment redirection will not work if the address is empty
		return $this;
	}

	public function setProduct($title, $category, $type) {
		$this->params->put('product_name', $title);
		$this->params->put('category', $category);
		$this->params->put('type', $type);
		return $this;
	}

	public function setIntent($intent, $targetId, $extra = '') {
		$this->params->put('intent', $intent);
		$this->params->put('target_id', $targetId);
		$this->params->put('extra', $extra);
		return $this;
	}

	/**
	 * @throws Exception
	 */
	public function getParams() {
		$keys = ['amount', 'tran_id', 'user_name', 'product_name', 'intent'];
		foreach ($keys as $k) {
			if (!$this->params->has($k)) {
				throw new Exception("Missing payment param: ${$k}");
			}
		}
		return $this->params;
	}
}
