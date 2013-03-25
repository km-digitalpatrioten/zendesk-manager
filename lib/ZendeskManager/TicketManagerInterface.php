<?php

namespace ZendeskManager;

interface TicketManagerInterface {
    
    public function createTicket(TicketInterface $ticket);
    
    public function getTickets();
}