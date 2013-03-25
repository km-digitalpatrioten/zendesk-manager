<?php

namespace ZendeskManager;

class User implements UserInterface {
    
    protected $id;
    protected $url;
    protected $name;
    protected $externalId;
    protected $alias;
    protected $createdAt;
    protected $updatedAt;
    protected $active;
    protected $verified;
    protected $shared;
    protected $localeId;
    protected $timeZone;
    protected $lastLoginAt;
    protected $email;
    protected $phone;
    protected $signature;
    protected $details;
    protected $notes;
    protected $organizationId;
    protected $role;
    protected $customRoleId;
    protected $moderator;
    protected $ticketRestriction;
    protected $onlyPrivateComments;
	protected $tags = array();
	protected $suspended;
	protected $photo;
    
    protected static $writableProperties = array(
        'name',
        'externalId',
        'alias',
        'verified',
        'localeId',
        'timeZone',
        'email',
        'phone',
		'signature',
		'details',
		'notes',
		'organizationId',
		'role',
		'customRoleId',
		'moderator',
		'ticketRestriction',
		'onlyPrivateComments',
		'tags',
		'suspended',
		'photo',
    );
    
    protected static $dateTimeProperties = array(
        'createdAt',
        'updatedAt',
        'lastLoginAt'
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
	
	public function getName()
	{
		return $this->name;
	}

	public function setName($name) 
	{
		$this->name = $name;
		
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

	public function getAlias() 
	{
		return $this->alias;
	}

	public function setAlias($alias) 
	{
		$this->alias = $alias;
		
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

	public function getActive() 
	{
		return $this->active;
	}

	public function setActive($active) 
	{
		$this->active = $active;
		
		return $this;
	}

	public function getVerified() 
	{
		return $this->verified;
	}

	public function setVerified($verified) 
	{
		$this->verified = $verified;
		
		return $this;
	}

	public function getShared() 
	{
		return $this->shared;
	}

	public function setShared($shared) 
	{
		$this->shared = $shared;
		
		return $this;
	}

	public function getLocaleId() 
	{
		return $this->localeId;
	}

	public function setLocaleId($localeId) 
	{
		$this->localeId = $localeId;
		
		return $this;
	}

	public function getTimeZone() 
	{
		return $this->timeZone;
	}

	public function setTimeZone($timeZone) 
	{
		$this->timeZone = $timeZone;
		
		return $this;
	}

	public function getLastLoginAt() 
	{
		return $this->lastLoginAt;
	}

	public function setLastLoginAt($lastLoginAt) 
	{
		$this->lastLoginAt = $lastLoginAt;
		
		return $this;
	}

	public function getEmail() 
	{
		return $this->email;
	}

	public function setEmail($email) 
	{
		$this->email = $email;
		
		return $this;
	}

	public function getPhone() 
	{
		return $this->phone;
	}

	public function setPhone($phone) 
	{
		$this->phone = $phone;
		
		return $this;
	}

	public function getSignature() 
	{
		return $this->signature;
	}

	public function setSignature($signature) 
	{
		$this->signature = $signature;
		
		return $this;
	}

	public function getDetails() 
	{
		return $this->details;
	}

	public function setDetails($details) 
	{
		$this->details = $details;
		
		return $this;
	}

	public function getNotes() 
	{
		return $this->notes;
	}

	public function setNotes($notes) 
	{
		$this->notes = $notes;
		
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

	public function getRole() 
	{
		return $this->role;
	}

	public function setRole($role) 
	{
		$this->role = $role;
		
		return $this;
	}

	public function getCustomRoleId() 
	{
		return $this->customRoleId;
	}

	public function setCustomRoleId($customRoleId) 
	{
		$this->customRoleId = $customRoleId;
		
		return $this;
	}

	public function getModerator() 
	{
		return $this->moderator;
	}

	public function setModerator($moderator) 
	{
		$this->moderator = $moderator;
		
		return $this;
	}

	public function getTicketRestriction() 
	{
		return $this->ticketRestriction;
	}

	public function setTicketRestriction($ticketRestriction) 
	{
		$this->ticketRestriction = $ticketRestriction;
		
		return $this;
	}

	public function getOnlyPrivateComments() 
	{
		return $this->onlyPrivateComments;
	}

	public function setOnlyPrivateComments($onlyPrivateComments) 
	{
		$this->onlyPrivateComments = $onlyPrivateComments;
		
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
	
	public function addTags($tag) 
	{
		$this->tags[] = $tag;
		
		return $this;
	}

	public function getSuspended() 
	{
		return $this->suspended;
	}

	public function setSuspended($suspended) 
	{
		$this->suspended = $suspended;
		
		return $this;
	}

	public function getPhoto() 
	{
		return $this->photo;
	}

	public function setPhoto($photo) 
	{
		$this->photo = $photo;
		
		return $this;
	}
}