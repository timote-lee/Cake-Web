<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmailVerificationsFixture
 */
class EmailVerificationsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ipsum d',
                'used' => '2025-11-25 06:46:46',
                'created' => '2025-11-25 06:46:46',
                'modified' => '2025-11-25 06:46:46',
            ],
        ];
        parent::init();
    }
}
