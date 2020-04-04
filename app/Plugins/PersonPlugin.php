<?php

namespace App\Plugins;

class PersonPlugin extends BasePlugin
{
    const YES = 'Yes';
    const NO = 'No';
    const STATUS_ACTIVE = 'Active';
    const STATUS_BANNED = 'Banned';
    const STATUS_DELETED = 'Deleted';
    const STATUS_INACTIVE = 'Inactive';
    const STATUS_PENDING = 'Pending'; // Pending registration


    public static $tablePerson = 'snv_person';
    public static $tablePersonSchema = array(
        array("Id", "STRING", "NOT NULL PRIMARY KEY"),
        array("Status", "STRING"),
        array("FirstName", "STRING"),
        array("LastName", "STRING"),
        array("Gender", "STRING"),
        array("Birthday", "STRING"),
        array("Email", "STRING"),
        array("AdminNotes", "TEXT"),
        array("CreatedAt", "DATETIME"),
        array("UpdatedAt", "DATETIME"),
        array("DeletedAt", "DATETIME"),
    );

    public static function createTables()
    {
        if (self::getTablePerson()->exists() == false) {
            self::getTablePerson()->create(self::$tablePersonSchema);
        }
    }

    public static function getTablePerson()
    {
        return self::getDatabase()->table(self::$tablePerson);
    }

    public static function deletePersonById($id)
    {
        $result = self::getTablePerson()->where('Id', '==', $id)->delete();
        return $result;
    }

    /**
     * @return \Sinevia\SqlDb
     */
    public static function getDatabase()
    {
        return db();
    }

    /**
     * Finds a user by his email
     * @param string $libreid
     * @return \Member|null
     */
    public static function findPersonByEmail($email)
    {
        $person = self::getTablePerson()->where('Email', '==', $email)->selectOne();

        return $person;
    }

    public static function generatePasswordHash($password, $password_salt)
    {
        $hash = sha1($password_salt . $password . $password_salt);
        return $hash;
    }

    /**
     * Creates a new user
     * @param array $user
     * @return array the user data array or null if failed
     * @throws RuntimeException
     */
    public static function createPerson($data)
    {
        if (isset($data['Id']) == false) {
            $data['Id'] = \Sinevia\UidUtils::microUid();
        }
        if (isset($data['CreatedAt']) == false) {
            $data['CreatedAt'] = date('Y-m-d H:i:s');
        }
        if (isset($data['UpdatedAt']) == false) {
            $data['UpdatedAt'] = date('Y-m-d H:i:s');
        }
        if (is_array($data) == false) {
            throw new \RuntimeException('Calling createPerson with non-Array parameter');
        }
        $result = self::getTablePerson()->insert($data);
        if ($result !== false) {
            return self::findPersonById($data['Id']);
        }
        return null;
    }
    /**
     * Finds a user by his Member ID
     * @param string $libreid
     * @return array|null
     */
    public static function findPersonById($id)
    {
        if (is_string($id) == false || is_numeric($id) == false) {
            throw new \RuntimeException('Non-string or non-numeric parameter');
        }

        $person = self::getTablePerson()
            ->where('Id', '==', $id)
            ->selectOne();

        return $person;
    }

    /**
     * Updates a person
     * @param Member $user
     * @return boolean
     * @throws RuntimeException
     */
    public static function updateUserById($id, $data)
    {
        if (isset($data['UpdatedAt']) == false) {
            $data['UpdatedAt'] = date('Y-m-d H:i:s');
        }
        $result = self::getTablePerson()
            ->where('Id', '==', $id)
            ->update($data);
        return $result;
    }
}