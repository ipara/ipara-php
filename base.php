<?php




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