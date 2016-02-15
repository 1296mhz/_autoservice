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
      $subject = 'Заявка на кредит';
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
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Продажа Opel и Chevrolet</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">
<style type="text/css">
div#container
{
   width: 1000px;
   position: relative;
   margin-top: 0px;
   margin-left: auto;
   margin-right: auto;
   text-align: left;
}
body
{
   font-size: 8px;
   line-height: 1.1875;
   text-align: center;
   margin: 0;
   background-color: #DCDCDC;
   background-image: url(images/index_bkgrnd.png);
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
#Layer6
{
   background-color: #F5F5F5;
}
#Image7
{
   border: 0px #000000 solid;
}
#Layer2
{
   background-color: transparent;
   background-image: url(images/index_Layer2_bkgrnd.png);
   background-repeat: repeat;
   background-position: left top;
}
#wb_Text2 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text2 div
{
   text-align: center;
}
#wb_Text4 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text4 div
{
   text-align: center;
}
#Layer5
{
   background-color: transparent;
   background-image: url(images/index_Layer5_bkgrnd.png);
   background-repeat: repeat;
   background-position: left top;
}
#wb_Text25 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text25 div
{
   text-align: center;
}
#wb_Text26 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text26 div
{
   text-align: center;
}
#wb_Text27 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text27 div
{
   text-align: center;
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
#Image16
{
   border: 0px #000000 solid;
}
#wb_Text5 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text5 div
{
   text-align: left;
}
#Image1
{
   border: 0px #000000 solid;
}
#wb_Text10 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: right;
}
#wb_Text10 div
{
   text-align: right;
}
#Layer3
{
   background-color: #A9A9A9;
   background-image: url(images/index_Layer3_bkgrnd.png);
   background-repeat: repeat;
   background-position: left top;
}
#wb_Text3 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text3 div
{
   text-align: center;
}
#Image17
{
   border: 0px #000000 solid;
}
#Image19
{
   border: 0px #000000 solid;
}
#Image20
{
   border: 0px #000000 solid;
}
#Image21
{
   border: 0px #000000 solid;
}
#wb_Text6 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text6 div
{
   text-align: center;
}
#Image23
{
   border: 0px #000000 solid;
}
#wb_Text11 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text11 div
{
   text-align: center;
}
#wb_Text12 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text12 div
{
   text-align: center;
}
#wb_Text9 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text9 div
{
   text-align: left;
}
#Image2
{
   border: 0px #000000 solid;
}
#wb_Text13 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text13 div
{
   text-align: left;
}
#wb_Text14 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text14 div
{
   text-align: left;
}
#Image3
{
   border: 0px #000000 solid;
}
#Image4
{
   border: 0px #000000 solid;
}
#wb_Text15 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text15 div
{
   text-align: left;
}
#wb_Text16 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text16 div
{
   text-align: left;
}
#Image5
{
   border: 0px #000000 solid;
}
#wb_Text17 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text17 div
{
   text-align: center;
}
#wb_Text18 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text18 div
{
   text-align: left;
}
#wb_Text19 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text19 div
{
   text-align: center;
}
#wb_Text20 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text20 div
{
   text-align: left;
}
#wb_Text8 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text8 div
{
   text-align: left;
}
#wb_Text21 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text21 div
{
   text-align: left;
}
#wb_Text22 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text22 div
{
   text-align: center;
}
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
#Editbox3
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
#wb_Text23 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text23 div
{
   text-align: center;
}
#Image6
{
   border: 0px #000000 solid;
}
#wb_Text24 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text24 div
{
   text-align: left;
}
#wb_Text35 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text35 div
{
   text-align: left;
}
#Image11
{
   border: 0px #000000 solid;
}
#Image12
{
   border: 0px #000000 solid;
}
#wb_Text36 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text36 div
{
   text-align: left;
}
#wb_Text37 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text37 div
{
   text-align: left;
}
#Image13
{
   border: 0px #000000 solid;
}
#Image14
{
   border: 0px #000000 solid;
}
#wb_Text38 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text38 div
{
   text-align: left;
}
#wb_Text39 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text39 div
{
   text-align: left;
}
#Image15
{
   border: 0px #000000 solid;
}
#Image22
{
   border: 0px #000000 solid;
}
#wb_Text40 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text40 div
{
   text-align: left;
}
#wb_Text41 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text41 div
{
   text-align: left;
}
#Image24
{
   border: 0px #000000 solid;
}
#Image25
{
   border: 0px #000000 solid;
}
#wb_Text42 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text42 div
{
   text-align: left;
}
#wb_Text43 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text43 div
{
   text-align: left;
}
#Image26
{
   border: 0px #000000 solid;
}
#Image27
{
   border: 0px #000000 solid;
}
#wb_Text44 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text44 div
{
   text-align: left;
}
#wb_Text45 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text45 div
{
   text-align: left;
}
#Image28
{
   border: 0px #000000 solid;
}
#Image29
{
   border: 0px #000000 solid;
}
#wb_Text46 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text46 div
{
   text-align: left;
}
#wb_Text47 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text47 div
{
   text-align: left;
}
#Image30
{
   border: 0px #000000 solid;
}
#Image31
{
   border: 0px #000000 solid;
}
#wb_Text48 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text48 div
{
   text-align: left;
}
#wb_Text49 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text49 div
{
   text-align: left;
}
#Image32
{
   border: 0px #000000 solid;
}
#Image33
{
   border: 0px #000000 solid;
}
#wb_Text50 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text50 div
{
   text-align: left;
}
#wb_Text51 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text51 div
{
   text-align: left;
}
#Image34
{
   border: 0px #000000 solid;
}
#Image35
{
   border: 0px #000000 solid;
}
#wb_Text52 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text52 div
{
   text-align: left;
}
#wb_Text53 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text53 div
{
   text-align: left;
}
#Image36
{
   border: 0px #000000 solid;
}
#Image37
{
   border: 0px #000000 solid;
}
#wb_Text54 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text54 div
{
   text-align: left;
}
#wb_Text55 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text55 div
{
   text-align: left;
}
#Image38
{
   border: 0px #000000 solid;
}
#Image39
{
   border: 0px #000000 solid;
}
#wb_Text56 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text56 div
{
   text-align: left;
}
#wb_Text57 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text57 div
{
   text-align: left;
}
#Image40
{
   border: 0px #000000 solid;
}
#Image41
{
   border: 0px #000000 solid;
}
#wb_Text58 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text58 div
{
   text-align: left;
}
#wb_Text59 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text59 div
{
   text-align: left;
}
#Image42
{
   border: 0px #000000 solid;
}
#Image43
{
   border: 0px #000000 solid;
}
#wb_Text60 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text60 div
{
   text-align: left;
}
#wb_Text61 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text61 div
{
   text-align: left;
}
#Image44
{
   border: 0px #000000 solid;
}
#Image45
{
   border: 0px #000000 solid;
}
#wb_Text62 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text62 div
{
   text-align: left;
}
#wb_Text63 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text63 div
{
   text-align: left;
}
#Image46
{
   border: 0px #000000 solid;
}
#Image47
{
   border: 0px #000000 solid;
}
#wb_Text64 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text64 div
{
   text-align: left;
}
#wb_Text65 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text65 div
{
   text-align: left;
}
#Image48
{
   border: 0px #000000 solid;
}
#Image49
{
   border: 0px #000000 solid;
}
#wb_Text66 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text66 div
{
   text-align: left;
}
#wb_Text67 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text67 div
{
   text-align: left;
}
#Image50
{
   border: 0px #000000 solid;
}
#Image51
{
   border: 0px #000000 solid;
}
#wb_Text68 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text68 div
{
   text-align: left;
}
#wb_Text69 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text69 div
{
   text-align: left;
}
#Image52
{
   border: 0px #000000 solid;
}
#wb_Text70 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text70 div
{
   text-align: center;
}
#wb_Form3
{
   background-color: transparent;
   border: 0px #000000 solid;
}
#Editbox7
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
#Button2
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
#Editbox8
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
#wb_Text28 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text28 div
{
   text-align: center;
}
#wb_Text29 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text29 div
{
   text-align: center;
}
#wb_Text30 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text30 div
{
   text-align: left;
}
#wb_Text31 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text31 div
{
   text-align: left;
}
#wb_Text32 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text32 div
{
   text-align: left;
}
#wb_Text33 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text33 div
{
   text-align: left;
}
#wb_Text71 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text71 div
{
   text-align: center;
}
#PhotoGallery1
{
   border-spacing: 15px;
   width: 100%;
}
#PhotoGallery1 .figure
{
   padding: 0px 0px 0px 0px;
   text-align: center;
   vertical-align: top;
}
#PhotoGallery1 .figure img
{
   border: 0px #000000 solid;
}
#wb_Text72 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text72 div
{
   text-align: center;
}
#Image8
{
   border: 0px #000000 solid;
}
#wb_Text73 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text73 div
{
   text-align: center;
}
#wb_Text74 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text74 div
{
   text-align: center;
}
#Image9
{
   border: 0px #000000 solid;
}
#wb_Text75 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text75 div
{
   text-align: left;
}
#Image10
{
   border: 0px #000000 solid;
}
#wb_Text76 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text76 div
{
   text-align: center;
}
#Image53
{
   border: 0px #000000 solid;
}
#Image18
{
   border: 0px #000000 solid;
}
#Image54
{
   border: 0px #000000 solid;
}
</style>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="fancybox/jquery.easing-1.3.pack.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.0.css" type="text/css">
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.0.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="wwb9.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   $("a[data-rel='PhotoGallery1']").attr('rel', 'PhotoGallery1');
   $("a[rel^='PhotoGallery1']").fancybox({});
});
</script>
</head>
<body>
<div id="Layer6" style="position:absolute;text-align:center;left:0px;top:11466px;width:100%;height:134px;z-index:30;" title="">
<div id="Layer6_Container" style="width:1000px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_Text73" style="position:absolute;left:295px;top:14px;width:384px;height:87px;text-align:center;z-index:0;">
<span style="color:#000000;font-family:Tahoma;font-size:24px;">Продажа <br>и сервисное обслуживание <br>автомобилей GM в Москве</span></div>
<div id="wb_Text75" style="position:absolute;left:724px;top:16px;width:235px;height:16px;z-index:1;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:13px;">Адрес: 47 км МКАД (внешняя сторона)</span></div>
<div id="wb_Text76" style="position:absolute;left:714px;top:35px;width:246px;height:33px;text-align:center;z-index:2;">
<span style="color:#000000;font-family:Tahoma;font-size:27px;">+7 (495) 787-97-37</span></div>
<div id="wb_Image10" style="position:absolute;left:740px;top:76px;width:200px;height:35px;z-index:3;">
<a href="javascript:displaylightbox('./callback.php',{})" target="_self"><img src="images/button%20%283%29.png" id="Image10" alt="" style="width:200px;height:35px;"></a></div>
<div id="wb_Image9" style="position:absolute;left:13px;top:32px;width:240px;height:47px;z-index:4;">
<img src="images/trin.jpg" id="Image9" alt="" style="width:240px;height:47px;"></div>
<div id="wb_Text74" style="position:absolute;left:0px;top:82px;width:263px;height:36px;text-align:center;z-index:5;">
<span style="color:#000000;font-family:Tahoma;font-size:15px;"> Официальный дилер Opel и Chevrolet</span></div>
</div>
</div>
<div id="Layer5" style="position:absolute;text-align:center;left:0px;top:9893px;width:100%;height:454px;z-index:31;" title="">
<div id="Layer5_Container" style="width:1000px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_Text25" style="position:absolute;left:285px;top:37px;width:411px;height:32px;text-align:center;z-index:9;">
<span style="color:#FFFFFF;font-family:Arial;font-size:27px;"><strong>КАК МЫ РАБОТАЕМ</strong></span></div>
<div id="wb_Text27" style="position:absolute;left:507px;top:238px;width:162px;height:110px;text-align:center;z-index:10;">
<span style="color:#FFFFFF;font-family:Arial;font-size:19px;"><strong>Вы получаете по телефону приглашение в наш дилерский центр</strong></span></div>
<div id="wb_Text26" style="position:absolute;left:62px;top:234px;width:194px;height:121px;text-align:center;z-index:11;">
<span style="color:#FFFFFF;font-family:Arial;font-size:21px;"><strong>Вы отправляете нам заявку или звоните по телефону <br></strong></span><span style="color:#FFA500;font-family:Tahoma;font-size:21px;">+7 (495) 787-97-37</span></div>
<div id="wb_Text28" style="position:absolute;left:297px;top:235px;width:162px;height:88px;text-align:center;z-index:12;">
<span style="color:#FFFFFF;font-family:Arial;font-size:19px;"><strong>Заявка обрабатывается в течении часа</strong></span></div>
<div id="wb_Shape3" style="position:absolute;left:109px;top:138px;width:83px;height:78px;z-index:13;">
<img src="images/img0003.png" id="Shape3" alt="" style="border-width:0;width:83px;height:78px;"></div>
<div id="wb_Shape6" style="position:absolute;left:338px;top:134px;width:83px;height:78px;z-index:14;">
<img src="images/img0004.png" id="Shape6" alt="" style="border-width:0;width:83px;height:78px;"></div>
<div id="wb_Shape5" style="position:absolute;left:767px;top:132px;width:83px;height:78px;z-index:15;">
<img src="images/img0005.png" id="Shape5" alt="" style="border-width:0;width:83px;height:78px;"></div>
<div id="wb_Shape4" style="position:absolute;left:543px;top:131px;width:83px;height:78px;z-index:16;">
<img src="images/img0006.png" id="Shape4" alt="" style="border-width:0;width:83px;height:78px;"></div>
<div id="wb_Text30" style="position:absolute;left:370px;top:152px;width:22px;height:40px;z-index:17;text-align:left;">
<span style="color:#228B22;font-family:Arial;font-size:35px;">2</span></div>
<div id="wb_Text33" style="position:absolute;left:573px;top:149px;width:22px;height:40px;z-index:18;text-align:left;">
<span style="color:#228B22;font-family:Arial;font-size:35px;">3</span></div>
<div id="wb_Text32" style="position:absolute;left:798px;top:150px;width:22px;height:40px;z-index:19;text-align:left;">
<span style="color:#228B22;font-family:Arial;font-size:35px;">4</span></div>
<div id="wb_Text29" style="position:absolute;left:734px;top:237px;width:162px;height:44px;text-align:center;z-index:20;">
<span style="color:#FFFFFF;font-family:Arial;font-size:19px;"><strong>Бронирование автомобиля</strong></span></div>
<div id="wb_Text31" style="position:absolute;left:139px;top:153px;width:22px;height:40px;z-index:21;text-align:left;">
<span style="color:#228B22;font-family:Arial;font-size:35px;">1</span></div>
</div>
</div>
<div id="Layer3" style="position:absolute;text-align:center;left:0px;top:692px;width:100%;height:83px;z-index:32;" title="">
<div id="Layer3_Container" style="width:1000px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_Text3" style="position:absolute;left:194px;top:23px;width:568px;height:33px;text-align:center;z-index:22;">
<span style="color:#FFFFFF;font-family:Tahoma;font-size:27px;"><strong>ВАШИ ВЫГОДЫ</strong></span></div>
</div>
</div>
<div id="container">
<div id="wb_Image7" style="position:absolute;left:46px;top:9457px;width:493px;height:384px;z-index:33;">
<img src="images/calculator.gif" id="Image7" alt="" style="width:493px;height:384px;"></div>
<div id="wb_Shape1" style="position:absolute;left:629px;top:1108px;width:314px;height:371px;filter:alpha(opacity=90);-moz-opacity:0.90;opacity:0.90;z-index:34;">
<img src="images/img0001.png" id="Shape1" alt="" style="border-width:0;width:314px;height:371px;"></div>
<div id="Layer2" style="position:absolute;text-align:left;left:723px;top:8px;width:274px;height:111px;z-index:35;" title="">
<div id="wb_Text5" style="position:absolute;left:25px;top:6px;width:235px;height:16px;z-index:6;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:13px;">Адрес: 47 км МКАД (внешняя сторона)</span></div>
<div id="wb_Image1" style="position:absolute;left:41px;top:61px;width:200px;height:35px;z-index:7;">
<a href="javascript:displaylightbox('./callback.php',{})" target="_self"><img src="images/button%20%283%29.png" id="Image1" alt="" style="width:200px;height:35px;"></a></div>
<div id="wb_Text4" style="position:absolute;left:13px;top:24px;width:246px;height:33px;text-align:center;z-index:8;">
<span style="color:#000000;font-family:Tahoma;font-size:27px;">+7 (495) 787-97-37</span></div>
</div>
<div id="wb_Text2" style="position:absolute;left:311px;top:10px;width:384px;height:87px;text-align:center;z-index:36;">
<span style="color:#000000;font-family:Tahoma;font-size:24px;">Продажа <br>и сервисное обслуживание <br>автомобилей GM в Москве</span></div>
<div id="wb_Text1" style="position:absolute;left:0px;top:80px;width:263px;height:36px;text-align:center;z-index:37;">
<span style="color:#000000;font-family:Tahoma;font-size:15px;"> Официальный дилер Opel и Chevrolet</span></div>
<div id="wb_Image16" style="position:absolute;left:13px;top:32px;width:240px;height:47px;z-index:38;">
<img src="images/trin.jpg" id="Image16" alt="" style="width:240px;height:47px;"></div>
<div id="wb_Text10" style="position:absolute;left:329px;top:519px;width:140px;height:54px;text-align:right;z-index:39;">
<span style="color:#696969;font-family:Arial;font-size:24px;">ДО КОНЦА АКЦИИ:</span></div>
<div id="Html1" style="position:absolute;left:478px;top:495px;width:479px;height:91px;z-index:40">
<script type="text/javascript" src="http://www.timegenerator.ru/s/85f5fdec44f76446eb35509085ffd285.js"></script></div>
<div id="wb_Image17" style="position:absolute;left:443px;top:808px;width:64px;height:64px;z-index:41;">
<img src="images/64Px%20-%20141.png" id="Image17" alt="" style="width:64px;height:64px;"></div>
<div id="wb_Image19" style="position:absolute;left:143px;top:809px;width:64px;height:64px;z-index:42;">
<img src="images/64Px%20-%20207.png" id="Image19" alt="" style="width:64px;height:64px;"></div>
<div id="wb_Image20" style="position:absolute;left:132px;top:1097px;width:64px;height:64px;z-index:43;">
<img src="images/64Px%20-%20342.png" id="Image20" alt="" style="width:64px;height:64px;"></div>
<div id="wb_Image21" style="position:absolute;left:443px;top:1099px;width:64px;height:64px;z-index:44;">
<img src="images/64Px%20-%20450.png" id="Image21" alt="" style="width:64px;height:64px;"></div>
<div id="wb_Text6" style="position:absolute;left:84px;top:884px;width:180px;height:52px;text-align:center;z-index:45;">
<span style="color:#696969;font-family:Tahoma;font-size:21px;"><strong>Официальный дилер</strong></span><span style="color:#228B22;font-family:Tahoma;font-size:21px;"> <br></span></div>
<div id="wb_Image23" style="position:absolute;left:776px;top:811px;width:64px;height:64px;z-index:46;">
<img src="images/64Px%20-%20386.png" id="Image23" alt="" style="width:64px;height:64px;"></div>
<div id="wb_Text11" style="position:absolute;left:489px;top:888px;width:653px;height:50px;text-align:center;z-index:47;">
<span style="color:#696969;font-family:Tahoma;font-size:21px;"><strong>Полный комплекс<br>услуг</strong></span><span style="color:#228B22;font-family:Tahoma;font-size:21px;"> </span></div>
<div id="wb_Text12" style="position:absolute;left:82px;top:1180px;width:165px;height:50px;text-align:center;z-index:48;">
<span style="color:#696969;font-family:Tahoma;font-size:21px;"><strong>Технический центр</strong></span></div>
<div id="wb_Text9" style="position:absolute;left:376px;top:1273px;width:219px;height:114px;z-index:49;text-align:left;">
<span style="color:#228B22;font-family:Tahoma;font-size:16px;">Мы работаем для того, чтобы покупка и дальнейшая эксплуатация автомобилей популярных марок Opel и Chevrolet вдохновляла Вас</span></div>
<div id="wb_Image2" style="position:absolute;left:4px;top:1678px;width:480px;height:270px;z-index:50;">
<img src="images/Captiva_Carbon_Flash.png" id="Image2" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text13" style="position:absolute;left:518px;top:1699px;width:362px;height:35px;z-index:51;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;"> Chevrolet Captiva</span></div>
<div id="wb_Text14" style="position:absolute;left:529px;top:1747px;width:381px;height:156px;z-index:52;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUCG26UJD0001352<br>Тип кузова: w<br>Комплектация, двигатель: LS, 2,4 МТ<br>Цвет: GAR-CARBON FLASH MET (G)<br>Объём двигателя: 2400<br>Цена по прайсу: 1 125 000 руб<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 109 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 1 016 000 руб</span></div>
<div id="wb_Image3" style="position:absolute;left:581px;top:1920px;width:137px;height:40px;z-index:53;">
<a href="javascript:displaylightbox('./captiva.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image3" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image4" style="position:absolute;left:12px;top:2002px;width:480px;height:270px;z-index:54;">
<img src="images/Cobalt_Sovereign_Silver.png" id="Image4" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text15" style="position:absolute;left:532px;top:2023px;width:327px;height:70px;z-index:55;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Cobalt Sovereign Silver</span></div>
<div id="wb_Text16" style="position:absolute;left:533px;top:2110px;width:381px;height:175px;z-index:56;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBJF69VJEA010877<br>Тип кузова: 4<br>Комплектация, двигатель: LT, 1,5 МТ<br>Цвет: GAN-SOVEREIGN SILVER MET (G)<br>Доп. опции, пакеты: C60, XYAY<br>Объём двигателя: 1500<br>Цена по прайсу: 527 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 70 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 457 000 руб</span></div>
<div id="wb_Image5" style="position:absolute;left:578px;top:2305px;width:137px;height:40px;z-index:57;">
<a href="javascript:displaylightbox('./cobalt_silver.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image5" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Text17" style="position:absolute;left:178px;top:1539px;width:636px;height:84px;text-align:center;z-index:58;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Остались последние автомобили 2013 года выпуска с максимальными выгодами!</span></div>
<div id="wb_Text18" style="position:absolute;left:94px;top:952px;width:191px;height:95px;z-index:59;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;"> </span><span style="color:#228B22;font-family:Tahoma;font-size:16px;">Мы обеспечим Вам выгодные <br>и надежные условия приобретения автомобилей</span></div>
<div id="wb_Text19" style="position:absolute;left:387px;top:885px;width:180px;height:52px;text-align:center;z-index:60;">
<span style="color:#696969;font-family:Tahoma;font-size:21px;"><strong>100% <br>гарантия</strong></span><span style="color:#228B22;font-family:Tahoma;font-size:21px;"><br></span></div>
<div id="wb_Text20" style="position:absolute;left:390px;top:949px;width:195px;height:129px;z-index:61;text-align:left;">
<span style="color:#228B22;font-family:Tahoma;font-size:16px;"> Мы гарантируем нашим клиентам высокий уровень обслуживания и отличное качество всех производимых работ<br></span><span style="color:#000000;font-family:Calibri;font-size:15px;"><br></span></div>
<div id="wb_Text8" style="position:absolute;left:725px;top:953px;width:178px;height:133px;z-index:62;text-align:left;">
<span style="color:#228B22;font-family:Tahoma;font-size:16px;">Кредитование, страхование, удаленное урегулирование убытков, а также обмен старого автомобиля на новый</span></div>
<div id="wb_Text21" style="position:absolute;left:59px;top:1247px;width:231px;height:225px;z-index:63;text-align:left;">
<span style="color:#228B22;font-family:Arial;font-size:16px;">Мы</span><span style="color:#228B22;font-family:Tahoma;font-size:16px;"> предлагаем широкий спектр услуг по техническому обслуживанию любой степени сложности: от диагностики до ремонта автомобилей. Мы гарантируем не только качественный ремонт в самые короткие сроки, но и специальные условия, а также скидки для постоянных клиентов</span><span style="color:#000000;font-family:Arial;font-size:13px;"><br></span></div>
<div id="wb_Text22" style="position:absolute;left:337px;top:1179px;width:287px;height:75px;text-align:center;z-index:64;">
<span style="color:#696969;font-family:Tahoma;font-size:21px;"><strong>Максимум<br>положительных <br>эмоций</strong></span></div>
<div id="wb_Form1" style="position:absolute;left:634px;top:1238px;width:303px;height:228px;z-index:65;">
<form name="Form1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">
<input type="text" id="Editbox1" style="position:absolute;left:35px;top:14px;width:220px;height:35px;line-height:35px;z-index:23;" name="Editbox1" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;">
<input type="submit" id="Button1" name="" value="" style="position:absolute;left:35px;top:164px;width:241px;height:51px;z-index:24;">
<input type="text" id="Editbox2" style="position:absolute;left:35px;top:63px;width:220px;height:36px;line-height:36px;z-index:25;" name="Editbox2" value="" placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;">
<input type="text" id="Editbox3" style="position:absolute;left:35px;top:112px;width:220px;height:35px;line-height:35px;z-index:26;" name="Editbox3" value="" placeholder="&#1042;&#1072;&#1096; email">
</form>
</div>
<div id="wb_Text23" style="position:absolute;left:652px;top:1129px;width:275px;height:94px;text-align:center;z-index:66;">
<span style="color:#000000;font-family:Tahoma;font-size:19px;">Чтобы оформить <br></span><span style="color:#228B22;font-family:Tahoma;font-size:27px;">ЗАЯВКУ НА КРЕДИТ</span><span style="color:#000000;font-family:Tahoma;font-size:19px;">, <br></span><span style="color:#000000;font-family:Tahoma;font-size:16px;">заполните форму и нажмите &quot;Отправить заявку&quot;</span></div>
<div id="wb_Image6" style="position:absolute;left:7px;top:2350px;width:480px;height:270px;z-index:67;">
<img src="images/Cobalt_Smoke_Beige.png" id="Image6" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text24" style="position:absolute;left:523px;top:2387px;width:362px;height:70px;z-index:68;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Cobalt<br>Smokey Beige</span></div>
<div id="wb_Text35" style="position:absolute;left:527px;top:2484px;width:381px;height:175px;z-index:69;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBJF69VJEA049047<br>Тип кузова: 4<br>Комплектация, двигатель: LT, 1,5 МТ<br>Доп. опции, пакеты: C60<br>Цвет: G6J-SMOKEY BEIGE<br>Объём двигателя: 1500<br>Цена по прайсу: 507 000 руб<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 70 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 437 000 руб</span></div>
<div id="wb_Image11" style="position:absolute;left:573px;top:2669px;width:137px;height:40px;z-index:70;">
<a href="javascript:displaylightbox('./cobalt_beige.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image11" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image12" style="position:absolute;left:13px;top:2752px;width:480px;height:270px;z-index:71;">
<img src="images/Cobalt_Carbon_Flash.png" id="Image12" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text36" style="position:absolute;left:524px;top:2773px;width:362px;height:70px;z-index:72;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Cobalt<br>Carbon Flash Met</span></div>
<div id="wb_Text37" style="position:absolute;left:528px;top:2861px;width:381px;height:175px;z-index:73;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBJF69VJEA010877<br>Тип кузова: 4<br>Комплектация, двигатель: LT, 1,5 МТ<br>Цвет: GAR-CARBON FLASH MET (G)<br>Доп. опции, пакеты: C60, XYAY<br>Объём двигателя: 1500<br>Цена по прайсу: 527 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 70 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 457 000 руб</span></div>
<div id="wb_Image13" style="position:absolute;left:569px;top:3061px;width:137px;height:40px;z-index:74;">
<a href="javascript:displaylightbox('./cobalt_carbon.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image13" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image14" style="position:absolute;left:20px;top:3136px;width:480px;height:270px;z-index:75;">
<img src="images/Cobalt_Misty_Lake.png" id="Image14" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text38" style="position:absolute;left:531px;top:3157px;width:362px;height:70px;z-index:76;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Cobalt<br>Misty Lake Met</span></div>
<div id="wb_Text39" style="position:absolute;left:535px;top:3245px;width:381px;height:175px;z-index:77;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBJF69VJEA030432<br>Тип кузова: 4<br>Комплектация, двигатель: LT, 1,5 МТ<br>Цвет: GCW-MISTY LAKE MET (G)<br>Доп. опции, пакеты: C60, XYAY<br>Объём двигателя: 1500<br>Цена по прайсу: 527 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 70 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 457 000 руб</span></div>
<div id="wb_Image15" style="position:absolute;left:576px;top:3445px;width:137px;height:40px;z-index:78;">
<a href="javascript:displaylightbox('./cobalt_misty.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image15" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image22" style="position:absolute;left:20px;top:3539px;width:472px;height:285px;z-index:79;">
<img src="images/Malibu_Smoke_Grey.jpg" id="Image22" alt="" style="width:472px;height:285px;"></div>
<div id="wb_Text40" style="position:absolute;left:531px;top:3560px;width:225px;height:35px;z-index:80;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Malibu</span></div>
<div id="wb_Text41" style="position:absolute;left:533px;top:3619px;width:381px;height:175px;z-index:81;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUGA69U9C0000457<br>Тип кузова: 4<br>Комплектация, двигатель: LS, 2,4 АТ<br>Цвет: GUE-SMOKE GREY/CITY GREY<br>Доп. опции, пакеты: UD7, XFMW<br>Объём двигателя: 2400<br>Цена по прайсу: 1 030 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 120 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: 910 000 руб</span></div>
<div id="wb_Image24" style="position:absolute;left:572px;top:3823px;width:137px;height:40px;z-index:82;">
<a href="javascript:displaylightbox('./malibu.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image24" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image25" style="position:absolute;left:19px;top:3948px;width:480px;height:270px;z-index:83;">
<img src="images/Orlando_Carbon_Flash.png" id="Image25" alt="" style="width:480px;height:270px;"></div>
<div id="wb_Text42" style="position:absolute;left:530px;top:3960px;width:243px;height:35px;z-index:84;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Orlando</span></div>
<div id="wb_Text43" style="position:absolute;left:534px;top:4021px;width:338px;height:156px;z-index:85;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUYA75YJE0000309<br>Тип кузова: w<br>Комплектация, двигатель: LTZ, 2,0 АТ<br>Цвет: GAR-CARBON FLASH MET (G)<br>Объём двигателя: 2000<br>Цена по прайсу: 1 122 500 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 95 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">1 027 500</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image26" style="position:absolute;left:569px;top:4211px;width:137px;height:40px;z-index:86;">
<a href="javascript:displaylightbox('./orlando.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image26" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image27" style="position:absolute;left:0px;top:4299px;width:600px;height:310px;z-index:87;">
<img src="images/Spark_White.png" id="Image27" alt="" style="width:600px;height:310px;"></div>
<div id="wb_Text44" style="position:absolute;left:531px;top:4311px;width:243px;height:70px;z-index:88;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Spark<br>White</span></div>
<div id="wb_Text45" style="position:absolute;left:534px;top:4407px;width:338px;height:156px;z-index:89;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBMA481JEA518946<br>Тип кузова: 5<br>Комплектация, двигатель: Base, 1,0 АТ<br>Цвет: GAZ-WHITE (G)<br>Объём двигателя: 1000<br>Цена по прайсу: 474 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 75 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">399 000</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image28" style="position:absolute;left:570px;top:4588px;width:137px;height:40px;z-index:90;">
<a href="javascript:displaylightbox('./spark_white.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image28" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image29" style="position:absolute;left:0px;top:4685px;width:600px;height:310px;z-index:91;">
<img src="images/Spark_Sovereign_Silver.png" id="Image29" alt="" style="width:600px;height:310px;"></div>
<div id="wb_Text46" style="position:absolute;left:531px;top:4697px;width:243px;height:70px;z-index:92;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Spark<br>Sovereign Silver</span></div>
<div id="wb_Text47" style="position:absolute;left:534px;top:4793px;width:338px;height:156px;z-index:93;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBMA481JEA522631<br>Тип кузова: 5<br>Комплектация, двигатель: Base, 1,0 АТ<br>Цвет: GAN-SOVEREIGN SILVER MET (G)<br>Объём двигателя: 1000<br>Цена по прайсу: 481 500 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 75 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">406 500</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image30" style="position:absolute;left:570px;top:4974px;width:137px;height:40px;z-index:94;">
<a href="javascript:displaylightbox('./spark_silver.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image30" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image31" style="position:absolute;left:0px;top:5079px;width:600px;height:310px;z-index:95;">
<img src="images/Spark_Super_Red.png" id="Image31" alt="" style="width:600px;height:310px;"></div>
<div id="wb_Text48" style="position:absolute;left:531px;top:5091px;width:243px;height:70px;z-index:96;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Spark<br>Super Red</span></div>
<div id="wb_Text49" style="position:absolute;left:534px;top:5187px;width:338px;height:156px;z-index:97;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBMA481JEA507594<br>Тип кузова: 5<br>Комплектация, двигатель: Base, 1,0 АТ<br>Цвет: GGE-SUPER RED (G)<br>Объём двигателя: 1000<br>Цена по прайсу: 533 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 75 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">458 000</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image32" style="position:absolute;left:570px;top:5368px;width:137px;height:40px;z-index:98;">
<a href="javascript:displaylightbox('./spark_red.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image32" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image33" style="position:absolute;left:0px;top:5456px;width:600px;height:310px;z-index:99;">
<img src="images/Spark_Moroccan_Blue.png" id="Image33" alt="" style="width:600px;height:310px;"></div>
<div id="wb_Text50" style="position:absolute;left:531px;top:5468px;width:243px;height:70px;z-index:100;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Chevrolet Spark<br>Moroccan Blue</span></div>
<div id="wb_Text51" style="position:absolute;left:534px;top:5564px;width:338px;height:156px;z-index:101;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWBMA481JDA574474<br>Тип кузова: 5<br>Комплектация, двигатель: Base, 1,0 АТ<br>Цвет: GCT-MOROCCAN BLUE MET (G)<br>Объём двигателя: 1000<br>Цена по прайсу: 541 500 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 75 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">466 500</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image34" style="position:absolute;left:570px;top:5745px;width:137px;height:40px;z-index:102;">
<a href="javascript:displaylightbox('./spark_blue.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image34" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image35" style="position:absolute;left:0px;top:5840px;width:555px;height:272px;z-index:103;">
<img src="images/Astra%20GTC_SCULPTURE%20BRONZE.png" id="Image35" alt="" style="width:555px;height:272px;"></div>
<div id="wb_Text52" style="position:absolute;left:531px;top:5853px;width:243px;height:70px;z-index:104;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Astra GTC <br>Sculpture Bronze</span></div>
<div id="wb_Text53" style="position:absolute;left:534px;top:5949px;width:351px;height:175px;z-index:105;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWFPF2DZ1D0021035<br>Тип кузова: 3<br>Комплектация, двигатель: Sport, 1,6 АТ (XHT)<br>Цвет: GWE-SCULPTURE BRONZE<br>Доп. опции/пакеты: J71, LP4G, TSQ<br>Объём двигателя: 1600<br>Цена по прайсу: 1 006 500 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 110 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">896</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">500</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image36" style="position:absolute;left:564px;top:6152px;width:137px;height:40px;z-index:106;">
<a href="javascript:displaylightbox('./astra_bronze.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image36" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image37" style="position:absolute;left:0px;top:6243px;width:545px;height:272px;z-index:107;">
<img src="images/Astra%20GTC_Phantom_Grey.png" id="Image37" alt="" style="width:545px;height:272px;"></div>
<div id="wb_Text54" style="position:absolute;left:531px;top:6256px;width:243px;height:70px;z-index:108;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Astra GTC <br>Phantom Grey</span></div>
<div id="wb_Text55" style="position:absolute;left:534px;top:6352px;width:351px;height:175px;z-index:109;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWFPF2DP1D0018451<br>Тип кузова: 3<br>Комплектация, двигатель: Sport, 2,0 АТ (DTJ)<br>Цвет: GWH-PHANTOM GREY MET (169V)<br>Доп. опции/пакеты: A8Z, J71, TSQ<br>Объём двигателя: 2000<br>Цена по прайсу: 970 500 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 110 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">860</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">500</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image38" style="position:absolute;left:564px;top:6555px;width:137px;height:40px;z-index:110;">
<a href="javascript:displaylightbox('./astra_grey.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image38" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image39" style="position:absolute;left:0px;top:6666px;width:541px;height:263px;z-index:111;">
<img src="images/Astra%20OPC_Carbon_Flash.png" id="Image39" alt="" style="width:541px;height:263px;"></div>
<div id="wb_Text56" style="position:absolute;left:531px;top:6657px;width:243px;height:70px;z-index:112;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Astra GTC <br>Carbon Flash</span></div>
<div id="wb_Text57" style="position:absolute;left:534px;top:6753px;width:371px;height:213px;z-index:113;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWFPF2ES1D0018947<br>Тип кузова: 3<br>Комплектация, двигатель: OPC, 2,0 МТ <br>(NFT) S&amp;S<br>Цвет: GAR-CARBON FLASH MET (G)<br>Доп. опции/пакеты: C32, HME, LPCJ, <br>LPCK, RUQ, UPH<br>Объём двигателя: 2000<br>Цена по прайсу: 1 394 200 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 110 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">1</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">284</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">200</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image40" style="position:absolute;left:560px;top:6999px;width:137px;height:40px;z-index:114;">
<a href="javascript:displaylightbox('./astra_carbon.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image40" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image41" style="position:absolute;left:0px;top:7134px;width:527px;height:246px;z-index:115;">
<img src="images/Zafira%20Tourer_Sovereign_Silver.png" id="Image41" alt="" style="width:527px;height:246px;"></div>
<div id="wb_Text58" style="position:absolute;left:531px;top:7101px;width:243px;height:70px;z-index:116;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Zafira Tourer<br>Sovereign Silver</span></div>
<div id="wb_Text59" style="position:absolute;left:534px;top:7197px;width:371px;height:175px;z-index:117;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XWFPE9DC1E0000499<br>Тип кузова: w<br>Комплектация, двигатель: Cosmo, 1,4 АТ (NET)<br>Цвет: GAN-SOVEREIGN SILVER MET (G)<br>Доп. опции/пакеты: LPOU, PZK<br>Объём двигателя: 1400<br>Цена по прайсу: 1 220 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 115 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">1</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">105</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">000</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image42" style="position:absolute;left:560px;top:7405px;width:137px;height:40px;z-index:118;">
<a href="javascript:displaylightbox('./zafira_silver.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image42" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image43" style="position:absolute;left:0px;top:7525px;width:571px;height:259px;z-index:119;">
<img src="images/Mokka_Orange_Rock.png" id="Image43" alt="" style="width:571px;height:259px;"></div>
<div id="wb_Text60" style="position:absolute;left:531px;top:7503px;width:243px;height:70px;z-index:120;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Mokka<br>Orange Rock</span></div>
<div id="wb_Text61" style="position:absolute;left:534px;top:7599px;width:390px;height:175px;z-index:121;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUJC7D51E0003263<br>Тип кузова: w<br>Комплектация, двигатель: Enjoy, 1,8 АТ (XER) AWD<br>Цвет: G6V-ORANGE ROCK (357X)<br>Доп. опции/пакеты: OGD, UFW<br>Объём двигателя: 1800<br>Цена по прайсу: 1 010 900 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 50 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">960</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">900</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image44" style="position:absolute;left:560px;top:7807px;width:137px;height:40px;z-index:122;">
<a href="javascript:displaylightbox('./mokka_orange1.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image44" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image45" style="position:absolute;left:0px;top:7941px;width:557px;height:253px;z-index:123;">
<img src="images/Mokka_Velvet_Red.png" id="Image45" alt="" style="width:557px;height:253px;"></div>
<div id="wb_Text62" style="position:absolute;left:531px;top:7910px;width:243px;height:70px;z-index:124;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Mokka<br>Velvet Red</span></div>
<div id="wb_Text63" style="position:absolute;left:534px;top:8006px;width:390px;height:175px;z-index:125;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUJC7D51E0003492<br>Тип кузова: w<br>Комплектация, двигатель: Enjoy, 1,8 АТ (XER) AWD<br>Цвет: GCS-VELVET RED MET (G)<br>Доп. опции/пакеты: OGD, UFW<br>Объём двигателя: 1800<br>Цена по прайсу: 1 005 900 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 50 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">955</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">900</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image46" style="position:absolute;left:560px;top:8214px;width:137px;height:40px;z-index:126;">
<a href="javascript:displaylightbox('./mokka_red.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image46" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image47" style="position:absolute;left:0px;top:8340px;width:556px;height:254px;z-index:127;">
<img src="images/Mokka_Carbon_Flash.png" id="Image47" alt="" style="width:556px;height:254px;"></div>
<div id="wb_Text64" style="position:absolute;left:531px;top:8315px;width:243px;height:70px;z-index:128;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Mokka<br>Carbon Flash</span></div>
<div id="wb_Text65" style="position:absolute;left:534px;top:8411px;width:390px;height:175px;z-index:129;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUJC7D51E0002822<br>Тип кузова: w<br>Комплектация, двигатель: Enjoy, 1,8 АТ (XER) AWD<br>Цвет: GAR-CARBON FLASH MET (G)<br>Доп. опции/пакеты: OGD<br>Объём двигателя: 1800<br>Цена по прайсу: 993 900 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 50 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">943</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">900</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image48" style="position:absolute;left:560px;top:8619px;width:137px;height:40px;z-index:130;">
<a href="javascript:displaylightbox('./mokka_carbon.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image48" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image49" style="position:absolute;left:0px;top:8726px;width:557px;height:253px;z-index:131;">
<img src="images/Mokka_Boracay_Blue.png" id="Image49" alt="" style="width:557px;height:253px;"></div>
<div id="wb_Text66" style="position:absolute;left:531px;top:8711px;width:243px;height:70px;z-index:132;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Mokka<br>Boracay Blue</span></div>
<div id="wb_Text67" style="position:absolute;left:534px;top:8807px;width:390px;height:175px;z-index:133;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUJD7D51E0003424<br>Тип кузова: w<br>Комплектация, двигатель: Cosmo, 1,8 АТ (XER) AWD<br>Цвет: GQM-BORACAY BLUE MET<br>Объём двигателя: 1800<br>Цена по прайсу: 1 062 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 50 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">1</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">012</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">000</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image50" style="position:absolute;left:558px;top:8993px;width:137px;height:40px;z-index:134;">
<a href="javascript:displaylightbox('./mokka_blue.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image50" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Image51" style="position:absolute;left:0px;top:9094px;width:533px;height:253px;z-index:135;">
<img src="images/Mokka_Orange_Rock.png" id="Image51" alt="" style="width:533px;height:253px;"></div>
<div id="wb_Text68" style="position:absolute;left:531px;top:9087px;width:243px;height:70px;z-index:136;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Opel Mokka<br>Orange Rock</span></div>
<div id="wb_Text69" style="position:absolute;left:534px;top:9183px;width:390px;height:156px;z-index:137;text-align:left;">
<span style="color:#000000;font-family:Tahoma;font-size:16px;">VIN: XUUJD7D51E0003796<br>Тип кузова: w<br>Комплектация, двигатель: Cosmo, 1,8 МТ (XER)<br>Цвет: G6V-ORANGE ROCK (357X)<br>Объём двигателя: 1800<br>Цена по прайсу: 935 000 рублей<br></span><span style="color:#FF0000;font-family:Tahoma;font-size:16px;">Действующая скидка: 50 000 руб</span><span style="color:#000000;font-family:Tahoma;font-size:16px;"><br></span><span style="color:#000000;font-family:Tahoma;font-size:19px;">Цена с учётом скидки: </span><span style="color:#000000;font-family:Arial;font-size:19px;">885</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> </span><span style="color:#000000;font-family:Arial;font-size:19px;">000</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"> руб</span></div>
<div id="wb_Image52" style="position:absolute;left:558px;top:9369px;width:137px;height:40px;z-index:138;">
<a href="javascript:displaylightbox('./mokka_orange2.php',{})" target="_self"><img src="images/button%20%286%29.png" id="Image52" alt="" style="width:137px;height:40px;"></a></div>
<div id="wb_Shape2" style="position:absolute;left:537px;top:9476px;width:314px;height:333px;filter:alpha(opacity=90);-moz-opacity:0.90;opacity:0.90;z-index:139;">
<img src="images/img0002.png" id="Shape2" alt="" style="border-width:0;width:314px;height:333px;"></div>
<div id="wb_Text70" style="position:absolute;left:558px;top:9493px;width:276px;height:131px;text-align:center;z-index:140;">
<span style="color:#000000;font-family:Tahoma;font-size:19px;">Отправить заявку на <br></span><span style="color:#228B22;font-family:Tahoma;font-size:27px;">оценку своего старого автомобиля</span><span style="color:#000000;font-family:Tahoma;font-size:19px;"><br>(в зачёт нового)<br></span></div>
<div id="wb_Form3" style="position:absolute;left:542px;top:9606px;width:303px;height:177px;z-index:141;">
<form name="Form1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form3">
<input type="text" id="Editbox7" style="position:absolute;left:35px;top:14px;width:220px;height:35px;line-height:35px;z-index:27;" name="Editbox1" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;">
<input type="submit" id="Button2" name="" value="" style="position:absolute;left:40px;top:116px;width:241px;height:51px;z-index:28;">
<input type="text" id="Editbox8" style="position:absolute;left:35px;top:63px;width:220px;height:36px;line-height:36px;z-index:29;" name="Editbox2" value="" placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;">
</form>
</div>
<div id="wb_Text71" style="position:absolute;left:178px;top:10403px;width:613px;height:70px;text-align:center;z-index:142;">
<span style="color:#000000;font-family:Tahoma;font-size:29px;">Сотрудники отдела продаж и сервиса постоянно проходят обучение у Импортера!</span></div>
<div id="wb_PhotoGallery1" style="position:absolute;left:170px;top:10506px;width:624px;height:482px;z-index:143;">
<table id="PhotoGallery1">
   <tr>
      <td class="figure" style="width:289px;height:452px">
      <a href="images/svid3.jpg" data-rel="PhotoGallery1" title="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Chevrolet"><img alt="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Chevrolet" title="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Chevrolet" src="images/svid3.jpg" style="width:289px;height:388px;"></a>
      </td>
      <td class="figure" style="width:289px;height:452px">
      <a href="images/svid4.jpg" data-rel="PhotoGallery1" title="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Opel"><img alt="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Opel" title="&#1057;&#1074;&#1080;&#1076;&#1077;&#1090;&#1077;&#1083;&#1100;&#1089;&#1090;&#1074;&#1086; &#1086;&#1092;&#1080;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1076;&#1080;&#1083;&#1077;&#1088;&#1072; Opel" src="images/svid4.jpg" style="width:289px;height:387px;"></a>
      </td>
   </tr>
</table>
</div>
<div id="wb_Text72" style="position:absolute;left:178px;top:11005px;width:613px;height:64px;text-align:center;z-index:144;">
<span style="color:#228B22;font-family:Tahoma;font-size:29px;">Мы находимся по адресу:<br></span><span style="color:#000000;font-family:Tahoma;font-size:24px;">г. Москва, 47 км МКАД (внешняя сторона), ст1а</span></div>
<div id="wb_Image8" style="position:absolute;left:245px;top:10977px;width:64px;height:64px;z-index:145;">
<img src="images/64Px%20-%20196.png" id="Image8" alt="" style="width:64px;height:64px;"></div>
<div id="Html2" style="position:absolute;left:189px;top:11128px;width:573px;height:131px;z-index:146">
<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=9-MSCl41zwoubkeAl2OmIJJeSdHvikPL&width=600&height=291"></script></div>
<div id="wb_Image53" style="position:absolute;left:21px;top:120px;width:940px;height:347px;z-index:147;">
<img src="images/main.jpg" id="Image53" alt="" style="width:940px;height:347px;"></div>
<div id="wb_Image18" style="position:absolute;left:601px;top:611px;width:216px;height:35px;z-index:148;">
<a href="javascript:displaylightbox('./zayavka.php',{})" target="_self"><img src="images/button%20%287%29.png" id="Image18" alt="" style="width:216px;height:35px;"></a></div>
<div id="wb_Image54" style="position:absolute;left:21px;top:479px;width:285px;height:188px;z-index:149;">
<img src="images/last.jpg" id="Image54" alt="" style="width:285px;height:188px;"></div>
</div>
</body>
</html>