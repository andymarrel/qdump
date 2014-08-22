<?php

namespace Andymarrell\Sociauth\Providers;

abstract class BaseUserProvider implements UserProviderInterface {
    /**
     * @var array
     */
    protected $data;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    public function __construct(array $data){
        $this->data = $data;
    }

    /**
     * @return string|false
     */
    public function getId(){
        if (array_key_exists('id', $this->data)){
            return $this->data['id'];
        }

        return false;
    }

    /**
     * @return string|false
     */
    public function getEmail(){
        if (array_key_exists('email', $this->data)){
            return $this->data['email'];
        }

        return false;
    }

    /**
     * Get specific property from recieved data (like avatar, nickname etc.)
     *
     * @param string $property
     * @return mixed
     * @throws PropertyNotFoundException
     */
    public function getSpecificData($property) {
        if (array_key_exists($property, $this->data)){
            return $this->data[$property];
        }

        throw new PropertyNotFoundException;
    }

    public function getData(){
        return $this->data;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setId($id){
        $this->id = $id;
    }
}