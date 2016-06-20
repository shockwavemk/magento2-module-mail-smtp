<?php
/**
 * Copyright 2016 Shockwave-Design - J. & M. Kramer, all rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Shockwavemk\Mail\Smtp\Model\Config\Source\Smtp;

use Shockwavemk\Mail\Smtp\Model\Config;

class Authentication implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('None'), 'value' => Config::AUTHENTICATION_NONE],
            ['label' => __('Login'), 'value' => Config::AUTHENTICATION_LOGIN],
            ['label' => __('Plain'), 'value' => Config::AUTHENTICATION_PLAIN],
            ['label' => __('CRAM-MD5'), 'value' => Config::AUTHENTICATION_CRAM_MD5]
        ];
    }
}
