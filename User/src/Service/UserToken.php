<?php
namespace User\Service;

use User\Entity\User;
use User\Entity\Password;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
use Zend\Config\Factory;
use Firebase\JWT\JWT;
use User\Service\UserManager;
use Zend\Http\Request;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserToken
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



    public function getHeaderAuth($cos){
        if($cos){
            $request = new Request();

            $userManager = new UserManager($this->entityManager);
            $cosValue = $cos->getFieldValue();
            $userToken = $this->decodeToken($cosValue);
            if(!$userToken){
                $id = 1;
            }else{

                $id = $userToken->data->userId;
            }
            //var_dump($userToken); die();
            $user = $this->entityManager->getRepository(User::class)->findOneById($id);
            $tokenTrue = $this->checkToken();
            if($tokenTrue){
                $token = $userManager->generateToken($user);
                $request->getHeaders()->addHeaders(['User-JWT' => $token]);
            }else{
                $user = false;
            }
            return $user;
        }else{
            return false;
        }
    }

    public function checkToken(){

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
        }catch(\Exception $s){
            return false;
        }

        return $token;

    }







}

