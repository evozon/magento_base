<?php

/**
 * Requirement model
 *
 * @package     Evozon_Base_Model_Check
 * @copyright   Copyright (c) Evozon Systems (http://www.evozon.com/)
 * @author      Constantin Bejenaru <constantin.bejenaru@evozon.com>
 */
class Evozon_Base_Model_Check_Requirement
{

    /**
     * Requirement satisfied flag
     *
     * @var boolean
     */
    protected $satisfied = false;

    /**
     * Requirement message
     *
     * @var string
     */
    protected $message;

    /**
     * Requirement help
     *
     * @var string
     */
    protected $help;

    /**
     * Requirement optional flag (recommendation)
     *
     * @var boolean
     */
    protected $optional = false;

    /**
     * Constructor - initialize requirement
     *
     * @param boolean $satisfied Flag if requirement is satisfied
     * @param string  $message   Requirement message
     * @param string  $help      Help messages
     * @param boolean $optional  Flag if requirement is optional
     */
    public function __construct($satisfied, $message, $help, $optional)
    {
        $this->satisfied = (boolean) $satisfied;
        $this->message   = (string) $message;
        $this->help      = (string) $help;
        $this->optional  = (boolean) $optional;
    }

    /**
     * Return whether the requirement is satisfied
     *
     * @return boolean
     */
    public function isSatisfied()
    {
        return $this->satisfied;
    }

    /**
     * Return requirement message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Return requirement help message
     *
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * Returns whether the requirement is optional or mandatory
     *
     * @return boolean
     */
    public function isOptional()
    {
        return $this->optional;
    }
}
