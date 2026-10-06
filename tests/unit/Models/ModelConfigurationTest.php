<?php

use App\Models\CustomerModel;
use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class ModelConfigurationTest extends CIUnitTestCase
{
    public function testCustomerModelMetadataMatchesCustomersTable(): void
    {
        $properties = (new \ReflectionClass(CustomerModel::class))->getDefaultProperties();

        $this->assertSame('customers', $properties['table']);
        $this->assertSame('id', $properties['primaryKey']);
        $this->assertTrue($properties['useAutoIncrement']);
        $this->assertSame('array', $properties['returnType']);
        $this->assertTrue($properties['useTimestamps']);
        $this->assertSame('created_at', $properties['createdField']);
        $this->assertSame('', $properties['updatedField']);
        $this->assertSame(
            ['full_name', 'email', 'phone', 'password_hash', 'status'],
            $properties['allowedFields'],
        );
    }

    public function testUserModelMetadataMatchesUsersTable(): void
    {
        $properties = (new \ReflectionClass(UserModel::class))->getDefaultProperties();

        $this->assertSame('users', $properties['table']);
        $this->assertSame('id', $properties['primaryKey']);
        $this->assertTrue($properties['useAutoIncrement']);
        $this->assertSame('array', $properties['returnType']);
        $this->assertTrue($properties['useTimestamps']);
        $this->assertSame('created_at', $properties['createdField']);
        $this->assertSame('', $properties['updatedField']);
        $this->assertSame(
            ['username', 'full_name', 'role', 'password', 'attendance_status', 'is_verified', 'avatar'],
            $properties['allowedFields'],
        );
    }
}
