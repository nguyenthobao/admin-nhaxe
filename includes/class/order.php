<?php
/**
 * @Project BNC v2 -> Controller
 * @File includes/class/order.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 23/12/2014, 03:28 [PM]
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

Class OrderClass {
	public function getTypeOrder($key=null){
		/**
		 * $type's values: Loại đơn hàng
		 *
		 * Shipping: Chuyển hàng
		 * Shopping: Mua tại quầy
		 * Deposit: Đơn đặt cọc
		 * Trial: Đơn dung thử
		 * Temporary: Đơn đặt nhanh (CSKH sẽ bổ sung thông tin sau)
		 */
		$type = array(
			'shipping'  => 'Chuyển hàng',
			'shopping'  => 'Mua tại quầy',
			'deposit'   => 'Đơn đặt cọc',
			'trial'     => 'Đơn dùng thử',
			'temporary' => 'Đơn đặt nhanh (CSKH sẽ bổ sung thông tin sau)',
			);
		if (!empty($key)) {
			return $type[$key];
		}else{
			return $type;
		}
	}
	public function getStatusOrder($key=null){
		/**
		 * $status's values: Trạng thái đơn hàng
			* 1|New         => Mới
			* 2|Confirming  => Đang xác nhận
			* 3|Confirmed   => Đã xác nhận
			* 4|Packing     => Đang đóng gói sản phẩm
			* 5|ChangeDepot => Đổi kho xuất hàng
			* 6|Pickup      => Chờ đi nhận
			* 7|Pickingup   => Đang đi nhận
			* 8|Pickedup    => Đã nhận hàng
			* 9|Shipping    => Đang giao hàng
			* 10|Success     => Thành công
			* 11|Failed      => Thất bại (Không liên lạc được khách)
			* 12|Canceled    => Khách hủy
			* 13|Aborted     => Hệ thống hủy (Gọi nhiều lần không được / sai thông tin...)
			* 14|SoldOut     => Hết hàng
			* 15|Returning   => Đang chuyển hoàn
			* 16|Returned    => Đã chuyển hoàn
		 */
		$status = array(
				'New'         => 'Mới',
				'Confirming'  => 'Đang xác nhận',
				'Confirmed'   => 'Đã xác nhận',
				'Packing '    => 'Đang đóng gói sản phẩm',
				'ChangeDepot' => 'Đổi kho xuất hàng',
				'Pickup'      => 'Chờ đi nhận',
				'Pickingup'   => 'Đang đi nhận',
				'Pickedup'    => 'Đã nhận hàng',
				'Shipping'    => 'Đang giao hàng',
				'Success'     => 'Thành công',
				'Failed'      => 'Thất bại (Không liên lạc được khách)',
				'Canceled'    => 'Khách hủy',
				'Aborted'     => 'Hệ thống hủy (Gọi nhiều lần không được / sai thông tin...)',
				'SoldOut'     => 'Hết hàng',
				'Returning'   => 'Đang chuyển hoàn',
				'Returned'    => 'Đã chuyển hoàn',
			);
		if (!empty($key)) {
			return $status[$key];
		}else{
			return $status;	
		}
	}
	public function getReason($key=null){
		/**
			* $reason's values: Lý do đơn hàng
			* Same                 => 'Đơn trùng'
			* WrongProduct         => 'Đặt nhầm sản phẩm'
			* HighShipFee          => 'Phí vận chuyển cao'
			* NotTransfer          => 'Không muốn chuyển khoản'
			* CannotCall           => 'Không gọi được khách'
			* CustomerCancel       => 'Khách không muốn mua nữa',
			* CustomerNotAtHome    => 'Khách hàng đi vắng'
			* Bought               => 'Đã mua tại quầy',
			* WaitingTranfer       => 'Chờ chuyển khoản'
			* Soldout              => 'Hết hàng'
			* NotPleasureDeliverer => 'Khách hàng không hài lòng về NVVC',
			* ShippingLongTime     => 'Thời gian giao hàng lâu',
			* WrongAddress         => 'Sai địa chỉ giao hàng',
			* CannotWaitShipping   => 'Không chờ giao hàng được',
			* Other                => 'Lý do khác',
		 */
		$reason = array(
            'Same'                     => 'Đơn trùng',
            'CustomerCancel'           => 'Khách không muốn mua nữa',
            'WaitingTranfer'           => 'Chờ chuyển khoản',
            'Soldout'                  => 'Hết hàng',
            'ShippingLongTime'         => 'Thời gian giao hàng lâu',
            'CannotWaitShipping'       => 'Không chờ giao hàng được',
            'WrongProduct'             => 'Đặt nhầm sản phẩm',
            'HighShipFee'              => 'Phí vận chuyển cao',
            'NotTransfer'              => 'Không muốn chuyển khoản',
            'Duplicated'               => 'Đơn trùng',
            'CannotCall'               => 'Không gọi được khách',
            'SoldOut'                  => 'Hết hàng',
            'WaitingTransfer'          => ' Chờ chuyển khoản',
            'NotLikeProduct'           => 'Khách không thích sản phẩm',
            'NotPleasureDeliverer'     => 'Khách không hài lòng về nhân viên vận chuyển',
            'SlowShipping'             => 'Giao hàng chậm',
            'Bought'                   => 'Đã mua sản phẩm tại cửa hàng',
            'CustomerNotAtHome'        => 'Khách đi vắng (sẽ giao hàng vào hôm khác)',
            'WrongAddress'             => 'Sai địa chỉ người nhận',
            'NotBuy'                   => 'Khách không muốn mua nữa',
            'CannotCallSender'         => 'Không liên hệ được với người gửi',
            'SellerNotSellOnline'      => 'Người gửi không bán hàng Online / Ngoại tỉnh',
            'SellerNotHandoverCarrier' => 'Người gửi không bàn giao hàng cho hãng vận chuyển',
            'SellerNotProcessOrder'    => ' Người gửi không xử lý đơn hàng',
            'WrongPickupAddress'       => 'Sai địa chỉ kho lấy hàng',
            'WrongPrice'               => 'Sai giá sản phẩm',
            'SelfShipping'             => 'Người gửi tự vận chuyển',
            'CarrierPickupLate'        => 'Hãng vận chuyển lấy hàng muộn',
            'CarrierLostProduct'       => 'Hãng vận chuyển làm mất hàng',
            'Other'                    => 'Lý do khác',
        );
		if (!empty($key)) {
			return $reason[$key];
		}else{
			return $reason;	
		}
		
	}
}
?>