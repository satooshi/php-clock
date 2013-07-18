<?php

namespace Satooshi\Component\Environment;

/**
 * Clock.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class Clock
{
    /**
     * Default DateTime format.
     *
     * @var string
     */
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * DateTime format.
     *
     * @var string
     */
    protected $dateTimeFormat = self::DATETIME_FORMAT;

    /**
     * Unix timestamp.
     *
     * @var integer
     */
    protected $timestamp;

    /**
     * Current DateTime object.
     *
     * @var \DateTime
     */
    protected $currentDateTime;

    /**
     * Constructor.
     *
     * @param string    $timezone
     * @param \DateTime $time
     */
    public function __construct($timezone = null, \DateTime $time = null)
    {
        $this->currentDateTime = static::createRequestDateTime($timezone, $time);
        $this->timestamp       = $this->currentDateTime->getTimestamp();
    }

    /**
     * String expression.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->currentDateTime->format($this->dateTimeFormat);
    }

    /**
     * Create DateTime from REQUEST_TIME.
     *
     * @param string    $timezone
     * @param \DateTime $time
     *
     * @return \DateTime
     */
    public static function createRequestDateTime($timezone = null, \DateTime $time = null)
    {
        if ($time !== null) {
            if ($timezone !== null) {
                $time->setTimezone(new \DateTimeZone($timezone));
            }

            return $time;
        }

        if (!isset($_SERVER['REQUEST_TIME'])) {
            return new \DateTime();
        }

        $dateTime     = new \DateTime('@' . $_SERVER['REQUEST_TIME']);
        $dateTimeZone = new \DateTimeZone($timezone ?: ini_get('date.timezone'));

        $dateTime->setTimezone($dateTimeZone);

        return $dateTime;
    }

    // accessor

    /**
     * Set datetime format.
     *
     * @param string $dateTimeFormat
     *
     * @return Clock
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    /**
     * Return datetime format.
     *
     * @return string
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * Return current datetime.
     *
     * @return \DateTime
     */
    public function getCurrentDateTime()
    {
        // prevent modification
        return clone $this->currentDateTime;
    }

    /**
     * Return unix timestamp.
     *
     * @return integer
     */
    public function getUnixTimestamp()
    {
        return $this->timestamp;
    }
}
