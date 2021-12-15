<?php 
/**
 * PHPValidationInterface.php
 *
 * This file is part of PHPValidation.
 *
 * @package    PHPValidationInterface.php @ 2021-10-28T20:06:13.735Z
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2021 PHPValidation
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt  GNU GPL 3.0
 * @version    1.0.7
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace PHPValidation;

interface PHPValidationInterface 
{

    public function set(array $data = []): PHPValidationInterface;

    public function addSet($key, $value): PHPValidationInterface;

    public function pattern(string $name, string $pattern): PHPValidationInterface;

    public function mail($mail, $domain = ""): bool;

    public function is_mail($mail): bool;

    public function url($url, $domain = ""): bool;

    public function is_url($url): bool;

    public function is_string($data): bool;

    public function is_str($data): bool;

    public function string($data, $lengthRange = null): bool;

    public function is_numeric($data): bool;

    public function is_int($data): bool;

    public function is_integer($data): bool;

    public function integer($data, $range = null): bool;

    public function is_resource($data): bool;

    public function is_float($data): bool;

    public function is_real($data): bool;

    public function is_double($data): bool;

    public function is_object($data): bool;

    public function is_class($data, $class_name): bool;

    public function is_array($data): bool;

    public function is_null($data): bool;

    public function is_empty($data): bool;

    public function is_bool($data): bool;

    public function ip(string $ip): bool;

    public function ipv4(string $ip): bool;

    public function ipv6(string $ip): bool;

    public function minLength(string $value, int $min_length): bool;

    public function maxLength(string $value, int $max_length): bool;

    public function min(int $value, int $min): bool;

    public function max(string $value, int $max): bool;

    public function regex($value, $pattern): bool;

    public function date(string $value): bool;

    public function dateFormat(string $value, string $format): bool;

    public function required($data): bool;

    public function rule($rule, $dataId): self;

    public function ruleExecutive(string $rule, string $dataKey): void;

    public function validation(): bool;

    public function errors();

    public function error_method(): string;

    public function __rSet(string $key, string $value): void;

}
