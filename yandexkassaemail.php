<?php
/**
 * JBZoo Element YandexKassa by Email
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     JBZoo
 * @license     MIT
 * @copyright   Copyright (C) JBZoo.com, All rights reserved.
 * @link        https://github.com/JBZoo/Element-Payment-YandexKassa-Email
 * @author      Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class JBCartElementPaymentYandexKassaEmail
 */
class JBCartElementPaymentYandexKassaEmail extends JBCartElementPayment
{
    /**
     * Payment uri
     * @var string
     */
    private $_uri = 'https://money.yandex.ru/eshop.xml';

    /**
     * Redirect to payment form action
     * @return null|string
     */
    public function getRedirectUrl()
    {
        $summa = $this->getOrderSumm()->val($this->config->get('currency', 'rub'));
        $summa = number_format($summa, 2, '.', '');

        $query = array(
            'shopId'         => JString::trim($this->config->get('shopId')),
            'scid'           => JString::trim($this->config->get('scid')),
            'sum'            => $summa,
            'customerNumber' => 'UserID ' . JFactory::getUser()->id,
            'orderNumber'    => $this->getOrder()->id,
        );

        $paymentType = $this->config->get('paymentType', 'AC');
        if ($paymentType && $paymentType != 'none') {
            $query['paymentType'] = $paymentType;
        }

        return $this->_uri . '?' . $this->_jbrouter->query($query);
    }

    /**
     * Set payment rate
     * @return JBCartValue
     */
    public function getRate()
    {
        return $this->_order->val($this->config->get('rate', '3.5%'));
    }

}
