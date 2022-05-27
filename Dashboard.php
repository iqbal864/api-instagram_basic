<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function index()
	{
		// Instagran API
		$user_id = "178XXXXXXXXXXX";
		$token = "IGQXXXXXXXXXXX";

		$get_profile = file_get_contents('https://graph.instagram.com/v14.0/' . $user_id . '?fields=id,username&access_token=' . $token . '');
		$get_profile_api = json_decode($get_profile);

		$data['api1'] = $get_profile_api;

		$get_id_media = file_get_contents('https://graph.instagram.com/v14.0/' . $user_id . '/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,username,timestamp&access_token=' . $token . '');
		$get_id_media_api = json_decode($get_id_media);

		$id_media = [];
		foreach ($get_id_media_api->data as $id) {
			if ($id->media_type == "VIDEO") {
				$id_media[] =  array(
					'id' => $id->id,
					'caption' => $id->caption,
					'media_type' => $id->media_type,
					'media_url' => $id->media_url,
					'permalink' =>  $id->permalink,
					'thumbnail_url' =>  $id->thumbnail_url,
					'timestamp' => $id->timestamp
				);
			} else {
				$id_media[] =  array(
					'id' => $id->id,
					'caption' => $id->caption,
					'media_type' => $id->media_type,
					'media_url' => $id->media_url,
					'permalink' =>  $id->permalink,
					'timestamp' => $id->timestamp
				);
			}
		}


		$data['api'] = $id_media;

		$this->load->view('dashboard/index', $data);
	}
}
