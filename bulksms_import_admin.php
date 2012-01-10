<?php
	
		if(isset($_POST['bulksms_admin_submit']))
                   {
			//Form data sent
                        $bulksms_admin_mobile=$_POST['bulksms_admin_mobile'];
                        update_option('bulksms_admin_mobile',$bulksms_admin_mobile);
                        
			$gateway_domain=$_POST['bulksms_gateway_domain'];
			update_option('bulksms_gateway_domain', $gateway_domain);

			$bulksms_username=$_POST['bulksms_username'];
                        update_option('bulksms_username', $bulksms_username);
                        
                        $bulksms_password=$_POST['bulksms_password'];
                        update_option('bulksms_password',$bulksms_password);
                        
                        $bulksms_sender=$_POST['bulksms_sender'];
                        update_option('bulksms_sender',$bulksms_sender);
                        
                        if(isset($_POST['sendreply']))
                        {
                        $bulksms_send_visitor_msg=1;
                        update_option('bulksms_send_visitor_msg',$bulksms_send_visitor_msg);
                        }
                        else
                        {
                        $bulksms_send_visitor_msg=0;
                        update_option('bulksms_send_visitor_msg',$bulksms_send_visitor_msg);
                        }
                        
                        $bulksms_visitor_message=$_POST['bulksms_visitor_message'];
                        update_option('bulksms_visitor_message',$bulksms_visitor_message);
                        
                        
			?>
                        
			<div class="updated"><p><strong>Options Saved!</strong></p></div>
			<?php
		} else {
			//Normal page display
                        $bulksms_admin_mobile=get_option('bulksms_admin_mobile');
			$gateway_domain=get_option('bulksms_gateway_domain');
                        $bulksms_username=get_option('bulksms_username');
                        $bulksms_password=get_option('bulksms_password');
                        $bulksms_sender=get_option('bulksms_sender');
                        $bulksms_send_visitor_msg=get_option('bulksms_send_visitor_message');
                        $bulksms_visitor_message=get_option('bulksms_visitor_message');
                        
                        
                ?>        
                
                
                <div class="wrap">
			<h2>Bulk SMS Options</h2>

			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
				
			<table>
                            <tr>
				<td><p>Admin Mobile(without country code): </td><td><input type="text" name="bulksms_admin_mobile" value="<?php echo $bulksms_admin_mobile; ?>" size="20"> ex: 9970103544</p></td>
                                <tr>
				<td><p>Gateway URL: </td><td><input type="text" name="bulksms_gateway_domain" value="<?php echo $gateway_domain; ?>" size="30"> ex: sms.litglobal.co.in/pushsms.php</p></td>
                                <tr>
				<td><p>Username: </td><td><input type="text" name="bulksms_username" value="<?php echo $bulksms_username; ?>" size="15"> ex: myusername</p></td>
                                <tr>
                                <td><p>Password:  </td><td><input type="password" name="bulksms_password" value="<?php echo $bulksms_password; ?>" size="15"> ex: mypassword</p></td>
                                <tr>
                                <td><p>Sender ID: </td><td><input type="text" name="bulksms_sender" value="<?php echo $bulksms_sender; ?>" size="10"> ex: AKSHAY</p></td>
                                <tr>
                                <td><p>Visitor Message: </td><td>
                                <input type="checkbox" name="sendreply" onclick="if(document.getElementById('visitor_message').style.display=='block'){document.getElementById('visitor_message').style.display='none';}else{document.getElementById('visitor_message').style.display='block';}" value="sendreply"  <?php if($bulksms_send_visitor_msg==1){?> checked <?php } ?> >Send Reply to Visitor</td>
                                <tr>
                                <td></td>
                                <td><div id="visitor_message" <?php if($bulksms_send_visitor_msg==1){echo "style='position:relative; display:block;'"; }else {echo "style='position:relative; display:block;'";} ?>>
                                  <textarea name="bulksms_visitor_message"><?php echo $bulksms_visitor_message; ?></textarea>
                                </div>
                                </td>
                                <tr>
				<p class="submit">
                                <td>
				<input type="submit" name="bulksms_admin_submit" value="Save Changes" />
                                </td>
                                </tr>
                        </table>
				</p>
			</form>
		</div>
                <?php
		}
	?>
	


