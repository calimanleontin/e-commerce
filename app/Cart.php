<?php
namespace App;


class Cart
{
    private $owner_id;
    private $relation = array();

    /**
     * @param $owner
     */
    public function setOwnerId($owner)
    {
        $this->owner_id = $owner;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return array
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param array $relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    /**
     * @param $product_id
     */
    public function increaseQuantity($product_id)
    {
        $this->relation[$product_id] += 1;
    }

    /**
     * @param $product_id
     */
    public function decreaseQuantity($product_id)
    {
        if($this->relation[$product_id] == 1)
            $this->relation[$product_id] = 0;
        else
            $this->relation[$product_id] -= 1;
    }

    /**
     * @param $product_id
     */
    public function addNewProduct($product_id)
    {
        if (array_key_exists($product_id,$this->relation))
            $this->increaseQuantity($product_id);
        else
            $this->relation[$product_id] = 1;
    }

    /**
     * @param $product_id
     */
    public function removeProduct($product_id)
    {
        unset($this->relation[$product_id]);
    }

    /**
     * @return array
     */
    public function getCart()
    {
        return $this->relation;
    }
}