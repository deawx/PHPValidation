<?php
/**
 * ValidationMethods.php
 *
 * This file is part of PHPValidation.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 PHPValidation
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt  GNU GPL 3.0
 * @version    1.1
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace PHPValidation;

trait ValidationMethods
{

    /**
     * @param $data
     * @return bool
     */
    protected function integer($data): bool
    {
        $pattern = '/^(' . self::INT_PATTERN . ')$/u';
        if(\preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function float($data): bool
    {
        $pattern = '/^(' . self::FLOAT_PATTERN . ')$/u';
        if(\preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function alpha($data): bool
    {
        $pattern = '/^(' . self::ALPHA_PATTERN . ')$/u';
        if(\preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function alphaNum($data): bool
    {
        $pattern = '/^(' . self::ALPHA_NUMERIC_PATTERN . ')$/u';
        if(\preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @param null|string $type
     * @return bool
     */
    protected function creditCard($data, $type = null): bool
    {
        if(\is_string($data)){
            $data = \str_replace(' ', '', $data);
        }
        if($type === null){
            return \preg_match('/^(?:' . \implode('|', self::CREDIT_CARD_PATTERNS) . ')$/', $data) !== FALSE;
        }
        $type = \strtoupper(\trim($type));
        switch($type){
            case 'AMEX':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['amex'] . '$/', $data) !== FALSE;
                break;
            case 'VISA':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['visa'] . '$/', $data) !== FALSE;
                break;
            case 'MASTERCARD':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['mastercard'] . '$/', $data) !== FALSE;
                break;
            case 'MAESTRO':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['maestro'] . '$/', $data) !== FALSE;
                break;
            case 'JCB':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['jcb'] . '$/', $data) !== FALSE;
                break;
            case 'SOLO':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['solo'] . '$/', $data) !== FALSE;
                break;
            case 'SWITCH':
                return \preg_match('/^' . self::CREDIT_CARD_PATTERNS['switch'] . '$/', $data) !== FALSE;
                break;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function numeric($data): bool
    {
        return \is_numeric($data);
    }

    /**
     * @param $data
     * @return bool
     */
    protected function string($data): bool
    {
        return \is_string($data);
    }

    /**
     * @param $data
     * @return bool
     */
    protected function boolean($data): bool
    {
        if($data === TRUE || $data === FALSE){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function array($data): bool
    {
        return \is_array($data);
    }

    /**
     * @param $data
     * @return bool
     */
    protected function mail($data): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_EMAIL) !== FALSE){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @param $domain
     * @return bool
     */
    protected function mailHost($data, $domain): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_EMAIL)){
            $parse = \explode('@', $data);
            $parseDNS = $parse[1] ?? null;
            if($parseDNS === $domain){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function url($data): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_URL)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @param $domain
     * @return bool
     */
    protected function urlHost($data, $domain): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_URL)){
            $host = \parse_url($data, \PHP_URL_HOST);
            if($host === $domain){
                return true;
            }elseif(\mb_substr($host, -(\strlen($domain) + 1)) === '.' . $domain){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function empty($data): bool
    {
        return empty($data);
    }

    /**
     * @param $data
     * @return bool
     */
    protected function required($data): bool
    {
        if((\is_string($data) && \trim($data) != '') || \is_numeric($data) || !empty($data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @param $min
     * @return bool
     */
    protected function min($data, $min): bool
    {
        if(!\is_numeric($data) && (\is_array($data) || \is_string($data))){
            $data = \is_array($data) ? \count($data) : \mb_strlen($data);
        }
        return ($data >= $min);
    }

    /**
     * @param $data
     * @param $max
     * @return bool
     */
    protected function max($data, $max): bool
    {
        if(!\is_numeric($data) && (\is_array($data) || \is_string($data))){
            $data = \is_array($data) ? \count($data) : \mb_strlen($data);
        }
        return ($data <= $max);
    }

    /**
     * @param $data
     * @param $range
     * @return bool
     */
    protected function length($data, $range): bool
    {
        $min = null;
        $max = (\is_numeric($range) && $range > 0) ? $range : null;
        $len = (\is_string($data) || \is_numeric($data)) ? \mb_strlen((string)$data) : \count($data);
        if(\is_string($range)){
            $separator = \strpos($range, '...') ? '...' : '-';
            $parse = \explode($separator, $range, 2);
            $min = $parse[0] ?? null;
            $max = $parse[1] ?? null;
        }
        if(\is_numeric($min) && $len < $min){
            return false;
        }
        if(\is_numeric($max) && $max > 0 && $len > $max){
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @param $pattern
     * @return bool
     */
    protected function regex($data, $pattern): bool
    {
        $pattern = '/^(' . ($this->patterns[\strtolower($pattern)] ?? $pattern) . ')$/u';
        if(\preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function date($data): bool
    {
        $isDate = false;
        if($data instanceof \DateTime){
            $isDate = true;
        }else{
            $isDate = \strtotime($data) !== FALSE;
        }
        return $isDate;
    }

    /**
     * @param $data
     * @param $format
     * @return bool
     */
    protected function dateFormat($data, $format): bool
    {
        $dateFormat = \date_parse_from_format($format, $data);
        if($dateFormat['error_count'] === 0 && $dateFormat['warning_count'] === 0){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function ip($data): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_IP) !== FALSE){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function ipv4($data): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4) !== FALSE){
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function ipv6($data): bool
    {
        if(\filter_var($data, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)){
            return true;
        }
        return false;
    }

    protected function only($data, ...$only): bool
    {
        if(\is_string($data)){
            $data = \mb_strtolower($data);
        }
        foreach($only as $row){
            if(\mb_strtolower($row) === $data){
                return true;
            }
        }
        return false;
    }

    protected function strictOnly($data, ...$only): bool
    {
        foreach($only as $row){
            if($row == $data){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $data
     * @param $repDataId
     * @return bool
     */
    protected function repeat($data, $repDataId): bool
    {
        $repData = $this->data[$repDataId] ?? ($data !== null ? null : '');
        if($repData === $data){
            return true;
        }
        return false;
    }

    protected function equals($data, $eqData): bool
    {
        return $data === $eqData;
    }

    /**
     * @param $data
     * @param $startWith
     * @return bool
     */
    protected function startWith($data, $startWith): bool
    {
        if(\is_array($data)){
            return ($data[0] ?? ($startWith !== null ? null : '')) == $startWith;
        }
        $len = \mb_strlen($startWith);
        return (\mb_substr($data, 0, $len) == $startWith);
    }

    /**
     * @param $data
     * @param $endWith
     * @return bool
     */
    protected function endWith($data, $endWith): bool
    {
        if(\is_array($data)){
            return \end($data) == $endWith;
        }
        $len = \mb_strlen($endWith);
        return (\mb_substr($data, -($len)) == $endWith);
    }

    /**
     * @param $data
     * @param $search
     * @return bool
     */
    protected function in($data, $search): bool
    {
        if(\is_string($data) || \is_numeric($data)){
            return \mb_stripos((string)$data, (string)$search) !== FALSE;
        }
        if(\is_array($data)){
            return \in_array($search, $data, true) !== FALSE;
        }
        return false;
    }

    /**
     * @param $data
     * @param $search
     * @return bool
     */
    protected function notIn($data, $search): bool
    {
        if(\is_string($data) || \is_numeric($data)){
            return \mb_stripos((string)$data, (string)$search) === FALSE;
        }
        if(\is_array($data)){
            return \in_array($search, $data, true) === FALSE;
        }
        return false;
    }

}
