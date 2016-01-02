<?php
/**
 * Copyright © 2015 Martin Kramer. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Shockwavemk\Mail\Smtp\Model\Config\Source\Smtp;

use Shockwavemk\Mail\Smtp\Model\Config;

class Ssl implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('No SSL'), 'value' => Config::SSL_NONE],
            ['label' => __('SSL'), 'value' => Config::SSL_DEFAULT],
            ['label' => __('SSL TLS'), 'value' => Config::SSL_TLS]
        ];
    }
}
