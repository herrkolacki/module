<?php
namespace User\Service;

use User\Entity\User;
use User\Entity\Password;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
use Zend\Config\Factory;
use Firebase\JWT\JWT;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method adds a new user.
     */
    public function addUser($data)
    {
        // Do not allow several users with the same email address.
        if($this->checkUserExists($data['email'])) {
            throw new \Exception("User with email address " . $data['$email'] . " already exists");
        }

        if(!isset($data['role_id'])){
            $data['role_id'] = (int)1;
        }
        if(!isset($data['active'])){
            $data['active'] = (int)0;
        }
        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setPhone($data['phone']);
        $user->setActive($data['active']);

        // Encrypt password and store the password in encrypted state.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->setPassword($passwordHash);


        $user->setRoleId($data['role_id']);
        $currentDate = date('Y-m-d H:i:s');
        $user->setCreated($currentDate);

        // Add the entity to the entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();

        return $user;
    }

    /**
     * This method updates data of an existing user.
     */
    public function updateUser($user, $data)
    {
        // Do not allow to change user email if another user with such email already exits.
        if($user->getEmail()!=$data['email'] && $this->checkUserExists($data['email'])) {
            throw new \Exception("Another user with email address " . $data['email'] . " already exists");
        }
        if($user->getPhone()!=$data['phone'] && $this->checkUserExists($data['phone'])) {
            throw new \Exception("Another user with phone " . $data['phone'] . " already exists");
        }
        if($user->getUsername()!=$data['username'] && $this->checkUserExists($data['username'])) {
            throw new \Exception("Another user with phone " . $data['username'] . " already exists");
        }

        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setRoleId($data['role_id']);
        $user->setPhone($data['phone']);


        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }

    /**
     * This method checks if at least one user presents, and if not, creates
     * 'Admin' user with email 'admin@example.com' and password 'Secur1ty'.
     */
    public function createAdminUserIfNotExists()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);

        if ($user==null) {
            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setUsername('Admin');
            $bcrypt = new Bcrypt();
            $passwordHash = $bcrypt->create('Moje1234');
            $user->setPassword($passwordHash);
            //$user->setStatus(User::STATUS_ACTIVE);
            $user->setCreated(date('Y-m-d H:i:s'));
            $user->setActive((int)1);
            $user->setRoleId((int)5);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    /**
     * Checks whether an active user with given email address already exists in the database.
     */
    public function checkUserExists($email) {

        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);

        return $user !== null;
    }

    /**
     * Checks that the given password is correct.
     */
    public function validatePassword($user, $password)
    {
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }

        return false;
    }

    /**
     * Generates token for user jwt
     */
    public function generateToken($user)
    {
        $config = Factory::fromFile('config/autoload/local.php', true);

        $tokenId = base64_decode(random_bytes(32)); // token id ali nie dziala dobrze jeszcze

        //now + 1 month();
        $expire = time()+(6*60*60*24*30);

        $data = [
          //  'jti' => $tokenId, //jak wyzek
            'exp' => $expire,
            'data' => [
                'userId' =>(string) $user->getId(),
                'role' => (string)$user->getRoleId(),
                'pass' => 'Moje1234',

            ]
        ];
        // sekret key from configs
        $secretKey =  base64_decode($config->get('jwt')->get('key'));
        $jwt = JWT::encode($data,$secretKey,'HS512');
        $user->setToken($jwt);

        $tokenExpired =  date("Y-m-d H:i:s", $expire) ;
        $user->setTokenExpire($tokenExpired);
        // Apply changes to database.
        $this->entityManager->flush();
        return $jwt;
    }

    /**
     * decode JWT token
     * @param String $jwt
     * @return array
     */
    public function decodeToken(String $jwt)
    {
        if(!$jwt) {
            return false;
        }
        $config = Factory::fromFile('config/autoload/local.php', true);
        //now + 1 month();

        try{
            $secretKey = base64_decode($config->get('jwt')->get('key'));
            $token = JWT::decode($jwt, $secretKey, ['HS512']);
        }catch(\Exception $e){
           return false;
        }
        return $token;

    }

    /**
     * Generates a password reset token for the user. This token is then stored in database and
     * sent to the user's E-mail address. When the user clicks the link in E-mail message, he is
     * directed to the Set Password page.
     */
    public function generatePasswordResetToken($user)
    {
        // Generate a token.
        $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
        $user->setPasswordResetToken($token);

        $currentDate = date('Y-m-d H:i:s');
        $user->setPasswordResetTokenCreationDate($currentDate);

        $this->entityManager->flush();

        $subject = 'Password Reset';

        $httpHost = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
        $passwordResetUrl = 'http://' . $httpHost . '/set-password?token=' . $token;

        $body = 'Please follow the link below to reset your password:\n';
        $body .= "$passwordResetUrl\n";
        $body .= "If you haven't asked to reset your password, please ignore this message.\n";

        // Send email to user.
        mail($user->getEmail(), $subject, $body);
    }

    /**
     * Checks whether the given password reset token is a valid one.
     */
    public function validatePasswordResetToken($passwordResetToken)
    {
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByPasswordResetToken($passwordResetToken);

        if($user==null) {
            return false;
        }

        $tokenCreationDate = $user->getPasswordResetTokenCreationDate();
        $tokenCreationDate = strtotime($tokenCreationDate);

        $currentDate = strtotime('now');

        if ($currentDate - $tokenCreationDate > 24*60*60) {
            return false; // expired
        }

        return true;
    }

    /**
     * This method sets new password by password reset token.
     */
    public function setNewPasswordByToken($passwordResetToken, $newPassword)
    {
        if (!$this->validatePasswordResetToken($passwordResetToken)) {
           return false;
        }

        $user = $this->entityManager->getRepository(User::class)
                ->findOneByPasswordResetToken($passwordResetToken);

        if ($user==null) {
            return false;
        }

        // Set new password for user        
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Remove password reset token
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreationDate(null);

        $this->entityManager->flush();

        return true;
    }

    /**
     * This method is used to change the password for the given user. To change the password,
     * one must know the old password.
     */
    public function changePassword($user, $data)
    {
        $oldPassword = $data['old_password'];

        // Check that old password is correct
        if (!$this->validatePassword($user, $oldPassword)) {
            return false;
        }

        $newPassword = $data['new_password'];

        if(!$this->checkAndSavePassword($newPassword, $user['id'])){
            return false;
        }

        // Check password length
        if (strlen($newPassword)<6 || strlen($newPassword)>64) {
            return false;
        }

        // Set new password for user        
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Apply changes
        $this->entityManager->flush();

        return true;
    }

    /** check password, if user had the same early  return false else save new pass
     * @param $password
     * @param $user_id
     * @return bool
     */
    private function checkAndSavePassword($password, $user_id)
    {
        $bcrypt = new Bcrypt();
        $passwords = $this->entityManager->getRepository(Password::class)
                                            ->findByUserId($user_id);
        foreach($passwords as $pass){
            if($bcrypt->verify($pass, $password)) {
                return false;
            }
        }
        $pass = new Password();
        $pass->setUserId($user_id);
        $pass->setPassword($password);
        $pass->setCreated(date('Y-m-d H:i:s'));
        return true;
    }
}

