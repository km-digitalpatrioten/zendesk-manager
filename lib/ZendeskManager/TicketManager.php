<?php

namespace ZendeskManager;

class TicketManager extends ZendeskManager implements TicketManagerInterface {

    const TICKET_AUDIT = '/api/v2/tickets/%id%/audits.json';

    const TICKET_LIST = '/api/v2/tickets.json';

    const TICKET_CREATE = '/api/v2/tickets.json';

    const TICKET_WEB_URL = '/agent/#/tickets/%id%';

    public function generateWebUrlForTicket(TicketInterface $ticket) {
        return $this->url . str_replace('%id%', $ticket->getId(), self::TICKET_WEB_URL);
    }

    /**
     * @param int $page
     * @return array
     */
    public function getTickets($page = 1) {
        $this->browser->get($this->url . self::TICKET_LIST . '?page=' . $page);
        $response = $this->getResponse();
        $ticketsData = $response->tickets;
        $tickets = array_map(function ($value) {
            return new Ticket($value);
        }, $ticketsData);

        return array(
            'tickets' => $tickets,
            'nextPage' => (!empty($response->next_page))
        );
    }

    public function getTicketAudit(\ZendeskManager\Ticket $ticket, $page = 1) {
        $this->browser->get($this->url . str_replace('%id%', $ticket->getId(), self::TICKET_AUDIT) . '?page=' . $page);
        $response = $this->getResponse();
        $auditData = $response->audits;

        return array(
            'audits' => $auditData,
            'nextPage' => (!empty($response->next_page))
        );
    }

    public function getUserTickets(\ZendeskManager\User $user) {
        $this->browser->get($this->url . str_replace('%id%', $user->getId(), UserManager::USER_TICKETS));
        $ticketsData = $this->getResponse()->tickets;
        $tickets = array_map(function ($value) {
            return new Ticket($value);
        }, $ticketsData);

        return $tickets;
    }

    public function createTicket(TicketInterface $ticket) {
        $this->browser->post(
            $this->url . self::TICKET_CREATE, array('Content-Type: application/json'), $ticket->convertToJson()
        );

        return new Ticket($this->getResponse()->ticket);
    }
}