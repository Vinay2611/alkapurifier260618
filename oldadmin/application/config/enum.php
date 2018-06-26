<?php
abstract class BasicEnum
{
    private static $constCacheArray = NULL;

    public static function Val($const)
    {
        $calledClass = get_called_class();

        $constants = self::getConstants();

        $key = array_search($const, $constants);

        return $key;
    }

    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict = true);
    }
}

//Never Change the value of given Constant
// You Can add new constant with new value

class UserType extends BasicEnum
{
    const Admin = 1;
    const Manager = 2;
    const Staff = 3;
}


class ControllerType extends BasicEnum{
    const AreaProduction = 1;
    const PlantProduction = 2;
    const IndustrialProduction = 3;
    const ProductionJobber = 4;
    const AreaSales = 5;
    const PlantSales = 6;
    const IndustrialSales = 7;
    const SalesJobber = 8;
}