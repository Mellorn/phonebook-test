<?php

declare(strict_types=1);

namespace App\Services\PhoneBook;

use App\Contracts\Services\PhoneBook\PhoneBookService as ServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Contact;
use App\Models\Phone;
use App\DataTransfer\ContactDTO;
use App\DataTransfer\PhoneDTO;

final class PhoneBookService implements ServiceContract
{
    /**
     * Get contacts list.
     *
     * @param  int|null  $page
     *
     * @return LengthAwarePaginator
     */
    public function contactsList(?int $page = null): LengthAwarePaginator
    {
        return Contact::orderBy('name')->paginate(page: $page);
    }

    /**
     * Create a new contact.
     *
     * @param  ContactDTO  $data
     *
     * @return Contact
     */
    public function createContact(ContactDTO $data): Contact
    {
        return Contact::resolveConnection()->transaction(function () use ($data) {
            $contact = Contact::create(['name' => $data->name]);
            $contact->phones()->create(['number' => $data->phone->number]);

            return $this->loadPhones($contact);
        });
    }

    /**
     * Load phones for contact.
     *
     * @param  Contact  $contact
     *
     * @return Contact
     */
    public function loadPhones(Contact $contact): Contact
    {
        return $contact->load([
            'phones' => static fn ($query) => $query->orderBy('id'),
        ]);
    }

    /**
     * Update contact.
     *
     * @param  Contact  $contact
     * @param  ContactDTO  $data
     *
     * @return Contact
     */
    public function updateContact(Contact $contact, ContactDTO $data): Contact
    {
        $contact->fill([
            'name' => $data->name
        ])
            ->save();

        return $contact;
    }

    /**
     * Delete contact.
     *
     * @param  Contact  $contact
     *
     * @return void
     */
    public function deleteContact(Contact $contact): void
    {
        $contact->delete();
    }

    /**
     * Add a new number to a contact.
     *
     * @param  Contact  $contact
     * @param  PhoneDTO  $data
     *
     * @return Phone
     */
    public function addPhone(Contact $contact, PhoneDTO $data): Phone
    {
        return $contact->phones()->create(['number' => $data->number]);
    }

    /**
     * Update phone.
     *
     * @param  Phone  $phone
     * @param  PhoneDTO  $data
     *
     * @return Phone
     */
    public function updatePhone(Phone $phone, PhoneDTO $data): Phone
    {
        $phone->fill([
            'number' => $data->number,
        ])
            ->save();

        return $phone;
    }

    /**
     * Delete phone.
     *
     * @param  Phone  $phone
     *
     * @return void
     */
    public function deletePhone(Phone $phone): void
    {
        $phone->delete();
    }
}
