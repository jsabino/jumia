<?php
namespace App\Domain;

class Customer
{

    private $id;
    private $name;
    /**
     * @var PhoneNumber
     */
    private $phone;

    public function __construct(string $name, PhoneNumber $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    public static function createFromArray(array $data): Customer
    {
        $customer = new Customer($data['name'], new PhoneNumber($data['phone']));
        $customer->id = $data['id'];

        return $customer;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }
}
