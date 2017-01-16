<?php

Route::get('contact', function(){

	$data = array(
			'plugin_data' => (object) array_build(PluginData::where('plugin_slug', 'contact')->get(), function($key, $data) {
					return array($data->key, $data->value);
			})
	);
	// Show the file located in /content/plugins/hello/views/index.php
	return View::make('plugins::contact.views.index', $data);

});
Route::post('contact_send', function() {
		$user_data = array('fullname' => Input::get('fullname'), 'email' => Input::get('email'), 'subject' => Input::get('subject'), 'message' => Input::get('message') );

		$validation = Validator::make(
		    array(
		        'fullname' => Input::get( 'fullname' ),
		        'email' => Input::get( 'email' ),
						'subject' => Input::get( 'subject' ),
						'message' => Input::get( 'message' ),
		    ),
		    array(
		        'fullname' => array( 'required', 'max:20' ),
		        'email' => array( 'required', 'email' ),
						'subject' => array( 'required', 'max:100' ),
						'message' => array( 'required', 'max:1500' ),
		    )
		);

		if ($validation->fails()){
				$msg = json_decode($validation->messages(), true);
				$msg['note'][] = 'Sorry, there was an error sending your message.';
				$msg['note_type'][] = 'error';
				echo json_encode($msg);
				exit;
		}else{
			//get plugin data
			$data = array(
					'plugin_data' => (object) array_build(PluginData::where('plugin_slug', 'contact')->get(), function($key, $data) {
							return array($data->key, $data->value);
					})
				);
				//print($data['plugin_data']->email);
			try{
				//senf contact mail
				Mail::raw("Name: ". $user_data['fullname'] . "<br/>Email:" . $user_data['email'] . "<br/>Message:" . $user_data['message'], function($message)  use($data, $user_data) {
							$message->to($data['plugin_data']->email, "Agricdemy")->subject("Contact: " . $user_data['subject']);
					 });
				//send message
				$msg['note'] = '<b>Your email has been sent successfully!.</b>';
				$msg['note_type'] = 'success';
				echo json_encode($msg);
				exit;
			}catch(\Exception $e) {
				$msg = json_decode($validation->messages(), true);
				$msg['note'][] = 'Sorry, there was an error sending your message.';
				$msg['note_type'][] = 'error';
				echo json_encode($msg);
				exit;
			}
		}
		exit;
});
