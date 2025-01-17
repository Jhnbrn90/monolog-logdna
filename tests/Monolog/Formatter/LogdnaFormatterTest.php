<?php

namespace Zwijn\Monolog\Formatter;

use PHPUnit\Framework\TestCase;

class LogdnaFormatterTest extends TestCase
{

    /**
     * @var \Zwijn\Monolog\Formatter\LogdnaFormatter
     */
    private $logdnaFormatter = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logdnaFormatter = new \Zwijn\Monolog\Formatter\LogdnaFormatter();
    }

    public function testFormatAccordingToLogdnaStandard()
    {
        $record = $this->getRecord();
        $json = $this->logdnaFormatter->format($record);
        $decoded_json = \json_decode($json, true);

        $this->assertArrayHasKey('lines', $decoded_json);
        $this->assertEquals($decoded_json['lines'][0]['line'], $record->message);
        $this->assertEquals($decoded_json['lines'][0]['app'], $record->channel);
        $this->assertEquals($decoded_json['lines'][0]['level'], $record->level->toPsrLogLevel());
        $this->assertEquals($decoded_json['lines'][0]['meta'], $record->context);

    }

    private function getRecord(): \Monolog\LogRecord
    {
        return new \Monolog\LogRecord(
            new \DateTimeImmutable(),
            'name',
            \Monolog\Level::Debug,
            'some message',

        );
    }

}
