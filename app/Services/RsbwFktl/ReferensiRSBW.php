<?php

namespace App\Services\RsbwFktl;

use App\Services\RsbwFktl\SetupRSBW;

class ReferensiRSBW
{

    protected $setupFktl;
    public function __construct()
    {
        $this->setupFktl = new SetupRSBW;
    }

    public function statusAntrian($data)
    {
        $endpoin = '/statusantrean';
        return $this->setupFktl->postRequest($data, $endpoin);
    }

    public function sisaAntrian($data)
    {
        $endpoin = '/sisaantrean';
        return $this->setupFktl->postRequest($data, $endpoin);
    }
    public function jadwalOprasi($data)
    {
        $endpoin = '/jadwaloperasirs';
        return $this->setupFktl->postRequest($data, $endpoin);
    }
    public function cekinMjkn($data)
    {
        $endpoin = '/checkinantrean';
        return $this->setupFktl->postRequest($data, $endpoin);
    }
}
