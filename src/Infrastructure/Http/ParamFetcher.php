<?php

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class ParamFetcher
{

    private const TYPE_STRING = 'string';

    private const TYPE_INT = 'int';

    private const TYPE_FLOAT = 'float';

    private const TYPE_DATE = 'date';

    private const TYPE_BOOLEAN = 'boolean';

    private const SCALAR_TYPES = [self::TYPE_STRING, self::TYPE_INT];

    private array $data;
    private bool $testType = false;

    /**
     * @param  array  $data
     * @param  bool  $testType
     */
    public function __construct(array $data, bool $testType)
    {
        $this->data = $data;
        $this->testType = $testType;
    }

    public static function fromRequestBody(Request $request): self
    {
        return new static($request->request->all(), true);
    }

    public static function fromRequestAttributes(Request $request): self
    {
        return new static($request->attributes->all(), true);
    }

    public static function fromRequestQuery(Request $request): self
    {
        return new static($request->query->all(), true);
    }

    public function getRequiredFloat(string $key): float
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_FLOAT);

        return (float)$this->data[$key];
    }

    private function assertRequired(string $key): void
    {
        Assert::keyExists($this->data, $key, sprintf('"%s" not found', $key));
        Assert::notNull($this->data[$key], sprintf('"%s" should be not null', $key));
    }

    private function assertType(string $key, string $type, ?string $format = null): void
    {
        if (!$this->testType && in_array($type, self::SCALAR_TYPES, true)) {
            return;
        }

        switch ($type) {
            case self::TYPE_STRING:
                Assert::string($this->data[$key], sprintf('"%s" should be a string. Got %%s', $key));
                break;

            case self::TYPE_INT:
                Assert::integer($this->data[$key], sprintf('"%s" should be an integer. Got %%s', $key));
                break;

            case self::TYPE_FLOAT:
                Assert::numeric($this->data[$key], sprintf('"%s" should be an float. Got %%s', $key));
                break;

        }
    }

    public function getRequiredBoolean(string $key): bool
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_BOOLEAN);

        return (boolean)$this->data[$key];
    }

    public function getRequiredString(string $key): string
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_STRING);

        return (string)$this->data[$key];
    }

    public function getRequiredNotEmptyEmail(string $key): string{
        $this->getRequiredNotEmptyString($key);
        $this->assertEmail($key);

        return (string)$this->data[$key];
    }


    public function getRequiredNotEmptyString(string $key): string
    {
        $this->assertRequired($key);
        $this->assertNotEmpty($key);
        $this->assertType($key, self::TYPE_STRING);

        return (string)$this->data[$key];
    }

    private function assertNotEmpty(string $key): void
    {
        Assert::keyExists($this->data, $key, sprintf('"%s" not found', $key));
        Assert::notNull($this->data[$key], sprintf('"%s" should be not null', $key));
        Assert::minLength($this->data[$key], 1, sprintf('"%s" minimal length is 1', $key));
    }

    private function assertEmail(string $key): void{
        Assert::email($this->data, $key);
    }

    public function getNullableString(string $key): ?string
    {
        if (!isset($this->data[$key])) {
            return null;
        }
        $this->assertType($key, self::TYPE_STRING);

        return (string)$this->data[$key];
    }

    public function getRequiredInt(string $key): int
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_INT);

        return (int)$this->data[$key];
    }

    public function getRequiredNotEmptyInt(string $key): string
    {
        $this->assertRequired($key);
        $this->assertNotEmpty($key);
        $this->assertType($key, self::TYPE_INT);

        return (string)$this->data[$key];
    }

    public function getNullableInt(string $key): ?int
    {
        if (!isset($this->data[$key])) {
            return null;
        }
        $this->assertType($key, self::TYPE_INT);

        return (int)$this->data[$key];
    }

    public function getRequiredNotEmptyFloat(string $key): ?float
    {
        $this->assertRequired($key);
        $this->assertNotEmpty($key);
        $this->assertType($key, self::TYPE_FLOAT);

        return (float)$this->data[$key];
    }

    public function getNullableFloat(string $key): ?float
    {
        if (!isset($this->data[$key])) {
            return null;
        }
        $this->assertType($key, self::TYPE_FLOAT);

        return (float)$this->data[$key];
    }

    public function getRequiredArray(string $key): array
    {
        $this->assertRequired($key);

        return (array)$this->explodeToArray($key);
    }

    public function getRequiredNotEmptyArray(string $key): array
    {
        $this->assertRequired($key);
        $explodeToArray = $this->explodeToArray($key);
        Assert::minCount($explodeToArray, 1);

        return $explodeToArray;
    }

    public function getNullableArray(string $key): ?array
    {
        if (!isset($this->data[$key]) || $this->data[$key] === []) {
            return null;
        }

        return $this->explodeToArray($key);
    }


    /**
     * @param  string  $key
     * @return false|string[]
     */
    protected function explodeToArray(string $key)
    {
        $data = $this->data[$key];
        if (is_string($data)) {
            $explode = explode(',', $data);
            return $explode && $explode[0] ? $explode : null;
        }

        return $data;
    }

    public function getNullableBoolean(string $key)
    {
        if (!isset($this->data[$key])) {
            return null;
        }
        $this->assertType($key, self::TYPE_BOOLEAN);

        return (boolean)$this->data[$key];
    }

}