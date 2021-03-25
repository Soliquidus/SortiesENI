<?php

namespace App\Entity;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

class EventSearch
{
    /**
     * @var string|null
     * @Assert\Length(max=50)
     */
    private $name;

    /**
     * @var Campus
     */
    private $campus;

    /**
     * @var DateType
     */
    private $minDate;

    /**
     * @var DateType
     */
    private $maxDate;

    /**
     * @var boolean
     */
    private $eventCreator;

    private $checkboxField;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return EventSearch
     */
    public function setName(?string $name): EventSearch
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return Campus|null
     */
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus|null $campus
     * @return EventSearch
     */
    public function setCampus(?Campus $campus): EventSearch
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinDate()
    {
        return $this->minDate;
    }

    /**
     * @param mixed $minDate
     * @return EventSearch
     */
    public function setMinDate($minDate)
    {
        $this->minDate = $minDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxDate()
    {
        return $this->maxDate;
    }

    /**
     * @param mixed $maxDate
     * @return EventSearch
     */
    public function setMaxDate($maxDate)
    {
        $this->maxDate = $maxDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEventCreator(): bool
    {
        return $this->eventCreator;
    }

    /**
     * @param bool $eventCreator
     * @return EventSearch
     */
    public function setEventCreator(bool $eventCreator): EventSearch
    {
        $this->eventCreator = $eventCreator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckboxField()
    {
        return $this->checkboxField;
    }

    /**
     * @param mixed $checkboxField
     * @return EventSearch
     */
    public function setCheckboxField($checkboxField)
    {
        $this->checkboxField = $checkboxField;
        return $this;
    }



}
