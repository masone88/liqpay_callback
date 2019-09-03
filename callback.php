<?php    
  
    if(isset($_POST["signature"]) && isset($_POST["data"]))
	{ 
		$received_signature  = $_POST['signature']; 
		$received_data = $_POST['data'];  
 
		$private_key = 'example_0'; 
		$tomail = 'example@gmail.com'; 
 
		$decode_data = json_decode(base64_decode($received_data)); 
		$generated_signature = base64_encode(sha1($private_key.$received_data.$private_key, 1));
 
		$order_id            = $decode_data->order_id;
		$status              = $decode_data->status;
		$description         = $decode_data->description; 
		$amount              = $decode_data->amount;
		$currency            = $decode_data->currency; 
		
		
		if ($received_signature !== $generated_signature) 
		{ 
			file_put_contents('signature.txt', "No ident received_signature {$received_signature} generated_signature {$generated_signature}");
		} 
		else
		{ 
			if($status) {
				
				$subject = "no-reply LiqPay"; 

				$message = ' 
				<p>Заказ № '.$order_id.'</p> </br> 
				<p>Описание: '.$description.'</p> </br>  
				<p>Сумма платежа: '.$amount.' '.$currency.'</p> </br>  
				<p>Статус: '.$status.'</p> </br>  
				</br>';

				$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
				$headers .= "From: CloutFame.com <support@cloutfame.com>\r\n";  

				mail($tomail, $subject, $message, $headers);  
			}
		}
	}	  
  ?>
  
