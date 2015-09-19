<?php

namespace Omnipay\Creditcall\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->Result->LocalResult) && ((string)$this->data->Result->LocalResult) === '0';
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return isset($this->data->TransactionDetails->CardEaseReference) ?
            (string)$this->data->TransactionDetails->CardEaseReference : null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        if (!isset($this->data->Result->Errors)) {
            return null;
        }

        $errors = array();
        foreach ((array)$this->data->Result->Errors as $error) {
            $error = (string)$error;
            if ($error !== '') {
                $errors[] = $this->mapError($error);
            }
        }

        return count($errors) > 0 ? implode(' ', $errors) : null;
    }

    /**
     * @return null|string
     */
    public function getCardReference()
    {
        return isset($this->data->CardDetails->CardReference) ? (string)$this->data->CardDetails->CardReference : null;
    }

    /**
     * @return null|string
     */
    public function getCardHash()
    {
        return isset($this->data->CardDetails->CardHash) ? (string)$this->data->CardDetails->CardHash : null;
    }

    /**
     * @return null
     */
    public function getRedirectUrl()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return array
     */
    public function getRedirectData()
    {
        return array();
    }

    /**
     * @param string $error
     * @return string
     */
    protected function mapError($error)
    {
        $errorsMap = array(
            'CSC Invalid Length.' => 'The CVV provided is invalid.',
            'AmountTooSmall'      => 'The amount is too small for payment to be processed.',
            'cvv_not_matched'     => 'The CVV provided is invalid.',
            'address_not_matched' => 'The Address provided is invalid.',
            'zip_not_matched'     => 'The Zip code provided is invalid.',
        );

        if (array_key_exists($error, $errorsMap)) {
            return $errorsMap[$error];
        }

        return $error;
    }
}
