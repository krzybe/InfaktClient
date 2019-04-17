<?php

declare(strict_types=1);

namespace Infakt\Model\Invoice;

/**
 * Class representing an invoice kind.
 */
class Kind
{
    public const FINAL = 'final';

    public const ADVANCE = 'advance';

    public const MARGIN = 'margin';

    public const PROFORMA = 'proforma';

    public const VAT = 'vat';

    public static $kinds = [
        self::FINAL,
        self::ADVANCE,
        self::MARGIN,
        self::PROFORMA,
        self::VAT
    ];
}
