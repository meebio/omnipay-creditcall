<?php

namespace Omnipay\Creditcall\Message;

/**
 * AuthorizeResponse
 */
class AuthorizeResponse extends Response
{
    /**
     * @return array|string
     */
    public function getMessage()
    {
        $errors = parent::getMessage();

        /*
         * In addition to errors directly provided by gateway,
         * we check if we can guess what caused payment to fail.
         * If request was not successful and there is no errors
         * from gateway we check if CVV or address or zip verification failed.
         */
        if (!$this->isSuccessful() && $errors === '') {
            $errorsArray = array();
            if ($this->isCvvNotMatched()) {
                $errorsArray[] = $this->mapError('cvv_not_matched');
            }

            if ($this->isAddressNotMatched()) {
                $errorsArray[] = $this->mapError('address_not_matched');
            }

            if ($this->isZipNotMatched()) {
                $errorsArray[] = $this->mapError('zip_not_matched');
            }

            $errors = implode(' ', $errors);
        }

        return $errors;
    }

    /**
     * @return bool
     */
    public function isCvvNotMatched()
    {
        return isset($this->data->CardDetails->AdditionalVerification->CSC)
        && ((string)$this->data->CardDetails->AdditionalVerification->CSC) === 'notmatched';
    }

    /**
     * @return bool
     */
    public function isAddressNotMatched()
    {
        return isset($this->data->CardDetails->AdditionalVerification->Address)
        && ((string)$this->data->CardDetails->AdditionalVerification->Address) === 'notmatched';
    }

    /**
     * @return bool
     */
    public function isZipNotMatched()
    {
        return isset($this->data->CardDetails->AdditionalVerification->Zip)
        && ((string)$this->data->CardDetails->AdditionalVerification->Zip) === 'notmatched';
    }
}
