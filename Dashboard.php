<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function index()
	{
		$this->load->model('Model_project');
		if (empty($_GET)) {
			$years = date("d-m-Y");
			$tahun = date('Y', strtotime($years));
		} else {
			$tahun = date($_GET['tahun']);
		}
		$data = $this->Model_project->tampil_project($tahun);
		json_encode($data);
		$data['title'] = "Project Plan";

		// Instagran API
		$user_id = "17841402788276749";
		$token = "IGQVJWcjhnLTlBeFVXME1JSlRjM2YwM29lWUNURnM1bjFYVm90b3hoWTQ4TVVBbVJPbU42bmhYQlN6bHJoM0E0b2I5V3lFcmJYZAnM1dVRaa1dvRWpqdWZATcVFxMWFUeDZAqeUMtMGVn";

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

		// $get_data = file_get_contents('https://www.instagram.com/iqbalflh__/channel/?__a=1&page=2');

		// $test = json_decode($get_data, true);



		// $data['api2'] = $test;

		// $data['test'] = json_decode($get_data, true);

		$this->load->view('templates/template_header');
		$this->load->view('templates/template_sidebar');
		$this->load->view('dashboard/index', $data);
		$this->load->view('templates/template_footer');
	}
}
