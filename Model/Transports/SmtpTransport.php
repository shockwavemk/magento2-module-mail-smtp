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
    protected $_magentoMail;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $_dateTime;


    /**
     *
     *
     * @param \Shockwavemk\Mail\Smtp\Model\Config $config
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param null $parameters
     * @throws \InvalidArgumentException
     */
    public function __construct(
        \Shockwavemk\Mail\Smtp\Model\Config $config,
        \Magento\Framework\Mail\MessageInterface $message,
        \Magento\Framework\Stdlib\DateTime $dateTime,
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
        $this->_dateTime = $dateTime;
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
            $attachments = $this->getMail()->getAttachments();

            /** @noinspection IsEmptyFunctionUsageInspection */
            if(!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $this->_message->addAttachment($attachment->toMimePart());
                }
            }

            $this->getMail()
                ->setSent(false)
                ->setSentAt($this->createSentAt())
                ->setTransportId(uniqid($this->_message->getSubject(), true));

            parent::send($this->_message);

            $this->getMail()->setSent(true);

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
        return $this->_magentoMail;
    }

    /**
     * @param mixed $mail
     * @return \Shockwavemk\Mail\Base\Model\Transports\TransportInterface
     */
    public function setMail($mail)
    {
        $this->_magentoMail = $mail;
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

    /**
     * @return null|string
     */
    public function createSentAt()
    {
        return $this->_dateTime->formatDate(
            new \DateTime()
        );
    }
}
