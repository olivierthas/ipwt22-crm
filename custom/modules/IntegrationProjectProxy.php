<?php

//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

class IntegrationProjectProxy
{
	//API call
	public static function CallAPI($method, $url, $data = false)
	{
		$curl = curl_init();

		switch ($method)
		{
			//method
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
					'Content-Type: application/json',                                                                                
					'Content-Length: ' . strlen($data))                                                                       
					);   
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($curl);
		//print $result;
		
		return 0;
	}

	function sendMessage($bean, $event, $argument)
	{
		//custom logic
		LoggerManager::getLogger();
		LoggerManager::getLogger()->fatal("----------------------------------------------------------------------------");
		//object type
		LoggerManager::getLogger()->fatal($bean->object_name);
		LoggerManager::getLogger()->fatal("----------------------------------------------------------------------------");
		//opgegeven naam voor het object
		LoggerManager::getLogger()->fatal($bean->name);
		LoggerManager::getLogger()->fatal("ID van het aangemaakte onderdeel:");
		LoggerManager::getLogger()->fatal( $bean->id);

		if ($bean->object_name == "Account")
		{
			//Call naar Test method in API van Jérémy
			//CallAPI("GET", "http://localhost:5555/api/account/test");

			//Opbouwen van array met de nodige data van een nieuw aangemaakte account in suiteCRM
			$arr = array('id' => $bean->id, 'name' => $bean->name, 'billing_address_street' => $bean->billing_address_street, 'billing_address_city' => $bean->billing_address_city, 'billing_address_postalcode' => $bean->billing_address_postalcode, 'billing_address_country' =>  $bean->billing_address_country, 'phone_office' => $bean->phone_office, 'email' => $bean->email1, 'Emails' => null);
			//, 'name' => "Elias", 'billing_address_street' => "ehbStraat", 'city' => "Meise", 'postalCode' => "1860", 'country' => "BE", 'phoneOffice' => "02/481.79.00", 'email' => "elias@ehb.be");
			
			//Json encoding
			$data =  json_encode($arr);

			//Loggen voor controle van de data
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method 
			//143.47.178.204:8080
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/account/Create", $data);
		}

		if ($bean->object_name == "Contact")
		{
			//Opbouwen van array met de nodige data van een nieuw aangemaakte Contact in suiteCRM
			$arr = array('id' => $bean->id, 'first_name' => $bean->first_name, 'last_name' => $bean->last_name,'email1' => $bean->email1, 'phone_mobile' => $bean->phone_mobile);
			
			//Json encoding
			$data =  json_encode($arr);

			//Loggen
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method in Contact Controller
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/contact/Create", $data);
		}

		$data =  json_encode($bean);
		//LoggerManager::getLogger()->fatal($data);

		if ($bean->object_name == "Meeting")
		{
			//Opbouwen van array met de nodige data van een nieuw aangemaakte Meeting in suiteCRM
			$arr = array('id' => $bean->id, 'name' => $bean->name, 'description' => $bean->description,  'date_start' => $bean->date_start, 'date_end' => $bean->date_end, 'duration_hours' => $bean->duration_hours, 'duration_minutes' => $bean->duration_minutes, 'status' => $bean->status, 'parent_type' => $bean->parent_type, 'parent_id' => $bean->parent_id);
						
			//$bean->load_relationship('meetings_contacts');
			//$contacts = $bean->load_relationship('meetings_contacts'); 

			//Probeersel om contacts meteen mee te geven bij aanmaken meeting, without success
			//$sql = "SELECT  meeting_id, contact_id FROM meetings_contacts WHERE meeting_id = '{$bean->id}'"; 
			//$sql = "SELECT  meeting_id, contact_id FROM meetings_contacts WHERE meeting_id = 'b2509457-57fb-8b3b-b3f2-628690ecb70e'";
			//sleep(5);

			// LoggerManager::getLogger()->fatal($sql);
			// $result = $GLOBALS["db"]->query($sql);

			// while ( $product = $GLOBALS["db"]->fetchByAssoc($result) ) {
			// 	$contact_id = $product['contact_id'];
			// 	LoggerManager::getLogger()->fatal($contact_id);
			// }

			//LoggerManager::getLogger()->fatal($result);
			
			//Welke velden komen mee via bean?
			//LoggerManager::getLogger()->fatal($bean->column_fields);
			//LoggerManager::getLogger()->fatal($contacts->column_fields);

			//If relationship is loaded
			// if ($bean->load_relationship('meetings_contacts'))
			// {
			// 	LoggerManager::getLogger()->fatal("Gelukt");
			// } else LoggerManager::getLogger()->fatal($bean->load_relationship('meetings_contacts'));

			// foreach($contacts as $contact){
			// 		//do something with a contact.
			// 		$someId = $contact->id;
			// 		LoggerManager::getLogger()->fatal("Een contact");
			// 		LoggerManager::getLogger()->fatal($someId);
			// }

			//LoggerManager::getLogger()->fatal("After foreach loop");
			//Json encoding
			$data =  json_encode($arr);

			//Loggen
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method 
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/meeting/Create", $data);
		}

			
			//     /*if ($bean->object_name == 'Account')
			//     {
			// 	    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
			// 	    $channel = $connection->channel();
			// 	    $channel->queue_declare('hello', false, false, false, false);
			// 	    $msg = new AMQPMessage($bean->name);
			// 	    $channel->basic_publish($msg, '', 'hello');
			// 	    $channel->close();
			// 	    $connection->close();
			//     }*/		
			// }

	}

	function sendDeleteMessage($bean, $event, $argument)
	{
		//custom logic
		LoggerManager::getLogger();
		//object type
		LoggerManager::getLogger()->fatal($bean->object_name);
		//opgegeven naam voor het object
		LoggerManager::getLogger()->fatal($bean->name);
		LoggerManager::getLogger()->fatal("ID van het aangemaakte onderdeel:");
		LoggerManager::getLogger()->fatal( $bean->id);

		if ($bean->object_name == "Account")
		{
			//Doorgeven van id verwijderde Account
			$arr = array('id' => $bean->id);
			
			//Json encoding
			$data =  json_encode($arr);

			//Loggen
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method 
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/account/Delete", $data);
		}

		if ($bean->object_name == "Contact")
		{
			//Doorgeven van id verwijderde Account
			$arr = array('id' => $bean->id);
			
			//Json encoding
			$data =  json_encode($arr);

			//Loggen
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method 
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/contact/Delete", $data);
		}

		if ($bean->object_name == "Meeting")
		{
			//Doorgeven van id verwijderde Account
			$arr = array('id' => $bean->id);
			
			//Json encoding
			$data =  json_encode($arr);

			//Loggen
			LoggerManager::getLogger()->fatal($data);

			//API call naar Create method 
			//IntegrationProjectProxy::CallAPI("POST", "http://193.191.183.42:5172/api/meeting/Delete", $data);
		}
	}
}

?>
