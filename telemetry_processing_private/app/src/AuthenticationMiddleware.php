<?php

namespace TelemProc;

class AuthenticationMiddleware
{
    private $doctrine_wrapper;
    private $session_wrapper;
    public function setDoctrineWrapper($doctrine_wrapper){
        $this->doctrine_wrapper = $doctrine_wrapper;

    }
    public function setSessionWrapper($session_wrapper){
        $this->session_wrapper = $session_wrapper;
    }
    public function __invoke($request, $response, $next){
        $is_admin = false;
        $username = $this->session_wrapper->getSessionVar('user');
        if(!empty($username)){
            $is_admin = $this->doctrine_wrapper->checkifAdmin(username);
            $request = $request->withAttributes("isAdmin", $is_admin);
            $response = $response->next($request, $response);
        }
        else{
            $response = $response->withRedirect('loginform');
        }
        return $response;

    }
}