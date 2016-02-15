<?php
   function ValidateEmail($email)
   {
      $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
      return preg_match($pattern, $email);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $mailto = 'sales@mkad47.ru';
      $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
      $subject = 'Заявка (Opel Astra GTC Phantom Grey)';
      $message = 'Values submitted from web site form:';
      $success_url = './form-ok.php';
      $error_url = '';
      $error = '';
      $eol = "\r\n";
      $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
      $boundary = md5(uniqid(time()));

      $header  = 'From: '.$mailfrom.$eol;
      $header .= 'Reply-To: '.$mailfrom.$eol;
      $header .= 'MIME-Version: 1.0'.$eol;
      $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
      $header .= 'X-Mailer: PHP v'.phpversion().$eol;
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address is invalid!\n<br>";
      }

      if (!empty($error))
      {
         $errorcode = file_get_contents($error_url);
         $replace = "##error##";
         $errorcode = str_replace($replace, $error, $errorcode);
         echo $errorcode;
         exit;
      }

      $internalfields = array ("submit", "reset", "send", "captcha_code");
      $message .= $eol;
      $message .= "IP Address : ";
      $message .= $_SERVER['REMOTE_ADDR'];
      $message .= $eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (!is_array($value))
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
            else
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
         }
      }

      $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
      $body .= '--'.$boundary.$eol;
      $body .= 'Content-Type: text/plain; charset=ISO-8859-1'.$eol;
      $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $body .= $eol.stripslashes($message).$eol;
      if (!empty($_FILES))
      {
          foreach ($_FILES as $key => $value)
          {
             if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize)
             {
                $body .= '--'.$boundary.$eol;
                $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
                $body .= 'Content-Transfer-Encoding: base64'.$eol;
                $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
                $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
             }
         }
      }
      $body .= '--'.$boundary.'--'.$eol;
      if ($mailto != '')
      {
         mail($mailto, $subject, $body, $header);
      }
      header('Location: '.$success_url);
      exit;
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Page</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">
<style type="text/css">
body
{
   margin: 0;
   padding: 0;
   background-color: #F0FFF0;
   color: #000000;
}
</style>
<style type="text/css">
a
{
   color: #0000FF;
   text-decoration: underline;
}
a:visited
{
   color: #800080;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #0000FF;
   text-decoration: underline;
}
</style>
<link href="http://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<style type="text/css">
#wb_Form1
{
   background-color: transparent;
   border: 0px #000000 solid;
}
#Editbox1
{
   border: 1px #246187 solid;
   -moz-border-radius: 3px;
   -webkit-border-radius: 3px;
   border-radius: 3px;
   background-color: #FFFFFF;
   color :#696969;
   font-family: 'PT Sans';
   font-size: 16px;
   padding: 0px 0px 0px 10px;
   text-align: left;
   vertical-align: middle;
}
#Button1
{
   border: 0px #A9A9A9 solid;
   background-color: transparent;
   background-image: url(images/button%20%285%29.png);
   background-repeat: no-repeat;
   background-position: left top;
   color: #000000;
   font-family: Arial;
   font-size: 13px;
}
#Editbox2
{
   border: 1px #246187 solid;
   -moz-border-radius: 3px;
   -webkit-border-radius: 3px;
   border-radius: 3px;
   background-color: #FFFFFF;
   color :#696969;
   font-family: 'PT Sans';
   font-size: 16px;
   padding: 0px 0px 0px 10px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text1 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text1 div
{
   text-align: center;
}
</style>
</head>
<body>

<div id="wb_Shape10" style="position:absolute;left:42px;top:28px;width:480px;height:288px;z-index:4;">
<img src="images/img0024.png" id="Shape10" alt="" style="border-width:0;width:480px;height:288px;"></div>
<div id="wb_Form1" style="position:absolute;left:119px;top:133px;width:325px;height:172px;z-index:5;">
<form name="Form1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">
<input type="text" id="Editbox1" style="position:absolute;left:44px;top:14px;width:220px;height:35px;line-height:35px;z-index:0;" name="Editbox1" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;">
<input type="submit" id="Button1" name="" value="" style="position:absolute;left:44px;top:117px;width:236px;height:51px;z-index:1;">
<input type="text" id="Editbox2" style="position:absolute;left:43px;top:65px;width:220px;height:36px;line-height:36px;z-index:2;" name="Editbox2" value="" placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;">
</form>
</div>
<div id="wb_Text1" style="position:absolute;left:111px;top:49px;width:365px;height:66px;text-align:center;z-index:6;">
<span style="color:#228B22;font-family:Tahoma;font-size:27px;">Заявка на Opel Astra GTC <br>Phantom Grey</span></div>
</body>
</html>