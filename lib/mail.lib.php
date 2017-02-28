<?php
class Mail
{
    public function main($subject="", $message="", $mail_address_to="", $mail_address_from="")
    {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        if($subject != '' &&  $message != '' && $mail_address_to != '' && $mail_address_from != '')
        {
            //メール送信開始
            if(mail($mail_address_to, $subject, $message, $mail_address_from)) 
            {
                //メール送信成功
                return 1;
            }
            else
            {
                //メール送信失敗 何らかのエラー
                return 0;
            }
        }
        else
        {
            //メール送信失敗 項目不備
            return 2;
        
        }
    }
}
