<?php
namespace Application\Service;

use Zend\Authentication\Storage\Session as SessionStorage;

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

    private $ses;
    private $user;
    public function __construct($authService, $urlHelper) 
    {

        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->ses = new SessionStorage();
        $this->user = $this->ses->read();
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

        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {

            if($this->user->getRoleId() == 1){
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

            }
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


