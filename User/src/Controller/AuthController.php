<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use User\Form\LoginForm;
use User\Entity\User;
use Zend\Http\Request;
use Zend\Authentication\Storage\Session as SessionStorage;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Auth manager.
     * @var User\Service\AuthManager 
     */
    private $authManager;
    
    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    
    /**
     * User manager.
     * @var User\Service\UserManager
     */
    private $userManager;
    
    /**
     * Constructor.
     */
    public function __construct($entityManager, $authManager, $authService, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
        $this->userManager = $userManager;

    }
    
    /**
     * Authenticates user given email address and password credentials.     
     */
    public function loginAction()
    {
        // Retrieve the redirect URL (if passed). We will redirect the user to this
        // URL after successfull login.
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }

        // Check if we do not have users in database at all. If so, create
        // the 'Admin' user.
        $this->userManager->createAdminUserIfNotExists();
        
        // Create login form
        $form = new LoginForm(); 
        $form->get('redirect_url')->setValue($redirectUrl);

        // Store login status.
        $isLoginError = false;
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Perform login attempt.
                $result = $this->authManager->login($data['phone'],
                        $data['password'], $data['remember_me']);


                // Check result.
                if ($result->getCode() == Result::SUCCESS) {
                    /** potrzebne dane usera zeby zrobic tokena */
                    $user = $this->entityManager->getRepository(User::class)
                                                ->findOneByPhone($data['phone']);

                    if($user->getTokenExpire() <= date('Y-m-d H:i:s')){
                        $this->userManager->generateToken($user);
                    }

                   $this->userManager->decodeToken($user->getToken());
                    $this->ses = new SessionStorage();
                    $this->ses->write($user);

                    $request = new Request();
                    $request->setMethod(Request::METHOD_GET);
                    $request->getHeaders()->addHeaders(['auth' => $user->getToken()]);
                    $request->getHeaders()->addHeaders(['WWW-Authenticate' => 'Negotiate']);
                    header('Authorization: Basic '.$user->getToken());
                  //  $request->setPost($request->getHeaders()->addHeaders(['auth' => $user->getToken()]));

                    // Get redirect URL.
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');


                    if (!empty($redirectUrl)) {
                        // The below check is to prevent possible redirect attack 
                        // (if someone tries to redirect user to another domain).
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || $uri->getHost()!=null)
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                    }

                    // If redirect URL is provided, redirect the user to that URL;
                    // otherwise redirect to Home page.
                    if(empty($redirectUrl)) {
                        return  $this->redirect()->toUrl('/products?'.$user->getToken());
                            //$this->redirect()->toRoute('home');
                    } else {
                        $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    $isLoginError = true;
                }                
            } else {
                $isLoginError = true;
            }           
        } 
        
        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);
    }
    
    /**
     * The "logout" action performs logout operation.
     */
    public function logoutAction() 
    {        
        $this->authManager->logout();
        $this->ses = new SessionStorage();
        $this->ses->clear();
        return $this->redirect()->toRoute('login');
    }
}
