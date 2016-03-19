<?php

    /**
     * creates FinancingInvoiceOrderlines. Used in additionalValues in PxOrder.Initialize8 or PxOrder.Capture5 for Financing Invoice.
     * http://www.payexpim.com/extended-functionality/financinginvoice-orderlines-invoice-2-0/
     */
    class invoiceOrderLines{
	
        private $onlineInvoice;
        private $orderLines;
        private $totalAmount;
        
        function __construct(){
            
           	$this->onlineInvoice = new simpleXMLelement("<OnlineInvoice />");
		$this->onlineInvoice->addAttribute("xmlns:xsi" , "http://www.w3.org/2001/XMLSchema-instance");
		$this->onlineInvoice->addAttribute("xmlns:xsd" , "http://www.w3.org/2001/XMLSchema");
		$this->orderLines = $this->onlineInvoice->addChild("OrderLines"); 
        }
        
        /**
         * Add an orderline to the XML. VAT amount and total amount till be calculated by the method.
         * 
         * @param string $Product Name of the product.
         * @param int $Qty Quantity of this product.
         * @param float $UnitPrice Price for a single unit of this product, no VAT included.
         * @param int $VatRate VAT rate for this product.
         */
        function addOrderLine($Product, $Qty, $UnitPrice, $VatRate){
            
            $_UnitPrice = round($UnitPrice ,2, PHP_ROUND_HALF_UP);
            
            $orderline = $this->orderLines->addChild("OrderLine");
            $orderline->addChild("Product", $Product);
            $orderline->addChild("Qty", $Qty);
            $orderline->addChild("UnitPrice", $_UnitPrice);
            $orderline->addChild("VatRate", $VatRate);
            
            
            $unitVatAmount = round(($UnitPrice * $VatRate) / 100, 2, PHP_ROUND_HALF_UP);
            $vatAmount = round($unitVatAmount * $Qty, 2, PHP_ROUND_HALF_UP);
            $netAmount = round($UnitPrice * $Qty, 2, PHP_ROUND_HALF_UP);
            $amount = round($netAmount + $vatAmount, 2, PHP_ROUND_HALF_UP);
            
            $orderline->addChild("VatAmount", $vatAmount);
            $orderline->addChild("Amount", $amount);
            
            $this->totalAmount += $amount;
        }
        
        /**
         * Returns the complete XML for this object included the orderlines that were added through addOrderLine()
         * 
         * @return string completed XML
         */
        function getXML(){
            return $this->onlineInvoice->asXML();
        }
        
        /**
         * Returns the total amount of all orderlines. Remember to multiply by 100 and store as a string if used for Initialize->price/priceArgList.
         * 
         * @return float the total amount of all orderlines.
         */
        function getTotalAmount(){
            return $this->totalAmount;
        }

    }    

?>