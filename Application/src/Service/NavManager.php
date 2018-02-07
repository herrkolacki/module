<?php
namespace Application\Service;

use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Http\Request;
use User\Entity\User;
use User\Service\UserManager;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * Constructs the service.
     */

    private $entityManager;


    private $user;
    public function __construct($authService, $urlHelper, $entityManager)
    {

        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->entityManager = $entityManager;
       $request = new Request();
        $request->getHeaders()->addHeaders(['authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJleHAiOjE1MTM0MTkxMDQsImRhdGEiOnsidXNlcklkIjoiNiIsInJvbGUiOiIxIiwicGFzcyI6Ik1vamUxMjM0In19.YVAaNfMMZsaGA6uh9V3FvjaGMIOfSU8jfBL65VXG92Xi2uYa3zMaRRdAoQe61KTEooGRsCuIVc0I-sI1xRui9A']);
        $cos = $request->getHeader('authorization');

        if($cos){
            $cosValue = $cos->getFieldValue();
            $userManager = new UserManager($this->entityManager);
            $userToken = $userManager->decodeToken($cosValue);
            if(!$userToken){
                $this->user = $this->entityManager->getRepository(User::class)
                                                  ->find(1);

            }

            $this->user = $this->entityManager->getRepository(User::class)
                                              ->find($userToken->data->userId);
        }
        //var_dump($request->getHeaders());// pobiera wszystkie headery...
    }
    
    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;

        $items = [];
        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link'  => $url('home')
        ];
        
        $items[] = [
            'id' => 'add',
            'label' => 'Add',
            'link'  => 'users/add'
        ];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.

      //  if (!$this->authService->hasIdentity()) {
        if(!$this->user){
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {

          /*  if($this->user->getRoleId() == 1){
                $items[] = [
                    'id' => 'admin',
                    'label' => 'Admin',
                    'dropdown' => [
                        [
                            'id' => 'users',
                            'label' => 'Manage Users',
                            'link' => $url('users')
                        ]
                    ]
                ];

            }*/
            $items[] = [
                'id' => 'changePassword',
                'label' => 'zmien pass',
                'link'  => $url('change-password')
            ];
            $items[] = [
                'id' => 'about',
                'label' => 'About',
                'link'  => $url('about')
            ];


           $items[] = [
                'id' => 'product',
                'label' => 'Produkty',
                'link' => $url('products'),
                'float' => 'right',
            ];

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',

            ];
            $items[] = [
                'id' => 'logout',
                'label' => 'Sign out',
                'link' => $url('logout'),
                'float' => 'right',
            ];
        }

        return $items;
    }
}


