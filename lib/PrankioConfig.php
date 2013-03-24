<?
class PrankioConfig {

    protected static $_data = array();

    /*
     * Set some data
     *
     * @param array $arr
     */
    public static function set($arr){
        self::$_data = $arr;
    }

    /*
     * Get config based on a key
     *
     * @param string $key
     */
    public static function get($key){
        return self::$_data[$key];
    }

}