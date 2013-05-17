<?php

namespace ZendeskManager;

class UserManager extends ZendeskManager implements UserManagerInterface {

    const USER_LIST = '/api/v2/users.json';

    const USER_SEARCH = '/api/v2/users/search.json?query=%query%';

    const USER_TICKETS = '/api/v2/users/%id%/tickets/requested.json';

    /**
     * @param int $page
     * @return array|mixed
     */
    public function getUsers($page = 1) {
        $this->browser->get($this->url . self::USER_LIST . '?page='. $page);
        $response = $this->getResponse();
        $usersData = $response->users;
        $users = array_map(function ($value) {
            return new User($value);
        }, $usersData);

        return array(
            'users' => $users,
            'nextPage' => (!empty($response->next_page))
        );
    }

    public function searchUsers($query) {
        $this->browser->get($this->url . str_replace('%query%', $query, self::USER_SEARCH));
        $usersData = $this->getResponse()->users;
        $users = array_map(function ($value) {
            return new User($value);
        }, $usersData);

        return $users;
    }
}