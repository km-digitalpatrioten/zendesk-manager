<?php

namespace ZendeskManager;

interface UserManagerInterface {

    /**
     * @param int $page
     * @return mixed
     */
    public function getUsers($page = 1);

}