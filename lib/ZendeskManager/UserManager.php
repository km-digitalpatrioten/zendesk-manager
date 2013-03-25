<?php

namespace ZendeskManager;

class UserManager extends ZendeskManager implements UserManagerInterface
{
    const USER_LIST = '/api/v2/users.json';

    public function getUsers()
    {
        $this->browser->get($this->url . self::USER_LIST);
        $usersData = $this->getResponse()->users;
        $users = array_map(function($value){
			return new User($value);
		}, $usersData);

        return $users;
    }

}