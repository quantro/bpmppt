<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Welcome to <?php echo get_app_config('skpd_name') ?>!</h2>
Thanks for joining <?php echo get_app_config('skpd_name') ?>. We listed your sign in details below, make sure you keep them safe.<br/>
To verify your email address, please follow this link:<br/>
<br/>
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">Finish your registration...</a></b></big><br/>
<br/>
Link doesn't work? Copy the following link to your browser address bar:<br/>
<nobr><a href="<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?></a></nobr><br/>
<br/>
Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.<br/>
<br/>
<br/>
<?php if (strlen($username) > 0) { ?>Your username: <?php echo $username; ?><br/><?php } ?>
Your email address: <?php echo $email; ?><br/>
<?php if (isset($password)) { /* ?>Your password: <?php echo $password; ?><br/><?php */ } ?>
