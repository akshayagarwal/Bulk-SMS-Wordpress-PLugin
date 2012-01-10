<?php
/*
Plugin Name: Bulk SMS 
Plugin URI: http://wordpress.org/extend/plugins/bulk-sms/
Description: Sends SMS using Bulk SMS Gateway
Version: 1.0
Author: Akshay Agarwal  
Author URI: http://www.akshayagarwal.in
License: GPL2
*/

/*  Copyright 2011  AKSHAY AGARWAL  (email : info@akshayagarwal.in)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function show_bulksms_visitor_form(){
            
            $bulksms_form = "";
            $bulksms_form ="<form action='".$_SERVER['PHP_SELF']."' method='post'>
	    <table>
	     <tr>
	    <td>Name: </td><td><input type='text' name='visitor_name'></td>
             <tr>
            <td>Mobile: </td><td><input type='text' name='visitor_mobile' length=10> (without country code)</td>
             <tr>
	    <td>Email: </td><td><input type='text' name='visitor_email'></td>
	    <tr>
            <td>Message: </td><td><textarea name='message_for_admin'></textarea></td>
            <tr>
            <td></td><td><input type='submit' name='submit' value='Send'></td>
	    </table>
	    </form>
            ";
            return $bulksms_form;
}

function bulksms_add_header_scripts()
{
  if(isset($_POST['submit']))
  {
            
	    $bulksms_admin_mobile=get_option('bulksms_admin_mobile');
	    $gateway_domain=get_option('bulksms_gateway_domain');
            $bulksms_username=get_option('bulksms_username');
            $bulksms_password=get_option('bulksms_password');
            $bulksms_sender=get_option('bulksms_sender');
	    $bulksms_send_visitor_msg=get_option('bulksms_send_visitor_msg');
            $bulksms_visitor_message=get_option('bulksms_visitor_message');
	    
	    $message_for_admin=$_POST['visitor_name']." ( ".$_POST['visitor_mobile']." , ".$_POST['visitor_email']." says ".$_POST['message_for_admin'];
	    $visitor_mobile=$_POST['visitor_mobile'];
	    
	    
	    
	    $username=urlencode($bulksms_username);
	    $password=urlencode($bulksms_password);
	    $sender=urlencode($bulksms_sender);
	    $admin_message=urlencode($message_for_admin);
	    $method="POST";
	    
	    
	    
	    $opts = array(
	      'http'=>array(
		'method'=>"$method",
		    'content' => "username=$username&password=$password&sender=$sender&to=$bulksms_admin_mobile&message=$admin_message",
		'header'=>"Accept-language: en\r\n" .
			  "Cookie: foo=bar\r\n"
	      )
	    );
	    
	    
	    
	    $context = stream_context_create($opts);
	    
	    $fp = fopen("http://$gateway_domain", "r", false, $context);
	    $response = @stream_get_contents($fp);
	    //echo "$response";
	    fpassthru($fp);
	    fclose($fp);
	    
	    
	    if($bulksms_send_visitor_msg==1)
	    {
			$visitor_message=urlencode($bulksms_visitor_message);
			
	    $opts = array(
	      'http'=>array(
		'method'=>"$method",
		    'content' => "username=$username&password=$password&sender=$sender&to=$visitor_mobile&message=$visitor_message",
		'header'=>"Accept-language: en\r\n" .
			  "Cookie: foo=bar\r\n"
	      )
	    );
	    
	    
	    
	    $context = stream_context_create($opts);
	    
	    $fp = fopen("http://$gateway_domain", "r", false, $context);
	    $response = @stream_get_contents($fp);
	    //echo "$response";
	    fpassthru($fp);
			
	    }
	    
	    fclose($fp);
	    ?>
	    <script type="text/javascript">
	     alert('Message Sent Successfully!');
	    </script>
	    <?php
	      }
	    
  
}

function bulksms_admin_form()
{
   include('bulksms_import_admin.php');
}

add_shortcode('bulksms', 'show_bulksms_visitor_form');
add_action('wp_head', 'bulksms_add_header_scripts');
add_action('admin_menu', 'bulksms_plugin_menu');

function bulksms_plugin_menu() {
	add_options_page('Bulk SMS Options', 'Bulk SMS', 'manage_options', 'bulksms', 'bulksms_admin_form');
}

?>
