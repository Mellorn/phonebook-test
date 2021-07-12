<?php

declare(strict_types=1);

namespace App\Contracts\Services\PhoneBook;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Contact;
use App\Models\Phone;
use App\DataTransfer\ContactDTO;
use App\DataTransfer\PhoneDTO;

interface PhoneBookService
{
    /**
     * Get contacts list.
     *
     * @param  int|null  $page
     *
     * @return LengthAwarePaginator
     */
    public function contactsList(?int $page = null): LengthAwarePaginator;

    /**
     * Create a new contact.
     *
     * @param  ContactDTO  $data
     *
     * @return Contact
     */
    public function createContact(ContactDTO $data): Contact;

    /**
     * Load phones for contact.
     *
     * @param  Contact  $contact
     *
     * @return Contact
     */
    public function loadPhones(Contact $contact): Contact;

    /**
     * Update contact.
     *
     * @param  Contact  $contact
     * @param  ContactDTO  $data
     *
     * @return Contact
     */
    public function updateContact(Contact $contact, ContactDTO $data): Contact;

    /**
     * Delete contact.
     *
     * @param  Contact  $contact
     *
     * @return void
     */
    public function deleteContact(Contact $contact): void;

    /**
     * Add a new number to a contact.
     *
     * @param  Contact  $contact
     * @param  PhoneDTO  $data
     *
     * @return Phone
     */
    public function addPhone(Contact $contact, PhoneDTO $data): Phone;

    /**
     * Update phone.
     *
     * @param  Phone  $phone
     * @param  PhoneDTO  $data
     *
     * @return Phone
     */
    public function updatePhone(Phone $phone, PhoneDTO $data): Phone;

    /**
     * Delete phone.
     *
     * @param  Phone  $phone
     *
     * @return void
     */
    public function deletePhone(Phone $phone): void;
}
