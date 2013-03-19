<?php
class Application_Repository_Contact extends Ozkan_Mapper
{
	private static $TABLE = "contacts"; 
	public function getAll()
	{
		$contacts = array();
		$ps = $this->db->prepare('select * from '.Application_Repository_Contact::$TABLE);
		$ps->execute();
		$ps->bind_result($id, $name, $email, $phoneNumber, $postalAddress, $jobTitle, $corporation, $note);
		
		while($ps->fetch())
		{
			$contact = new Application_Model_Contact();
			$contact->setId($id);
			$contact->setName($name);
			$contact->setCorporation($corporation);
			$contact->setEmail($email);
			$contact->setPhoneNumber($phoneNumber);
			$contact->setPostalAddress($postalAddress);
			$contact->setJobTitle($jobTitle);
			$contact->setNote($note);
			$contacts[] = $contact;
		}
		return $contacts;
	}
	
	public function insertOrUpdate(Application_Model_Contact $contact)
	{
		if($contact->getId() == 0)
		{
			return $this->add($contact);
		}
		else
		{
			return $this->update($contact);
		}
	}
	
	public function add(Application_Model_Contact $contact)
	{
		$ps = $this->db->prepare('insert into '.Application_Repository_Contact::$TABLE.' 
		(`name`, `email`, `phone_number`,`postal_address`,`job_title`,`corporation`, `note`)
			values (?,?,?,?,?,?,?)');
		$ps->bind_param('sssssss', $contact->getName(), $contact->getEmail(), $contact->getPhoneNumber(),
			$contact->getPostalAddress(), $contact->getJobTitle(), $contact->getCorporation(), $contact->getNote());
		$ps->execute();
		$contact->setId($this->db->insert_id);
		echo $this->db->error;
		$ps->close();
		if($contact->getId() == 0){
				return false;
			}
			return true;
	}
	
	public function update(Application_Model_Contact $contact)
	{
		$contact2 = $this->get($contact->getId());
		if($contact2 == null) return false;
		$contact2 = null; //temizlik
		$ps = $this->db->prepare('update '.Application_Repository_Contact::$TABLE.' set 
		`name`=?,`email`=?,`phone_number`=?,`postal_address`=?,`job_title`=?,`corporation`=?,`note`=? where `id`=? ');
		$ps->bind_param('sssssssi', $contact->getName(), $contact->getEmail(), 
		$contact->getPhoneNumber(), $contact->getPostalAddress(), $contact->getJobTitle(), $contact->getCorporation(), 
		$contact->getNote(), $contact->getId());
		$ps->execute();
		return true;
	}
	
	public function get($id)
	{
		$ps = $this->db->prepare('select * from '.Application_Repository_Contact::$TABLE.' where `id`=?');
		$ps->bind_param('i', $id);
		$ps->execute();
		$ps->bind_result($idx, $name, $email, $phoneNumber, $postalAddress, $jobTitle, $corporation, $note);
		$contact = null;
		if($ps->fetch())
		{
			$contact = new Application_Model_Contact();
			$contact->setId($idx);
			$contact->setName($name);
			$contact->setCorporation($corporation);
			$contact->setEmail($email);
			$contact->setPhoneNumber($phoneNumber);
			$contact->setPostalAddress($postalAddress);
			$contact->setJobTitle($jobTitle);
			$contact->setNote($note);
		}
		$ps->close();
		return $contact;
	}
	
	public function find($key)
	{
		$contacts = array();
		$ps = $this->db->prepare('select * from '.Application_Repository_Contact::$TABLE.'
		 where `name` like ? or`email` like ? or `phone_number` like ? or`postal_address` like ? or
		 `job_title` like ? or `corporation`like ? or `note` like ?');
		echo $this->db->error;
		$key = '%'.$key.'%';
		$ps->bind_param('sssssss', $key, $key, $key, $key, $key, $key, $key);
		$ps->execute();
		$ps->bind_result($id, $name, $email, $phoneNumber, $postalAddress, $jobTitle, $corporation, $note);
		
		while($ps->fetch())
		{
			$contact = new Application_Model_Contact();
			$contact->setId($id);
			$contact->setName($name);
			$contact->setCorporation($corporation);
			$contact->setEmail($email);
			$contact->setPhoneNumber($phoneNumber);
			$contact->setPostalAddress($postalAddress);
			$contact->setJobTitle($jobTitle);
			$contact->setNote($note);
			$contacts[] = $contact;
		}
		return $contacts;
	}
	
	public function delete($id)
	{
		$ps = $this->db->prepare('delete from '.Application_Repository_Contact::$TABLE.' where `id`=?');
		$ps->bind_param('i', $id);
		$ps->execute();
		$ps->close();
	}
}