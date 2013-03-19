<?php 
class Application_Model_Contact extends  Ozkan_Model
{
	private $id;
	private $name;
	private $email;
	private $phoneNumber;
	private $postalAddress;
	private $jobTitle;
	private $corporation;
	private $note;
	/**
	 * @return the $note
	 */
	public function getNote() {
		return $this->note;
	}

	/**
	 * @param field_type $note
	 */
	public function setNote($note) {
		$this->note = $note;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $phoneNumber
	 */
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}

	/**
	 * @return the $postalAddress
	 */
	public function getPostalAddress() {
		return $this->postalAddress;
	}

	/**
	 * @return the $jobTitle
	 */
	public function getJobTitle() {
		return $this->jobTitle;
	}

	/**
	 * @return the $corporation
	 */
	public function getCorporation() {
		return $this->corporation;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param field_type $phoneNumber
	 */
	public function setPhoneNumber($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}

	/**
	 * @param field_type $postalAddress
	 */
	public function setPostalAddress($postalAddress) {
		$this->postalAddress = $postalAddress;
	}

	/**
	 * @param field_type $jobTitle
	 */
	public function setJobTitle($jobTitle) {
		$this->jobTitle = $jobTitle;
	}

	/**
	 * @param field_type $corporation
	 */
	public function setCorporation($corporation) {
		$this->corporation = $corporation;
	}

	
}