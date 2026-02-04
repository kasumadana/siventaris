<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Department: string implements HasLabel
{
    case TKP = 'TKP';
    case DPIB = 'DPIB';
    case ELIN = 'ELIN';
    case TITL = 'TITL';
    case TPTU = 'TPTU';
    case TPM = 'TPM';
    case TSM = 'TSM';
    case TKR = 'TKR';
    case RPL = 'RPL';
    case TKJ = 'TKJ';
    case DKV = 'DKV';
    case PRF = 'PRF';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TKP => 'Teknik Konstruksi & Perumahan',
            self::DPIB => 'Desain Pemodelan & Informasi Bangunan',
            self::ELIN => 'Elektronika Industri',
            self::TITL => 'Teknik Instalasi Tenaga Listrik',
            self::TPTU => 'Teknik Pendinginan & Tata Udara',
            self::TPM => 'Teknik Pemesinan',
            self::TSM => 'Teknik Sepeda Motor',
            self::TKR => 'Teknik Kendaraan Ringan',
            self::RPL => 'Rekayasa Perangkat Lunak',
            self::TKJ => 'Teknik Komputer & Jaringan',
            self::DKV => 'Desain Komunikasi Visual',
            self::PRF => 'Produksi Film',
        };
    }
}
