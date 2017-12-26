   <table>
   <tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" width="100%">
        		<tr>
                	<td valign="middle" style="background-color:#00ABBB; padding:25px 20px; color:#fff; font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:30px;  line-height:1.3;">
                    {{ucwords(trans('messages.keyword_invoice'))}}: <span style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">{{$invoicerecord->invoiceid}} </span>
                    </td>
                    <td width="150px" valign="middle" style="background-color:#00909E; padding:15px 20px; color:#fff; font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:18px;  line-height:1.3; text-align: right">
                    <span style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">{{trans('messages.keyword_issued')}} :</span><br> {{date('d/m/Y',strtotime($invoicerecord->issued_dt))}}<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    
    <tr>
    	<td>
        
        <table width="100%" cellpadding="0" cellspacing="0">
        	<tr>
            	<td style="padding:15px 10px 15px 20px; background-color:#fff" width="50%" valign="top">
                	<table width="100%"  cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td style="border:5px solid #00abbc; padding:15px; height:215px" valign="top">
                            	<table width="100%" cellpadding="0" cellspacing="0">
                                	<tr>
                                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px;  line-height:1.3; padding-bottom:10px"> 
                                        	<strong>{{ucwords(trans('messages.keyword_invoice_to'))}}:</strong>
                                        </td>
                                    </tr>	
                                    <tr>
                                    	 <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:15px;  line-height:1.3; padding-bottom:10px"> 
                                                <strong>{{ucwords($invoicerecord->name)}}</strong> <br>
                                               {{ucwords($invoicerecord->address)}}
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:15px;  line-height:1.3; padding-bottom:10px"> 
                                                Customer ID: IT00493270474 <br>
												Customer VAT ID: IT00493270474 <br>
                                                Constant symbol: 0308 <br>
												Variable symbol: 17011591
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="padding:15px 20px 15px 10px; background-color:#fff" width="50%" valign="top">
                		<table width="100%"  cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td style="padding:15px; height:215px" valign="top">
                            	<table width="100%" cellpadding="0" cellspacing="0">
                                	<tr>
                                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px;  line-height:1.3; padding-bottom:10px"> 
                                        	<strong>Payment method:</strong> <strong>Bank transfer</strong>
                                        </td>
                                    </tr>	
                                    <tr>
                                    	 <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:15px;  line-height:1.3; padding-bottom:10px"> 
                                               <strong>Issue date:</strong> 02.12.2017 <br>
                                               <strong>Due date:</strong> 16.12.2017 <br>
                                               <strong>VAT date:</strong> 30.11.2017 
                                        </td>
                                    </tr>
                                    
                                     <tr>
                                    	 <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:15px;  line-height:1.3; padding-bottom:10px"> 
                                               <strong>Payment Note:</strong> <br>
                                              <span style="font-size:13px; font-family:'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">Lorem ipsum dolor sit amet, diam homero percipitur eos ne. Temporibus mediocritatem ad vel eu ornatus minimum invidunt quo, eos harum officiis te. Dolorem perfecto in vim, te nam alia elitr volutpat, ne libris officiis vix. Ei pro solet definiebas accommodare.</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                	
                </td>
            </tr>
        </table>
        </td>
    </tr>
   </table>
    <table>
    <tr>
    	<td style=" background-color:#fff; padding:0 20px">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<thead>
            	<tr>
                	<th style="text-align:left; font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;"> Item</th>
                    <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;"> Qty</th>
                    <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;"> Unit Price</th>
                    <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;">  Price</th>
                    <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;">  VAT Rate</th>
                     <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;">  VAT</th>
                     <th style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#333333; color:#fff; padding:7px 12px; font-size:15px; line-height:1.3;">  Sub Total</th>
                </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align: left">
                        <strong><span>Reservation commission for Hotel Ercolini & Savi</span></strong> <br>
                        <span>192510067, 194267967</span> <br>
                        <span style="font-size:13px;"> Lorem ipsum dolor sit amet, diam homero percipitur eos ne.</span>
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top">1                        
                        </td>
                        
                         <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> 12%                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $1200                      
                        </td>
                    
                    
                    </tr>
                    
                    <tr>
                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align: left">
                        <strong><span>Reservation commission for Hotel Ercolini & Savi</span></strong> <br>
                        <span>192510067, 194267967</span> <br>
                        <span style="font-size:13px;"> Lorem ipsum dolor sit amet, diam homero percipitur eos ne.</span>
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top">1                        
                        </td>
                        
                         <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> 12%                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $1200                      
                        </td>
                    
                    
                    </tr>
                    
                    <tr>
                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align: left">
                        <strong><span>Reservation commission for Hotel Ercolini & Savi</span></strong> <br>
                        <span>192510067, 194267967</span> <br>
                        <span style="font-size:13px;"> Lorem ipsum dolor sit amet, diam homero percipitur eos ne.</span>
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top">1                        
                        </td>
                        
                         <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> 12%                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $1200                      
                        </td>
                    
                    
                    </tr>
                    
                    <tr>
                    	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align: left">
                        <strong><span>Reservation commission for Hotel Ercolini & Savi</span></strong> <br>
                        <span>192510067, 194267967</span> <br>
                        <span style="font-size:13px;"> Lorem ipsum dolor sit amet, diam homero percipitur eos ne.</span>
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top">1                        
                        </td>
                        
                         <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> 12%                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $12                      
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; padding:7px 12px; font-size:15px; line-height:1.3; border:1px solid #ccc; border-collapse:collapse; text-align:center" valign="top"> $1200                      
                        </td>
                    
                    
                    </tr>
                 
                </tbody>
                	<tr>
                    	<td colspan="7" style="height:2px; background-color:#333"> </td>
                    </tr>
                   
                   
                	<tr>
                    	<td colspan="3"  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f2f2f2;  color:#333; border-left:1px solid #ccc; padding:10px 12px 0 12px; font-size:15px; line-height:1.3;  text-align: left">
                        	<strong>Items total</strong>
                        
                        </td>
                        
                        <td   style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; background-color: #f2f2f2; padding:10px 12px 0 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	<strong>$374,80</strong>
                        
                        </td>
                        <td style="background-color: #f2f2f2;">
                        </td>
                        <td  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; background-color: #f2f2f2; padding:10px 12px 0 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	<strong>$374,80</strong>
                        
                        </td>
                         <td  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f2f2f2;  border-right:1px solid #ccc; color:#333; padding:10px 12px 0 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	<strong>$12000</strong>
                        
                        </td>
                    	
                    </tr>
                    
                    <tr>
                    	<td colspan="3"  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f2f2f2; border-left:1px solid #ccc; color:#333; padding:10px 12px 10px 12px; font-size:15px; line-height:1.3;  text-align: left">
                        	<strong>Payments in advance</strong>
                        
                        </td>
                        
                        <td   style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; background-color: #f2f2f2; padding:10px 12px 10px 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	0
                        
                        </td>
                        <td style="background-color: #f2f2f2;">
                        </td>
                        <td  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;  color:#333; background-color: #f2f2f2; padding:10px 12px 10px 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	
                        
                        </td>
                         <td  style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f2f2f2; border-right:1px solid #ccc;  color:#333; padding:10px 12px 10px 12px; font-size:15px; line-height:1.3;  text-align: center">
                        	0
                        
                        </td>
                    	
                    </tr>
                    <tr>
                    
						<td colspan="6"  style="font-family: 'Playfair Display', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#00ABBB;  color:#fff; padding:10px 12px 10px 12px; font-size:18px; line-height:1.3;  text-align: left" valign="middle">
                        	Total to Pay
                        
                        </td>
                        
                        <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#00ABBB;  color:#fff; padding:10px 12px 10px 12px; font-size:30px; line-height:1.3;  text-align: left" valign="middle">
                        	$12000
                        
                        </td>
                    
                    </tr>
                    
                <tfoot>
                
                
                </tfoot>
            </table>
    	</td>
    </tr>
    </table>
    
    <table>
    <tr>
    	<td style="height:10px;  background-color: #fff;">
        
        </td>
    
    </tr>
    </table>
    <table>
    
    <tr>
    	<td style="padding: 15px 20px 15px 20px; background-color: #fff;">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="border: 5px solid #00abbc; padding: 15px;">
                    	<table width="100%" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td colspan="5" style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding-bottom:30px;  font-size:15px; line-height:1.3;  text-align: left">
                                	<strong>Currency rate by Czech National Bank for 01.11.2017 25,55500 CZK/1 EUR</strong> <br>
                                    Company register kept by the Regional Court in Pilsen, Czech republic, Section C, File 30443 <br>
                                    City code: ITA_MCT
                                </td>
                        	</tr>
                            <tr>
                            	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: left"><strong>VAT summary in CZK</strong> </td>
                                <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: left"><strong>VAT base in CZK</strong> </td>
                                 <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: left"><strong>VAT rate</strong> </td>
                                  <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: left"><strong>VAT in CZK</strong> </td>
                                  <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: left"><strong>Total incl. VAT in CZK</strong> </td>
                            </tr>
                            <tr>
                            	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: center"> </td>
                                	<td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: center">9 578,01 </td>
                                    <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: center">0%</td>
                                     <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: center">0,00</td>
                                      <td style="font-family: 'Questrial', Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding:10px 12px; border:1px solid #ccc;  font-size:15px; line-height:1.3;  text-align: center">9 578,01</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
    