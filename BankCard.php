<?php

 /*
  *   Bu sınıf cüzdana kart ekleme servisi isteği sonucunda ve cüzdandaki kartları getir isteği sonucunda bize döndürülen 
  *   alanları temsil etmektedir. 
 */

class BankCard 
{
             public $cardId ;
    
            public $maskNumber ;
    
            public $alias ;
    
            public $bankId ;
    
            public $bankName ;
    
            public $cardFamilyName ;
    
            public $supportsInstallment ;
            public $supportedInstallments ;
            public $type ;
    
            public $serviceProvider ;
    
            public $threeDSecureMandatory ;
            public $cvcMandatory ;
}