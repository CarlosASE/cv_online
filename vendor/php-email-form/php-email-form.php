<?php

class PHP_Email_Form {
    public $ajax = false;
    public $to;
    public $subject;
    public $from_name;
    public $from_email;
    public $message;
    public $headers;
    private $messages = array();

    public function __construct() {
        $this->headers = '';
        $this->message = '';
    }

    public function add_message($content, $label, $priority = 0) {
        $this->messages[] = array('content' => $content, 'label' => $label, 'priority' => $priority);
    }

    public function compile_message() {
        usort($this->messages, function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        $compiled_message = '';
        foreach ($this->messages as $msg) {
            $compiled_message .= $msg['label'] . ": " . $msg['content'] . "\n";
        }

        $this->message = $compiled_message;
    }
    
    public function send() {
        $this->compile_message();
        
        // Añadir encabezados de From si from_name y from_email están definidos
        if (!empty($this->from_name) && !empty($this->from_email)) {
            $this->headers .= "From: {$this->from_name} <{$this->from_email}>\r\n";
        }

        $result = mail($this->to, $this->subject, $this->message, $this->headers);
        
        if ($this->ajax) {
            return json_encode(['success' => $result]);
        } else {
            return $result ? 'Email sent successfully!' : 'Failed to send email.';
        }
    }
}

?>
