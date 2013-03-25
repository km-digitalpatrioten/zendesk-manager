<?php

namespace ZendeskManager;

class Ticket implements TicketInterface {
	
	protected $id;
	protected $url;
	protected $externalId;
	protected $type;
	protected $subject;
	protected $description;
	protected $priority;
	protected $status;
	protected $recipient;
	protected $requesterId;
	protected $submitterId;
	protected $assigneeId;
	protected $organizationId;
	protected $groupId;
	protected $collaboratorIds = array();
	protected $forumTopicId;
	protected $problemId;
	protected $hasIncidents;
	protected $dueAt;
	protected $tags = array();
	protected $via;
	protected $customFields = array();
	protected $satisfactionRating;
	protected $sharingAgreementIds = array();
	protected $followupIds = array();
	protected $ticketFormId;
	protected $createdAt;
	protected $updatedAt;
    
    protected static $writableProperties = array(
        'externalId',
        'type',
        'subject',
        'description',
        'priority',
        'status',
        'dueAt',
        'tags',
    );
    
    protected static $dateTimeProperties = array(
        'createdAt',
        'updatedAt',
        'dueAt'
    );
    
    public static function camelize($id)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $id);
    }
    
    public static function underscore($id)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), strtr($id, '_', '.')));
    }
    
    public function __construct($data = array())
    {
        foreach($data as $property => $value) {
            $property = self::camelize($property);
            if ($value && in_array($property, self::$dateTimeProperties)) {
                $value = new \DateTime($value, new \DateTimeZone('UTC'));
            }
            
			$methodName = 'set'.$property;
			if (method_exists($this, $methodName)) 
			{ 
				call_user_func(array($this, $methodName), $value); 
			}
        }
    }
    
    public function convertToJson() {
        $parameters = new \stdClass;
        $parameters->ticket = new \stdClass;
        
        foreach (self::$writableProperties as $property) {
            if (isset($this->$property)) {
                if ($this->$property instanceof \DateTime) {
                    $dateTime = new \DateTime($this->$property->format('Y-m-d'), new \DateTimeZone('UTC'));
                    $value = $dateTime->format('c');
                } else {
                    $value = $this->$property;
                }

                $property = self::underscore($property);

                $parameters->ticket->$property = $value;
            }
        }
        
        return json_encode($parameters);
    }
    
	public function getId() 
	{
		return $this->id;
	}

	public function setId($id) 
	{
		$this->id = $id;
		
		return $this;
	}

	public function getUrl() 
	{
		return $this->url;
	}

	public function setUrl($url) 
	{
		$this->url = $url;
		
		return $this;
	}

	public function getExternalId() 
	{
		return $this->externalId;
	}

	public function setExternalId($externalId) 
	{
		$this->externalId = $externalId;
		
		return $this;
	}

	public function getType() 
	{
		return $this->type;
	}

	public function setType($type) 
	{
		$this->type = $type;
		
		return $this;
	}

	public function getSubject() 
	{
		return $this->subject;
	}

	public function setSubject($subject) 
	{
		$this->subject = $subject;
		
		return $this;
	}

	public function getDescription() 
	{
		return $this->description;
	}

	public function setDescription($description) 
	{
		$this->description = $description;
		
		return $this;
	}

	public function getPriority() 
	{
		return $this->priority;
	}

	public function setPriority($priority) 
	{
		$this->priority = $priority;
		
		return $this;
	}

	public function getStatus() 
	{
		return $this->status;
	}

	public function setStatus($status) 
	{
		$this->status = $status;
		
		return $this;
	}

	public function getRecipient() 
	{
		return $this->recipient;
	}

	public function setRecipient($recipient) 
	{
		$this->recipient = $recipient;
		
		return $this;
	}

	public function getRequesterId() 
	{
		return $this->requesterId;
	}

	public function setRequesterId($requesterId) 
	{
		$this->requesterId = $requesterId;
		
		return $this;
	}

	public function getSubmitterId() 
	{
		return $this->submitterId;
	}

	public function setSubmitterId($submitterId) 
	{
		$this->submitterId = $submitterId;
		
		return $this;
	}

	public function getAssigneeId() 
	{
		return $this->assigneeId;
	}

	public function setAssigneeId($assigneeId) 
	{
		$this->assigneeId = $assigneeId;
		
		return $this;
	}

	public function getOrganizationId() 
	{
		return $this->organizationId;
	}

	public function setOrganizationId($organizationId) 
	{
		$this->organizationId = $organizationId;
		
		return $this;
	}

	public function getGroupId() 
	{
		return $this->groupId;
	}

	public function setGroupId($groupId) 
	{
		$this->groupId = $groupId;
		
		return $this;
	}

	public function getCollaboratorIds() 
	{
		return $this->collaboratorIds;
	}

	public function setCollaboratorIds($collaboratorIds) 
	{
		$this->collaboratorIds = $collaboratorIds;
		
		return $this;
	}

	public function getForumTopicId() 
	{
		return $this->forumTopicId;
	}

	public function setForumTopicId($forumTopicId) 
	{
		$this->forumTopicId = $forumTopicId;
		
		return $this;
	}

	public function getProblemId() 
	{
		return $this->problemId;
	}

	public function setProblemId($problemId) 
	{
		$this->problemId = $problemId;
		
		return $this;
	}

	public function getHasIncidents() 
	{
		return $this->hasIncidents;
	}

	public function setHasIncidents($hasIncidents) 
	{
		$this->hasIncidents = $hasIncidents;
		
		return $this;
	}

	public function getDueAt() 
	{
		return $this->dueAt;
	}

	public function setDueAt($dueAt) 
	{
		$this->dueAt = $dueAt;
		
		return $this;
	}

	public function getTags() 
	{
		return $this->tags;
	}

	public function setTags($tags) 
	{
		$this->tags = $tags;
		
		return $this;
	}

	public function getVia() 
	{
		return $this->via;
	}

	public function setVia($via) 
	{
		$this->via = $via;
		
		return $this;
	}

	public function getCustomFields() 
	{
		return $this->customFields;
	}

	public function setCustomFields($customFields) 
	{
		$this->customFields = $customFields;
		
		return $this;
	}

	public function getSatisfactionRating() 
	{
		return $this->satisfactionRating;
	}

	public function setSatisfactionRating($satisfactionRating) 
	{
		$this->satisfactionRating = $satisfactionRating;
		
		return $this;
	}

	public function getSharingAgreementIds() 
	{
		return $this->sharingAgreementIds;
	}

	public function setSharingAgreementIds($sharingAgreementIds) 
	{
		$this->sharingAgreementIds = $sharingAgreementIds;
		
		return $this;
	}

	public function getFollowupIds() 
	{
		return $this->followupIds;
	}

	public function setFollowupIds($followupIds) 
	{
		$this->followupIds = $followupIds;
		
		return $this;
	}

	public function getTicketFormId() 
	{
		return $this->ticketFormId;
	}

	public function setTicketFormId($ticketFormId) 
	{
		$this->ticketFormId = $ticketFormId;
		
		return $this;
	}

	public function getCreatedAt() 
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt) 
	{
		$this->createdAt = $createdAt;
		
		return $this;
	}

	public function getUpdatedAt() 
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt($updatedAt) 
	{
		$this->updatedAt = $updatedAt;
		
		return $this;
	}

}