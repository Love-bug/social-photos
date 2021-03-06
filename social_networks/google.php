<?php

require_once(dirname(dirname(__FILE__)) . "/utils/google_utils.php");

class Google implements social_network {

    private $oauth_endpoint = "https://accounts.google.com/o/oauth2/auth";
    private $api_key = ""; // key filled up in production deployment
    private $api_scope = "https://www.googleapis.com/auth/plus.me https://picasaweb.google.com/data/";
    private $session_variable = "google_access_token";

    public static $callback_url = "http://socialphotos.net/callbacks/google.php";

    public function oauth_url() {
        $callback_url  = Google::$callback_url;
        return "{$this->oauth_endpoint}?client_id={$this->api_key}&redirect_uri={$callback_url}&scope={$this->api_scope}&response_type=code";
    }

    public function session_variable() {
        return $this->session_variable;
    }

    public function name() {
        return "Google+";
    }

    public function sign_in_button() {
        return "static/images/google-sign-in.png";
    }

    public function drop_down_icon() {
        return "static/images/google-icon-32.png";
    }

    public function is_writable() {
        return true;
    }

    public function has_albums() {
        return true;
    }

    public function fetch_basic_info_from_network() {
        $info = gp_get_userinfo();
        session_register("google_name");
        session_register("google_link");
        session_register("google_id");
        $_SESSION['google_name'] = $info['name'];
        $_SESSION['google_link'] = $info['link'];
        $_SESSION['google_id'] = $info['userid'];
    }

    public function basic_info() {
        return array('name' => $_SESSION['google_name'], 'link' => $_SESSION['google_link']);
    }

    public function album_list() {
        return gp_get_albums_list();
    }

    public function photos_list($albumid) {
        return gp_get_photos($albumid);
    }

    public function photo($photoid) {
        return gp_get_photo($photoid);
    }

    public function post_photo($albumid, $photo, $photo_file) {
        return gp_post_photo($albumid, $photo, $photo_file);
    }

    public function create_album($title, $caption) {
        return gp_create_album($title, $caption);
    }

    public function clean_up_after_album_creation() {
        return;
    }

}

?>
