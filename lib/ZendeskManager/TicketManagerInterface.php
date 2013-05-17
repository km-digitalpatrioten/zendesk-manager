<?php

namespace ZendeskManager;

interface TicketManagerInterface {

    public function createTicket(TicketInterface $ticket);

    /**
     * @param int $page
     * @return mixed
     */
    public function getTickets($page = 1);
}