<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountNameEnum: string
{
    case Ansar = 'بانک انصار';
    case Pasargad = 'بانک پاسارگاد';
    case IranZamin = 'بانک ایران زمین';
    case Shahr = 'بانک شهر';
    case Parsian = 'بانک پارسیان';
    case ToseeTavon = 'بانک توسعه تعاون';

    public function numbers(): array
    {
        return match ($this) {
            self::Ansar => ['6273-81'],
            self::Pasargad => ['5022-29'],
            self::IranZamin => ['5057-85'],
            self::Shahr => ['5028-06'],
            self::Parsian => ['6221-06', '6391-94'],
            self::ToseeTavon => ['5029-08'],
        };
    }

    public static function fromNumber(string $number): ?self
    {
        foreach (self::cases() as $case) {
            if (in_array($number, $case->numbers())) {
                return $case;
            }
        }

        return null;
    }
}
