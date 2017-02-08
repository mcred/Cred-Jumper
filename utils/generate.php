<?php
namespace GeneratorUtil;

/**
 *
 */
class Generator
{
    private $namespace;
    private $className;
    private $includeTest;
    private $srcDir;
    private $testDir;

    public function __construct(string $namespace, string $className, bool $includeTest)
    {
        $this->namespace = $namespace;
        $this->className = $className;
        $this->properClassName = ucfirst($this->className);
        $this->includeTest = $includeTest;
        $this->srcDir = 'src/';
        $this->testDir = 'tests/unit/';

        $this->checkNamespace();
        $this->checkClassName();
        $this->checkIncludeTest();
    }

    private function checkNamespace() : void
    {
        if (!$this->namespace) {
            throw new InvalidArgumentException('Namespace is required.');
        }
    }

    private function checkClassName() : void
    {
        if (!$this->className) {
            throw new InvalidArgumentException('ClassName is required.');
        }
    }

    private function checkIncludeTest() : void
    {
        if (!$this->includeTest) {
            throw new InvalidArgumentException('IncludeTest is required.');
        }
    }

    private function createClassFromTemplate() : string
    {
        return "<?php
namespace $this->namespace;

/**
 * The $this->properClassName Objects and Methods
 *
 * @author     Derek Smart <derek@grindaga.com>
 */
class $this->properClassName
{
    public function __construct()
    {
    }
}";
    }

    private function createTestFromTemplate() : string
    {
        return "<?php
namespace $this->namespace;

/**
* @covers \\$this->namespace\\$this->properClassName
*/
class {$this->properClassName}Test extends \PHPUnit\Framework\TestCase
{
}";
    }

    private function writeClassFile() : void
    {
        file_put_contents($this->srcDir.$this->properClassName.'.php', $this->createClassFromTemplate());
    }

    private function writeTestFile() : void
    {
        file_put_contents($this->testDir.$this->properClassName.'Test.php', $this->createTestFromTemplate());
    }

    public function generate() : void
    {
        $this->writeClassFile();
        if ($this->includeTest) {
            $this->writeTestFile();
        }
    }
}

$generator = new Generator($argv[1], $argv[2], $argv[3]);
$generator->generate();
