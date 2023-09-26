<?php
/*
 * Program Name..: emails.class.php
 * Author........: Brian Timberlake
 * Date Created..: November 9, 2022
 */
class Email {
  private $sqlTable;
  private $fromName;
  private $fromEmailAddress;
  private $toEmailAddress;
  private $content;
  private $subject;
  private $fileAttached;
  private $readyForEmail;

  public function __construct() {
    $this->sqlTable = new SQLTable();
    $this->setup();
  }

  public function setName($name) { $this->fromName = $name; }
  public function setFromEmailAddress($fromEmailAddress) { $this->fromEmailAddress = $fromEmailAddress; }
  public function setToEmailAddress($toEmailAddress) { $this->toEmailAddress = $toEmailAddress; }
  public function setContent($content) { $this->content = $content; }
  public function setSubject($subject) { $this->subject = $subject; }
  public function setFileAttached($fileAttached) { $this->fileAttached = $fileAttached; }
  public function getReadyForEmail() { return $this->readyForEmail; }

  private function setup() {
    $rows = $this->sqlTable->load('loadSetup', array(BUS_UNIT));
    $this->readyForEmail = 'N';
    foreach ($rows as $row) $this->readyForEmail = $row['ReadyForEmail'];
  }

  public function emailComplete() { $ret = $this->sqlTable->execute('updateSetup', array(BUS_UNIT)); }

  public function send() {
    //recipient
    $to = $this->toEmailAddress;

    //sender
    $from = 'admin@kdga.org';
    $fromName = BUS_UNIT . ' Administrator';

    //example: email subject 'Super Bowl <Year> Squares'
    $subject = $this->subject;

    //email body content
    $htmlContent = $this->content;

    //header for sender info
    $headers = "From: $fromName" . " <" . $from . ">";

    //boundary 
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    //headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    //multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    //preparing attachment
    if(!empty($this->fileAttached) > 0) {
        if (is_file($this->fileAttached)) {
          $message .= "--{$mime_boundary}\n";
          $fp = @fopen($this->fileAttached,"rb");
          $data = @fread($fp, filesize($this->fileAttached));

          @fclose($fp);
          $data = chunk_split(base64_encode($data));
          $message .= "Content-Type: application/octet-stream; name=\"" . basename($this->fileAttached) . "\"\n" .
            "Content-Description: " . basename($this->fileAttached) . "\n" .
            "Content-Disposition: attachment;\n" . " filename=\"" . basename($this->fileAttached) . "\"; size=" . filesize($this->fileAttached) . ";\n" .
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    //send email
    if (mail($to, $subject, $message, $headers, $returnpath)) {
      echo "<h3 style='color: green;'>Thank you for contacting us!</h3>";
    } else {
      echo "<h3 style='color: red;'>Oops, something went wrong. Please try again later</h3>";
    }
  }
}
?>
