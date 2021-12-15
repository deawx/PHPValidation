<?php
/**
 * PHPValidation.php
 *
 * This file is part of PHPValidation.
 *
 * @package    PHPValidation.php @ 2021-10-03T10:06:13.735Z
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2021 PHPValidation
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt  GNU GPL 3.0
 * @version    1.0.7
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace PHPValidation;

class PHPValidation implements \PHPValidation\PHPValidationInterface
{

    private string $version = '1.0.7';
    
    /**
     * @var array
     */
    public $patterns = [
        'uri' => '[A-Za-z0-9-\/_?&=]+',
        'slug' => '[-a-z0-9_-]',
        'url' => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha' => '[\p{L}]+',
        'words' => '[\p{L}\s]+',
        'alphanum' => '[\p{L}0-9]+',
        'int' => '[0-9]+',
        'float' => '[0-9\.,]+',
        'tel' => '[0-9+\s()-]+',
        'text' => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file' => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder' => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address' => '[\p{L}0-9\s.,()°-]+',
        'date_dmy' => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd' => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email' => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]'
    ];

    public $lang = [
        "validation_error_invalid_mail" => "{mail} e-mail address is not valid.",
        "validation_error_invalid_mail_domain" => "The domain of your email address ({mail}) should be {domain}, not {maildomain}.",
        "validation_error_invalid_url" => "{url} URL address is not valid.",
        "validation_error_invalid_url_domain" => "The domain of the url address ({url}) should be {domain}, not {urldomain}.",
        "validation_error_invalid_bool" => "{data} is not bool.",
        "validation_error_invalid_null" => "{data} is not null.",
        "validation_error_invalid_array" => "{data} is not array.",
        "validation_error_invalid_object" => "{data} is not object.",
        "validation_error_invalid_class" => "This {data} is not a {class_name} object.",
        "validation_error_invalid_float" => "{data} is not float number.",
        "validation_error_invalid_resource" => "{data} is not resource.",
        "validation_error_invalid_integer" => "{data} is not integer.",
        "validation_error_invalid_integer_min_range" => "({data}) it cannot be less than {min}.",
        "validation_error_invalid_integer_max_range" => "({data}) It cannot be greater than {max}.",
        "validation_error_invalid_numeric" => "{data} is not numeric.",
        "validation_error_invalid_ip" => "{ip} IP address is not valid",
        "validation_error_invalid_ipv4" => "{ipv4} IPv4 address is not valid",
        "validation_error_invalid_ipv6" => "{ipv6} IPv6 address is not valid",
        "validation_error_invalid_string_lenght" => "Its length should be {lenght}.",
        "validation_error_invalid_string_minlenght" => "It must be at least {min} in length.",
        "validation_error_invalid_string_maxlenght" => "The length should be no more than {max}.",
        "validation_error_invalid_min_length" => "The text must contain at least {min_length} characters.",
        "validation_error_invalid_max_length" => "Text can contain up to {max_length} characters.",
        "validation_error_invalid_min" => "Must be a number less than or equal to {min}",
        "validation_error_invalid_max" => "Must be a number greater than or equal to {max}",
        "validation_error_invalid_format" => "{data} is not in valid {pattern} format",
        "validation_error_invalid_date" => "{date} Is not a valid date",
        "validation_error_invalid_date_format" => "{value} Not a valid {format} date format",
        "validation_error_invalid_required" => "Cannot be left blank",
        "validation_error_invalid_empty" => "{data} is not empty.",
    ];

    /**
     * @var array
     */
    public $error = [];


    public $error_method = '';

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var array
     */
    public $rule = [];

    public function version(): string
    {
        return $this->version;
    }

    /**
     * Include the data to be validated as an associative array.
     * 
     * @param array $data
     * @return self
     */
    public function set(array $data = []): self
    {
        $this->data = $data;

        return $this;
    }

    public function addSet($key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Adds a new pattern
     * 
     * @param string $name
     * @param string $pattern
     * @return self
     */
    public function pattern(string $name, string $pattern): self
    {
        $this->patterns[$name] = $pattern;

        return $this;
    }

    /**
     * Returns the pattern associated with the pattern name.
     * 
     * @param string $pattern_name
     * @return string|false
     */
    private function pattern_regex(string $pattern_name)
    {
        return isset($this->patterns[$pattern_name]) ? '/^(' . $this->patterns[$pattern_name] . ')$/u' : false;
    }

    /**
     * Checks if a value is in email address format.
     * 
     * @param string $mail Data to be tested.
     * @param string $domain Default : ""
     * @return bool
     */
    public function mail($mail, $domain = ""): bool
    {
        $this->error_method = 'mail';
        if($this->is_mail($mail)){
            if($domain != ""){
                [$mailuser, $maildomain] = \explode("@", $mail, 2);
                if($maildomain == $domain){
                    return true;
                }else{
                    $this->error[] = $this->__r("validation_error_invalid_mail_domain", ["mail" => $mail, "domain" => $domain, "maildomain" => $maildomain]);
                }
            }else{
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if a value is in email address format.
     * 
     * @param string $mail Data to be tested.
     * @return bool
     */
    public function is_mail($mail): bool
    {
        $this->error_method = 'is_mail';
        if(\filter_var($mail, \FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->error[] = $this->__r("validation_error_invalid_mail", ["mail" => $mail]);
            return false;
        }
    }

    /**
     * Checks if a value is in URL address format.
     * 
     * @param string $url Data to be tested.
     * @param string $domain Default : ""
     * @param bool
     */
    public function url($url, $domain = ""): bool
    {
        $this->error_method = 'url';
        if($this->is_url($url)){
            if($domain != ""){
                $host = \parse_url($url, PHP_URL_HOST);

                if($host == $domain){
                    return true;
                }elseif(\substr($host, -(\strlen($domain) + 1)) == ".".$domain){
                    return true;
                }else{
                    $this->error[] = $this->__r("validation_error_invalid_url_domain", ["url" => $url, "domain" => $domain, "urldomain" => $host]);
                }
            }else{
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if a value is in URL address format.
     * 
     * @param string $url Data to be tested.
     * @param bool
     */
    public function is_url($url): bool
    {
        $this->error_method = 'is_url';
        if (\filter_var($url, \FILTER_VALIDATE_URL)) {
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_url", ["url" => $url]);
        return false;
    }

    /**
     * Tests if the value is a string.
     * 
     * @param $data
     * @return bool
     */
    public function is_string($data): bool 
    {
        $this->error_method = 'is_string';
        if(\is_string($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_string", ["data" => $data]);
        return false;
    }

    /**
     * @see is_string() method
     */
    public function is_str($data): bool 
    {
        $this->error_method = 'is_str';
        return $this->is_string($data);
    }

    /**
     * Tests if the value is a string. It can also test the length of the string.
     * 
     * @param $data
     * @param $lengthRange Default : NULL Example : 10-25
     * @return bool
     */
    public function string($data, $lengthRange = null): bool
    {
        $this->error_method = 'string';
        if($this->is_string($data)){
            if($lengthRange !== null){
                $dataLength = $this->stringLength($data);
                if(\is_numeric($lengthRange) && $lengthRange > 0){
                    if($dataLength == $lengthRange){
                        return true;
                    }else{
                        $this->error[] = $this->__r("validation_error_invalid_string_lenght", ["lenght" => $lengthRange]);
                        return false;
                    }
                }elseif(\is_string($lengthRange)){
                    $lengthRangeExp = \explode("-", $lengthRange, 2);
                    $minLength = $lengthRangeExp[0] ?? 0;
                    $maxLength = $lengthRangeExp[1] ?? 0;
                    if($minLength > 0 && $dataLength < $minLength){
                        $this->error[] = $this->__r("validation_error_invalid_string_minlenght", ["min" => $minLength]);
                        return false;
                    }
                    if($maxLength > 0 && $dataLength > $maxLength){
                        $this->error[] = $this->__r("validation_error_invalid_string_maxlenght", ["max" => $maxLength]);
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * It tests the data with the is_numeric() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_numeric($data): bool
    {
        $this->error_method = 'is_numeric';
        if(\is_numeric($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_numeric", ["data" => $data]);
        return false;
    } 

    /**
     * It tests the data with the is_int() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_int($data): bool 
    {
        $this->error_method = 'is_int';
        if(\is_int($data)){
            return true;
        }elseif(\is_numeric($data) && \abs(\abs(\floor($data)) - \abs($data)) == 0 && !\is_float($data)){;
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_integer", ["data" => $data]);
        return false;
    }

    /**
     * @see is_int() method
     */
    public function is_integer($data): bool 
    {
        $this->error_method = 'is_integer';
        return $this->is_int($data);
    }

    /**
     * Tests an integer to see if it is within a certain range.
     * 
     * @param $data
     * @param string|null $range Default: NULL Example : "50-120"
     * @return bool
     */
    public function integer($data, $range = null): bool
    {
        $this->error_method = 'integer';
        if($this->is_int($data)){
            if($range !== null){
                $rangeExp = \array_filter(\explode("-", $range, 2));
                $min = $rangeExp[0] ?? null;
                $max = $rangeExp[1] ?? null;
                if($min !== null && $data < $min){
                    $this->error[] = $this->__r("validation_error_invalid_integer_min_range", ["min" => $min, "data" => $data]);
                    return false;
                }
                if($max !== null && $data > $max){
                    $this->error[] = $this->__r("validation_error_invalid_integer_max_range", ["max" => $max, "data" => $data]);
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * It tests the data with the is_resource() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_resource($data): bool
    {
        $this->error_method = 'is_resource';
        if(\is_resource($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_resource", ["data" => $data]);
        return false;
    }

    /**
     * It tests the data with the is_float() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_float($data): bool 
    {
        $this->error_method = 'is_float';
        if(\is_float($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_float", ["data" => $data]);
        return false;
    }

    /**
     * @see is_float() method
     */
    public function is_real($data): bool
    {
        $this->error_method = 'is_real';
        return $this->is_float($data);
    }

    /**
     * @see is_float() method
     */
    public function is_double($data): bool 
    {
        $this->error_method = 'is_double';
        return $this->is_float($data);
    }

    /**
     * It tests the data with the is_object() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_object($data): bool 
    {
        $this->error_method = 'is_object';
        if(\is_object($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_object", ["data" => $data]);
        return false;
    }

    /**
     * Tests the class name of an object.
     * 
     * @param object $data
     * @param string $class_name
     * @return bool
     */
    public function is_class($data, $class_name): bool
    {
        $this->error_method = 'is_class';
        if($this->is_object($data)){
            $data_name = \get_class($data);
            if($data_name == $class_name){
                return true;
            }
            $this->error[] = $this->__r("validation_error_invalid_class", ["data" => $data_name, "class_name" => $class_name]);
        }
        return false;
    }

    /**
     * It tests the data with the is_array() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_array($data): bool 
    {
        $this->error_method = 'is_array';
        if(\is_array($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_array", ["data" => $data]);
        return false;
    }

    /**
     * It tests the data with the is_null() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_null($data): bool 
    {
        $this->error_method = 'is_null';
        if($data === null){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_null", ["data" => $data]);
        return false;
    }

    public function is_empty($data): bool
    {
        $this->error_method = 'is_empty';
        if(empty($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_empty", ["data" => $data]);
        return false;
    }

    /**
     * It tests the data with the is_bool() function.
     * 
     * @param $data
     * @return bool
     */
    public function is_bool($data): bool 
    {
        $this->error_method = 'is_bool';
        if(\is_bool($data)){
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_bool", ["data" => $data]);
        return false;
    }

    /**
     * Checks if a value is in IP address format.
     * 
     * @param string $ip Data to be tested.
     * @return bool
     */
    public function ip(string $ip): bool
    {
        $this->error_method = 'ip';
        if (\filter_var($ip, \FILTER_VALIDATE_IP)) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_ip", ["ip" => $ip]);
            return false;
        }
    }

    /**
     * Checks if a value is in IPv4 address format.
     * 
     * @param string $ip Data to be tested.
     * @return bool
     */
    public function ipv4(string $ip): bool
    {
        $this->error_method = 'ipv4';
        if (\filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_ipv4", ["ipv4" => $ip]);
            return false;
        }
    }

    /**
     * Checks if a value is in IPv6 address format.
     * 
     * @param string $ip Data to be tested.
     * @return bool
     */
    public function ipv6(string $ip): bool
    {
        $this->error_method = 'ipv6';
        if (\filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_ipv6", ["ipv6" => $ip]);
            return false;
        }
    }

    /**
     * Returns the number of characters in a string.
     * 
     * @param string $str Data to be tested.
     * @return int|false
     */
    private function stringLength(string $str)
    {
        if(!\function_exists("mb_strlen")){
            return \strlen($str);
        }
        return \mb_strlen($str);
    }

    /**
     * Tests the number of characters in a string. Returns true if there are more characters than required, false otherwise.
     * 
     * @param string $value Data to be tested.
     * @param int $min_length Minimum length to be accepted
     * @return bool
     */
    public function minLength(string $value, int $min_length): bool
    {
        $this->error_method = 'minLength';
        if ($this->stringLength($value) >= $min_length) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_min_length", ["min_length" => $min_length]);
            return false;
        }
    }

    /**
     * Tests the number of characters in a string. Returns true if there are as many or less characters as specified, false if more.
     * 
     * @param string $value Data to be tested.
     * @param int $max_length Maksimum length to be accepted
     * @return bool
     */
    public function maxLength(string $value, int $max_length): bool
    {
        $this->error_method = 'maxLength';
        if ($this->stringLength($value) <= $max_length) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_max_length", ["max_length" => $max_length]);
            return false;
        }
    }

    /**
     * Tests the smallness of an integer.
     * 
     * @param int $value Data to be tested.
     * @param int $min Minimum number to accept
     * @param bool
     */
    public function min(int $value, int $min): bool
    {
        $this->error_method = 'min';
        if ($min >= $value) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_min", ["min" => $min]);
            return false;
        }
    }

    /**
     * Tests the bigness of an integer.
     * 
     * @param string $value Data to be tested.
     * @param int $max Maximum number to accept
     * @return bool
     */
    public function max(string $value, int $max): bool
    {
        $this->error_method = 'max';
        if ($max <= $value) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_max", ["max" => $max]);

            return false;
        }
    }

    /**
     * Tests a value with a pattern.
     * 
     * @param string $value Data to be tested.
     * @param string $pattern An existing pattern name or the pattern itself.
     * @return bool
     */
    public function regex($value, $pattern): bool
    {   
        $this->error_method = 'regex';
        $temp_pattern = $pattern;
        $pattern = $this->pattern_regex($pattern);
        if($pattern === false){
            $pattern = '/^(' . $temp_pattern . ')$/u';
        }
        if (\preg_match($pattern, $value)) {
            return true;
        } else {
            $this->error[] = $this->__r("validation_error_invalid_format", ["data" => $value, "pattern" => $pattern]);
            return false;
        }
    }

    /**
     * Tests whether a value is of time type.
     * 
     * @param string $value Data to be tested.
     * @return bool
     */
    public function date(string $value): bool
    {
        $this->error_method = 'date';
        $isDate = false;
        if ($value instanceof \DateTime) {
            $isDate = true;
        } else {
            $isDate = \strtotime($value) !== false;
        }
        if (!$isDate) {
            $this->error[] = $this->__r("validation_error_invalid_date", ["date" => $value]);
        }

        return $isDate;
    }

    /**
     * Tests whether a value is in a certain time format.
     * 
     * @param string $value
     * @param string $format
     * @return bool
     */
    public function dateFormat(string $value, string $format): bool
    {
        $this->error_method = 'dateFormat';
        $dateFormat = \date_parse_from_format($format, $value);

        if ($dateFormat['error_count'] === 0 && $dateFormat['warning_count'] === 0) {
            return true;
        } else {
            $this->error[] = $this->__r(
                "validation_error_invalid_date_format", ["value" => $value, "format" => $format]
            );
            return false;
        }
    }

    /**
     * Tests whether a value is blank.
     * 
     * @param string|array $data
     * @return bool
     */
    public function required($data): bool
    {
        $this->error_method = 'required';
        if((\is_string($data) && \trim($data) != "") || !empty($data)) {
            return true;
        }
        $this->error[] = $this->__r("validation_error_invalid_required");

        return false;
    }

    /**
     * Appends data to an associative array for testing with a method.
     * 
     * @param string|array $rule The method or methods to be applied to the data.
     * @param string|array $dataId Key value of data to be tested from preloaded data array
     * @return self
     */
    public function rule($rule, $dataId): self
    {
        if (\is_string($rule)) {
            $rule = [$rule];
        }
        if (\is_string($dataId)) {
            $dataId = [$dataId];
        }
        $this->rule[] = [
            "rule" => $rule,
            "dataID" => $dataId
        ];

        return $this;
    }

    /**
     * It tests a data with a method.
     * 
     * @param string $rule The method to be applied to the data.
     * @param string $dataKey Key value of data to be tested from preloaded data array
     * @return void
     */
    public function ruleExecutive(string $rule, string $dataKey): void
    {
        $data = [];
        $data = [$this->data[$dataKey]];

        \preg_match("/\((.*)\)/u", $rule, $params);
        if (isset($params[0])) {
            $method = \preg_replace("/\((.*)\)/u", '', $rule);
            $data[] = \trim($params[0], "()");
        } else {
            $method = $rule;
        }
        \call_user_func_array([__CLASS__, $method], $data);
    }


    /**
     * It performs the tests previously declared by the rule() method.
     * 
     * @return bool
     */
    public function validation(): bool
    {
        $this->error = [];
        foreach ($this->rule as $rule) {
            foreach ($rule['rule'] as $rule_row) {
                foreach ($rule['dataID'] as $data_row) {
                    $this->ruleExecutive($rule_row, $data_row);
                }
            }
        }
        if (\count($this->error) > 0) {
            $return = false;
        } else {
            $return = true;
        }
        $this->rule = [];
        return $return;
    }

    /**
     * Returns an array of errors that occur during validation operations.
     * 
     * @return array|false
     */
    public function errors()
    {
        if(\count($this->error) > 0){
            return $this->error;
        }else{
            return false;
        }
    }

    public function error_method(): string
    {
        return $this->error_method;
    }

    private function __r($key, array $context = [])
    {
        $lang = $this->lang[$key] ?? $key;
        return $this->interpolate($lang, $context);
    }

    public function __rSet(string $key, string $value): void
    {
        $this->lang[$key] = $value;
    }
    
    private function interpolate(string $message, array $context = []): string
    {
        $replace = array();
        $i = 0;
        foreach ($context as $key => $val) {
            if (!\is_array($val) && (!\is_object($val) || \method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
                $replace['{' . $i . '}'] = $val;
                $i++;
            }
        }

        return \strtr($message, $replace);
    }

}
