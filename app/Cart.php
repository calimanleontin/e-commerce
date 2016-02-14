<?php
namespace App;


class Cart
{
    private $owner_id;
    private $sum;
    private $relation = array();

    /**
     * @param $product_id
     * @return bool
     */
    public function checkProduct($product_id)
    {
        if (array_key_exists($product_id,$this->relation))
            return true;
        return false;
    }

    public function setQuantity($product_id,$quantity)
    {
        $this->relation[$product_id] = $quantity;
    }

    /**
     * @param $product_id
     * @return mixed
     */
    public function getQuantity($product_id)
    {
        return $this->relation[$product_id];
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @param $price
     */
    public function increaseSum($price)
    {
        $this->sum += $price;
    }

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