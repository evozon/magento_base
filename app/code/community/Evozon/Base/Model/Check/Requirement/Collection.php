<?php

/**
 * Requirements collection
 *
 * @package     Evozon_Base_Model_Check_Requirement
 * @copyright   Copyright (c) Evozon Systems (http://www.evozon.com)
 * @author      Constantin Bejenaru <constantin.bejenaru@evozon.com>
 */
class Evozon_Base_Model_Check_Requirement_Collection implements IteratorAggregate, Countable
{

    /**
     * Requirements collection
     *
     * @var array
     */
    private $requirements = array();

    /**
     * Get requirements as iterator
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->requirements);
    }

    /**
     * Count requirements
     *
     * @return integer
     */
    public function count()
    {
        return count($this->requirements);
    }

    /**
     * Get mandatory requirements
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Add a requirement
     *
     * @param Evozon_Base_Model_Check_Requirement $requirement
     *
     * @return Evozon_Base_Model_Check_Requirement_Collection
     */
    public function add(Evozon_Base_Model_Check_Requirement $requirement)
    {
        $this->requirements[] = $requirement;

        return $this;
    }

    /**
     * Add a mandatory requirement
     *
     * @param boolean $satisfied Flag if requirement is satisfied
     * @param string  $message   Requirement message
     * @param string  $help      Help messages
     */
    public function addRequirement($satisfied, $message, $help)
    {
        $this->add(new Evozon_Base_Model_Check_Requirement($satisfied, $message, $help, false));
    }

    /**
     * Add a recommendation (optional requirement)
     *
     * @param boolean $satisfied Flag if requirement is satisfied
     * @param string  $message   Requirement message
     * @param string  $help      Help messages
     */
    public function addRecommendation($satisfied, $message, $help)
    {
        $this->add(new Evozon_Base_Model_Check_Requirement($satisfied, $message, $help, true));
    }
}
