<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

// @todo Autoloading
require_once 'lib/PhpMailer/PhpMailer.php';

/**
 * Handles delivery of email.
 * 
 * @note
 *  This class is basically a wrapper for PHP Mailer. In order
 *   to make this class work, you need to copy PHPMailer into "lib/PhpMailer/".
 * 
 * @uses        PHP Mailer
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Email_Mailer {
    
    const CR = "\r\n";
    
    private $_encoding = 'iso-8859-1';
    
    /** @var string */
    private $_senderName;
    
    /** @var Atom_Email_Adress */
    private $_senderEmail;
    
    /** @var array */
    private $_recipients = array();
    
    /** @var array */
    private $_attachements = array();
    
    /** @var string */
    private $_subject = 'no subject';
    
    /** @var string */
    private $_text = '';
    
    
    public function __construct(Atom_Email_Address $senderEmail, $senderName) {
        $this->_senderEmail = $senderEmail;
        $this->_senderName = $senderName;
    }
    
    public function setSubject($subject) {
        $this->_subject = $subject;
    }
    
    public function setText($text) {
        $this->_text = $text;
    }
    
    public function addRecipient(Atom_Email_Address $recipientAddress) {
        $this->_recipients[] = $recipientAddress;
    }
    
    public function addAttachement($file) {
        if (!is_file($file)) {
            
        }
        
        __func('Files/getMimeType');
        
        $this->_attachements[] = array(
            'file' => $file,
            'content_type' => getMimeType($file)
        );
    }
    
    public function setEncoding($encoding) {
        $this->_encoding = $encoding;
    }
    
    public function send() {
        $mailer = new PhpMailer();
        $pConfig = Atom_Config::instance();
        
        // SMTP Versand vorbereiten
        $mailer->IsSMTP();
        $mailer->SMTPAuth = true;
        $mailer->SMTPKeepAlive = true;
        $mailer->Host = $pConfig->Email->Host;
        $mailer->Port = 25;
        $mailer->Username = $pConfig->Email->User;
        $mailer->Password = $pConfig->Email->Pass;
        
        $mailer->SetFrom(
            $this->_senderEmail->toString(),
            $this->_senderName
        );
        
        foreach ($this->_recipients as $curRecipient) {        
            $mailer->AddAddress(utf8_decode($curRecipient->toString()));
        }
        
        $mailer->Subject = utf8_decode($this->_subject);
        $mailer->AltBody = $this->_text;
        $mailer->MsgHTML(nl2br($this->_text));
        $mailer->Send();
    }
}

