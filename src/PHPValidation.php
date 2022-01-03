<?php
/**
 * PHPValidation.php
 *
 * This file is part of PHPValidation.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2021 PHPValidation
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt  GNU GPL 3.0
 * @version    1.1
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace PHPValidation;

class PHPValidation
{

    use ValidationMethods;

    protected const FLOAT_PATTERN = '[0-9\.,]+';
    protected const INT_PATTERN = '[0-9]+';
    protected const ALPHA_PATTERN = '[\p{L}]+';
    protected const ALPHA_NUMERIC_PATTERN = '[\p{L}0-9]+';

    protected const CREDIT_CARD_PATTERNS = [
        'amex'          => '(3[47]\d{13})',
        'visa'          => '(4\d{12}(?:\d{3})?)',
        'mastercard'    => '(5[1-5]\d{14})',
        'maestro'       => '((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)',
        'jcb'           => '(35[2-8][89]\d\d\d{10})',
        'solo'          => '((?:6334|6767)\d{12}(?:\d\d)?\d?)',
        'switch'        => '(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)',
    ];

    private string $version = '1.1';

    protected string $repeatSuffix = '_repeat';

    protected array $patterns = [
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

    protected string $localeFile = 'en.php';

    protected array $internalValidLanguages = [
        'en', 'tr',
    ];

    protected array $locale = [
        'labels'            => [],
        'integer'           => '{field} must be an integer.',
        'float'             => '{field} must be an float.',
        'numeric'           => '{field} must be an numeric.',
        'string'            => '{field} must be an string.',
        'boolean'           => '{field} must be an boolean',
        'array'             => '{field} must be an Array.',
        'mail'              => '{field} must be an E-Mail address.',
        'mailHost'          => '{field} the email must be a {2} mail.',
        'url'               => '{field} must be an URL address.',
        'urlHost'           => 'The host of the {field} url must be {2}.',
        'empty'             => '{field} must be empty.',
        'required'          => '{field} cannot be left blank.',
        'min'               => '{field} must be greater than or equal to {2}.',
        'max'               => '{field} must be no more than {2}.',
        'length'            => 'The {field} length range must be {2}.',
        'regex'             => '{field} must match the {2} pattern.',
        'date'              => '{field} must be a date.',
        'dateFormat'        => '{field} must be a correct date format.',
        'ip'                => '{field} must be the IP Address.',
        'ipv4'              => '{field} must be the IPv4 Address.',
        'ipv6'              => '{field} must be the IPv6 Address.',
        'repeat'            => '{field} must be the same as {field1}',
        'equals'            => '{field} can only be {2}.',
        'startWith'         => '{field} must start with "{2}".',
        'endWith'           => '{field} must end with "{2}".',
        'in'                => '{field} must contain {2}.',
        'notIn'             => '{field} must not contain {2}.',
        'alpha'             => '{field} must contain only alpha characters.',
        'alphaNum'          => '{field} can only be alphanumeric.',
        'creditCard'        => '{field} must be a credit card number.',
        'only'              => 'The {field} value is not valid.',
        'strictOnly'        => 'The {field} value is not valid.',
        'custom_closure'    => '{field} could not be verified.',
        'custom_function'   => '{field} could not be verified.',
        'custom_method'     => '{field} could not be verified.',
    ];

    protected array $rules = [
        'integer',
        'float',
        'numeric',
        'string',
        'boolean',
        'array',
        'mail',
        'mailHost',
        'url',
        'urlHost',
        'empty',
        'required',
        'min',
        'max',
        'length',
        'regex',
        'date',
        'dateFormat',
        'ip',
        'ipv4',
        'ipv6',
        'repeat',
        'equals',
        'startWith',
        'endWith',
        'in',
        'notIn',
        'alpha',
        'alphaNum',
        'creditCard',
        'only',
        'strictOnly',
    ];

    protected array $error = [];

    protected array $userError = [];

    protected array $data = [];

    protected array $rule = [];

    protected array $optional = [];

    protected array $customRules = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Imports translations from the localization file.
     *
     * @throws \Exception
     * @param string|null $localePath
     * @return $this
     */
    public function locale(?string $localePath = null): self
    {
        if($localePath === null){
            $path = \rtrim(__DIR__, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'lang' . \DIRECTORY_SEPARATOR . 'en.php';
        }elseif(\in_array($localePath, $this->internalValidLanguages, true)){
            $path = \rtrim(__DIR__, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'lang' . \DIRECTORY_SEPARATOR . $localePath . '.php';
        }else{
            $path = $localePath;
        }
        if(!\is_file($path)){
            throw new \Exception('PHPValidation: The localization file could not be found.');
        }
        $this->localeFile = $path;
        $locale = $this->locateLoad();
        if(\is_array($locale)){
            $this->localeArray($locale);
        }
        return $this;
    }

    /**
     * Merges an array with a locale (language) array.
     *
     * @param array $localeArray
     * @return $this
     */
    public function localeArray(array $localeArray): self
    {
        $this->locale = \array_merge($this->locale, $localeArray);
        return $this;
    }

    /**
     * Returns the version of the library.
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Returns a copy of the library, loading the specified data directory.
     *
     * @param array $data
     * @return $this
     */
    public function withData(array $data = []): self
    {
        $clone = clone $this;
        $clone->data = \array_merge($clone->error, $data);
        return $clone;
    }

    /**
     * Defines a named regular expression pattern.
     *
     * @param string $name
     * @param string $pattern
     * @return $this
     */
    public function pattern(string $name, string $pattern): self
    {
        $name = \strtolower($name);
        $this->patterns[$name] = $pattern;
        return $this;
    }

    /**
     * Adds a rule.
     *
     * @param string|array $rule <p>You can define multiple rules at once as a array or as a string separated by "|".</p>
     * @param string|array $dataKey <p>Defines the keys of the data to which the defined rules will be applied. If you want to add more than one, you can specify it as an array or as a string separated by "|".</p>
     * @return self
     */
    public function rule($rule, $dataKey): self
    {
        if(\is_string($rule)){
            if(\strpos($rule, '|')){
                $rule = \explode('|', $rule);
            }else{
                $rule = [$rule];
            }
        }
        if(!\is_array($rule)){
            throw new \InvalidArgumentException('Rules can be specified as a string or array.');
        }
        $dataKey = $this->prepareData($dataKey);
        $rules = [];
        foreach($rule as $row){
            if($row == 'optional'){
                $this->optional = \array_merge($this->optional, $dataKey);
            }
            $ruleClear = \preg_replace('/\((.*)\)/u', '', $row);
            if(\in_array($ruleClear, $this->rules, true) !== FALSE){
                $rules[] = $row;
            }else{
                $this->userError[] = '"'.$row.'" validation failed because the rule you specified could not be found.';
            }
        }
        $this->rule[] = [
            "rule" => $rules,
            "dataKey" => $dataKey,
        ];

        return $this;
    }

    /**
     * It allows you to write your own validation method with a callable function.
     *
     * @param \Closure $closure
     * @param string|array $dataKey
     * @param string $errorMsg
     * @return $this
     */
    public function ruleClosure(\Closure $closure, $dataKey, string $errorMsg = ''): self
    {
        $this->customRules['closure'][] = [
            'closure'   => $closure,
            'dataKey'    => $this->prepareData($dataKey),
            'errorMsg'  => $errorMsg
        ];
        return $this;
    }

    /**
     * Defines a rule using a predefined function.
     *
     * @param string $function
     * @param string|array $dataKey
     * @param string $errorMsg
     * @return $this
     */
    public function ruleFunction(string $function, $dataKey, string $errorMsg = ''): self
    {
        $this->customRules['function'][] = [
            'function'  => $function,
            'dataKey'    => $this->prepareData($dataKey),
            'errorMsg'  => $errorMsg
        ];
        return $this;
    }

    /**
     * Defines a class or object's method and rule.
     *
     * @param $classOrObject
     * @param string $method
     * @param string|array $dataKey
     * @param string $errorMsg
     * @return $this
     */
    public function ruleMethod($classOrObject, string $method, $dataKey, string $errorMsg = ''): self
    {
        if(!\is_object($classOrObject) && !\class_exists($classOrObject)){
            throw new \InvalidArgumentException('A class or object must be specified.');
        }
        $this->customRules['method'][] = [
            'class'     => $classOrObject,
            'method'    => $method,
            'dataKey'    => $this->prepareData($dataKey),
            'errorMsg'  => $errorMsg
        ];
        return $this;
    }

    /**
     * Validates data within specified rules.
     *
     * @return bool
     */
    public function validation(): bool
    {
        $this->error = [];
        $errors = $this->userError;
        $this->userError = [];
        foreach ($this->rule as $rule) {
            foreach ($rule['rule'] as $rule_row) {
                foreach ($rule['dataKey'] as $data_row) {
                    if(!isset($this->data[$data_row]) && \in_array($data_row, $this->optional, true)){
                        continue;
                    }
                    $this->ruleExecutive($rule_row, $data_row);
                }
            }
        }
        if(!empty($this->customRules)){
            $this->customRulesExecutive();
            $this->customRules = [];
        }
        $this->repeatDataValidation();
        $errors = \array_merge($this->error, $errors);
        if (\count($errors) > 0) {
            $return = false;
        } else {
            $return = true;
        }
        $this->rule = [];
        $this->customRules = [];
        return $return;
    }

    private function repeatDataValidation()
    {
        $repeatSuffixLen = \mb_strlen($this->repeatSuffix);
        foreach($this->data as $key => $value){
            if(\mb_substr($key, -$repeatSuffixLen) === $this->repeatSuffix){
                $origDataKey = \mb_substr($key, 0, -$repeatSuffixLen);
                $origData = $this->data[$origDataKey] ?? null;
                if($this->repeat($origData, $key) === FALSE){
                    $this->error[] = $this->__r($origDataKey, 'repeat', ['field' => $origDataKey, 'field1' => $key, $key]);
                }
            }
        }
    }

    /**
     * Returns the value of a data.
     *
     * @param string $key
     * @return mixed|null
     */
    public function data(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * It adds an external error so that the validation fails.
     *
     * @param string $error
     * @param array $context
     * @return $this
     */
    public function error(string $error, array $context = []): self
    {
        $this->userError[] = $this->interpolate($error, $context);
        return $this;
    }

    /**
     * Returns the errors that occurred as an array. An empty array is returned if there are no errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return \array_merge($this->error, $this->userError);
    }

    public function labels(array $labels): self
    {
        $this->locale['labels'] = \array_merge($this->locale['labels'], $labels);
        return $this;
    }

    private function __r($field, $key, array $context = []): string
    {
        $lang = $this->locale[$field][$key] ?? ($this->locale[$key] ?? $key);
        return $this->interpolate($lang, $context);
    }

    private function interpolate(string $message, array $context = []): string
    {
        $replace = array();
        $i = 0;
        foreach ($context as $key => $val) {
            if (!\is_array($val) && (!\is_object($val) || \method_exists($val, '__toString'))) {
                if((\is_string($val) || \is_int($val) && \substr((string)$key, 0, 5) == 'field')){
                    $val = $this->locale['labels'][$val] ?? $val;
                }
                $replace['{' . $key . '}'] = $val;
                $replace['{' . $i . '}'] = $val;
                $i++;
            }
        }

        return \strtr($message, $replace);
    }

    private function locateLoad()
    {
        return require_once $this->localeFile;
    }

    protected function ruleExecutive(string $rule, string $dataKey): void
    {
        $prepare = $this->prepareArguments($rule, $dataKey);
        $method = $prepare['method'];
        $arguments = $prepare['arguments'];
        if($this->{$method}(...$arguments) === FALSE){
            $field = ['field' => $dataKey];
            $this->error[] = $this->__r($dataKey, $method, \array_merge($field, $arguments));
        }
    }

    protected function customRulesExecutive(): void
    {
        $closureRules = $this->customRules['closure'] ?? [];
        foreach($closureRules as $rule){
            foreach($rule['dataKey'] as $item){
                if(!isset($this->data[$item]) && \in_array($item, $this->optional, true)){
                    continue;
                }
                $data = $this->data[$item] ?? null;
                if(\call_user_func_array($rule['closure'], [$data]) === FALSE){
                    $error = \trim($rule['errorMsg']);
                    $this->error[] = ($error !== '' ? $this->__r($item, $error, ['field' => $item]) : $this->__r($item,'custom_closure', ['field' => $item]));
                }
            }
        }

        $functionRules = $this->customRules['function'] ?? [];
        foreach($functionRules as $rule){
            foreach($rule['dataKey'] as $item){
                if(!isset($this->data[$item]) && \in_array($item, $this->optional, true)){
                    continue;
                }
                $prepare = $this->prepareArguments($rule['function'], $item);
                if(\call_user_func_array($prepare['method'], $prepare['arguments']) === FALSE){
                    $error = \trim($rule['errorMsg']);
                    $this->error[] = ($error !== '' ? $this->__r($item, $error, ['field' => $item]) : $this->__r($item,'custom_function', ['field' => $item]));
                }
            }
        }

        $methodRules = $this->customRules['method'] ?? [];
        foreach($methodRules as $rule){
            $object = $rule['class'];
            if(!\is_object($rule['class'])){
                $object = new $rule['class']();
            }
            foreach($rule['dataKey'] as $item){
                if(!isset($this->data[$item]) && \in_array($item, $this->optional, true)){
                    continue;
                }
                $data = $this->data[$item] ?? null;
                $prepare = $this->prepareArguments($rule['method'], $item);
                if(\call_user_func_array([$object, $prepare['method']], $prepare['arguments']) === FALSE){
                    $error = \trim($rule['errorMsg']);
                    $this->error[] = ($error !== '' ? $this->__r($item, $error, ['field' => $item]) : $this->__r($item,'custom_method', ['field' => $item]));
                }
            }
        }
    }

    private function prepareArguments(string $rule, $dataKey): array
    {
        $arguments = [($this->data[$dataKey] ?? null)];
        \preg_match("/\((.*)\)/u", $rule, $params);
        if(isset($params[0])){
            $method = \preg_replace("/\((.*)\)/u", '', $rule);
            $arguments = \array_merge_recursive($arguments, \explode(',', \trim($params[0], '()')));
        }else{
            $method = $rule;
        }
        return [
            'method'        => $method,
            'arguments'     => $arguments
        ];
    }

    /**
     * @param string|array $dataKey
     */
    protected function prepareData($dataKey): array
    {
        $keys = $dataKey;
        if(\is_string($dataKey)){
            if(\strpos($dataKey, '|')){
                $keys = \explode('|', $dataKey);
            }else{
                $keys = [$dataKey];
            }
        }
        if(!\is_array($keys)){
            throw new \InvalidArgumentException('The keys of the data to be validated must be specified as a string or array.');
        }
        return $keys;
    }

}
