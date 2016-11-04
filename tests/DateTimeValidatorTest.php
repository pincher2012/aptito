<?php
use Aptito\models\DateTimeValidator;

/**
 *
 */
class DateTimeValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param bool $expected
     * @param mixed $date
     *
     * @dataProvider providerValidate
     */
    public function testValidate($expected, $date)
    {
        $validator = new DateTimeValidator();
        $result = $validator->validate($date);
        self::assertSame($expected, $result);
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function providerValidate()
    {
        return [
            'when date is positive integer then return true' => [
                true,
                1
            ],
            'when date is string then return true' => [
                true,
                '1'
            ],
            'when date is negative integer then return false' => [
                false,
                -1
            ],
            'when date is not integer then return false' => [
                false,
                null
            ],
        ];
    }
}
