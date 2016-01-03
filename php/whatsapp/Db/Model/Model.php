<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 15:32
 */

namespace Thomblin\Whatsapp\Db\Model;


class Model
{
    public $id;

    public function __construct(array $values = array())
    {
        $this->fromArray($values);
    }

    /**
     * @param array $values
     */
    public function fromArray(array $values)
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $name) {
            if (isset($values[$name])) {
                $this->$name = $values[$name];
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = array();

        foreach (array_keys(get_class_vars(get_class($this))) as $name) {
            $values[$name] = $this->$name;
        }

        return $values;
    }
}