<?php

namespace App\Models;

class ServerInfo
{
    private string $model;

    private string $ram;

    private string $storage;

    private string $location;

    private string $price;


    /**
     * Get the value of model
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @param string $model
     *
     * @return self
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of ram
     *
     * @return string
     */
    public function getRam(): string
    {
        return $this->ram;
    }

    /**
     * Set the value of ram
     *
     * @param string $ram
     *
     * @return self
     */
    public function setRam(string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get the value of storage
     *
     * @return string
     */
    public function getStorage(): string
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @param string $storage
     *
     * @return self
     */
    public function setStorage(string $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get the value of location
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @param string $location
     *
     * @return self
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of price
     *
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param string $price
     *
     * @return self
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
