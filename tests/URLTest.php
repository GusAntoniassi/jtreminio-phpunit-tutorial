<?php
namespace App\Test;

use App\URL;
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{

    /**
     * @param string $originalString String a ser sluggificada
     * @param string $expectedResult O resultado esperado
     *
     * @dataProvider providerTestSluggifyReturnsSluggifiedString
     */
    public function testSluggifyReturnsSluggifiedString($originalString, $expectedResult)
    {
        $url = new URL();

        $result = $url->sluggify($originalString);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Utiliza o @dataProvider do PHPUnit para fornecer os dados de teste. O
     * formato é de um array contendo outros arrays com os dados. Cada array
     * será testado de forma unitária pelo teste que utilizar o provider.
     * @return array
     */
    public function providerTestSluggifyReturnsSluggifiedString()
    {
        return array(
            array('This string will be sluggified', 'this-string-will-be-sluggified'),
            array('THIS STRING WILL BE SLUGGIFIED', 'this-string-will-be-sluggified'),
            array('This1 string2 will3 be 44 sluggified10', 'this1-string2-will3-be-44-sluggified10'),
            array('This! @string#$ %$will ()be "sluggified', 'this-string-will-be-sluggified'),
            array("Tänk efter nu – förr'n vi föser dig bort", 'tank-efter-nu-forrn-vi-foser-dig-bort'),
            array('', ''),
        );
    }
}