<?php


namespace Codec\Types;

use Codec\ScaleBytes;
use Codec\Types\ScaleDecoder;
use Codec\Utils;


class Address extends ScaleDecoder
{
    public function decode ()
    {
        $accountLength = $this->data->nextBytes(1);
        switch (Utils::bytesToHex($accountLength)) {
            case "ff":
                return Utils::bytesToHex($this->data->nextBytes(32));
            case "fc":
                $this->data->nextBytes(2);
                break;
            case "fe":
                $this->data->nextBytes(8);
                break;
            case "fd":
                $this->data->nextBytes(4);
                break;
        }
        return "";
    }


    function encode ($param)
    {
        $value = Utils::trimHex($param);
        if (strlen($value) == 64) {
            return "0xff" . $value;
        } else {
            return new \InvalidArgumentException(sprintf('Address not support AccountIndex or param not AccountId'));
        }
    }
}