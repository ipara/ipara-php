<?php

	/*
	 *	Tüm request ve response sınıflarındaki ortak alanları içermektedir.
	 *	Tüm Request ve response Sınıflarında zorunlu olarak kullanılacak alanları temsil eder.
	 *	Ortak alanları tekrar tekrar kullanmak yerine bu sınıftan kalıtım alarak kullanım sağlanır.
	*/


class  Base
    {
     
    }
    
    class BaseRequest extends Base
    {
        public $Echo ;
      
        public $Mode ;
    }
    
    class BaseResponse extends Base
    {
        public $Result ;
        public $ErrorCode ;
        public $ErrorMessage ;

        public $ResponseMessage ;

        public $Mode ;
        public $Echo ;
        public $Hash ;
        public $TransactionDate ;

    }

    class ThreeDPaymentInitResponse extends BaseResponse
    {
        public $Amount ;
        public $OrderId ;
      
    }