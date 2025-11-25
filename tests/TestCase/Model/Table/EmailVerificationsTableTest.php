<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailVerificationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailVerificationsTable Test Case
 */
class EmailVerificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailVerificationsTable
     */
    protected $EmailVerifications;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.EmailVerifications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmailVerifications') ? [] : ['className' => EmailVerificationsTable::class];
        $this->EmailVerifications = $this->getTableLocator()->get('EmailVerifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EmailVerifications);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EmailVerificationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
