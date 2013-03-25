<?php

namespace ZendeskManager;

interface TicketInterface {
    
    public function convertToJson();
    
    public function getId();
}