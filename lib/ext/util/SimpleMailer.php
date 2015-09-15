<?php

class SimpleMailer {

/**
 * Wysyła maila korzystając z eZ. <br />
 * <b>Uwaga:</b>korzysta z ustawień aplikacji (app.yml) w celu pobrania adresu nadawcy (mail_from) 
 * oraz serwera smtp (mail_smtp). Kodowanie treści maila w utf-8!
 * @param string $to - adres email odbiorcy
 * @param strin $subject - tytuł maila
 * @param strin $bodyHtml - treść maila w formacie html
 */	
	static public function sendEmail($to, $subject, $bodyHtml) {
		try {
			sfContext :: getInstance()->getLogger()->debug("Email to: $to, subject: $subject, content: $bodyHtml");
			$mail = new ezcMailComposer();
			$mail->from = new ezcMailAddress( sfConfig :: get('app_mail_from'), "Smartpay" );
			//$mail->addTo( new ezcMailAddress( $email ) );
			$mail->addTo( new ezcMailAddress( $to ) );
			$mail->subject = $subject;
			// Create a text part to be added to the mail
			$mail->htmlText = "<html>$bodyHtml</html>";
			$mail->charset = 'utf-8';
			//$mail->plainText = "$EMAIL_BODY";
			$mail->build();
			$transport = new ezcMailTransportSmtp( sfConfig :: get('app_mail_smtp_transport_host'), sfConfig :: get('app_mail_smtp_user'), sfConfig :: get('app_mail_smtp_password') );
			$transport->send( $mail );
			//zapisanie w bazie danych
			//$this->saveEmail($login, $email, $mail->subject, $emailBodyHtml);
		}
		catch (Exception $e) {
			sfContext :: getInstance()->getLogger()->err($e->getMessage());
		}		
	}


/**
 * Wysyła maila z załącznikiem o podanej nazwie <br />
 * Dodał Adam Jakubiak 17.06.2009
 * @param string $to - adres email odbiorcy
 * @param string $subject - tytuł maila
 * @param string $bodyHtml - treść maila w formacie html
 * @param string $attPath - ścieżka do pliku na serwerze
 * @param string $attFilename - nazwa pliku załącznika
 */	
	static public function sendWithAttachment($to, $subject, $bodyHtml, $attPath, $attFilename) {
		try {
			sfContext :: getInstance()->getLogger()->debug("Email to: $to, subject: $subject, content: $bodyHtml, filepath: $attPath");
			$mail = new ezcMailComposer();
			$mail->from = new ezcMailAddress( sfConfig :: get('app_mail_from'), sfConfig :: get('app_mail_from'));
        	$mail->addTo( new ezcMailAddress($to) );
        	$mail->subject = $subject;
        	//$mail->plainText = "Można wysyłać maile NIE w formacie HTML tylko czyste";
        	$mail->htmlText = "<html>$bodyHtml</html>";
        	$mail->charset = 'utf-8';
        	// ustalam nazwę pliku załącznika (działa tylko z nowym komponentem MAIL) 
        	$contentDisposition = new ezcMailContentDispositionHeader('attachment',$attFilename);
            $contentDisposition->displayFileName = $attFilename;
            $contentDisposition->fileName = $attFilename;
        	$mail->addAttachment($attPath, null, null, null, $contentDisposition);
        	$mail->build();
        	// Ustawiam sposób wysyłki na SMTP - z parametrami przechowywanymi w app.yml
			$transport = new ezcMailTransportSmtp(sfConfig :: get('app_mail_smtp_transport_host'), sfConfig :: get('app_mail_smtp_user'), sfConfig :: get('app_mail_smtp_password'));
			$transport->send( $mail );

		}
		catch (Exception $e) {
			sfContext :: getInstance()->getLogger()->err($e->getMessage());
		}		
	}
	
}
?>