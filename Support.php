<?php 

namespace App;

class Support
{
    /**
     * Request a new qr code generation.
     * @param  array $data  User data
     * @return string
     * @see https://developers.google.com/chart/infographics/docs/qr_codes
     */
    public function generate($data)
    {
        $fields = http_build_query(array(
            'cht'  => 'qr',
            'chs'  => implode('x', array($data['width'], $data['height'])),
            'chld' => implode('|', array($data['ecl'], $data['margin'])),
            'chl'  => $this->getHash($data)
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://chart.apis.google.com/chart");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);
        curl_close();

        return $response;
    }

    /**
     * Generates a vcard from POST.
     * @param  array $data  User data
     * @see https://tools.ietf.org/html/rfc6350
     * @see https://en.wikipedia.org/wiki/VCard#vCard_4.0
     */
    protected function getHash($data)
    {
        $version = '3.0';
        $vcard   = "BEGIN:VCARD"
            . PHP_EOL . "VERSION:" . $version
            . PHP_EOL . "N:" . $data['surname'] . ";" . $data['name']
            . PHP_EOL . "FN:" . $data['name'] . " " . $data['surname']

            . (! empty($data['organization'])  ? PHP_EOL . "ORG:" . $data['organization'] : '')
            . (! empty($data['work_position']) ? PHP_EOL . "TITLE:" . $data['position'] : '')
            . (! empty($data['work_address'])  ? PHP_EOL . "ADR;TYPE=WORK:" . $data['work_address'] : '')
            . (! empty($data['work_phone'])    ? PHP_EOL . "TEL;TYPE=WORK,VOICE:" . $data['work_phone'] : '')
            . (! empty($data['work_fax'])      ? PHP_EOL . "TEL;TYPE=WORK,FAX:" . $data['work_fax'] : '')
            . (! empty($data['work_url'])      ? PHP_EOL . "URL:" . $data['work_url'] : '')
            . (! empty($data['work_email'])    ? PHP_EOL . "EMAIL;TYPE=WORK:" . $data['work_email'] : '')

            . (! empty($data['home_address'])  ? PHP_EOL . "ADR;TYPE=HOME:" . $data['home_address'] : '')
            . (! empty($data['home_phone'])    ? PHP_EOL . "TEL;TYPE=HOME,VOICE:" . $data['home_phone'] : '')
            
            . PHP_EOL . "REV:" . $data['revision']
            . PHP_EOL . "END:VCARD";

        return $vcard;
    }

    /**
     * Verifies if the returned response is as expected.
     * @param  string  $hash
     * @return boolean
     */
    public function isValidQrCode($hash)
    {
        return (0 === strpos($hash, chr(137) . 'PNG'));
    }
}
