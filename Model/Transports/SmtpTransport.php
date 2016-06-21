<?php
/**
 * Copyright 2016 Shockwave-Design - J. & M. Kramer, all rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Shockwavemk\Mail\Smtp\Model\Transports;

class SmtpTransport extends \Zend_Mail_Transport_Smtp implements \Magento\Framework\Mail\TransportInterface
{
    /**
     * @var \Magento\Framework\Mail\MessageInterface
     */
    protected $_message;

    /** @var  \Shockwavemk\Mail\Base\Model\Mail */
    protected $_mail;

    /**
     *
     *
     * @param \Shockwavemk\Mail\Smtp\Model\Config $config
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @param null $parameters
     * @throws \InvalidArgumentException
     */
    public function __construct(
        \Shockwavemk\Mail\Smtp\Model\Config $config,
        \Magento\Framework\Mail\MessageInterface $message,
        $parameters = null)
    {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('The message should be an instance of \Zend_Mail');
        }

        parent::__construct(
            $config->getHost(), 
            $config->getSmtpParameters()
        );
        
        $this->_message = $message;
    }

    /**
     * Send a mail using this transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        try {
            $attachments = $this->_mail->getAttachments();

            /** @noinspection IsEmptyFunctionUsageInspection */
            if(!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $this->_message->addAttachment($attachment->toMimePart());
                }
            }

            parent::send($this->_message);
            
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\MailException(
                new \Magento\Framework\Phrase($e->getMessage()),
                $e)
            ;
        }
    }

    /**
     * Returns wrapped mail object
     *
     * @return \Shockwavemk\Mail\Base\Model\Mail
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @param mixed $mail
     * @return \Shockwavemk\Mail\Base\Model\Transports\TransportInterface
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
        return $this;
    }

    /**
     * Returns wrapped message
     *
     * @return \Zend_Mail
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Assign wrapped message
     *
     * @param \Zend_Mail $message
     * @return \Shockwavemk\Mail\Base\Model\Transports\TransportInterface
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }
}
