<?php

namespace app\entity;

class Rate extends BaseEntity
{
    protected int $id;
    protected string $portFrom;
    protected string $portTo;
    protected string $containerType;
    protected float $rate;
    protected string $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPortFrom(): string
    {
        return $this->portFrom;
    }

    /**
     * @param string $portFrom
     *
     * @return self
     */
    public function setPortFrom(string $portFrom): self
    {
        $this->portFrom = $portFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getPortTo(): string
    {
        return $this->portTo;
    }

    /**
     * @param string $portTo
     *
     * @return self
     */
    public function setPortTo(string $portTo): self
    {
        $this->portTo = $portTo;

        return $this;
    }

    public function getRoute(): string
    {
        return "{$this->getPortFrom()}-{$this->getPortTo()}";
    }

    /**
     * @return string
     */
    public function getContainerType(): string
    {
        return $this->containerType;
    }

    /**
     * @param string $containerType
     *
     * @return self
     */
    public function setContainerType(string $containerType): self
    {
        $this->containerType = $containerType;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     *
     * @return self
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
