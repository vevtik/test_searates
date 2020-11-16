<?php

namespace app\entity;

class BaseEntity
{
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function toArray()
    {
        $result = [];
        $vars = get_object_vars($this);

        foreach ($vars as $field => $value) {
            $result[$this->getConversionFieldName($field)] = $value;
        }

        return $result;
    }

    private function getConversionFieldName(string $field): string
    {
        $result = preg_replace('/([A-Z])/', '_$1', $field);
        $result = trim($result, '_');
        $result = strtolower($result);

        return $result;
    }

    public function setData(array $data): void
    {
        foreach ($data as $key => $val) {
            $setter = 'set' . toPascalCase($key);
            if (method_exists($this, $setter)) {
                $this->$setter($val);
            }
        }
    }
}
