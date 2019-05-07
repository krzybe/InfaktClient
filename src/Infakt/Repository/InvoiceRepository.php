<?php

declare(strict_types=1);

namespace Infakt\Repository;

use Infakt\Model\Invoice;
use Infakt\Model\Invoice\Kind;

class InvoiceRepository extends AbstractObjectRepository
{
    /**
     *
     * @param string $kind
     * @throws \LogicException
     * @return string
     */
    public function getNextNumber(string $kind = Kind::VAT): string
    {
        if (!in_array($kind, Kind::$kinds)) {
            throw new \LogicException('Invalid invoice kind "'.$kind.'"');
        }

        $query = $this->getServiceName().'/next_number.json?kind='.$kind;
        $response = $this->infakt->get($query);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return (string) $data['next_number'];
    }

    /**
     * Mark as paid
     *
     * @param Invoice $invoice
     * @param \DateTime $paidDate
     */
    public function markAsPaid(Invoice $invoice, \DateTime $paidDate = null): bool
    {
        $query = $this->getServiceName().'/'.$invoice->getId().'/paid.json';
        $response = $this->infakt->post($query);

        return $response->getStatusCode() == 204;
    }

    /**
     * Send invoice via email
     *
     * @param Invoice $invoice
     * @param string $recipient
     * @param string $printType
     * @param string $locale
     * @param bool $sendCopy
     * @return bool
     */
    public function send(Invoice $invoice, string $recipient = null, string $printType = 'original', string $locale = 'pl', bool $sendCopy = false): bool
    {
        $query = $this->getServiceName().'/'.$invoice->getId().'/deliver_via_email.json';

        $data = [
            'print_type' => $printType,
            'locale' => $locale,
            'send_copy' => $sendCopy
        ];

        if (null !== $recipient) {
            $data['recipient'] = $recipient;
        }

        $response = $this->infakt->post($query, \GuzzleHttp\json_encode($data));

        return $response->getStatusCode() == 202;
    }
}
